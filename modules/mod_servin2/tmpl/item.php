<?php
/**
 * @version     CVS: 1.0.0
 * @package     com_servin2
 * @subpackage  mod_servin2
 * @author      Aldo Ulises <aldouli6@gmail.com>
 * @copyright   2018 Aldo Ulises
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;
$element = ModServin2Helper::getItem($params);
?>

<?php if (!empty($element)) : ?>
	<div>
		<?php $fields = get_object_vars($element); ?>
		<?php foreach ($fields as $field_name => $field_value) : ?>
			<?php if (ModServin2Helper::shouldAppear($field_name)): ?>
				<div class="row">
					<div class="span4">
						<strong><?php echo ModServin2Helper::renderTranslatableHeader($params, $field_name); ?></strong>
					</div>
					<div
						class="span8"><?php echo ModServin2Helper::renderElement($params->get('item_table'), $field_name, $field_value); ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif;
