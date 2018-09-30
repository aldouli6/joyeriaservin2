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
class Servin2ModelVentas extends JModelList
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
				'cliente', 'a.`cliente`',
				'pieza', 'a.`pieza`',
				'cantidad', 'a.`cantidad`',
				'fecha', 'a.`fecha`',
				'total', 'a.`total`',
				'abonado', 'a.`abonado`',
				'pagada', 'a.`pagada`',
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
		// Filtering cliente
		$this->setState('filter.cliente', $app->getUserStateFromRequest($this->context.'.filter.cliente', 'filter_cliente', '', 'string'));

		// Filtering pieza
		$this->setState('filter.pieza', $app->getUserStateFromRequest($this->context.'.filter.pieza', 'filter_pieza', '', 'string'));

		// Filtering fecha
		$this->setState('filter.fecha.from', $app->getUserStateFromRequest($this->context.'.filter.fecha.from', 'filter_from_fecha', '', 'string'));
		$this->setState('filter.fecha.to', $app->getUserStateFromRequest($this->context.'.filter.fecha.to', 'filter_to_fecha', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_servin2');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.cliente', 'asc');
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
		$query->from('`#__servin_ventas2` AS a');
                

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
		// Join over the foreign key 'cliente'
		$query->select('`#__servin_clientes2_3025079`.`nombre` AS clientes_fk_value_3025079');
		$query->join('LEFT', '#__servin_clientes2 AS #__servin_clientes2_3025079 ON #__servin_clientes2_3025079.`id` = a.`cliente`');
		// Join over the foreign key 'pieza'
		$query->select('CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) AS piezas_fk_value_3025077');
		$query->join('LEFT', '#__servin_piezas2 AS #__servin_piezas2_3025077 ON #__servin_piezas2_3025077.`id` = a.`pieza`');
                

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
				$query->where('(#__servin_clientes2_3025079.nombre LIKE ' . $search . '  OR CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) LIKE ' . $search . '  OR  a.fecha LIKE ' . $search . '  OR  a.total LIKE ' . $search . ' )');
			}
		}
                

		// Filtering cliente
		$filter_cliente = $this->state->get("filter.cliente");

		if ($filter_cliente !== null && !empty($filter_cliente))
		{
			$query->where("a.`cliente` = '".$db->escape($filter_cliente)."'");
		}

		// Filtering pieza
		$filter_pieza = $this->state->get("filter.pieza");

		if ($filter_pieza !== null && !empty($filter_pieza))
		{
			$query->where("a.`pieza` = '".$db->escape($filter_pieza)."'");
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

			if (isset($oneItem->cliente))
			{
				$values    = explode(',', $oneItem->cliente);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_clientes2_3025079`.`nombre`')
						->from($db->quoteName('#__servin_clientes2', '#__servin_clientes2_3025079'))
						->where($db->quoteName('#__servin_clientes2_3025079.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$oneItem->cliente = !empty($textValue) ? implode(', ', $textValue) : $oneItem->cliente;
			}

			if (isset($oneItem->pieza))
			{
				$values    = explode(',', $oneItem->pieza);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) AS `fk_value`')
						->from($db->quoteName('#__servin_piezas2', '#__servin_piezas2_3025077'))
						->where($db->quoteName('#__servin_piezas2_3025077.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->fk_value;
					}
				}

				$oneItem->pieza = !empty($textValue) ? implode(', ', $textValue) : $oneItem->pieza;
			}
		}

		return $items;
	}
}
