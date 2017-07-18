<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class CDemoPlaning extends CBitrixComponent
{
    public function ListFolder($idparent)
    {
        $ListSubFolder = Bitrix\Disk\Folder::getList(array("filter"=>array("=PARENT_ID"=>$idparent, "=TYPE"=>2, "=DELETED_TYPE"=>0)));
        return $ListSubFolder -> fetchall();
    }

    public function ListFileID($idparent)
    {
        $ListElFolder = Bitrix\Disk\Folder::getList(array("filter"=>array("=PARENT_ID"=>$idparent, "=TYPE"=>3, "=DELETED_TYPE"=>0)));
        while ($rowListElFolder = $ListElFolder -> fetch()){
            $arReturn[$rowListElFolder["FILE_ID"]] = Bitrix\Main\FileTable::getById($rowListElFolder["FILE_ID"])->fetchAll();
        }
        return $arReturn;
    }
}
?>