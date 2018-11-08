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
	if (!'<?php print_r($this->item->compras) ?>' || !'<?php print_r($this->item->ventas) ?>') {
		var value = js("input[name='jform[tipo_transaccion]']:checked").val();
    	llenarconsigpermitidas(value);

	}
	function consultatotal(tabla,id){
 		js.ajax({ 
	            url: "index.php?option=com_servin2&task=consultatotal&view=ajaxs&tmpl=ajax&id=" + id + "&string="+tabla,  
	            async: true, 
	            success: function(result){
	            var obj = result;
				var objeto = JSON.parse(obj);
            	console.log(objeto);
            	js('#jform_total').val(parseFloat(objeto['total']).toFixed(2));
            	js('#jform_abono').val(parseFloat(objeto['abonado']).toFixed(2));    	
            	js('#jform_adeudo').val(parseFloat(objeto['adeudo']).toFixed(2)); 
            	js('.abo_dev').parent().parent().show();     	
            	},
	            error: function(result) {
	                console.log(result);
	            }
	    	});
 	}
 	function llenarconsigpermitidas(value){
 		js.ajax({ 
	            url: "index.php?option=com_servin2&task=consigpermitidas&view=ajaxs&tmpl=ajax&id=" + value,  
	            async: true, 
	            success: function(result){
	            var obj = result;
				objeto = JSON.parse(obj);
            	console.log(objeto); 
            	js('#jform_devoluciones').empty();
            	js("#jform_devoluciones").append('<option abonado="" value="">Selecciona una opción</option>');
            	js.each( objeto, function( key, value ) {
            		var s = (value['id']=="<?php print_r($this->item->devoluciones) ?>")?'selected="selected"':"";
            		js("#jform_devoluciones").append('<option '+s+' abonado="'+value['abono']+'" value="'+value['id']+'">'+value['descripcion']+'</option>');
				});
				js("#jform_devoluciones").trigger("liszt:updated");

            	},
	            error: function(result) {
	                console.log(result);
	            }
	    	});
 	}
 	function clearselects(){
 		js('#jform_compras').prop("selectedIndex",-1);
 		js('#jform_ventas').prop("selectedIndex",-1);
 		js('#jform_total').val('');
 		js('#jform_abono').val('');
 		js('input:radio[name="jform[abo_dev]"][value=0]').click();
 		js('input:radio[name="jform[abo_dev]"][value=0]').attr('checked', true);
 		js("label[for='jform_abo_dev0']").addClass('active btn-danger');
 		js('input:radio[name="jform[abo_dev]"][value=1]').removeAttr('checked');
 		js("label[for='jform_abo_dev1']").removeClass('active btn-success');
 		
 		js('#jform_devoluciones').prop("selectedIndex",-1);
		js("#jform_devoluciones").trigger("liszt:updated");
 		js("#jform_compras").trigger("liszt:updated");
 		js("#jform_ventas").trigger("liszt:updated");
 		js('.abo_dev').parent().parent().hide();   
 	}
 	function devolucionesmas(){
 		 var abonado_actual = parseFloat(js('#jform_abono').val() ).toFixed(2);
		var abonado_devo = parseFloat(js('#jform_devoluciones').children("option:selected").attr('abonado')).toFixed(2);;
		var abonototal = (parseFloat(abonado_actual)+parseFloat(abonado_devo)).toFixed(2);
 		js('#jform_abono').val( abonototal);
 		js('#jform_adeudo').val((parseFloat(js('#jform_total').val())-parseFloat(abonototal)).toFixed(2) );
 	}
 	js('#jform_compras').change(function(){
	    consultatotal('compras2', js(this).val());
	});
	js('#jform_ventas').change(function(){
	    consultatotal('ventas2', js(this).val());
	});
	js('#jform_tipo_transaccion').change(function() {
	    clearselects();
	    var value = js("input[name='jform[tipo_transaccion]']:checked").val();
    	llenarconsigpermitidas(value);
	});
	js('#jform_devoluciones').change(function() {
		devolucionesmas();
		
	});
	js('#jform_abo_dev').change(function() {
		var radio=js("#jform_abo_dev input[type='radio']:checked").val();
		if(radio=='1'){
			devoluciones();
	    	js('#jform_tipo_transaccion').addClass('readonly disabled');
	    	js('#jform_tipo_transaccion').attr('style','pointer-events: none');
	    	js('#jform_compras_chzn').addClass('chzn-disabled');
	    	js('#jform_compras').attr('disabled','disabled');	    	
 			js("#jform_compras").trigger("liszt:updated");
 			js('#jform_ventas_chzn').addClass('chzn-disabled');
	    	js('#jform_ventas').attr('disabled','disabled');	    	
 			js("#jform_ventas").trigger("liszt:updated");
	    }else{
	    	js('#jform_tipo_transaccion').removeClass('readonly disabled');	    	
	    	js('#jform_tipo_transaccion').removeAttr('style');
	    	js('#jform_compras_chzn').removeClass('chzn-disabled');
	    	js('#jform_compras').removeAttr('disabled');	    	
 			js("#jform_compras").trigger("liszt:updated");
 			js('#jform_ventas_chzn').removeClass('chzn-disabled');
	    	js('#jform_ventas').removeAttr('disabled');	    	
 			js("#jform_ventas").trigger("liszt:updated");
 			var abonado_actual = parseFloat(js('#jform_abono').val() ).toFixed(2);
			var abonado_devo = parseFloat(js('#jform_devoluciones').children("option:selected").attr('abonado')).toFixed(2);;
			var abonototal = (parseFloat(abonado_actual)-parseFloat(abonado_devo)).toFixed(2);
	 		js('#jform_abono').val( abonototal);
	 		js('#jform_adeudo').val((parseFloat(js('#jform_total').val())-parseFloat(abonototal)).toFixed(2) );
	 		js('#jform_devoluciones').prop("selectedIndex",-1);
			js("#jform_devoluciones").trigger("liszt:updated");
	 	}
	});
	js('input:hidden.compras').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('comprashidden')){
			js('#jform_compras option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_compras").trigger("liszt:updated");
	js('input:hidden.ventas').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('ventashidden')){
			js('#jform_ventas option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_ventas").trigger("liszt:updated");
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
				<?php echo $this->form->renderField('compras'); ?>

			<?php
				foreach((array)$this->item->compras as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="compras" name="jform[comprashidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('ventas'); ?>

			<?php
				foreach((array)$this->item->ventas as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="ventas" name="jform[ventashidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('total'); ?>
				<?php echo $this->form->renderField('abono'); ?>
				<?php echo $this->form->renderField('adeudo'); ?>
				<?php echo $this->form->renderField('abo_dev'); ?>
				<?php echo $this->form->renderField('devoluciones'); ?>

			<?php
				foreach((array)$this->item->devoluciones as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="devoluciones" name="jform[devolucioneshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				
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
