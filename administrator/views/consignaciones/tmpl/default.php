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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_servin2/assets/css/servin2.css');
$document->addStyleSheet(JUri::root() . 'media/com_servin2/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_servin2');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_servin2&task=consignaciones.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'consignacionList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo JRoute::_('index.php?option=com_servin2&view=consignaciones'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

            <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="consignacionList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.`ordering`', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
								<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.`state`', $listDirn, $listOrder); ?>
</th>
					<?php endif; ?>

									<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_ID', 'a.`id`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_NO_FOLIO_PAGARE', 'a.`no_folio_pagare`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_TIPO_TRANSACCION', 'a.`tipo_transaccion`', $listDirn, $listOrder); ?>
				</th>
				<!-- <th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_COMPRAS', 'a.`compras`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_VENTAS', 'a.`ventas`', $listDirn, $listOrder); ?>
				</th> -->
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_TOTAL', 'a.`total`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_ABONO', 'a.`abono`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_ADEUDO', 'a.`adeudo`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_FECHA_EMISION', 'a.`fecha_emision`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_FECHA_LIMITE', 'a.`fecha_limite`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'Estatus', 'a.`estatus`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_SERVIN2_CONSIGNACIONES_FECHA_DEVOLUCION', 'a.`fecha_devolucion`', $listDirn, $listOrder); ?>
				</th>

					
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_servin2');
					$canEdit    = $user->authorise('core.edit', 'com_servin2');
					$canCheckin = $user->authorise('core.manage', 'com_servin2');
					$canChange  = $user->authorise('core.edit.state', 'com_servin2');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php if (isset($this->items[0]->ordering)) : ?>
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel    = '';

									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
										  title="<?php echo $disabledLabel ?>">
							<i class="icon-menu"></i>
						</span>
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								<?php else : ?>
									<span class="sortable-handler inactive">
							<i class="icon-menu"></i>
						</span>
								<?php endif; ?>
							</td>
						<?php endif; ?>
						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<?php if (isset($this->items[0]->state)): ?>
							<td class="center">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'consignaciones.', $canChange, 'cb'); ?>
</td>
						<?php endif; ?>

										<td>

					<?php echo $item->id; ?>
				</td>				<td>
				<?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'consignaciones.', $canCheckin); ?>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_servin2&task=consignacion.edit&id='.(int) $item->id); ?>">
					<?php echo $this->escape($item->no_folio_pagare); ?></a>
				<?php else : ?>
					<?php echo $this->escape($item->no_folio_pagare); ?>
				<?php endif; ?>

				</td>				<td>

					<?php echo $item->tipo_transaccion; ?>
				</td>			<!-- 	<td>

					<?php echo $item->compras; ?>
				</td>				<td>

					<?php echo $item->ventas; ?>
				</td> -->				<td>

					<?php echo $item->total; ?>
				</td>				<td>

					<?php echo $item->abono; ?>
				</td>				<td>

					<?php echo $item->adeudo; ?>
				</td>				<td>

					<?php echo $item->fecha_emision; ?>
				</td>				<td>

					<?php echo $item->fecha_limite; ?>
				</td>				<td>

					<?php switch ($item->estatus) {
						case '1':
							echo '<label  class="btn  btn-primary">';
							echo "Consignación";
							echo '</label>';
							break;
						case '2':
							echo '<label  class="btn  ">';
							echo "Devolución";
							echo '</label>';
							break;
						case '3':
							echo '<label  class="btn  btn-success">';
							echo "Pagada";
							echo '</label>';
							break;
						case '4':
							echo '<label  class="btn  ">';
							echo "Abonada";
							echo '</label>';
							break;
					}; 
					
					?>	
				</td>				<td>

					<?php echo $item->fecha_devolucion; ?>
				</td>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>
<script>
    window.toggleField = function (id, task, field) {

        var f = document.adminForm, i = 0, cbx, cb = f[ id ];

        if (!cb) return false;

        while (true) {
            cbx = f[ 'cb' + i ];

            if (!cbx) break;

            cbx.checked = false;
            i++;
        }

        var inputField   = document.createElement('input');

        inputField.type  = 'hidden';
        inputField.name  = 'field';
        inputField.value = field;
        f.appendChild(inputField);

        cb.checked = true;
        f.boxchecked.value = 1;
        window.submitform(task);

        return false;
    };
</script>