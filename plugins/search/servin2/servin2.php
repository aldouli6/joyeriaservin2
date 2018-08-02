<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Search.content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_servin2/router.php';

/**
 * Content search plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  Search.content
 * @since       1.6
 */
class PlgSearchServin2 extends JPlugin
{
	/**
	 * Determine areas searchable by this plugin.
	 *
	 * @return  array  An array of search areas.
	 *
	 * @since   1.6
	 */
	public function onContentSearchAreas()
	{
		static $areas = array(
			'servin2' => 'Servin2'
		);

		return $areas;
	}

	/**
	 * Search content (articles).
	 * The SQL must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav.
	 *
	 * @param   string  $text      Target search string.
	 * @param   string  $phrase    Matching option (possible values: exact|any|all).  Default is "any".
	 * @param   string  $ordering  Ordering option (possible values: newest|oldest|popular|alpha|category).  Default is "newest".
	 * @param   mixed   $areas     An array if the search it to be restricted to areas or null to search all areas.
	 *
	 * @return  array  Search results.
	 *
	 * @since   1.6
	 */
	public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
	{
		$db = JFactory::getDbo();

		if (is_array($areas))
		{
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas())))
			{
				return array();
			}
		}

		$limit = $this->params->def('search_limit', 50);

		$text = trim($text);

		if ($text == '')
		{
			return array();
		}

		$rows = array();

		
//Search Materiales.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.nombre LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.nombre LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.nombre AS title',
                        '"" AS created',
                        'a.nombre AS text',
                        '"Material" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_materiales2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=material&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Kilatajes.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.kilataje LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.kilataje LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.kilataje AS title',
                        '"" AS created',
                        'a.kilataje AS text',
                        '"Kilataje" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_kilatajes2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=kilataje&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Ubicaciones.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.nombre LIKE ' . $text;
$wheres2[] = 'a.direccion LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.nombre LIKE ' . $word;
$wheres2[] = 'a.direccion LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.nombre AS title',
                        '"" AS created',
                        'a.nombre AS text',
                        '"Ubicacione" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_ubicaciones2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=ubicacione&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Hechuras.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.numero LIKE ' . $text;
$wheres2[] = 'a.costo LIKE ' . $text;
$wheres2[] = 'a.tipo_ganancia LIKE ' . $text;
$wheres2[] = 'a.ganancia LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.numero LIKE ' . $word;
$wheres2[] = 'a.costo LIKE ' . $word;
$wheres2[] = 'a.tipo_ganancia LIKE ' . $word;
$wheres2[] = 'a.ganancia LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.numero AS title',
                        '"" AS created',
                        'a.numero AS text',
                        '"Hechura" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_hechuras2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=hechura&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Piezas.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.descripcion LIKE ' . $text;
$wheres2[] = '`servin_materiales2`.`nombre` LIKE ' . $text;
$wheres2[] = '`servin_kilatajes2`.`kilataje` LIKE ' . $text;
$wheres2[] = '`servin_ubicaciones2`.`nombre` LIKE ' . $text;
$wheres2[] = '`servin_hechuras2`.`numero` LIKE ' . $text;
$wheres2[] = 'a.tipo LIKE ' . $text;
$wheres2[] = 'a.gramos LIKE ' . $text;
$wheres2[] = 'a.estatus LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.descripcion LIKE ' . $word;
$wheres2[] = '`servin_materiales2`.`nombre` LIKE ' . $word;
$wheres2[] = '`servin_kilatajes2`.`kilataje` LIKE ' . $word;
$wheres2[] = '`servin_ubicaciones2`.`nombre` LIKE ' . $word;
$wheres2[] = '`servin_hechuras2`.`numero` LIKE ' . $word;
$wheres2[] = 'a.tipo LIKE ' . $word;
$wheres2[] = 'a.gramos LIKE ' . $word;
$wheres2[] = 'a.estatus LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.descripcion AS title',
                        'a.created_at AS created',
                        'a.descripcion AS text',
                        '"Pieza" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_piezas2 AS a')
            ->innerJoin('`#__servin_materiales2` AS servin_materiales2 ON servin_materiales2.id = a.material')
