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
$elements = ModServin2Helper::getList($params);
?>

<?php if (!empty($elements)) : ?>
	<table class="table">
		<?php foreach ($elements as $element) : ?>
			<tr>
				<th><?php echo ModServin2Helper::renderTranslatableHeader($params, $params->get('field')); ?></th>
				<td><?php echo ModServin2Helper::renderElement(
						$params->get('table'), $params->get('field'), $element->{$params->get('field')}
					); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif;
