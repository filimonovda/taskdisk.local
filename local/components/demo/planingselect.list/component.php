<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Disk\Folder;

if($_POST){
    $el = new CIBlockElement;
    if(count($_FILES['filepc']['tmp_name'])>0){
        foreach($_FILES['filepc']['tmp_name'] as $postFile){
            $arPropFile[]=CFile::MakeFileArray($postFile);
        }
    }
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
$this->IncludeComponentTemplate($componentPage);
?>