<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Form Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Jhonatan Flores
 * @link        http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access  public
 * @param   string  the URI segments of the form destination
 * @param   array   a key/value pair of attributes
 * @param   array   a key/value pair hidden data
 * @return  string
 */
    

    function pantalla($vista, $data=NULL, $id_modulo=0) 
    {
        error_reporting(0);
        $CI =& get_instance();
        $data['IDM']=$id_modulo;
        $data['nick']=$CI->session->userdata('usuario');
        $data['nombre']=$CI->session->userdata('nombre');
        $data['menus']=$CI->seguridad_model->buscar_menus($CI->session->userdata('id_usuario'));
        //$data['actividades']=$CI->seguridad_model->buscar_actividades($CI->session->userdata('id_usuario'));
        if($id_modulo>0 && $id_modulo!=2000) {
            $data['menu_actual']=$CI->seguridad_model->descripcion_menu($id_modulo);
            $data['ayuda']=$CI->seguridad_model->buscar_ayuda($id_modulo);
			$data['ayuda2']=$CI->seguridad_model->buscar_ayuda2($id_modulo);
        }
        else
            if($id_modulo==0)
                $data['menu_actual']=array(
                    "id_modulo_padre"=> NULL, 
                    "img_modulo_padre"=> NULL, 
                    "nombre_modulo_padre"=> NULL, 
                    "url_modulo_padre"=> NULL, 
                    "id_modulo"=> 0, 
                    "nombre_modulo"=> "Búsqueda", 
                    "url_modulo"=> "usuarios/buscar", 
                    "img_modulo"=> "glyphicon glyphicon-search", 
                    "descripcion_modulo"=> "Listado de resultados obtenidos en el buscador"
                );
            else
                $data['menu_actual']=array(
                    "id_modulo_padre"=> NULL, 
                    "img_modulo_padre"=> NULL, 
                    "nombre_modulo_padre"=> NULL, 
                    "url_modulo_padre"=> NULL, 
                    "id_modulo"=> 0, 
                    "nombre_modulo"=> "Mi perfil", 
                    "url_modulo"=> "usuarios/mi_perfil", 
                    "img_modulo"=> "glyphicon glyphicon-user", 
                    "descripcion_modulo"=> "Mi registro de usuario"
                );
        
        $CI->load->view('encabezado',$data);
        $CI->load->view('menu_central');
        $CI->load->view('menu_izquierda');
        $CI->load->view($vista);
        $CI->load->view('menu_derecha');    
        $CI->load->view('piePagina');
    }
    
    function pantalla_error() 
    {
        error_reporting(0);
        $CI =& get_instance();
        
        $CI->load->view('encabezado');
        $CI->load->view('error_404');
        $CI->load->view('piePagina');
    }

    function ir_a($url){
        echo'<script language="JavaScript" type="text/javascript">
                var pagina="'.base_url().$url.'"
                function redireccionar() 
                {
                location.href=pagina
                } 
                setTimeout ("redireccionar()", 600);
                
                </script>';
        
        }   

    function nuevaVentana($url){
        echo'<script language="JavaScript" type="text/javascript">
                var pagina2="'.base_url().$url.'"
                function nuevaVentana() 
                {
                window.open(pagina2,"_blank");
                } 
                setTimeout ("nuevaVentana()", 300);
                
                </script>';
        
        }   

    /*function enviar_correo($correo=array(),$title,$message) */
    function enviar_correo($correo,$title,$message) 
    {
        $CI =& get_instance();
        $CI->load->library("phpmailer");
        
        $mail = new PHPMailer();
        $mail->Host = "mtrabajo.mtps.gob.sv";
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = "departamento.transporte@mtps.gob.sv";
        $mail->Password = ".[?=)&%$";
        $mail->From = "departamento.transporte@mtps.gob.sv";
        $mail->FromName = "Departamento de Transporte";
        $mail->IsHTML(true);          
        $mail->Timeout = 1000;
        /*for($i=0;$i<count($correo);$i++)
            $mail->AddAddress( $correo[$i] );*/
        $mail->AddAddress( $correo );
        $mail->ContentType = "text/html";
        $mail->Subject = $title;
        $mail->Body = $message;
        $r=$mail->Send();
        return $r;
    }
    
    function enviar_correo_automatico_administracion($id_solicitud_transporte=NULL, $id_modulo=NULL) 
    {
        $CI =& get_instance();
        $CI->load->model('usuario_model');
        $CI->load->model('transporte_model');
        $datos=$CI->usuario_model->buscar_correos($id_solicitud_transporte, $id_modulo);
        $solicitud=$CI->transporte_model->consultar_solicitud($id_solicitud_transporte);
        for($i=0;$i<count($datos);$i++) {
            $nombre=ucwords($datos[$i]['nombre']);
            $correo=ucwords($datos[$i]['correo']);
            /*$correo="leoneladonispm@hotmail.com";*/
            $nominal=ucwords($datos[$i]['nominal']);
            $mensaje="Estimad@ ".$nombre.",<br><br>La solicitud N&deg;<strong>".$id_solicitud_transporte."</strong> realizada por <strong>".ucwords($solicitud['nombre'])."</strong> ";
            switch($id_modulo){
                case 60:
                    $titulo="SOLICITUD DE TRANSPORTE PENDIENTE DE AUTORIZACION";
                    $mensaje.="requiere de su autorizaci&oacute;n.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
                    break;
                case 62:
                    $titulo="SOLICITUD DE TRANSPORTE PENDIENTE DE ASIGACION DE VEHCULO/MOTORISTA";
                    $mensaje.="requiere asignaci&oacute;n de veh&iacute;culo/motorista.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
                    break;
                default:
                    $titulo="";
                    $mensaje="";
            }
            $r=enviar_correo($correo,$titulo,$mensaje);
        }
    }
    
    function enviar_correo_automatico_usuarios($id_solicitud_transporte=NULL) 
    {
        $CI =& get_instance();
        $CI->load->model('usuario_model');
        $CI->load->model('transporte_model');
        $datos=$CI->usuario_model->buscar_correo($id_solicitud_transporte);
        $nombre=ucwords($datos['nombre']);
        $correo=ucwords($datos['correo']);
        /*$correo="leoneladonispm@hotmail.com";*/
        $nominal=ucwords($datos['nominal']);
        $mensaje="Estimad@ ".$nombre.",<br><br>Su solicitud N&deg;<strong>".$id_solicitud_transporte."</strong> con fecha de salida <strong>".$datos['fecha_mision']."</strong> ";
        switch($datos['estado']){
            case 0:
                $titulo="SOLICITUD DE TRANSPORTE RECHAZADA";
                $mensaje.="ha sido reprobada. Puede que se deba a uno de los siguientes motivos: '<strong>".$datos['observacion']."</strong>'<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
                break;
            case 2:
                $titulo="SOLICITUD DE TRANSPORTE APROBADA";
                $mensaje.="ha sido aprobada.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
                break;
            case 3:
                $titulo="SOLICITUD DE TRANSPORTE ASIGNADA CON VEHICULO/MOTORISTA";
                $mensaje.="ha sido asignada con veh&iacute;culo/motorista.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
                break;
            default:
                $titulo="";
                $mensaje="";
        }
        $r=enviar_correo($correo,$titulo,$mensaje);
    }
    
    function alerta($msj,$url){
        echo'
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8"/>
				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>        
				<title>SIPAT | Sistema de Planificación Anual de Trabajo</title>
				
				<link rel="stylesheet" type="text/css" href="'.base_url().'css/bootstrap/bootstrap.min.css"/>
				<script src="'.base_url().'js/demo-rtl.js"></script>
				<link rel="stylesheet" type="text/css" href="'.base_url().'css/libs/font-awesome.css"/>
				<link rel="stylesheet" type="text/css" href="'.base_url().'css/libs/nanoscroller.css"/>
				 
				<link rel="stylesheet" type="text/css" href="'.base_url().'css/compiled/theme_styles.css"/>
				 
				<link rel="stylesheet" href="'.base_url().'css/libs/daterangepicker.css" type="text/css"/>
				<link rel="stylesheet" href="'.base_url().'css/libs/jquery-jvectormap-1.2.2.css" type="text/css"/>
				<link rel="stylesheet" href="'.base_url().'css/libs/weather-icons.css" type="text/css"/>
				 
				<link type="image/x-icon" href="'.base_url().'img/favicon.png" rel="shortcut icon"/>
				 
				<!--<link href="'.base_url().'css/fontsgoogleapis.css?family=Open+Sans:400,600,700,300" rel="stylesheet" type="text/css">-->
				<!--[if lt IE 9]>
						<script src="'.base_url().'js/html5shiv.js"></script>
						<script src="'.base_url().'js/respond.min.js"></script>
					<![endif]-->
				<style>
					#config-tool{width:350px;}
					#config-tool.closed{right:-350px;}
					.rtl #config-tool.closed{left:-350px;}
					#footer-bar {height: auto;line-height: 15px;}
					@media (max-width: 400px) {
						#config-tool{width:300px;}
						#config-tool.closed{right:-300px;}
						.rtl #config-tool.closed{left:-300px;}
					}
					@media (max-width: 350px) {
						#config-tool{width:270px;}
						#config-tool.closed{right:-270px;}
						.rtl #config-tool.closed{left:-270px;}
					}
				</style>
				<script src="'.base_url().'js/demo-skin-changer.js"></script>  
				<script src="'.base_url().'js/jquery.js"></script>
				<script src="'.base_url().'js/bootstrap.js"></script>
				<script src="'.base_url().'js/jquery.nanoscroller.min.js"></script>
				<script src="'.base_url().'js/demo.js"></script>  
				 
				<script src="'.base_url().'js/moment.min.js"></script>
				<script src="'.base_url().'js/jquery-jvectormap-1.2.2.min.js"></script>
				<script src="'.base_url().'js/jquery-jvectormap-world-merc-en.js"></script>
				<script src="'.base_url().'js/gdp-data.js"></script>
				<script src="'.base_url().'js/flot/jquery.flot.min.js"></script>
				<script src="'.base_url().'js/flot/jquery.flot.resize.min.js"></script>
				<script src="'.base_url().'js/flot/jquery.flot.time.min.js"></script>
				<script src="'.base_url().'js/flot/jquery.flot.threshold.js"></script>
				<script src="'.base_url().'js/flot/jquery.flot.axislabels.js"></script>
				<script src="'.base_url().'js/jquery.sparkline.min.js"></script>
				<script src="'.base_url().'js/skycons.js"></script>
				 
				<script src="'.base_url().'js/scripts.js"></script>
				<script src="'.base_url().'js/pace.min.js"></script>
            </head>
            <body style="background: #FFF;">
                <button style="display:none" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-static"></button>
                <div class="modal fade bs-example-modal-static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Error al intentar ingresar al sitio</h4>
                        </div>
                        <div class="modal-body">
                            El usuario y contraseña no coiciden.
                        </div>
                    </div>
                  </div>
                </div>
                <script language="JavaScript" type="text/javascript">
                    var pagina="'.base_url().$url.'"
                    function redireccionar() {
                        $(".btn").click();
                        setTimeout("partB()",3000)
                    } 
                    function partB() {
                        location.href=pagina
                    } 
                    setTimeout ("redireccionar()",1000);
                </script>
            </body>
            </html>
            ';
        }   



/* End of file tools_helper.php */
/* Location: ./system/helpers/form_helper.php */