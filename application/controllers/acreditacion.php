<?php
class Acreditacion extends CI_Controller
{
    function Acreditacion()
    {
        parent::__construct();
        date_default_timezone_set('America/El_Salvador');
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->model('seguridad_model');
        $this->load->model('promocion_model');
        $this->load->model('acreditacion_model');
        
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }
    
    function index()
    {
        ir_a("index.php/acreditacion/participantes");
    }
    
    /*
    *   Nombre: participantes
    *   Objetivo: Carga la vista del formulario de ingreso de empleados del lugar de trabajo que asistirán a la capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 24/07/2014
    *   Observaciones: Ninguna.
    */
    function participantes($accion_transaccion=NULL, $estado_transaccion=NULL, $idlt=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep);
                    break;
            }
            $data['idlt']=$idlt;
            $data['cargo_comite']=$this->acreditacion_model->cargo_comite();
            $data['tipo_representacion']=$this->acreditacion_model->tipo_representacion();
            $data['tipo_inscripcion']=$this->acreditacion_model->tipo_inscripcion();
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/participantes',$data,Dparticipantes);
        }
        else {
            pantalla_error();
        }
    }

    /*
    *   Nombre: participantes_recargado
    *   Objetivo: Funcion que recarga el formulario para editarlo o limpiarlo 
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 27/07/2014
    *   Observaciones: Ninguna.
    */
    function participantes_recargado($id_empleado_institucion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep);
                    break;
            }
            $data['cargo_comite']=$this->acreditacion_model->cargo_comite();
            $data['tipo_representacion']=$this->acreditacion_model->tipo_representacion();
            $data['tipo_inscripcion']=$this->acreditacion_model->tipo_inscripcion();
            if($id_empleado_institucion!=NULL) {
                $data['empleado_institucion']=$this->acreditacion_model->empleado_institucion($id_empleado_institucion);    
                $data['empleados_lugar_trabajo_sustituyen']=$this->acreditacion_model->empleados_lugar_trabajo($data['empleado_institucion']['id_lugar_trabajo'],"",1,$id_empleado_institucion);    
            }   
            $this->load->view('acreditacion/participantes_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: busqueda_dui_empleados
    *   Objetivo: Busca si un numero de dui ya ha sido registrado
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/11/2014
    *   Observaciones: Ninguna.
    */
    function busqueda_dui_empleados()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();

            $dui_empleado=$this->input->post('dui_empleado');
            $id_empleado_institucion=$this->input->post('id_empleado_institucion');
            
            $r=$this->acreditacion_model->busqueda_dui_empleados($dui_empleado,$id_empleado_institucion);
            
            $this->db->trans_complete();
            $json =array(
                'resultado'=>$r['total']
            );
            echo json_encode($json);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: resumen_empleados_comite
    *   Objetivo: Muestra el resumen de los empleados registrados en un lugar de trabajo
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 03/10/2014
    *   Observaciones: Ninguna.
    */
    function resumen_empleados_comite($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            $data=$this->acreditacion_model->resumen_empleados_comite($id_lugar_trabajo);
            $this->load->view('acreditacion/resumen_empleados_comite',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_participantes
    *   Objetivo: Guarda el formulario de ingreso de empleados de un lugar de trabajo
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 27/07/2014
    *   Observaciones: Ninguna.
    */
    function guardar_participantes()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_empleado_institucion=$this->input->post('id_empleado_institucion');
            $id_lugar_trabajo=$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_ingreso'));
            $fecha_ingreso=date("Y-m-d", strtotime($fec));
            $id_tipo_representacion=$this->input->post('id_tipo_representacion');
            $nombre_empleado=$this->input->post('nombre_empleado');
            $id_genero=$this->input->post('id_genero');
            $dui_empleado=$this->input->post('dui_empleado');
            $cargo_empleado=$this->input->post('cargo_empleado');
            $id_cargo_comite=($this->input->post('id_cargo_comite')!="")?$this->input->post('id_cargo_comite'):'NULL';
            $id_tipo_inscripcion=$this->input->post('id_tipo_inscripcion');
            $delegado=($this->input->post('delegado')!="")?$this->input->post('delegado'):'NULL';
            
            if($id_tipo_representacion==3)
                $sindicato='1';
            else
                $sindicato='NULL';
            
            if($id_empleado_institucion=="") {
                $fecha_creacion=date('Y-m-d H:i:s');
                $id_usuario_crea=$this->session->userdata('id_usuario');
                $id_empleado_institucion_sustituye=($this->input->post('id_empleado_institucion_sustituye')!="")?$this->input->post('id_empleado_institucion_sustituye'):'NULL';
                
                $formuInfo = array(
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'id_tipo_representacion'=>$id_tipo_representacion,
                    'nombre_empleado'=>$nombre_empleado,
                    'id_genero'=>$id_genero,
                    'dui_empleado'=>$dui_empleado,
                    'cargo_empleado'=>$cargo_empleado,
                    'id_cargo_comite'=>$id_cargo_comite,
                    'id_tipo_inscripcion'=>$id_tipo_inscripcion,
                    'delegado'=>$delegado,
                    'sindicato'=>$sindicato,
                    'fecha_ingreso'=>$fecha_ingreso,
                    'id_empleado_institucion_sustituye'=>$id_empleado_institucion_sustituye,
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea
                );
                $this->acreditacion_model->guardar_participante($formuInfo);
                $tipo=1;
            }
            else {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                $id_empleado_institucion_sustituye=($this->input->post('id_empleado_institucion_sustituye')!="")?$this->input->post('id_empleado_institucion_sustituye'):'id_empleado_institucion_sustituye';
                
                $formuInfo = array(
                    'id_empleado_institucion'=>$id_empleado_institucion,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'id_tipo_representacion'=>$id_tipo_representacion,
                    'nombre_empleado'=>$nombre_empleado,
                    'id_genero'=>$id_genero,
                    'dui_empleado'=>$dui_empleado,
                    'cargo_empleado'=>$cargo_empleado,
                    'id_cargo_comite'=>$id_cargo_comite,
                    'id_tipo_inscripcion'=>$id_tipo_inscripcion,
                    'delegado'=>$delegado,
                    'sindicato'=>$sindicato,
                    'fecha_ingreso'=>$fecha_ingreso,
                    'id_empleado_institucion_sustituye'=>$id_empleado_institucion_sustituye,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                $this->acreditacion_model->actualizar_participante($formuInfo);
                $tipo=2;
            }

            if ($id_empleado_institucion_sustituye!='NULL' && $id_empleado_institucion_sustituye!='id_empleado_institucion_sustituye') {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');

                $formuInfo = array(
                    'id_empleado_institucion'=>$id_empleado_institucion_sustituye,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica,
                );
                $this->acreditacion_model->eliminar_participante($formuInfo);
            }
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/participantes/".$tipo."/".$tr."/".$id_lugar_trabajo);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: empleados_lugar_trabajo
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function empleados_lugar_trabajo($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $data['empleados_lugar_trabajo']=$this->acreditacion_model->empleados_lugar_trabajo($id_lugar_trabajo);
            $this->load->view('acreditacion/participantes_lugar_trabajo',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: empleados_lugar_trabajo_sustituyen
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion para sustitución
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 27/11/2014
    *   Observaciones: Ninguna.
    */
    function empleados_lugar_trabajo_sustituyen($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $data['empleados_lugar_trabajo_sustituyen']=$this->acreditacion_model->empleados_lugar_trabajo($id_lugar_trabajo,"",1);
            $this->load->view('acreditacion/empleados_lugar_trabajo_sustituyen',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: eliminar_participante
    *   Objetivo: Desactiva a un empleado que se había ingresado para que participara en una capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_participante($id_empleado_institucion)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_empleado_institucion'=>$id_empleado_institucion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->acreditacion_model->eliminar_participante($formuInfo);
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/participantes/3/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: capacitacion
    *   Objetivo: Formulario de ingreso de una capacitacion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function capacitacion($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {    
            switch($data['id_permiso']) {
                case 1:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep,1,3);
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia(NULL,NULL,date('Y-m-d'),NULL,$id_seccion['id_empleado']);
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones($dep,1);
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia();
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones(NULL,1);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo(NULL,1,3);
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep,1,3);
                    
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) {
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],2,date('Y-m-d'));
                    }
                    else {
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],1,date('Y-m-d'));
                    }
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones($dep,1);
                    break;
            }   
            
            
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/capacitacion',$data,Dprogramar_capacitacion);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: capacitacion_recargado
    *   Objetivo: Formulario de edidición de una capacitación 
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function capacitacion_recargado($id_capacitacion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {    
            if($id_capacitacion!=NULL) {
                $data['capacitacion']=$this->acreditacion_model->ver_capacitacion($id_capacitacion);
                $data['id_capacitacion']=$id_capacitacion;
            }
            //echo $data['capacitacion'][0]['fecha_capacitacion2'];
            switch($data['id_permiso']) {
                case 1:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep,1,3);
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia(NULL,NULL,date('Y-m-d'),NULL,$id_seccion['id_empleado']);
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia(NULL,NULL,$data['capacitacion'][0]['fecha_capacitacion2'],$id_capacitacion);  
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],2,$data['capacitacion'][0]['fecha_capacitacion2'],$id_capacitacion);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],1,$data['capacitacion'][0]['fecha_capacitacion2'],$id_capacitacion);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo($dep);
                    break;
            }   
            $this->load->view('acreditacion/capacitacion_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: mostrar_lugares_trabajo
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function mostrar_lugares_trabajo()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {    
            switch($data['id_permiso']) {
                case 1:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo_sin_capacitarse($dep);
                    break;
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo_sin_capacitarse();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->insticion_lugar_trabajo_sin_capacitarse($dep);
                    break;
            }
            $this->load->view('acreditacion/mostrar_lugares_trabajo',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: empleados_lugar_trabajo_capacitacion
    *   Objetivo: Muestra todos los empleados de un lugar de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function empleados_lugar_trabajo_capacitacion($id_lugar_trabajo=NULL,$empleados="")
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $data['empleados_lugar_trabajo']=$this->acreditacion_model->empleados_lugar_trabajo_sin_capacitarse($id_lugar_trabajo,$empleados);
            $this->load->view('acreditacion/participantes_lugar_trabajo_capacitacion',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: participantes_recargado_capacitacion
    *   Objetivo: Muestra los datos de un empleado para poder editarlos desde la pantalla de capacitaciones
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function participantes_recargado_capacitacion($id_empleado_institucion=NULL) 
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $data['empleado_institucion']=$this->acreditacion_model->empleado_institucion($id_empleado_institucion);            
            $this->load->view('acreditacion/participantes_recargado_capacitacion',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: actualizar_empleado_capacitacion
    *   Objetivo: Actualiza por medio de ajax el dui y cargo de un empleado desde la pantalla de capacitaciones
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function actualizar_empleado_capacitacion($id_empleado_institucion=NULL) 
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();

            $dui_empleado=$this->input->post('dui_empleado');
            $cargo_empleado=$this->input->post('cargo_empleado');
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_empleado_institucion'=>$id_empleado_institucion,
                'dui_empleado'=>$dui_empleado,
                'cargo_empleado'=>$cargo_empleado,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->acreditacion_model->actualizar_participante_capacitacion($formuInfo);
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_capacitacion
    *   Objetivo: Guarda el formulario de capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 12/08/2014
    *   Observaciones: Ninguna.
    */
    function guardar_capacitacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion);
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_capacitacion=$this->input->post('id_capacitacion');
            
            $id_lugar_trabajo=($this->input->post('id_lugar_trabajo')=='')?'NULL':$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_capacitacion'));
            $fecha_capacitacion=date("Y-m-d", strtotime($fec));
            $hora_capacitacion=$this->input->post('hora_capacitacion');
            $hora_capacitacion=date("H:i:s", strtotime($hora_capacitacion));
            
            $id_empleado_institucion=$this->input->post('id_empleado_institucion');
            $id_empleado=$this->input->post('id_empleado');
            
            if($id_capacitacion=="") {
                $fecha_creacion=date('Y-m-d H:i:s');
                $id_usuario_crea=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_capacitacion'=>$fecha_capacitacion,
                    'hora_capacitacion'=>$hora_capacitacion,
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea,
                );
                $id_capacitacion=$this->acreditacion_model->guardar_capacitacion($formuInfo);
                $tipo=1;
            }
            else {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_capacitacion'=>$id_capacitacion,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_capacitacion'=>$fecha_capacitacion,
                    'hora_capacitacion'=>$hora_capacitacion,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica,
                );
                $this->acreditacion_model->actualizar_capacitacion($formuInfo);
                $tipo=2;
            }
            
            $this->acreditacion_model->eliminar_empleados_capacitacion($id_capacitacion);
            $this->acreditacion_model->eliminar_tecnicos_capacitacion($id_capacitacion);
            
            for($i=0;$i<count($id_empleado_institucion);$i++) {
                $formuInfo = array(
                    'id_capacitacion'=>$id_capacitacion,
                    'id_empleado_institucion'=>$id_empleado_institucion[$i]
                );
                if($id_empleado_institucion[$i]!="")
                    $this->acreditacion_model->agregar_empleados_capacitacion($formuInfo);
            }
            
            for($i=0;$i<count($id_empleado);$i++) {
                $formuInfo = array(
                    'id_capacitacion'=>$id_capacitacion,
                    'id_empleado'=>$id_empleado[$i]
                );
                $this->acreditacion_model->agregar_tecnicos_capacitacion($formuInfo);
            }
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/capacitacion/".$tipo."/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: eliminar_capacitacion
    *   Objetivo: elimina una capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 13/08/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_capacitacion($id_capacitacion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_capacitacion'=>$id_capacitacion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->acreditacion_model->eliminar_capacitacion($formuInfo);
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/capacitacion/3/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: asistencia
    *   Objetivo: registrar la asistencia a una capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 28/08/2014
    *   Observaciones: Ninguna.
    */
    function asistencia($accion_transaccion=NULL, $estado_transaccion=NULL) 
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_asistencia); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {    
            switch($data['id_permiso']) {
                case 1:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones($dep,1,$id_seccion['id_empleado']);
                    break;
                case 3:
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones(NULL,1);
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['capacitaciones']=$this->acreditacion_model->mostrar_capacitaciones($dep,1);
                    break;
            }   
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/asistencia',$data,Dcontrol_asistencia);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: asistencia_recargado
    *   Objetivo: registrar la asistencia a una capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 28/08/2014
    *   Observaciones: Ninguna.
    */
    function asistencia_recargado($id_capacitacion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_asistencia); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {    
            if($id_capacitacion!=NULL) {
                $data['capacitacion']=$this->acreditacion_model->ver_capacitacion($id_capacitacion);
                $data['id_capacitacion']=$id_capacitacion;
            }
            $this->load->view('acreditacion/asistencia_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_asistencia
    *   Objetivo: Guarda el formulario de asistencia a una capacitación
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 29/08/2014
    *   Observaciones: Ninguna.
    */
    function guardar_asistencia()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_asistencia);
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_capacitacion=$this->input->post('id_capacitacion');
            $id_empleado_ck=$this->input->post('id_empleado_ck');
            
            for($i=0;$i<count($id_empleado_ck);$i++) {
                $id_emp_ck=explode("***",$id_empleado_ck[$i]);
                $formuInfo = array(
                    'id_capacitacion'=>$id_capacitacion,
                    'id_empleado_institucion'=>$id_emp_ck[0],
                    'asistio'=>1
                );
                if($id_emp_ck[0]!="")
                    $this->acreditacion_model->guardar_asistencia_capacitacion($formuInfo);
            }
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/asistencia/1/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    function imprimir_asistencia($id_capacitacion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_asistencia);
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['id_seccion']=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
            $capacitacion=$this->acreditacion_model->ver_capacitacion($id_capacitacion);
            /*$this->load->view('transporte/acreditacion_pdf.php',$data);*/
            
            $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
            $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
            $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
            //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true));
            $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
            foreach($capacitacion as $val) {
                $id=$val['id'];
                $idc[$id]=1;
            }
            for($i=0;$i<count($capacitacion);$i++) { 
                $id=$capacitacion[$i]['id'];
                if($idc[$id]==1) {
                    $idc[$id]=0;
                    if($i>0)
                        $this->mpdf->AddPage();
                    $data['capacitacion']=$this->acreditacion_model->ver_capacitacion($id_capacitacion, $capacitacion[$i]['id']);
                    $html = $this->load->view('acreditacion/asistencia_pdf.php', $data, true);
                    $this->mpdf->WriteHTML($html,2);
                }
            }
            
            $this->mpdf->Output(); /*Salida del pdf*/
        }
        else {
            pantalla_error();
        }
    }       
    
    /*
    *   Nombre: registrar_comite
    *   Objetivo: Guarda el formulario de registro de un comite
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 29/08/2014
    *   Observaciones: Ninguna.
    */
    function registrar_comite($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dregistrar_comite); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            switch($data['id_permiso']) {
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite($dep);
                    break;
            }
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/registrar_comite',$data,Dregistrar_comite);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: registrar_comite_recargado
    *   Objetivo: Guarda el formulario de registro de un comite
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 29/08/2014
    *   Observaciones: Ninguna.
    */
    function registrar_comite_recargado($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dregistrar_comite); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            if($id_lugar_trabajo!=NULL) {
                $data['empleado_lugar_trabajo']=$this->acreditacion_model->empleados_lugar_trabajo($id_lugar_trabajo,"");
                $data['ins']=$this->promocion_model->lugares_trabajo_empresa(NULL,$id_lugar_trabajo);
                $data['id_lugar_trabajo']=$id_lugar_trabajo;
                $data['ilt']=$id_lugar_trabajo;
            }
            $this->load->view('acreditacion/registrar_comite_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function guardar_comite()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dregistrar_comite);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
                        
            $id_lugar_trabajo=($this->input->post('id_lugar_trabajo')=='')?'NULL':$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_conformacion'));
            $fecha_conformacion=date("Y-m-d", strtotime($fec));
            
            $id_empleado_ck_del=$this->input->post('id_empleado_ck_del');
            $id_empleado_ck_sin=$this->input->post('id_empleado_ck_sin');
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_lugar_trabajo'=>$id_lugar_trabajo,
                'fecha_conformacion'=>$fecha_conformacion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica
            );
            $this->acreditacion_model->actualizar_comite($formuInfo);

            $this->acreditacion_model->quitar_empleados_delegados_sindicato($id_lugar_trabajo);
            
            for($i=0;$i<count($id_empleado_ck_del);$i++) {
                $formuInfo = array(
                    'delegado'=>1,
                    'id_empleado_institucion'=>$id_empleado_ck_del[$i],
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                if($id_empleado_ck_del[$i]!="")
                    $this->acreditacion_model->agregar_empleados_delegados($formuInfo);
            }
            
            for($i=0;$i<count($id_empleado_ck_sin);$i++) {
                $formuInfo = array(
                    'sindicato'=>1,
                    'id_empleado_institucion'=>$id_empleado_ck_sin[$i],
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                if($id_empleado_ck_sin[$i]!="")
                    $this->acreditacion_model->agregar_empleados_sindicato($formuInfo);
            }
            
            $tipo=2;
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/registrar_comite/".$tipo."/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: aprobar_comite
    *   Objetivo: Guarda el formulario de aprobación de un comite
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 31/08/2014
    *   Observaciones: Ninguna.
    */
    function aprobar_comite($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Daprobar_comite); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            switch($data['id_permiso']) {
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite(NULL,1);
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite($dep,1);
                    break;
            }
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/aprobar_comite',$data,Daprobar_comite);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: aprobar_comite_recargado
    *   Objetivo: Guarda el formulario de aprobación de un comite
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 31/08/2014
    *   Observaciones: Ninguna.
    */
    function aprobar_comite_recargado($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Daprobar_comite); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            if($id_lugar_trabajo!=NULL) {
                $data['empleado_lugar_trabajo']=$this->acreditacion_model->empleados_lugar_trabajo($id_lugar_trabajo,"");
                $data['ins']=$this->promocion_model->lugares_trabajo_empresa(NULL,$id_lugar_trabajo);
                $data['id_lugar_trabajo']=$id_lugar_trabajo;
                $data['ilt']=$id_lugar_trabajo;
                $data['lugar_trabajo']=$this->acreditacion_model->resumen_empleados_comite($id_lugar_trabajo);
            }
            $data['cargo_comite']=$this->acreditacion_model->cargo_comite();
            $this->load->view('acreditacion/aprobar_comite_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function guardar_aprobacion_comite()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Daprobar_comite);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
                        
            $id_lugar_trabajo=($this->input->post('id_lugar_trabajo')=='')?'NULL':$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_conformacion'));
            $fecha_conformacion=date("Y-m-d", strtotime($fec));
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_lugar_trabajo'=>$id_lugar_trabajo,
                'estado'=>2,
                'fecha_conformacion'=>$fecha_conformacion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica
            );
            $this->acreditacion_model->guardar_aprobacion_comite($formuInfo);

            $id_cargo_comite=$this->input->post('id_cargo_comite');

            for ($i=0;$i<count($id_cargo_comite);$i++) { 
                $cargo_comite=explode("***", $id_cargo_comite[$i]);
                $formuInfo = array(
                    'id_empleado_institucion'=>$cargo_comite[0],
                    'id_cargo_comite'=>$cargo_comite[1],
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                $this->acreditacion_model->actualizar_cargo_comite($formuInfo);
            }
            
            $tipo=2;
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/acreditacion/aprobar_comite/".$tipo."/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    function imprimir_acreditacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dimprimir_acreditacion); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            switch($data['id_permiso']) {
                case 3:
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite(NULL,2);
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $dep=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
                    $data['insticion_lugar_trabajo']=$this->acreditacion_model->lugares_trabajo_comite($dep,2);
                    break;
            }
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('acreditacion/imprimir_acreditacion',$data,Dimprimir_acreditacion);
        }
        else {
            pantalla_error();
        }
    }
    
    function imprimir_pdf()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dimprimir_acreditacion);
        if($data['id_permiso']!=NULL) {
            $data['id_seccion']=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));

            $id_lugar_trabajo=$this->input->post("id_lugar_trabajo");

            if($this->input->post('tabla')!="")
                $lt= "&".$this->input->post('tabla');
            $empelados=explode("&id_empleado_institucion%5B%5D=",$lt);

            //$empelados=$this->acreditacion_model->consultar_lugar_trabajo_empleados($id_lugar_trabajo);
            /*$this->load->view('transporte/acreditacion_pdf.php',$data);*/
            
            $this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
            $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
            $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
            //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true));
            $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
            
            $data['memo']=$this->acreditacion_model->memo_acreditacion_pdf($empelados[1]);
            $data['empleados']=$this->acreditacion_model->memo_acreditacion_lista_empleados_pdf('0'.str_replace("&id_empleado_institucion%5B%5D=",",",$lt));
            $html = $this->load->view('acreditacion/memo_acreditacion_pdf.php', $data, true);
            $this->mpdf->WriteHTML($html,2);
            $this->mpdf->AddPage();
            $html = $this->load->view('acreditacion/memo_acreditacion_pdf.php', $data, true);
            $this->mpdf->WriteHTML($html,2);
            $this->mpdf->AddPage();

            $data['carta']=$this->acreditacion_model->memo_acreditacion_pdf($empelados[1]);
            $html = $this->load->view('acreditacion/carta_acreditacion_pdf.php', $data, true);
            $this->mpdf->WriteHTML($html,2);
            $this->mpdf->AddPage();
            $html = $this->load->view('acreditacion/carta_acreditacion_pdf.php', $data, true);
            $this->mpdf->WriteHTML($html,2);
            
            $fec=str_replace("/","-",$this->input->post('fecha_entrega'));
            $fecha_entrega=date("Y-m-d", strtotime($fec));
            
            for($i=1;$i<count($empelados);$i++) { 
                $this->mpdf->AddPage();
                $formuInfo = array(
                    'id_empleado_institucion'=>$empelados[$i],
                    'nombre_entrega'=>$this->input->post('nombre_entrega'),
                    'dui_entrega'=>$this->input->post('dui_entrega'),
                    'fecha_entrega'=>$fecha_entrega,
                    'fecha_creacion'=>date('Y-m-d H:i:s'),
                    'id_usuario_crea'=>$this->session->userdata('id_usuario')
                );
                $this->acreditacion_model->entrega_acreditacion($formuInfo);
                $data['lugar_trabajo']=$this->acreditacion_model->consultar_lugar_trabajo($empelados[$i]);
                if($data['lugar_trabajo']['tiempo_activo']>=2 || $data['lugar_trabajo']['tiempo_activo']<0) {
                    $this->acreditacion_model->actulizar_acreditacion($empelados[$i]);
                    $data['lugar_trabajo']=$this->acreditacion_model->consultar_lugar_trabajo($empelados[$i]);
                }
                $html = $this->load->view('acreditacion/acreditacion_pdf.php', $data, true);
                $this->mpdf->WriteHTML($html,2);
            }
            $this->mpdf->Output(); /*Salida del pdf*/
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: comprobar_capacitacion
    *   Objetivo: Verifica que se haya inscrito al menos un empleado a una capacitacion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 08/09/2014
    *   Observaciones: Ninguna.
    */
    function comprobar_capacitacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $id_empleado_institucion=$this->input->post('id_empleado_institucion');
            $c=false;
            for($i=0;$i<count($id_empleado_institucion);$i++) {
                if($id_empleado_institucion[$i]!="")
                    $c=true;
            }
            if($c) {        
                $json =array(
                    'resultado'=>1
                );
            }
            else {
                $json =array(
                    'resultado'=>0
                );
            }
        }
        else {
            $json =array(
                'resultado'=>0
            );
        }
        echo json_encode($json);
    }
    
    function lista_tecnicos_disponibles($fecha=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_capacitacion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            if($fecha!=NULL)
                $fecha=date("Y-m-d", strtotime($fecha));
            switch($data['id_permiso']) {
                case 1:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia(NULL,NULL,$fecha,NULL,$id_seccion['id_empleado']);
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia(NULL,1,$fecha);
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) {
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],2,$fecha);
                    }
                    else {
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos_disponibles_por_dia($id_seccion['id_seccion'],1,$fecha);
                    }
                    break;
            }
            $this->load->view('acreditacion/lista_tecnicos_disponibles',$data);
        }
    }
    
    function capacitaciones()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_capacitaciones); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            pantalla('acreditacion/capacitaciones',$data,Dreportes_capacitaciones);
        }
        else {
            pantalla_error();
        }
    }
    
    function acreditaciones()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_acreditaciones); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            pantalla('acreditacion/acreditaciones',$data,Dreportes_acreditaciones);
        }
        else {
            pantalla_error();
        }
    }

    function ver_empleados_capacitados($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dimprimir_acreditacion); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {  
            $data['id_lugar_trabajo']=$id_lugar_trabajo;
            if ($id_lugar_trabajo!=NULL) {
                $data['empleado_lugar_trabajo']=$this->acreditacion_model->consultar_lugar_trabajo_empleados($id_lugar_trabajo);
            }
            $this->load->view('acreditacion/ver_empleados_capacitados',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function resultados($fecha_iniciale=NULL,$fecha_finale=NULL,$reportee=NULL,$exportacione=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_capacitaciones); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            if($fecha_iniciale==NULL) {
                $fec=str_replace("/","-",$this->input->post('fecha_inicial'));
                $fecha_inicial=date("Y-m-d", strtotime($fec));
            }
            else {
                $fecha_inicial=date("Y-m-d", strtotime($fecha_iniciale));
            }
            if($fecha_finale==NULL) {
                $fec=str_replace("/","-",$this->input->post('fecha_final'));
                $fecha_final=date("Y-m-d", strtotime($fec));
            }
            else {
                $fecha_final=date("Y-m-d", strtotime($fecha_finale));
            }
            if($reportee==NULL)
                $reporte=$this->input->post('radio');
            else
                $reporte=$reportee;
            if($exportacione==NULL)
                $data['exportacion']=$this->input->post('radio2');
            else
                $data['exportacion']=$exportacione;
            $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
            if($data['id_permiso']==4)
                $id_departamento=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
            else
                $id_departamento=NULL;
            switch($reporte) {
                case 1:
                    $data['info']=$this->acreditacion_model->resultados_comites($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Comites ".date('d-m-Y hisa');
                    if($data['exportacion']!=2) {
                        $this->load->view('acreditacion/resultados_comites',$data);
                    }
                    else {                      
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_comites.php', $data, true);
                        $data_cab['titulo']="CAPACITACIONES REALIZADAS POR LUGAR DE TRABAJO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 2:
                    $data['info']=$this->acreditacion_model->resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Técnicos ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('acreditacion/resultados_tecnicos',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_tecnicos.php', $data, true);
                        $data_cab['titulo']="CAPACITACIONES REALIZADAS POR TÉCNICO EDUCADOR";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 3:
                    $data['info']=$this->acreditacion_model->resultados_trabajadores_capacitados($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Trabajadores Capacitados ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('acreditacion/resultados_trabajadores_capacitados',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_trabajadores_capacitados.php', $data, true);
                        $data_cab['titulo']="CAPACITACIONES POR EMPLEADO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
            }
        }
        else {
            pantalla_error();
        }
    }
    
    function resultados_acreditaciones($fecha_iniciale=NULL,$fecha_finale=NULL,$reportee=NULL,$exportacione=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_acreditaciones); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            if($fecha_iniciale==NULL) {
                $fec=str_replace("/","-",$this->input->post('fecha_inicial'));
                $fecha_inicial=date("Y-m-d", strtotime($fec));
            }
            else {
                $fecha_inicial=date("Y-m-d", strtotime($fecha_iniciale));
            }
            if($fecha_finale==NULL) {
                $fec=str_replace("/","-",$this->input->post('fecha_final'));
                $fecha_final=date("Y-m-d", strtotime($fec));
            }
            else {
                $fecha_final=date("Y-m-d", strtotime($fecha_finale));
            }
            if($reportee==NULL)
                $reporte=$this->input->post('radio');
            else
                $reporte=$reportee;
            if($exportacione==NULL)
                $data['exportacion']=$this->input->post('radio2');
            else
                $data['exportacion']=$exportacione;
            $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
            if($data['id_permiso']==4)
                $id_departamento=$this->promocion_model->ubicacion_departamento($id_seccion['id_seccion']);
            else
                $id_departamento=NULL;
            switch($reporte) {
                case 1:
                    $data['info']=$this->acreditacion_model->resultados_acreditaciones($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Comites ".date('d-m-Y hisa');
                    if($data['exportacion']!=2) {
                        $this->load->view('acreditacion/resultados_acreditaciones',$data);
                    }
                    else {                      
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_acreditaciones.php', $data, true);
                        $data_cab['titulo']="ACREDITACIONES REALIZADAS POR LUGAR DE TRABAJO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 2:
                    $data['info']=$this->acreditacion_model->resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Técnicos ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('acreditacion/resultados_tecnicos',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_tecnicos.php', $data, true);
                        $data_cab['titulo']="CAPACITACIONES REALIZADAS POR TÉCNICO EDUCADOR";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 3:
                    $data['info']=$this->acreditacion_model->resultados_trabajadores_capacitados($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Trabajadores Capacitados ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('acreditacion/resultados_trabajadores_capacitados',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('acreditacion/resultados_trabajadores_capacitados.php', $data, true);
                        $data_cab['titulo']="CAPACITACIONES POR EMPLEADO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
            }
        }
        else {
            pantalla_error();
        }
    }
}
?>