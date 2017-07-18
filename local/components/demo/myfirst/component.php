<?

use Bitrix\Crm\DealTable;

$cacheTime=5;

$сache = Bitrix\Main\Data\Cache::createInstance();
if($сache->initCache($cacheTime, md5($_REQUEST["ID"])))
{
    echo "<p style='color:#00FF00'>Есть кэш, получаем</p>";
    $arResult = $сache->getVars();
}
elseif ($сache->startDataCache())
{
    echo "<p style='color:#FF0000'>Нет кэша, создаем</p>";
    if(isset($_REQUEST["ID"])){
        $List = DealTable::getList(array("filter"=>array("ID" => $_REQUEST["ID"])));
    }else{
        $List = DealTable::getList(array());
    }
    $arResult = $List->fetchAll();
    $сache->endDataCache($arResult);
}

$this->IncludeComponentTemplate($componentPage);
?>