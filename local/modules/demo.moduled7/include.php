<?
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
}
?>
