<?php

class Promocion_model extends CI_Model {
    
    /*Secciones que no pertenecen a San Salvador*/
    public $secciones=array(52,53,54,55,56,57,58,59,60,61,64,65,66); 
    
    function __construct() 
    {
        parent::__construct();
    }
    
    function mostrar_clasificacion() 
    {
        $sentencia="SELECT id_clasificacion AS id, CONCAT_WS(' - ',codigo_clasificacion,nombre_clasificacion) AS nombre FROM sac_clasificacion_institucion WHERE LENGTH(codigo_clasificacion)=7";
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
    
    function mostrar_tecnicos_disponibles_por_dia($id_seccion=NULL,$ss=NULL,$fecha=NULL,$id_capacitacion=NULL,$id_empleado=NULL)
    {
        $where="";
        if($id_seccion!=NULL && $ss!=NULL) {
            if($ss==1) 
                for($i=0;$i<count($this->secciones);$i++)
                    $where.=" AND id_seccion<>".$this->secciones[$i];
            else
                $where.=" AND id_seccion=".$id_seccion;
        }
        if ($id_empleado!=NULL) {
            $where.=" AND tcm_empleado.id_empleado=".$id_empleado;
        }
        $w="";
        if($fecha==NULL)
            $f=date('Y-m-d');
        else {
            $f=$fecha;
            $w=" AND sac_capacitacion.id_capacitacion<>'".$id_capacitacion."'";
        }
        /*$sentencia="SELECT
                    tcm_empleado.id_empleado AS id,
                    tcm_empleado.nombre,
                    CASE 
                        WHEN (sac_capacitacion.fecha_capacitacion='".$f."' AND sac_capacitacion.estado_capacitacion=1 ".$w.") THEN 'disabled' ELSE ''
                    END AS activo
                    FROM
                    tcm_empleado
                    LEFT JOIN sac_capacitador ON sac_capacitador.id_empleado = tcm_empleado.id_empleado
                    LEFT JOIN sac_capacitacion ON sac_capacitador.id_capacitacion = sac_capacitacion.id_capacitacion
                    WHERE (funcional LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL' OR nominal LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL') ".$where;*/
        $sentencia="SELECT DISTINCT
                    tcm_empleado.id_empleado AS id,
                    tcm_empleado.nombre,
                    CASE 
                        WHEN (sac_capacitacion.fecha_capacitacion='".$f."' ".$w.") THEN 'disabled' ELSE ''
                    END AS activo
                    FROM
                    tcm_empleado
                    LEFT JOIN (
                        SELECT id_empleado,fecha_capacitacion,sac_capacitacion.id_capacitacion
                        FROM sac_capacitador
                        LEFT JOIN sac_capacitacion ON sac_capacitador.id_capacitacion = sac_capacitacion.id_capacitacion 
                        WHERE sac_capacitacion.fecha_capacitacion='".$f."'
                    ) AS sac_capacitacion ON tcm_empleado.id_empleado = sac_capacitacion.id_empleado
                    WHERE (funcional LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL' OR nominal LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL') ".$where;
        //echo "<br><br><br><br><br><br><br><br><br><br><br><br>".$sentencia;
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
    
    function institucion_visita_nuevo($id_departamento=0)
    {
        $sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre 
                    FROM sac_institucion 
                    INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion 
                    INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio 
                    INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais 
                    LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo 
                    WHERE sac_lugar_trabajo.estado=1 
                    AND sac_programacion_visita.estado_programacion IS NULL
                    AND org_departamento.id_departamento=".$id_departamento;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function institucion_visita($id_departamento)
    {
        $sentencia="SELECT DISTINCT sac_institucion.id_institucion AS id, sac_institucion.nombre_institucion AS nombre
                    FROM sac_institucion
                    INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
                    LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
                    INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
                    INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
                    WHERE sac_institucion.estado=1 AND sac_lugar_trabajo.estado=1 AND org_departamento.id_departamento=".$id_departamento;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function lugares_trabajo_institucion_visita($id_departamento,$id_institucion=NULL,$mostrar_todos="FALSE",$id_lugar_trabajo=NULL)
    {
        $where="";
        if($id_institucion!=NULL)
            $where.="AND sac_lugar_trabajo.id_institucion=".$id_institucion." ";
        if($mostrar_todos=="FALSE") {
            /*$where.="AND (sac_programacion_visita.estado_programacion<>1 OR sac_programacion_visita.estado_programacion IS NULL";*/
            $where.="AND (sac_programacion_visita.estado_programacion IS NULL";
            if($id_lugar_trabajo!=NULL)
                $where.=" OR sac_lugar_trabajo.id_lugar_trabajo=".$id_lugar_trabajo;
            $where.=") ";
        }
        $sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, sac_lugar_trabajo.nombre_lugar AS nombre
                    FROM sac_institucion
                    INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
                    INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
                    INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
                    LEFT JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
                    WHERE sac_lugar_trabajo.estado=1 AND org_departamento.id_departamento=".$id_departamento." ".$where;
        $query=$this->db->query($sentencia);
        /*echo $sentencia;*/
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
                    WHERE (sac_programacion_visita.fecha_visita like '0000-00-00' AND sac_programacion_visita.hora_visita like '00:00:00' AND sac_lugar_trabajo.estado=1 AND sac_programacion_visita.id_empleado=".$id_empleado.")".$where;
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
    
    function buscar_asignacion($id_empleado=0,$id_lugar_trabajo=0)
    {
        $sentencia="SELECT COUNT(*) AS total FROM sac_programacion_visita WHERE id_empleado=".$id_empleado." AND id_lugar_trabajo=".$id_lugar_trabajo." AND estado_programacion=1";
        $query=$this->db->query($sentencia);
        return (array)$query->row();
    }
    
    function eliminar_asignacion($id_empleado,$cad)
    {
        $sentencia="DELETE FROM sac_programacion_visita WHERE id_empleado=".$id_empleado." AND estado_programacion=1 ".$cad;
        $this->db->query($sentencia);
    }
    
    function guardar_asignacion($formuInfo)
    {
        extract($formuInfo);        
        $sentencia="INSERT INTO sac_programacion_visita
                    (id_empleado, id_lugar_trabajo, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_empleado, $id_lugar_trabajo, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
    }
    
    function ver_asignaciones($id_empleado)
    {
        $sentencia="SELECT DISTINCT sac_lugar_trabajo.id_lugar_trabajo AS id, CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre 
                    FROM sac_programacion_visita
                    INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
                    INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
                    WHERE sac_lugar_trabajo.estado=1 AND sac_programacion_visita.estado_programacion=1 AND sac_programacion_visita.id_empleado=".$id_empleado;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function guardar_programacion($formuInfo)
    {
        extract($formuInfo);        
        $sentencia="INSERT INTO sac_programacion_visita
                    (id_empleado, id_lugar_trabajo, fecha_visita, hora_visita, hora_visita_final, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_empleado, $id_lugar_trabajo, '$fecha_visita', '$hora_visita', '$hora_visita_final', '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
    }
    
    function guardar_programacion_nuevo($formuInfo)
    {
        extract($formuInfo);        
        $sentencia="UPDATE sac_programacion_visita SET
                    fecha_visita='$fecha_visita', hora_visita='$hora_visita', hora_visita_final='$hora_visita_final', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
                    WHERE fecha_visita like '0000-00-00' AND hora_visita like '00:00:00' AND id_empleado=".$id_empleado." AND id_lugar_trabajo=".$id_lugar_trabajo;
        $this->db->query($sentencia);
    }
    
    function calendario($id_empleado=0)
    {   
        $sentencia="SELECT
                    CONCAT_WS(' ','N° visitas: ',COUNT(*)) AS titulo,
                    fecha_visita AS fecha
                    FROM sac_programacion_visita
                    WHERE id_empleado='".$id_empleado."' AND fecha_visita>='".date('Y-m-01', strtotime('-6 month'))."'
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
    
    function eliminar_programacion_nuevo($formuInfo)
    {
        extract($formuInfo);
        $sentencia="UPDATE sac_programacion_visita SET
                    fecha_visita='0000-00-00', hora_visita='00:00:00', hora_visita_final='00:00:00', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
                    WHERE id_programacion_visita=".$id_programacion_visita;
        $this->db->query($sentencia);
    }
    
    function actualizar_lugar_trabajo($formuInfo)
    {
        extract($formuInfo);     
        if($necesita_comite=="")
            $necesita_comite="necesita_comite";
        $sentencia="UPDATE sac_lugar_trabajo SET
                    id_institucion=$id_institucion, id_tipo_lugar_trabajo=$id_tipo_lugar_trabajo, nombre_lugar='$nombre_lugar', direccion_lugar='$direccion_lugar', id_municipio=$id_municipio, nombre_contacto='$nombre_contacto', telefono='$telefono', correo='$correo', total_hombres=$total_hombres, total_mujeres=$total_mujeres, necesita_comite=$necesita_comite,fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
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
                    fecha_visita='$fecha_visita', hora_visita='$hora_visita', hora_visita_final='$hora_visita_final', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
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
        /*$sentencia="INSERT INTO sac_promocion 
                    (id_programacion_visita,fecha_promocion,hora_inicio,hora_final,nombre_recibio,observaciones,necesita_comite,fecha_creacion,id_usuario_crea)
                    VALUES 
                    ($id_programacion_visita,'$fecha_promocion','$hora_inicio','$hora_final','$nombre_recibio','$observaciones',$necesita_comite,'$fecha_creacion',$id_usuario_crea)";*/
        $sentencia="INSERT INTO sac_promocion 
                    (id_programacion_visita,fecha_promocion,hora_inicio,hora_final,nombre_recibio,observaciones,fecha_creacion,id_usuario_crea)
                    VALUES 
                    ($id_programacion_visita,'$fecha_promocion','$hora_inicio','$hora_final','$nombre_recibio','$observaciones','$fecha_creacion',$id_usuario_crea)";
        $this->db->query($sentencia);
		return $this->db->insert_id();
    }
    
    function resultados_instituciones($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        /*$sentencia="SELECT
                    sac_promocion.id_promocion,
                    LOWER(CONCAT_WS(', ',sac_lugar_trabajo.direccion_lugar, org_departamento.departamento,org_municipio.municipio)) AS ubicacion,
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
                    WHERE sac_programacion_visita.estado_programacion<=2 AND sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'";*/
        
        /*********************************************************************/
        /**************ESTE ES EL NUEVO QUERY DE LAS PROMOCIONES**************/
        /*********************************************************************/

        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RP.id_departamento=".$id_departamento;
        }
        $sentencia="SELECT 
                    @s:=@s+1 AS numero, 
                    DATE_FORMAT(RP.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
                    DATE_FORMAT(RP.hora_inicio,'%h:%i %p') AS hora_promocion,
                    CONCAT_WS(' - ',RP.nombre_institucion,RP.nombre_lugar) AS nombre_lugar,
                    CONCAT_WS(', ',RP.direccion_lugar, LOWER(RP.municipio),LOWER(RP.departamento)) AS direccion_lugar,
                    RP.nombre_clasificacion,
                    RP.nombre_tipo,
                    RP.nombre_representante,
                    (RP.total_hombres+RP.total_mujeres) AS total_empleados,
                    CASE
                        WHEN RP.sindicato=1 THEN 'Sí' ELSE 'No' 
                    END AS posee_sindicato,
                    RP.nombre_contacto,
                    RP.telefono,
                    RP.correo,
                    RP.observaciones,
                    CASE
                        WHEN RP.necesita_comite=1 THEN 'Sí' ELSE 'No' 
                    END AS necesita_comite
                    FROM sac_resultado_promocion AS RP, (SELECT @s:=0) AS S
                    WHERE RP.id_promocion IS NOT NULL AND RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                    ORDER BY RP.fecha_promocion ASC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        /*$sentencia="SELECT
                    tcm_empleado.seccion,
                    tcm_empleado.id_seccion,
                    tcm_empleado.nombre,
                    (COUNT(sac_programacion_visita.id_programacion_visita)) AS total
                    FROM
                    tcm_empleado
                    LEFT JOIN sac_programacion_visita ON tcm_empleado.id_empleado = sac_programacion_visita.id_empleado
                    LEFT JOIN sac_promocion ON sac_promocion.id_programacion_visita = sac_programacion_visita.id_programacion_visita
                    WHERE (funcional LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL' OR nominal LIKE 'TECNICO EN SEGURIDAD OCUPACIONAL') AND (sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final' OR sac_promocion.fecha_promocion IS NULL)
                    GROUP BY tcm_empleado.id_empleado, tcm_empleado.nombre";*/
        
        /*********************************************************************/
        /**************ESTE ES EL NUEVO QUERY DE LAS PROMOCIONES**************/
        /*********************************************************************/

        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RP.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT
                    @s:=@s+1 AS numero,
                    RP.seccion,
                    RP.nombre_empleado AS nombre,
                    COUNT(RP.id_promocion) AS total
                    FROM sac_resultado_promocion AS RP, (SELECT @s:=0) AS S
                    WHERE RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                    GROUP BY RP.id_empleado
                    ORDER BY numero ASC";
        
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function resultados_sectores($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        /*$sentencia="SELECT
                    sac_clasificacion_institucion.nombre_clasificacion AS nombre,
                    COUNT(*) AS total
                    FROM
                    sac_clasificacion_institucion
                    INNER JOIN sac_institucion ON sac_institucion.id_clasificacion = sac_clasificacion_institucion.id_clasificacion
                    INNER JOIN sac_lugar_trabajo ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
                    INNER JOIN sac_programacion_visita ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
                    INNER JOIN sac_promocion ON sac_promocion.id_programacion_visita = sac_programacion_visita.id_programacion_visita
                    WHERE sac_promocion.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'
                    GROUP BY sac_clasificacion_institucion.nombre_clasificacion";*/
        
        /*********************************************************************/
        /**************ESTE ES EL NUEVO QUERY DE LAS PROMOCIONES**************/
        /*********************************************************************/

        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RP.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT
                    @s:=@s+1 AS numero,
                    RP.nombre_clasificacion AS nombre,
                    COUNT(RP.id_promocion) AS total
                    FROM sac_resultado_promocion AS RP, (SELECT @s:=0) AS S
                    WHERE RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                    GROUP BY RP.id_clasificacion
                    ORDER BY numero ASC";
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
    
    function consultas_promociones_departamentos($id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL)
            $where=" AND org_departamento.id_departamento=".$id_departamento;
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
                    WHERE org_departamento.id_departamento<15 ".$where." AND (fecha_promocion>=CONCAT_WS('-',YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)),MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)),'01') OR id_promocion IS NULL)
                    GROUP BY org_departamento.departamento
                    ORDER BY org_departamento.departamento";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function total_promociones_clasificacion($id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL)
            $where=" WHERE id_departamento=".$id_departamento;
        $sentencia="SELECT 
                    sac_clasificacion_institucion.nombre_clasificacion,
                    COUNT(id_promocion) AS total
                    FROM sac_clasificacion_institucion
                    INNER JOIN sac_resultado_promocion ON sac_clasificacion_institucion.id_clasificacion=sac_resultado_promocion.id_clasificacion
                    ".$where." AND fecha_promocion>=CONCAT_WS('-',YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)),MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)),'01')
                    GROUP BY sac_clasificacion_institucion.nombre_clasificacion
                    ORDER BY COUNT(id_promocion) DESC LIMIT 0,5";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function consultas_promociones_sector($id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL)
            $where=" WHERE id_departamento=".$id_departamento;
        $sentencia="SELECT 
                    sac_sector_institucion.nombre_sector,
                    COUNT(id_promocion) AS total
                    FROM sac_sector_institucion
                    INNER JOIN sac_resultado_promocion ON sac_sector_institucion.id_sector=sac_resultado_promocion.id_sector
                    ".$where." AND fecha_promocion>=CONCAT_WS('-',YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)),MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH)),'01')
                    GROUP BY sac_sector_institucion.nombre_sector
                    ORDER BY sac_sector_institucion.nombre_sector";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function asignaciones_pdf($id_empleado,$fecha_inicial,$fecha_final)
    {
        $sentencia="SELECT 
                    CONCAT_WS(' - ',sac_institucion.nombre_institucion, sac_lugar_trabajo.nombre_lugar) AS nombre,
                    DATE_FORMAT(sac_programacion_visita.fecha_visita, '%d/%m/%Y') AS fecha,
                    DATE_FORMAT(sac_programacion_visita.hora_visita,'%h:%i %p') AS hora,
                    sac_lugar_trabajo.direccion_lugar,
                    LOWER(CONCAT_WS(', ', org_departamento.departamento, org_municipio.municipio)) AS municipio,
                    CASE 
                        WHEN sac_programacion_visita.estado_programacion=1 THEN 'Promoción de ley'
                        WHEN sac_programacion_visita.estado_programacion=2 THEN 'Promoción de ley'
                        WHEN sac_programacion_visita.estado_programacion=3 THEN 'Verificación de cumplimiento'
                        WHEN sac_programacion_visita.estado_programacion=4 THEN 'Verificación de cumplimiento'
                    END AS tipo_programacion,
                    CASE 
                        WHEN sac_programacion_visita.estado_programacion=1 THEN 'Programada'
                        WHEN sac_programacion_visita.estado_programacion=2 THEN 'Realizada'
                        WHEN sac_programacion_visita.estado_programacion=3 THEN 'Programada'
                        WHEN sac_programacion_visita.estado_programacion=4 THEN 'Realizada'
                    END AS estado_programacion
                    FROM sac_programacion_visita
                    INNER JOIN sac_lugar_trabajo ON sac_programacion_visita.id_lugar_trabajo = sac_lugar_trabajo.id_lugar_trabajo
                    INNER JOIN sac_institucion ON sac_lugar_trabajo.id_institucion = sac_institucion.id_institucion
                    INNER JOIN org_municipio ON org_municipio.id_municipio = sac_lugar_trabajo.id_municipio
                    INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais
                    WHERE sac_programacion_visita.id_empleado=".$id_empleado." AND sac_programacion_visita.fecha_visita BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
                    ORDER BY sac_programacion_visita.fecha_visita, sac_programacion_visita.hora_visita
                    ";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function consultas_anios()
    {
        $sentencia="SELECT DISTINCT 
                    Y.id, Y.nombre
                    FROM (
                        SELECT
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS id,
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS nombre
                        FROM sac_resultado_promocion AS R
                        WHERE R.id_promocion IS NOT NULL
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS id,
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS nombre
                        FROM sac_resultado_verificacion AS R
                        WHERE R.id_promocion IS NOT NULL
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_capacitacion,'%Y') AS id,
                        DATE_FORMAT(R.fecha_capacitacion,'%Y') AS nombre
                        FROM sac_resultado_capacitacion AS R
                        WHERE R.id_capacitacion IS NOT NULL
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_conformacion,'%Y') AS id,
                        DATE_FORMAT(R.fecha_conformacion,'%Y') AS nombre
                        FROM sac_resultado_acreditacion AS R
                        WHERE R.fecha_conformacion IS NOT NULL
                    ) AS Y
                    ORDER BY Y.nombre DESC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function consultas_meses($anio)
    {
        $sentencia="SELECT DISTINCT 
                    M.id, M.nombre
                    FROM (
                        SELECT
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS y,
                        DATE_FORMAT(R.fecha_promocion,'%m') AS id,
                        CASE
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '01' THEN 'Enero'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '02' THEN 'Febrero'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '03' THEN 'Marzo'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '04' THEN 'Abril'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '05' THEN 'Mayo'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '06' THEN 'Junio'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '07' THEN 'Julio'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '08' THEN 'Agosto'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '09' THEN 'Septiembre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '10' THEN 'Octubre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '11' THEN 'Noviembre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '12' THEN 'Diciembre'
                        END AS nombre
                        FROM sac_resultado_promocion AS R
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_promocion,'%Y') AS y,
                        DATE_FORMAT(R.fecha_promocion,'%m') AS id,
                        CASE
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '01' THEN 'Enero'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '02' THEN 'Febrero'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '03' THEN 'Marzo'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '04' THEN 'Abril'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '05' THEN 'Mayo'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '06' THEN 'Junio'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '07' THEN 'Julio'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '08' THEN 'Agosto'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '09' THEN 'Septiembre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '10' THEN 'Octubre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '11' THEN 'Noviembre'
                            WHEN DATE_FORMAT(R.fecha_promocion,'%m') LIKE '12' THEN 'Diciembre'
                        END AS nombre
                        FROM sac_resultado_verificacion AS R
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_capacitacion,'%Y') AS y,
                        DATE_FORMAT(R.fecha_capacitacion,'%m') AS id,
                        CASE
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '01' THEN 'Enero'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '02' THEN 'Febrero'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '03' THEN 'Marzo'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '04' THEN 'Abril'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '05' THEN 'Mayo'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '06' THEN 'Junio'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '07' THEN 'Julio'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '08' THEN 'Agosto'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '09' THEN 'Septiembre'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '10' THEN 'Octubre'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '11' THEN 'Noviembre'
                            WHEN DATE_FORMAT(R.fecha_capacitacion,'%m') LIKE '12' THEN 'Diciembre'
                        END AS nombre
                        FROM sac_resultado_capacitacion AS R
                        UNION
                        SELECT 
                        DATE_FORMAT(R.fecha_conformacion,'%Y') AS y,
                        DATE_FORMAT(R.fecha_conformacion,'%m') AS id,
                        CASE
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '01' THEN 'Enero'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '02' THEN 'Febrero'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '03' THEN 'Marzo'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '04' THEN 'Abril'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '05' THEN 'Mayo'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '06' THEN 'Junio'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '07' THEN 'Julio'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '08' THEN 'Agosto'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '09' THEN 'Septiembre'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '10' THEN 'Octubre'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '11' THEN 'Noviembre'
                            WHEN DATE_FORMAT(R.fecha_conformacion,'%m') LIKE '12' THEN 'Diciembre'
                        END AS nombre
                        FROM sac_resultado_acreditacion AS R
                    ) AS M
                    WHERE M.id IS NOT NULL AND M.y LIKE '".$anio."'
                    ORDER BY M.id ASC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function resumen_informe($anio,$mes,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT 1 AS idp, 0 AS idh, 'COMITES DE SEGURIDAD E HIGIENE OCUPACIONAL' AS tipo, NULL AS 'subtotal', NULL AS 'total'
                    UNION
                    SELECT 1 AS idp, 1 AS idh, 'a )  Total  Visitas de Promoción' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RP.id_promocion) AS total FROM sac_resultado_promocion AS RP WHERE DATE_FORMAT(RP.fecha_promocion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RP.fecha_promocion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT 1 AS idp, 2 AS idh, 'b ) Total Capacitaciones Para Formación Comités' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RC.id_lugar_trabajo) AS total FROM sac_resultado_capacitacion AS RC WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."' AND RC.estado_capacitacion=0 ".$where."
                    UNION
                    SELECT 1 AS idp, 3 AS idh, 'c ) Seguimiento a la Gestión de Seguridad y Salud Ocupacional' AS tipo, NULL AS 'subtotal', 0 AS total
                    UNION
                    SELECT 1 AS idp, 4 AS idh, 'd ) Visitas de Verificación Art.  10  - Decreto N°  86' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RV.id_promocion) AS total FROM sac_resultado_verificacion AS RV WHERE DATE_FORMAT(RV.fecha_promocion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RV.fecha_promocion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT 1 AS idp, 5 AS idh, 'e ) Comités Acreditados' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RA.id_lugar_trabajo, RA.fecha_conformacion) AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT 1 AS idp, 6 AS idh, NULL AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT 2 AS idp, 0 AS idh, 'TOTAL TRABAJADORES CAPACITADOS PARA FORMAR COMITES' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS total FROM sac_resultado_capacitacion AS RC WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.asistio_empleado=1
                    UNION
                    SELECT 2 AS idp, 1 AS idh, 'Hombres' AS tipo, COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS 'subtotal', NULL AS total FROM sac_resultado_capacitacion AS RC WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.id_genero=1 AND RC.asistio_empleado=1
                    UNION
                    SELECT 2 AS idp, 2 AS idh, 'Mujeres' AS tipo, COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS 'subtotal', NULL AS total FROM sac_resultado_capacitacion AS RC WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.id_genero=2 AND RC.asistio_empleado=1
                    UNION
                    SELECT 2 AS idp, 3 AS idh, NULL AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT 3 AS idp, 0 AS idh, 'TOTAL TRABAJADORES ACREDITADOS PARA FORMAR COMITES' AS tipo, NULL AS 'subtotal', COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1
                    UNION
                    SELECT 3 AS idp, 1 AS idh, 'Hombres' AS tipo, COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS 'subtotal', NULL AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1 AND RA.id_genero=1
                    UNION
                    SELECT 3 AS idp, 2 AS idh, 'Mujeres' AS tipo, COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS 'subtotal', NULL AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1 AND RA.id_genero=2
                    UNION
                    SELECT 3 AS idp, 3 AS idh, NULL AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT DISTINCT 4 AS idp, 0 AS idh, 'TOTAL TRABAJADORES BENEFICIADOS EN LAS EMPRESAS CON LA FORMACION DE COMITES' AS tipo, NULL AS 'subtotal', IFNULL(SUM(DISTINCT (SELECT IFNULL(SUM(IFNULL(RA.total_hombres,0)+IFNULL(RA.total_mujeres,0)),0) AS t FROM sac_lugar_trabajo AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where.")),0) AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT DISTINCT 4 AS idp, 1 AS idh, 'Hombres' AS tipo, IFNULL(SUM(DISTINCT (SELECT IFNULL(SUM(IFNULL(RA.total_hombres,0)),0) AS t FROM sac_lugar_trabajo AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where.")),0) AS 'subtotal', NULL AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT DISTINCT 4 AS idp, 2 AS idh, 'Mujeres' AS tipo, IFNULL(SUM(DISTINCT (SELECT IFNULL(SUM(IFNULL(RA.total_mujeres,0)),0) AS t FROM sac_lugar_trabajo AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where.")),0) AS 'subtotal', NULL AS total FROM sac_resultado_acreditacion AS RA WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where."
                    UNION
                    SELECT 4 AS idp, 3 AS idh, '' AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT 5 AS idp, 0 AS idh, 'DIVULGACION DE LA LGPRLT Y SUS REGLAMENTOS ' AS tipo, NULL AS 'subtotal', 0 AS total 
                    UNION
                    SELECT 5 AS idp, 1 AS idh, 'Hombres' AS tipo, 0 AS 'subtotal', NULL AS total
                    UNION
                    SELECT 5 AS idp, 2 AS idh, 'Mujeres' AS tipo, 0 AS 'subtotal', NULL AS total
                    UNION
                    SELECT 5 AS idp, 3 AS idh, NULL AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT 6 AS idp, 0 AS idh, 'NOTAS (Detalle Otras Actividades)' AS tipo, NULL AS 'subtotal', NULL AS total
                    UNION
                    SELECT 6 AS idp, 1 AS idh, NULL AS tipo, NULL AS 'subtotal', NULL AS total";
        //echo $sentencia;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function resumen_informe_promocion($anio,$mes,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RP.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT DISTINCT
                    CONCAT(RP.nombre_institucion,' - ',RP.nombre_lugar,' (',RP.direccion_lugar,'. ',LOWER(RP.municipio),LOWER(RP.departamento),')') AS direccion_lugar,
                    RP.ciiu4,
                    SUBSTR(RP.codigo_clasificacion,1,2) AS codigo,
                    COUNT(DISTINCT RP.id_promocion) AS total
                    FROM sac_resultado_promocion AS RP 
                    WHERE DATE_FORMAT(RP.fecha_promocion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RP.fecha_promocion,'%Y') LIKE '".$anio."'".$where."
                    GROUP BY RP.id_lugar_trabajo";
        $query=$this->db->query($sentencia);
        //echo $sentencia;
        return (array)$query->result_array();
    }

    function resumen_informe_verificacion($anio,$mes,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RV.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT DISTINCT
                    CONCAT(RV.nombre_institucion,' - ',RV.nombre_lugar,' (',RV.direccion_lugar, LOWER(RV.municipio),LOWER(RV.departamento),')') AS direccion_lugar,
                    RV.ciiu4,
                    SUBSTR(RV.codigo_clasificacion,1,2) AS codigo,
                    COUNT(DISTINCT RV.id_promocion) AS total_promciones_por_lugar_de_trabajo,
                    COUNT(DISTINCT RV.id_empleado_institucion) AS total_miembros_entrevistados_por_lugar_de_trabajo,
                    MAX(RV.id_estado_verificacion) AS id_estado_verificacion,
                    RV.nombre_estado_verificacion
                    FROM sac_resultado_verificacion AS RV 
                    WHERE DATE_FORMAT(RV.fecha_promocion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RV.fecha_promocion,'%Y') LIKE '".$anio."'".$where."
                    GROUP BY RV.id_lugar_trabajo";
        //echo $sentencia;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function resumen_informe_capacitacion($anio,$mes,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RC.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT 
                    CONCAT(RC.nombre_institucion,' - ',RC.nombre_lugar,' (',RC.direccion_lugar,'. ', LOWER(RC.municipio),', ',LOWER(RC.departamento),')') AS direccion_lugar,
                    RC.ciiu4,
                    SUBSTR(RC.codigo_clasificacion,1,2) AS codigo,
                    IFNULL(RCH.total_hombres_capacitados,0) AS total_hombres_capacitados,
                    IFNULL(RCM.total_mujeres_capacitados,0) AS total_mujeres_capacitados,
                    COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS total_capacitados,
                    RC.total_hombres AS total_hombres_beneficiados,
                    RC.total_mujeres AS total_mujeres_beneficiados,
                    (RC.total_hombres+RC.total_mujeres) AS total_beneficiados
                    FROM sac_resultado_capacitacion AS RC 
                    LEFT JOIN (
                        SELECT 
                        RC.id_lugar_trabajo, 
                        COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS total_hombres_capacitados
                        FROM sac_resultado_capacitacion AS RC 
                        WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.id_genero=1 AND RC.asistio_empleado=1
                        GROUP BY RC.id_lugar_trabajo
                    ) AS RCH ON RCH.id_lugar_trabajo=RC.id_lugar_trabajo
                    LEFT JOIN (
                        SELECT 
                        RC.id_lugar_trabajo, 
                        COUNT(DISTINCT RC.id_empleado_institucion, RC.asistio_empleado) AS total_mujeres_capacitados
                        FROM sac_resultado_capacitacion AS RC 
                        WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.id_genero=2 AND RC.asistio_empleado=1
                        GROUP BY RC.id_lugar_trabajo
                    ) AS RCM ON RCM.id_lugar_trabajo=RC.id_lugar_trabajo
                    WHERE DATE_FORMAT(RC.fecha_capacitacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RC.fecha_capacitacion,'%Y') LIKE '".$anio."'".$where." AND RC.estado_capacitacion=0 AND RC.asistio_empleado=1
                    GROUP BY RC.id_lugar_trabajo";
        //echo $sentencia;
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function resumen_informe_acreditacion($anio,$mes,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND RA.id_departamento=".$id_departamento;
        }       
        $sentencia="SELECT 
                    CONCAT(RA.nombre_institucion,' - ',RA.nombre_lugar,' (',RA.direccion_lugar,'. ', LOWER(RA.municipio),', ',LOWER(RA.departamento),')') AS direccion_lugar,
                    CONCAT(RA.nombre_institucion,' - ',RA.nombre_lugar) AS nombre,
                    RA.direccion_lugar AS direccion, 
                    LOWER(RA.municipio) AS municipio,
                    LOWER(RA.departamento) AS departamento,
                    RA.ciiu4,
                    SUBSTR(RA.codigo_clasificacion,1,2) AS codigo,
                    IFNULL(RAH.total_hombres_capacitados,0) AS total_hombres_capacitados,
                    IFNULL(RAM.total_mujeres_capacitados,0) AS total_mujeres_capacitados,
                    COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS total_capacitados,
                    RA.total_hombres AS total_hombres_beneficiados,
                    RA.total_mujeres AS total_mujeres_beneficiados,
                    (RA.total_hombres+RA.total_mujeres) AS total_beneficiados
                    FROM sac_resultado_acreditacion AS RA 
                    LEFT JOIN (
                        SELECT 
                        RA.id_lugar_trabajo, 
                        COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS total_hombres_capacitados
                        FROM sac_resultado_acreditacion AS RA 
                        WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1 AND RA.id_genero=1
                        GROUP BY RA.id_lugar_trabajo
                    ) AS RAH ON RAH.id_lugar_trabajo=RA.id_lugar_trabajo
                    LEFT JOIN (
                        SELECT 
                        RA.id_lugar_trabajo, 
                        COUNT(DISTINCT RA.id_empleado_institucion, RA.asistio_empleado) AS total_mujeres_capacitados
                        FROM sac_resultado_acreditacion AS RA 
                        WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1 AND RA.id_genero=2
                        GROUP BY RA.id_lugar_trabajo
                    ) AS RAM ON RAM.id_lugar_trabajo=RA.id_lugar_trabajo
                    WHERE DATE_FORMAT(RA.fecha_conformacion,'%m') LIKE '".$mes."' AND DATE_FORMAT(RA.fecha_conformacion,'%Y') LIKE '".$anio."'".$where." AND RA.asistio_empleado=1
                    GROUP BY RA.id_lugar_trabajo";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function nombre_jefe()
    {
        $sentencia="SELECT TRIM(nombre) AS nombre_jefe
                    FROM tcm_empleado
                    WHERE nominal LIKE '%jefe del departamento seguridad e higiene ocupacional%' OR funcional LIKE '%jefe del departamento seguridad e higiene ocupacional%'";
        $query=$this->db->query($sentencia);
        return (array)$query->row();
    }
	
	function ver_incumplimientos()
	{
		$sentencia="SELECT I.id_incumplimiento AS id, I.nombre_incumplimiento AS nombre, I.base_legal_incumplimiento AS base_legal FROM sac_incumplimiento AS I";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
    
    function guardar_ingreso_incumplimiento($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO sac_incumplimiento_promocion 
                    (id_promocion,id_incumplimiento,observacion_adicional)
                    VALUES 
                    ($id_promocion,$id_incumplimiento,'$observacion_adicional')";
        $this->db->query($sentencia);
    }
	
	function resultados_incumplimiento_instituciones($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND id_departamento=".$id_departamento;
        }
		$sentencia="SET SESSION group_concat_max_len = 100000000";
        $query=$this->db->query($sentencia);
        $sentencia="
					SELECT 
					@s:=@s+1 AS numero,
					I.fecha_promocion,
					I.hora_promocion,
					I.nombre_lugar,
					GROUP_CONCAT('***',I.incumplimiento) AS incumplimientos
					FROM (
						SELECT 
						DATE_FORMAT(RP.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
						DATE_FORMAT(RP.hora_inicio,'%h:%i %p') AS hora_promocion,
						RP.id_lugar_trabajo,
						CONCAT_WS(' - ',RP.nombre_institucion,RP.nombre_lugar) AS nombre_lugar,
						IP.id_incumplimiento,
						CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
						FROM sac_resultado_promocion AS RP
						INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RP.id_promocion
						LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
						WHERE RP.id_promocion IS NOT NULL AND RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
						UNION
						SELECT
						DATE_FORMAT(RV.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
						DATE_FORMAT(RV.hora_inicio,'%h:%i %p') AS hora_promocion,
						RV.id_lugar_trabajo,
						CONCAT_WS(' - ',RV.nombre_institucion,RV.nombre_lugar) AS nombre_lugar,
						IP.id_incumplimiento,
						CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
						FROM sac_resultado_verificacion AS RV
						INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RV.id_promocion
						LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
						WHERE RV.id_promocion IS NOT NULL AND RV.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
						GROUP BY RV.id_lugar_trabajo,IP.id_incumplimiento
					) AS I, (SELECT @s:=0) AS S
					GROUP BY I.id_lugar_trabajo
					ORDER BY I.fecha_promocion ASC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function resultados_incumplimiento_tipo($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND id_departamento=".$id_departamento;
        }
        $sentencia="SET SESSION group_concat_max_len = 100000000";
        $query=$this->db->query($sentencia);
        $sentencia="
                    SELECT 
                    @s:=@s+1 AS numero,
                    I.incumplimiento AS nombre,
                    COUNT(*) AS total
                    FROM (
                        SELECT 
                        DATE_FORMAT(RP.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
                        DATE_FORMAT(RP.hora_inicio,'%h:%i %p') AS hora_promocion,
                        RP.id_lugar_trabajo,
                        CONCAT_WS(' - ',RP.nombre_institucion,RP.nombre_lugar) AS nombre_lugar,
                        IP.id_incumplimiento,
                        CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
                        FROM sac_resultado_promocion AS RP
                        INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RP.id_promocion
                        LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
                        WHERE RP.id_promocion IS NOT NULL AND RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                        UNION
                        SELECT
                        DATE_FORMAT(RV.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
                        DATE_FORMAT(RV.hora_inicio,'%h:%i %p') AS hora_promocion,
                        RV.id_lugar_trabajo,
                        CONCAT_WS(' - ',RV.nombre_institucion,RV.nombre_lugar) AS nombre_lugar,
                        IP.id_incumplimiento,
                        CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
                        FROM sac_resultado_verificacion AS RV
                        INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RV.id_promocion
                        LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
                        WHERE RV.id_promocion IS NOT NULL AND RV.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                        GROUP BY RV.id_lugar_trabajo,IP.id_incumplimiento
                    ) AS I, (SELECT @s:=0) AS S
                    GROUP BY I.incumplimiento
                    ORDER BY @s:=@s+1 ASC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function resultados_incumplimiento_tecnicos($fecha_inicial,$fecha_final,$id_departamento=NULL)
    {
        $where="";
        if($id_departamento!=NULL) {
            $where.=" AND id_departamento=".$id_departamento;
        }
        $sentencia="SET SESSION group_concat_max_len = 100000000";
        $query=$this->db->query($sentencia);
        $sentencia="
                    SELECT 
                    @s:=@s+1 AS numero,
                    I.nombre_empleado,
                    I.incumplimiento AS nombre,
                    COUNT(*) AS total
                    FROM (
                        SELECT 
                        RP.nombre_empleado,
                        DATE_FORMAT(RP.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
                        DATE_FORMAT(RP.hora_inicio,'%h:%i %p') AS hora_promocion,
                        RP.id_lugar_trabajo,
                        CONCAT_WS(' - ',RP.nombre_institucion,RP.nombre_lugar) AS nombre_lugar,
                        IP.id_incumplimiento,
                        CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
                        FROM sac_resultado_promocion AS RP
                        INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RP.id_promocion
                        LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
                        WHERE RP.id_promocion IS NOT NULL AND RP.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                        UNION
                        SELECT
                        RV.nombre_empleado,
                        DATE_FORMAT(RV.fecha_promocion, '%d/%m/%Y') AS fecha_promocion,
                        DATE_FORMAT(RV.hora_inicio,'%h:%i %p') AS hora_promocion,
                        RV.id_lugar_trabajo,
                        CONCAT_WS(' - ',RV.nombre_institucion,RV.nombre_lugar) AS nombre_lugar,
                        IP.id_incumplimiento,
                        CASE WHEN IP.id_incumplimiento IS NULL THEN IP.observacion_adicional ELSE I.nombre_incumplimiento END AS incumplimiento
                        FROM sac_resultado_verificacion AS RV
                        INNER JOIN sac_incumplimiento_promocion AS IP ON IP.id_promocion=RV.id_promocion
                        LEFT JOIN sac_incumplimiento AS I ON I.id_incumplimiento=IP.id_incumplimiento
                        WHERE RV.id_promocion IS NOT NULL AND RV.fecha_promocion BETWEEN '$fecha_inicial' AND '$fecha_final'".$where."
                        GROUP BY RV.id_lugar_trabajo,IP.id_incumplimiento
                    ) AS I, (SELECT @s:=0) AS S
                    GROUP BY I.nombre_empleado, I.incumplimiento
                    ORDER BY @s:=@s+1 ASC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
}
?>