<?php
class Verificacion extends CI_Controller
{
	public $mostrar_todos="FALSE"; 
	
    function Verificacion()
	{
        parent::__construct();
		error_reporting(0);
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library("mpdf");
		$this->load->model('seguridad_model');
		$this->load->model('promocion_model');
		$this->load->model('acreditacion_model');
		$this->load->model('verificacion_model');
		date_default_timezone_set('America/El_Salvador');
		
		if(!$this->session->userdata('id_usuario')){
		 	redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		ir_a("index.php/verificacion/programa");
  	}
	
	/*
	*	Nombre: asignacion
	*	Objetivo: Carga la vista que contiene el formulario de ingreso de asignacion de visitas
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 02/11/2014
	*	Observaciones: Ninguna.
	*/
	function asignacion($accion_transaccion=NULL, $estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_2); 
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
			pantalla('verificacion/asignacion',$data,Dasigancion_visita_2);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: lugares_trabajo_empresa_asigna
	*	Objetivo: Muestra todos los lugares de trabajo de una institucion
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 02/11/2014
	*	Observaciones: Ninguna.
	*/
	function lugares_trabajo_empresa_asigna($id_empleado=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_2); 
		if($data['id_permiso']==3 || $data['id_permiso']==4) {
			$info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
			$dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
			$data['lugar_trabajo']=$this->verificacion_model->institucion_visita_nuevo($dep);
			$this->load->view('verificacion/lugares_trabajo_empresa_asigna',$data);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: guardar_asignacion
	*	Objetivo: Guarda el formulario de ingreso de asignacion de visitas
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 02/11/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_asignacion()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_2);
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
			$this->verificacion_model->eliminar_asignacion($id_empleado,$cad);
			
			for($i=1;$i<count($id_lugar_trabajo);$i++) {
				$formuInfo = array(
					'id_empleado'=>$id_empleado,
					'id_lugar_trabajo'=>$id_lugar_trabajo[$i],
					'fecha_creacion'=>$fecha_creacion,
					'id_usuario_crea'=>$id_usuario_crea
				);
				$t=$this->verificacion_model->buscar_asignacion($id_empleado,$id_lugar_trabajo[$i]);
				if($t['total']==0)
					$this->verificacion_model->guardar_asignacion($formuInfo);
			}
			
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a("index.php/verificacion/asignacion/1/".$tr);
		}
		else {
			pantalla_error();
		}		
	}
	
	/*
	*	Nombre: ver_asignaciones_programacion
	*	Objetivo: Mostrar en una tabla las asignaciones programadas a un empleado
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 02/11/2014
	*	Observaciones: Ninguna.
	*/
	function ver_asignaciones_programacion($id_empleado=0)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasigancion_visita_2);
		if($data['id_permiso']==3 || $data['id_permiso']==4){
			$this->db->trans_start();
			
			$data['lugares_trabajo']=$this->verificacion_model->ver_asignaciones($id_empleado);
						
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
	*	Nombre: programa
	*	Objetivo: Carga la vista del formulario de registro de programacion de visitas
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 01/09/2014
	*	Observaciones: Ninguna.
	*/
	function programa($accion_transaccion=NULL, $estado_transaccion=NULL)
	{	
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			switch($data['id_permiso']) {
				case 1:
					$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
					$data['tecnico']=$this->promocion_model->mostrar_tecnicos();
					$data['id_empleado']=$info['id_empleado'];
					$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita_nuevo($info['id_empleado']);
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
			pantalla('verificacion/programacion',$data,Dprogramar_visita_2);
		}
		else {
			pantalla_error();
		}
	}

	/*
	*	Nombre: programa_recargado
	*	Objetivo: Funcion que recarga el formulario para editarlo o limpiarlo 
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 01/09/2014
	*	Observaciones: Ninguna.
	*/
	function programa_recargado($id_programacion_visita=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			switch($data['id_permiso']) {
				case 1:
					$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
					$data['tecnico']=$this->promocion_model->mostrar_tecnicos();
					$data['id_empleado']=$info['id_empleado'];
					$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita_nuevo($info['id_empleado']);
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
				$data['institucion']=$this->verificacion_model->institucion_visita($dep);
				$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita($dep,$data['programacion']['id_institucion'],$this->mostrar_todos,$data['programacion']['id_lugar_trabajo']);*/
				$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita_nuevo($data['programacion']['id_empleado'],$id_programacion_visita);
			}
			
			$this->load->view('verificacion/programacion_recargado',$data);
		}
		else {
			pantalla_error();
		}
	}
	/*
	*	Nombre: institucion_visita
	*	Objetivo: Muestra todos los lugares de trabajo de una institucion
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function institucion_visita($id_empleado=NULL,$estado=0)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			if($estado==0) {
				$info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
				$dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
				$data['institucion']=$this->verificacion_model->institucion_visita($dep);
				$this->load->view('verificacion/institucion_visita',$data);
			}
			else {
				$data['institucion']=$this->verificacion_model->insticion_lugar_trabajo($id_empleado,date('Y-m-d'),3);
				$this->load->view('verificacion/institucion_visita2',$data);
			}
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: lugares_trabajo_institucion_visita
	*	Objetivo: Muestra todos los lugares de trabajo de una institucion
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Esta funcion permite filtrar si se desea que un lugar de trabajo no puede tener dos visitas activas.
	*/
	function lugares_trabajo_institucion_visita($id_empleado=NULL,$id_institucion=NULL,$id_lugar_trabajo=NULL,$vacio=1)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			$info=$this->seguridad_model->info_empleado($id_empleado, "id_seccion");
			$dep=$this->promocion_model->ubicacion_departamento($info["id_seccion"]);
			if($id_lugar_trabajo!="undefined" && $id_lugar_trabajo!="" && $id_lugar_trabajo!=NULL && $id_lugar_trabajo!=0)
				$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita($dep,$id_institucion,$this->mostrar_todos,$id_lugar_trabajo);
			else {
				$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita($dep,$id_institucion,$this->mostrar_todos);
			}
			$data['vacio']=$vacio;
			$this->load->view('verificacion/lugares_trabajo_empresa_visita',$data);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: lugares_trabajo_institucion_visita_nuevo
	*	Objetivo: Muestra todos los lugares de trabajo asignados a un empleado
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 03/10/2014
	*	Observaciones: Esta funcion permite filtrar si se desea que un lugar de trabajo no puede tener dos visitas activas.
	*/
	function lugares_trabajo_institucion_visita_nuevo($id_empleado=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			if($id_empleado!=NULL) {
				$data['lugar_trabajo']=$this->verificacion_model->lugares_trabajo_institucion_visita_nuevo($id_empleado);
				$vacio=1;
			}
			else {
				$vacio=0;
				$data['lugar_trabajo']=array();
			}
			$data['vacio']=$vacio;
			$this->load->view('verificacion/lugares_trabajo_empresa_visita',$data);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: comprobar_programacion
	*	Objetivo: Verifica que el tecnico seleccionado no tenga una visita preveiamente programada en el dia y hora seleccionados
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function comprobar_programacion($estado_programacion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
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
	*	Nombre: guardar_programacion
	*	Objetivo: Guarda el registro de asignacion de visita a una institucion
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_programacion()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2);
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
					'id_usuario_crea'=>$id_usuario_crea,
					'estado_programacion'=>3
				);
				$this->verificacion_model->guardar_programacion($formuInfo);
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
			ir_a("index.php/verificacion/programa/1/".$tr);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: guardar_programacion_nuevo
	*	Objetivo: Guarda el registro de asignacion de visita a una institucion
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 30/10/2014
	*	Observaciones: Ninguna.
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
			ir_a("index.php/verificacion/programa/1/".$tr);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: calendario
	*	Objetivo: Muestra el calendario mensual de las visitas programadas
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function calendario($id_empleado=NULL,$como_mostrar=0)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			$data['como_mostrar']=$como_mostrar;
			$data['visita']=$this->promocion_model->calendario($id_empleado);
			$this->load->view('verificacion/calendario',$data);
		}
		else {
			pantalla_error();
		}
	}
	
	/*
	*	Nombre: calendario_dia
	*	Objetivo: Muestra el calendario diario de las visitas programadas
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function calendario_dia($id_empleado=NULL,$fecha)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
		  	$data['visita']=$this->promocion_model->calendario_dia($id_empleado, $fecha);
			$this->load->view('verificacion/calendario_dia',$data);
		}
		else {
			$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
			if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
				$data['visita']=$this->promocion_model->calendario_dia($id_empleado, $fecha);
				$this->load->view('verificacion/calendario_dia',$data);
			}
			else {
				pantalla_error();
			}
		}
	}
	
	/*
	*	Nombre: eliminar_programacion
	*	Objetivo: Elimina un registro de visita
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
	*/
	function eliminar_programacion($id_programacion_visita=NULL) 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dprogramar_visita_2); 
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
	*	Nombre: eliminar_programacion_nuevo
	*	Objetivo: Elimina un registro de visita
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 17/07/2014
	*	Observaciones: Ninguna.
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
	
	function ingreso()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_visita); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			switch($data['id_permiso']) {
				case 1:
					$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
					$data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'),3);
					$data['id_empleado']=$info['id_empleado'];
					break;
				case 3:
					$data['tecnico']=$this->promocion_model->mostrar_tecnicos();
					break;
				case 4:
					/*$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
					$data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'),3);
					$data['id_empleado']=$info['id_empleado'];*/
					$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
					if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion']))	
						$data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
					else
						$data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
					break;
			}
			$data['estado_verificacion']=$this->verificacion_model->ver_estados_verificacion();
			$data['tematicas']=$this->verificacion_model->ver_tematicas();
			$data['incumplimientos']=$this->promocion_model->ver_incumplimientos();
			$data['estado_transaccion']=$estado_transaccion;
			$data['accion_transaccion']=$accion_transaccion;
			pantalla('verificacion/ingreso_promocion',$data,Dcontrol_visita);
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
					$data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'),3);
					$data['id_empleado']=$info['id_empleado'];
					break;
				case 3:
					$data['tecnico']=$this->promocion_model->mostrar_tecnicos();
					break;
				case 4:
					/*$info=$this->seguridad_model->info_empleado(0, "id_empleado",$this->session->userdata('id_usuario'));
					$data['insticion_lugar_trabajo']=$this->promocion_model->insticion_lugar_trabajo($info['id_empleado'],date('Y-m-d'),3);
					$data['id_empleado']=$info['id_empleado'];*/
					$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
					if(!$this->promocion_model->es_san_salvador($id_seccion['id_seccion']))	
						$data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],2);
					else
						$data['tecnico']=$this->promocion_model->mostrar_tecnicos($id_seccion['id_seccion'],1);
					break;
			}
			$data['estado_verificacion']=$this->verificacion_model->ver_estados_verificacion();
			$this->load->view('verificacion/ingreso_promocion_recargado',$data);
		}
		else {
			pantalla_error();
		}
	}

	/*
	*	Nombre: miembros_comite
	*	Objetivo: Muestra los miembros de un comite
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/11/2014
	*	Observaciones: Ninguna.
	*/
	function miembros_comite($id_lugar_trabajo=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dparticipantes); 
		if($data['id_permiso']==3 || $data['id_permiso']==4){
			$data['empleado_institucion']=$this->acreditacion_model->empleados_lugar_trabajo($id_lugar_trabajo,"",1);
			$this->load->view('acreditacion/miembros_comite',$data);
		}
		else {
			pantalla_error();
		}
	}
	
	function ingreso_promocion_institucion_recargado($id_institucion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dasignaciones); 
		if($data['id_permiso']==1 || $data['id_permiso']==3 || $data['id_permiso']==4) {
			$data['tematicas']=$this->verificacion_model->ver_tematicas();
			$this->load->view('verificacion/ingreso_promocion_institucion_recargado',$data);
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
			$id_empleado_institucion=$this->input->post('id_empleado_institucion');	
			$observaciones=$this->input->post('observaciones');	
			$id_estado_verificacion=$this->input->post('id_estado_verificacion');	
			
			/*$id_tematica=$this->input->post('id_tematica');*/	
			$id_tematica=$this->input->post('id_tematica_real');
			$fecha_capacitacion=$this->input->post('fecha_capacitacion');
			$facilitador=$this->input->post('facilitador');
			
			$id_incumplimiento=$this->input->post('id_incumplimiento');	
			$observacion_adicional=$this->input->post('observacion_adicional');
			
			$fecha_creacion=date('Y-m-d H:i:s');
			$id_usuario_crea=$this->session->userdata('id_usuario');
			$fecha_modificacion=date('Y-m-d H:i:s');
			$id_usuario_modifica=$this->session->userdata('id_usuario');
			
			$formuInfo = array(
				'id_programacion_visita'=>$id_programacion_visita,
				'estado_programacion'=>4,
				'fecha_modificacion'=>$fecha_modificacion,
				'id_usuario_modifica'=>$id_usuario_modifica
			);
			$this->promocion_model->actualizar_estado_programacion($formuInfo);
			/*echo "actualizar_estado_programacion<pre>";
			print_r($formuInfo);
			echo "</pre>";*/

			$formuInfo = array(
				'id_programacion_visita'=>$id_programacion_visita,
				'fecha_promocion'=>$fecha_promocion,
				'hora_inicio'=>$hora_inicio,
				'hora_final'=>$hora_final,
				'nombre_recibio'=>$nombre_recibio,
				'observaciones'=>$observaciones,
				'id_estado_verificacion'=>$id_estado_verificacion,
				'fecha_creacion'=>$fecha_creacion,
				'id_usuario_crea'=>$id_usuario_crea
			);
			$id_promocion=$this->verificacion_model->guardar_ingreso_promocion($formuInfo);
			/*echo "guardar_ingreso_promocion<pre>";
			print_r($formuInfo);
			echo "</pre>";*/
			
			/*echo "guardar_ingreso_tematica";*/
			for($i=0;$i<count($id_tematica);$i++) {
				$fec=str_replace("/","-",$fecha_capacitacion[$i]);
				$fecha_capacitacion[$i]=date("Y-m-d", strtotime($fec));
				$formuInfo = array(
					'id_programacion_visita'=>$id_programacion_visita,
					'id_tematica'=>$id_tematica[$i],
					'fecha_capacitacion'=>$fecha_capacitacion[$i],
					'facilitador'=>$facilitador[$i]
				);
				$this->verificacion_model->guardar_ingreso_tematica($formuInfo);
				/*echo "<pre>";
				print_r($formuInfo);
				echo "</pre>";*/
			}

			/*echo "guardar_ingreso_miembros_entrevistados";*/
			for($i=0;$i<count($id_empleado_institucion);$i++) {
				$formuInfo = array(
					'id_promocion'=>$id_promocion,
					'id_empleado_institucion'=>$id_empleado_institucion[$i]
				);
				$this->verificacion_model->guardar_ingreso_miembros_entrevistados($formuInfo);
				/*echo "<pre>";
				print_r($formuInfo);
				echo "</pre>";*/
			}

			$formuInfo = array(
				'id_lugar_trabajo'=>$id_lugar_trabajo,
				'estado'=>3,
				'fecha_modificacion'=>$fecha_modificacion,
				'id_usuario_modifica'=>$id_usuario_modifica
			);
			$this->verificacion_model->guardar_verificacion_comite($formuInfo);
			
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
			ir_a("index.php/verificacion/ingreso/1/".$tr);
		}
		else {
			pantalla_error();
		}
	}

	function verificaciones()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_verificaciones); 
		if($data['id_permiso']==3 || $data['id_permiso']==4) {
			
			$data['tipo_lugar_trabajo']=$this->promocion_model->mostrar_tipo_lugar_trabajo();
			$data['municipio']=$this->promocion_model->mostrar_municipio();
			pantalla('verificacion/verificaciones',$data,Dreportes_verificaciones);
		}
		else {
			pantalla_error();
		}
	}
	
	function resultados($fecha_iniciale=NULL,$fecha_finale=NULL,$reportee=NULL,$exportacione=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dreportes_verificaciones); 
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
					$data['info']=$this->verificacion_model->resultados_instituciones($fecha_inicial,$fecha_final,$id_departamento);
					$data['nombre']="Instituciones ".date('d-m-Y hisa');
					if($data['exportacion']!=2) {
						$this->load->view('verificacion/resultados_instituciones',$data);
					}
					else {						
						$this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
						$stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
						$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
						$this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
						
						$html = $this->load->view('verificacion/resultados_instituciones.php', $data, true);
						$data_cab['titulo']="VERIFICACIONES REALIZADAS POR LUGAR DE TRABAJO";
						$this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
						$this->mpdf->WriteHTML($html,2);
						$this->mpdf->Output(); /*Salida del pdf*/
					}
					break;
				case 2:
					$data['info']=$this->verificacion_model->resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento);
					$data['nombre']="Técnicos ".date('d-m-Y hisa');
					if($data['exportacion']!=2)
						$this->load->view('verificacion/resultados_tecnicos',$data);
					else {
						$this->mpdf->mPDF('utf-8','letter-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
						$stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
						$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
						//$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
						$this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
						
						$html = $this->load->view('verificacion/resultados_tecnicos.php', $data, true);
						$data_cab['titulo']="VERIFICACIONES REALIZADAS POR TÉCNICO EDUCADOR";
						$this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
						$this->mpdf->WriteHTML($html,2);
						$this->mpdf->Output(); /*Salida del pdf*/
					}
					break;
				case 3:
					$data['info']=$this->verificacion_model->resultados_otros($fecha_inicial,$fecha_final,$id_departamento);
					$data['nombre']="Sectores ".date('d-m-Y hisa');
					if($data['exportacion']!=2)
						$this->load->view('verificacion/resultados_otros',$data);
					else {
						$this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
						$stylesheet = file_get_contents('css/pdf/acreditacion.css'); /*Selecionamos la hoja de estilo del pdf*/
						$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
						//$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
						$this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
						
						$html = $this->load->view('verificacion/resultados_otros.php', $data, true);
						$data_cab['titulo']="VERIFICACIONES POR SECTOR ECONÓMICO";
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