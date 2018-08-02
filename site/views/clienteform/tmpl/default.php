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

<div class="cliente-edit front-end-edit">
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

		<form id="form-cliente"
			  action="<?php echo JRoute::_('index.php?option=com_servin2&task=cliente.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('nombre'); ?>

	<?php echo $this->form->renderField('direccion'); ?>

	<?php echo $this->form->renderField('telefono'); ?>

	<?php echo $this->form->renderField('correo'); ?>

	<?php echo $this->form->renderField('fotoine'); ?>

				<?php if (!empty($this->item->fotoine)) : ?>
					<?php $fotoineFiles = array(); ?>
					<?php foreach ((array)$this->item->fotoine as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $fotoineFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[fotoine_hidden]" id="jform_fotoine_hidden" value="<?php echo implode(',', $fotoineFiles); ?>" />
	<?php echo $this->form->renderField('fotocomprobante'); ?>

				<?php if (!empty($this->item->fotocomprobante)) : ?>
					<?php $fotocomprobanteFiles = array(); ?>
					<?php foreach ((array)$this->item->fotocomprobante as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $fotocomprobanteFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[fotocomprobante_hidden]" id="jform_fotocomprobante_hidden" value="<?php echo implode(',', $fotocomprobanteFiles); ?>" />
			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_servin2&task=clienteform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_servin2"/>
			<input type="hidden" name="task"
				   value="clienteform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
