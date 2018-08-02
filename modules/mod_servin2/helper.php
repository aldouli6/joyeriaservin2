<?php

/**
 * @version     CVS: 1.0.0
 * @package     com_servin2
 * @subpackage  mod_servin2
 * @author      Aldo Ulises <aldouli6@gmail.com>
 * @copyright   2018 Aldo Ulises
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Helper for mod_servin2
 *
 * @package     com_servin2
 * @subpackage  mod_servin2
 * @since       1.6
 */
class ModServin2Helper
{
	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return array Array with all the elements
	 */
	public static function getList(&$params)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($params->get('table'))
			->where('state = 1');

		$db->setQuery($query, $params->get('offset'), $params->get('limit'));
		$rows = $db->loadObjectList();

		return $rows;
	}

	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return mixed stdClass object if the item was found, null otherwise
	 */
	public static function getItem(&$params)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($params->get('item_table'))
			->where('id = ' . intval($params->get('item_id')));

		$db->setQuery($query);
		$element = $db->loadObject();

		return $element;
	}

	/**
	 * Render element
	 *
	 * @param   Joomla\Registry\Registry $table_name  Table name
	 * @param   string                   $field_name  Field name
	 * @param   string                   $field_value Field value
	 *
	 * @return string
	 */
	public static function renderElement($table_name, $field_name, $field_value)
	{
		$result = '';
		
		switch ($table_name)
		{
			
		case '#__servin_materiales2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'nombre':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_kilatajes2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'kilataje':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_ubicaciones2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'nombre':
		$result = $field_value;
		break;
		case 'direccion':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_hechuras2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'numero':
		$result = $field_value;
		break;
		case 'costo':
		$result = $field_value;
		break;
		case 'tipo_ganancia':
		$result = $field_value;
		break;
		case 'ganancia':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_piezas2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_at':
		$result = $field_value;
		break;
		case 'created_at':
		$result = $field_value;
		break;
		case 'descripcion':
		$result = $field_value;
		break;
		case 'material':
		$result = self::loadValueFromExternalTable('#__servin_materiales2', 'id', 'nombre', $field_value);
		break;
		case 'kilataje':
		$result = self::loadValueFromExternalTable('#__servin_kilatajes2', 'id', 'kilataje', $field_value);
		break;
		case 'ubicacion':
		$result = self::loadValueFromExternalTable('#__servin_ubicaciones2', 'id', 'nombre', $field_value);
		break;
		case 'hechura':
		$result = self::loadValueFromExternalTable('#__servin_hechuras2', 'id', 'numero', $field_value);
		break;
		case 'tipo':
		$result = $field_value;
		break;
		case 'gramos':
		$result = $field_value;
		break;
		case 'cantidad':
		$result = $field_value;
		break;
		case 'estatus':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_proveedores2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'empresa':
		$result = $field_value;
		break;
		case 'nombre':
		$result = $field_value;
		break;
		case 'direccion':
		$result = $field_value;
		break;
		case 'telefono':
		$result = $field_value;
		break;
		case 'correo':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_clientes2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'nombre':
		$result = $field_value;
		break;
		case 'direccion':
		$result = $field_value;
		break;
		case 'telefono':
		$result = $field_value;
		break;
		case 'correo':
		$result = $field_value;
		break;
		case 'fotoine':
						if (!empty($field_value)) {
							$result = JPATH_ADMINISTRATOR . 'components/com_servin2//' . $field_value;
						} else {
							$result = $field_value;
						}
		break;
		case 'fotocomprobante':
						if (!empty($field_value)) {
							$result = JPATH_ADMINISTRATOR . 'components/com_servin2//' . $field_value;
						} else {
							$result = $field_value;
						}
		break;
		}
		break;
		case '#__servin_compras2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'created_at':
		$result = $field_value;
		break;
		case 'modified_at':
		$result = $field_value;
		break;
		case 'fecha':
		$result = $field_value;
		break;
		case 'proveedor':
		$result = self::loadValueFromExternalTable('#__servin_proveedores2', 'id', '', $field_value);
		break;
		case 'pieza':
		$result = self::loadValueFromExternalTable('#__servin_piezas2', 'id', '', $field_value);
		break;
		case 'cantidad':
		$result = $field_value;
		break;
		case 'total':
		$result = $field_value;
		break;
		case 'abonado':
		$result = $field_value;
		break;
		case 'pagada':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_ventas2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'created_at':
		$result = $field_value;
		break;
		case 'modified_at':
		$result = $field_value;
		break;
		case 'pieza':
		$result = self::loadValueFromExternalTable('#__servin_piezas2', 'id', '', $field_value);
		break;
		case 'fecha':
		$result = $field_value;
		break;
		case 'tipo':
		$result = $field_value;
		break;
		case 'gramos':
		$result = $field_value;
		break;
		case 'cantidad':
		$result = $field_value;
		break;
		case 'cliente':
		$result = self::loadValueFromExternalTable('#__servin_clientes2', 'id', 'nombre', $field_value);
		break;
		case 'total':
		$result = $field_value;
		break;
		case 'metodo_pago':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin_consignaciones2':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'created_at':
		$result = $field_value;
		break;
		case 'modified_at':
		$result = $field_value;
		break;
		case 'no_folio_pagare':
		$result = $field_value;
		break;
		case 'foto_pagare':
						if (!empty($field_value)) {
							$result = JPATH_ADMINISTRATOR . 'components/com_servin2//' . $field_value;
						} else {
							$result = $field_value;
						}
		break;
		case 'piezas':
		$result = self::loadValueFromExternalTable('#__servin_piezas2', 'id', '', $field_value);
		break;
		case 'para':
		$result = $field_value;
		break;
		case 'cliente':
		$result = self::loadValueFromExternalTable('#__servin_clientes2', 'id', 'nombre', $field_value);
		break;
		case 'proveedor':
		$result = self::loadValueFromExternalTable('#__servin_proveedores2', 'id', '', $field_value);
		break;
		case 'total':
		$result = $field_value;
		break;
		case 'abono':
		$result = $field_value;
		break;
		case 'abo_dev':
		$result = $field_value;
		break;
		case 'devoluciones':
		$result = self::loadValueFromExternalTable('#__servin_consignaciones2', 'id', 'no_folio_pagare', $field_value);
		break;
		case 'adeudo':
		$result = $field_value;
		break;
		case 'fecha_emision':
		$result = $field_value;
		break;
		case 'fecha_limite':
		$result = $field_value;
		break;
		case 'devolucion':
		$result = $field_value;
		break;
		case 'fecha_devolucion':
		$result = $field_value;
		break;
		case 'estatus':
		$result = $field_value;
		break;
		}
		break;
		case '#__servin2_pagos':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'consignacion':
		$result = self::loadValueFromExternalTable('#__servin_consignaciones2', 'id', 'foto_pagare', $field_value);
		break;
		case 'pago':
		$result = $field_value;
		break;
		case 'metodo':
		$result = $field_value;
		break;
		case 'fecha':
		$result = $field_value;
		break;
		}
		break;
		}

		return $result;
	}

	/**
	 * Returns the translatable name of the element
	 *
	 * @param   Joomla\Registry\Registry &$params Module parameters
	 * @param   string                   $field   Field name
	 *
	 * @return string Translatable name.
	 */
	public static function renderTranslatableHeader(&$params, $field)
	{
		return JText::_(
			'MOD_SERVIN2_HEADER_FIELD_' . str_replace('#__', '', strtoupper($params->get('table'))) . '_' . strtoupper($field)
		);
	}

	/**
	 * Checks if an element should appear in the table/item view
	 *
	 * @param   string $field name of the field
	 *
	 * @return boolean True if it should appear, false otherwise
	 */
	public static function shouldAppear($field)
	{
		$noHeaderFields = array('checked_out_time', 'checked_out', 'ordering', 'state');

		return !in_array($field, $noHeaderFields);
	}

	

    /**
     * Method to get a value from a external table
     * @param string $source_table Source table name
     * @param string $key_field Source key field 
     * @param string $value_field Source value field
     * @param mixed  $key_value Value for the key field
     * @return mixed The value in the external table or null if it wasn't found
     */
    private static function loadValueFromExternalTable($source_table, $key_field, $value_field, $key_value) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select($db->quoteName($value_field))
                ->from($source_table)
                ->where($db->quoteName($key_field) . ' = ' . $db->quote($key_value));


        $db->setQuery($query);
        return $db->loadResult();
    }
}
