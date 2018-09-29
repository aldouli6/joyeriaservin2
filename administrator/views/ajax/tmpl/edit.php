<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Servin
 * @author     Aldo Ulises <aldouli6@gmail.com>
 * @copyright  2018 Aldo Ulises
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_servin/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.cliente').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('clientehidden')){
			js('#jform_cliente option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_cliente").trigger("liszt:updated");
	js('input:hidden.piezas').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('piezashidden')){
			js('#jform_piezas option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_piezas").trigger("liszt:updated");
	js('input:hidden.devoluciones').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('devolucioneshidden')){
			js('#jform_devoluciones option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_devoluciones").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'ajax.cancel') {
			Joomla.submitform(task, document.getElementById('ajax-form'));
		}
		else {
			
			if (task != 'ajax.cancel' && document.formvalidator.isValid(document.id('ajax-form'))) {
				
				Joomla.submitform(task, document.getElementById('ajax-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_servin&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="ajax-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SERVIN_TITLE_AJAX', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
