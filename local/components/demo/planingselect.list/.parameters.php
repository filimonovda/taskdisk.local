<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$Folders=Folder::getList(array("filter"=>array("=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $Folders->fetch()){
    $arFolderList[$row["ID"]]=$row["NAME"];
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
    $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
}

$arComponentParameters = array(
    "GROUPS" => array(
        "PARAMS" => array(
            "NAME" => Loc::getMessage("PARAMS"),
            "SORT" => "100"
        ),
    ),

    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::GetMessage("IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ),

        "IBLOCK_ID" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::GetMessage("IBLOCK_IBLOCK"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
        ),

        "PropertyID" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => Loc::GetMessage("IBLOCK_PROPERTY"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "REFRESH" => "Y",
            "VALUES" => $arProperty,
        ),

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