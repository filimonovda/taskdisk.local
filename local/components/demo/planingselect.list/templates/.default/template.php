<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
CJSCore::Init(array('ajax'));
?>
<script language="JavaScript">
    function selectadditems(elem) {
        BX.ajax.insertToNode(
            '/local/components/demo/planingselect.list/ajax.php?typeelements=file&root=' + <?=$arParams["MainFolder"]?> + '&folderid=' + elem.options[elem.selectedIndex].value,
            'imgplains'
        );
        BX.ajax.insertToNode(
            '/local/components/demo/planingselect.list/ajax.php?typeelements=folder&root=' + <?=$arParams["MainFolder"]?> + '&folderid=' + elem.options[elem.selectedIndex].value,
            'filterselect'
        );
    }
</script>
<form method="post" enctype="multipart/form-data">
    <div>
        <label>Имя элемента: </label><input name="name"><br>
    </div>
    <hr>
    <div>
        <laber>Загрузить файлы:</laber><br>
        <input type="file" name="filepc[]"><br>
        <input type="file" name="filepc[]"><br>
        <input type="file" name="filepc[]"><br>
    </div>
    <hr>
    <div id="filterselect">
        <label>Файлы с диска: </label>
        <select name="SelectRoomCountList" id="SelectRoomCountList" onchange="javascript:selectadditems(this)">
            <option value="<?=$arParams["MainFolder"]?>"><?= Loc::getMessage("all") ?></option>
            <? foreach ($arResult['SelectRoomCountList'] as $key => $value): ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div id="imgplains">
        <? foreach ($arResult['SelectVariantPlansList'] as $arResult): ?>
            <div class="enable" style="float: left; padding: 10px;" SelectRoomCountList="<?= $arResult["RoomCount"] ?>"
                 SelectTypeHouseList="<?= $arResult["TypeHouse"] ?>" SelectAreaSizeList="<?= $arResult["AreaSize"] ?>">
                <input type="checkbox" name="file[]" value="<?= $arResult["SmilePicURL"] ?>"><img
                        src="<?= $arResult["SmilePicURL"] ?>" style="max-height: 300px;"></div>
        <? endforeach; ?>
    </div>
    <input type="submit">
</form>