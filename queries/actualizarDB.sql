ALTER TABLE `ourtalent`.`actividades` 
ADD COLUMN `estatus` INT NOT NULL DEFAULT 1 AFTER `tipo_de_actividad_id`;
