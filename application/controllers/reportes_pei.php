<?php
# UFG Jairo - Se cambia nombre de clase
class Reportes_pei extends CI_Controller
{
    /* Incluir(TRUE)/No incluir(FALSE) los lugares de trabajo que ya tienen una visita programada en la lista de lugares de trabajo que se pueden asignar*/
    public $mostrar_todos="FALSE"; 

    
    #UFG Jairo - Se cambia nombre de constructor
    function Reportes_pei()
    {

        parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->model('seguridad_model');
        $this->load->model('promocion_model');
        $this->load->model('reportes_model');
        $this->load->model('monitoreo_model');
        $this->load->model('pat_model');
		$this->load->model('pei_model');
        date_default_timezone_set('America/El_Salvador');
        
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }


  function index()
    {
        ir_a("index.php/reportes_pei/avance_pei"); # Se moidifica URL
    }	


    /*
    *   Nombre: configuracion
    *   Objetivo: Formulario de avance de PEI
    *   Hecha por: Leonel (Base reportes PAT)
    *   Modificada por: Jairo (aceptado para reportes PEI)
    *   Última Modificación: 
    *   Observaciones: Ninguna.
    */


    function avance_pei()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Davance); 
        if($data['id_permiso']!="") {
            $data['documentos']=$this->pat_model->buscar_documentos();			
            pantalla('reportes_pei/avance',$data,Davance);
        }
        else {
            echo "Sin acceso concedido";
        }
    }



    function buscar_unidad_documento($id_documento)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Davance); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
            
            $data['items']=$this->pat_model->buscar_seccion_documento($id_documento); 
            $data['documentos']=$this->pei_model->buscar_documentos($id_documento);
            
            $items='<option value=""></option>';
            foreach ($data['items'] as $val) {
                $items.='<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
            }
			
			$items2='<option value=""></option>';
            for($i=1;$i<=($data['documentos'][0]['fin_periodo']-$data['documentos'][0]['inicio_periodo']);$i++) {
				if(($data['documentos'][0]['inicio_periodo']+$i)<=date('Y')+1)
                	$items2.='<option value="'.($data['documentos'][0]['inicio_periodo']+$i).'">'.($data['documentos'][0]['inicio_periodo']+$i).'</option>';
            }

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'unidad_lider'=>$items,
                'anios'=>$items2
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
	

    function periodo_pei($anio=NULL,$iddocumento=NULL)
{
	 $this->db->trans_start();
	$data["periodo"] = $this->pat_model->pat_periodo($anio,$iddocumento);
	$anio='<option value=""></option>';
	for($c=$data["periodo"]["inicio_periodo"] + 1; $c<=$data["periodo"]["fin_periodo"];$c++)
	{
		$anio .= '<option value="'.$c.'">'.$c.'</option>';
	}
	$this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'anio'=>$anio
                
            );
            echo json_encode($json);

}



	function crear_reporte_pei() //Se ha agregado parametro de padre
	{
		$id_padre = 90;

		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Davance); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
			

			//Se toma ID de pei actual
			$id_documento=$this->input->post('id_documento');
			
			

			if($data['id_permiso']==3) { 
			//se toma unidad seleccionada  
				$id_seccion=$this->input->post('unidad_lider');
			}
			else {

				//Se define seccion para el usuario
				$seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr'));
				//Se guarda en id_seccion
				$id_seccion=$seccion['id_seccion'];
			}
			
			//Seteamos el año
			$anio=$this->input->post('anio');
			
			//Seteamos el intervalo
			$intervalo=$this->input->post('radio');
			//Seteamos el mes ingresado
			$periodo=$this->input->post('mes');

			//Seteamos que tipo de reporte eligió

			$exportacion=$this->input->post('radio2');

			switch($periodo) {
				case 1:
					$p="Monitoreo Enero";
					break;
				case 2:
					$p="Monitoreo Febrero";
					break;
				case 3:
					$p="Monitoreo Marzo";
					break;
				case 4:
					$p="Monitoreo Abril";
					break;
				case 5:
					$p="Monitoreo Mayo";
					break;
				case 6:
					$p="Monitoreo Junio";
					break;
				case 7:
					$p="Monitoreo Julio";
					break;
				case 8:
					$p="Monitoreo Agosto";
					break;
				case 9:
					$p="Monitoreo Septiembre";
					break;
				case 10:
					$p="Monitoreo Octubre";
					break;
				case 11:
					$p="Monitoreo Noviembre";
					break;
				case 12:
					$p="Monitoreo Diciembre";
					break;
				case 13:
					$p="Evaluación 1er Trimestre";
					break;
				case 14:
					$p="Evaluación 2do Trimestre";
					break;
				case 15:
					$p="Evaluación 3er Trimestre";
					break;
				case 16:
					$p="Evaluación 4to Trimestre";
					break;
				default:
					$p="Evaluación Anual";
			}


			$seccion=$this->pei_model->buscar_seccion($id_seccion);
			
			$tabla=$this->reportes_model->get_actions($id_padre);


			//$tabla=$this->reportes_model->buscar_nivel_item_actividad($id_documento, $id_seccion, $data['id_permiso'], $periodo, $anio); 
			if($exportacion==1) {
				$this->db->trans_complete();
				$tr=($this->db->trans_status()===FALSE)?0:1;
				$json =array(
					'resultado'=>$tr,
					'tabla'=>$tabla
				);
            echo json_encode($json);
			}
			if($exportacion==2) {
				$this->mpdf->mPDF('utf-8','letter'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/

				$stylesheet = file_get_contents('css/pdf/informe.css'); /*Selecionamos la hoja de estilo del pdf*/


				$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/



				$this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
				
				//$html = $this->load->view('promocion/resultados_instituciones.php', $data, true);
				$html=$tabla;
				$data_cab['titulo']=$seccion[0]['nombre_seccion'].' - PAT'.$anio;
				$data_cab['periodo']=$p;
				$this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
				$this->mpdf->WriteHTML($html,2);
				$this->mpdf->Output(); /*Salida del pdf*/	
			}
			if($exportacion==3) {
				$data_cab['titulo']=$seccion[0]['nombre_seccion'].' - PAT'.$anio;
				$data_cab['periodo']=$p;
				$data_cab['tabla']=$tabla;
				$data_cab['exportacion']=3;
				$this->load->view('cabecera_pdf.php', $data_cab);
			}
        }
        else {
           	$json =array(
                'resultado'=>0
            );
            echo json_encode($json);
        }
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#UFG

