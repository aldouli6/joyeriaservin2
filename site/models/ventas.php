<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin2
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

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
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'created_at', 'a.created_at',
				'modified_at', 'a.modified_at',
				'pieza', 'a.pieza',
				'fecha', 'a.fecha',
				'tipo', 'a.tipo',
				'gramos', 'a.gramos',
				'cantidad', 'a.cantidad',
				'cliente', 'a.cliente',
				'total', 'a.total',
				'metodo_pago', 'a.metodo_pago',
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
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
            $app  = Factory::getApplication();
		$list = $app->getUserState($this->context . '.list');

		$ordering  = isset($list['filter_order'])     ? $list['filter_order']     : null;
		$direction = isset($list['filter_order_Dir']) ? $list['filter_order_Dir'] : null;

		$list['limit']     = (int) Factory::getConfig()->get('list_limit', 20);
		$list['start']     = $app->input->getInt('start', 0);
		$list['ordering']  = $ordering;
		$list['direction'] = $direction;

		$app->setUserState($this->context . '.list', $list);
		$app->input->set('list', null);

            // List state information.
            parent::populateState($ordering, $direction);

            $app = Factory::getApplication();

            $ordering  = $app->getUserStateFromRequest($this->context . '.ordercol', 'filter_order', $ordering);
            $direction = $app->getUserStateFromRequest($this->context . '.orderdirn', 'filter_order_Dir', $ordering);

            $this->setState('list.ordering', $ordering);
            $this->setState('list.direction', $direction);

            $start = $app->getUserStateFromRequest($this->context . '.limitstart', 'limitstart', 0, 'int');
            $limit = $app->getUserStateFromRequest($this->context . '.limit', 'limit', 0, 'int');

            if ($limit == 0)
            {
                $limit = $app->get('list_limit', 0);
            }

            $this->setState('list.limit', $limit);
            $this->setState('list.start', $start);
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
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		// Join over the foreign key 'pieza'
		$query->select('CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) AS piezas_fk_value_3025077');
		$query->join('LEFT', '#__servin_piezas2 AS #__servin_piezas2_3025077 ON #__servin_piezas2_3025077.`id` = a.`pieza`');
		// Join over the foreign key 'cliente'
		$query->select('`#__servin_clientes2_3025079`.`nombre` AS clientes_fk_value_3025079');
		$query->join('LEFT', '#__servin_clientes2 AS #__servin_clientes2_3025079 ON #__servin_clientes2_3025079.`id` = a.`cliente`');
            
		if (!Factory::getUser()->authorise('core.edit', 'com_servin2'))
		{
			$query->where('a.state = 1');
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
				$query->where('(CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) LIKE ' . $search . '  OR #__servin_clientes2_3025079.nombre LIKE ' . $search . ' )');
                }
            }
            

		// Filtering pieza
		$filter_pieza = $this->state->get("filter.pieza");

		if ($filter_pieza)
		{
			$query->where("a.`pieza` = '".$db->escape($filter_pieza)."'");
		}

		// Filtering fecha
		// Checking "_dateformat"
		$filter_fecha_from = $this->state->get("filter.fecha_from_dateformat");
		$filter_Qfecha_from = (!empty($filter_fecha_from)) ? $this->isValidDate($filter_fecha_from) : null;

		if ($filter_Qfecha_from != null)
		{
			$query->where("a.fecha >= '" . $db->escape($filter_Qfecha_from) . "'");
		}

		$filter_fecha_to = $this->state->get("filter.fecha_to_dateformat");
		$filter_Qfecha_to = (!empty($filter_fecha_to)) ? $this->isValidDate($filter_fecha_to) : null ;

		if ($filter_Qfecha_to != null)
		{
			$query->where("a.fecha <= '" . $db->escape($filter_Qfecha_to) . "'");
		}

		// Filtering cliente
		$filter_cliente = $this->state->get("filter.cliente");

		if ($filter_cliente)
		{
			$query->where("a.`cliente` = '".$db->escape($filter_cliente)."'");
		}

		// Filtering metodo_pago
		$filter_metodo_pago = $this->state->get("filter.metodo_pago");
		if ($filter_metodo_pago != '') {
			$query->where("a.`metodo_pago` = '".$db->escape($filter_metodo_pago)."'");
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
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{

			if (isset($item->pieza))
			{

				$values    = explode(',', $item->pieza);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('CONCAT(`#__servin_piezas2_3025077`.`descripcion`, \' \', `#__servin_piezas2_3025077`.`hechura`) AS `fk_value`')
						->from($db->quoteName('#__servin_piezas2', '#__servin_piezas2_3025077'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->fk_value;
					}
				}

				$item->pieza = !empty($textValue) ? implode(', ', $textValue) : $item->pieza;
			}

				$item->tipo = empty($item->tipo) ? '' : JText::_('COM_SERVIN2_VENTAS_TIPO_OPTION_' . strtoupper($item->tipo));

			if (isset($item->cliente))
			{

				$values    = explode(',', $item->cliente);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_clientes2_3025079`.`nombre`')
						->from($db->quoteName('#__servin_clientes2', '#__servin_clientes2_3025079'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$item->cliente = !empty($textValue) ? implode(', ', $textValue) : $item->cliente;
			}


			$item->metodo_pago = JText::_('COM_SERVIN2_VENTAS_METODO_PAGO_OPTION_' . strtoupper($item->metodo_pago));
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_SERVIN2_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	 *
	 * @param   string  $date  Date to be checked
	 *
	 * @return bool
	 */
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? Factory::getDate($date)->format("Y-m-d") : null;
	}
}
