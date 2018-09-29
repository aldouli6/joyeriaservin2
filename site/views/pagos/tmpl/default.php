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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_servin2') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'pagoform.xml');
$canEdit    = $user->authorise('core.edit', 'com_servin2') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'pagoform.xml');
$canCheckin = $user->authorise('core.manage', 'com_servin2');
$canChange  = $user->authorise('core.edit.state', 'com_servin2');
$canDelete  = $user->authorise('core.delete', 'com_servin2');
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

	<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="pagoList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%">
	<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_TIPO', 'a.tipo', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_CONSIGNACION', 'a.consignacion', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_COMPRA', 'a.compra', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_VENTA', 'a.venta', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_PAGO', 'a.pago', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_METODO', 'a.metodo', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_SERVIN2_PAGOS_FECHA', 'a.fecha', $listDirn, $listOrder); ?>
				</th>


							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_SERVIN2_PAGOS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

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
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_servin2'); ?>

			
			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_servin2&task=pago.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
	<?php if ($item->state == 1): ?>
		<i class="icon-publish"></i>
	<?php else: ?>
		<i class="icon-unpublish"></i>
	<?php endif; ?>
	</a>
</td>
				<?php endif; ?>

								<td>

					<?php echo $item->id; ?>
				</td>
				<td>

					<?php echo $item->tipo; ?>
				</td>
				<td>

					<?php echo $item->consignacion; ?>
				</td>
				<td>

					<?php echo $item->compra; ?>
				</td>
				<td>

					<?php echo $item->venta; ?>
				</td>
				<td>

					<?php echo $item->pago; ?>
				</td>
				<td>

					<?php echo $item->metodo; ?>
				</td>
				<td>

					<?php echo $item->fecha; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_servin2&task=pagoform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_SERVIN2_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_SERVIN2_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
