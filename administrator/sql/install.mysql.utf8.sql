CREATE TABLE IF NOT EXISTS `#__servin_materiales2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_kilatajes2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`kilataje` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_ubicaciones2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
`direccion` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_hechuras2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`numero` VARCHAR(255)  NOT NULL ,
`costo` DOUBLE,
`tipo_ganancia` VARCHAR(255)  NOT NULL ,
`ganancia` DOUBLE,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_piezas2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`modified_at` DATETIME NOT NULL ,
`created_at` DATETIME NOT NULL ,
`descripcion` TEXT NOT NULL ,
`material` INT NOT NULL ,
`kilataje` INT NOT NULL ,
`ubicacion` INT NOT NULL ,
`hechura` INT NOT NULL ,
`tipo` VARCHAR(255)  NOT NULL ,
`existencia` DOUBLE,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_proveedores2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`empresa` VARCHAR(255)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
`direccion` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`correo` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_clientes2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
`direccion` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`correo` VARCHAR(255)  NOT NULL ,
`fotoine` TEXT NOT NULL ,
`fotocomprobante` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_compras2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`created_at` DATETIME NOT NULL ,
`modified_at` DATETIME NOT NULL ,
`proveedor` INT NOT NULL ,
`fecha` DATETIME NOT NULL ,
`pieza` INT NOT NULL ,
`cantidad` DOUBLE,
`total` DOUBLE,
`abonado` DOUBLE,
`pagada` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_ventas2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`created_at` DATETIME NOT NULL ,
`modified_at` DATETIME NOT NULL ,
`cliente` INT NOT NULL ,
`pieza` INT NOT NULL ,
`cantidad` DOUBLE,
`fecha` DATETIME NOT NULL ,
`total` DOUBLE,
`abonado` DOUBLE,
`pagada` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_consignaciones2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`created_at` DATETIME NOT NULL ,
`modified_at` DATETIME NOT NULL ,
`no_folio_pagare` VARCHAR(255)  NOT NULL ,
`foto_pagare` TEXT NOT NULL ,
`tipo_transaccion` VARCHAR(255)  NOT NULL ,
`compras` INT NOT NULL ,
`ventas` INT NOT NULL ,
`total` DOUBLE,
`abono` DOUBLE,
`abo_dev` VARCHAR(255)  NOT NULL ,
`devoluciones` VARCHAR(255)  NOT NULL ,
`adeudo` DOUBLE,
`fecha_emision` DATETIME NOT NULL ,
`fecha_limite` DATETIME NOT NULL ,
`devolucion` VARCHAR(255)  NOT NULL ,
`fecha_devolucion` DATETIME NOT NULL ,
`estatus` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__servin_pagos2` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`tipo` VARCHAR(255)  NOT NULL ,
`tipo_consignacion` VARCHAR(255)  NOT NULL ,
`compra` INT NOT NULL ,
`consignacion` INT NOT NULL ,
`venta` INT NOT NULL ,
`pago` DOUBLE,
`metodo` VARCHAR(255)  NOT NULL ,
`datos_pago` TEXT NOT NULL ,
`fecha` DATETIME NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

