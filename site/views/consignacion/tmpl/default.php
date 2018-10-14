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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_servin2');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_servin2'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_NO_FOLIO_PAGARE'); ?></th>
			<td><?php echo $this->item->no_folio_pagare; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_FOTO_PAGARE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->foto_pagare as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'uploads' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_TIPO_TRANSACCION'); ?></th>
			<td><?php echo $this->item->tipo_transaccion; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_COMPRAS'); ?></th>
			<td><?php if( $this->item->tipo_transaccion == 0 ) echo $this->item->compras; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_VENTAS'); ?></th>
			<td><?php if( $this->item->tipo_transaccion == 1 ) echo $this->item->ventas; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_TOTAL'); ?></th>
			<td><?php echo $this->item->total; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_ABONO'); ?></th>
			<td><?php echo $this->item->abono; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_ABO_DEV'); ?></th>
			<td><?php echo $this->item->abo_dev; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_DEVOLUCIONES'); ?></th>
			<td><?php if( $this->item->abo_dev == 1 ) echo $this->item->devoluciones; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_ADEUDO'); ?></th>
			<td><?php echo $this->item->adeudo; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_FECHA_EMISION'); ?></th>
			<td><?php echo $this->item->fecha_emision; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_FECHA_LIMITE'); ?></th>
			<td><?php echo $this->item->fecha_limite; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_DEVOLUCION'); ?></th>
			<td><?php echo $this->item->devolucion; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_FECHA_DEVOLUCION'); ?></th>
			<td><?php if( $this->item->devolucion == 1 ) echo $this->item->fecha_devolucion; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SERVIN2_FORM_LBL_CONSIGNACION_ESTATUS'); ?></th>
			<td><?php echo $this->item->estatus; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_servin2&task=consignacion.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_SERVIN2_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_servin2.consignacion.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_SERVIN2_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_SERVIN2_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_SERVIN2_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_servin2&task=consignacion.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_SERVIN2_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>