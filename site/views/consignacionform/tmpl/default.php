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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_servin2', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_servin2/js/form.js');

$user    = JFactory::getUser();
$canEdit = Servin2HelpersServin2::canUserEdit($this->item, $user);


?>

<div class="consignacion-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_SERVIN2_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_SERVIN2_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_SERVIN2_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-consignacion"
			  action="<?php echo JRoute::_('index.php?option=com_servin2&task=consignacion.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
				<?php echo $this->form->getInput('created_at'); ?>
				<?php echo $this->form->getInput('modified_at'); ?>
	<?php echo $this->form->renderField('no_folio_pagare'); ?>

	<?php echo $this->form->renderField('foto_pagare'); ?>

				<?php if (!empty($this->item->foto_pagare)) : ?>
					<?php $foto_pagareFiles = array(); ?>
					<?php foreach ((array)$this->item->foto_pagare as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $foto_pagareFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[foto_pagare_hidden]" id="jform_foto_pagare_hidden" value="<?php echo implode(',', $foto_pagareFiles); ?>" />
	<?php echo $this->form->renderField('tipo_transaccion'); ?>

	<?php echo $this->form->renderField('tipo'); ?>

	<?php echo $this->form->renderField('pieza'); ?>

	<?php foreach((array)$this->item->pieza as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="pieza" name="jform[piezahidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('piezas'); ?>

	<?php echo $this->form->renderField('gramos'); ?>

	<?php echo $this->form->renderField('cliente'); ?>

	<?php foreach((array)$this->item->cliente as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="cliente" name="jform[clientehidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('proveedor'); ?>

	<?php foreach((array)$this->item->proveedor as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="proveedor" name="jform[proveedorhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('total'); ?>

	<?php echo $this->form->renderField('abono'); ?>

	<?php echo $this->form->renderField('abo_dev'); ?>

	<?php echo $this->form->renderField('devoluciones'); ?>

	<?php foreach((array)$this->item->devoluciones as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="devoluciones" name="jform[devolucioneshidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('adeudo'); ?>

	<?php echo $this->form->renderField('fecha_emision'); ?>

	<?php echo $this->form->renderField('fecha_limite'); ?>

	<?php echo $this->form->renderField('devolucion'); ?>

	<?php echo $this->form->renderField('fecha_devolucion'); ?>

	<?php echo $this->form->renderField('estatus'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_servin2&task=consignacionform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_servin2"/>
			<input type="hidden" name="task"
				   value="consignacionform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
