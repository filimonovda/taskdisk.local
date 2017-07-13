<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;

$arParams["MainFolder"]=521;

$RoomCount=Folder::getList(array("filter"=>array("=PARENT_ID"=>$arParams["MainFolder"])));
while ($row = $RoomCount->fetch()){
    $RoomCountID[]=$row["ID"];
    $arResult['SelectRoomCountList'][$row["NAME"]][$row["PARENT_ID"]][]=$row["ID"];

    echo "<pre>";
    //print_r(Folder::getList(array("filter"=>array("=PARENT_ID"=>$row["ID"])))->fetchAll());
    echo "</pre>";
}

$TypeHouse=Folder::getList(array("filter"=>array("=PARENT_ID"=>$RoomCountID)));
while ($row = $TypeHouse->fetch()){
    $TypeHouseID[]=$row["ID"];
    $arResult['SelectTypeHouseList'][$row["NAME"]][$row["PARENT_ID"]][]=$row["ID"];

    echo "<pre>";
//    print_r($row);
    echo "</pre>";
}

$AreaSize=Folder::getList(array("filter"=>array("=PARENT_ID"=>$TypeHouseID)));
while ($row = $AreaSize->fetch()){
    $AreaSizeID[]=$row["ID"];
    $arResult['SelectAreaSizeList'][$row["NAME"]][]=$row["ID"];

    echo "<pre>";
//    print_r($row);
    echo "</pre>";
}

//$RoomCountID[]=Folder::getList(array("select"=>array("ID"),"filter"=>array("=PARENT_ID"=>$arParams["MainFolder"])))->fetch();



echo "<pre>";
print_r($arResult);
echo "</pre>";
$this->IncludeComponentTemplate($componentPage);
?>