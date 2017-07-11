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
        //var nextid=selectObject.id; //атрибут
        //var parentid=selectObject.options[selectObject.selectedIndex].value; //значение
        //var el = document.querySelector("div[SelectRoomCountList=522]");
        //var el = document.querySelector('div#imgplains div[SelectRoomCountList="522"]');

       /*var eldisable = document.querySelectorAll('div#imgplains div[' + nextid + ']');
        for (var indexdisable = 0; indexdisable < eldisable.length; indexdisable++) {
            if (eldisable[indexdisable].className === "enable") {
                eldisable[indexdisable].className = "disable";
            }
        }

        var elenable = document.querySelectorAll('div#imgplains div[' + nextid + '="' + parentid + '"]');
        for (var indexenable = 0; indexenable < elenable.length; indexenable++) {
            elenable[indexenable].className = "enable";
            if (elenable[indexenable].className === "disable") {
                elenable[indexenable].className = "enable";
            }
        }*/

       //скрываем все
        var eldisable = document.querySelectorAll('div#imgplains div');
        for (var indexdisable = 0; indexdisable < eldisable.length; indexdisable++) {
            if (eldisable[indexdisable].className === "enable") {
                eldisable[indexdisable].className = "disable";
            }
        }
        //скрываем все

        var SelectRoomCountObg = document.getElementById("SelectRoomCountList");
        var SelectTypeHouseObg = document.getElementById("SelectTypeHouseList");
        var SelectAreaSizeObg = document.getElementById("SelectAreaSizeList");

        var SelectRoomCountValue = SelectRoomCountObg.options[SelectRoomCountObg.selectedIndex].value;
        var SelectTypeHouseValue = SelectTypeHouseObg.options[SelectTypeHouseObg.selectedIndex].value;
        var SelectAreaSizeValue = SelectAreaSizeObg.options[SelectAreaSizeObg.selectedIndex].value;

        var searchar = [];
        if(SelectRoomCountValue !== "all") searchar.push('div#imgplains div[SelectRoomCountList="' + SelectRoomCountValue + '"]');
        if(SelectTypeHouseValue !== "all") searchar.push('div#imgplains div[SelectTypeHouseList="' + SelectTypeHouseValue + '"]');
        if(SelectAreaSizeValue !== "all") searchar.push('div#imgplains div[SelectAreaSizeList="' + SelectAreaSizeValue + '"]');
        //var searchstr=searchar.join(",");

        //показываем что соответсвует результатам поиска
        var elenable = document.querySelectorAll(searchar);
        for (var indexenable = 0; indexenable < elenable.length; indexenable++) {
            elenable[indexenable].className = "enable";
            if (elenable[indexenable].className === "disable") {
                elenable[indexenable].className = "enable";
            }
        }
        //показываем что соответсвует результатам поиска
    }
</script>

<div>
    <select name="SelectRoomCountList" id="SelectRoomCountList" onchange="javascript:selectadditems()">
        <option value="all"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectRoomCountList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectTypeHouseList" id="SelectTypeHouseList" onchange="javascript:selectadditems()">
        <option value="all"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectTypeHouseList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>

    <select name="SelectAreaSizeList" id="SelectAreaSizeList" onchange="javascript:selectadditems()">
        <option value="all"><?=Loc::getMessage("all")?></option>
    <?foreach ($arResult['SelectAreaSizeList'] as $key => $value):?>
        <option value="<?=$value?>"><?=$value?></option>
    <?endforeach;?>
    </select>
</div>
<div id="imgplains">
<?foreach ($arResult['SelectVariantPlansList'] as $arResult):?>
    <div class="enable" style="float: left; padding: 10px;" SelectRoomCountList="<?=$arResult["RoomCount"]?>" SelectTypeHouseList="<?=$arResult["TypeHouse"]?>" SelectAreaSizeList="<?=$arResult["AreaSize"]?>"><img src="<?=$arResult["SmilePicURL"]?>" style="max-height: 300px;"></div>
<?endforeach;?>
</div>
