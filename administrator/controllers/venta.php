<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin2
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Venta controller class.
 *
 * @since  1.6
 */
class Servin2ControllerVenta extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'ventas';
		parent::__construct();
	}
	public function save(){  
		//Obtener los objetos de la vista
	    $mainframe = JFactory::getApplication();
	    $datos = new Jregistry($mainframe -> input ->get('jform', '', 'array') );
	    $datos=$datos;
		//$print=print_r( $datos, true);
		//$mainframe->enqueueMessage ($print,'notice' );
		$db = JFactory::getDbo();
		$sql="select * from `#__servin_piezas2` WHERE id =".$datos['pieza'].";";
		$db->setQuery($sql);
		$result = $db->loadAssoc();	
		if($datos['cantidad']>$result['existencia']){
			$mainframe->enqueueMessage ('No se cuentan con las existencias suficientes para generar la venta.','error' );
			$this->setRedirect('index.php?option=com_servin2&view=venta&layout=edit&id='.$datos['id']);
		}else{
			parent::save(); 	
		}	
		  	
	}
}
