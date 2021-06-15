
truncate table  detalle_ingreso;
truncate table  detalle_salida;


SET FOREIGN_KEY_CHECKS = 0;
truncate table  ingreso;
truncate table  salida;
SET FOREIGN_KEY_CHECKS = 1;

UPDATE producto SET
und_ingresadas=0,und_salidas=0
  WHERE 1;
