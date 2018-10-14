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
class Servin2ModelConsignaciones extends JModelList
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
				'no_folio_pagare', 'a.no_folio_pagare',
				'foto_pagare', 'a.foto_pagare',
				'tipo_transaccion', 'a.tipo_transaccion',
				'compras', 'a.compras',
				'ventas', 'a.ventas',
				'total', 'a.total',
				'abono', 'a.abono',
				'abo_dev', 'a.abo_dev',
				'devoluciones', 'a.devoluciones',
				'adeudo', 'a.adeudo',
				'fecha_emision', 'a.fecha_emision',
				'fecha_limite', 'a.fecha_limite',
				'devolucion', 'a.devolucion',
				'fecha_devolucion', 'a.fecha_devolucion',
				'estatus', 'a.estatus',
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

            $query->from('`#__servin_consignaciones2` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		// Join over the foreign key 'compras'
		$query->select('`#__servin_compras2_3109334`.`pieza` AS compras_fk_value_3109334');
		$query->join('LEFT', '#__servin_compras2 AS #__servin_compras2_3109334 ON #__servin_compras2_3109334.`id` = a.`compras`');
		// Join over the foreign key 'ventas'
		$query->select('`#__servin_ventas2_3109336`.`pieza` AS ventas_fk_value_3109336');
		$query->join('LEFT', '#__servin_ventas2 AS #__servin_ventas2_3109336 ON #__servin_ventas2_3109336.`id` = a.`ventas`');
		// Join over the foreign key 'devoluciones'
		$query->select('`#__servin_consignaciones2_3025097`.`no_folio_pagare` AS #__servin_consignaciones2_fk_value_3025097');
		$query->join('LEFT', '#__servin_consignaciones2 AS #__servin_consignaciones2_3025097 ON #__servin_consignaciones2_3025097.`id` = a.`devoluciones`');
            
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
				$query->where('( a.no_folio_pagare LIKE ' . $search . ' )');
                }
            }
            

		// Filtering compras
		$filter_compras = $this->state->get("filter.compras");

		if ($filter_compras)
		{
			$query->where("a.`compras` = '".$db->escape($filter_compras)."'");
		}

		// Filtering ventas
		$filter_ventas = $this->state->get("filter.ventas");

		if ($filter_ventas)
		{
			$query->where("a.`ventas` = '".$db->escape($filter_ventas)."'");
		}

		// Filtering fecha_emision
		$filter_fecha_emision_from = $this->state->get("filter.fecha_emision.from");

		if ($filter_fecha_emision_from !== null && !empty($filter_fecha_emision_from))
		{
			$query->where("a.`fecha_emision` >= '".$db->escape($filter_fecha_emision_from)."'");
		}
		$filter_fecha_emision_to = $this->state->get("filter.fecha_emision.to");

		if ($filter_fecha_emision_to !== null  && !empty($filter_fecha_emision_to))
		{
			$query->where("a.`fecha_emision` <= '".$db->escape($filter_fecha_emision_to)."'");
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

		// Filtering fecha_devolucion
		$filter_fecha_devolucion_from = $this->state->get("filter.fecha_devolucion.from");

		if ($filter_fecha_devolucion_from !== null && !empty($filter_fecha_devolucion_from))
		{
			$query->where("a.`fecha_devolucion` >= '".$db->escape($filter_fecha_devolucion_from)."'");
		}
		$filter_fecha_devolucion_to = $this->state->get("filter.fecha_devolucion.to");

		if ($filter_fecha_devolucion_to !== null  && !empty($filter_fecha_devolucion_to))
		{
			$query->where("a.`fecha_devolucion` <= '".$db->escape($filter_fecha_devolucion_to)."'");
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
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{
				$item->tipo_transaccion = empty($item->tipo_transaccion) ? '' : JText::_('COM_SERVIN2_CONSIGNACIONES_TIPO_TRANSACCION_OPTION_' . strtoupper($item->tipo_transaccion));

			if (isset($item->compras))
			{

				$values    = explode(',', $item->compras);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_compras2_3109334`.`pieza`')
						->from($db->quoteName('#__servin_compras2', '#__servin_compras2_3109334'))
						->where($db->quoteName('#__servin_compras2_3109334.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$item->compras = !empty($textValue) ? implode(', ', $textValue) : $item->compras;
			}


			if (isset($item->ventas))
			{

				$values    = explode(',', $item->ventas);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_ventas2_3109336`.`pieza`')
						->from($db->quoteName('#__servin_ventas2', '#__servin_ventas2_3109336'))
						->where($db->quoteName('#__servin_ventas2_3109336.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$item->ventas = !empty($textValue) ? implode(', ', $textValue) : $item->ventas;
			}

				$item->abo_dev = empty($item->abo_dev) ? '' : JText::_('COM_SERVIN2_CONSIGNACIONES_ABO_DEV_OPTION_' . strtoupper($item->abo_dev));

			if (isset($item->devoluciones))
			{

				$values    = explode(',', $item->devoluciones);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_consignaciones2_3025097`.`no_folio_pagare`')
						->from($db->quoteName('#__servin_consignaciones2', '#__servin_consignaciones2_3025097'))
						->where($db->quoteName('#__servin_consignaciones2_3025097.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->no_folio_pagare;
					}
				}

				$item->devoluciones = !empty($textValue) ? implode(', ', $textValue) : $item->devoluciones;
			}

				$item->estatus = empty($item->estatus) ? '' : JText::_('COM_SERVIN2_CONSIGNACIONES_ESTATUS_OPTION_' . strtoupper($item->estatus));
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
