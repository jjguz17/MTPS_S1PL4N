<?php

class Verificacion_model extends CI_Model {
	
    function __construct() 
	{
		parent::__construct();
    }
	
	function mostrar_clasificacion() 
	{
		$sentencia="SELECT id_clasificacion AS id, nombre_clasificacion AS nombre FROM sac_clasificacion_institucion WHERE LENGTH(codigo_clasificacion)=7";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function mostrar_sector() 
	{
		$sentencia="SELECT id_sector AS id, nombre_sector AS nombre FROM sac_sector_institucion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function guardar_promocion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_institucion
					(nombre_institucion, nit_empleador, nombre_representante, id_clasificacion, id_sector, sindicato, fecha_creacion, id_usuario_crea) 
					VALUES 
					('$nombre_institucion', '$nit_empleador', '$nombre_representante', $id_clasificacion, $id_sector, '$sindicato', '$fecha_creacion', $id_usuario_crea)";
		$this->db->query($sentencia);
	}
	
	function actualizar_promocion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_institucion SET
					nombre_institucion='$nombre_institucion', nit_empleador='$nit_empleador', nombre_representante='$nombre_representante', id_clasificacion=$id_clasificacion, id_sector=$id_sector, sindicato='$sindicato', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
					WHERE id_institucion=".$id_institucion;
		$this->db->query($sentencia);
	}
	
	function mostrar_institucion($estado=NULL, $id_institucion=NULL) 
	{
		$where="";
		if($estado!=NULL)
			$where.=" AND estado=".$estado;
		if($id_institucion!=NULL)
			$where.=" AND id_institucion=".$id_institucion;
		$sentencia="SELECT id_institucion, id_institucion AS id, nombre_institucion AS nombre, id_clasificacion, id_sector, nit_empleador, nombre_representante, sindicato FROM sac_institucion WHERE TRUE ".$where;
		$query=$this->db->query($sentencia);
		if($id_institucion!=NULL)
			return (array)$query->row();
		else
			return (array)$query->result_array();
	}
	
	function eliminar_institucion($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_institucion SET estado=0, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica WHERE id_institucion=".$id_institucion;
		$this->db->query($sentencia);
	}
	
