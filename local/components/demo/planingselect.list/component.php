<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;
use Bitrix\Main\FileTable;

if($_POST){
    $el = new CIBlockElement;
    foreach($_POST['file'] as $elFile){
        $arPropFile[]=CFile::MakeFileArray($elFile);
    }
    $PROP[$arParams['PropertyID']]=$arPropFile;
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"      => $arParams['IBLOCK_ID'],
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_POST['name'],
        "ACTIVE"         => "Y",
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        echo "Создан элемент: ".$PRODUCT_ID;
    else
        echo "Ошибка: ".$el->LAST_ERROR;
}

$RoomCount=Folder::getList(array("filter"=>array("=PARENT_ID"=>$arParams["MainFolder"], "=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $RoomCount->fetch()){
    $RoomCountID[]=$row["ID"];
    $arResult['SelectRoomCountList'][$row["ID"]]=$row["NAME"];
    $arResult['SelectRoomCountList']=array_unique($arResult['SelectRoomCountList']);
}

$TypeHouse=Folder::getList(array("filter"=>array("=PARENT_ID"=>$RoomCountID, "=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $TypeHouse->fetch()){
    $TypeHouseID[]=$row["ID"];
    $arResult['SelectTypeHouseList'][$row["ID"]]=$row["NAME"];
    $arResult['SelectTypeHouseList']=array_unique($arResult['SelectTypeHouseList']);
}

$AreaSize=Folder::getList(array("filter"=>array("=PARENT_ID"=>$TypeHouseID, "=TYPE"=>2, "=DELETED_TYPE"=>0)));
while ($row = $AreaSize->fetch()){
    $AreaSizeID[] = $row["ID"];
    $arResult['SelectAreaSizeList'][$row["ID"]] = $row["NAME"];
    $arResult['SelectAreaSizeList'] = array_unique($arResult['SelectAreaSizeList']);

    $VariantPlans=Folder::getList(array("filter"=>array("=PARENT_ID"=>$row["ID"], "=TYPE"=>3, "=DELETED_TYPE"=>0)));
    while ($rowPlans = $VariantPlans->fetch()){
        $arFile=FileTable::getById($rowPlans["FILE_ID"])->fetch();
        $elTypeHouse=Folder::getList(array("select"=>array("ID","PARENT_ID","NAME"), "filter"=>array("=ID"=>$row["PARENT_ID"], "=TYPE"=>2, "=DELETED_TYPE"=>0),"limit"=>1))->fetch();
        $elRoomCount=Folder::getList(array("select"=>array("ID","PARENT_ID","NAME"), "filter"=>array("=ID"=>$elTypeHouse["PARENT_ID"], "=TYPE"=>2, "=DELETED_TYPE"=>0),"limit"=>1))->fetch();
        $SmilePicURL="/upload/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];//FileTable::getById($rowPlans["FILE_ID"])->fetch(), Array("width" => 150, "height" => 300);
        $arResult['SelectVariantPlansList'][]=array("ID"=>$rowPlans["FILE_ID"], "NAME"=>$rowPlans["NAME"], "RoomCount"=>$elRoomCount["NAME"], "TypeHouse"=>$elTypeHouse["NAME"], "AreaSize"=>$row["NAME"], "SmilePicURL"=>$SmilePicURL);
    }
}
$this->IncludeComponentTemplate($componentPage);
?>