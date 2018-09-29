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
class Servin2ModelPagos extends JModelList
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
				'tipo', 'a.`tipo`',
				'consignacion', 'a.`consignacion`',
				'compra', 'a.`compra`',
				'venta', 'a.`venta`',
				'pago', 'a.`pago`',
				'metodo', 'a.`metodo`',
				'fecha', 'a.`fecha`',
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
		// Filtering tipo
		$this->setState('filter.tipo', $app->getUserStateFromRequest($this->context.'.filter.tipo', 'filter_tipo', '', 'string'));

		// Filtering consignacion
		$this->setState('filter.consignacion', $app->getUserStateFromRequest($this->context.'.filter.consignacion', 'filter_consignacion', '', 'string'));

		// Filtering compra
		$this->setState('filter.compra', $app->getUserStateFromRequest($this->context.'.filter.compra', 'filter_compra', '', 'string'));

		// Filtering venta
		$this->setState('filter.venta', $app->getUserStateFromRequest($this->context.'.filter.venta', 'filter_venta', '', 'string'));

		// Filtering metodo
		$this->setState('filter.metodo', $app->getUserStateFromRequest($this->context.'.filter.metodo', 'filter_metodo', '', 'string'));

		// Filtering fecha
		$this->setState('filter.fecha.from', $app->getUserStateFromRequest($this->context.'.filter.fecha.from', 'filter_from_fecha', '', 'string'));
		$this->setState('filter.fecha.to', $app->getUserStateFromRequest($this->context.'.filter.fecha.to', 'filter_to_fecha', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_servin2');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.tipo', 'asc');
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
		$query->from('`#__servin2_pagos` AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
		// Join over the foreign key 'consignacion'
		$query->select('`#__servin_consignaciones2_3029711`.`pieza` AS consignaciones_fk_value_3029711');
		$query->join('LEFT', '#__servin_consignaciones2 AS #__servin_consignaciones2_3029711 ON #__servin_consignaciones2_3029711.`id` = a.`consignacion`');
		// Join over the foreign key 'compra'
		$query->select('`#__servin_compras2_3076251`.`pieza` AS compras_fk_value_3076251');
		$query->join('LEFT', '#__servin_compras2 AS #__servin_compras2_3076251 ON #__servin_compras2_3076251.`id` = a.`compra`');
		// Join over the foreign key 'venta'
		$query->select('`#__servin_ventas2_3076252`.`pieza` AS ventas_fk_value_3076252');
		$query->join('LEFT', '#__servin_ventas2 AS #__servin_ventas2_3076252 ON #__servin_ventas2_3076252.`id` = a.`venta`');
                

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
				$query->where('( a.tipo LIKE ' . $search . '  OR  a.pago LIKE ' . $search . ' )');
			}
		}
                

		// Filtering tipo
		$filter_tipo = $this->state->get("filter.tipo");

		if ($filter_tipo !== null && (is_numeric($filter_tipo) || !empty($filter_tipo)))
		{
			$query->where("a.`tipo` = '".$db->escape($filter_tipo)."'");
		}

		// Filtering consignacion
		$filter_consignacion = $this->state->get("filter.consignacion");

		if ($filter_consignacion !== null && !empty($filter_consignacion))
		{
			$query->where("a.`consignacion` = '".$db->escape($filter_consignacion)."'");
		}

		// Filtering compra
		$filter_compra = $this->state->get("filter.compra");

		if ($filter_compra !== null && !empty($filter_compra))
		{
			$query->where("a.`compra` = '".$db->escape($filter_compra)."'");
		}

		// Filtering venta
		$filter_venta = $this->state->get("filter.venta");

		if ($filter_venta !== null && !empty($filter_venta))
		{
			$query->where("a.`venta` = '".$db->escape($filter_venta)."'");
		}

		// Filtering metodo
		$filter_metodo = $this->state->get("filter.metodo");

		if ($filter_metodo !== null && (is_numeric($filter_metodo) || !empty($filter_metodo)))
		{
			$query->where("a.`metodo` = '".$db->escape($filter_metodo)."'");
		}

		// Filtering fecha
		$filter_fecha_from = $this->state->get("filter.fecha.from");

		if ($filter_fecha_from !== null && !empty($filter_fecha_from))
		{
			$query->where("a.`fecha` >= '".$db->escape($filter_fecha_from)."'");
		}
		$filter_fecha_to = $this->state->get("filter.fecha.to");

		if ($filter_fecha_to !== null  && !empty($filter_fecha_to))
		{
			$query->where("a.`fecha` <= '".$db->escape($filter_fecha_to)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', "a.id");
		$orderDirn = $this->state->get('list.direction', "ASC");

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
					$oneItem->tipo = ($oneItem->tipo == '') ? '' : JText::_('COM_SERVIN2_PAGOS_TIPO_OPTION_' . strtoupper($oneItem->tipo));

			if (isset($oneItem->consignacion))
			{
				$values    = explode(',', $oneItem->consignacion);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_consignaciones2_3029711`.`pieza`')
						->from($db->quoteName('#__servin_consignaciones2', '#__servin_consignaciones2_3029711'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$oneItem->consignacion = !empty($textValue) ? implode(', ', $textValue) : $oneItem->consignacion;
			}

			if (isset($oneItem->compra))
			{
				$values    = explode(',', $oneItem->compra);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_compras2_3076251`.`pieza`')
						->from($db->quoteName('#__servin_compras2', '#__servin_compras2_3076251'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$oneItem->compra = !empty($textValue) ? implode(', ', $textValue) : $oneItem->compra;
			}

			if (isset($oneItem->venta))
			{
				$values    = explode(',', $oneItem->venta);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_ventas2_3076252`.`pieza`')
						->from($db->quoteName('#__servin_ventas2', '#__servin_ventas2_3076252'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$oneItem->venta = !empty($textValue) ? implode(', ', $textValue) : $oneItem->venta;
			}
					$oneItem->metodo = JText::_('COM_SERVIN2_PAGOS_METODO_OPTION_' . strtoupper($oneItem->metodo));
		}

		return $items;
	}
}
