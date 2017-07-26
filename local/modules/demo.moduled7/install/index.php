<?
IncludeModuleLangFile(__FILE__);
use Bitrix\Main;

Class demo_moduled7 extends CModule
{
	const MODULE_ID = 'demo.moduled7';
	var $MODULE_ID = 'demo.moduled7'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';



//include $_SERVER['DOCUMENT_ROOT'] . "/local/modules/" . $MODULE_ID . "/lib/moduled7.php";

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("demo.moduled7_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("demo.moduled7_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("demo.moduled7_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("demo.moduled7_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
        Main\Loader::includeModule($this -> MODULE_ID);
        Main\Loader::includeModule("highloadblock");

        Bitrix\Highloadblock\HighloadBlockTable::add(array(
            'NAME' => 'Color',
            'TABLE_NAME' => 'demo_hl_color',
        ));

        $NewHL_ID=Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => 'demo_hl_color')))->fetch()['ID'];

        $oUserTypeEntity = new CUserTypeEntity();
        $aUserFields = array(
            'ENTITY_ID'         => 'HLBLOCK_'.$NewHL_ID,
            'FIELD_NAME'        => 'UF_VALUE',
            'USER_TYPE_ID'      => 'string',
        );
        $oUserTypeEntity->Add( $aUserFields );

		if(!Main\Application::getConnection(\Demo\Moduled7\Moduled7Table::getConnectionName())->isTableExists(
            Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->getDBTableName()
        )
        ) {
            Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->createDbTable();
        }

        RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", self::MODULE_ID, "CDemoModuled", "beforeUpdateElementID");
        RegisterModuleDependences('main', 'OnCheckListGet', self::MODULE_ID, 'CDemoModuled', 'onCheckTable');
        RegisterModuleDependences("main", "OnAdminTabControlBegin", self::MODULE_ID, 'CDemoModuled', "AdminTabColor");
        RegisterModuleDependences("main", "OnBeforeProlog", self::MODULE_ID, 'CDemoModuled', "AddOrUpdateTable");
        RegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', self::MODULE_ID, 'CDemoModuled', 'GetUserTypeDescription');

        return true;
	}

	function UnInstallDB($arParams = array())
	{
        Main\Loader::includeModule($this -> MODULE_ID);
        Main\Loader::includeModule("highloadblock");

        Main\Application::getConnection(\Demo\Moduled7\Moduled7Table::getConnectionName())->query('drop table if exists '.Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->getDBTableName());

		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", self::MODULE_ID, "CDemoModuled", "beforeUpdateElementID");
        UnRegisterModuleDependences('main', 'OnCheckListGet', self::MODULE_ID, 'CDemoModuled', 'onCheckTable');
        UnRegisterModuleDependences("main", "OnAdminTabControlBegin", self::MODULE_ID, 'CDemoModuled', "AdminTabColor");
        UnRegisterModuleDependences("main", "OnBeforeProlog", self::MODULE_ID, 'CDemoModuled', "AddOrUpdateTable");
        UnRegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', self::MODULE_ID, 'CDemoModuled', 'GetUserTypeDescription');

        Bitrix\Highloadblock\HighloadBlockTable::delete(
            Bitrix\Highloadblock\HighloadBlockTable::getList(array(
                "filter"=>array(
                    'NAME' => 'Color',
                    'TABLE_NAME' => 'demo_hl_color',
                )
            ))->fetch()["ID"]
        );

        return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item,
					'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.self::MODULE_ID.'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function UnInstallFiles()
	{
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.')
						continue;
					unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components'))
		{
			if ($dir = opendir($p))
			{
				while (false !== $item = readdir($dir))
				{
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0))
					{
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
        RegisterModule(self::MODULE_ID);
		$this->InstallFiles();
        $this->InstallDB();
	}

	function DoUninstall()
	{
		global $APPLICATION;
		$this->UnInstallDB();
		$this->UnInstallFiles();
        UnRegisterModule(self::MODULE_ID);
	}
}
?>
