<?

use Bitrix\Crm\DealTable;

if(isset($_REQUEST["ID"]))
    $List = DealTable::getList(array("filter"=>array("ID" => $_REQUEST["ID"])));
else
    $List = DealTable::getList(array());
endif;

$arResult = $List->fetchAll();
$this->IncludeComponentTemplate($componentPage);
?>