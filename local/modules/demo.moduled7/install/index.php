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

		if(!Main\Application::getConnection(\Demo\Moduled7\Moduled7Table::getConnectionName())->isTableExists(
            Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->getDBTableName()
        )
        ) {
            Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->createDbTable();
        }
        //RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CDemoModuled', 'OnBuildGlobalMenu');
        RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", self::MODULE_ID, "CDemoModuled", "beforeUpdateElementID");
        RegisterModuleDependences('main', 'OnCheckListGet', self::MODULE_ID, 'CDemoModuled', 'onCheckTable');
        return true;
	}

	function UnInstallDB($arParams = array())
	{
        Main\Loader::includeModule($this -> MODULE_ID);
        Main\Application::getConnection(\Demo\Moduled7\Moduled7Table::getConnectionName())->query('drop table if exists '.Main\Entity\Base::getInstance('\Demo\Moduled7\Moduled7Table')->getDBTableName());

		//UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CDemoModuled', 'OnBuildGlobalMenu');
        UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", self::MODULE_ID, "CDemoModuled", "beforeUpdateElementID");
        UnRegisterModuleDependences('main', 'OnCheckListGet', self::MODULE_ID, 'CDemoModuled', 'onCheckTable');
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
