<?php
namespace Demo\Moduled7;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Entity;
	
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
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('MODULED7_ENTITY_ID_FIELD'),
			),
			'ID_USER' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateIdUser'),
				'title' => Loc::getMessage('MODULED7_ENTITY_ID_USER_FIELD'),
			),
			'TITLE' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateTitle'),
				'title' => Loc::getMessage('MODULED7_ENTITY_TITLE_FIELD'),
			),
            new Entity\ReferenceField(
                'USER',
                '\Bitrix\Main\UserTable',
                array('=this.ID_USER' => 'ref.ID')
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