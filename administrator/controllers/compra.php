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
 * Compra controller class.
 *
 * @since  1.6
 */
class Servin2ControllerCompra extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'compras';
		parent::__construct();
	}
	public function save(){  
		//Obtener los objetos de la vista
	    $mainframe = JFactory::getApplication();
	    $datos = new Jregistry($mainframe -> input ->get('jform', '', 'array') );
	    $datos=$datos;
		//$print=print_r( $datos, true);
		//$mainframe->enqueueMessage ($print,'notice' );
		// if($datos['id']>0){
		// 	$db = JFactory::getDbo();
		// 	$query='select id, ordering, state, checked_out, checked_out_time,created_by,modified_by,rfc,razon_social,calle,no_ext,no_int,no_int,cp,colonia,ciudad,municipio,estado,email from #__condo_dir_factur WHERE id ='.$datos['id'].';';
		// 	$db->setQuery($query);
		// 	$result = $db->loadAssoc();	
		// 	/*$print=print_r( $result, true);
		// 	$mainframe->enqueueMessage ($print,'notice' );*/
		// 	unset($datos['actualizado']);
		// 	if($result!=$datos){
		// 		$sql="update `#__condo_dir_factur` SET `actualizado` = 0 WHERE id =".$datos['id'].";";
		// 	    $db->setQuery($sql);
		// 	    $db->execute();
		// 	}
		// }	
		parent::save();   	
	}
}
