<?
IncludeModuleLangFile(__FILE__);
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
		/*global $DB;
		$DB->Query("
			CREATE TABLE `demo_moduled7` (
				`ID` int NOT NULL AUTO_INCREMENT,
				`ID_USER` varchar(255) NOT NULL,
				`TITLE` varchar(255) NOT NULL,
				PRIMARY KEY(`ID`)
			);
		", true);*/
        if(!Application::getConnection(\Simbirsoft\Main\Entity\CrmDealHistoryRieltorTable::getConnectionName())->isTableExists(
            Base::getInstance('\Simbirsoft\Main\Entity\CrmDealHistoryRieltorTable')->getDBTableName()
        )
        ) {
            Base::getInstance('\Simbirsoft\Main\Entity\CrmDealHistoryRieltorTable')->createDbTable();
        }

		RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CDemoModuled', 'OnBuildGlobalMenu');
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB;
		$DB->Query("DROP TABLE `demo_moduled7`;", true);
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CDemoModuled', 'OnBuildGlobalMenu');
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
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
