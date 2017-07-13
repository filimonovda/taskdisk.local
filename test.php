<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$group = new CGroup;
/*$user = new CUser;
$arFields = Array(
    "NAME"              => "Сергей",
    "LAST_NAME"         => "Иванов",
    "EMAIL"             => "ivanov@microsoft.com",
    "LOGIN"             => "ivan",
    "LID"               => "ru",
    "ACTIVE"            => "Y",
    "GROUP_ID"          => array(10,11),
    "PASSWORD"          => "123456",
    "CONFIRM_PASSWORD"  => "123456"
);*/

//$ID = $user->Add($arFields);
//$ID = $group->Add($arFields);
//echo $ID;

use Bitrix\Main\GroupTable;

GroupTable::add(array(
        "NAME"=>"test"
       ));
?>