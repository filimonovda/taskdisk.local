<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;
/*

if(!CModule::IncludeModule("iblock"))
    return;

if($arCurrentValues["IBLOCK_ID"] > 0)
{
    $arIBlock = CIBlock::GetArrayByID($arCurrentValues["IBLOCK_ID"]);

    $bWorkflowIncluded = ($arIBlock["WORKFLOW"] == "Y") && CModule::IncludeModule("workflow");
    $bBizproc = ($arIBlock["BIZPROC"] == "Y") && CModule::IncludeModule("bizproc");
}
else
{
    $bWorkflowIncluded = CModule::IncludeModule("workflow");
    $bBizproc = false;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
    $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arProperty_LNSF = array(
    "NAME" => GetMessage("IBLOCK_ADD_NAME"),
    "TAGS" => GetMessage("IBLOCK_ADD_TAGS"),
    "DATE_ACTIVE_FROM" => GetMessage("IBLOCK_ADD_ACTIVE_FROM"),
    "DATE_ACTIVE_TO" => GetMessage("IBLOCK_ADD_ACTIVE_TO"),
    "IBLOCK_SECTION" => GetMessage("IBLOCK_ADD_IBLOCK_SECTION"),
    "PREVIEW_TEXT" => GetMessage("IBLOCK_ADD_PREVIEW_TEXT"),
    "PREVIEW_PICTURE" => GetMessage("IBLOCK_ADD_PREVIEW_PICTURE"),
    "DETAIL_TEXT" => GetMessage("IBLOCK_ADD_DETAIL_TEXT"),
    "DETAIL_PICTURE" => GetMessage("IBLOCK_ADD_DETAIL_PICTURE"),
);
$arVirtualProperties = $arProperty_LNSF;

$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "F")))
    {
        $arProperty_LNSF[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$arGroups = array();
$rsGroups = CGroup::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"));
while ($arGroup = $rsGroups->Fetch())
{
    $arGroups[$arGroup["ID"]] = $arGroup["NAME"];
}

if ($bWorkflowIncluded)
{
    $rsWFStatus = CWorkflowStatus::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"), $is_filtered);
    $arWFStatus = array();
    while ($arWFS = $rsWFStatus->Fetch())
    {
        $arWFStatus[$arWFS["ID"]] = $arWFS["TITLE"];
    }
}
else
{
    $arActive = array("ANY" => GetMessage("IBLOCK_STATUS_ANY"), "INACTIVE" => GetMessage("IBLOCK_STATUS_INCATIVE"));
    $arActiveNew = array("N" => GetMessage("IBLOCK_ALLOW_N"), "NEW" => GetMessage("IBLOCK_ACTIVE_NEW_NEW"), "ANY" => GetMessage("IBLOCK_ACTIVE_NEW_ANY"));
}

$arAllowEdit = array("CREATED_BY" => GetMessage("IBLOCK_CREATED_BY"), "PROPERTY_ID" => GetMessage("IBLOCK_PROPERTY_ID"));
*/

$Folders=Folder::getList(array("filter"=>array("=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $Folders->fetch()){
    $arFolderList[$row["ID"]]=$row["NAME"];
}

$arComponentParameters = array(
    "GROUPS" => array(
        "PARAMS" => array(
            "NAME" => GetMessage("PARAMS"),
            "SORT" => "100"
        ),
    ),

    "PARAMETERS" => array(
        "MainFolder" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("MainFolder"),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "N",
            "VALUES" => $arFolderList,
            "REFRESH" => "N",
        ),
    ),
);


/*    $arComponentParameters["PARAMETERS"]["ELEMENT_ASSOC_PROPERTY"] = array(
        "PARENT" => "ACCESS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_ASSOC_PROPERTY"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => $arProperty,
        "ADDITIONAL_VALUES" => "Y",
    );*/
?>