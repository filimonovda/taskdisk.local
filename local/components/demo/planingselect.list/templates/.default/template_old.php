<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var \Bitrix\Disk\Internals\BaseComponent $component */
use Bitrix\Main\Localization\Loc;
?>

<select name="SelectRoomCountList" id="SelectRoomCountList">
<?foreach ($arResult['SelectRoomCountList'] as $key => $value):?>
    <?print_r($value)?>
    <option  onselect=""><?=$key?></option>
<?endforeach;?>
</select>

<select name="SelectTypeHouseList" id="SelectTypeHouseList">
    <?foreach ($arResult['SelectTypeHouseList'] as $key => $value):?>
        <option onselect=""><?=$key?></option>
    <?endforeach;?>
</select>

<select name="SelectAreaSizeList" id="SelectAreaSizeList">
    <?foreach ($arResult['SelectAreaSizeList'] as $key => $value):?>
        <option onselect=""><?=$key?></option>
    <?endforeach;?>
</select>