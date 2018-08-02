<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin2
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Servin2 model.
 *
 * @since  1.6
 */
class Servin2ModelPieza extends JModelItem
{
    public $_item;

        
    
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return void
	 *
	 * @since    1.6
	 *
	 */
	protected function populateState()
	{
		$app  = Factory::getApplication('com_servin2');
		$user = Factory::getUser();

		// Check published state
		if ((!$user->authorise('core.edit.state', 'com_servin2')) && (!$user->authorise('core.edit', 'com_servin2')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}

		// Load state from the request userState on edit or from the passed variable on default
		if (Factory::getApplication()->input->get('layout') == 'edit')
		{
			$id = Factory::getApplication()->getUserState('com_servin2.edit.pieza.id');
		}
		else
		{
			$id = Factory::getApplication()->input->get('id');
			Factory::getApplication()->setUserState('com_servin2.edit.pieza.id', $id);
		}

		$this->setState('pieza.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('pieza.id', $params_array['item_id']);
		}

		$this->setState('params', $params);
	}

	/**
	 * Method to get an object.
	 *
	 * @param   integer $id The id of the object to get.
	 *
	 * @return  mixed    Object on success, false on failure.
     *
     * @throws Exception
	 */
	public function getItem($id = null)
	{
            if ($this->_item === null)
            {
                $this->_item = false;

                if (empty($id))
                {
                    $id = $this->getState('pieza.id');
                }

                // Get a level row instance.
                $table = $this->getTable();

                // Attempt to load the row.
                if ($table->load($id))
                {
                    

                    // Check published state.
                    if ($published = $this->getState('filter.published'))
                    {
                        if (isset($table->state) && $table->state != $published)
                        {
                            throw new Exception(JText::_('COM_SERVIN2_ITEM_NOT_LOADED'), 403);
                        }
                    }

                    // Convert the JTable to a clean JObject.
                    $properties  = $table->getProperties(1);
                    $this->_item = ArrayHelper::toObject($properties, 'JObject');

                    
                } 
            }
        
            

		if (isset($this->_item->created_by))
		{
			$this->_item->created_by_name = Factory::getUser($this->_item->created_by)->name;
		}

		if (isset($this->_item->modified_by))
		{
			$this->_item->modified_by_name = Factory::getUser($this->_item->modified_by)->name;
		}

		if (isset($this->_item->material) && $this->_item->material != '')
		{
			if (is_object($this->_item->material))
			{
				$this->_item->material = ArrayHelper::fromObject($this->_item->material);
			}

			$values = (is_array($this->_item->material)) ? $this->_item->material : explode(',',$this->_item->material);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_materiales2_3025006`.`nombre`')
					->from($db->quoteName('#__servin_materiales2', '#__servin_materiales2_3025006'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->nombre;
				}
			}

			$this->_item->material = !empty($textValue) ? implode(', ', $textValue) : $this->_item->material;

		}

		if (isset($this->_item->kilataje) && $this->_item->kilataje != '')
		{
			if (is_object($this->_item->kilataje))
			{
				$this->_item->kilataje = ArrayHelper::fromObject($this->_item->kilataje);
			}

			$values = (is_array($this->_item->kilataje)) ? $this->_item->kilataje : explode(',',$this->_item->kilataje);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_kilatajes2_3025007`.`kilataje`')
					->from($db->quoteName('#__servin_kilatajes2', '#__servin_kilatajes2_3025007'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->kilataje;
				}
			}

			$this->_item->kilataje = !empty($textValue) ? implode(', ', $textValue) : $this->_item->kilataje;

		}

		if (isset($this->_item->ubicacion) && $this->_item->ubicacion != '')
		{
			if (is_object($this->_item->ubicacion))
			{
				$this->_item->ubicacion = ArrayHelper::fromObject($this->_item->ubicacion);
			}

			$values = (is_array($this->_item->ubicacion)) ? $this->_item->ubicacion : explode(',',$this->_item->ubicacion);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_ubicaciones2_3025008`.`nombre`')
					->from($db->quoteName('#__servin_ubicaciones2', '#__servin_ubicaciones2_3025008'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->nombre;
				}
			}

			$this->_item->ubicacion = !empty($textValue) ? implode(', ', $textValue) : $this->_item->ubicacion;

		}

		if (isset($this->_item->hechura) && $this->_item->hechura != '')
		{
			if (is_object($this->_item->hechura))
			{
				$this->_item->hechura = ArrayHelper::fromObject($this->_item->hechura);
			}

			$values = (is_array($this->_item->hechura)) ? $this->_item->hechura : explode(',',$this->_item->hechura);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_hechuras2_3025009`.`numero`')
					->from($db->quoteName('#__servin_hechuras2', '#__servin_hechuras2_3025009'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->numero;
				}
			}

			$this->_item->hechura = !empty($textValue) ? implode(', ', $textValue) : $this->_item->hechura;

		}
					$this->_item->tipo = JText::_('COM_SERVIN2_PIEZAS_TIPO_OPTION_' . $this->_item->tipo);
					$this->_item->estatus = JText::_('COM_SERVIN2_PIEZAS_ESTATUS_OPTION_' . $this->_item->estatus);

            return $this->_item;
        }

	/**
	 * Get an instance of JTable class
	 *
	 * @param   string $type   Name of the JTable class to get an instance of.
	 * @param   string $prefix Prefix for the table class name. Optional.
	 * @param   array  $config Array of configuration values for the JTable object. Optional.
	 *
	 * @return  JTable|bool JTable if success, false on failure.
	 */
	public function getTable($type = 'Pieza', $prefix = 'Servin2Table', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_servin2/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the id of an item by alias
	 *
	 * @param   string $alias Item alias
	 *
	 * @return  mixed
	 */
	public function getItemIdByAlias($alias)
	{
            $table      = $this->getTable();
            $properties = $table->getProperties();
            $result     = null;

            if (key_exists('alias', $properties))
            {
                $table->load(array('alias' => $alias));
                $result = $table->id;
            }
            
                return $result;
            
	}

	/**
	 * Method to check in an item.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('pieza.id');
                
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
                
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('pieza.id');

                
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = Factory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
                
	}

	/**
	 * Publish the element
	 *
	 * @param   int $id    Item id
	 * @param   int $state Publish state
	 *
	 * @return  boolean
	 */
	public function publish($id, $state)
	{
		$table = $this->getTable();
                
		$table->load($id);
		$table->state = $state;

		return $table->store();
                
	}

	/**
	 * Method to delete an item
	 *
	 * @param   int $id Element id
	 *
	 * @return  bool
	 */
	public function delete($id)
	{
		$table = $this->getTable();

                
                    return $table->delete($id);
                
	}

	
}
