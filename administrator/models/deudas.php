<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin2
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Servin2 records.
 *
 * @since  1.6
 */
class Servin2ModelDeudas extends JModelList
{
    
        
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'created_at', 'a.`created_at`',
				'modified_at', 'a.`modified_at`',
				'proveedor', 'a.`proveedor`',
				'fecha_compra', 'a.`fecha_compra`',
				'fecha_limite', 'a.`fecha_limite`',
				'total', 'a.`total`',
				'abono', 'a.`abono`',
				'saldo', 'a.`saldo`',
				'resumen', 'a.`resumen`',
				'estatus', 'a.`estatus`',
			);
		}

		parent::__construct($config);
	}

    
        
    
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		// Filtering proveedor
		$this->setState('filter.proveedor', $app->getUserStateFromRequest($this->context.'.filter.proveedor', 'filter_proveedor', '', 'string'));

		// Filtering fecha_compra
		$this->setState('filter.fecha_compra.from', $app->getUserStateFromRequest($this->context.'.filter.fecha_compra.from', 'filter_from_fecha_compra', '', 'string'));
		$this->setState('filter.fecha_compra.to', $app->getUserStateFromRequest($this->context.'.filter.fecha_compra.to', 'filter_to_fecha_compra', '', 'string'));

		// Filtering fecha_limite
		$this->setState('filter.fecha_limite.from', $app->getUserStateFromRequest($this->context.'.filter.fecha_limite.from', 'filter_from_fecha_limite', '', 'string'));
		$this->setState('filter.fecha_limite.to', $app->getUserStateFromRequest($this->context.'.filter.fecha_limite.to', 'filter_to_fecha_limite', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_servin2');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.proveedor', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

                
                    return parent::getStoreId($id);
                
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__servin_deudas2` AS a');
                

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
		// Join over the foreign key 'proveedor'
		$query->select('CONCAT(`#__servin_proveedores2_3025022`.`empresa`, \' \', `#__servin_proveedores2_3025022`.`nombre`) AS proveedores_fk_value_3025022');
		$query->join('LEFT', '#__servin_proveedores2 AS #__servin_proveedores2_3025022 ON #__servin_proveedores2_3025022.`id` = a.`proveedor`');
                

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('(CONCAT(`#__servin_proveedores2_3025022`.`empresa`, \' \', `#__servin_proveedores2_3025022`.`nombre`) LIKE ' . $search . '  OR  a.fecha_compra LIKE ' . $search . '  OR  a.fecha_limite LIKE ' . $search . '  OR  a.total LIKE ' . $search . '  OR  a.abono LIKE ' . $search . '  OR  a.saldo LIKE ' . $search . '  OR  a.resumen LIKE ' . $search . '  OR  a.estatus LIKE ' . $search . ' )');
			}
		}
                

		// Filtering proveedor
		$filter_proveedor = $this->state->get("filter.proveedor");

		if ($filter_proveedor !== null && !empty($filter_proveedor))
		{
			$query->where("a.`proveedor` = '".$db->escape($filter_proveedor)."'");
		}

		// Filtering fecha_compra
		$filter_fecha_compra_from = $this->state->get("filter.fecha_compra.from");

		if ($filter_fecha_compra_from !== null && !empty($filter_fecha_compra_from))
		{
			$query->where("a.`fecha_compra` >= '".$db->escape($filter_fecha_compra_from)."'");
		}
		$filter_fecha_compra_to = $this->state->get("filter.fecha_compra.to");

		if ($filter_fecha_compra_to !== null  && !empty($filter_fecha_compra_to))
		{
			$query->where("a.`fecha_compra` <= '".$db->escape($filter_fecha_compra_to)."'");
		}

		// Filtering fecha_limite
		$filter_fecha_limite_from = $this->state->get("filter.fecha_limite.from");

		if ($filter_fecha_limite_from !== null && !empty($filter_fecha_limite_from))
		{
			$query->where("a.`fecha_limite` >= '".$db->escape($filter_fecha_limite_from)."'");
		}
		$filter_fecha_limite_to = $this->state->get("filter.fecha_limite.to");

		if ($filter_fecha_limite_to !== null  && !empty($filter_fecha_limite_to))
		{
			$query->where("a.`fecha_limite` <= '".$db->escape($filter_fecha_limite_to)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
                
		foreach ($items as $oneItem)
		{

			if (isset($oneItem->proveedor))
			{
				$values    = explode(',', $oneItem->proveedor);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('CONCAT(`#__servin_proveedores2_3025022`.`empresa`, \' |\', `#__servin_proveedores2_3025022`.`nombre`) AS `fk_value`')
						->from($db->quoteName('#__servin_proveedores2', '#__servin_proveedores2_3025022'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->fk_value;
					}
				}

				$oneItem->proveedor = !empty($textValue) ? implode(', ', $textValue) : $oneItem->proveedor;
			}
					$oneItem->estatus = ($oneItem->estatus == '') ? '' : JText::_('COM_SERVIN2_DEUDAS_ESTATUS_OPTION_' . strtoupper($oneItem->estatus));
		}

		return $items;
	}
}
