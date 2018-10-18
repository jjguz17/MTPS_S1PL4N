<?php
class Usuarios extends CI_Controller
{
    
    function Usuarios()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model('usuario_model');
        $this->load->model('seguridad_model');
        $this->load->model('transporte_model');
        $this->load->library("mpdf");
        date_default_timezone_set('America/El_Salvador');
        if(!$this->session->userdata('id_usuario')) {
            redirect('index.php/sessiones');
        }
    }
    
    function index()
    {
        ir_a("index.php/usuarios/roles");
    }
    
    /*
    *   Nombre: roles
    *   Objetivo: Carga la vista para la administracion de los roles
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 11/05/2014
    *   Observaciones: Ninguna.
    */
    function roles($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_rol); /*Verificacion de permiso para administrara roles*/
        
        if($data['id_permiso']==3) {
            switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
                case 1:
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
                case 2:
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
                case 3:
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
            }
            $data['menu']=$this->usuario_model->mostrar_menu();
            $data['estado_transaccion']=$estado_transaccion;
            $data['accion_transaccion']=$accion_transaccion;
            pantalla('usuarios/roles',$data,Dcontrol_rol);  
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: datos_de_rol
    *   Objetivo: Carga la vista para crear o modificar los roles
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 11/05/2014
    *   Observaciones: Ninguna.
    */
    function datos_de_rol($id_rol=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_rol); /*Verificacion de permiso para administrara roles*/
        
        if($data['id_permiso']==3) {
            switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
                case 1:
                    $data['menu']=$this->usuario_model->mostrar_menu($id_rol);
                    break;
                case 2:
                    $data['menu']=$this->usuario_model->mostrar_menu($id_rol);
                    break;
                case 3:
                    $data['menu']=$this->usuario_model->mostrar_menu($id_rol);
                    break;
            }
            
            if($id_rol!=NULL)           
                $data['rol']=$this->usuario_model->mostrar_roles($id_rol);
            else
                $data['rol']=array();
                
            $this->load->view('usuarios/formu_rol',$data);  
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: guardar_rol
    *   Objetivo: Guarda los registros de roles
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/05/2014
    *   Observaciones: Ninguna.
    */
    function guardar_rol()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_rol);
        
        if($data['id_permiso']==3) {
            $id_rol=$this->input->post('id_rol');
            if($id_rol=="") {
            
                $this->db->trans_start();
                $nombre_rol=strtoupper($this->input->post('nombre_rol'));
                $descripcion_rol=$this->input->post('descripcion_rol');
                
                $formuInfo = array(
                    'nombre_rol'=>$nombre_rol,
                    'descripcion_rol'=>$descripcion_rol
                );
                
                $id_rol=$this->usuario_model->guardar_rol($formuInfo); /*Guardando rol*/
                $permiso=$this->input->post('permiso');
                
                for($i=0;$i<count($permiso);$i++) {
                    if($permiso[$i]!="") {
                        $explode_permiso=explode(",",$permiso[$i]);
                        $id_modulo=$explode_permiso[0];
                        $id_permiso=$explode_permiso[1];
                        $formuInfo = array(
                            'id_rol'=>$id_rol,
                            'id_modulo'=>$id_modulo,
                            'id_permiso'=>$id_permiso,
                            'estado'=>1
                        );
                        $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol*/
                        
                        $data=$this->usuario_model->buscar_padre_permisos_rol($id_modulo); 
                        if($data['padre']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['padre'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['padre']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el padre*/
                        }
                        
                        if($data['abuelo']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['abuelo'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['abuelo']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el abuelo*/
                        }
                        
                        if($data['bisabuelo']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['bisabuelo'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['bisabuelo']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el bisabuelo*/
                        }
                            
                    }
                }
                $formuInfo = array(
                    'id_rol'=>$id_rol,
                    'id_modulo'=>71,
                    'id_permiso'=>3,
                    'estado'=>1
                );
                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para salir del sistema*/
                
                $this->db->trans_complete();
                $tr=($this->db->trans_status()===FALSE)?0:1;
                ir_a('index.php/usuarios/roles/1/'.$tr);
            }
            else {
                $this->db->trans_start();
                $id_rol=$this->input->post('id_rol');
                $nombre_rol=strtoupper($this->input->post('nombre_rol'));
                $descripcion_rol=$this->input->post('descripcion_rol');
                
                $formuInfo = array(
                    'id_rol'=>$id_rol,
                    'nombre_rol'=>$nombre_rol,
                    'descripcion_rol'=>$descripcion_rol
                );
                
                $this->usuario_model->actualizar_rol($formuInfo); /*Actualizar rol*/
                $this->usuario_model->eliminar_permisos_rol($id_rol); /*Eliminar permisos del rol*/
                $permiso=$this->input->post('permiso');
                
                for($i=0;$i<count($permiso);$i++) {
                    if($permiso[$i]!="") {
                        $explode_permiso=explode(",",$permiso[$i]);
                        $id_modulo=$explode_permiso[0];
                        $id_permiso=$explode_permiso[1];
                        $formuInfo = array(
                            'id_rol'=>$id_rol,
                            'id_modulo'=>$id_modulo,
                            'id_permiso'=>$id_permiso,
                            'estado'=>1
                        );
                        $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol*/
                        
                        $data=$this->usuario_model->buscar_padre_permisos_rol($id_modulo); 
                        if($data['padre']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['padre'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['padre']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el padre*/
                        }
                        
                        if($data['abuelo']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['abuelo'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['abuelo']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el abuelo*/
                        }
                        
                        if($data['bisabuelo']!="") {
                            $formuInfo = array(
                                'id_rol'=>$id_rol,
                                'id_modulo'=>$data['bisabuelo'],
                                'id_permiso'=>$id_permiso,
                                'estado'=>1
                            );
                            $total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['bisabuelo']);
                            if($total['total']==0)
                                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el bisabuelo*/
                        }
                            
                    }
                }
                $formuInfo = array(
                    'id_rol'=>$id_rol,
                    'id_modulo'=>71,
                    'id_permiso'=>3,
                    'estado'=>1
                );
                $this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para salir del sistema*/
                
                $this->db->trans_complete();
                $tr=($this->db->trans_status()===FALSE)?0:1;
                ir_a('index.php/usuarios/roles/2/'.$tr);
            }
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: eliminar_rol
    *   Objetivo: Elimina los registros de roles
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/05/2014
    *   Observaciones: Ninguna.
    */
    function eliminar_rol($id_rol=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_rol);
        
        if($data['id_permiso']==3) {
            $this->db->trans_start();
            $this->usuario_model->eliminar_rol($id_rol); /*Eliminar rol*/
            $this->usuario_model->eliminar_permisos_rol($id_rol); /*Eliminar permisos del rol*/
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a('index.php/usuarios/roles/3/'.$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: usuario
    *   Objetivo: Carga la vista para la administracion de los usuarios
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 19/05/2014
    *   Observaciones: Ninguna.
    */
    function usuario($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_usuario); /*Verificacion de permiso para administrara usuarios*/
        
        if($data['id_permiso']==3) {
            switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
                case 1:
                    $data['usuarios']=$this->usuario_model->mostrar_usuarios(NULL,NULL,1);
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario();
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
                case 2:
                    $data['usuarios']=$this->usuario_model->mostrar_usuarios(NULL,NULL,1);
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario();
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
                case 3:
                    $data['usuarios']=$this->usuario_model->mostrar_usuarios(NULL,NULL,1);
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario();
                    $data['roles']=$this->usuario_model->mostrar_roles();
                    break;
            }
            $data['accion_transaccion']=$accion_transaccion;
            $data['estado_transaccion']=$estado_transaccion;
            pantalla('usuarios/usuarios',$data,Dcontrol_usuario);   
        }
        else {
            pantalla_error();
        }
    }
        
    /*
    *   Nombre: datos_de_usuario
    *   Objetivo: Carga la vista del formulario creación o actualización de usuarios
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 20/05/2014
    *   Observaciones: Ninguna.
    */
    function datos_de_usuario($id_usuario=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_usuario); /*Verificacion de permiso para administrara usuarios*/
        
        if($data['id_permiso']==3) {
            switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
                case 1:
                    $id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario($id_seccion['id_seccion']);
                    break;
                case 2:
                    $id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario($id_seccion['id_seccion']);
                    break;
                case 3:
                    $data['empleados']=$this->usuario_model->empleados_sin_usuario();
                    break;
            }
            $data['roles']=$this->usuario_model->mostrar_roles();
            
            if($id_usuario!=NULL)           
                $data['usu']=$this->usuario_model->mostrar_usuarios($id_usuario);
            else
                $data['usu']=array();
            
            $this->load->view('usuarios/formu_usuario',$data);  
        }
        else {
            pantalla_error();
        }
    }
    
    /*
    *   Nombre: buscar_info_adicional_usuario
    *   Objetivo: Mostrar la informacion del usuario que se necesita crear
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/05/2014
    *   Observaciones: Ninguna
    */
    function buscar_info_adicional_usuario()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_usuario); /*Verificacion de permiso para crear solicitudes*/
        
        if($data['id_permiso']==3) {
            $id_empleado=$this->input->post('id_empleado');
            $data=$this->usuario_model->info_adicional($id_empleado);
            if($data['usuario']!="")
                $estado=1;
            $json =array(
                'usuario'=>$data['usuario'],
                'estado'=>$estado
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'estado'=>0
            );
            echo json_encode($json);
        }
    }
    
    /*
    *   Nombre: guardar_usuario
    *   Objetivo: Guarda los registros de usuarios
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/05/2014
    *   Observaciones: Ninguna.
    */
    function guardar_usuario()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_usuario);
        
        if($data['id_permiso']==3) {
            $id_usuario=$this->input->post('id_usuario');
            
            if($id_usuario=="") {
                $this->db->trans_start();
                $id_empleado=$this->input->post('nombre_completo');
                $usuario=$this->input->post('usuario');
                $password=md5($this->input->post('password'));
                
                $data=$this->usuario_model->info_adicional($id_empleado);
                
    
                if($data['id_genero']==1) {
                    $data['id_genero']="M";
                }
                else 
                    $data['id_genero']="F";
                
                $formuInfo = array(
                    'nombre_completo'=>$data['nombre'],
                    'password'=>$password,
                    'nr'=>$data['nr'],
                    'sexo'=>$data['id_genero'],
                    'usuario'=>$usuario,
                    'id_seccion'=>$data['id_seccion'],
                    'estado'=>1
                );
                
                $id_usuario=$this->usuario_model->guardar_usuario($formuInfo); /*Guardando usuario*/
                $id_rol=$this->input->post('id_rol');
    
                for($i=0;$i<count($id_rol);$i++) {
                    $formuInfo = array(
                        'id_rol'=>$id_rol[$i],
                        'id_usuario'=>$id_usuario
                    );
                    $this->usuario_model->guardar_permisos_usuario($formuInfo); /*Guardando permisos del usuario*/
                }
                $this->db->trans_complete();
                $tr=($this->db->trans_status()===FALSE)?0:1;
                ir_a('index.php/usuarios/usuario/1/'.$tr);
            }
            else {
                $this->db->trans_start();
                $id_usuario=$this->input->post('id_usuario');
                $password=md5($this->input->post('password'));
                
                if($password!="") {         
                    $formuInfo = array(
                        'password'=>$password,
                        'id_usuario'=>$id_usuario
                    );
                    $this->usuario_model->actualizar_usuario($formuInfo); /*Actualizar usuario*/
                }
                
                $this->usuario_model->eliminar_roles_usuario($id_usuario); /*Eliminar permisos del usuario*/
                
                $id_rol=$this->input->post('id_rol');
    
                for($i=0;$i<count($id_rol);$i++) {
                    $formuInfo = array(
                        'id_rol'=>$id_rol[$i],
                        'id_usuario'=>$id_usuario
                    );
                    $this->usuario_model->guardar_permisos_usuario($formuInfo); /*Guardando permisos del usuario*/
                }
                $this->db->trans_complete();
                $tr=($this->db->trans_status()===FALSE)?0:1;
                ir_a('index.php/usuarios/usuario/2/'.$tr);
            }
        }
        else {
            pantalla_error();
        }
    }

    
    /*
    *   Nombre: eliminar_usuario
    *   Objetivo: Desvactiva los registros de usuarios
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 20/05/2014
    *   Observaciones: No elimina, solo cambia a cero el estado del usuario.
    */
    function eliminar_usuario($id_usuario=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_usuario);
        
        if($data['id_permiso']==3) {
            $this->db->trans_start();
            $this->usuario_model->desactivar_usuario($id_usuario); /*Desactivar usuario*/
            /*$this->usuario_model->eliminar_usuario($id_usuario);*/ /*Eliminar usuario*/
            /*$this->usuario_model->eliminar_permisos_usuario($id_usuario);*/ /*Eliminar permisos del usuario*/
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            ir_a('index.php/usuarios/usuario/3/'.$tr);
        }
        else {
            pantalla_error();
        }
    }
    
    function buscar()
    {
        $buscar=$this->input->post('buscar');
        $data['buscar']=$buscar;
        $data['resultados']=$this->usuario_model->realizar_busqueda($this->session->userdata('id_usuario'),$buscar); 
        pantalla('resultados_busqueda',$data);
    }

    function mi_perfil($accion_transaccion=NULL, $estado_transaccion=NULL)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dinicio); 
        if($data['id_permiso']!=NULL) {
            $data['usuario']=$this->usuario_model->buscar_perfil($this->session->userdata('id_usuario'));
            $data['accion_transaccion']=$accion_transaccion;
            $data['estado_transaccion']=$estado_transaccion;
            pantalla('usuarios/formu_perfil',$data,2000);
        }
        else {
            pantalla_error();
        }
    }

    function actualizar_usuario()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dinicio); 
        if($data['id_permiso']!=NULL) {
            $this->db->trans_start();
            $id_usuario=$this->session->userdata('id_usuario');
            $password=$this->input->post('password');
            $new_password=md5($this->input->post('new_password'));
            $new_password2=md5($this->input->post('new_password2'));

            $u=$this->seguridad_model->consultar_usuario($this->session->userdata('usuario'),$password);

            $formuInfo = array(
                'password'=>$new_password,
                'id_usuario'=>$id_usuario
            );
            if($new_password==$new_password2 && $new_password!="" && $u['id_usuario']!=0)
                $this->usuario_model->actualizar_usuario($formuInfo);

            $this->db->trans_complete();

            if($new_password==$new_password2 && $u['id_usuario']!=0)
                $tr=($this->db->trans_status()===FALSE)?0:1;
            else
                if($u['id_usuario']==0)
                    $tr=3;
                else
                    $tr=4;

            ir_a('index.php/usuarios/mi_perfil/2/'.$tr);
        }
        else {
            pantalla_error();
        }
    }
}
?>