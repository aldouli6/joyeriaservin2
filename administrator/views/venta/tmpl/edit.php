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
	var precio_;
	if (!'<?php print_r($this->item->pieza) ?>') {
		js(".oculta").parent().parent().hide();
	}	
	js('#jform_total').on('change',function(e){
		calcular();
    });
    consultaprecio();
 	consultaexistencia();
    function calcular(){
		js('#jform_total').attr('min',js('#jform_abono').val());
		js('#jform_abono').attr('max',js('#jform_total').val());		
	}
	function consultaprecio(){
 		js.ajax({ 
	            url: "index.php?option=com_servin2&task=preciosugerido&view=ajaxs&tmpl=ajax&id=" + js("#jform_pieza").val(),  
	            async: true, 
	            success: function(result){
	            	console.log(result);
	            	precio_=result;
	            	js("#jform_total").val(parseFloat( js("#jform_cantidad").val() * precio_ ).toFixed(2) );
	
	            },
	            error: function(result) {
	                console.log(result);
	            }
	    	});
 	}
 	function consultaexistencia(){
 		js.ajax({ 
	            url: "index.php?option=com_servin2&task=exitencia&view=ajaxs&tmpl=ajax&id=" + js("#jform_pieza").val(),  
	            async: true, 
	            success: function(result){
	            	console.log(result);
	            	cantidad=result;
	            	js("#jform_cantidad").attr("max", cantidad );
	
	            },
	            error: function(result) {
	                console.log(result);
	            }
	    	});
 	}
 	js("#jform_pieza").change(function(){
	    if(js(this).val() !=""){
	    	js(".oculta").parent().parent().show();	 
	    	consultaprecio();
	    	consultaexistencia();   	
	    }else{
	    	js(".oculta").parent().parent().hide();
	    	precio_=0;
	    	js("#jform_cantidad").removeAttr("max");
	    }
	});
	js("#jform_cantidad").change(function(){
	    js("#jform_total").val(parseFloat( js(this).val() * precio_ ).toFixed(2) );
	});
	js('input:hidden.cliente').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('clientehidden')){
			js('#jform_cliente option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_cliente").trigger("liszt:updated");
	js('input:hidden.pieza').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('piezahidden')){
			js('#jform_pieza option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_pieza").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'venta.cancel') {
			Joomla.submitform(task, document.getElementById('venta-form'));
		}
		else {
			
			if (task != 'venta.cancel' && document.formvalidator.isValid(document.id('venta-form'))) {
				
				Joomla.submitform(task, document.getElementById('venta-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_servin2&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="venta-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SERVIN2_TITLE_VENTA', true)); ?>
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
				<?php echo $this->form->renderField('modified_at'); ?>				<?php echo $this->form->renderField('cliente'); ?>

			<?php
				foreach((array)$this->item->cliente as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="cliente" name="jform[clientehidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<?php echo $this->form->renderField('fecha'); ?>				
			<?php echo $this->form->renderField('pieza'); ?>

			<?php
				foreach((array)$this->item->pieza as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="pieza" name="jform[piezahidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('cantidad'); ?>
				
				<?php echo $this->form->renderField('total'); ?>
				<?php echo $this->form->renderField('abonado'); ?>
				<?php echo $this->form->renderField('pagada'); ?>


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
