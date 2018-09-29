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
class Servin2ModelPiezas extends JModelList
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
				'modified_at', 'a.modified_at',
				'created_at', 'a.created_at',
				'descripcion', 'a.descripcion',
				'material', 'a.material',
				'kilataje', 'a.kilataje',
				'ubicacion', 'a.ubicacion',
				'hechura', 'a.hechura',
				'tipo', 'a.tipo',
				'gramos', 'a.gramos',
				'piezas', 'a.piezas',
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

            $query->from('`#__servin_piezas2` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		// Join over the foreign key 'material'
		$query->select('`#__servin_materiales2_3025006`.`nombre` AS materiales_fk_value_3025006');
		$query->join('LEFT', '#__servin_materiales2 AS #__servin_materiales2_3025006 ON #__servin_materiales2_3025006.`id` = a.`material`');
		// Join over the foreign key 'kilataje'
		$query->select('`#__servin_kilatajes2_3025007`.`kilataje` AS kilatajes_fk_value_3025007');
		$query->join('LEFT', '#__servin_kilatajes2 AS #__servin_kilatajes2_3025007 ON #__servin_kilatajes2_3025007.`id` = a.`kilataje`');
		// Join over the foreign key 'ubicacion'
		$query->select('`#__servin_ubicaciones2_3025008`.`nombre` AS ubicaciones_fk_value_3025008');
		$query->join('LEFT', '#__servin_ubicaciones2 AS #__servin_ubicaciones2_3025008 ON #__servin_ubicaciones2_3025008.`id` = a.`ubicacion`');
		// Join over the foreign key 'hechura'
		$query->select('`#__servin_hechuras2_3025009`.`numero` AS hechuras_fk_value_3025009');
		$query->join('LEFT', '#__servin_hechuras2 AS #__servin_hechuras2_3025009 ON #__servin_hechuras2_3025009.`id` = a.`hechura`');
            
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
				$query->where('( a.descripcion LIKE ' . $search . '  OR #__servin_materiales2_3025006.nombre LIKE ' . $search . '  OR #__servin_kilatajes2_3025007.kilataje LIKE ' . $search . '  OR #__servin_ubicaciones2_3025008.nombre LIKE ' . $search . '  OR #__servin_hechuras2_3025009.numero LIKE ' . $search . ' )');
                }
            }
            

		// Filtering material
		$filter_material = $this->state->get("filter.material");

		if ($filter_material)
		{
			$query->where("a.`material` = '".$db->escape($filter_material)."'");
		}

		// Filtering kilataje
		$filter_kilataje = $this->state->get("filter.kilataje");

		if ($filter_kilataje)
		{
			$query->where("a.`kilataje` = '".$db->escape($filter_kilataje)."'");
		}

		// Filtering ubicacion
		$filter_ubicacion = $this->state->get("filter.ubicacion");

		if ($filter_ubicacion)
		{
			$query->where("a.`ubicacion` = '".$db->escape($filter_ubicacion)."'");
		}

		// Filtering hechura
		$filter_hechura = $this->state->get("filter.hechura");

		if ($filter_hechura)
		{
			$query->where("a.`hechura` = '".$db->escape($filter_hechura)."'");
		}

		// Filtering tipo
		$filter_tipo = $this->state->get("filter.tipo");

		if ($filter_tipo !== null && (is_numeric($filter_tipo) || !empty($filter_tipo)))
		{
			$query->where("a.`tipo` = '".$db->escape($filter_tipo)."'");
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

			if (isset($item->material))
			{

				$values    = explode(',', $item->material);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_materiales2_3025006`.`nombre`')
						->from($db->quoteName('#__servin_materiales2', '#__servin_materiales2_3025006'))
						->where($db->quoteName('#__servin_materiales2_3025006.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$item->material = !empty($textValue) ? implode(', ', $textValue) : $item->material;
			}


			if (isset($item->kilataje))
			{

				$values    = explode(',', $item->kilataje);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_kilatajes2_3025007`.`kilataje`')
						->from($db->quoteName('#__servin_kilatajes2', '#__servin_kilatajes2_3025007'))
						->where($db->quoteName('#__servin_kilatajes2_3025007.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->kilataje;
					}
				}

				$item->kilataje = !empty($textValue) ? implode(', ', $textValue) : $item->kilataje;
			}


			if (isset($item->ubicacion))
			{

				$values    = explode(',', $item->ubicacion);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_ubicaciones2_3025008`.`nombre`')
						->from($db->quoteName('#__servin_ubicaciones2', '#__servin_ubicaciones2_3025008'))
						->where($db->quoteName('#__servin_ubicaciones2_3025008.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$item->ubicacion = !empty($textValue) ? implode(', ', $textValue) : $item->ubicacion;
			}


			if (isset($item->hechura))
			{

				$values    = explode(',', $item->hechura);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_hechuras2_3025009`.`numero`')
						->from($db->quoteName('#__servin_hechuras2', '#__servin_hechuras2_3025009'))
						->where($db->quoteName('#__servin_hechuras2_3025009.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->numero;
					}
				}

				$item->hechura = !empty($textValue) ? implode(', ', $textValue) : $item->hechura;
			}

				$item->tipo = empty($item->tipo) ? '' : JText::_('COM_SERVIN2_PIEZAS_TIPO_OPTION_' . strtoupper($item->tipo));
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
