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
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'tipo', 'a.tipo',
				'tipo_consignacion', 'a.tipo_consignacion',
				'compra', 'a.compra',
				'consignacion', 'a.consignacion',
				'venta', 'a.venta',
				'pago', 'a.pago',
				'metodo', 'a.metodo',
				'datos_pago', 'a.datos_pago',
				'fecha', 'a.fecha',
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

            $query->from('`#__servin_pagos2` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		// Join over the foreign key 'compra'
		$query->select('`#__servin_compras2_3076251`.`pieza` AS compras_fk_value_3076251');
		$query->join('LEFT', '#__servin_compras2 AS #__servin_compras2_3076251 ON #__servin_compras2_3076251.`id` = a.`compra`');
		// Join over the foreign key 'consignacion'
		$query->select('`#__servin_consignaciones2_3109333`.`no_folio_pagare` AS consignaciones_fk_value_3109333');
		$query->join('LEFT', '#__servin_consignaciones2 AS #__servin_consignaciones2_3109333 ON #__servin_consignaciones2_3109333.`id` = a.`consignacion`');
		// Join over the foreign key 'venta'
		$query->select('`#__servin_ventas2_3076252`.`pieza` AS ventas_fk_value_3076252');
		$query->join('LEFT', '#__servin_ventas2 AS #__servin_ventas2_3076252 ON #__servin_ventas2_3076252.`id` = a.`venta`');
            
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
				$query->where('(#__servin_consignaciones2_3109333.no_folio_pagare LIKE ' . $search . ' )');
                }
            }
            

		// Filtering tipo
		$filter_tipo = $this->state->get("filter.tipo");

		if ($filter_tipo !== null && (is_numeric($filter_tipo) || !empty($filter_tipo)))
		{
			$query->where("a.`tipo` = '".$db->escape($filter_tipo)."'");
		}

		// Filtering tipo_consignacion
		$filter_tipo_consignacion = $this->state->get("filter.tipo_consignacion");

		if ($filter_tipo_consignacion !== null && (is_numeric($filter_tipo_consignacion) || !empty($filter_tipo_consignacion)))
		{
			$query->where("a.`tipo_consignacion` = '".$db->escape($filter_tipo_consignacion)."'");
		}

		// Filtering compra
		$filter_compra = $this->state->get("filter.compra");

		if ($filter_compra)
		{
			$query->where("a.`compra` = '".$db->escape($filter_compra)."'");
		}

		// Filtering consignacion
		$filter_consignacion = $this->state->get("filter.consignacion");

		if ($filter_consignacion)
		{
			$query->where("a.`consignacion` = '".$db->escape($filter_consignacion)."'");
		}

		// Filtering venta
		$filter_venta = $this->state->get("filter.venta");

		if ($filter_venta)
		{
			$query->where("a.`venta` = '".$db->escape($filter_venta)."'");
		}

		// Filtering metodo
		$filter_metodo = $this->state->get("filter.metodo");
		if ($filter_metodo != '') {
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
            $orderCol  = $this->state->get('list.ordering', 'id');
            $orderDirn = $this->state->get('list.direction', 'ASC');

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
				$item->tipo = empty($item->tipo) ? '' : JText::_('COM_SERVIN2_PAGOS_TIPO_OPTION_' . strtoupper($item->tipo));
				$item->tipo_consignacion = empty($item->tipo_consignacion) ? '' : JText::_('COM_SERVIN2_PAGOS_TIPO_CONSIGNACION_OPTION_' . strtoupper($item->tipo_consignacion));

			if (isset($item->compra))
			{

				$values    = explode(',', $item->compra);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_compras2_3076251`.`pieza`')
						->from($db->quoteName('#__servin_compras2', '#__servin_compras2_3076251'))
						->where($db->quoteName('#__servin_compras2_3076251.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$item->compra = !empty($textValue) ? implode(', ', $textValue) : $item->compra;
			}


			if (isset($item->consignacion))
			{

				$values    = explode(',', $item->consignacion);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_consignaciones2_3109333`.`no_folio_pagare`')
						->from($db->quoteName('#__servin_consignaciones2', '#__servin_consignaciones2_3109333'))
						->where($db->quoteName('#__servin_consignaciones2_3109333.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->no_folio_pagare;
					}
				}

				$item->consignacion = !empty($textValue) ? implode(', ', $textValue) : $item->consignacion;
			}


			if (isset($item->venta))
			{

				$values    = explode(',', $item->venta);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_ventas2_3076252`.`pieza`')
						->from($db->quoteName('#__servin_ventas2', '#__servin_ventas2_3076252'))
						->where($db->quoteName('#__servin_ventas2_3076252.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$item->venta = !empty($textValue) ? implode(', ', $textValue) : $item->venta;
			}


			$item->metodo = JText::_('COM_SERVIN2_PAGOS_METODO_OPTION_' . strtoupper($item->metodo));
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
