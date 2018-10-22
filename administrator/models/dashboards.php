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
class Servin2ModelDashboards extends JModelList
{
    
        
    
        
    
        
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

		// Load the parameters.
		$params = JComponentHelper::getParams('com_servin2');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.tipo', 'asc');

        parent::populateState($ordering, $direction);

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
		$db	= $this->getDbo();
		$query	= $db->getQuery(true);

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
					$oneItem->tipo_consignacion = ($oneItem->tipo_consignacion == '') ? '' : JText::_('COM_SERVIN2_PAGOS_TIPO_CONSIGNACION_OPTION_' . strtoupper($oneItem->tipo_consignacion));

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
						->where($db->quoteName('#__servin_compras2_3076251.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->pieza;
					}
				}

				$oneItem->compra = !empty($textValue) ? implode(', ', $textValue) : $oneItem->compra;
			}

			if (isset($oneItem->consignacion))
			{
				$values    = explode(',', $oneItem->consignacion);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
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

				$oneItem->consignacion = !empty($textValue) ? implode(', ', $textValue) : $oneItem->consignacion;
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
						->where($db->quoteName('#__servin_ventas2_3076252.id') . ' = '. $db->quote($db->escape($value)));

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