	function mostrar_tipo_lugar_trabajo() 
	{
		$sentencia="SELECT id_tipo_lugar_trabajo AS id, nombre_tipo AS nombre FROM sac_tipo_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function mostrar_municipio() 
	{
		$sentencia="SELECT org_municipio.id_municipio AS id, LOWER(CONCAT_WS(', ', org_departamento.departamento, org_municipio.municipio)) AS nombre
					FROM org_municipio
					INNER JOIN org_departamento ON org_municipio.id_departamento_pais = org_departamento.id_departamento
					ORDER BY org_departamento.departamento, org_municipio.municipio";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function guardar_lugar_trabajo($formuInfo)
	{
		extract($formuInfo);		
		$sentencia="INSERT INTO sac_lugar_trabajo
					(id_institucion, id_tipo_lugar_trabajo, nombre_lugar, direccion_lugar, id_municipio, nombre_contacto, telefono, correo, total_hombres, total_mujeres, fecha_creacion, id_usuario_crea) 
					VALUES 
					($id_institucion, $id_tipo_lugar_trabajo, '$nombre_lugar', '$direccion_lugar', $id_municipio, '$nombre_contacto', '$telefono', '$correo', $total_hombres, $total_mujeres, '$fecha_creacion', $id_usuario_crea)";
		$this->db->query($sentencia);
	}
	
	function eliminar_lugar_trabajo($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_lugar_trabajo SET estado=0, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica WHERE id_lugar_trabajo=".$id_lugar_trabajo;
		$this->db->query($sentencia);
	}
	
	function lugares_trabajo_empresa($id_institucion=NULL,$id_lugar_trabajo=NULL)
	{
		if($id_institucion!=NULL)
			$sentencia="SELECT id_lugar_trabajo AS id, nombre_lugar AS nombre FROM sac_lugar_trabajo WHERE sac_lugar_trabajo.estado>=1 AND id_institucion=".$id_institucion;
		else
			if($id_lugar_trabajo!=NULL)
				$sentencia="SELECT id_lugar_trabajo, id_lugar_trabajo AS id, nombre_lugar AS nombre, id_institucion,id_tipo_lugar_trabajo, id_municipio, direccion_lugar, nombre_contacto, telefono, correo, total_hombres, total_mujeres, DATE_FORMAT(fecha_conformacion,'%d/%m/%Y') AS fecha_conformacion FROM sac_lugar_trabajo WHERE sac_lugar_trabajo.estado>=1 AND id_lugar_trabajo=".$id_lugar_trabajo;
			else
				$sentencia="SELECT id_lugar_trabajo AS id, nombre_lugar AS nombre FROM sac_lugar_trabajo WHERE sac_lugar_trabajo.estado>=1";
		$query=$this->db->query($sentencia);
		if($id_lugar_trabajo!=NULL)
			return (array)$query->row();
		else
			return (array)$query->result_array();
	}
	
	function mostrar_tecnicos($id_seccion=NULL,$ss=NULL)
	{
		$where="";
		if($id_seccion!=NULL && $ss!=NULL) {
			if($ss==1) 
				for($i=0;$i<count($this->secciones);$i++)
				 	$where.=" AND id_seccion<>".$this->secciones[$i];
			else
				$where.=" AND id_seccion=".$id_seccion;
		}
		$sentencia="SELECT id_empleado AS id, nombre FROM tcm_empleado 
					WHERE (funcional LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL' OR nominal LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL') ".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	public function ubicacion_departamento($id_seccion)
	{	
		switch($id_seccion){
			case 52:
				$id_departamento=1;
				break;
			case 53:
				$id_departamento=9;
				break;
			case 54:
				$id_departamento=4;
				break;
			case 55:
				$id_departamento=7;
				break;
			case 56:
				$id_departamento=5;
				break;
			case 57:
				$id_departamento=14;
				break;
			case 58:
				$id_departamento=13;
				break;
			case 59:
				$id_departamento=10;
				break;
			case 60:
				$id_departamento=3;
				break;
			case 61:
				$id_departamento=11;
				break;
			case 64:
				$id_departamento=8;
				break;
			case 65:
				$id_departamento=12;
				break;
			case 66:
				$id_departamento=2;
				break;
			default:
				$id_departamento=6;
		}
		return $id_departamento;
	}
	
	function institucion_visita($id_departamento)
	{
		/*$sentencia="SELECT DISTINCT sac_institucion.id_institucion AS id, sac_institucion.nombre_institucion AS nombre
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					WHERE sac_institucion.estado=1 AND sac_lugar_trabajo.estado>=1 AND sac_lugar_trabajo.fecha_conformacion IS NOT NULL AND org_departamento.id_departamento=".$id_departamento;*/
		$sentencia="SELECT DISTINCT sac_institucion.id_institucion AS id, sac_institucion.nombre_institucion AS nombre
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					WHERE sac_institucion.estado=1 AND sac_lugar_trabajo.estado=2 AND org_departamento.id_departamento=".$id_departamento;
		//echo $sentencia;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function institucion_visita_nuevo($id_departamento=0)
	{
		$dias=10;
		$where="FALSE";
		$where="sac_lugar_trabajo.estado=3 AND DATEDIFF(CURRENT_TIMESTAMP(),sac_lugar_trabajo.fecha_conformacion)>=".$dias;
		$sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre 
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					WHERE sac_institucion.estado=1 AND (sac_lugar_trabajo.estado=2 OR (".$where.")) AND org_departamento.id_departamento=".$id_departamento." 
					GROUP BY sac_lugar_trabajo.id_lugar_trabajo,sac_lugar_trabajo.nombre_lugar
					HAVING (MAX(sac_programacion_visita.estado_programacion)<>3 OR MAX(sac_programacion_visita.estado_programacion) IS NULL)";
		$query=$this->db->query($sentencia);
		//echo $sentencia;
		return (array)$query->result_array();
	}
	
	function lugares_trabajo_institucion_visita($id_departamento,$id_institucion=NULL,$mostrar_todos="FALSE",$id_lugar_trabajo=NULL)
	{
		$where="";
		$w2="";
		if($id_institucion!=NULL)
			$where.="AND sac_lugar_trabajo.id_institucion=".$id_institucion." ";
		if($mostrar_todos=="FALSE") {
			/*$where.="AND (sac_programacion_visita.estado_programacion<>1 OR sac_lugar_trabajo.fecha_conformacion IS NOT NULL";*/
			/*$where.="AND (sac_lugar_trabajo.fecha_conformacion IS NOT NULL";*/
			$where.="AND (TRUE ";
			if($id_lugar_trabajo!=NULL) {
				$where.=" OR sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo;
				$w2=" OR sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo;
			}
			$where.=") ";
		}
		$sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, sac_lugar_trabajo.nombre_lugar AS nombre
					FROM sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					WHERE sac_lugar_trabajo.estado=2 AND org_departamento.id_departamento=".$id_departamento." ".$where."
					GROUP BY sac_lugar_trabajo.id_lugar_trabajo,sac_lugar_trabajo.nombre_lugar
					HAVING (MAX(sac_programacion_visita.estado_programacion)<>3 OR MAX(sac_programacion_visita.estado_programacion) IS NULL) ".$w2;
		//echo $sentencia;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function lugares_trabajo_institucion_visita_nuevo($id_empleado=0,$id_programacion_visita=NULL)
	{
		$where="";
		if($id_programacion_visita!=NULL)
			$where=" OR sac_programacion_visita.id_programacion_visita=".$id_programacion_visita;
		$sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE (sac_programacion_visita.fecha_visita like '0000-00-00' AND sac_programacion_visita.hora_visita like '00:00:00' AND sac_lugar_trabajo.estado=2 AND sac_programacion_visita.id_empleado=".$id_empleado.")".$where;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function es_san_salvador($id_seccion)
	{	
		if(in_array($id_seccion,$this->secciones)){
			return false;
		}else{
			return true;
		}
	}
	
	function ver_asignaciones($id_empleado)
	{
		$sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre 
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE sac_lugar_trabajo.estado=2 AND sac_programacion_visita.estado_programacion=3 AND sac_programacion_visita.id_empleado=".$id_empleado;
		$query=$this->db->query($sentencia);
		//echo $sentencia;
		return (array)$query->result_array();
	}
	
	function eliminar_asignacion($id_empleado,$cad)
	{
		$sentencia="DELETE FROM sac_programacion_visita WHERE id_empleado=".$id_empleado." AND estado_programacion=3 ".$cad;
		$this->db->query($sentencia);
	}
	
	function buscar_asignacion($id_empleado=0,$id_lugar_trabajo=0)
	{
		$sentencia="SELECT COUNT(*) AS total FROM sac_programacion_visita WHERE id_empleado=".$id_empleado." AND id_lugar_trabajo=".$id_lugar_trabajo." AND estado_programacion=3";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function guardar_asignacion($formuInfo)
	{
		extract($formuInfo);		
		$sentencia="INSERT INTO sac_programacion_visita
					(id_empleado, id_lugar_trabajo, estado_programacion, fecha_creacion, id_usuario_crea) 
					VALUES 
					($id_empleado, $id_lugar_trabajo, 3, '$fecha_creacion', $id_usuario_crea)";
		$this->db->query($sentencia);
	}
	
	function comprobar_programacion($formuInfo)
	{
		extract($formuInfo);
		$where="";
		if($estado_programacion!=NULL && $estado_programacion!="")
			$where.=" AND estado_programacion=".$estado_programacion;
		if($id_programacion_visita!=NULL && $id_programacion_visita!="")
			$where.=" AND id_programacion_visita<>".$id_programacion_visita;
		$sentencia="SELECT Count(*) AS total FROM sac_programacion_visita
					WHERE id_empleado=".$id_empleado." AND fecha_visita like '".$fecha_visita."' 
					AND ((hora_visita >= '".$hora_visita."' AND hora_visita < '".$hora_visita_final."') OR (hora_visita_final > '".$hora_visita."' AND hora_visita_final <= '".$hora_visita_final."'))
					".$where;
		//echo $sentencia;
		$query=$this->db->query($sentencia);
		$val=(array)$query->row();
		if($val['total']==0)
			return 1;
		else
			return 0;
	}
	
	function guardar_programacion($formuInfo)
	{
		extract($formuInfo);		
		$sentencia="INSERT INTO sac_programacion_visita
					(id_empleado, id_lugar_trabajo, fecha_visita, hora_visita, hora_visita_final, estado_programacion, fecha_creacion, id_usuario_crea) 
					VALUES 
					($id_empleado, $id_lugar_trabajo, '$fecha_visita', '$hora_visita', '$hora_visita_final', $estado_programacion, '$fecha_creacion', $id_usuario_crea)";
		$this->db->query($sentencia);
	}
	
	function calendario($id_empleado)
	{	
		$sentencia="SELECT
					CONCAT_WS(' ','N° visitas: ',COUNT(*)) AS titulo,
					fecha_visita AS fecha
					FROM sac_programacion_visita
					WHERE id_empleado=".$id_empleado." AND fecha_visita>='".date('Y-m-01', strtotime('-6 month'))."'
					GROUP BY fecha_visita";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function calendario_dia($id_empleado,$fecha)
	{	
		$sentencia="SELECT
					id_programacion_visita AS id,
					sac_lugar_trabajo.nombre_lugar AS titulo,
					sac_institucion.nombre_institucion AS titulo2,
					fecha_visita AS fecha,
					DATE_FORMAT(hora_visita,'%h:%i %p') AS hora,
					DATE_FORMAT(hora_visita_final,'%h:%i %p') AS hora_final,
					DATE_FORMAT(hora_visita,'%H:%i') AS hora_m,
					estado_programacion AS estado
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE id_empleado=".$id_empleado." AND fecha_visita='".$fecha."'";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_programacion($id_programacion_visita)
	{
		$sentencia="DELETE FROM sac_programacion_visita WHERE id_programacion_visita=".$id_programacion_visita;
		$this->db->query($sentencia);
	}
	
	function actualizar_lugar_trabajo($formuInfo)
	{
		extract($formuInfo);		
		$sentencia="UPDATE sac_lugar_trabajo SET
					id_institucion=$id_institucion, id_tipo_lugar_trabajo=$id_tipo_lugar_trabajo, nombre_lugar='$nombre_lugar', direccion_lugar='$direccion_lugar', id_municipio=$id_municipio, nombre_contacto='$nombre_contacto', telefono='$telefono', correo='$correo', total_hombres=$total_hombres, total_mujeres=$total_mujeres, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
					WHERE id_lugar_trabajo=".$id_lugar_trabajo;
		$this->db->query($sentencia);
	}
	
	function buscar_programacion($id_programacion_visita)
	{
		$sentencia="SELECT sac_programacion_visita.id_programacion_visita, sac_institucion.id_institucion, sac_programacion_visita.id_lugar_trabajo, id_empleado, DATE_FORMAT(fecha_visita,'%d/%m/%Y') AS fecha_visita, DATE_FORMAT(hora_visita,'%h:%i %p') AS hora_visita 
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE id_programacion_visita=".$id_programacion_visita;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function actualizar_programacion($formuInfo)
	{
		extract($formuInfo);		
		$sentencia="UPDATE sac_programacion_visita SET
					id_empleado=$id_empleado, id_lugar_trabajo=$id_lugar_trabajo, fecha_visita='$fecha_visita', hora_visita='$hora_visita', hora_visita_final='$hora_visita_final', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_programacion_visita=".$id_programacion_visita;
		$this->db->query($sentencia);
	}
	
	function fecha_letras($fecha=NULL,$formato="mysql")
	{
		$dias = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
		$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		if($fecha==NULL) {
			$fecha=date('Y-m-d');
			$formato="mysql";
		}
		switch($formato){
			case "mysql":
				$fec=explode("-",$fecha);
				$dia=$fec[2];
				$mes=$fec[1];
				$anio=$fec[0];
				break;
			default:
				$fec=explode("/",$fecha);
				$dia=$fec[0];
				$mes=$fec[1];
				$anio=$fec[2];
				break;
		}
		
		return $dias[date('w', strtotime($fecha))]." ".$dia." de ".$meses[date('n', strtotime($fecha))]." de ".$anio;
	}
	
	function insticion_lugar_trabajo($id_empleado,$fecha,$estado=1)
	{
		/*$sentencia="SELECT
					CONCAT_WS('***',id_programacion_visita,sac_lugar_trabajo.id_institucion,sac_programacion_visita.id_lugar_trabajo) AS id,
					CONCAT_WS(' - ',sac_institucion.nombre_institucion,sac_lugar_trabajo.nombre_lugar) AS nombre
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE id_empleado=".$id_empleado." AND fecha_visita<='".$fecha."' AND estado_programacion=".$estado;*/
		$sentencia="SELECT
					CONCAT_WS('***',id_programacion_visita,sac_lugar_trabajo.id_institucion,sac_programacion_visita.id_lugar_trabajo) AS id,
					CONCAT_WS(' - ',sac_institucion.nombre_institucion,sac_lugar_trabajo.nombre_lugar) AS nombre
					FROM sac_programacion_visita
					INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					WHERE id_empleado=".$id_empleado." AND estado_programacion=".$estado;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function actualizar_estado_programacion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="UPDATE sac_programacion_visita SET
					estado_programacion=$estado_programacion, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_programacion_visita=".$id_programacion_visita;
		$this->db->query($sentencia);
	}
	
	function guardar_ingreso_promocion($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_promocion 
					(id_programacion_visita,fecha_promocion,hora_inicio,hora_final,nombre_recibio,observaciones,id_estado_verificacion,fecha_creacion,id_usuario_crea)
					VALUES 
					($id_programacion_visita,'$fecha_promocion','$hora_inicio','$hora_final','$nombre_recibio','$observaciones',$id_estado_verificacion,'$fecha_creacion',$id_usuario_crea)";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function resultados_instituciones_no_se_utiliza($fecha_inicial,$fecha_final)
	{
		$sentencia="SELECT
					sac_promocion.id_promocion,
					LOWER(CONCAT_WS(', ',org_departamento.departamento,org_municipio.municipio)) AS ubicacion,
					CONCAT_WS(' - ',sac_institucion.nombre_institucion,sac_lugar_trabajo.nombre_lugar) AS institucion,
					sac_sector_institucion.nombre_sector,
					sac_lugar_trabajo.total_hombres,
					sac_lugar_trabajo.total_mujeres,
					sac_institucion.sindicato,
					tcm_empleado.nombre,
					DATE_FORMAT(sac_promocion.fecha_promocion, '%d/%m/%y') AS fecha
					FROM
					sac_institucion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
					INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
					INNER JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_promocion ON sac_promocion.id_programacion_visita = sac_programacion_visita.id_programacion_visita
					INNER JOIN sac_sector_institucion ON sac_institucion.id_sector = sac_sector_institucion.id_sector
					INNER JOIN tcm_empleado ON tcm_empleado.id_empleado = sac_programacion_visita.id_empleado
					WHERE sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function resultados_tecnicos_no_se_utiliza($fecha_inicial,$fecha_final)
	{
		$sentencia="SELECT
					tcm_empleado.seccion,
					tcm_empleado.id_seccion,
					tcm_empleado.nombre,
					(COUNT(*)-1) AS total
					FROM
					tcm_empleado
					LEFT JOIN sac_programacion_visita ON tcm_empleado.id_empleado = sac_programacion_visita.id_empleado
					LEFT JOIN sac_promocion ON sac_promocion.id_programacion_visita = sac_programacion_visita.id_programacion_visita
					WHERE (funcional LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL' OR nominal LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL') AND (sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final' OR sac_promocion.fecha_promocion IS NULL)
					GROUP BY tcm_empleado.id_empleado, tcm_empleado.nombre";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}

	function resultados_sectores($fecha_inicial,$fecha_final)
	{
		$sentencia="SELECT
					sac_clasificacion_institucion.nombre_clasificacion AS nombre,
					COUNT(*) AS total
					FROM
					sac_clasificacion_institucion
					INNER JOIN sac_institucion ON sac_institucion.id_clasificacion = sac_clasificacion_institucion.id_clasificacion
					INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
					INNER JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
					INNER JOIN sac_promocion ON sac_promocion.id_programacion_visita = sac_programacion_visita.id_programacion_visita
					WHERE sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'
					GROUP BY sac_clasificacion_institucion.nombre_clasificacion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultas_promociones($select=array('*'),$where=array(),$group=array(),$order=array())
	{	
		$sel='';
		for($i=0;$i<count($select);$i++) {
			if($i>0)
				$sel.=', ';
			$sel.=$select[$i];
		}
		$whe='';
		for($i=0;$i<count($where);$i++) {
			if($i>0)
				$whe.=' ';
			$whe.=$where[$i];
		}
		$gro='';
		for($i=0;$i<count($group);$i++) {
			if($i>0)
				$gro.=', ';
			else
				$gro.='GROUP BY ';
			$gro.=$group[$i];
		}
		$ord='';
		for($i=0;$i<count($order);$i++) {
			if($i>0)
				$ord.=', ';
			else
				$gro.='ORDER BY ';
			$ord.=$order[$i];
		}
		$sentencia="SELECT ".$sel." FROM sac_resultado_promocion WHERE TRUE ".$whe." ".$gro." ".$ord;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultas_promociones_departamentos()
	{
		$sentencia="SELECT 
					CASE org_departamento.id_departamento
						WHEN 1 THEN 'AHU' 
						WHEN 2 THEN 'ANA'
						WHEN 3 THEN 'SON'
						WHEN 4 THEN 'CHA' 
						WHEN 5 THEN 'LIB'
						WHEN 6 THEN 'SS'
						WHEN 7 THEN 'CUS' 
						WHEN 8 THEN 'PAZ'
						WHEN 9 THEN 'CAB'
						WHEN 10 THEN 'SV' 
						WHEN 11 THEN 'USU'
						WHEN 12 THEN 'MIG'
						WHEN 13 THEN 'MOR' 
						WHEN 14 THEN 'UNI' 
					END AS codigo,
					CASE org_departamento.id_departamento
						WHEN 1 THEN 'AH' 
						WHEN 2 THEN 'SA'
						WHEN 3 THEN 'SO'
						WHEN 4 THEN 'CH' 
						WHEN 5 THEN 'LL'
						WHEN 6 THEN 'SS'
						WHEN 7 THEN 'CU' 
						WHEN 8 THEN 'LP'
						WHEN 9 THEN 'CA'
						WHEN 10 THEN 'SV' 
						WHEN 11 THEN 'US'
						WHEN 12 THEN 'SM'
						WHEN 13 THEN 'MO' 
						WHEN 14 THEN 'LU' 
					END AS codigo2,
					COUNT(id_promocion) AS total
					FROM org_departamento
					LEFT JOIN sac_resultado_promocion ON org_departamento.id_departamento=sac_resultado_promocion.id_departamento
					WHERE org_departamento.id_departamento<15
					GROUP BY org_departamento.departamento
					ORDER BY org_departamento.departamento";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function total_promociones_clasificacion()
	{
		$sentencia="SELECT 
					sac_clasificacion_institucion.nombre_clasificacion,
					COUNT(id_promocion) AS total
					FROM sac_clasificacion_institucion
					INNER JOIN sac_resultado_promocion ON sac_clasificacion_institucion.id_clasificacion=sac_resultado_promocion.id_clasificacion
					GROUP BY sac_clasificacion_institucion.nombre_clasificacion
					ORDER BY COUNT(id_promocion) DESC LIMIT 0,5";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function consultas_promociones_sector()
	{
		$sentencia="SELECT 
					sac_sector_institucion.nombre_sector,
					COUNT(id_promocion) AS total
					FROM sac_sector_institucion
					INNER JOIN sac_resultado_promocion ON sac_sector_institucion.id_sector=sac_resultado_promocion.id_sector
					GROUP BY sac_sector_institucion.nombre_sector
					ORDER BY sac_sector_institucion.nombre_sector";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function ver_tematicas()
	{
		$sentencia="SELECT id_tematica AS id, nombre_tematica AS nombre FROM sac_tematica";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function ver_estados_verificacion()
	{
		$sentencia="SELECT id_estado_verificacion AS id, nombre_estado_verificacion AS nombre FROM sac_estado_verificacion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function guardar_ingreso_tematica($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_control_visita 
					(id_programacion_visita,id_tematica,fecha_capacitacion,facilitador)
					VALUES 
					($id_programacion_visita,$id_tematica,'$fecha_capacitacion','$facilitador')";
		$query=$this->db->query($sentencia);
	}
	
	function guardar_ingreso_miembros_entrevistados($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO sac_miembro_entrevistado 
					(id_promocion,id_empleado_institucion)
					VALUES 
					($id_promocion,$id_empleado_institucion)";
		$query=$this->db->query($sentencia);
	}

	function resultados_instituciones($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RV.id_departamento=".$id_departamento;
		}		
		$sentencia="SELECT
					@s:=@s+1 AS numero,
					CONCAT_WS(' - ',RV.nombre_institucion,RV.nombre_lugar) AS nombre_lugar,
					CONCAT_WS(', ',RV.direccion_lugar, LOWER(RV.municipio),LOWER(RV.departamento)) AS direccion_lugar,
					DATE_FORMAT(RV.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
					DATE_FORMAT(RV.hora_inicio,'%h:%i %p') AS hora_promocion,
					RV.nombre_recibio,
					RV.observaciones,
					RV.nombre_estado_verificacion,
					GROUP_CONCAT(DISTINCT RV.nombre_empleado_institucion,' (',IF(RV.nombre_cargo_comite IS NULL, 'Sin Cargo', RV.nombre_cargo_comite),')') AS entrevistados,
					GROUP_CONCAT(DISTINCT RV.nombre_tematica,' - ',DATE_FORMAT(RV.fecha_capacitacion, '%d/%m/%Y'),' (',RV.facilitador,')') AS tematicas
					FROM sac_resultado_verificacion AS RV, (SELECT @s:=0) AS S
					WHERE RV.id_promocion IS NOT NULL AND RV.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
					GROUP BY RV.id_lugar_trabajo
					ORDER BY RV.fecha_promocion ASC";
		
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}

	function resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RV.id_departamento=".$id_departamento;
		}		
		$sentencia="SELECT
					@s:=@s+1 AS numero,
					RV.seccion,
					RV.nombre_empleado AS nombre,
					COUNT(DISTINCT RV.id_promocion) AS total
					FROM sac_resultado_verificacion AS RV, (SELECT @s:=0) AS S
					WHERE RV.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
					GROUP BY RV.id_empleado
					ORDER BY numero ASC";
		
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}

	function resultados_otros($fecha_inicial,$fecha_final,$id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND RV.id_departamento=".$id_departamento;
		}		
		$sentencia="";
		
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}

	function guardar_verificacion_comite($formuInfo)
	{
		extract($formuInfo);
		/*$sentencia="UPDATE sac_lugar_trabajo SET
					estado='$estado',
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_lugar_trabajo=$id_lugar_trabajo";*/
		/*
		*	Hice esto para que un establecimiento solo pueda tener una sola verificación
		*/
		$sentencia="UPDATE sac_lugar_trabajo SET
					estado=estado+1,
					fecha_modificacion='$fecha_modificacion',
					id_usuario_modifica=$id_usuario_modifica 
					WHERE id_lugar_trabajo=$id_lugar_trabajo";
		$query=$this->db->query($sentencia);
		return true;
	}

	function consultas_verificaciones_ultimos_meses($id_departamento=NULL)
	{
		$where="";
		if($id_departamento!=NULL) {
			$where.=" AND id_departamento=".$id_departamento;
		}
		$sentencia="SELECT 
					EV.nombre_estado_verificacion AS estado,
					COUNT(RV.id_estado_verificacion) AS total
					FROM sac_estado_verificacion AS EV
					LEFT JOIN (
						SELECT RV.id_lugar_trabajo, RV.id_estado_verificacion
						FROM sac_resultado_verificacion AS RV 
						WHERE (RV.fecha_promocion>=CONCAT_WS('-',YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)),MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)),'01') OR RV.id_promocion IS NULL) ".$where."
						GROUP BY RV.id_lugar_trabajo
						ORDER BY RV.id_promocion DESC
					) AS RV ON RV.id_estado_verificacion=EV.id_estado_verificacion
					GROUP BY EV.nombre_estado_verificacion";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
}
?>