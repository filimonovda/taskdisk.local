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
<script language="JavaScript">
    function selectadditems(selectObject) {
        var nextid=selectObject.id; //атрибут
        var parentid=selectObject.options[selectObject.selectedIndex].value; //значение

        var el = document.querySelector("div#imgplains div["+nextid+"="+parentid+"]");
        //$("div[nextid*='parentid']").className="disabled";
        //$("div:not([nextid*='parentid'])").className="enable";

            alert(el.className);
            //alert(selectObject.options[selectObject.selectedIndex].value);

            //var selectBox = document.getElementById(nextID);
            //var selectedValue = selectBox.options[selectBox.selectedIndex].value;


            //document.getElementById('test').innerHTML = ""; // очищаем Select
            //document.getElementById('sel_1').options.length = 0; // еще один способ очистки, найденный в интернете
            //document.getElementById('test').innerHTML = "<select id='sel_1'><option>Воронеж</option><option>Новгород</option></select>"; // вставляем новые option'ы
    }
</script>

<div>
    <select name="SelectRoomCountList" id="SelectRoomCountList" onchange="javascript:selectadditems(this)">
        <option value="all">Все</option>
    <?foreach ($arResult['SelectRoomCountList'] as $key => $value):?>
        <option value="<?=$key?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectTypeHouseList" id="SelectTypeHouseList" onchange="javascript:selectadditems(this)">
        <option value="all">Все</option>
    <?foreach ($arResult['SelectTypeHouseList'] as $key => $value):?>
        <option value="<?=$key?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectAreaSizeList" id="SelectAreaSizeList" onchange="javascript:selectadditems(this)">
        <option value="all">Все</option>
    <?foreach ($arResult['SelectAreaSizeList'] as $key => $value):?>
        <option value="<?=$key?>"><?=$value?></option>
    <?endforeach;?>
    </select>
</div>
<div id="imgplains">
<?foreach ($arResult['SelectVariantPlansList'] as $arResult):?>
    <div class="disabled" style="float: left; padding: 10px;" SelectRoomCountList="<?=$arResult["RoomCount"]?>" SelectTypeHouseList="<?=$arResult["TypeHouse"]?>" SelectAreaSizeList="<?=$arResult["AreaSize"]?>"><img src="<?=$arResult["SmilePicURL"]?>" style="max-height: 300px;"></div>
<?endforeach;?>
</div>
