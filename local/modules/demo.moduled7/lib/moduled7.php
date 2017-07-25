<?php
namespace Demo\Moduled7;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Entity,
    Bitrix\Highloadblock\HighloadBlockTable as HLBTb,
    Bitrix\Main\Loader;
	
Loc::loadMessages(__FILE__);

/**
 * Class Moduled7Table
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ID_USER string(255) mandatory
 * <li> TITLE string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Moduled7
 **/

class Moduled7Table extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'demo_moduled7';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
        Loader::includeSharewareModule("highloadblock");
        Loader::includeSharewareModule("iblock");
        $HLGetList = HLBTb::GetList(array("filter" => array('TABLE_NAME' => 'demo_hl_color')))->Fetch();
        $HLEntity = HLBTb::compileEntity($HLGetList);

        return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('MODULED7_ENTITY_ID_FIELD'),
			),
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('MODULED7_ENTITY_ID_USER_FIELD'),
			),
			'ELEMENT_ID' => array(
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('MODULED7_ENTITY_TITLE_FIELD'),
			),
            'COLOR_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage('MODULED7_ENTITY_TITLE_FIELD'),
            ),
            new Entity\ReferenceField(
                'HLCOLOR',
                $HLEntity,
                ['this.COLOR_ID' => 'ref.ID']
            ),
		);
	}
	/**
	 * Returns validators for ID_USER field.
	 *
	 * @return array
	 */
	public static function validateIdUser()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
	/**
	 * Returns validators for TITLE field.
	 *
	 * @return array
	 */
	public static function validateTitle()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
}
?>