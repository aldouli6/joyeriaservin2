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
 * Pago controller class.
 *
 * @since  1.6
 */
class Servin2ControllerPago extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'pagos';
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
		switch ($datos['tipo']) {
			case '1':

				break;
			case '2':
				$sql="update `#__servin_compras2` SET `abonado` = abonado + ".$datos['pago']." WHERE id =".$datos['compra'].";";
			    $db->setQuery($sql);
		 	    $db->execute();
				$sql="select total, abonado from  `#__servin_compras2` WHERE id =".$datos['compra'].";";
				$db->setQuery($sql);
				$result = $db->loadAssoc();					
				if($result['total']<=$result['abonado']){
					$sql="update `#__servin_compras2` SET `pagada` = 1 WHERE id =".$datos['compra'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
				}
				$this->setRedirect('index.php?option=com_servin2&view=pagos');
				break;
			case '3':
				# code...
				break;
			default:
				# code...
				break;
		}
		// if($datos['id']>0){
		// 	
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