->innerJoin('`#__servin_kilatajes2` AS servin_kilatajes2 ON servin_kilatajes2.id = a.kilataje')
->innerJoin('`#__servin_ubicaciones2` AS servin_ubicaciones2 ON servin_ubicaciones2.id = a.ubicacion')
->innerJoin('`#__servin_hechuras2` AS servin_hechuras2 ON servin_hechuras2.id = a.hechura')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=pieza&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Proveedores.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.empresa LIKE ' . $text;
$wheres2[] = 'a.nombre LIKE ' . $text;
$wheres2[] = 'a.direccion LIKE ' . $text;
$wheres2[] = 'a.telefono LIKE ' . $text;
$wheres2[] = 'a.correo LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.empresa LIKE ' . $word;
$wheres2[] = 'a.nombre LIKE ' . $word;
$wheres2[] = 'a.direccion LIKE ' . $word;
$wheres2[] = 'a.telefono LIKE ' . $word;
$wheres2[] = 'a.correo LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.empresa AS title',
                        '"" AS created',
                        'a.empresa AS text',
                        '"Proveedor" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_proveedores2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=proveedor&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Clientes.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.nombre LIKE ' . $text;
$wheres2[] = 'a.direccion LIKE ' . $text;
$wheres2[] = 'a.telefono LIKE ' . $text;
$wheres2[] = 'a.correo LIKE ' . $text;
$wheres2[] = 'a.fotocomprobante LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.nombre LIKE ' . $word;
$wheres2[] = 'a.direccion LIKE ' . $word;
$wheres2[] = 'a.telefono LIKE ' . $word;
$wheres2[] = 'a.correo LIKE ' . $word;
$wheres2[] = 'a.fotocomprobante LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.nombre AS title',
                        '"" AS created',
                        'a.nombre AS text',
                        '"Cliente" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_clientes2 AS a')
            
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=cliente&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Compras.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.fecha LIKE ' . $text;
$wheres2[] = 'CONCAT(`servin_proveedores2`.`empresa`, \' \', `servin_proveedores2`.`nombre`) LIKE ' . $text;
$wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $text;
$wheres2[] = 'a.total LIKE ' . $text;
$wheres2[] = 'a.abonado LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.fecha LIKE ' . $word;
$wheres2[] = 'CONCAT(`servin_proveedores2`.`empresa`, \' \', `servin_proveedores2`.`nombre`) LIKE ' . $word;
$wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $word;
$wheres2[] = 'a.total LIKE ' . $word;
$wheres2[] = 'a.abonado LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.id AS title',
                        'a.created_at AS created',
                        'a.id AS text',
                        '"Compra" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_compras2 AS a')
            ->innerJoin('`#__servin_proveedores2` AS servin_proveedores2 ON servin_proveedores2.id = a.proveedor')
->innerJoin('`#__servin_piezas2` AS servin_piezas2 ON servin_piezas2.id = a.pieza')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=compra&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Ventas.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $text;
$wheres2[] = 'a.fecha LIKE ' . $text;
$wheres2[] = '`servin_clientes2`.`nombre` LIKE ' . $text;
$wheres2[] = 'a.total LIKE ' . $text;
$wheres2[] = 'a.metodo_pago LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $word;
$wheres2[] = 'a.fecha LIKE ' . $word;
$wheres2[] = '`servin_clientes2`.`nombre` LIKE ' . $word;
$wheres2[] = 'a.total LIKE ' . $word;
$wheres2[] = 'a.metodo_pago LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.id AS title',
                        'a.created_at AS created',
                        'a.id AS text',
                        '"Venta" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_ventas2 AS a')
            ->innerJoin('`#__servin_piezas2` AS servin_piezas2 ON servin_piezas2.id = a.pieza')
