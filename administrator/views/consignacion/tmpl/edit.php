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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_servin2/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.pieza').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('piezahidden')){
			js('#jform_pieza option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_pieza").trigger("liszt:updated");
	js('input:hidden.cliente').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('clientehidden')){
			js('#jform_cliente option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_cliente").trigger("liszt:updated");
	js('input:hidden.proveedor').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('proveedorhidden')){
			js('#jform_proveedor option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_proveedor").trigger("liszt:updated");
	js('input:hidden.devoluciones').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('devolucioneshidden')){
			js('#jform_devoluciones option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_devoluciones").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'consignacion.cancel') {
			Joomla.submitform(task, document.getElementById('consignacion-form'));
		}
		else {
			
			if (task != 'consignacion.cancel' && document.formvalidator.isValid(document.id('consignacion-form'))) {
				
				Joomla.submitform(task, document.getElementById('consignacion-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_servin2&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="consignacion-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SERVIN2_TITLE_CONSIGNACION', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>
				<?php echo $this->form->renderField('created_at'); ?>
				<?php echo $this->form->renderField('modified_at'); ?>				<?php echo $this->form->renderField('no_folio_pagare'); ?>
				<?php echo $this->form->renderField('foto_pagare'); ?>

				<?php if (!empty($this->item->foto_pagare)) : ?>
					<?php $foto_pagareFiles = array(); ?>
					<?php foreach ((array)$this->item->foto_pagare as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $foto_pagareFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[foto_pagare_hidden]" id="jform_foto_pagare_hidden" value="<?php echo implode(',', $foto_pagareFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('tipo_transaccion'); ?>
				<?php echo $this->form->renderField('pieza'); ?>

			<?php
				foreach((array)$this->item->pieza as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="pieza" name="jform[piezahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('cantidad'); ?>
				<?php echo $this->form->renderField('cliente'); ?>

			<?php
				foreach((array)$this->item->cliente as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="cliente" name="jform[clientehidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('proveedor'); ?>

			<?php
				foreach((array)$this->item->proveedor as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="proveedor" name="jform[proveedorhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('total'); ?>
				<?php echo $this->form->renderField('abono'); ?>
				<?php echo $this->form->renderField('abo_dev'); ?>
				<?php echo $this->form->renderField('devoluciones'); ?>

			<?php
				foreach((array)$this->item->devoluciones as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="devoluciones" name="jform[devolucioneshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('adeudo'); ?>
				<?php echo $this->form->renderField('fecha_emision'); ?>
				<?php echo $this->form->renderField('fecha_limite'); ?>
				<?php echo $this->form->renderField('devolucion'); ?>
				<?php echo $this->form->renderField('fecha_devolucion'); ?>
				<?php echo $this->form->renderField('estatus'); ?>


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
