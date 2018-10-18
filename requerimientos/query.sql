UPDATE `mtps`.`org_modulo` SET `id_modulo`='168', `id_sistema`='10', `nombre_modulo`='Inicio', `descripcion_modulo`='Dashboard de información del sistema', `orden`='1', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='fa fa-home', `opciones_modulo`='3' WHERE (`id_modulo`='168');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='169', `id_sistema`='10', `nombre_modulo`='Plan Estratégico Institucional', `descripcion_modulo`=NULL, `orden`='2', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='fa fa-file', `opciones_modulo`='1' WHERE (`id_modulo`='169');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='170', `id_sistema`='10', `nombre_modulo`='Plan Anual de Trabajo', `descripcion_modulo`=NULL, `orden`='3', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='fa fa-flag', `opciones_modulo`='3' WHERE (`id_modulo`='170');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='171', `id_sistema`='10', `nombre_modulo`='Monitorieo de Planificación', `descripcion_modulo`=NULL, `orden`='4', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='fa fa-pencil', `opciones_modulo`='3' WHERE (`id_modulo`='171');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='172', `id_sistema`='10', `nombre_modulo`='Usuarios', `descripcion_modulo`='Control de usuarios y roles', `orden`='6', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='glyphicon glyphicon-user', `opciones_modulo`='1' WHERE (`id_modulo`='172');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='173', `id_sistema`='10', `nombre_modulo`='Control de roles', `descripcion_modulo`='Creación, modificación y eliminacón de roles', `orden`='1', `dependencia`='172', `url_modulo`='usuarios/roles', `img_modulo`='fa fa-caret-right', `opciones_modulo`='1' WHERE (`id_modulo`='173');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='174', `id_sistema`='10', `nombre_modulo`='Informe de Avance', `descripcion_modulo`='Estado actual del desarrollo de las actividades', `orden`='1', `dependencia`='175', `url_modulo`='reportes/avance', `img_modulo`=NULL, `opciones_modulo`='3' WHERE (`id_modulo`='174');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='175', `id_sistema`='10', `nombre_modulo`='Reportes', `descripcion_modulo`='Consolidado de datos para exportación a hoja electrónica/pdf', `orden`='5', `dependencia`=NULL, `url_modulo`=NULL, `img_modulo`='fa fa-file-text', `opciones_modulo`='3' WHERE (`id_modulo`='175');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='176', `id_sistema`='10', `nombre_modulo`='Configuración PEI', `descripcion_modulo`='Configuración inicial del PEI', `orden`='1', `dependencia`='169', `url_modulo`='pei/documento', `img_modulo`=NULL, `opciones_modulo`='1' WHERE (`id_modulo`='176');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='177', `id_sistema`='10', `nombre_modulo`='Configuración PAT', `descripcion_modulo`='Configuración inicial del PAT', `orden`='1', `dependencia`='170', `url_modulo`='pat/configuracion', `img_modulo`=NULL, `opciones_modulo`='1' WHERE (`id_modulo`='177');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='178', `id_sistema`='10', `nombre_modulo`='Validación PAT', `descripcion_modulo`='Revisión y validación de las actividades del PAT', `orden`='3', `dependencia`='170', `url_modulo`='pat/validacion', `img_modulo`=NULL, `opciones_modulo`='1' WHERE (`id_modulo`='178');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='179', `id_sistema`='10', `nombre_modulo`='Control de cumplimiento PAT', `descripcion_modulo`='Ingreso de cumplimiento de metas mensuales plasmadas en el PAT', `orden`='1', `dependencia`='171', `url_modulo`='monitoreo/pat', `img_modulo`=NULL, `opciones_modulo`='3' WHERE (`id_modulo`='179');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='180', `id_sistema`='10', `nombre_modulo`='Control PAT', `descripcion_modulo`='Mantenimiento del PAT', `orden`='2', `dependencia`='170', `url_modulo`='pat/cpat', `img_modulo`='', `opciones_modulo`='3' WHERE (`id_modulo`='180');
UPDATE `mtps`.`org_modulo` SET `id_modulo`='181', `id_sistema`='10', `nombre_modulo`='Control PEI', `descripcion_modulo`='Mantenimiento del PEI', `orden`='2', `dependencia`='169', `url_modulo`='pei/objetivos', `img_modulo`=NULL, `opciones_modulo`='1' WHERE (`id_modulo`='181');

