<?php
class Promocion extends CI_Controller
{
    /* Incluir(TRUE)/No incluir(FALSE) los lugares de trabajo que ya tienen una visita programada en la lista de lugares de trabajo que se pueden asignar*/
    public $mostrar_todos="FALSE"; 
    
    function Promocion()
    {
        parent::__construct();
        date_default_timezone_set('America/El_Salvador');
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->model('seguridad_model');
        $this->load->model('promocion_model');
        
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }
    
    function index()
    {
        ir_a("index.php/promocion/general");
    }
    
    /*
    *   Nombre: general
    *   Objetivo: Carga la vista del formulario de ingreso de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function general($accion_transaccion=NULL, $estado_transaccion=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddatos_generales); 
        if($data['id_permiso']==3) {
            $data['clasificacion']=$this->promocion_model->mostrar_clasificacion();
            $data['sector']=$this->promocion_model->mostrar_sector();
            $data['institucion']=$this->promocion_model->mostrar_institucion(1);
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('promocion/ingreso_institucion',$data,Ddatos_generales);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: general_recargado
    *   Objetivo: Funcion que recarga el formulario para editarlo o limpiarlo 
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 19/07/2014
    *   Observaciones: Ninguna.
    */
    function general_recargado($id_institucion=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddatos_generales); 
        if($data['id_permiso']==3) {
            $data['clasificacion']=$this->promocion_model->mostrar_clasificacion();
            $data['sector']=$this->promocion_model->mostrar_sector();
            if($id_institucion!=NULL)
                $data['institucion']=$this->promocion_model->mostrar_institucion(1,$id_institucion);
            $this->load->view('promocion/ingreso_institucion_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_promocion
    *   Objetivo: Guarda el formulario de ingreso de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function guardar_promocion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddatos_generales);
        if($data['id_permiso']==3){
            $this->db->trans_start();
            
            $id_institucion=$this->input->post('id_institucion');
            $nombre_institucion=$this->input->post('nombre_institucion');
            $nit_empleador=$this->input->post('nit_empleador');
            
            $nombre_representante=$this->input->post('nombre_representante');
            $id_clasificacion=($this->input->post('id_clasificacion')=='')?'NULL':$this->input->post('id_clasificacion');
            $id_sector=($this->input->post('id_sector')=='')?'NULL':$this->input->post('id_sector');
            $sindicato=$this->input->post('sindicato');
            
            if($id_institucion=="") {
                $fecha_creacion=date('Y-m-d H:i:s');
                $id_usuario_crea=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'nombre_institucion'=>$nombre_institucion,
                    'nit_empleador'=>$nit_empleador,
                    'nombre_representante'=>$nombre_representante,
                    'id_clasificacion'=>$id_clasificacion,
                    'id_sector'=>$id_sector,
                    'sindicato'=>$sindicato,
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea,
                );
                $this->promocion_model->guardar_promocion($formuInfo);
                $tipo=1;
            }
            else {
                $sindicato=($this->input->post('sindicato')=='')?'0':$this->input->post('sindicato');
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_institucion'=>$id_institucion,
                    'nombre_institucion'=>$nombre_institucion,
                    'nit_empleador'=>$nit_empleador,
                    'nombre_representante'=>$nombre_representante,
                    'id_clasificacion'=>$id_clasificacion,
                    'id_sector'=>$id_sector,
                    'sindicato'=>$sindicato,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica,
                );
                $this->promocion_model->actualizar_promocion($formuInfo);
                $tipo=2;
            }
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/general/".$tipo."/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: eliminar_institucion
    *   Objetivo: desactiva una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_institucion($id_institucion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddatos_generales);
        if($data['id_permiso']==3){
            $this->db->trans_start();
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_institucion'=>$id_institucion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->promocion_model->eliminar_institucion($formuInfo);
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/general/3/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo
    *   Objetivo: Carga la vista del formulario de ingreso de un lugar de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function lugares_trabajo($accion_transaccion=NULL, $estado_transaccion=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dlugares_trabajo); 
        if($data['id_permiso']==3) {
            $data['institucion']=$this->promocion_model->mostrar_institucion(1);
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('promocion/ingreso_lugar_trabajo',$data,Dlugares_trabajo);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo_recargado
    *   Objetivo: Funcion que recarga el formulario para editarlo o limpiarlo 
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 19/07/2014
    *   Observaciones: Ninguna.
    */
    function lugares_trabajo_recargado($id_lugar_trabajo=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dlugares_trabajo); 
        if($data['id_permiso']==3) {
            $data['institucion']=$this->promocion_model->mostrar_institucion(1);
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            if($id_lugar_trabajo!=NULL)
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_empresa(NULL,$id_lugar_trabajo);
            $this->load->view('promocion/ingreso_lugar_trabajo_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_lugar_trabajo
    *   Objetivo: Guarda el formulario de ingreso de un lugar de trabajo
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function guardar_lugar_trabajo()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dlugares_trabajo);
        if($data['id_permiso']==3){
            $this->db->trans_start();
            
            unset($_post);
            $id_lugar_trabajo=$this->input->post('id_lugar_trabajo');
            $id_institucion=$this->input->post('id_institucion');
            $id_tipo_lugar_trabajo=$this->input->post('id_tipo_lugar_trabajo');
            $nombre_lugar=$this->input->post('nombre_lugar');
            $direccion_lugar=$this->input->post('direccion_lugar');
            $id_municipio=$this->input->post('id_municipio');
            
            $nombre_contacto=$this->input->post('nombre_contacto');
            $telefono=$this->input->post('telefono');
            $correo=$this->input->post('correo');
            $total_hombres=($this->input->post('total_hombres')=="")?0:$this->input->post('total_hombres');
            $total_mujeres=($this->input->post('total_mujeres')=="")?0:$this->input->post('total_mujeres');
            
            if($id_lugar_trabajo=="") {
                $fecha_creacion=date('Y-m-d H:i:s');
                $id_usuario_crea=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_institucion'=>$id_institucion,
                    'id_tipo_lugar_trabajo'=>$id_tipo_lugar_trabajo,
                    'nombre_lugar'=>$nombre_lugar,
                    'direccion_lugar'=>$direccion_lugar,
                    'id_municipio'=>$id_municipio,
                    'nombre_contacto'=>$nombre_contacto,
                    'telefono'=>$telefono,
                    'correo'=>$correo,
                    'total_hombres'=>$total_hombres,
                    'total_mujeres'=>$total_mujeres,
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea,
                );
                $this->promocion_model->guardar_lugar_trabajo($formuInfo);
                $tipo=1;
            }
            else {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'id_institucion'=>$id_institucion,
                    'id_tipo_lugar_trabajo'=>$id_tipo_lugar_trabajo,
                    'nombre_lugar'=>$nombre_lugar,
                    'direccion_lugar'=>$direccion_lugar,
                    'id_municipio'=>$id_municipio,
                    'nombre_contacto'=>$nombre_contacto,
                    'telefono'=>$telefono,
                    'correo'=>$correo,
                    'total_hombres'=>$total_hombres,
                    'total_mujeres'=>$total_mujeres,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica,
                );
                $this->promocion_model->actualizar_lugar_trabajo($formuInfo);
                $tipo=2;
            }
                
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/lugares_trabajo/".$tipo."/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: eliminar_lugar_trabajo
    *   Objetivo: desactiva un lugar de trabajo
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_lugar_trabajo($id_institucion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dlugares_trabajo);
        if($data['id_permiso']==3){
            $this->db->trans_start();
            
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_lugar_trabajo'=>$id_institucion,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->promocion_model->eliminar_lugar_trabajo($formuInfo);
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/lugares_trabajo/3/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo_empresa
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 15/07/2014
    *   Observaciones: Ninguna.
    */
    function lugares_trabajo_empresa($id_institucion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dlugares_trabajo); 
        if($data['id_permiso']==3) {
            $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_empresa($id_institucion);
            $this->load->view('promocion/lugares_trabajo_empresa',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: asignacion
    *   Objetivo: Carga la vista que contiene el formulario de ingreso de asignacion de visitas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 07/07/2014
    *   Observaciones: Ninguna.
    */
    function asignacion($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_1); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('promocion/asignacion',$data,Dasigancion_visita_1);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo_empresa_asigna
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 26/10/2014
    *   Observaciones: Ninguna.
    */
    function lugares_trabajo_empresa_asigna($id_empleado=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_1); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            $info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
            $dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
            $data['lugar_trabajo']=$this->promocion_model->institucion_visita_nuevo($dep);
            $this->load->view('promocion/lugares_trabajo_empresa_asigna',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_asignacion
    *   Objetivo: Guarda el formulario de ingreso de asignacion de visitas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 07/07/2014
    *   Observaciones: Ninguna.
    */
    function guardar_asignacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_1);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_empleado=$this->input->post("id_empleado");
            if($this->input->post('tabla')!="")
                $lt= "&".$this->input->post('tabla');
            $id_lugar_trabajo=explode("&id_lugar_trabajo%5B%5D=",$lt);
            $fecha_creacion=date('Y-m-d H:i:s');
            $id_usuario_crea=$this->session->userdata('id_usuario');
            
            $cad="";
            for($i=1;$i<count($id_lugar_trabajo);$i++) {
                $cad.=" AND id_lugar_trabajo <> ".$id_lugar_trabajo[$i];
            }
            $this->promocion_model->eliminar_asignacion($id_empleado,$cad);
            
            for($i=1;$i<count($id_lugar_trabajo);$i++) {
                $formuInfo = array(
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo[$i],
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea
                );
                $t=$this->promocion_model->buscar_asignacion($id_empleado,$id_lugar_trabajo[$i]);
                if($t['total']==0)
                    $this->promocion_model->guardar_asignacion($formuInfo);
            }
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/asignacion/1/".$tr);
        }
        else {
            pantalla_error();
        }       
    }
    
    /*
    *   Nombre: ver_asignaciones_programacion
    *   Objetivo: Mostrar en una tabla las asignaciones programadas a un empleado
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 29/10/2014
    *   Observaciones: Ninguna.
    */
    function ver_asignaciones_programacion($id_empleado=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_1);
        if($data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $data['lugares_trabajo']=$this->promocion_model->ver_asignaciones($id_empleado);
                        
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            if($tr==1)
                $json =array(
                    'resultado'=>$data['lugares_trabajo']
                );
            else
                $json =array(
                    'resultado'=>0
                );
        }
        else {
            $json =array(
                'resultado'=>0
            );
        }
        echo json_encode($json);
    }
    
    /*
    *   Nombre: programa
    *   Objetivo: Carga la vista que contiene el formulario de ingreso de programacion de visitas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function programa($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 1:
                    $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    $data['id_empleado']=$info['id_empleado'];
                    $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita_nuevo($info['id_empleado']);
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('promocion/programacion',$data,Dprogramar_visita_1);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: programa_recargado
    *   Objetivo: Carga la vista que contiene el formulario de ingreso de programacion de visitas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function programa_recargado($id_programacion_visita=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 1:
                    $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    $data['id_empleado']=$info['id_empleado'];
                    $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita_nuevo($info['id_empleado']);
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
            if($id_programacion_visita!=NULL) {
                $data['programacion']=$this->promocion_model->buscar_programacion($id_programacion_visita);
                $data['idpv']=$id_programacion_visita;
                /*$info=$this->seguridad_model->info_empleado($data['programacion']['id_empleado'], "id_seccion");
                $dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
                $data['institucion']=$this->promocion_model->institucion_visita($dep);
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita($dep,$data['programacion']['id_institucion'],$this->mostrar_todos,$data['programacion']['id_lugar_trabajo']);*/
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita_nuevo($data['programacion']['id_empleado'],$id_programacion_visita);
            }
            
            $this->load->view('promocion/programacion_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: institucion_visita
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function institucion_visita($id_empleado=NULL,$estado=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            if($estado==0 && $id_empleado!=NULL && $id_empleado!='') {
                echo "++++++++++++++".$id_empleado."+++++++++++++";
                $info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
                $dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
                $data['institucion']=$this->promocion_model->institucion_visita($dep);
                $this->load->view('promocion/institucion_visita',$data);
            }
            else {
                $data['institucion']=$this->promocion_model->insticion_lugar_trabajo($id_empleado,date('Y-m-d'));
                $this->load->view('promocion/institucion_visita2',$data);
            }
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo_institucion_visita
    *   Objetivo: Muestra todos los lugares de trabajo de una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Esta funcion permite filtrar si se desea que un lugar de trabajo no puede tener dos visitas activas.
    */
    function lugares_trabajo_institucion_visita($id_empleado=NULL,$id_institucion=NULL,$id_lugar_trabajo=NULL,$vacio=1)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
            $dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
            if($id_lugar_trabajo!="undefined" && $id_lugar_trabajo!="" && $id_lugar_trabajo!=NULL && $id_lugar_trabajo!=0)
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita($dep,$id_institucion,$this->mostrar_todos,$id_lugar_trabajo);
            else {
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita($dep,$id_institucion,$this->mostrar_todos);
            }
            $data['vacio']=$vacio;
            $this->load->view('promocion/lugares_trabajo_empresa_visita',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: lugares_trabajo_institucion_visita_nuevo
    *   Objetivo: Muestra todos los lugares de trabajo asignados a un empleado
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 30/10/2014
    *   Observaciones: Esta funcion permite filtrar si se desea que un lugar de trabajo no puede tener dos visitas activas.
    */
    function lugares_trabajo_institucion_visita_nuevo($id_empleado=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            if($id_empleado!=NULL) {
                $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_institucion_visita_nuevo($id_empleado);
                $vacio=1;
            }
            else {
                $vacio=0;
                $data['lugar_trabajo']=array();
            }
            $data['vacio']=$vacio;
            $this->load->view('promocion/lugares_trabajo_empresa_visita',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: comprobar_programacion
    *   Objetivo: Verifica que el tecnico seleccionado no tenga una visita preveiamente programada en el dia y hora seleccionados
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function comprobar_programacion($estado_programacion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $id_programacion_visita=$this->input->post('id_programacion_visita');
            $id_empleado=$this->input->post('id_empleado');
            $id_lugar_trabajo=$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_visita'));
            $fecha_visita=date("Y-m-d", strtotime($fec));
            $hora_visita=$this->input->post('hour').':'.$this->input->post('minute').':00 '.$this->input->post('meridian');
            $hora_visita=date("H:i:s", strtotime($hora_visita));
            $hora_visita_final=date("H:i:s", strtotime($hora_visita)+3600);
            
            //echo "*".$id_empleado."*".$id_lugar_trabajo."*".$fecha_visita."*".$hora_visita."*".$hora_visita_final;
            if($id_empleado!="" && $id_lugar_trabajo!="" && $fecha_visita!="" && $hora_visita!="" && $hora_visita_final!="") {      
                $formuInfo = array(
                    'id_programacion_visita'=>$id_programacion_visita,
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_visita'=>$fecha_visita,
                    'hora_visita'=>$hora_visita,
                    'hora_visita_final'=>$hora_visita_final,
                    'estado_programacion'=>$estado_programacion
                );
                
                $json =array(
                    'resultado'=>$this->promocion_model->comprobar_programacion($formuInfo)
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
    
    /*
    *   Nombre: guardar_programacion
    *   Objetivo: Guarda el registro de asignacion de visita a una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function guardar_programacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1);
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_programacion_visita=$this->input->post('id_programacion_visita');
            $id_empleado=$this->input->post('id_empleado');
            $id_lugar_trabajo=$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_visita'));
            $fecha_visita=date("Y-m-d", strtotime($fec));
            $hora_visita=$this->input->post('hour').':'.$this->input->post('minute').':00 '.$this->input->post('meridian');
            $hora_visita=date("H:i:s", strtotime($hora_visita));
            $hora_visita_final=date("H:i:s", strtotime($hora_visita)+3600);
            
            if($id_programacion_visita=="") {
                $fecha_creacion=date('Y-m-d H:i:s');
                $id_usuario_crea=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_visita'=>$fecha_visita,
                    'hora_visita'=>$hora_visita,
                    'hora_visita_final'=>$hora_visita_final,
                    'fecha_creacion'=>$fecha_creacion,
                    'id_usuario_crea'=>$id_usuario_crea
                );
                $this->promocion_model->guardar_programacion($formuInfo);
            }
            else {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_programacion_visita'=>$id_programacion_visita,
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_visita'=>$fecha_visita,
                    'hora_visita'=>$hora_visita,
                    'hora_visita_final'=>$hora_visita_final,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                $this->promocion_model->actualizar_programacion($formuInfo);
            }
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/programa/1/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_programacion_nuevo
    *   Objetivo: Guarda el registro de asignacion de visita a una institucion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 30/10/2014
    *   Observaciones: Ninguna.
    */
    function guardar_programacion_nuevo()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1);
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4){
            $this->db->trans_start();
            
            $id_programacion_visita=$this->input->post('id_programacion_visita');
            $id_empleado=$this->input->post('id_empleado');
            $id_lugar_trabajo=$this->input->post('id_lugar_trabajo');
            $fec=str_replace("/","-",$this->input->post('fecha_visita'));
            $fecha_visita=date("Y-m-d", strtotime($fec));
            $hora_visita=$this->input->post('hour').':'.$this->input->post('minute').':00 '.$this->input->post('meridian');
            $hora_visita=date("H:i:s", strtotime($hora_visita));
            $hora_visita_final=date("H:i:s", strtotime($hora_visita)+3600);
            
            if($id_programacion_visita=="") {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_visita'=>$fecha_visita,
                    'hora_visita'=>$hora_visita,
                    'hora_visita_final'=>$hora_visita_final,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                $this->promocion_model->guardar_programacion_nuevo($formuInfo);
            }
            else {
                $fecha_modificacion=date('Y-m-d H:i:s');
                $id_usuario_modifica=$this->session->userdata('id_usuario');
                
                $formuInfo = array(
                    'id_programacion_visita'=>$id_programacion_visita,
                    'id_empleado'=>$id_empleado,
                    'id_lugar_trabajo'=>$id_lugar_trabajo,
                    'fecha_visita'=>$fecha_visita,
                    'hora_visita'=>$hora_visita,
                    'hora_visita_final'=>$hora_visita_final,
                    'fecha_modificacion'=>$fecha_modificacion,
                    'id_usuario_modifica'=>$id_usuario_modifica
                );
                $this->promocion_model->actualizar_programacion($formuInfo);
            }
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/programa/1/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: buscar_asignaciones
    *   Objetivo: Muestra el formulario de busqueda de asignaciones
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 05/11/2014
    *   Observaciones: Ninguna.
    */
    function buscar_asignaciones()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $this->load->view('promocion/buscar_asignaciones');
        }
        else {
            pantalla_error();
        }
    }
    
    function asignaciones_pdf()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $id_empleado=$this->input->post('id_empleado');
            $fec=str_replace("/","-",$this->input->post('fecha_inicial'));
            $fecha_inicial=date("Y-m-d", strtotime($fec));
            $fec=str_replace("/","-",$this->input->post('fecha_final'));
            $fecha_final=date("Y-m-d", strtotime($fec));
            
            if($id_empleado=="") {
                $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                $id_empleado=$info['id_empleado'];
            }
            
            $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
            $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
            $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
            $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
            
            $data['programaciones']=$this->promocion_model->asignaciones_pdf($id_empleado,$fecha_inicial,$fecha_final);
            $html = $this->load->view('promocion/resultados_asignaciones.php', $data, true);
            $data_cab['titulo']="ASIGNACIONES PROGRAMADAS";
            $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
            $this->mpdf->WriteHTML($html,2);
            
            $this->mpdf->AddPage();
            $data['programaciones']=$this->promocion_model->asignaciones_pdf($id_empleado,'0000-00-00','0000-00-00');
            $html = $this->load->view('promocion/resultados_asignaciones.php', $data, true);
            $data_cab['titulo']="ASIGNACIONES NO PROGRAMADAS";
            $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
            $this->mpdf->WriteHTML($html,2);
            $this->mpdf->Output(); /*Salida del pdf*/
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: calendario
    *   Objetivo: Muestra el calendario mensual de las visitas programadas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function calendario($id_empleado=NULL,$como_mostrar=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['como_mostrar']=$como_mostrar;
            $data['visita']=$this->promocion_model->calendario($id_empleado);
            $this->load->view('promocion/calendario',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: calendario_dia
    *   Objetivo: Muestra el calendario diario de las visitas programadas
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function calendario_dia($id_empleado=NULL,$fecha)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['visita']=$this->promocion_model->calendario_dia($id_empleado, $fecha);
            $this->load->view('promocion/calendario_dia',$data);
        }
        else {
            $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
            if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
                $data['visita']=$this->promocion_model->calendario_dia($id_empleado, $fecha);
                $this->load->view('promocion/calendario_dia',$data);
            }
            else {
                pantalla_error();
            }
        }
    }
    
    /*
    *   Nombre: eliminar_programacion
    *   Objetivo: Elimina un registro de visita
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_programacion($id_programacion_visita=NULL) 
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $this->promocion_model->eliminar_programacion($id_programacion_visita);
            $json =array(
                    'resultado'=>1
                );
        }
        else {
            $json =array(
                    'resultado'=>0
                );
        }
        echo json_encode($json);
    }
    
    /*
    *   Nombre: eliminar_programacion_nuevo
    *   Objetivo: Elimina un registro de visita
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 17/07/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_programacion_nuevo($id_programacion_visita=NULL) 
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_1); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_programacion_visita'=>$id_programacion_visita,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica
            );
            $this->promocion_model->eliminar_programacion_nuevo($formuInfo);
            $json =array(
                    'resultado'=>1
                );
        }
        else {
            $json =array(
                    'resultado'=>0
                );
        }
        echo json_encode($json);
    }
    
    function ingreso($accion_transaccion=NULL,$estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dingreso_promocion); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 1:
                    $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    /*$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];*/
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
			$data['incumplimientos']=$this->promocion_model->ver_incumplimientos();
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('promocion/ingreso_promocion',$data,Dingreso_promocion);
        }
        else {
            pantalla_error();
        }
    }
    
    function ver_asignaciones()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 1:
                    $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['visita_mensual']=$this->promocion_model->calendario($info['id_empleado']);
                    $data['visita']=$this->promocion_model->calendario_dia($info['id_empleado'], date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    /*$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['visita_mensual']=$this->promocion_model->calendario($info['id_empleado']);
                    $data['visita']=$this->promocion_model->calendario_dia($info['id_empleado'], date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];*/
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
            pantalla('promocion/asignaciones',$data,Dasignaciones);
        }
        else {
            pantalla_error();
        }
    }
    
    function ingreso_promocion_recargado()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            switch($data['id_permiso']) {
                case 1:
                    $info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];
                    break;
                case 3:
                    $data['tecnico']=$this->promocion_model->mostrar_tecnicos();
                    break;
                case 4:
                    /*$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
                    $data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'));
                    $data['id_empleado']=$info['id_empleado'];*/
                    $id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion'])) 
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
                    else
                        $data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
                    break;
            }
            $this->load->view('promocion/ingreso_promocion_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function ingreso_promocion_institucion_recargado($id_institucion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['institucion']=$this->promocion_model->mostrar_institucion(1, $id_institucion);
            $data['clasificacion']=$this->promocion_model->mostrar_clasificacion();
            $data['sector']=$this->promocion_model->mostrar_sector();
            $this->load->view('promocion/ingreso_promocion_institucion_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function ingreso_promocion_lugar_trabajo_recargado($id_lugar_trabajo=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $data['lugar_trabajo']=$this->promocion_model->lugares_trabajo_empresa(NULL,$id_lugar_trabajo);
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            $this->load->view('promocion/ingreso_promocion_lugar_trabajo_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
    function guardar_ingreso_promocion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
        if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
            $this->db->trans_start();
            
            $ids=explode("***",$this->input->post('id_lugar_trabajo'));
            $id_programacion_visita=$ids[0];
            $id_institucion=$ids[1];
            $id_lugar_trabajo=$ids[2];  
            
            $fec=str_replace("/","-",$this->input->post('fecha_promocion'));
            $fecha_promocion=date("Y-m-d", strtotime($fec));
            $hora_inicio=$this->input->post('hora_inicio');
            $hora_final=$this->input->post('hora_final');
            $nombre_recibio=$this->input->post('nombre_recibio');
            $observaciones=$this->input->post('observaciones');
            $necesita_comite=($this->input->post('necesita_comite')=='')?'0':$this->input->post('necesita_comite');     
            
            $nombre_institucion=$this->input->post('nombre_institucion');
            $nit_empleador=$this->input->post('nit_empleador');
            $nombre_representante=$this->input->post('nombre_representante');
            $id_clasificacion=($this->input->post('id_clasificacion')=='')?'NULL':$this->input->post('id_clasificacion');
            $id_sector=($this->input->post('id_sector')=='')?'NULL':$this->input->post('id_sector');
            $sindicato=($this->input->post('sindicato')=='')?'0':$this->input->post('sindicato');
            
            $id_tipo_lugar_trabajo=$this->input->post('id_tipo_lugar_trabajo');
            $nombre_lugar=$this->input->post('nombre_lugar');
            $direccion_lugar=$this->input->post('direccion_lugar');
            $id_municipio=$this->input->post('id_municipio');
            
            $nombre_contacto=$this->input->post('nombre_contacto');
            $telefono=$this->input->post('telefono');
            $correo=$this->input->post('correo');
            $total_hombres=($this->input->post('total_hombres')=="")?0:$this->input->post('total_hombres');
            $total_mujeres=($this->input->post('total_mujeres')=="")?0:$this->input->post('total_mujeres');
			
			$id_incumplimiento=$this->input->post('id_incumplimiento');	
			$observacion_adicional=$this->input->post('observacion_adicional');
            
            $fecha_creacion=date('Y-m-d H:i:s');
            $id_usuario_crea=$this->session->userdata('id_usuario');
            $fecha_modificacion=date('Y-m-d H:i:s');
            $id_usuario_modifica=$this->session->userdata('id_usuario');
            
            $formuInfo = array(
                'id_programacion_visita'=>$id_programacion_visita,
                'estado_programacion'=>2,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica
            );
            $this->promocion_model->actualizar_estado_programacion($formuInfo);
            
            $formuInfo = array(
                'id_programacion_visita'=>$id_programacion_visita,
                'fecha_promocion'=>$fecha_promocion,
                'hora_inicio'=>$hora_inicio,
                'hora_final'=>$hora_final,
                'nombre_recibio'=>$nombre_recibio,
                'observaciones'=>$observaciones,
                /*'necesita_comite'=>$necesita_comite,*/
                'fecha_creacion'=>$fecha_creacion,
                'id_usuario_crea'=>$id_usuario_crea
            );
            $id_promocion=$this->promocion_model->guardar_ingreso_promocion($formuInfo);
            
            $formuInfo = array(
                'id_institucion'=>$id_institucion,
                'nombre_institucion'=>$nombre_institucion,
                'nit_empleador'=>$nit_empleador,
                'nombre_representante'=>$nombre_representante,
                'id_clasificacion'=>$id_clasificacion,
                'id_sector'=>$id_sector,
                'sindicato'=>$sindicato,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->promocion_model->actualizar_promocion($formuInfo);
            
            $formuInfo = array(
                'id_lugar_trabajo'=>$id_lugar_trabajo,
                'id_institucion'=>$id_institucion,
                'id_tipo_lugar_trabajo'=>$id_tipo_lugar_trabajo,
                'nombre_lugar'=>$nombre_lugar,
                'direccion_lugar'=>$direccion_lugar,
                'id_municipio'=>$id_municipio,
                'nombre_contacto'=>$nombre_contacto,
                'telefono'=>$telefono,
                'correo'=>$correo,
                'total_hombres'=>$total_hombres,
                'total_mujeres'=>$total_mujeres,                
                'necesita_comite'=>$necesita_comite,
                'fecha_modificacion'=>$fecha_modificacion,
                'id_usuario_modifica'=>$id_usuario_modifica,
            );
            $this->promocion_model->actualizar_lugar_trabajo($formuInfo);
			
			/*echo "guardar_ingreso_tematica";*/
			for($i=0;$i<count($id_incumplimiento);$i++) {
				$formuInfo = array(
					'id_promocion'=>$id_promocion,
					'id_incumplimiento'=>$id_incumplimiento[$i],
					'observacion_adicional'=>""
				);
				$this->promocion_model->guardar_ingreso_incumplimiento($formuInfo);
				/*echo "<pre>";
				print_r($formuInfo);
				echo "</pre>";*/
			}
			
			if($observacion_adicional!="") {
				$formuInfo = array(
					'id_promocion'=>$id_promocion,
					'id_incumplimiento'=>"NULL",
					'observacion_adicional'=>$observacion_adicional
				);
				$this->promocion_model->guardar_ingreso_incumplimiento($formuInfo);
			}
            
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a("index.php/promocion/ingreso/1/".$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    function promociones()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_promociones); 
        if($data['id_permiso']==3 || $data['id_permiso']==4) {
            
            $data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
            $data['municipio']=$this->promocion_model->mostrar_municipio();
            pantalla('promocion/promociones',$data,Dreportes_promociones);
        }
        else {
            pantalla_error();
        }
    }
    
    function resultados($fecha_iniciale=NULL,$fecha_finale=NULL,$reportee=NULL,$exportacione=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_promociones); 
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
                    $data['info']=$this->promocion_model->resultados_instituciones($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Instituciones ".date('d-m-Y hisa');
                    if($data['exportacion']!=2) {
                        $this->load->view('promocion/resultados_instituciones',$data);
                    }
                    else {                      
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_instituciones.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES REALIZADAS POR LUGAR DE TRABAJO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 2:
                    $data['info']=$this->promocion_model->resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Técnicos ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('promocion/resultados_tecnicos',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_tecnicos.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES REALIZADAS POR TÉCNICO EDUCADOR";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); /*Salida del pdf*/
                    }
                    break;
                case 3:
                    $data['info']=$this->promocion_model->resultados_sectores($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Sectores ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('promocion/resultados_sectores',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
                        $this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_sectores.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES POR SECTOR ECONÓMICO";
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