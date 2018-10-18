<?php
class Pei extends CI_Controller
{
    /* Incluir(TRUE)/No incluir(FALSE) los lugares de trabajo que ya tienen una visita programada en la lista de lugares de trabajo que se pueden asignar*/
    public $mostrar_todos="FALSE"; 
    
    function Pei()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->model('seguridad_model');
        $this->load->model('promocion_model');
        $this->load->model('pei_model');
        date_default_timezone_set('America/El_Salvador');
        
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }
    
    function index()
    {
        ir_a("index.php/pei/documento");
    }	
	    
    /*
    *   Nombre: documento
    *   Objetivo: Formulario de configuración inicial del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */
    function documento($accion_transaccion=NULL, $estado_transaccion=NULL)
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento); 
        if($data['id_permiso']==3) {
            $data['documentos']=$this->pei_model->buscar_documentos();
            pantalla('pei/documento',$data,Ddocumento);
        }
        else {
            echo "Sin acceso concedido";
        }
    }

    /*
    *   Nombre: guardar_documento
    *   Objetivo: Guarda formulario de configuración inicial del PEI
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Ninguna.
    */

    function poner_guion($url){
        $url = strtolower($url);
        //Reemplazamos caracteres especiales latinos
        $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
        $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
        $url = str_replace($find, $repl, $url);
        //Añadimos los guiones
        $find = array(' ', '&amp;', '\r\n', '\n','+');
        $url = str_replace($find, '-', $url);
        //Eliminamos y Reemplazamos los demas caracteres especiales
        $find = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;{^&gt;*&gt;/');
        $repl = array('', '-', '');
        $url = preg_replace($find, $repl, $url);
        return $url;
    }

    function guardar_documento()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Ddocumento);
        if($data['id_permiso']==3){

            $config['upload_path'] = './documentos/';
            $config['allowed_types'] = 'pdf';
            //$config['file_name'] = utf8_decode($this->input->post('nombre_pei'));
            $config['file_name'] = $this->poner_guion($this->input->post('nombre_pei'));
            $config['remove_spaces'] = false;
                    
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload() && $this->input->post('id_documento')=="")
            {
                $tr=0;
            }   
            else
            {
                $this->db->trans_start();
                $file_data = $this->upload->data();    

                $id_documento=$this->input->post('id_documento');
                $count=$this->input->post('count');
                $nombre_pei=$this->input->post('nombre_pei');
                $fec=str_replace("/","-",$this->input->post('fecha_aprobacion'));
                $fecha_aprobacion=date("Y-m-d", strtotime($fec));
                $inicio_periodo=$this->input->post('inicio_periodo');
                $fin_periodo=$this->input->post('fin_periodo');
                $nombre_documento=$this->poner_guion($this->input->post('nombre_pei')).".pdf";//$file_data['file_name'];
                $observacion=$this->input->post('observacion');

                $lista=json_decode($this->input->post('lista'));

                $fecha=date('Y-m-d H:i:s');
                $id_usuario=$this->session->userdata('id_usuario');

                if($id_documento=="") {
                    $formuInfo = array(
                        'nombre_pei'=>$nombre_pei,
                        'fecha_aprobacion'=>$fecha_aprobacion,
                        'nombre_documento'=>$nombre_documento,
                        'inicio_periodo'=>$inicio_periodo,
                        'fin_periodo'=>$fin_periodo,
                        'observacion'=>$observacion,
                        'fecha_creacion'=>$fecha,
                        'id_usuario_crea'=>$id_usuario
                    );
                    $id_documento=$this->pei_model->guardar_documento($formuInfo);  

                    $descripcion_bitacora="El usuario ".$this->session->userdata('usuario')." creó PEI con el id ".$id_documento;
                    $id_accion=3;
                    $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion);                
                }
                else {                    
                    $formuInfo = array(
                        'id_documento'=>$id_documento,
                        'nombre_pei'=>$nombre_pei,
                        'fecha_aprobacion'=>$fecha_aprobacion,
                        'nombre_documento'=>$nombre_documento,
                        'inicio_periodo'=>$inicio_periodo,
                        'fin_periodo'=>$fin_periodo,
                        'observacion'=>$observacion,
                        'fecha_modificacion'=>$fecha,
                        'id_usuario_modifica'=>$id_usuario
                    );
                    $this->pei_model->actualizar_documento($formuInfo);

                    $descripcion_bitacora="El usuario ".$this->session->userdata('usuario')." modificó PEI con el id ".$id_documento;
                    $id_accion=4;
                    $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion);   
                }
				if($count>0)
                	$this->pei_model->eliminar_nivel($id_documento);

                for($i=0;$i<count($lista);$i++){
                    $formuInfo = array(
                        'id_nivel'=>$lista[$i]->id_nivel,
                        'id_documento'=>$id_documento,
						'tipo_nivel'=>1,
                        'nivel'=>1,
                        'nombre_nivel'=>$lista[$i]->id,
                        'indicador'=>($lista[$i]->ind===FALSE)?0:1,
                        'abreviacion'=>$lista[$i]->abr,
                        'id_padre'=>"NULL"
                    );
					if($count>0)
                    	$id_padre2=$this->pei_model->guardar_nivel($formuInfo);
					else
						$this->pei_model->actualizar_nivel($formuInfo);

                    $lista2=$lista[$i]->children;
                    for($i2=0;$i2<count($lista2);$i2++){
                        $formuInfo = array(
                        	'id_nivel'=>$lista2[$i2]->id_nivel,
                            'id_documento'=>$id_documento,
							'tipo_nivel'=>1,
                            'nivel'=>2,
                            'nombre_nivel'=>$lista2[$i2]->id,
                            'indicador'=>($lista2[$i2]->ind===FALSE)?0:1,
                            'abreviacion'=>$lista2[$i2]->abr,
                            'id_padre'=>($id_padre2!="")?$id_padre2:$lista2[$i2]->id_padre
                        );
                        if($count>0)
                    		$id_padre3=$this->pei_model->guardar_nivel($formuInfo); 
						else
							$this->pei_model->actualizar_nivel($formuInfo);

                        $lista3=$lista2[$i2]->children;
                        for($i3=0;$i3<count($lista3);$i3++){
                            $formuInfo = array(
                        		'id_nivel'=>$lista3[$i3]->id_nivel,
                                'id_documento'=>$id_documento,
								'tipo_nivel'=>1,
                                'nivel'=>3,
                                'nombre_nivel'=>$lista3[$i3]->id,
                                'indicador'=>($lista3[$i3]->ind===FALSE)?0:1,
                                'abreviacion'=>$lista3[$i3]->abr,
                                'id_padre'=>($id_padre3!="")?$id_padre3:$lista3[$i3]->id_padre
                            );
                            if($count>0)
                    			$id_padre4=$this->pei_model->guardar_nivel($formuInfo); 
							else
								$this->pei_model->actualizar_nivel($formuInfo);

                            $lista4=$lista3[$i3]->children;
                            for($i4=0;$i4<count($lista4);$i4++){
                                $formuInfo = array(
                        			'id_nivel'=>$lista4[$i4]->id_nivel,
                                    'id_documento'=>$id_documento,
									'tipo_nivel'=>1,
                                    'nivel'=>4,
                                    'nombre_nivel'=>$lista4[$i4]->id,
                                    'indicador'=>($lista4[$i4]->ind===FALSE)?0:1,
                                    'abreviacion'=>$lista4[$i4]->abr,
                                    'id_padre'=>($id_padre4!="")?$id_padre4:$lista4[$i4]->id_padre
                                );
                                if($count>0)
                    				$id_padre5=$this->pei_model->guardar_nivel($formuInfo); 
								else
									$this->pei_model->actualizar_nivel($formuInfo);

                                $lista5=$lista4[$i4]->children;
                                for($i5=0;$i5<count($lista5);$i5++){
                                    $formuInfo = array(
                        				'id_nivel'=>$lista5[$i5]->id_nivel,
                                        'id_documento'=>$id_documento,
										'tipo_nivel'=>1,
                                        'nivel'=>5,
                                        'nombre_nivel'=>$lista5[$i5]->id,
                                        'indicador'=>($lista5[$i5]->ind===FALSE)?0:1,
                                        'abreviacion'=>$lista5[$i5]->abr,
                                        'id_padre'=>($id_padre5!="")?$id_padre5:$lista5[$i5]->id_padre
                                    );
                                    if($count>0)
                    					$id_padre6=$this->pei_model->guardar_nivel($formuInfo); 
									else
										$this->pei_model->actualizar_nivel($formuInfo);

                                    $lista6=$lista5[$i5]->children;
                                    for($i6=0;$i6<count($lista6);$i6++){
                                        $formuInfo = array(
                        					'id_nivel'=>$lista6[$i6]->id_nivel,
                                            'id_documento'=>$id_documento,
											'tipo_nivel'=>1,
                                            'nivel'=>6,
                                            'nombre_nivel'=>$lista6[$i6]->id,
                                            'indicador'=>($lista6[$i6]->ind===FALSE)?0:1,
                                            'abreviacion'=>$lista6[$i6]->abr,
                                            'id_padre'=>($id_padre6!="")?$id_padre6:$lista6[$i6]->id_padre
                                        );
                                        if($count>0)
                    						$id_padre7=$this->pei_model->guardar_nivel($formuInfo); 
										else
											$this->pei_model->actualizar_nivel($formuInfo);

                                        $lista7=$lista6[$i6]->children;
                                        for($i7=0;$i7<count($lista7);$i7++){
                                            $formuInfo = array(
                        						'id_nivel'=>$lista7[$i7]->id_nivel,
                                                'id_documento'=>$id_documento,
												'tipo_nivel'=>1,
                                                'nivel'=>7,
                                                'nombre_nivel'=>$lista7[$i7]->id,
                                                'indicador'=>($lista7[$i7]->ind===FALSE)?0:1,
                                                'abreviacion'=>$lista7[$i7]->abr,
                                                'id_padre'=>($id_padre7!="")?$id_padre7:$lista7[$i7]->id_padre
                                            );
                                            if($count>0)
                    							$id_padre8=$this->pei_model->guardar_nivel($formuInfo);
											else
												$this->pei_model->actualizar_nivel($formuInfo);

                                            $lista8=$lista7[$i7]->children;
                                            for($i8=0;$i8<count($lista8);$i8++){
                                                $formuInfo = array(
                        							'id_nivel'=>$lista8[$i8]->id_nivel,
                                                    'id_documento'=>$id_documento,
													'tipo_nivel'=>1,
                                                    'nivel'=>8,
                                                    'nombre_nivel'=>$lista8[$i8]->id,
                                                    'indicador'=>($lista8[$i8]->ind===FALSE)?0:1,
                                                    'abreviacion'=>$lista8[$i8]->abr,
                                                    'id_padre'=>($id_padre8!="")?$id_padre8:$lista8[$i8]->id_padre
                                                );
                                                if($count>0)
                    								$id_padre9=$this->pei_model->guardar_nivel($formuInfo);
												else
													$this->pei_model->actualizar_nivel($formuInfo);

                                                $lista9=$lista8[$i8]->children;
                                                for($i9=0;$i9<count($lista9);$i9++){
                                                    $formuInfo = array(
                        								'id_nivel'=>$lista9[$i9]->id_nivel,
                                                        'id_documento'=>$id_documento,
														'tipo_nivel'=>1,
                                                        'nivel'=>9,
                                                        'nombre_nivel'=>$lista9[$i9]->id,
                                                        'indicador'=>($lista9[$i9]->ind===FALSE)?0:1,
                                                        'abreviacion'=>$lista9[$i9]->abr,
                                                        'id_padre'=>($id_padre9!="")?$id_padre9:$lista9[$i9]->id_padre
                                                    );
                                                    if($count>0)
                    									$id_padre0=$this->pei_model->guardar_nivel($formuInfo);
													else
														$this->pei_model->actualizar_nivel($formuInfo);

                                                    $lista0=$lista9[$i9]->children;
                                                    for($i0=0;$i0<count($lista0);$i0++){
                                                        $formuInfo = array(
                        									'id_nivel'=>$lista0[$i0]->id_nivel,
                                                            'id_documento'=>$id_documento,
															'tipo_nivel'=>1,
                                                            'nivel'=>10,
                                                            'nombre_nivel'=>$lista0[$i0]->id,
                                                            'indicador'=>($lista0[$i0]->ind===FALSE)?0:1,
                                                            'abreviacion'=>$lista0[$i0]->abr,
                                                            'id_padre'=>($id_padre0!="")?$id_padre0:$lista0[$i0]->id_padre
                                                        );
                                                    	if($count>0)
                                                        	$this->pei_model->guardar_nivel($formuInfo);
														else
															$this->pei_model->actualizar_nivel($formuInfo);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $this->db->trans_complete();
                $tr=($this->db->trans_status()===FALSE)?0:1;
            }
            
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
            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario')." eliminó PEI con el id ".$id_documento;
            $id_accion=5;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion);  
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

    function guardar_item_wizard()
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();

            $id_item=$this->input->post('id_item'); 
            $id_nivel=$this->input->post('id_nivel'); 
            $id_seccion=$this->input->post('id_seccion'); 
            if($this->input->post('id_padre_texto')!="NULL" && $this->input->post('id_padre_texto')!="")
                $correlativo_item=$this->input->post('correlativo_item').".".$this->input->post('id_padre_texto');
            else
                $correlativo_item=$this->input->post('correlativo_item');
            $descripcion=$this->input->post('descripcion_item');
            $id_padre=$this->input->post('id_padre');

            $fecha=date('Y-m-d H:i:s');
            $id_usuario=$this->session->userdata('id_usuario');

             $formuInfo = array(
                'id_item'=>$id_item,
                'id_nivel'=>$id_nivel,
                'id_seccion'=>$id_seccion,
                'correlativo_item'=>$correlativo_item,
                'descripcion_item'=>$descripcion,
                'id_padre'=>$id_padre,
                'fecha_creacion'=>$fecha,
                'id_usuario_crea'=>$id_usuario,
                'fecha_modificacion'=>$fecha,
                'id_usuario_modifica'=>$id_usuario
            );

            if($id_item=="") {
                $id_item=$this->pei_model->guardar_wizard($formuInfo);
                $aa=" creó item en el wizard con el código ".$correlativo_item;
                $id_accion=3;
            }
            else {
                $this->pei_model->actualizar_wizard($formuInfo);
                $aa=" actualizó item del wizard con el código ".$correlativo_item;
                $id_accion=4;
            }
            $descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
            $this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 

            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'id_item'=>$id_item,
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

    function wizard_recargado2New($id_nivel=0)
    {
        $data['items']=$this->pei_model->buscar_items('NULL', $id_nivel);

        $json=' ';
        foreach ($data['items'] as $val) {
            $a='';
            $a.='<a title=\'Editar\' href=\'#\' onClick=\'editar(this, '.$val['id_item'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a>';
            $a.='<a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar_msg(this, '.$val['id_item'].');return false;\'  class=\'table-link delete-row\' data-id=\''.$val['id_item'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a>';
			if($val['indi']=="1") {
				$cor='\"'.(eregi_replace("[\n|\r|\n\r]", "", $val['correlativo_item'])).'\"';
				$a.='<a title=\'Presupuestar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'edit_presupuesto_row(this, '.$val['id_item'].', '.$cor.');return false;\'  class=\'table-link edit_presupuesto_row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-usd fa-stack-1x fa-inverse\'></i></span></a>';
			}
			$json.='["'.(eregi_replace("[\n|\r|\n\r]", '', $val['correlativo_item'])).'","'.(eregi_replace("[\n|\r|\n\r]", '', $val['descripcion_item'])).'","'.$a.'"],';
        }
        $json='{ "data": ['.substr($json,0,-1).'] }';
        echo $json;
    }

    function eliminar_itemNew($id_item=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();
           
            $formuInfo = array(
                'id_item'=>$id_item
            );
            $this->pei_model->eliminar_wizard($formuInfo);

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
	
	function actualizar_nivel2New($id_nivel=0, $agrupar_numeracion=0, $agregar_separador=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();
           
            $formuInfo = array(
				'id_nivel'=>$id_nivel,
				'agrupar_numeracion'=>$agrupar_numeracion,
				'agregar_separador'=>$agregar_separador
			);
			$this->pei_model->actualizar_nivel2($formuInfo);

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
	
	function editar_itemNew($id_item=0)
    {
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dobjetivos); 
        if($data['id_permiso']==3) {
            $this->db->trans_start();
           
            $data['items']=$this->pei_model->buscar_items('NULL', 'NULL', $id_item);
						
			$cor=explode(".",$data['items'][0]['correlativo_item'],2);
			$data['items'][0]['correlativo_item']=$cor[0];
			$data['items'][0]['id_padre_texto']=$cor[1];
			
            $this->db->trans_complete();
            $tr=($this->db->trans_status()===FALSE)?0:1;
            $json =array(
                'resultado'=>$tr,
                'valores'=>$data['items'],
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
    *   Nombre: guardar_wizard
    *   Objetivo: Guarda formulario tipo wizard
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Se deshechará.
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
				if($registro[$i]=="del") {
					$this->pei_model->eliminar_wizard($formuInfo);
                    $aa=" eliminó item del wizard con el código ".$correlativo_item[$i];
                    $id_accion=5;
                }
                if($registro[$i]=="new") {
                    $id_itemNew=$this->pei_model->guardar_wizard($formuInfo);
                    $aa=" creó item en el wizard con el código ".$correlativo_item[$i];
                    $id_accion=3;
                }
				if($registro[$i]=="update") {
					$this->pei_model->actualizar_wizard($formuInfo);
                    $aa=" actualizó item del wizard con el código ".$correlativo_item[$i];
                    $id_accion=4;
                }
				if($registro[$i]=="del" || $registro[$i]=="new" || $registro[$i]=="update") {
					$descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
					$this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
				}

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
    *   Observaciones: Se deshechará.
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
					if($id_presupuesto[$i]=="") {
						$pre=$this->pei_model->guardar_presupuesto($formuInfo);
                        $aa=" creó un presupuesto con el id ".$pre;
                        $id_accion=3;
						$descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
						$this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
                    }
					else {
						$this->pei_model->actualizar_presupuesto($formuInfo);
                        $aa=" actualizó presupuesto con el id ".$id_presupuesto[$i];
                        $id_accion=4;
						$descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
						$this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
                    }
				}
				else {
					if($id_presupuesto[$i]!="") {
						$this->pei_model->eliminar_presupuesto($formuInfo);
                        $aa=" eliminó presupuesto con el id ".$id_presupuesto[$i];
                        $id_accion=5;
						$descripcion_bitacora="El usuario ".$this->session->userdata('usuario').$aa;
						$this->seguridad_model->bitacora(10,$this->session->userdata('id_usuario'),$descripcion_bitacora,$id_accion); 
                    }
                }
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
    
	/*
    *   Nombre: resultados
    *   Objetivo: Muestra los resultados de una búsqueda de manera tabulada
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 01/05/2015
    *   Observaciones: Sólo se ha copiado el códgo de Acreditaciones.
    */	
    /*function resultados($fecha_iniciale=NULL,$fecha_finale=NULL,$reportee=NULL,$exportacione=NULL)
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
                        $this->mpdf->mPDF('utf-8','letter-L'); //Creacion de objeto mPDF con configuracion de pagina y margenes
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); //Selecionamos la hoja de estilo del pdf
                        $this->mpdf->WriteHTML($stylesheet,1); //lo escribimos en el pdf
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_instituciones.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES REALIZADAS POR LUGAR DE TRABAJO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); //Salida del pdf
                    }
                    break;
                case 2:
                    $data['info']=$this->promocion_model->resultados_tecnicos($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Técnicos ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('promocion/resultados_tecnicos',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter-L'); //Creacion de objeto mPDF con configuracion de pagina y margenes
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); //Selecionamos la hoja de estilo del pdf
                        $this->mpdf->WriteHTML($stylesheet,1); //lo escribimos en el pdf
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_tecnicos.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES REALIZADAS POR TÉCNICO EDUCADOR";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); //Salida del pdf
                    }
                    break;
                case 3:
                    $data['info']=$this->promocion_model->resultados_sectores($fecha_inicial,$fecha_final,$id_departamento);
                    $data['nombre']="Sectores ".date('d-m-Y hisa');
                    if($data['exportacion']!=2)
                        $this->load->view('promocion/resultados_sectores',$data);
                    else {
                        $this->mpdf->mPDF('utf-8','letter'); //Creacion de objeto mPDF con configuracion de pagina y margenes
                        $stylesheet = file_get_contents('css/pdf/acreditacion.css'); //Selecionamos la hoja de estilo del pdf
                        $this->mpdf->WriteHTML($stylesheet,1); //lo escribimos en el pdf
                        //$this->mpdf->SetHTMLHeader($this->load->view('cabecera_pdf.php', $data, true),1);
                        $this->mpdf->SetFooter('Fecha y hora de generación: '.date('d/m/Y H:i:s A').'||Página {PAGENO}/{nbpg}');
                        
                        $html = $this->load->view('promocion/resultados_sectores.php', $data, true);
                        $data_cab['titulo']="PROMOCIONES POR SECTOR ECONÓMICO";
                        $this->mpdf->WriteHTML($this->load->view('cabecera_pdf.php', $data_cab, true),2);
                        $this->mpdf->WriteHTML($html,2);
                        $this->mpdf->Output(); //Salida del pdf
                    }
                    break;
            }
        }
        else {
            pantalla_error();
        }
    }*/
}
?>