CREATE VIEW pat_estado_actividad_actual AS
SELECT
E.id_actividad,
MAX(E.fecha_creacion) AS fecha_creacion
FROM pat_estado_actividad AS E
GROUP BY E.id_actividad;

CREATE VIEW pat_niveles_items AS
SELECT
N1.id_documento AS id_doc,
N0.id_nivel AS niv00,
N0.nombre_nivel AS nom10,
I0.id_item AS ite00,
I0.correlativo_item AS cor10,
I0.descripcion_item AS des10,
N9.id_nivel AS niv09,
N9.nombre_nivel AS nom09,
I9.id_item AS ite09,
I9.correlativo_item AS cor09,
I9.descripcion_item AS des09,
N8.id_nivel AS niv08,
N8.nombre_nivel AS nom08,
I8.id_item AS ite08,
I8.correlativo_item AS cor08,
I8.descripcion_item AS des08,
N7.id_nivel AS niv07,
N7.nombre_nivel AS nom07,
I7.id_item AS ite07,
I7.correlativo_item AS cor07,
I7.descripcion_item AS des07,
N6.id_nivel AS niv06,
N6.nombre_nivel AS nom06,
I6.id_item AS ite06,
I6.correlativo_item AS cor06,
I6.descripcion_item AS des06,
N5.id_nivel AS niv05,
N5.nombre_nivel AS nom05,
I5.id_item AS ite05,
I5.correlativo_item AS cor05,
I5.descripcion_item AS des05,
N4.id_nivel AS niv04,
N4.nombre_nivel AS nom04,
I4.id_item AS ite04,
I4.correlativo_item AS cor04,
I4.descripcion_item AS des04,
N3.id_nivel AS niv03,
N3.nombre_nivel AS nom03,
I3.id_item AS ite03,
I3.correlativo_item AS cor03,
I3.descripcion_item AS des03,
N2.id_nivel AS niv02,
N2.nombre_nivel AS nom02,
I2.id_item AS ite02,
I2.correlativo_item AS cor02,
I2.descripcion_item AS des02,
N1.id_nivel AS niv01,
N1.nombre_nivel AS nom01,
I1.id_item AS ite01,
I1.correlativo_item AS cor01,
I1.descripcion_item AS des01
FROM pat_item AS I1
LEFT JOIN pat_nivel AS N1 ON I1.id_nivel = N1.id_nivel
LEFT JOIN pat_item AS I2 ON I1.id_padre = I2.id_item
LEFT JOIN pat_nivel AS N2 ON I2.id_nivel = N2.id_nivel
LEFT JOIN pat_item AS I3 ON I2.id_padre = I3.id_item
LEFT JOIN pat_nivel AS N3 ON I3.id_nivel = N3.id_nivel
LEFT JOIN pat_item AS I4 ON I3.id_padre = I4.id_item
LEFT JOIN pat_nivel AS N4 ON I4.id_nivel = N4.id_nivel
LEFT JOIN pat_item AS I5 ON I4.id_padre = I5.id_item
LEFT JOIN pat_nivel AS N5 ON I5.id_nivel = N5.id_nivel
LEFT JOIN pat_item AS I6 ON I5.id_padre = I6.id_item
LEFT JOIN pat_nivel AS N6 ON I6.id_nivel = N6.id_nivel
LEFT JOIN pat_item AS I7 ON I6.id_padre = I7.id_item
LEFT JOIN pat_nivel AS N7 ON I7.id_nivel = N7.id_nivel
LEFT JOIN pat_item AS I8 ON I7.id_padre = I8.id_item
LEFT JOIN pat_nivel AS N8 ON I8.id_nivel = N8.id_nivel
LEFT JOIN pat_item AS I9 ON I8.id_padre = I9.id_item
LEFT JOIN pat_nivel AS N9 ON I9.id_nivel = N9.id_nivel
LEFT JOIN pat_item AS I0 ON I9.id_padre = I0.id_item
LEFT JOIN pat_nivel AS N0 ON I0.id_nivel = N0.id_nivel;