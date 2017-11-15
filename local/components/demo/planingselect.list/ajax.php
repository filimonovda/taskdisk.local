<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Disk\Folder,
    Bitrix\Disk\Internals\ObjectTable,
    Bitrix\Main\FileTable;


function GetChildrenFile($FolderScan)
{
    $folder = Folder::loadById($FolderScan);
    $sc = $folder->getStorage()->getCurrentUserSecurityContext();
    if (is_object($folder)) {
        return $folder->getDescendants($sc, ['filter' => array('TYPE' => ObjectTable::TYPE_FILE)]);
    }
}

function GetParrent($FolderScan)
{
    $folder = Folder::loadById($FolderScan);
    if (is_object($folder)) {
        return $folder->getParentId();
    }
}

if ($_REQUEST['typeelements'] == 'file') {

    foreach (GetChildrenFile($_REQUEST['folderid']) as $children) {
        $arFile = FileTable::getById($children->getFileId())->fetch();
        ?>
        <div style="float: left; padding: 10px;">
            <input type="checkbox" name="file[]" value="/upload/<?= $arFile["SUBDIR"] ?>/<?= $arFile["FILE_NAME"] ?>">
            <img src="/upload/<?= $arFile["SUBDIR"] ?>/<?= $arFile["FILE_NAME"] ?>" style="max-height: 300px;">
        </div>
        <?
    }
} elseif ($_REQUEST['typeelements'] == 'folder') {
    ?>
    <label>Файлы с диска: </label>
    <?
    $parent = $_REQUEST['folderid'];
    $arFolderID[] = $_REQUEST['folderid'];
    do {
        $parent = GetParrent($arFolderID[0]);
        array_unshift($arFolderID, GetParrent($arFolderID[0]));
    } while ($parent != $_REQUEST['root']);
    foreach ($arFolderID as $key => $FolderID) {
        $objFolder = Folder::getList(array("filter"=>array("=PARENT_ID"=>$FolderID, "=TYPE"=>ObjectTable::TYPE_FOLDER, "=DELETED_TYPE"=>0), 'count_total' => true));
        if($objFolder->getCount()>0) {
            ?>
            <select name="SelectList<?= $FolderID ?>" id="SelectList<?= $FolderID ?>"
                    onchange="javascript:selectadditems(this)">
                <?
                while ($FolderChildren = $objFolder->fetch()) {
                    ?>
                    <option<?
                    if (in_array($FolderChildren['ID'], $arFolderID)): ?> selected<?endif ?>
                            value="<?= $FolderChildren['ID'] ?>"><?= $FolderChildren['NAME'] ?></option>
                    <?
                }
                ?>
            </select>
            <?
        }
    }
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");