function generar_reporte_logros($anio,$mes=null,$id_seccion)
{
    $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Davance); 
    if($data['id_permiso']!="") {            
        $this->db->trans_start();
        
        //Se toma ID de pei actual

        $data['items']=$this->reportes_model->avance_pei_logros($anio, (($mes == 'null') ? 'NULL', $mes), $id_seccion); 
        $this->db->trans_complete();
        $tr=($this->db->trans_status()===FALSE)?0:1;;
        $meta = $data['items']['meta'];
        $realizado = $data['items']['realizado'];
        $nombre_mes = null;
        switch($mes)
        {
            case 1:
            $nombre_mes = 'Enero';
            break;
            case 2:
            $nombre_mes = 'Febrero';
            break;
            case 3:
            $nombre_mes = 'Marzo';
            break;
            case 4:
            $nombre_mes = 'Abril';
            break;
            case 5:
            $nombre_mes = 'Mayo';
            break;
            case 6:
            $nombre_mes = 'Junio';
            break;
            case 7:
            $nombre_mes = 'Julio';
            break;
            case 8:
            $nombre_mes = 'Agosto';
            break;
            case 9:
            $nombre_mes = 'Septiembre';
            break;
            case 10:
            $nombre_mes = 'Octubre';
            break;
            case 11:
            $nombre_mes = 'Noviembre';
            break;
            case 12:
            $nombre_mes = 'Diciembre';
            break;
            case 13:
            $nombre_mes = '1er Trimestre';
            break;
            case 14:
            $nombre_mes = '2do Trimestre';
            break;
            case 15:
            $nombre_mes = '3er Trimestre';
            break;
            case 16:
            $nombre_mes = '4to Trimestre';
            break;
        }

        $porcentaje=$realizado * 100;
        if(!($meta == 0))
        $porcentaje = ($realizado / $meta) * 100;

        $json =array(
            'resultado'=>$tr,
            'titulo'=> 'Resultados de logros sección '.$data['items']['seccion'].', '.(($nombre_mes != null )?'/':'').$anio,
            'meta'=>$meta,
            'realizado'=>$realizado,
            //'porcentaje' => $porcentaje
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function buscar_nivel_item_actividad($id_documento, $id_seccion, $mes='NULL', $anio='NULL')
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcumplimiento); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();

            if($mes=='NULL') {
                $mes=date('m', (strtotime ("-15 day")));//Cambio de dias habiles
            }

            if($anio=='NULL') {
                $anio=date('Y', (strtotime ("-15 day"))); //Cambio de dias habiles
            }

            $data['items']=$this->monitoreo_model->buscar_nivel_item_actividad($id_documento, $id_seccion, $data['id_permiso'], $mes, $anio); 

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
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcumplimiento); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
            
            $id_logro=$this->input->post('id_logro');
            $id_actividad=$this->input->post('id_actividad');
            $cantidad_logro=$this->input->post('logro');
            $observaciones_logro=$this->input->post('observaciones_logro');
            $cambio=$this->input->post('cambio');
            if($data['id_permiso']==3) {
                $mes_logro=$this->input->post('mes');
                $anio_logro=date('Y');
            }
            else {
                $mes_logro=date('m', (strtotime ("-10 day")));//Cambio de dias habiles
                $anio_logro=date('Y', (strtotime ("-10 day")));//Cambio de dias habiles
            }
            $gasto_logro=($this->input->post('gasto_logro')=="")?0:$this->input->post('gasto_logro');

            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');
            
            for($i=0;$i<count($id_actividad);$i++) {
                $formuInfo = array(
                    'id_logro'=>$id_logro[$i],
                    'id_actividad'=>$id_actividad[$i],
                    'mes_logro'=>$mes_logro,
                    'anio_logro'=>$anio_logro,
                    'cantidad_logro'=>(($cantidad_logro[$i]=="")?0:$cantidad_logro[$i]),
                    'gasto_logro'=>(($gasto_logro[$i]=="")?0:$gasto_logro[$i]),
                    'observaciones_logro'=>$observaciones_logro[$i],
                    'fecha_creacion'=>$fecha,
                    'id_usuario_crea'=>$id_usuario,
                    'fecha_modificacion'=>$fecha,
                    'id_usuario_modifica'=>$id_usuario
                );

                if($cambio[$i]!=0) {
                    if($id_logro[$i]=="" || $id_logro[$i]==" ") {
                        $id_logro[$i]=$this->monitoreo_model->guardar_logro_actividad($formuInfo);
                        $aa=" ingresó logro del mes de ".$mes_logro." de la actividad con id ".$id_actividad[$i];                    
                        $id_accion=3;
                    } 
                    else {
                        $this->monitoreo_model->actualizar_logro_actividad($formuInfo);
                        $aa=" actualizó logro del mes de ".$mes_logro." de la actividad con id ".$id_actividad[$i];
                        $id_accion=4;
                    }

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
    *   Nombre: configuracion
    *   Objetivo: Formulario de mantenimiento del PAT
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 14/06/2015
    *   Observaciones: Ninguna.
    */


    function cpat()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {
            $data['documentos']=$this->pei_model->buscar_documentos();	
            if($data['id_permiso']==3) {
                //$data['seccion']=$this->pei_model->buscar_seccion();		
            }
            pantalla('pat/cpat',$data,Dcontrol_pat);
        }
        else {
            echo "Sin acceso concedido";
        }
    }


    function mostrar_items_padre_pat($id_documento)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {            
            $this->db->trans_start();
			
			if($data['id_permiso']==3) {  
            	$data['items']=$this->pat_model->buscar_items_padre_pat($id_documento);   
			}
			else {
				$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr')); 				
				$data['items']=$this->pat_model->buscar_items_padre_pat($id_documento,$id_seccion['id_seccion']);  
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
	
	function buscar_actividades($id_padre)
	{
		
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dcontrol_pat); 
        if($data['id_permiso']!="") {
			$this->db->trans_start();
			
			if($data['id_permiso']==3) {
				$data['items']=$this->pat_model->buscar_items('NULL','NULL','NULL',$id_padre);
			}
			else {
				$id_seccion=$this->seguridad_model->consultar_seccion_usuario($this->session->userdata('nr')); 
				$data['items']=$this->pat_model->buscar_items('NULL','NULL','NULL',$id_padre,$id_seccion['id_seccion']);
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
