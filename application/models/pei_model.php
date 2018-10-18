<?php

class Pei_model extends CI_Model {
    
    /*Secciones que no pertenecen a San Salvador*/
    public $secciones=array(52,53,54,55,56,57,58,59,60,61,64,65,66); 
    
    function __construct() 
    {
        parent::__construct();
    }

    function es_san_salvador($id_seccion)
    {   
        if(in_array($id_seccion,$this->secciones)){
            return false;
        }else{
            return true;
        }
    }
    
    function guardar_documento($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_documento
                    (nombre_pei, fecha_aprobacion, nombre_documento, inicio_periodo, fin_periodo, observacion, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ('$nombre_pei', '$fecha_aprobacion', '$nombre_documento', $inicio_periodo, $fin_periodo, '$observacion', '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function buscar_documentos($id_documento='NULL') 
    {
        //busca el documento con valor de id $id_documento, si $id_documento es NULL los muestra todos
        $sentencia="SELECT 
                    D.id_documento,
					nombre_pei,
                    DATE_FORMAT(D.fecha_aprobacion,'%d/%m/%Y') AS fecha_aprobacion,
                    YEAR(D.fecha_aprobacion) AS A,
                    D.nombre_documento,
					D.inicio_periodo,
					D.fin_periodo,
                    D.observacion,
                    D.fecha_creacion,
                    D.id_usuario_crea,
                    D.fecha_modificacion,
                    D.id_usuario_modifica 
                    FROM pat_documento AS D
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
                    ORDER BY D.fecha_aprobacion DESC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array(); //Se retorna el obejto que contiene los registros en forma de array
    }
    
    function actualizar_documento($formuInfo)
    {
        extract($formuInfo);
        if($nombre_documento!="")
            $sentencia="UPDATE pat_documento SET
                        nombre_pei='$nombre_pei', fecha_aprobacion='$fecha_aprobacion', nombre_documento='$nombre_documento', inicio_periodo=$inicio_periodo, fin_periodo=$fin_periodo, observacion='$observacion', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
                        WHERE id_documento=".$id_documento;
        else
            $sentencia="UPDATE pat_documento SET
                        nombre_pei='$nombre_pei', fecha_aprobacion='$fecha_aprobacion', inicio_periodo=$inicio_periodo, fin_periodo=$fin_periodo, observacion='$observacion', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
                        WHERE id_documento=".$id_documento;
        $this->db->query($sentencia);
    }

    function eliminar_documento($id_documento=0)
    {
        $sentencia="DELETE FROM pat_documento WHERE id_documento=$id_documento";
        $this->db->query($sentencia);
    }

    function guardar_nivel($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_nivel
                    (id_documento, tipo_nivel, nivel, nombre_nivel, indicador, abreviacion, id_padre) 
                    VALUES 
                    ($id_documento, $tipo_nivel, $nivel, '$nombre_nivel', $indicador, '$abreviacion', $id_padre)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_nivel($formuInfo)
    {
        extract($formuInfo);
		$sentencia="UPDATE pat_nivel SET
                    nivel=$nivel, nombre_nivel='$nombre_nivel', indicador=$indicador, abreviacion='$abreviacion', id_padre=$id_padre
					WHERE id_nivel=$id_nivel";
        /*$sentencia="UPDATE pat_nivel SET
                    nombre_nivel='$nombre_nivel', indicador=$indicador, abreviacion='$abreviacion'
					WHERE id_documento=$id_documento AND nivel=$nivel AND id_padre=$id_padre";*/
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_nivel2($formuInfo)
    {
        extract($formuInfo);
		if($agrupar_numeracion=="")
			$agrupar_numeracion=0;
		if($agregar_separador=="")
			$agregar_separador=0;
		$sentencia="UPDATE pat_nivel SET
                    agrupar_numeracion=$agrupar_numeracion,
                    agregar_separador=$agregar_separador
					WHERE id_nivel=$id_nivel";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function buscar_nivel($id_documento='NULL', $tipo_nivel='NULL', $id_nivel='NULL') 
    {
        $sentencia="SELECT 
                    D.id_nivel,
                    D.id_documento,
					D.tipo_nivel,
                    D.nivel,
                    D.nombre_nivel,
					LOWER(D.nombre_nivel) AS nombre_nivel_l,
                    IF(D.indicador=1,'true','false') AS indicador,
                    D.abreviacion,
                    D.id_padre,
					IF(D.agrupar_numeracion=1,'checked=\"checked\"','') AS agrupar_numeracion,
					IF(D.agregar_separador=1,'checked=\"checked\"','') AS agregar_separador
                    FROM pat_nivel AS D
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
					AND IFNULL(D.tipo_nivel,0)=IFNULL(".$tipo_nivel.",IFNULL(D.tipo_nivel,0))
                    AND IFNULL(D.id_nivel,0)=IFNULL(".$id_nivel.",IFNULL(D.id_nivel,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function eliminar_nivel($id_documento=0)
    {
        $sentencia="DELETE FROM pat_nivel WHERE id_documento=$id_documento";
        $this->db->query($sentencia);
    }

    function buscar_items($id_documento='NULL', $id_nivel='NULL', $id_item='NULL') 
    {
        $sentencia="SELECT DISTINCT
                    I.id_item,
                    I.id_nivel,
                    I.id_seccion,
                    REPLACE(I.correlativo_item,'\n','') AS correlativo_item,
                    REPLACE(I.descripcion_item,'\n','') AS descripcion_item,
                    I.id_padre,
                    I2.correlativo_item AS correlativo_item_p,
                    I2.descripcion_item AS descripcion_item_p,
					D.indicador AS indi
                    FROM pat_nivel AS D
                    INNER JOIN pat_item AS I ON I.id_nivel=D.id_nivel
                    LEFT JOIN pat_item AS I2 ON I2.id_item=I.id_padre
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
                    AND IFNULL(I.id_nivel,0)=IFNULL(".$id_nivel.",IFNULL(I.id_nivel,0))
                    AND IFNULL(I.id_item,0)=IFNULL(".$id_item.",IFNULL(I.id_item,0))
					ORDER BY I.id_nivel, I.id_padre";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function guardar_wizard($formuInfo)
    {
        extract($formuInfo);
		if($id_seccion=="")
			$id_seccion="NULL";
        $sentencia="INSERT INTO pat_item
                    (id_nivel, id_seccion, correlativo_item, descripcion_item, id_padre, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_nivel, $id_seccion, '$correlativo_item', '$descripcion_item', $id_padre, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function eliminar_wizard($formuInfo)
    {
        extract($formuInfo);
        $sentencia="DELETE FROM pat_item WHERE id_item='$id_item'";
        $this->db->query($sentencia);
    }

    function actualizar_wizard($formuInfo)
    {
        extract($formuInfo);
		if($id_seccion=="")
			$id_seccion="NULL";
		$sentencia="UPDATE pat_item SET
                    id_padre=$id_padre, correlativo_item='$correlativo_item', id_seccion=$id_seccion, descripcion_item='$descripcion_item', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_item='$id_item'";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }	
    
    function buscar_seccion($id_seccion='NULL') 
    {
        $sentencia="SELECT id_seccion, nombre_seccion FROM org_seccion WHERE IFNULL(id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(id_seccion,0))
					UNION
					SELECT 10000 AS id_seccion, 'OFICINAS REGIONALES' AS nombre_seccion
					UNION
					SELECT 10001 AS id_seccion, 'OFICINAS DEPARTAMENTALES' AS nombre_seccion";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
	
	function buscar_presupuesto($id_item='NULL', $id_presupuesto='NULL') 
    {
        $sentencia="SELECT 
					id_presupuesto,
					id_item, 
					clasificacion_gasto, 
					CASE WHEN presupuesto=0 THEN NULL ELSE presupuesto END AS presupuesto, 
					anio 
					FROM pat_presupuesto
					WHERE IFNULL(id_presupuesto,0)=IFNULL(".$id_presupuesto.",IFNULL(id_presupuesto,0))
                    AND IFNULL(id_item,0)=IFNULL(".$id_item.",IFNULL(id_item,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
	
	function buscar_unidades_apoyo($id_item='NULL') 
    {
        $sentencia="SELECT 
					ISE.id_item,
					ISE.id_seccion, 
					S.nombre_seccion, 
					ISE.id_tipo_apoyo
					FROM pat_item_seccion AS ISE
					INNER JOIN (
					SELECT id_seccion, nombre_seccion FROM org_seccion
					UNION
					SELECT 10000, 'OFICINAS REGIONALES'
					UNION
					SELECT 10001, 'OFICINAS DEPARTAMENTALES'
					) AS S ON S.id_seccion=ISE.id_seccion
					WHERE IFNULL(id_item,0)=IFNULL(".$id_item.",IFNULL(id_item,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function guardar_presupuesto($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_presupuesto
                    (id_item, clasificacion_gasto, presupuesto, anio, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_item, '$clasificacion_gasto', $presupuesto, $anio, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_presupuesto($formuInfo)
    {
        extract($formuInfo);
		$sentencia="UPDATE pat_presupuesto SET
                    clasificacion_gasto='$clasificacion_gasto', presupuesto=$presupuesto, anio=$anio, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_presupuesto=$id_presupuesto";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function eliminar_presupuesto($formuInfo)
    {
        extract($formuInfo);
        $sentencia="DELETE FROM pat_presupuesto WHERE id_presupuesto=$id_presupuesto";
        $this->db->query($sentencia);
    }
	
	function guardar_item_seccion($formuInfo)
	{
        extract($formuInfo);
        $sentencia="INSERT INTO pat_item_seccion
                    (id_item, id_seccion, id_tipo_apoyo) 
                    VALUES 
                    ($id_item, $id_seccion, $id_tipo_apoyo)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
	}
	
	function eliminar_item_seccion($id_item)
	{
        extract($formuInfo);
        $sentencia="DELETE FROM pat_item_seccion WHERE id_item=$id_item";
        $this->db->query($sentencia);
	}
}
?>