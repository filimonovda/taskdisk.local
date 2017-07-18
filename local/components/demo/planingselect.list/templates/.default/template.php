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

    }
</script>
<form method="post">
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
    <?
    print_r($arParams);
    ?>
</div>
    <input type="submit">
</form>