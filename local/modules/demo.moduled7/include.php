<?

use Bitrix\Highloadblock\HighloadBlockTable as HBT;

Class CDemoModuled 
{
	function beforeUpdateElementID(&$arFields)
	{
        define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
        AddMessage2Log($arFields);

		Demo\Moduled7\Moduled7Table::add(
			array(
				"fields" => array(
		        	"ID_USER" => $arFields["CREATED_BY"],
					"TITLE" => $arFields["NAME"]
				)
			)
		);
	}

	function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
	{
		if($GLOBALS['APPLICATION']->GetGroupRight("main") < "R")
			return;

		$MODULE_ID = basename(dirname(__FILE__));
		$aMenu = array(
			"parent_menu" => "global_menu_settings",
			"section" => $MODULE_ID,
			"sort" => 50,
			"text" => $MODULE_ID,
			"title" => '',
			"icon" => "",
			"page_icon" => "",
			"items_id" => $MODULE_ID."_items",
			"more_url" => array(),
			"items" => array()
		);

		if (file_exists($path = dirname(__FILE__).'/admin'))
		{
			if ($dir = opendir($path))
			{
				$arFiles = array();

				while(false !== $item = readdir($dir))
				{
					if (in_array($item,array('.','..','menu.php')))
						continue;

					if (!file_exists($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$MODULE_ID.'_'.$item))
						file_put_contents($file,'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.$MODULE_ID.'/admin/'.$item.'");?'.'>');

					$arFiles[] = $item;
				}

				sort($arFiles);

				foreach($arFiles as $item)
					$aMenu['items'][] = array(
						'text' => $item,
						'url' => $MODULE_ID.'_'.$item,
						'module_id' => $MODULE_ID,
						"title" => "",
					);
			}
		}
		$aModuleMenu[] = $aMenu;
	}

    static public function onCheckTable($arCheckList)
    {
        $checkList = array('CATEGORIES' => array(), 'POINTS' => array());

        $checkList['CATEGORIES']['DEMO_QA'] = array(
            'NAME' => 'Первый тест',
            'LINKS' => ''
        );

        $checkList['POINTS']['DEMO_QA_TABLE'] = array(
            'PARENT' => 'DEMO_QA',
            'REQUIRE' => 'Y',
            'AUTO' => 'Y',
            'CLASS_NAME' => __CLASS__,
            'METHOD_NAME' => 'checkTable',
            'NAME' => 'Проверяем наличие таблицы',
            'DESC' => 'Краткое описание',
            'HOWTO' => 'Много текста',
            'LINKS' => 'links'
        );

        $checkList['POINTS']['DEMO_QA_MAN'] = array(
            'PARENT' => 'DEMO_QA',
            'REQUIRE' => 'N',
            'AUTO' => 'N',
            'NAME' => 'Ручной тест',
            'DESC' => 'Описание ручного теста',
            'HOWTO' => 'Много текста',
        );

        return $checkList;
    }

    static public function checkTable($arParams)
    {
        Bitrix\Main\Loader::includeModule('demo.moduled7');

        $arResult = array('STATUS' => 'F');

        if(!Bitrix\Main\Application::getConnection(\Demo\Moduled7\Moduled7Table::getConnectionName())->isTableExists(
            Bitrix\Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->getDBTableName()
        )){
            $arResult = array(
                'STATUS' => false,
                'MESSAGE' => array(
                    'PREVIEW' => 'Таблица не найдена',
                    'DETAIL' => 'Может забыли создать? ;(',
                ),
            );
        }else{
            $arResult = array(
                'STATUS' => true,
                'MESSAGE' => array(
                    'PREVIEW' => 'Бинго! Табличка на месте!',
                ),
            );
		}
		return $arResult;
    }

    function AdminTabColor(&$form)
    {
		if($GLOBALS["APPLICATION"]->GetCurPage() == "/bitrix/admin/iblock_element_edit.php")
        {
            \Bitrix\Main\Loader::includeSharewareModule("demo.moduled7");
            $SelectValue = Demo\Moduled7\Moduled7Table::GetList(
                array(
                    'select' => array('COLOR_ID'),
                    'filter' => array(
						'IBLOCK_ID' => $_REQUEST['IBLOCK_ID'],
						'ELEMENT_ID' => $_REQUEST['ID']
                    ),
                )
            )->fetch()['COLOR_ID'];

            Bitrix\Main\Loader::includeModule("highloadblock");

			$TABLE_ID = HBT::getList(array('select' => array('ID'),"filter" => array('TABLE_NAME' => 'demo_hl_color')))->fetch()['ID'];
            $hlblock = HBT::getById($TABLE_ID)->fetch();
            $entity = HBT::compileEntity($hlblock);
            $entityClass = $entity->getDataClass();

            $res = $entityClass::getList(array());

            while ($ElementColor = $res->fetch())
            {
                ($ElementColor['ID']==$SelectValue) ? $checked=' selected' : $checked='';
                $Variant .= '<option value="'.$ElementColor['ID'].'"'.$checked.'>'.$ElementColor['UF_VALUE'].'</option>';
            }

            $form->tabs[] = array("DIV" => "tab_color", "TAB" => "Цвет", "ICON"=>"main_user_edit", "TITLE"=>"Выбор цвета HL", "CONTENT"=>
                '<tr valign="top">
				<td>Выберите цвет из HL блока:</td>
				<td>
					<select name="HLCOLOR_SELECT">'.
                $Variant
					.'</select>
				</td>
			</tr>'
            );
        }
    }

    function AddOrUpdateTable(){
        define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
        AddMessage2Log($_REQUEST);
        if ($_REQUEST['ID']>0 && $_REQUEST['HLCOLOR_SELECT']>0)
        {
        	Bitrix\Main\Loader::includeSharewareModule("demo.moduled7");

            if($UpdateElement = Demo\Moduled7\Moduled7Table::getList(array("filter" => array('IBLOCK_ID' => $_REQUEST['IBLOCK_ID'], 'ELEMENT_ID' => $_REQUEST['ID'])))->fetch()) {
                Demo\Moduled7\Moduled7Table::update($UpdateElement['ID'], array('COLOR_ID' => $_REQUEST['HLCOLOR_SELECT']));
            }else{
                Demo\Moduled7\Moduled7Table::add(array('IBLOCK_ID' => $_REQUEST['IBLOCK_ID'], 'ELEMENT_ID' => $_REQUEST['ID'], 'COLOR_ID' => $_REQUEST['HLCOLOR_SELECT']));
            }

        }
	}

	function GetUserTypeDescription(){
        return array(
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "MyArray",
            "DESCRIPTION" => "Произвольный массив",
            "ConvertToDB" =>array("CDemoModuled","ConvertToDB"),
            "ConvertFromDB" =>array("CDemoModuled","ConvertFromDB"),
            "GetPropertyFieldHtml" =>array("CDemoModuled","GetPropertyFieldHtml"),
            "GetAdminListViewHTML" =>array("CDemoModuled","GetAdminListViewHTML"),
        );
	}

	function ConvertToDB($arProperty, $value){
		return $value;
	}

	function ConvertFromDB($arProperty, $value){
		return $value;
	}

	function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName){
        return  CAdminCalendar::CalendarDate($strHTMLControlName["VALUE"], $value["VALUE"], 20).
            ($arProperty["WITH_DESCRIPTION"]=="Y"?
                '&nbsp;<input type="text" size="20" name="'.$strHTMLControlName["DESCRIPTION"].'" value="'.htmlspecialchars($value["DESCRIPTION"]).'">'
                :''
            );
	}

	function GetAdminListViewHTML(){

	}
}
?>

