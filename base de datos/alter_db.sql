ALTER TABLE `producto` CHANGE `und_salidas` `und_salidas` DECIMAL(18,2) NULL DEFAULT '0';

ALTER TABLE `detalle_salida` ADD `precio_compra` DECIMAL(18,2) NOT NULL DEFAULT '0.00' AFTER `cantidad`;

ALTER TABLE `producto` ADD `imagen` VARCHAR(500) NOT NULL AFTER `control_stock`;




ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_area` FOREIGN KEY (`area_idarea`) REFERENCES `area` (`idarea`);

DELETE FROM `seg_menus` WHERE id_perfil = 3;

ALTER TABLE `seg_menus`
  ADD CONSTRAINT `seg_menus_ibfk_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `seg_perfil` (`id_perfil`);

DELETE FROM `seg_menus` WHERE id_modulo not in  (select id_modulo from seg_modulo );

ALTER TABLE `seg_menus`
  ADD CONSTRAINT `seg_menus_ibfk_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `seg_modulo` (`id_modulo`);

ALTER TABLE `ingreso`
  ADD CONSTRAINT `ingreso_ibfk_periodo_pago` FOREIGN KEY (`idperiodo_pago`) REFERENCES `periodo_pago` (`idperiodo_pago`);


ALTER TABLE `salida`
  ADD CONSTRAINT `salida_ibfk_motivo` FOREIGN KEY (`motivo_movimiento_idmotivo`) REFERENCES `motivo_movimiento` (`idmotivo`);



ALTER TABLE `producto` ADD CONSTRAINT `unidad_ibfk_area` FOREIGN KEY (`presentacion_minima`) REFERENCES `presentacion`(`idpresentacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

Drop table tipo_pago; 

Drop table kardex; 

Drop table unidad_medida; 

Drop table stock; 






ALTER
 ALGORITHM = UNDEFINED
DEFINER=`root`@`localhost` 
 SQL SECURITY DEFINER
 VIEW `producto_stock`
 AS SELECT
    `pro`.`idproducto` AS `idproducto`,
    LPAD(`pro`.`codproducto`, 5, '0') AS `codproducto`,
    `pro`.`nombre` AS `producto`,
    `pre`.`abreviatura` AS `presentacion`,
    COALESCE(`pro`.`precio_venta`, 0) AS `precio_venta`,
    COALESCE(`pro`.`precio_unitario`, 0) AS `precio_compra`,
    COALESCE(`pro`.`und_ingresadas`, 0) AS `ingresado`,
    COALESCE(`pro`.`und_salidas`, 0) AS `salido`,
    COALESCE(
        `pro`.`und_ingresadas` - `pro`.`und_salidas`,
        0
    ) AS `stock`,
    CASE WHEN COALESCE(`pro`.`control_stock`, 0) = 0 THEN 'RANGO NO DEFINIDO' WHEN COALESCE(
        `pro`.`und_ingresadas` - `pro`.`und_salidas`,
        0
    ) >= COALESCE(`pro`.`control_stock`, 0) THEN '<span class=\'suficiente_stock\'>SUFICIENTE</span>' ELSE '<span class=\'comprar_stock\'>COMPRAR</span>'
END AS `estado`,
CONCAT(
    '<span class=\'ver_img\' onclick=\'ver_img(',
    `pro`.`idproducto`,
    ')\'>Ver!</span>'
) AS `imagen`
FROM
    (
        `luckimotors`.`producto` `pro`
    LEFT JOIN `luckimotors`.`presentacion` `pre`
    ON
        (
            `pre`.`idpresentacion` = `pro`.`presentacion_minima`
        )
    )
ORDER BY
    `pro`.`nombre`;

