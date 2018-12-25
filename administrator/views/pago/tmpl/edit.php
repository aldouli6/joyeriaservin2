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
	if (!'<?php print_r($this->item->consignacion) ?>') {		
		bloquearchzc('#jform_consignacion');	
	}

	function bloquearchzc(cadena){
 		js(cadena+'_chzn').addClass('chzn-disabled');
	    js(cadena).attr('disabled','disabled');	    	
 		js(cadena).trigger("liszt:updated");
 	}
	function desbloquearchzc(cadena){
 		js(cadena+'_chzn').removeClass('chzn-disabled');
	    js(cadena).removeAttr('disabled');    	
 		js(cadena).trigger("liszt:updated");
 	}
 	function llenarconsigpermitidas(value){
 		js.ajax({ 
	            url: "index.php?option=com_servin2&task=consigpermitidas&view=ajaxs&tmpl=ajax&id=" + value,  
	            async: true, 
	            success: function(result){
	            var obj = result;
				objeto = JSON.parse(obj);
            	console.log(objeto); 
            	js('#jform_consignacion').empty();
            	js("#jform_consignacion").append('<option abonado="" value="">Selecciona una opción</option>');
            	js.each( objeto, function( key, value ) {
            		var s = (value['id']=="<?php print_r($this->item->consignacion) ?>")?'selected="selected"':"";
            		js("#jform_consignacion").append('<option '+s+' abonado="'+value['abono']+'" value="'+value['id']+'">'+value['descripcion']+'</option>');
				});
				js("#jform_consignacion").trigger("liszt:updated");

            	},
	            error: function(result) {
	                console.log(result);
	            }
	    	});
 	}		
 	function clearselects(){
 		js('#jform_compra').prop("selectedIndex",-1); 
 		js('#jform_venta').prop("selectedIndex",-1); 
 		js('#jform_consignacion').prop("selectedIndex",-1); 
 		js("label[for='jform_tipo_consignacion1']").removeClass('active btn-success');
 		js("label[for='jform_tipo_consignacion0']").removeClass('active btn-danger');
 		js('input:radio[name="jform[tipo_consignacion]"][value=0]').removeAttr('checked');
 		js('input:radio[name="jform[tipo_consignacion]"][value=1]').removeAttr('checked');
 		js("#jform_compra").trigger("liszt:updated");
 		js("#jform_venta").trigger("liszt:updated");
 		js("#jform_consignacion").trigger("liszt:updated");
 		bloquearchzc('#jform_consignacion');
 	}
	js('#jform_tipo_consignacion').change(function() {
		var radio=js("#jform_tipo_consignacion input[type='radio']:checked").val();
		desbloquearchzc('#jform_consignacion');
		llenarconsigpermitidas(radio);
	});

	js('.comprasventas').change(function() {
		js('#jform_pago').removeAttr("max");
		js('#jform_pago').val("");
		var cadena1 = js(this).find(":selected").text();
		var cadena2 = cadena1.slice(cadena1.lastIndexOf("|")+2, cadena1.length);
		js('#jform_pago').attr("max", cadena2 );
		js('#lbldatos').text('Solo se pueden pagar '+cadena2+' pesos');
		
	});

	js('#jform_tipo').change(function() {
		clearselects();
		js('#jform_pago').removeAttr("max");
		js('#jform_pago').val("");
		js('#lbldatos').text('');
	});
	js('input:hidden.compra').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('comprahidden')){
			js('#jform_compra option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_compra").trigger("liszt:updated");
	js('input:hidden.consignacion').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('consignacionhidden')){
			js('#jform_consignacion option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_consignacion").trigger("liszt:updated");
	js('input:hidden.venta').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('ventahidden')){
			js('#jform_venta option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_venta").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'pago.cancel') {
			Joomla.submitform(task, document.getElementById('pago-form'));
		}
		else {
			
			if (task != 'pago.cancel' && document.formvalidator.isValid(document.id('pago-form'))) {
				
				Joomla.submitform(task, document.getElementById('pago-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_servin2&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="pago-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SERVIN2_TITLE_PAGO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('tipo'); ?>
				<?php echo $this->form->renderField('tipo_consignacion'); ?>
				<?php echo $this->form->renderField('compra'); ?>

			<?php
				foreach((array)$this->item->compra as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="compra" name="jform[comprahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('consignacion'); ?>

			<?php
				foreach((array)$this->item->consignacion as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="consignacion" name="jform[consignacionhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('venta'); ?>

			<?php
				foreach((array)$this->item->venta as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="venta" name="jform[ventahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<div class="control-group"> 
			<div class="control-label">
			</div>
				<div class="controls">
					<label id="lbldatos"></label>
				</div>
			</div>
							<?php echo $this->form->renderField('pago'); ?>
				<?php echo $this->form->renderField('metodo'); ?>
				<?php echo $this->form->renderField('datos_pago'); ?>
				<?php echo $this->form->renderField('fecha'); ?>


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
