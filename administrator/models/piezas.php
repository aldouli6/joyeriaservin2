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
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'modified_at', 'a.`modified_at`',
				'created_at', 'a.`created_at`',
				'descripcion', 'a.`descripcion`',
				'material', 'a.`material`',
				'kilataje', 'a.`kilataje`',
				'ubicacion', 'a.`ubicacion`',
				'hechura', 'a.`hechura`',
				'tipo', 'a.`tipo`',
				'gramos', 'a.`gramos`',
				'piezas', 'a.`piezas`',
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
		// Filtering material
		$this->setState('filter.material', $app->getUserStateFromRequest($this->context.'.filter.material', 'filter_material', '', 'string'));

		// Filtering kilataje
		$this->setState('filter.kilataje', $app->getUserStateFromRequest($this->context.'.filter.kilataje', 'filter_kilataje', '', 'string'));

		// Filtering ubicacion
		$this->setState('filter.ubicacion', $app->getUserStateFromRequest($this->context.'.filter.ubicacion', 'filter_ubicacion', '', 'string'));

		// Filtering hechura
		$this->setState('filter.hechura', $app->getUserStateFromRequest($this->context.'.filter.hechura', 'filter_hechura', '', 'string'));

		// Filtering tipo
		$this->setState('filter.tipo', $app->getUserStateFromRequest($this->context.'.filter.tipo', 'filter_tipo', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_servin2');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.descripcion', 'asc');
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
		$query->from('`#__servin_piezas2` AS a');
                

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
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
				$query->where('( a.descripcion LIKE ' . $search . '  OR #__servin_materiales2_3025006.nombre LIKE ' . $search . '  OR #__servin_kilatajes2_3025007.kilataje LIKE ' . $search . '  OR #__servin_ubicaciones2_3025008.nombre LIKE ' . $search . '  OR #__servin_hechuras2_3025009.numero LIKE ' . $search . '  OR  a.gramos LIKE ' . $search . ' )');
			}
		}
                

		// Filtering material
		$filter_material = $this->state->get("filter.material");

		if ($filter_material !== null && !empty($filter_material))
		{
			$query->where("a.`material` = '".$db->escape($filter_material)."'");
		}

		// Filtering kilataje
		$filter_kilataje = $this->state->get("filter.kilataje");

		if ($filter_kilataje !== null && !empty($filter_kilataje))
		{
			$query->where("a.`kilataje` = '".$db->escape($filter_kilataje)."'");
		}

		// Filtering ubicacion
		$filter_ubicacion = $this->state->get("filter.ubicacion");

		if ($filter_ubicacion !== null && !empty($filter_ubicacion))
		{
			$query->where("a.`ubicacion` = '".$db->escape($filter_ubicacion)."'");
		}

		// Filtering hechura
		$filter_hechura = $this->state->get("filter.hechura");

		if ($filter_hechura !== null && !empty($filter_hechura))
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
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
                
		foreach ($items as $oneItem)
		{

			if (isset($oneItem->material))
			{
				$values    = explode(',', $oneItem->material);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_materiales2_3025006`.`nombre`')
						->from($db->quoteName('#__servin_materiales2', '#__servin_materiales2_3025006'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$oneItem->material = !empty($textValue) ? implode(', ', $textValue) : $oneItem->material;
			}

			if (isset($oneItem->kilataje))
			{
				$values    = explode(',', $oneItem->kilataje);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_kilatajes2_3025007`.`kilataje`')
						->from($db->quoteName('#__servin_kilatajes2', '#__servin_kilatajes2_3025007'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->kilataje;
					}
				}

				$oneItem->kilataje = !empty($textValue) ? implode(', ', $textValue) : $oneItem->kilataje;
			}

			if (isset($oneItem->ubicacion))
			{
				$values    = explode(',', $oneItem->ubicacion);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_ubicaciones2_3025008`.`nombre`')
						->from($db->quoteName('#__servin_ubicaciones2', '#__servin_ubicaciones2_3025008'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->nombre;
					}
				}

				$oneItem->ubicacion = !empty($textValue) ? implode(', ', $textValue) : $oneItem->ubicacion;
			}

			if (isset($oneItem->hechura))
			{
				$values    = explode(',', $oneItem->hechura);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__servin_hechuras2_3025009`.`numero`')
						->from($db->quoteName('#__servin_hechuras2', '#__servin_hechuras2_3025009'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->numero;
					}
				}

				$oneItem->hechura = !empty($textValue) ? implode(', ', $textValue) : $oneItem->hechura;
			}
					$oneItem->tipo = ($oneItem->tipo == '') ? '' : JText::_('COM_SERVIN2_PIEZAS_TIPO_OPTION_' . strtoupper($oneItem->tipo));
		}

		return $items;
	}
}
