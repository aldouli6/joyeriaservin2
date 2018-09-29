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

<div class="pieza-edit front-end-edit">
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

		<form id="form-pieza"
			  action="<?php echo JRoute::_('index.php?option=com_servin2&task=pieza.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
				<?php echo $this->form->getInput('modified_at'); ?>
				<?php echo $this->form->getInput('created_at'); ?>
	<?php echo $this->form->renderField('descripcion'); ?>

	<?php echo $this->form->renderField('material'); ?>

	<?php foreach((array)$this->item->material as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="material" name="jform[materialhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('kilataje'); ?>

	<?php foreach((array)$this->item->kilataje as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="kilataje" name="jform[kilatajehidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('ubicacion'); ?>

	<?php foreach((array)$this->item->ubicacion as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="ubicacion" name="jform[ubicacionhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('hechura'); ?>

	<?php foreach((array)$this->item->hechura as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="hechura" name="jform[hechurahidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $this->form->renderField('tipo'); ?>

	<?php echo $this->form->renderField('gramos'); ?>

	<?php echo $this->form->renderField('piezas'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_servin2&task=piezaform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_servin2"/>
			<input type="hidden" name="task"
				   value="piezaform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
