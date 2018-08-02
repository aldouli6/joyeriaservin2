<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin2
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Servin2 helper.
 *
 * @since  1.6
 */
class Servin2Helper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_MATERIALES'),
			'index.php?option=com_servin2&view=materiales',
			$vName == 'materiales'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_KILATAJES'),
			'index.php?option=com_servin2&view=kilatajes',
			$vName == 'kilatajes'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_UBICACIONES'),
			'index.php?option=com_servin2&view=ubicaciones',
			$vName == 'ubicaciones'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_HECHURAS'),
			'index.php?option=com_servin2&view=hechuras',
			$vName == 'hechuras'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_PIEZAS'),
			'index.php?option=com_servin2&view=piezas',
			$vName == 'piezas'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_PROVEEDORES'),
			'index.php?option=com_servin2&view=proveedores',
			$vName == 'proveedores'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_CLIENTES'),
			'index.php?option=com_servin2&view=clientes',
			$vName == 'clientes'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_COMPRAS'),
			'index.php?option=com_servin2&view=compras',
			$vName == 'compras'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_VENTAS'),
			'index.php?option=com_servin2&view=ventas',
			$vName == 'ventas'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_CONSIGNACIONES'),
			'index.php?option=com_servin2&view=consignaciones',
			$vName == 'consignaciones'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_PAGOS'),
			'index.php?option=com_servin2&view=pagos',
			$vName == 'pagos'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_SERVIN2_TITLE_DASHBOARDS'),
			'index.php?option=com_servin2&view=dashboards',
			$vName == 'dashboards'
		);
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_servin2';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

