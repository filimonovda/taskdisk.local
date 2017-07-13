<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use \Bitrix\Main\Loader,
	Demo\Moduled7,
	Bitrix\Highloadblock\HighloadBlockTable as HLBTb,
	Bitrix\Main\Entity;

Loader::includeSharewareModule("demo.moduled7"); 
Loader::includeSharewareModule("highloadblock"); 

$HLGetList = HLBTb::GetList(array("filter" => array('TABLE_NAME' => 'testhi')))->Fetch();
$HLEntity = HLBTb::compileEntity($HLGetList);
$HLGetListHeight = HLBTb::GetList(array("filter" => array('TABLE_NAME' => 'Height')))->Fetch();
$HLEntityHeight = HLBTb::compileEntity($HLGetListHeight);

$arResult = Demo\Moduled7\Moduled7Table::GetList(
	array(
		'select' => array('USERID' => 'ID', 'VALERANAME' => 'USER.LOGIN', 'COLOR' => 'HLCOLOR.UF_COLOR', 'COUNT', 'MAX', 'SUM'),
		'runtime' => array(
                new Entity\ReferenceField(
                    'HLCOLOR',
                    $HLEntity,
                    ['this.ID' => 'ref.UF_USER_ID']
                ),
				new Entity\ReferenceField(
                    'HLHeight',
                    $HLEntityHeight,
                    ['=this.ID' => 'ref.UF_USER_ID']
                ),
				new Entity\ExpressionField('COUNT', 'COUNT(%s)', array('HLHeight.UF_VALUE')),
				new Entity\ExpressionField('MAX', 'MAX(%s)', array('HLHeight.UF_VALUE')),
				new Entity\ExpressionField('SUM', 'SUM(%s)', array('HLHeight.UF_VALUE')),
            ),
	)
);

echo "<pre>";
print_r($arResult->fetchall());
echo "</pre>";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>

