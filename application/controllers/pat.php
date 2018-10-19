<?php
class Pat extends CI_Controller
{
    /* Incluir(TRUE)/No incluir(FALSE) los lugares de trabajo que ya tienen una visita programada en la lista de lugares de trabajo que se pueden asignar*/
    public $mostrar_todos="FALSE"; 
    
    function Pat()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->model('seguridad_model');
        $this->load->model('promocion_model');
        $this->load->model('pat_model');
		$this->load->model('pei_model');
        date_default_timezone_set('America/El_Salvador');
        
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }
    
    function index()
    {
        ir_a("index.php/pat/configuracion");
    }	
	    
    /*
    *   Nombre: configuracion
    *   Objetivo: Formulario de configuración inicial del PAT
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/06/2015
    *   Observaciones: Ninguna.
    */
    function configuracion()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dconfiguracion); 
        if($data['id_permiso']==3) {
            $data['documentos']=$this->pei_model->buscar_documentos();			
            pantalla('pat/configuracion',$data,Dconfiguracion);
        }
        else {
            echo "Sin acceso concedido";
        }
    }
	
	/*
    *   Nombre: mostrar_niveles_recargado
    *   Objetivo: Actualiza el campo tipo SELECT que contiene los niveles del PEI seleccionado
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/06/2015
    *   Observaciones: Ninguna.
    */
    function mostrar_niveles_recargado($id_documento=0)
    {
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dconfiguracion); 
        if($data['id_permiso']==3) {			
			$this->db->trans_start();

            $data['estructura']=$this->pei_model->buscar_nivel($id_documento, 1);			
			$data['estructura2']=$this->pei_model->buscar_nivel($id_documento, 2);
			
			$items='<option value=""></option>';
			foreach ($data['estructura'] as $val) {
				$items.='<option value="'.$val['id_nivel'].'">'.$val['nombre_nivel'].'</option>';
			}

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'id_padre'=>$items,
                'valores'=>$data['estructura2']
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }      
    }

    /*
    *   Nombre: guardar_nivel
    *   Objetivo: Guarda formulario de configuración inicial del PAT
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/06/2015
    *   Observaciones: Ninguna.
    */
    function guardar_nivel()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dconfiguracion);
        if($data['id_permiso']==3){

			$this->db->trans_start();

			$id_nivel=$this->input->post('id_nivel');
			$id_documento=$this->input->post('id_documento');
			$nombre_nivel=$this->input->post('nombre_nivel');
			$abreviacion=$this->input->post('abreviacion');
			$id_padre=$this->input->post('id_padre');

			$formuInfo = array(
				'id_nivel'=>$id_nivel,
				'id_documento'=>$id_documento,
				'tipo_nivel'=>2,
				'nivel'=>1,
				'nombre_nivel'=>$nombre_nivel,
				'indicador'=>0,
				'abreviacion'=>$abreviacion,
				'id_padre'=>$id_padre
			);
			
			if($id_nivel=="") {
				$idi=$this->pei_model->guardar_nivel($formuInfo);
                $aa=" creó nivel con el id ".$idi;
                $id_accion=3;
            }
			else {
				$this->pei_model->actualizar_nivel($formuInfo);
                $aa=" actualizó nivel con el id ".$id_nivel;
                $id_accion=4;
            }

            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 

			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;            
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }
	    
    /*
    *   Nombre: cpat
    *   Objetivo: Formulario para el control de actividades del PAT
    *   Hecha por: Leonel Peña
    *   Modificada por: Leonel Peña
    *   Última Modificación: 14/06/2015
    *   Observaciones: Ninguna.
    */
    function cpat()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'), Dcontrol_pat); //Se verifica el permiso del usuario logueado
        if($data['id_permiso']!="") { //Si el valor es vacío no tiene ningún tipo de permiso
            $data['documentos']=$this->pei_model->buscar_documentos(); //Se obtienen todos los registros de PEI guardados previamente
            pantalla('pat/cpat',$data,Dcontrol_pat); //Se muestra la vista
        }
        else {
            pantalla_error(); //Pantalla que muestra que el usuario no tiene permiso para acceder a esta función
        }
    }


    function mostrar_items_padre_pat($id_documento, $anio='NULL')
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();

            if($anio=='NULL') {
                //$anio="DATE_FORMAT(CURDATE(),'%Y')";
                $anio=2017;
                // agregue $anio++; Robertohqz 0112116 1057
            }
			
			if($data['id_permiso']==3) {  
            	$data['items']=$this->pat_model->buscar_items_padre_pat($id_documento,'NULL',$anio);   
			}
			else {
				$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr')); 				
				$data['items']=$this->pat_model->buscar_items_padre_pat($id_documento,$id_seccion['id_seccion'],$anio);  
			}
            
            $items='<option value=""></option>';
            foreach ($data['items'] as $val) {
                $items.='<option value="'.$val['id_item'].'" data-v="'.trim($val['descripcion_item']).'">'.trim($val['correlativo_item']).'</option>';
            }

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'id_padre'=>$items,
                'nombre_nivel_p'=>$data['items'][0]['nombre_nivel_p'],
                'nombre_nivel'=>$data['items'][0]['nombre_nivel'],
                'id_nivel_a'=>$data['items'][0]['id_nivel_a']
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        } 
    }
	
	function guardar_actividad()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
			
			$id_item=$this->input->post('id_item');
			$id_nivel=$this->input->post('id_nivel');
			$id_seccion="NULL";
			$correlativo_item="";
			$descripcion_item=$this->input->post('descripcion_item');
			$id_padre=$this->input->post('id_padre');
			
			$id_actividad=$this->input->post('id_actividad');
			$unidad_medida=$this->input->post('unidad_medida');
			$recursos_actividad=$this->input->post('recursos_actividad');
			$observaciones_actividad=$this->input->post('observaciones_actividad');
            #$anio_meta=($this->input->post('anio_meta')=="")?"DATE_FORMAT(CURDATE(),'%Y')":$this->input->post('anio_meta');
			$anio_meta=($this->input->post('anio_meta')=="")?"DATE_FORMAT(CURDATE(),'2017')":$this->input->post('anio_meta');
            $meta_enero=($this->input->post('meta_enero')=="")?0:$this->input->post('meta_enero');
			$meta_febrero=($this->input->post('meta_febrero')=="")?0:$this->input->post('meta_febrero');
			$meta_marzo=($this->input->post('meta_marzo')=="")?0:$this->input->post('meta_marzo');
			$meta_abril=($this->input->post('meta_abril')=="")?0:$this->input->post('meta_abril');
			$meta_mayo=($this->input->post('meta_mayo')=="")?0:$this->input->post('meta_mayo');
			$meta_junio=($this->input->post('meta_junio')=="")?0:$this->input->post('meta_junio');
			$meta_julio=($this->input->post('meta_julio')=="")?0:$this->input->post('meta_julio');
			$meta_agosto=($this->input->post('meta_agosto')=="")?0:$this->input->post('meta_agosto');
			$meta_septiembre=($this->input->post('meta_septiembre')=="")?0:$this->input->post('meta_septiembre');
			$meta_octubre=($this->input->post('meta_octubre')=="")?0:$this->input->post('meta_octubre');
			$meta_noviembre=($this->input->post('meta_noviembre')=="")?0:$this->input->post('meta_noviembre');
			$meta_diciembre=($this->input->post('meta_diciembre')=="")?0:$this->input->post('meta_diciembre');
			$meta_actividad=$meta_enero+$meta_febrero+$meta_marzo+$meta_abril+$meta_mayo+$meta_junio+$meta_julio+$meta_agosto+$meta_septiembre+$meta_octubre+$meta_noviembre+$meta_diciembre;
			if($data['id_permiso']==3) {
                $id_seccion_crea=$this->input->post('unidad_lider');
                $ids=$id_seccion_crea;
            }
            else {
                $id_seccion_crea=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));	
                $ids=$id_seccion_crea['id_seccion'];		
            }
			
            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');
			
			$formuInfo = array(
				'id_item'=>$id_item,
				'id_nivel'=>$id_nivel,
				'id_seccion'=>$id_seccion,
				'correlativo_item'=>$correlativo_item,
				'descripcion_item'=>$descripcion_item,
				'id_padre'=>$id_padre,
				'fecha_creacion'=>$fecha,
				'id_usuario_crea'=>$id_usuario,
				'fecha_modificacion'=>$fecha,
				'id_usuario_modifica'=>$id_usuario
			);
			if($id_item=="") {
				$id_itemNew=$this->pei_model->guardar_wizard($formuInfo);
				$id_estado=1;
				$observacion_estado_actividad="";
                $aa=" creó item con el id ".$id_itemNew;
                $id_accion=3;
			}
			else {
				$this->pat_model->actualizar_wizard($formuInfo);
				$id_itemNew=$id_item;
				$id_estado=5;
				$observacion_estado_actividad="";
                $aa=" actualizó item con el id ".$id_itemNew;
                $id_accion=4;
			}

            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
			
			$formuInfo = array(
				'id_actividad'=>$id_actividad,
				'id_item'=>$id_itemNew,
				'meta_actividad'=>$meta_actividad,
				'unidad_medida'=>$unidad_medida,
				'meta_enero'=>$meta_enero,
                'anio_meta'=>$anio_meta,
				'meta_febrero'=>$meta_febrero,
				'meta_marzo'=>$meta_marzo,
				'meta_abril'=>$meta_abril,
				'meta_mayo'=>$meta_mayo,
				'meta_junio'=>$meta_junio,
				'meta_julio'=>$meta_julio,
				'meta_agosto'=>$meta_agosto,
				'meta_septiembre'=>$meta_septiembre,
				'meta_octubre'=>$meta_octubre,
				'meta_noviembre'=>$meta_noviembre,
				'meta_diciembre'=>$meta_diciembre,
				'recursos_actividad'=>$recursos_actividad,
				'observaciones_actividad'=>$observaciones_actividad,
				'id_seccion'=>$ids,
				'fecha_creacion'=>$fecha,
				'id_usuario_crea'=>$id_usuario,
				'fecha_modificacion'=>$fecha,
				'id_usuario_modifica'=>$id_usuario
			);
			if($id_actividad=="") {
				$id_actividad=$this->pat_model->guardar_actividad($formuInfo);
                $aa=" creó actividad con el id ".$id_actividad;
                $id_accion=3;
			}
			else {
				$this->pat_model->actualizar_actividad($formuInfo);
                $aa=" actualizó actividad con el id ".$id_actividad;
                $id_accion=4;
			}
            
            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
			
			$formuInfo = array(
				'id_actividad'=>$id_actividad,
				'id_estado'=>$id_estado,
				'observacion_estado_actividad'=>$observacion_estado_actividad,
				'fecha_creacion'=>$fecha,
				'id_usuario_crea'=>$id_usuario
			);
			$this->pat_model->guardar_estado_actividad($formuInfo);

            if($data['id_permiso']==3 && ($id_estado==1 || $id_estado==5)) {
                $formuInfo = array(
                    'id_actividad'=>$id_actividad,
                    'id_estado'=>3,
                    'observacion_estado_actividad'=>'Se autorizó inmediatamente por crearse con usuario Administrador',
                    'fecha_creacion'=> date('Y-m-d H:i:s', (strtotime ("+1 second"))),
                    'id_usuario_crea'=>$id_usuario
                );
                $this->pat_model->guardar_estado_actividad($formuInfo);
            }
			
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        } 
	}
	
	function buscar_actividades($id_padre, $anio='NULL')
	{
		
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {
			$this->db->trans_start();

            if($anio=='NULL') {
                //$anio="DATE_FORMAT(CURDATE(),'%Y')";
                $anio=2017;
                #Robertohqz 011216 1109
            }
			
			if($data['id_permiso']==3) {
				$data['items']=$this->pat_model->buscar_items('NULL','NULL','NULL',$id_padre,'NULL',$anio);
			}
			else {
				$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr')); 
				$data['items']=$this->pat_model->buscar_items('NULL','NULL','NULL',$id_padre,$id_seccion['id_seccion'],$anio);
			}

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
			
			$json=' ';
			foreach ($data['items'] as $val) {
				$a='';
                if($data['id_permiso']==3) {
					$a.='<a title=\'Ver\' data-toggle=\'modal\' href=\'#modal\' onClick=\'ver('.$val['id_item'].');return false;\'  class=\'table-link view-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-search fa-stack-1x fa-inverse\'></i></span></a>';
                    //$a.='&nbsp;&nbsp;<a title=\'Ver\' data-toggle=\'modal\' href=\'#modal\' onClick=\'ver('.$val['id_item'].');return false;\' class=\'view-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-search\'></i></a>&nbsp;';
					$a.='<a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_item'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a>';
                    //$a.='&nbsp;&nbsp;<a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_item'].');return false;\' class=\'edit-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-pencil\'></i></a>';
                    //$a.='&nbsp;';
 					$a.='<a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar_('.$val['id_item'].');return false;\'  class=\'table-link delete-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a>';
                   	//$a.='&nbsp;&nbsp;<a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar_('.$val['id_item'].');return false;\' class=\'delete-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-trash-o\'></i></a>';
                }
                else {
                    $a.='<a title=\'Ver\' data-toggle=\'modal\' href=\'#modal\' onClick=\'ver('.$val['id_item'].');return false;\'  class=\'table-link view-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-search fa-stack-1x fa-inverse\'></i></span></a>';
                    //$a.='&nbsp;&nbsp;<a title=\'Ver\' data-toggle=\'modal\' href=\'#modal\' onClick=\'ver('.$val['id_item'].');return false;\' class=\'view-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-search\'></i></a>&nbsp;';
    				if($val['id_estado']!=2 && $val['id_estado']!=3) {
    					$a.='<a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_item'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a>';
                    	//$a.='&nbsp;&nbsp;<a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_item'].');return false;\' class=\'edit-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-pencil\'></i></a>';
    					if($val['id_estado']!=4) {
    						$a.='<a title=\'Enviar\' href=\'#\' onClick=\'enviar('.$val['id_actividad'].');return false;\'  class=\'table-link send-row\' data-id=\''.$val['id_actividad'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-send fa-stack-1x fa-inverse\'></i></span></a>';
                            //$a.='&nbsp;&nbsp;<a title=\'Enviar\' href=\'#\' onClick=\'enviar('.$val['id_actividad'].');return false;\' class=\'send-row\' data-id=\''.$val['id_actividad'].'\'><i class=\'fa fa-send\'></i></a>&nbsp;';
    				    }
                        else {
                             $a.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                    }
    				else  {
    					//$a.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title=\'Ver\' data-toggle=\'modal\' href=\'#modal\' onClick=\'ver('.$val['id_item'].');return false;\' class=\'view-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-search\'></i></a>&nbsp;';
    				}
    				if($val['id_estado']==3 && $val['id_estado']==4) {
    					//$a.='&nbsp;&nbsp;<a title=\'Observaciones\' data-toggle=\'modal\' href=\'#modal\' onClick=\'observaciones(\''.$val['observacion_estado_actividad'].'\');return false;\' class=\'view-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-edit \'></i></a>';
    				}
                    if($val['id_estado']!=2 && $val['id_estado']!=3) {
    				    $a.='<a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar_('.$val['id_item'].');return false;\'  class=\'table-link delete-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a>';
                   		//$a.='&nbsp;&nbsp;<a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar_('.$val['id_item'].');return false;\' class=\'delete-row\' data-id=\''.$val['id_item'].'\'><i class=\'fa fa-trash-o\'></i></a>';
    				}
                }
				switch($val['id_estado']){
					case 1:
						$e='primary';
						break;
					case 2:
						$e='info';
						break;
					case 3:
						$e='success';
						break;
					case 4:
						$e='danger';
						break;
					case 5:
						$e='warning';
						break;
					default:
						$e='default';
				}
				
				$est='<span class=\'label label-'.$e.'\'>'.$val['descripcion_estado'].'</span>';
				
                $json.='["'.$val['descripcion_item'].'","'.$val['meta'].'","'.$est.'","'.$a.'"],';
			}
			$json='{ "data": ['.substr($json,0,-1).'] }';
			echo $json;
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}

    function buscar_actividades_unidad($id_padre)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
            
            $data['items']=$this->pat_model->buscar_seccion_actividades($id_padre);
            
            $items='<option value=""></option>';
            foreach ($data['items'] as $val) {
                $items.='<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
            }

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'unidad_lider'=>$items
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }
	
	function buscar_actividad($id_item,$presentacion=1)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat);
        if($data['id_permiso']!=""){
            $this->db->trans_start();

            $data['items']=$this->pat_model->buscar_items('NULL','NULL',$id_item);
			
			if($presentacion==1) {
				$this->db->trans_complete();
				$tr=($this->db->trans_status()===FALSE)?0:1;
				$json =array(
					'resultado'=>$tr,
					'valores'=>$data['items']
				);
				echo json_encode($json);
			}
			else {
                $data['jeraquia_nivel']=$this->pat_model->buscar_jeraquia_nivel($id_item);
                $data['historial_estado_actividad']=$this->pat_model->historial_estado_actividad($data['items'][0]['id_actividad']);
				$this->load->view('pat/ver_actividad',$data);
			}
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}
	
	function eliminar_actividad($id_item)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat);
        if($data['id_permiso']!=""){
            $this->db->trans_start();

            $formuInfo = array(
				'id_item'=>$id_item
			);
			$this->pat_model->eliminar_wizard($formuInfo);

            $aa=" eliminó actividad con el id ".$id_item;
            $id_accion=5;
            
            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}
	
	function enviar_actividad($id_actividad)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat);
        if($data['id_permiso']!=""){
            $this->db->trans_start();

            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');
			
            $formuInfo = array(
				'id_actividad'=>$id_actividad,
				'id_estado'=>2,
				'observacion_estado_actividad'=>'',
				'fecha_creacion'=>$fecha,
				'id_usuario_crea'=>$id_usuario
			);
			$this->pat_model->guardar_estado_actividad($formuInfo);

            $aa=" envió a revisión actividad con el id ".$id_actividad;
            $id_accion=4;
            
            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}

    function validacion()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dvalidacion);
        if($data['id_permiso']!=""){
            $data['documentos']=$this->pei_model->buscar_documentos();
            pantalla('pat/validacion',$data,Dcontrol_pat);
        }
        else {
            echo "Sin acceso concedido";
        }
    }

    function consulta_pat()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat);
        if($data['id_permiso']!=""){
            $data['documentos']=$this->pei_model->buscar_documentos();
            $data['id_seccion_consulta']=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));              

            pantalla('pat/consulta_pat',$data,Dcontrol_pat);
        }
        else {
            echo "Sin acceso concedido";
        }
    }

    function buscar_unidad_documento($id_documento)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dvalidacion); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
            
            $data['items']=$this->pat_model->buscar_seccion_documento($id_documento); 
            
            $items='<option value=""></option>';
            foreach ($data['items'] as $val) {
                $items.='<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
            }

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'unidad_lider'=>$items
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

    function buscar_nivel_item_actividad_consulta($id_documento, $id_seccion, $anio='NULL')
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="" ) {            
            $this->db->trans_start();

            if($anio=='NULL') {
                #$anio="DATE_FORMAT(CURDATE(),'%Y')";
                $anio=2017;
                #Robertohqz 011216 1110
            }
            
            $data['items']=$this->pat_model->buscar_nivel_item_actividad_consulta($id_documento, $id_seccion, $anio); 

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'tabla'=>$data['items']
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

    function buscar_nivel_item_actividad($id_documento, $id_seccion, $anio='NULL')
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dvalidacion); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();

            if($anio=='NULL') {
                #$anio="DATE_FORMAT(CURDATE(),'%Y')";
                $anio=2017;
                #Robertohqz 011216 1110
            }
            
            $data['items']=$this->pat_model->buscar_nivel_item_actividad($id_documento, $id_seccion, $anio); 

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'tabla'=>$data['items']
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

    function actualizar_pat()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dvalidacion); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
            
            $id_actividad=$this->input->post('id_actividad');
            $id_estadoa=$this->input->post('estadoa');
            $id_estado=$this->input->post('estado');
            $observacion=$this->input->post('observacion');

            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');
            
            for($i=0;$i<count($id_actividad);$i++) {
                if($id_estado[$i]!=$id_estadoa[$i] && $id_estado[$i]!="") {
                    $formuInfo = array(
                        'id_actividad'=>$id_actividad[$i],
                        'id_estado'=>$id_estado[$i],
                        'observacion_estado_actividad'=>$observacion[$i],
                        'fecha_creacion'=>$fecha,
                        'id_usuario_crea'=>$id_usuario
                    );
                    $this->pat_model->guardar_estado_actividad($formuInfo);

                    if($id_estado[$i]==3) {
                        $aa=" aprobó actividad con el id ".$id_actividad;
                    } 
                    else {
                        $aa=" rechazó actividad con el id ".$id_actividad;
                    }

                    $id_accion=4;
                    
                    $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
                    $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
                }
            }

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
	/*
    *   Nombre: buscar_documento
    *   Objetivo: Recarga por ajax formulario de configuración inicial del PEI para editarlo
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function buscar_documento($id_documento=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento);
        if($data['id_permiso']==3){
            $this->db->trans_start();

            $data['documentos']=$this->pei_model->buscar_documentos($id_documento);

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'valores'=>$data['documentos']

            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

	/*
    *   Nombre: eliminar_documento
    *   Objetivo: elimina registro de configuración inicial del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function eliminar_documento($id_documento=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento);
        if($data['id_permiso']==3){
            $this->db->trans_start();

            $this->pei_model->eliminar_documento($id_documento);

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr

            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

	/*
    *   Nombre: documento_recargado
    *   Objetivo: Recarga por ajax tabla que contiene todos los registros de configuración inicial del PEI para editarlos o eliminarlos
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function documento_recargado()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento); 
        if($data['id_permiso']==3) {
            $data['documentos']=$this->pei_model->buscar_documentos();
            $this->load->view('pei/documento_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
	
	/*
    *   Nombre: documento_recargado
    *   Objetivo: Recarga por ajax la estructura de un registro de configuración inicial del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function estructura_recargado($id_documento='NULL')
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento); 
        if($data['id_permiso']==3) {
            $data['estructura']=$this->pei_model->buscar_nivel($id_documento, 1);
            $this->load->view('pei/estructura_recargado',$data);
        }
        else {
            pantalla_error();
        }
    }
    
	/*
    *   Nombre: objetivos
    *   Objetivo: Muestra todos los registros de PEI existentes para agregar, actualizar o eliminar valores de su estructura
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function objetivos($accion_transaccion=NULL, $estado_transaccion=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $data['documentos']=$this->pei_model->buscar_documentos();
            pantalla('pei/objetivos',$data,Dobjetivos);
        }
        else {
            echo "Sin acceso concedido";
        }
    }
	
	/*
    *   Nombre: wizard_pei
    *   Objetivo: Formulario tipo wizard que permite agregar, actualizar o eliminar valores de su estructura
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
	function wizard_pei($id_documento=0)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $data['estructura']=$this->pei_model->buscar_nivel($id_documento, 1);
            $data['items']=$this->pei_model->buscar_items($id_documento);
			$data['seccion']=$this->pei_model->buscar_seccion();
            $this->load->view('pei/wizard_pei',$data);
        }
        else {
            echo "Sin acceso concedido";
        }
	}

	/*
    *   Nombre: guardar_wizard
    *   Objetivo: Guarda formulario tipo wizard
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function guardar_wizard()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();
            
            $id_itemNew=0;
            $id_nivel=$this->input->post('id_nivel'); 
            $id_item=$this->input->post('id_item'.$id_nivel);   
            $id_seccion=$this->input->post('id_seccion'.$id_nivel); 
            $agrupar_numeracion=$this->input->post('agrupar_numeracion_'.$id_nivel);  
            $agregar_separador=$this->input->post('agregar_separador_'.$id_nivel);       
            $registro=$this->input->post('registro'.$id_nivel);
            $correlativo_item=$this->input->post('correlativo_item'.$id_nivel);
            $id_padre=$this->input->post('id_padre'.$id_nivel);
            $descripcion=$this->input->post('descripcion'.$id_nivel);

            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');

            for($i=0;$i<count($registro);$i++) {
                 $formuInfo = array(
                    'id_item'=>$id_item[$i],
                    'id_nivel'=>$id_nivel,
                    'id_seccion'=>$id_seccion[$i],
                    'correlativo_item'=>$correlativo_item[$i],
                    'descripcion_item'=>$descripcion[$i],
                    'id_padre'=>$id_padre[$i],
                    'fecha_creacion'=>$fecha,
                    'id_usuario_crea'=>$id_usuario,
                    'fecha_modificacion'=>$fecha,
                    'id_usuario_modifica'=>$id_usuario
                );
				if($registro[$i]=="del")
					$this->pei_model->eliminar_wizard($formuInfo);
                if($registro[$i]=="new")
                    $id_itemNew=$this->pei_model->guardar_wizard($formuInfo);
				if($registro[$i]=="update")
					$this->pei_model->actualizar_wizard($formuInfo);
            }
			$formuInfo = array(
				'id_nivel'=>$id_nivel,
				'agrupar_numeracion'=>$agrupar_numeracion,
				'agregar_separador'=>$agregar_separador
			);
			$this->pei_model->actualizar_nivel2($formuInfo);

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'id_item'=>$id_itemNew,
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
    }

	/*
    *   Nombre: wizard_recargado
    *   Objetivo: Actualiza el campo tipo SELECT de la siguiente pestaña del wizard con los valores que se actualizaron de la pestaña anterior
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function wizard_recargado($id_nivel=0)
    {
        $data['items']=$this->pei_model->buscar_items('NULL', $id_nivel);
        echo '<option value=""></option>';
        foreach ($data['items'] as $val) {
            echo '<option value="'.$val['id_item'].'">'.$val['correlativo_item'].'</option>';
        }
    }

	/*
    *   Nombre: wizard_recargado2
    *   Objetivo: Actualiza la tabla de los registros gardados de un nivel
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function wizard_recargado2($id_nivel=0)
    {
        $data['items']=$this->pei_model->buscar_items('NULL', $id_nivel);

        foreach($data['items'] as $val2) {
            if($val2['id_padre']=="")
                $val2['id_padre']="NULL";
            echo '  <tr>';
            echo '  <td><span class="cv">'.$val2['correlativo_item'].'</span></td>
                    <td>
                        <input type="hidden" name="id_item'.$val2['id_nivel'].'[]" class="ite" value="'.$val2['id_item'].'"/>
                        <input type="hidden" name="registro'.$val2['id_nivel'].'[]" class="reg" value=""/>
                        <input type="hidden" name="correlativo_item'.$val2['id_nivel'].'[]" class="cor" value="'.$val2['correlativo_item'].'"/>
                        <input type="hidden" name="id_padre'.$val2['id_nivel'].'[]" class="pad" value="'.$val2['id_padre'].'"/>
                        <input type="hidden" name="descripcion'.$val2['id_nivel'].'[]" class="des" value="'.$val2['descripcion_item'].'"/>
                        <span class="dv">'.$val2['descripcion_item'].'</span></td>
                    <td>
                        <a href="#" class="edit_row" onClick="edit_row_'.$val2['id_nivel'].'(this);return false;"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                        <!--<a class="delete_row" href="#" onClick="delete_row_'.$val2['id_nivel'].'(this);return false;"><i class="fa fa-trash-o"></i></a>-->
                        <a class="delete_row" href="#" onClick="delete_row_'.$val2['id_nivel'].'(this);return false;">&nbsp;</a>
                        <a data-toggle="modal" href="#modal" onClick="eliminar_item_'.$val2['id_nivel'].'(this);return false;"><i class="fa fa-trash-o"></i></a>
                    </td>';
            echo '  </tr>';
        }
    }

	/*
    *   Nombre: presupuesto
    *   Objetivo: Formulario que registra un presupuesto de un registro de la estructura del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function presupuesto($id_item=0)
    {
		if($id_item=="" || $id_item==NULL)
			$id_item=0;			
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $data['id_item']=$this->pei_model->buscar_items("NULL","NULL",$id_item);
			$data['unidades_apoyo']=$this->pei_model->buscar_unidades_apoyo($id_item);
			$data['seccion']=$this->pei_model->buscar_seccion();
			$data['id_presupuesto']=$this->pei_model->buscar_presupuesto($id_item);
			if($data['id_item'][0]['id_nivel']=="" || $data['id_item'][0]['id_nivel']==NULL)
				$data['id_item'][0]['id_nivel']=0;	
            $data['estructura']=$this->pei_model->buscar_nivel("NULL", 1, $data['id_item'][0]['id_nivel']);
			if($data['estructura'][0]['id_documento']=="" || $data['estructura'][0]['id_documento']==NULL)
				$data['estructura'][0]['id_documento']=0;
            $data['documento']=$this->pei_model->buscar_documentos($data['estructura'][0]['id_documento']);
            $this->load->view('pei/presupuesto',$data);
        }
        else {
            echo "Sin acceso concedido";
        }
    }

	/*
    *   Nombre: unidades
    *   Objetivo: Impresion JSON de las unidades existentes en la tabla org_seccion
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Actualmente no se está utilizando.
    */	
	function unidades()
	{
		$data=$this->pei_model->buscar_seccion();
		$info='[';
		$i=0;
		foreach ($data as $val) {
			if($i==1)
				$info.=',';
            $info.='"'.$val['nombre_seccion'].'"';
			$i=1;
        }
		$info.=']';
		echo $info;
	}

	/*
    *   Nombre: guardar_presupuesto
    *   Objetivo: Guarda formulario que registra un presupuesto de un registro de la estructura del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */		
	function guardar_presupuesto()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();
			
			$id_presupuesto=$this->input->post('id_presupuesto');
			$id_item=$this->input->post('id_item');
			$clasificacion_gasto=$this->input->post('clasificacion_gasto');
			$unidad_lider=$this->input->post('unidad_lider');
			$unidad_apoyo=$this->input->post('unidad_apoyo');
			$presupuesto=$this->input->post('presupuesto');
			$anio=$this->input->post('anio');

            #$fecha=date('Y-m-d H:i:s');
            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');	
			
			for($i=0;$i<count($presupuesto);$i++) {
				if($presupuesto[$i]=="")$presupuesto[$i]=0;
              	$formuInfo = array(
                    'id_presupuesto'=>$id_presupuesto[$i],
                    'id_item'=>$id_item,
                    'clasificacion_gasto'=>$clasificacion_gasto,
                    'presupuesto'=>$presupuesto[$i],
                    'anio'=>$anio[$i],
                    'fecha_creacion'=>$fecha,
                    'id_usuario_crea'=>$id_usuario,
                    'fecha_modificacion'=>$fecha,
                    'id_usuario_modifica'=>$id_usuario
                );
				if($presupuesto[$i]!="" && $presupuesto[$i]!=0) {
					if($id_presupuesto[$i]=="")
						$this->pei_model->guardar_presupuesto($formuInfo);
					else
						$this->pei_model->actualizar_presupuesto($formuInfo);
				}
				else
					if($id_presupuesto[$i]!="")
						$this->pei_model->eliminar_presupuesto($formuInfo);
					
			}
			
			$this->pei_model->eliminar_item_seccion($id_item);
			for($i=0;$i<count($unidad_lider);$i++) {
              	$formuInfo = array(
                    'id_item'=>$id_item,
                    'id_seccion'=>$unidad_lider[$i],
                    'id_tipo_apoyo'=>1
                );
				if($unidad_lider[$i]!="" && $unidad_lider[$i]!=NULL)
					$this->pei_model->guardar_item_seccion($formuInfo);
					
			}
			
			for($i=0;$i<count($unidad_apoyo);$i++) {
              	$formuInfo = array(
                    'id_item'=>$id_item,
                    'id_seccion'=>$unidad_apoyo[$i],
                    'id_tipo_apoyo'=>2
                );
				if($unidad_apoyo[$i]!="" && $unidad_apoyo[$i]!=NULL)
					$this->pei_model->guardar_item_seccion($formuInfo);
					
			}

        	$this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr
            );
            echo json_encode($json);
        }
        else {
            $json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}
	
	/*
    *   Nombre: imprimir_variable
    *   Objetivo: Imprime el contenido de una variable de manera tabulada
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Sólo sirve para el desarrollador.
    */	
    function imprimir_variable($variable)
    {
        echo "<pre>";
        print_r($variable);
        echo "</pre>";
    }
}
?>
