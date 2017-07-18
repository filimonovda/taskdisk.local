<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?
$APPLICATION->IncludeComponent(
	"demo:planingselect.list", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"MainFolder" => "521",
		"PropertyID" => "98",
		"IBLOCK_TYPE" => "test",
		"IBLOCK_ID" => "28"
	),
	false
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>