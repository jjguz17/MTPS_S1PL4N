<?php

class Acreditacion_model extends CI_Model {
	
	/*Secciones que no pertenecen a San Salvador*/
	public $secciones=array(52,53,54,55,56,57,58,59,60,61,64,65,66); 
	
    function __construct() 
	{
		parent::__construct();
    }
	
	function insticion_lugar_trabajo($dep=NULL,$sin_vacios=1,$estado_capacitacion=NULL) 
	{
		$where="";
		if($sin_vacios==1)
			/*Muestra todos los lugares de trabajo que han sido promocionados*/
			/*$where.=" 	AND id_tipo_lugar_trabajo NOT LIKE '' 
						AND sac_lugar_trabajo.id_municipio NOT LIKE '' 
						AND nombre_lugar NOT LIKE '' 
						AND direccion_lugar NOT LIKE '' 
						AND nombre_contacto NOT LIKE '' 
						AND telefono NOT LIKE '' 
						AND total_hombres NOT LIKE '' 
						AND total_mujeres NOT LIKE ''";*/ 
			/*Muestra todos los lugares de trabajo que el tecnico dijo que necesitaban comite*/
			$where.=" AND sac_lugar_trabajo.necesita_comite=1";
		if($dep!=NULL)
			$where.=" 	AND id_departamento_pais=".$dep;
		if($estado_capacitacion!=NULL)
			//$where.=" 	AND sac_lugar_trabajo.estado<".$estado_capacitacion;
			$where.="";
		$sentencia="SELECT DISTINCT
					sac_lugar_trabajo.id_lugar_trabajo AS id,
					CONCAT_WS(' - ',nombre_institucion,nombre_lugar) AS nombre
					FROM sac_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					WHERE sac_lugar_trabajo.estado<>0 ".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function insticion_lugar_trabajo_sin_capacitarse($dep=NULL,$sin_vacios=1,$estado_capacitacion=NULL) 
	{
		$where="";
		if($sin_vacios==1)
			/*Muestra todos los lugares de trabajo que han sido promocionados*/
			/*$where.=" 	AND id_tipo_lugar_trabajo NOT LIKE '' 
						AND sac_lugar_trabajo.id_municipio NOT LIKE '' 
						AND nombre_lugar NOT LIKE '' 
						AND direccion_lugar NOT LIKE '' 
						AND nombre_contacto NOT LIKE '' 
						AND telefono NOT LIKE '' 
						AND total_hombres NOT LIKE '' 
						AND total_mujeres NOT LIKE ''";*/
			/*Muestra todos los lugares de trabajo que el tecnico dijo que necesitaban comite*/
			$where.=" AND sac_lugar_trabajo.necesita_comite=1";
		if($dep!=NULL)
			$where.=" 	AND id_departamento_pais=".$dep;
		if($estado_capacitacion!=NULL)
			//$where.=" 	AND sac_lugar_trabajo.estado<".$estado_capacitacion;
			$where.="";
		$sentencia="SELECT DISTINCT
					sac_lugar_trabajo.id_lugar_trabajo AS id,
					CONCAT_WS(' - ',nombre_institucion,nombre_lugar) AS nombre
					FROM sac_empleado_institucion
					LEFT JOIN sac_asistencia ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					LEFT JOIN sac_capacitacion ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					INNER JOIN sac_lugar_trabajo ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					WHERE sac_empleado_institucion.estado_empleado=1 AND (sac_asistencia.asistio IS NULL OR (sac_asistencia.asistio=0 AND sac_capacitacion.estado_capacitacion=0)) AND sac_lugar_trabajo.estado<>0 ".$where." AND sac_empleado_institucion.id_empleado_institucion NOT IN (SELECT id_empleado_institucion FROM sac_asistencia WHERE asistio=1)";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function tipo_representacion()
	{
		$sentencia="SELECT id_tipo_representacion AS id, nombre_tipo_representacion AS nombre FROM sac_tipo_representacion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function cargo_comite()
	{
		$sentencia="SELECT id_cargo_comite AS id, nombre_cargo_comite AS nombre FROM sac_cargo_comite";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function tipo_inscripcion()
	{
		$sentencia="SELECT id_tipo_inscripcion AS id, nombre AS nombre FROM sac_tipo_inscripcion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function resumen_empleados_comite($id_lugar_trabajo=0)
	{
		$sentencia="SELECT
					sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres AS total_empleados,
					sac_lugar_trabajo.total_hombres AS total_empleados_hombres,
					sac_lugar_trabajo.total_mujeres AS total_empleados_mujeres,
					sac_institucion.sindicato,
					COUNT(sac_empleado_institucion.id_empleado_institucion) AS total_comite,
					(SELECT COUNT(sac_empleado_institucion.id_genero) FROM sac_empleado_institucion WHERE sac_empleado_institucion.id_genero=1 AND sac_empleado_institucion.id_lugar_trabajo=".$id_lugar_trabajo." AND sac_empleado_institucion.estado_empleado=1) AS total_comite_hombres,
					(SELECT COUNT(sac_empleado_institucion.id_genero) FROM sac_empleado_institucion WHERE sac_empleado_institucion.id_genero=2 AND sac_empleado_institucion.id_lugar_trabajo=".$id_lugar_trabajo." AND sac_empleado_institucion.estado_empleado=1) AS total_comite_mujeres,
					(SELECT COUNT(sac_empleado_institucion.id_tipo_representacion) FROM sac_empleado_institucion WHERE sac_empleado_institucion.id_tipo_representacion=1 AND sac_empleado_institucion.id_lugar_trabajo=".$id_lugar_trabajo." AND sac_empleado_institucion.estado_empleado=1) AS total_comite_representantes_empleador,
					(SELECT COUNT(sac_empleado_institucion.id_tipo_representacion) FROM sac_empleado_institucion WHERE sac_empleado_institucion.id_tipo_representacion=2 AND sac_empleado_institucion.id_lugar_trabajo=".$id_lugar_trabajo." AND sac_empleado_institucion.estado_empleado=1) AS total_comite_representantes_trabajadores,
					COUNT(sac_empleado_institucion.sindicato) AS total_comite_sindicato,
					COUNT(sac_empleado_institucion.delegado) AS total_comite_delegados,
					CASE 
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=15 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=49 THEN 2
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=50 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=99 THEN 3
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=100 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=499 THEN 4
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=500 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=999 THEN 5
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=1000 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=2000 THEN 6
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=2001 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=3000 THEN 7
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=3001 THEN 8
					END AS total_empleados_representantes,
					CASE 
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=15 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=49 THEN 1
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=50 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=100 THEN 2
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=101 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=500 THEN 3
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=501 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=1000 THEN 4
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=1001 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=2000 THEN 5
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=2001 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=3000 THEN 6
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=3001 AND (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)<=4000 THEN 7
						WHEN (sac_lugar_trabajo.total_hombres+sac_lugar_trabajo.total_mujeres)>=4001 THEN 8
					END AS total_empleados_delegados
					FROM sac_lugar_trabajo
					INNER JOIN sac_institucion ON sac_institucion.id_institucion=sac_lugar_trabajo.id_institucion
					LEFT JOIN sac_empleado_institucion ON sac_empleado_institucion.id_lugar_trabajo=sac_lugar_trabajo.id_lugar_trabajo
					WHERE sac_lugar_trabajo.estado<>0 AND sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo." AND (sac_empleado_institucion.estado_empleado=1 OR sac_empleado_institucion.estado_empleado IS NULL)
					GROUP BY sac_lugar_trabajo.id_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function guardar_participante($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_empleado_institucion
					(id_lugar_trabajo, id_tipo_representacion, nombre_empleado, dui_empleado, cargo_empleado, id_tipo_inscripcion, id_cargo_comite, fecha_creacion, id_usuario_crea, delegado, sindicato, fecha_ingreso, id_genero,id_empleado_institucion_sustituye) 
					VALUES 
					($id_lugar_trabajo, $id_tipo_representacion, '$nombre_empleado', '$dui_empleado', '$cargo_empleado', $id_tipo_inscripcion, $id_cargo_comite, '$fecha_creacion', $id_usuario_crea, $delegado, $sindicato, '$fecha_ingreso', $id_genero, $id_empleado_institucion_sustituye)";
		$this->db->query($sentencia);
	}
	
	function empleados_lugar_trabajo($id_lugar_trabajo=NULL, $empleados="",$estado=1,$id_empleado_institucion=NULL)
	{
		$where="";
		if($id_lugar_trabajo!=NULL)
			$where=" AND id_lugar_trabajo=".$id_lugar_trabajo;
		if($empleados!="") {
			$emp=explode("-",$empleados);
			for($i=0;$i<(count($emp)-1);$i++) {
				$where.=" AND id_empleado_institucion <> ".$emp[$i];
			}
		}
		if($estado==1)
			$where.=" AND estado_empleado=1";
		if($id_empleado_institucion!=NULL)
			$where.=" AND id_empleado_institucion<>".$id_empleado_institucion;
		/*$sentencia="SELECT id_empleado_institucion AS id, nombre_empleado AS nombre, delegado, sindicato FROM sac_empleado_institucion WHERE estado_empleado=1 AND id_tipo_inscripcion<>2 ".$where;*/
		$sentencia="SELECT id_empleado_institucion AS id, nombre_empleado AS nombre, delegado, sindicato FROM sac_empleado_institucion WHERE TRUE ".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function empleados_lugar_trabajo_sin_capacitarse($id_lugar_trabajo=NULL, $empleados="")
	{
		$where="";
		if($id_lugar_trabajo!=NULL)
			$where=" AND sac_empleado_institucion.id_lugar_trabajo=".$id_lugar_trabajo;
		if($empleados!="") {
			$emp=explode("-",$empleados);
			for($i=0;$i<(count($emp)-1);$i++) {
				$where.=" AND sac_empleado_institucion.id_empleado_institucion <> ".$emp[$i];
			}
		}
		$sentencia="SELECT DISTINCT
					sac_empleado_institucion.id_empleado_institucion AS id,
					sac_empleado_institucion.nombre_empleado AS nombre,
					sac_empleado_institucion.delegado,
					sac_empleado_institucion.sindicato
					FROM
					sac_empleado_institucion
					LEFT JOIN sac_asistencia ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					LEFT JOIN sac_capacitacion ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					WHERE sac_empleado_institucion.estado_empleado=1 AND (sac_asistencia.asistio IS NULL OR (sac_asistencia.asistio=0 AND sac_capacitacion.estado_capacitacion=0)) ".$where." AND sac_empleado_institucion.id_empleado_institucion NOT IN (SELECT id_empleado_institucion FROM sac_asistencia WHERE asistio=1)";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_participante($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET estado_empleado=0, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica WHERE id_empleado_institucion=".$id_empleado_institucion;
		$this->db->query($sentencia);
	}
	
	function empleado_institucion($id_empleado_institucion)
	{
		$sentencia="SELECT
					id_empleado_institucion,
					id_lugar_trabajo,
					id_tipo_inscripcion,
					id_cargo_comite,
					nombre_empleado,
					cargo_empleado,
					dui_empleado,
					id_tipo_representacion,
					delegado,
					sindicato,
					DATE_FORMAT(fecha_ingreso,'%d/%m/%Y') AS fecha_ingreso,
					id_genero
					FROM sac_empleado_institucion
					WHERE id_empleado_institucion=".$id_empleado_institucion;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function actualizar_participante($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET
		 			id_lugar_trabajo=$id_lugar_trabajo, 
		 			id_tipo_representacion=$id_tipo_representacion, 
		 			id_tipo_inscripcion=$id_tipo_inscripcion, 
					id_cargo_comite=$id_cargo_comite,
		 			nombre_empleado='$nombre_empleado', 
		 			dui_empleado='$dui_empleado', 
		 			cargo_empleado='$cargo_empleado',
					fecha_modificacion='$fecha_modificacion', 
					id_usuario_modifica=$id_usuario_modifica, 
					delegado=$delegado, 
					sindicato=$sindicato,
					fecha_ingreso='$fecha_ingreso',
					id_empleado_institucion_sustituye=$id_empleado_institucion_sustituye,
					id_genero=$id_genero
					WHERE id_empleado_institucion=".$id_empleado_institucion;
		$this->db->query($sentencia);
	}
	
	function actualizar_participante_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET
		 			dui_empleado='$dui_empleado', 
		 			cargo_empleado='$cargo_empleado',
					fecha_modificacion='$fecha_modificacion', 
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_empleado_institucion=".$id_empleado_institucion;
		$this->db->query($sentencia);
	}
	
	function guardar_capacitacion($formuInfo) 
	{
		extract($formuInfo);
		if($id_lugar_trabajo!="")
			$sentencia="INSERT INTO sac_capacitacion
						(id_lugar_trabajo, fecha_capacitacion, hora_capacitacion, id_usuario_crea, fecha_creacion) 
						VALUES 
						($id_lugar_trabajo, '$fecha_capacitacion', '$hora_capacitacion', '$id_usuario_crea', '$fecha_creacion')";
		else
			$sentencia="INSERT INTO sac_capacitacion
						(fecha_capacitacion, hora_capacitacion, id_usuario_crea, fecha_creacion) 
						VALUES 
						('$fecha_capacitacion', '$hora_capacitacion', '$id_usuario_crea', '$fecha_creacion')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function eliminar_empleados_capacitacion($id_capacitacion)
	{
		$sentencia="DELETE FROM sac_asistencia WHERE id_capacitacion='$id_capacitacion'";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function eliminar_tecnicos_capacitacion($id_capacitacion)
	{
		$sentencia="DELETE FROM sac_capacitador WHERE id_capacitacion='$id_capacitacion'";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function agregar_empleados_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_asistencia
					(id_capacitacion, id_empleado_institucion) 
					VALUES 
					($id_capacitacion, $id_empleado_institucion)";
		$this->db->query($sentencia);
	}
	
	function agregar_tecnicos_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_capacitador
					(id_capacitacion, id_empleado) 
					VALUES 
					($id_capacitacion, $id_empleado)";
		$this->db->query($sentencia);
	}
	
	function mostrar_capacitaciones($dep=NULL,$todas=NULL,$id_empleado=NULL)
	{
		$where="";
		if($dep!=NULL) {
			$where=" AND org_municipio.id_departamento_pais=".$dep;
		}
		if($todas!=NULL) {
			/*$where.=" AND estado_capacitacion=".$todas." AND fecha_capacitacion<='".date('Y-m-d')."'";*/
			$where.=" AND estado_capacitacion=".$todas;
		}
		if($id_empleado!=NULL) {
			$where.=" AND sac_capacitador.id_empleado=".$id_empleado;
		}
		$sentencia="SELECT DISTINCT
					sac_capacitacion.id_capacitacion AS id,
					/*DATE_FORMAT(sac_capacitacion.fecha_capacitacion,'%d/%m/%Y') AS fecha,*/
					sac_capacitacion.fecha_capacitacion AS fecha,
					CASE 
						WHEN sac_capacitacion.id_lugar_trabajo IS NOT NULL THEN CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) 
						WHEN sac_capacitacion.id_lugar_trabajo IS NULL THEN 'MTPS' 
					END AS lugar
					FROM
					sac_capacitacion
					LEFT JOIN sac_lugar_trabajo ON sac_capacitacion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					LEFT JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN sac_asistencia ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					INNER JOIN sac_empleado_institucion ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					INNER JOIN sac_lugar_trabajo AS sac_lugar_trabajo_2 ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo_2.id_lugar_trabajo
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo_2.id_municipio AND org_municipio.id_municipio = sac_lugar_trabajo_2.id_municipio
					INNER JOIN sac_capacitador ON sac_capacitador.id_capacitacion = sac_capacitacion.id_capacitacion
					WHERE TRUE ".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="DELETE FROM sac_capacitacion WHERE id_capacitacion='$id_capacitacion'";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function ver_capacitacion($id_capacitacion,$id_lugar_trabajo=NULL) 
	{
		$where="";
		if($id_lugar_trabajo!=NULL)
			$where.=" AND sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo;
		$sentencia="SELECT
					sac_capacitador.id_capacitacion,
					sac_capacitacion.id_lugar_trabajo,
					DATE_FORMAT(fecha_capacitacion,'%d/%m/%Y') AS fecha_capacitacion,
					fecha_capacitacion AS fecha_capacitacion2,
					DATE_FORMAT(hora_capacitacion,'%h:%i %p') AS hora_capacitacion,
					sac_capacitador.id_empleado,
					tcm_empleado.nombre,
					sac_empleado_institucion.id_empleado_institucion,
					sac_empleado_institucion.nombre_empleado,
					sac_empleado_institucion.cargo_empleado,
					sac_lugar_trabajo.id_lugar_trabajo AS id,
					CONCAT_WS(' - ',nombre_institucion,nombre_lugar) AS nombre_lugar
					FROM sac_capacitacion
					INNER JOIN sac_capacitador ON sac_capacitador.id_capacitacion = sac_capacitacion.id_capacitacion
					INNER JOIN sac_asistencia ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					INNER JOIN sac_empleado_institucion ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					INNER JOIN tcm_empleado ON tcm_empleado.id_empleado = sac_capacitador.id_empleado
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_lugar_trabajo = sac_empleado_institucion.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE sac_capacitador.id_capacitacion=".$id_capacitacion.$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function actualizar_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_capacitacion SET
		 			id_lugar_trabajo=$id_lugar_trabajo, 
		 			fecha_capacitacion='$fecha_capacitacion',
		 			hora_capacitacion='$hora_capacitacion',
					fecha_modificacion='$fecha_modificacion', 
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_capacitacion=".$id_capacitacion;
		$this->db->query($sentencia);
	}
	
	function guardar_asistencia_capacitacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_asistencia SET
					asistio=$asistio 
					WHERE id_capacitacion=$id_capacitacion AND id_empleado_institucion=$id_empleado_institucion";
		$query=$this->db->query($sentencia);
		$sentencia="UPDATE sac_capacitacion SET
					estado_capacitacion=0 
					WHERE id_capacitacion=$id_capacitacion";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function lugares_trabajo_comite($dep=NULL,$est=NULL,$todos=NULL)
	{
		$where="";
		if($todos==NULL)
			$where.=" AND t1.inscritos=t2.capacitados";
		if($est==1)
			//$where.=" AND sac_lugar_trabajo.fecha_conformacion IS NULL";
			$where.=" AND sac_lugar_trabajo.estado=1";
		if($est==2)
			//$where.=" AND sac_lugar_trabajo.fecha_conformacion IS NOT NULL AND sac_lugar_trabajo.estado=2";
			$where.=" AND sac_lugar_trabajo.estado>=2";
		$sentencia="SELECT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',nombre_institucion,nombre_lugar) AS nombre, t1.inscritos, t2.capacitados 
					FROM sac_lugar_trabajo
					INNER JOIN (SELECT
					sac_lugar_trabajo.id_lugar_trabajo,
					Count(DISTINCT sac_asistencia.id_empleado_institucion) AS inscritos
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN sac_empleado_institucion ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_asistencia ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					GROUP BY sac_lugar_trabajo.id_lugar_trabajo) AS t1 ON sac_lugar_trabajo.id_lugar_trabajo=t1.id_lugar_trabajo
					INNER JOIN (SELECT
					sac_lugar_trabajo.id_lugar_trabajo,
					Count(DISTINCT sac_asistencia.id_empleado_institucion) AS capacitados
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN sac_empleado_institucion ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_asistencia ON sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					WHERE sac_asistencia.asistio=1
					GROUP BY sac_lugar_trabajo.id_lugar_trabajo) AS t2 ON sac_lugar_trabajo.id_lugar_trabajo=t2.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion=sac_institucion.id_institucion
					WHERE sac_lugar_trabajo.estado>=1 ".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function actualizar_comite($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_lugar_trabajo SET
					fecha_conformacion='$fecha_conformacion',
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_lugar_trabajo=$id_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function quitar_empleados_delegados_sindicato($id_lugar_trabajo)
	{
		$sentencia="UPDATE sac_empleado_institucion SET
					delegado=NULL,
					sindicato=NULL
					WHERE id_lugar_trabajo=$id_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function agregar_empleados_delegados($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET
					delegado=$delegado,
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_empleado_institucion=$id_empleado_institucion";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function agregar_empleados_sindicato($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET
					sindicato=$sindicato,
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_empleado_institucion=$id_empleado_institucion";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function guardar_aprobacion_comite($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_lugar_trabajo SET
					estado='$estado',
					fecha_conformacion='$fecha_conformacion',
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_lugar_trabajo=$id_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return true;
	}
	
	function consultar_lugar_trabajo_empleados($id_lugar_trabajo)
	{
		$sentencia="SELECT DISTINCT
					sac_empleado_institucion.id_empleado_institucion,
					sac_empleado_institucion.nombre_empleado
					FROM sac_institucion
					LEFT JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN sac_empleado_institucion ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					LEFT JOIN sac_asistencia ON  sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					LEFT JOIN sac_capacitacion ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					WHERE sac_asistencia.asistio=1 AND sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultar_lugar_trabajo($id_empleado_institucion=0)
	{
		$sentencia="SELECT
					sac_capacitacion.id_capacitacion,
					sac_lugar_trabajo.nombre_lugar,
					sac_institucion.nombre_institucion,
					sac_capacitacion.fecha_capacitacion,
					sac_asistencia.fecha_acreditacion,
					COALESCE(TIMESTAMPDIFF(YEAR,sac_asistencia.fecha_acreditacion,CURRENT_DATE),-1) as tiempo_activo,
					sac_empleado_institucion.nombre_empleado
					FROM sac_institucion
					LEFT JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN sac_empleado_institucion ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					LEFT JOIN sac_asistencia ON  sac_asistencia.id_empleado_institucion = sac_empleado_institucion.id_empleado_institucion
					LEFT JOIN sac_capacitacion ON sac_asistencia.id_capacitacion = sac_capacitacion.id_capacitacion
					WHERE sac_asistencia.asistio=1 AND sac_empleado_institucion.id_empleado_institucion=".$id_empleado_institucion." LIMIT 0,1";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function actulizar_acreditacion($id_empleado_institucion=0)
	{
		$sentencia="UPDATE sac_asistencia SET fecha_acreditacion='".date('Y-m-d')."' WHERE asistio=1 AND id_empleado_institucion=".$id_empleado_institucion;
		$query=$this->db->query($sentencia);
	}
	
	function busqueda_dui_empleados($dui_empleado,$id_empleado_institucion)
	{
		$where="";
		if($id_empleado_institucion!="" && $id_empleado_institucion!=NULL)
			$where=" AND id_empleado_institucion<>".$id_empleado_institucion;
		$sentencia="SELECT COUNT(dui_empleado) AS total
					FROM sac_empleado_institucion
					where dui_empleado LIKE '".$dui_empleado."'".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}

	function actualizar_cargo_comite($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_empleado_institucion SET id_cargo_comite=".$id_cargo_comite.", fecha_modificacion='".$fecha_modificacion."', id_usuario_modifica=".$id_usuario_modifica." WHERE id_empleado_institucion=".$id_empleado_institucion;
		$query=$this->db->query($sentencia);
	}
	
	function memo_acreditacion_pdf($id_empleado_institucion=0)
	{
		$sentencia="SELECT DISTINCT
					sac_lugar_trabajo.fecha_conformacion,
					sac_lugar_trabajo.nombre_lugar,
					sac_institucion.nombre_institucion,
					sac_lugar_trabajo.telefono AS telefono_lugar,
					sac_lugar_trabajo.direccion_lugar,
					LOWER(CONCAT_WS(', ',org_municipio.municipio,org_departamento.departamento)) AS municipio_lugar,
					E.nombre_empleado,
					E.cargo_empleado
					FROM sac_empleado_institucion
					INNER JOIN sac_lugar_trabajo ON sac_empleado_institucion.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN sac_empleado_institucion AS E ON E.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					WHERE E.id_cargo_comite=1 AND E.estado_empleado=1 AND sac_empleado_institucion.id_empleado_institucion=".$id_empleado_institucion;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function memo_acreditacion_lista_empleados_pdf($id_empleado_institucion='')
	{
		$sentencia="SELECT DISTINCT
					E.nombre_empleado,
					C.nombre_cargo_comite AS cargo_comite
					FROM sac_empleado_institucion AS E
					LEFT JOIN sac_cargo_comite AS C ON C.id_cargo_comite=E.id_cargo_comite 
					WHERE E.estado_empleado=1 AND E.id_empleado_institucion IN (".$id_empleado_institucion.")
					ORDER BY E.id_cargo_comite";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function resultados_comites($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RC.id_departamento=".$id_departamento;
		}
		$sentencia="SELECT 
					@s:=@s+1 numero,
					DATE_FORMAT(RC.fecha_capacitacion, '%d/%m/%Y') AS fecha_capacitacion,
					CONCAT_WS(' - ',RC.nombre_institucion,RC.nombre_lugar) AS nombre_lugar,
					CONCAT_WS(', ',RC.direccion_lugar, LOWER(RC.municipio),LOWER(RC.departamento)) AS direccion_lugar,
					COUNT(DISTINCT RC.id_empleado_institucion) AS total_capacitados,
					(RC.total_hombres+RC.total_mujeres) AS total_empleados,
					RC.nombre_sector,
					CASE
						WHEN RC.nombre_lugar_capacitacion IS NULL THEN 'MTPS'
						ELSE RC.nombre_lugar_capacitacion
					END AS lugar_capacitacion
					FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
					WHERE RC.asistio_empleado=1 AND RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'".$where."
					GROUP BY RC.id_lugar_trabajo
					ORDER BY numero ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RC.id_departamento=".$id_departamento;
		}
		$sentencia="SELECT 
					@s:=@s+1 numero,
					RC.tecnico_educador AS nombre,
					RC.seccion,
					COUNT(DISTINCT RC.id_capacitacion) AS total
					FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
					WHERE RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'".$where."
					GROUP BY RC.id_empleado
					ORDER BY numero ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function resultados_trabajadores_capacitados($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RC.id_departamento=".$id_departamento;
		}
		$sentencia="SELECT
					@s:=@s+1 numero,
					RC.dui_empleado,
					RC.nombre_empleado,
					LOWER(RC.genero) AS genero,
					CASE 
						WHEN RC.id_tipo_representacion=3 THEN 'Trabajadores'
						ELSE RC.tipo_representacion
					END AS tipo_representacion,
					RC.tipo_representacion AS tipo_representacion_real,
					CONCAT_WS(' - ',RC.nombre_institucion,RC.nombre_lugar) AS nombre_lugar,
					DATE_FORMAT(RC.fecha_capacitacion, '%d/%m/%Y') AS fecha_capacitacion
					FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
					WHERE RC.asistio_empleado	=1 AND RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'".$where."
					GROUP BY RC.id_empleado_institucion
					ORDER BY numero ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function entrega_acreditacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_entrega_acreditacion
						(id_empleado_institucion, nombre_entrega, dui_entrega, fecha_entrega, id_usuario_crea, fecha_creacion) 
						VALUES 
						($id_empleado_institucion, '$nombre_entrega', '$dui_entrega', '$fecha_entrega', $id_usuario_crea, '$fecha_creacion')";
		$query=$this->db->query($sentencia);
	}
	
	function resultados_acreditaciones($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RA.id_departamento=".$id_departamento;
		}
		$sentencia="SELECT 
					DATE_FORMAT(RA.fecha_conformacion,'%d/%m/%Y') AS fecha_emision,
					CONCAT_WS(' - ',RA.nombre_institucion,RA.nombre_lugar) AS nombre_lugar,
					CONCAT_WS(', ',RA.direccion_lugar, LOWER(RA.municipio),LOWER(RA.departamento)) AS direccion_lugar,
					RA.nombre_entrega,
					RA.dui_entrega,
					DATE_FORMAT(RA.fecha_entrega,'%d/%m/%Y') AS fecha_entrega,
					GROUP_CONCAT(DISTINCT RA.nombre_empleado,' (',IF(RA.nombre_cargo_comite IS NULL, 'Sin Cargo', RA.nombre_cargo_comite),') - ',DATE_FORMAT(RA.fecha_capacitacion,'%d/%m/%Y')) AS empleados_acreditados
					FROM sac_resultado_acreditacion AS RA
					WHERE RA.fecha_conformacion BETWEEN '$fecha_inicial' AND '$fecha_final' ".$where."
					GROUP BY RA.id_lugar_trabajo, RA.fecha_entrega
					ORDER BY RA.fecha_conformacion ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultas_capacitaciones_ultimos_meses($id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND id_departamento=".$id_departamento;
		}
		$sentencia="SELECT
					F.A AS anio, 
					F.M AS mes,
					COUNT(DISTINCT RC.id_empleado_institucion) AS capacitados,
					IFNULL(RC2.total,0) AS beneficiados
					FROM (
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -4 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -4 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -3 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -3 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -2 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -2 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AS A
						UNION
						SELECT
						MONTH(DATE_ADD(NOW(), INTERVAL 0 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL 0 MONTH)) AS A
					) AS F
					LEFT JOIN (
						SELECT DISTINCT RC.id_institucion, RC.fecha_capacitacion, RC.id_empleado_institucion, RC.total_hombres
						FROM sac_resultado_capacitacion AS RC 
						WHERE RC.estado_capacitacion=0 AND RC.asistio_empleado=1 ".$where."
					) AS RC ON DATE_FORMAT(RC.fecha_capacitacion,'%c') LIKE F.M AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE F.A 
					LEFT JOIN (
						SELECT DISTINCT RC2.id_institucion, (RC2.total_hombres+RC2.total_mujeres) AS total
						FROM sac_resultado_capacitacion AS RC2
						WHERE RC2.estado_capacitacion=0 AND RC2.asistio_empleado=1 ".$where."
					) AS RC2 ON RC2.id_institucion=RC.id_institucion
					GROUP BY F.A, F.M
					ORDER BY F.A ASC, F.M ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultas_acreditaciones_ultimos_meses($id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND id_departamento=".$id_departamento;
		}
		$sentencia="SELECT
					F.A AS anio, 
					F.M AS mes,
					COUNT(DISTINCT RC.id_empleado_institucion) AS acreditados_hombres,
					COUNT(DISTINCT RC2.id_empleado_institucion) AS acreditados_mujeres
					FROM (
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -4 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -4 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -3 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -3 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -2 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -2 MONTH)) AS A
						UNION
						SELECT 
						MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AS A
						UNION
						SELECT
						MONTH(DATE_ADD(NOW(), INTERVAL 0 MONTH)) AS M,
						YEAR(DATE_ADD(NOW(), INTERVAL 0 MONTH)) AS A
					) AS F
					LEFT JOIN (
						SELECT DISTINCT RC.id_institucion, RC.fecha_conformacion, RC.id_empleado_institucion
						FROM sac_resultado_acreditacion AS RC 
						WHERE RC.estado_capacitacion=0 AND RC.asistio_empleado=1 AND RC.id_genero=1 ".$where."
					) AS RC ON DATE_FORMAT(RC.fecha_conformacion,'%c') LIKE F.M AND DATE_FORMAT(RC.fecha_conformacion,'%Y') LIKE F.A 
					LEFT JOIN (
						SELECT DISTINCT RC2.id_institucion, RC2.fecha_conformacion, RC2.id_empleado_institucion
						FROM sac_resultado_acreditacion AS RC2
						WHERE RC2.estado_capacitacion=0 AND RC2.asistio_empleado=1 AND RC2.id_genero=2 ".$where."
					) AS RC2 ON DATE_FORMAT(RC2.fecha_conformacion,'%c') LIKE F.M AND DATE_FORMAT(RC2.fecha_conformacion,'%Y') LIKE F.A 
					GROUP BY F.A, F.M
					ORDER BY F.A ASC, F.M ASC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	/*
		SELECT 
		@s:=@s+1 numero,
		DATE_FORMAT(RC.fecha_capacitacion, '%d/%m/%Y') AS fecha_capacitacion,
		CONCAT_WS(' - ',RC.nombre_institucion,RC.nombre_lugar) AS nombre_lugar,
		CONCAT_WS(', ',RC.direccion_lugar, LOWER(RC.municipio),LOWER(RC.departamento)) AS direccion_lugar,
		COUNT(DISTINCT RC.id_empleado_institucion) AS total_capacitados,
		(RC.total_hombres+RC.total_mujeres) AS total_empleados,
		RC.nombre_sector,
		CASE
			WHEN RC.nombre_lugar_capacitacion IS NULL THEN 'MTPS'
			ELSE RC.nombre_lugar_capacitacion
		END AS lugar_capacitacion
		FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
		WHERE RC.asistio_empleado=1 AND RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'
		GROUP BY RC.id_lugar_trabajo
		ORDER BY numero ASC
	*/
	
	/*
		SELECT 
		@s:=@s+1 numero,
		RC.tecnico_educador,
		RC.seccion,
		COUNT(DISTINCT RC.id_capacitacion) AS total
		FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
		WHERE RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'
		GROUP BY RC.id_empleado
		ORDER BY numero ASC	
	*/
	
	/*
		SELECT
		@s:=@s+1 numero,
		RC.dui_empleado,
		RC.nombre_empleado,
		LOWER(RC.genero) AS genero,
		CASE 
			WHEN RC.id_tipo_representacion=3 THEN 'Trabajadores'
			ELSE RC.tipo_representacion
		END AS tipo_representacion,
		RC.tipo_representacion AS tipo_representacion_real,
		CONCAT_WS(' - ',RC.nombre_institucion,RC.nombre_lugar) AS nombre_lugar,
		DATE_FORMAT(RC.fecha_capacitacion, '%d/%m/%Y') AS fecha_capacitacion
		FROM sac_resultado_capacitacion AS RC, (SELECT @s:=0) AS S
		WHERE RC.asistio_empleado	=1 AND RC.fecha_capacitacion BETWEEN '$fecha_inicial' AND '$fecha_final' AND RC.fecha_capacitacion <= '".date('Y-m-d')."'
		GROUP BY RC.id_empleado_institucion
		ORDER BY numero ASC
	*/
}
?>