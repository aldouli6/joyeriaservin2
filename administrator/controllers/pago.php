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
		$tabla='';
		switch ($datos['tipo']) {
			case '1':
				$tabla='consignacion';
				$plural='consignaciones';
				break;
			case '2':
				$tabla='compra';
				$plural='compras';
				break;
			case '3':
				$tabla='venta';
				$plural='ventas';
				break;
			
		}
		$sql="select * from `#__servin_".$plural."2` WHERE id =".$datos[$tabla].";";
		$db->setQuery($sql);
		$result = $db->loadAssoc();	
		$adeudo=$result['total']-$result['abonado'];
		if($datos['pago'] > $result['total']-$result['abonado'] ){
			$mainframe->enqueueMessage ('El monto de pago debe ser menor a '.$adeudo.'.','error' );
			$this->setRedirect('index.php?option=com_servin2&view=pago&layout=edit&id='.$datos['id']);
		}else{	
			switch ($datos['tipo']) {
				case '1':
					if ($datos['tipo_consignacion'] == '0') {
						$signo=' + ';
						$plural='compras';
					}else{
						$signo=' - ';
						$plural='ventas';
					}
						$sql="update `#__servin_consignaciones2` SET `abono` = abono + ".$datos['pago']." WHERE id =".$datos['consignacion'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
				 	    $sql="update `#__servin_consignaciones2` SET `adeudo` = total-abono WHERE id =".$datos['consignacion'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
				 	//     $print=print_r( $sql, true);
						// $mainframe->enqueueMessage ($print,'notice' );
						$sql="select total,compras,ventas, abono from  `#__servin_consignaciones2` WHERE id =".$datos['consignacion'].";";
						$db->setQuery($sql);
						$result = $db->loadAssoc();
						if($result['total']<=$result['abono']){
							$sql="update `#__servin_consignaciones2` SET `estatus` = 3 WHERE id =".$datos['consignacion'].";";
						    $db->setQuery($sql);
					 	    $db->execute();
					 	//     $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
							$sql="select id,compras,ventas from  `#__servin_consignaciones2` WHERE id =".$datos['consignacion'].";";
							// $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
							$db->setQuery($sql);
							$result = $db->loadAssoc();
							$sql="update `#__servin_".$plural."2` SET `pagada` = 1 WHERE id =".$result[$plural].";";
							// $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
						    $db->setQuery($sql);
					 	    $db->execute();
							$sql="update `#__servin_".$plural."2` SET `abonado` = total WHERE id =".$result[$plural].";";
							// $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
						    $db->setQuery($sql);
					 	    $db->execute();
							$sql="select total,cantidad,pieza, abonado from  `#__servin_".$plural."2` WHERE id =".$result[$plural].";";
							// $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
							$db->setQuery($sql);
							$result = $db->loadAssoc();
							$sql="update `#__servin_piezas2` SET `existencia` =  `existencia` ".$signo.$result['cantidad']." WHERE id =".$result['pieza'].";";
							// $print=print_r( $sql, true);
							// $mainframe->enqueueMessage ($print,'notice' );
						    $db->setQuery($sql);
					 	    $db->execute();
						}

					
					break;
				case '2':
					$sql="update `#__servin_compras2` SET `abonado` = abonado + ".$datos['pago']." WHERE id =".$datos['compra'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					$sql="select total,cantidad,pieza, abonado from  `#__servin_compras2` WHERE id =".$datos['compra'].";";
					$db->setQuery($sql);
					$result = $db->loadAssoc();					
					if($result['total']<=$result['abonado']){
						$sql="update `#__servin_compras2` SET `pagada` = 1 WHERE id =".$datos['compra'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
				 	    //agregar a exisencia
				 	    $sql="update `#__servin_piezas2` SET `existencia` =  `existencia` + ".$result['cantidad']." WHERE id =".$result['pieza'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
					}
					$this->setRedirect('index.php?option=com_servin2&view=pagos');
					break;
				case '3':
					$sql="update `#__servin_ventas2` SET `abonado` = abonado + ".$datos['pago']." WHERE id =".$datos['venta'].";";
				    $db->setQuery($sql);
			 	    $db->execute();
					$sql="select total,cantidad,pieza, abonado from  `#__servin_ventas2` WHERE id =".$datos['venta'].";";
					$db->setQuery($sql);
					$result = $db->loadAssoc();					
					if($result['total']<=$result['abonado']){
						$sql="update `#__servin_ventas2` SET `pagada` = 1 WHERE id =".$datos['venta'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
				 	    //agregar a exisencia
				 	    $sql="update `#__servin_piezas2` SET `existencia` =  `existencia` - ".$result['cantidad']." WHERE id =".$result['pieza'].";";
					    $db->setQuery($sql);
				 	    $db->execute();
					}
					$this->setRedirect('index.php?option=com_servin2&view=pagos');
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
}
