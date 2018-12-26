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
 * Consignacion controller class.
 *
 * @since  1.6
 */
class Servin2ControllerConsignacion extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'consignaciones';
		parent::__construct();
	}
	public function save(){  
		//Obtener los objetos de la vista
	    $mainframe = JFactory::getApplication();
	    $datos = new Jregistry($mainframe -> input ->get('jform', '', 'array') );
	    $datos=$datos;
		$print=print_r( $datos, true);
		$mainframe->enqueueMessage ($print,'notice' );
		$db = JFactory::getDbo();
		switch ($datos['tipo_transaccion']) {
			case 0:
				//Compras
				$sql="select * from `#__servin_consignaciones2` WHERE id =".$datos['id'].";";
				$db->setQuery($sql);
				$result = $db->loadAssoc();	
				if($result['compras']!=$datos['compras']){
					$sql="update `#__servin_compras2` SET `pagada` = 1 WHERE id =".$result['compras'].";";
					$db->setQuery($sql);
			 	    $db->execute();
				}
				//La compra 3 se debe cambiar el estatus a 2-Consignacion
				$sql="update `#__servin_compras2` SET `pagada` = 2 WHERE id =".$datos['compras'].";";
				$db->setQuery($sql);
		 	    $db->execute();
		 	    //Si Selecciona abono
		 	    if($datos['abo_dev']==1){			
					//Cargar el abono tambien a la compra
					$sql="update `#__servin_compras2` SET `abonado` = ".$datos['abono']." WHERE id =".$datos['compras'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					//La consignacion seleccionada como abono debe ser marcada como abonada
					$sql="update `#__servin_consignaciones2` SET `estatus` = 4 WHERE id =".$datos['devoluciones'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					//Si el adeudo es igual a 0 
					if($datos['adeudo']<=0){
						//se marca comoo pagada e igual a la compra relacionada 
						$sql="update `#__servin_compras2` SET `pagada` = 1 WHERE id =".$datos['compras'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
					}
				}
				
				$print=print_r( $datos['devolucion'], true);
				$mainframe->enqueueMessage ($print,'notice' );
				
				

				break;
			case 1:
				//Ventas
			
				
				$sql="select * from `#__servin_consignaciones2` WHERE id =".$datos['id'].";";
				$db->setQuery($sql);
				$result = $db->loadAssoc();	
				$print=print_r( $result, true);
				$mainframe->enqueueMessage ($print,'notice' );
				}
				$sql="select * from `#__servin_consignaciones2` WHERE id =".$datos['id'].";";
				$db->setQuery($sql);
				$result = $db->loadAssoc();	
				if($result['ventas']!=$datos['ventas']){
					$sql="update `#__servin_ventas2` SET `pagada` = 1 WHERE id =".$result['ventas'].";";
					$db->setQuery($sql);
			 	    $db->execute();
				}
				//La venta 3 se debe cambiar el estatus a 2-Consignacion
				$sql="update `#__servin_ventas2` SET `pagada` = 2 WHERE id =".$datos['ventas'].";";
				$db->setQuery($sql);
		 	    $db->execute();

		 	    //Si Selecciona abono
		 	    if($datos['abo_dev']==1){			
					//Cargar el abono tambien a la venta
					$sql="update `#__servin_ventas2` SET `abonado` = ".$datos['abono']." WHERE id =".$datos['ventas'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					//La consignacion seleccionada como abono debe ser marcada como abonada
					$sql="update `#__servin_consignaciones2` SET `estatus` = 4 WHERE id =".$datos['devoluciones'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					//Si el adeudo es igual a 0 
					if($datos['adeudo']<=0){
						//se marca comoo pagada e igual a la venta relacionada 
						$sql="update `#__servin_ventas2` SET `pagada` = 1 WHERE id =".$datos['ventas'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
					}
				}
				
				
				break;
		}
		parent::save();   	
	}
}
