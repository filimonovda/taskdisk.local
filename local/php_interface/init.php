<?
//$eventManager = \Bitrix\Main\EventManager::getInstance();

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

AddEventHandler("iblock", "OnIBlockElementAdd", Array("MyClass", "OnBeforeIBlockAddHandler"));

class MyClass
{
    function OnBeforeIBlockAddHandler($arFields)
    {
        AddMessage2Log($arFields);
    }
}

/*$eventManager->addEventHandler (
    "main",
    "\Bitrix\Main\User::OnBeforeAdd",
    'onBeforeAddUser'
);

$eventManager->addEventHandler (
    "main",
    "\Bitrix\Main\Group::OnBeforeAdd",
    'onBeforeAddGroup'
);*/

    function onBeforeAddUser(\Bitrix\Main\Entity\Event $event) {

        $result = new \Bitrix\Main\Entity\EventResult();
        //$datauser = $event->getParameter("fields");
        //$arTemp['LOGIN']="Vasya";
        //$arTemp['NAME']="Vasya";
        //$result->modifyFields($arTemp);

        echo "User:";
        $fields = $event->getParameter('fields');
        print_r($fields['NAME']);

        //$cleanIsbn = str_replace('t', '12345', $fields['NAME']);
        //$id = $event->getParameter('id');
        //$name = $event->getParameter('NAME');
        //$result->modifyFields(array("name" => $cleanIsbn));

        // время
        //pr($fields);
    }

    function onBeforeAddGroup(\Bitrix\Main\Entity\Event $event) {
        echo "Group:";
        $fields = $event->getParameter('fields');
        print_r($fields['NAME']);

        $result = new \Bitrix\Main\Entity\EventResult();
        //$datauser = $event->getParameter("fields");
        //$arTemp['LOGIN']="Vasya";
        //$arTemp['NAME']="Vasya";
        //$result->modifyFields($arTemp);

        //$fields = $event->getParameter('fields');

        $cleanIsbn = str_replace('t', '12345', $fields['NAME']);
        //$id = $event->getParameter('id');
        //$name = $event->getParameter('NAME');
        $result->modifyFields(array("NAME" => $cleanIsbn));

        return $result;
        // время
        //pr($fields);
    }
?>