<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$Folders=Folder::getList(array("filter"=>array("=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $Folders->fetch()){
    $arFolderList[$row["ID"]]=$row["NAME"];
}

$arComponentParameters = array(
    "GROUPS" => array(
        "PARAMS" => array(
            "NAME" => Loc::getMessage("PARAMS"),
            "SORT" => "100"
        ),
    ),

    "PARAMETERS" => array(
        "MainFolder" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::getMessage("MainFolder"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "VALUES" => $arFolderList,
            "REFRESH" => "N",
        ),
    ),
);

?>