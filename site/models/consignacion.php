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
class Servin2ModelConsignacion extends JModelItem
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
			$id = Factory::getApplication()->getUserState('com_servin2.edit.consignacion.id');
		}
		else
		{
			$id = Factory::getApplication()->input->get('id');
			Factory::getApplication()->setUserState('com_servin2.edit.consignacion.id', $id);
		}

		$this->setState('consignacion.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('consignacion.id', $params_array['item_id']);
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
                    $id = $this->getState('consignacion.id');
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
					$this->_item->tipo_transaccion = JText::_('COM_SERVIN2_CONSIGNACIONES_TIPO_TRANSACCION_OPTION_' . $this->_item->tipo_transaccion);

		if (isset($this->_item->compras) && $this->_item->compras != '')
		{
			if (is_object($this->_item->compras))
			{
				$this->_item->compras = ArrayHelper::fromObject($this->_item->compras);
			}

			$values = (is_array($this->_item->compras)) ? $this->_item->compras : explode(',',$this->_item->compras);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_compras2_3109334`.`pieza`')
					->from($db->quoteName('#__servin_compras2', '#__servin_compras2_3109334'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->pieza;
				}
			}

			$this->_item->compras = !empty($textValue) ? implode(', ', $textValue) : $this->_item->compras;

		}

		if (isset($this->_item->ventas) && $this->_item->ventas != '')
		{
			if (is_object($this->_item->ventas))
			{
				$this->_item->ventas = ArrayHelper::fromObject($this->_item->ventas);
			}

			$values = (is_array($this->_item->ventas)) ? $this->_item->ventas : explode(',',$this->_item->ventas);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_ventas2_3109336`.`pieza`')
					->from($db->quoteName('#__servin_ventas2', '#__servin_ventas2_3109336'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->pieza;
				}
			}

			$this->_item->ventas = !empty($textValue) ? implode(', ', $textValue) : $this->_item->ventas;

		}
					$this->_item->abo_dev = JText::_('COM_SERVIN2_CONSIGNACIONES_ABO_DEV_OPTION_' . $this->_item->abo_dev);

		if (isset($this->_item->devoluciones) && $this->_item->devoluciones != '')
		{
			if (is_object($this->_item->devoluciones))
			{
				$this->_item->devoluciones = ArrayHelper::fromObject($this->_item->devoluciones);
			}

			$values = (is_array($this->_item->devoluciones)) ? $this->_item->devoluciones : explode(',',$this->_item->devoluciones);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__servin_consignaciones2_3025097`.`no_folio_pagare`')
					->from($db->quoteName('#__servin_consignaciones2', '#__servin_consignaciones2_3025097'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->no_folio_pagare;
				}
			}

			$this->_item->devoluciones = !empty($textValue) ? implode(', ', $textValue) : $this->_item->devoluciones;

		}
					$this->_item->estatus = JText::_('COM_SERVIN2_CONSIGNACIONES_ESTATUS_OPTION_' . $this->_item->estatus);

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
	public function getTable($type = 'Consignacion', $prefix = 'Servin2Table', $config = array())
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
		$id = (!empty($id)) ? $id : (int) $this->getState('consignacion.id');
                
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
		$id = (!empty($id)) ? $id : (int) $this->getState('consignacion.id');

                
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
