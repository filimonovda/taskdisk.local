<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<style>
    .disable{
        display: none;
    }
    .enable{
        display: block;
    }
</style>
<script language="JavaScript">
    function selectadditems() {
        var SelectRoomCountList = document.getElementById("SelectRoomCountList");
        var valSelectRoomCountList = SelectRoomCountList.options[SelectRoomCountList.selectedIndex].value;
        var SelectTypeHouseList = document.getElementById("SelectTypeHouseList");
        var valSelectTypeHouseList = SelectTypeHouseList.options[SelectTypeHouseList.selectedIndex].value;
        var SelectAreaSizeList = document.getElementById("SelectAreaSizeList");
        var valSelectAreaSizeList = SelectAreaSizeList.options[SelectAreaSizeList.selectedIndex].value;

        var elemsenable = document.querySelectorAll("#imgplains div");
        for (var ie = 0, cnt = elemsenable.length; ie < cnt; ie++) {
            elemsenable[ie].setAttribute('class','disable');
        }

        var elems = document.querySelectorAll("#imgplains div[SelectRoomCountList='"+valSelectRoomCountList+"'], #imgplains div[SelectTypeHouseList='"+valSelectTypeHouseList+"'], #imgplains div[SelectAreaSizeList='"+valSelectAreaSizeList+"']")
        for (var i = 0, cnt = elems.length; i < cnt; i++) {
            elems[i].setAttribute('class','enable');
        }
    }
</script>
<form method="post">
    <input name="name">
<div>
    <select name="SelectRoomCountList" id="SelectRoomCountList" onchange="javascript:selectadditems()">
        <option value="*"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectRoomCountList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectTypeHouseList" id="SelectTypeHouseList" onchange="javascript:selectadditems()">
        <option value="*"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectTypeHouseList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectAreaSizeList" id="SelectAreaSizeList" onchange="javascript:selectadditems()">
        <option value="*"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectAreaSizeList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>
</div>
<div id="imgplains">
    <?foreach ($arResult['SelectVariantPlansList'] as $arResult):?>
        <div class="enable" style="float: left; padding: 10px;" SelectRoomCountList="<?=$arResult["RoomCount"]?>" SelectTypeHouseList="<?=$arResult["TypeHouse"]?>" SelectAreaSizeList="<?=$arResult["AreaSize"]?>"><input type="checkbox" name="file[]" value="<?=$arResult["SmilePicURL"]?>"><img src="<?=$arResult["SmilePicURL"]?>" style="max-height: 300px;"></div>
    <?endforeach;?>
</div>
    <input type="submit">
</form>