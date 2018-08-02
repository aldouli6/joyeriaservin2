
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Material','com_servin2.material','{"special":{"dbtable":"#__servin_materiales2","key":"id","type":"Material","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/material.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.material')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Material', 
	`table` = '{"special":{"dbtable":"#__servin_materiales2","key":"id","type":"Material","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/material.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.material');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Kilataje','com_servin2.kilataje','{"special":{"dbtable":"#__servin_kilatajes2","key":"id","type":"Kilataje","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/kilataje.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.kilataje')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Kilataje', 
	`table` = '{"special":{"dbtable":"#__servin_kilatajes2","key":"id","type":"Kilataje","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/kilataje.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.kilataje');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Ubicacione','com_servin2.ubicacione','{"special":{"dbtable":"#__servin_ubicaciones2","key":"id","type":"Ubicacione","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/ubicacione.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.ubicacione')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Ubicacione', 
	`table` = '{"special":{"dbtable":"#__servin_ubicaciones2","key":"id","type":"Ubicacione","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/ubicacione.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.ubicacione');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Hechura','com_servin2.hechura','{"special":{"dbtable":"#__servin_hechuras2","key":"id","type":"Hechura","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/hechura.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.hechura')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Hechura', 
	`table` = '{"special":{"dbtable":"#__servin_hechuras2","key":"id","type":"Hechura","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/hechura.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.hechura');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Pieza','com_servin2.pieza','{"special":{"dbtable":"#__servin_piezas2","key":"id","type":"Pieza","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/pieza.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"material","targetTable":"#__servin_materiales2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"kilataje","targetTable":"#__servin_kilatajes2","targetColumn":"id","displayColumn":"kilataje"},{"sourceColumn":"ubicacion","targetTable":"#__servin_ubicaciones2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"hechura","targetTable":"#__servin_hechuras2","targetColumn":"id","displayColumn":"numero"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.pieza')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Pieza', 
	`table` = '{"special":{"dbtable":"#__servin_piezas2","key":"id","type":"Pieza","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/pieza.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"material","targetTable":"#__servin_materiales2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"kilataje","targetTable":"#__servin_kilatajes2","targetColumn":"id","displayColumn":"kilataje"},{"sourceColumn":"ubicacion","targetTable":"#__servin_ubicaciones2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"hechura","targetTable":"#__servin_hechuras2","targetColumn":"id","displayColumn":"numero"}]}'
WHERE (`type_alias` = 'com_servin2.pieza');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Proveedor','com_servin2.proveedor','{"special":{"dbtable":"#__servin_proveedores2","key":"id","type":"Proveedor","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/proveedor.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.proveedor')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Proveedor', 
	`table` = '{"special":{"dbtable":"#__servin_proveedores2","key":"id","type":"Proveedor","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/proveedor.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.proveedor');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Cliente','com_servin2.cliente','{"special":{"dbtable":"#__servin_clientes2","key":"id","type":"Cliente","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/cliente.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"fotocomprobante"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.cliente')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Cliente', 
	`table` = '{"special":{"dbtable":"#__servin_clientes2","key":"id","type":"Cliente","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/cliente.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"fotocomprobante"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_servin2.cliente');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Compra','com_servin2.compra','{"special":{"dbtable":"#__servin_compras2","key":"id","type":"Compra","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/compra.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"proveedor","targetTable":"#__servin_proveedores2","targetColumn":"id","displayColumn":"empresa"},{"sourceColumn":"pieza","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.compra')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Compra', 
	`table` = '{"special":{"dbtable":"#__servin_compras2","key":"id","type":"Compra","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/compra.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"proveedor","targetTable":"#__servin_proveedores2","targetColumn":"id","displayColumn":"empresa"},{"sourceColumn":"pieza","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"}]}'
WHERE (`type_alias` = 'com_servin2.compra');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Venta','com_servin2.venta','{"special":{"dbtable":"#__servin_ventas2","key":"id","type":"Venta","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/venta.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"pieza","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"},{"sourceColumn":"cliente","targetTable":"#__servin_clientes2","targetColumn":"id","displayColumn":"nombre"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.venta')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Venta', 
	`table` = '{"special":{"dbtable":"#__servin_ventas2","key":"id","type":"Venta","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/venta.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"pieza","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"},{"sourceColumn":"cliente","targetTable":"#__servin_clientes2","targetColumn":"id","displayColumn":"nombre"}]}'
WHERE (`type_alias` = 'com_servin2.venta');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Consignacion','com_servin2.consignacion','{"special":{"dbtable":"#__servin_consignaciones2","key":"id","type":"Consignacion","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/consignacion.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"foto_pagare"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"piezas","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"},{"sourceColumn":"cliente","targetTable":"#__servin_clientes2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"proveedor","targetTable":"#__servin_proveedores2","targetColumn":"id","displayColumn":"empresa"},{"sourceColumn":"devoluciones","targetTable":"#__servin_consignaciones2","targetColumn":"id","displayColumn":"no_folio_pagare"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.consignacion')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Consignacion', 
	`table` = '{"special":{"dbtable":"#__servin_consignaciones2","key":"id","type":"Consignacion","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/consignacion.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"foto_pagare"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"piezas","targetTable":"#__servin_piezas2","targetColumn":"id","displayColumn":"descripcion"},{"sourceColumn":"cliente","targetTable":"#__servin_clientes2","targetColumn":"id","displayColumn":"nombre"},{"sourceColumn":"proveedor","targetTable":"#__servin_proveedores2","targetColumn":"id","displayColumn":"empresa"},{"sourceColumn":"devoluciones","targetTable":"#__servin_consignaciones2","targetColumn":"id","displayColumn":"no_folio_pagare"}]}'
WHERE (`type_alias` = 'com_servin2.consignacion');

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Pago','com_servin2.pago','{"special":{"dbtable":"#__servin2_pagos","key":"id","type":"Pago","prefix":"Servin2Table"}}', '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/pago.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"consignacion","targetTable":"#__servin_consignaciones2","targetColumn":"id","displayColumn":"foto_pagare"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_servin2.pago')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Pago', 
	`table` = '{"special":{"dbtable":"#__servin2_pagos","key":"id","type":"Pago","prefix":"Servin2Table"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_servin2\/models\/forms\/pago.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"consignacion","targetTable":"#__servin_consignaciones2","targetColumn":"id","displayColumn":"foto_pagare"}]}'
WHERE (`type_alias` = 'com_servin2.pago');