->innerJoin('`#__servin_clientes2` AS servin_clientes2 ON servin_clientes2.id = a.cliente')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=venta&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}



//Search Consignaciones.
if ($limit > 0) {
    switch ($phrase) {
        case 'exact':
            $text = $db->quote('%' . $db->escape($text, true) . '%', false);
            $wheres2 = array();
            $wheres2[] = 'a.no_folio_pagare LIKE ' . $text;
$wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $text;
$wheres2[] = '`servin_clientes2`.`nombre` LIKE ' . $text;
$wheres2[] = 'CONCAT(`servin_proveedores2`.`empresa`, \' \', `servin_proveedores2`.`nombre`) LIKE ' . $text;
$wheres2[] = 'a.total LIKE ' . $text;
$wheres2[] = 'a.abono LIKE ' . $text;
$wheres2[] = 'a.adeudo LIKE ' . $text;
$wheres2[] = 'a.fecha_emision LIKE ' . $text;
$wheres2[] = 'a.fecha_limite LIKE ' . $text;
$wheres2[] = 'a.fecha_devolucion LIKE ' . $text;
$wheres2[] = 'a.estatus LIKE ' . $text;
            $where = '(' . implode(') OR (', $wheres2) . ')';
            break;

        case 'all':
        case 'any':
        default:
            $words = explode(' ', $text);
            $wheres = array();

            foreach ($words as $word) {
                $word = $db->quote('%' . $db->escape($word, true) . '%', false);
                $wheres2 = array();
                $wheres2[] = 'a.no_folio_pagare LIKE ' . $word;
$wheres2[] = 'CONCAT(`servin_piezas2`.`descripcion`, \' \', `servin_piezas2`.`hechura`) LIKE ' . $word;
$wheres2[] = '`servin_clientes2`.`nombre` LIKE ' . $word;
$wheres2[] = 'CONCAT(`servin_proveedores2`.`empresa`, \' \', `servin_proveedores2`.`nombre`) LIKE ' . $word;
$wheres2[] = 'a.total LIKE ' . $word;
$wheres2[] = 'a.abono LIKE ' . $word;
$wheres2[] = 'a.adeudo LIKE ' . $word;
$wheres2[] = 'a.fecha_emision LIKE ' . $word;
$wheres2[] = 'a.fecha_limite LIKE ' . $word;
$wheres2[] = 'a.fecha_devolucion LIKE ' . $word;
$wheres2[] = 'a.estatus LIKE ' . $word;
                $wheres[] = implode(' OR ', $wheres2);
            }

            $where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
            break;
    }

    switch ($ordering) {
        default:
            $order = 'a.id DESC';
            break;
    }

    $query = $db->getQuery(true);

    $query
            ->clear()
            ->select(
                    array(
                        'a.id',
                        'a.no_folio_pagare AS title',
                        'a.created_at AS created',
                        'a.no_folio_pagare AS text',
                        '"Consignacion" AS section',
                        '1 AS browsernav'
                    )
            )
            ->from('#__servin_consignaciones2 AS a')
            ->innerJoin('`#__servin_piezas2` AS servin_piezas2 ON servin_piezas2.id = a.piezas')
->innerJoin('`#__servin_clientes2` AS servin_clientes2 ON servin_clientes2.id = a.cliente')
->innerJoin('`#__servin_proveedores2` AS servin_proveedores2 ON servin_proveedores2.id = a.proveedor')
            ->where('(' . $where . ')')
            ->group('a.id')
            ->order($order);

    $db->setQuery($query, 0, $limit);
    $list = $db->loadObjectList();
    $limit -= count($list);

    if (isset($list)) {
        foreach ($list as $key => $item) {
            $list[$key]->href = JRoute::_('index.php?option=com_servin2&view=consignacion&id=' . $item->id, false, 2);
        }
    }

    $rows = array_merge($list, $rows);
}

		return $rows;
	}
}
