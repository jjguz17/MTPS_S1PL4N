<?php 

# define("SERVER_MTPS","192.168.1.200");
define("SERVER_MTPS","127.0.0.1");
class Sessiones extends CI_Controller {
		
	function Sessiones()
	{
        parent::__construct();
        error_reporting(0);
		$this->load->model('seguridad_model');
		$this->load->helper('cookie');
		$this->load->library("securimage/securimage");
		date_default_timezone_set('America/El_Salvador');
    }

	/*
	*	Nombre: index
	*	Obejtivo: Carga la vista que contiene el formulario de login
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 03/07/2014
	*	Observaciones: Ninguna
	*/
	function index($est=20000)
	{
		$in=$this->verificar();
		if($in<=3){
			$data['est']=$est;
			$this->load->view('encabezado.php'); 
			$this->load->view('login.php',$data); 
			$this->load->view('piePagina.php');		
		}
		else {
			//echo"Sistema Bloqueado";
			$this->load->view('lock.php'); 
		}
	}
	
	/*
	*	Nombre: iniciar_session
	*	Obejtivo: Verificar que el nick y password introducidos por el usuario sean correctos
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 03/07/2014
	*	Observaciones: La variable de session "id_seccion" no la deberiamos ocupar, deberiamos ir a buscar el registro actual del usuario logueado cada vez que se requiera
	*/
	function iniciar_session()
	{
		$in=$this->verificar();
		if ($in<=3) {				
			$login =$this->input->post('user');
			$clave =$this->input->post('pass');

			$v=$this->seguridad_model->consultar_usuario2($login); //verifica únicamente por el nombre de usuario

			if($v['id_usuario']!=0){/*se verifica que el usuario exista*/
			/////////////////////////////verificacion de usuario con la contraseña////////////////////////////
				$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
				
				if($v['id_usuario']==0)/*El usuario y la contraseñan son incorrectos*/
				{
						
					if (SERVER_MTPS==$_SERVER['SERVER_NAME']) { //Se verifica que active directory este disponible
					
						/*Procedemos a buscar en el Active Directory*/
						$active="login";//$this->ldap_login($login,$clave); /// verifica si existe ese usuario con el password en el Active Directory
						if($active=="login")
						{
							$v=$this->seguridad_model->consultar_usuario2($login); //verifica únicamente por el nombre de usuario
							if($v['id_usuario']==0)/*Si el usuario no ingreso sus datos correctamente*/
							{
								alerta("Clave incorrecta",'index.php/sessiones');	
							}
							else 
							{	
								
								$this->session->set_userdata('nombre', $v['nombre_completo']);
								$this->session->set_userdata('id_usuario', $v['id_usuario']);
								$this->session->set_userdata('usuario', $v['usuario']);
								$this->session->set_userdata('nr', $v['NR']);			
								$this->session->set_userdata('id_seccion', $v['id_seccion']);
								$this->session->set_userdata('sexo', $v['sexo']);
								setcookie('contador', 1, time() + 30* 60);	
									
								if($_SESSION['url']!=NULL && $_SESSION['url']!='' ) {
									redirect($_SESSION['url']);													

								}else{
									
									if($this->seguridad_model->bitacora(10,$v['id_usuario'],'El usuario '.$v['usuario'].' inició sesión',1))
									ir_a('index.php/inicio');
									else echo "error";											
								}	
							}
						}	else alerta("Usuario y clave no coinciden en Active Directory",'index.php/sessiones');	
					////////////////Fin verificacion con Active Directory
											
					} else {
							alerta("Clave incorrecta",'index.php/sessiones');	
					}
				}
				else 
				{	//se guardan los datos cuando, sin requerir verificacion en base de datos
					$this->session->set_userdata('nombre', $v['nombre_completo']);
					$this->session->set_userdata('id_usuario', $v['id_usuario']);
					$this->session->set_userdata('usuario', $v['usuario']);
					$this->session->set_userdata('nr', $v['NR']);			
					$this->session->set_userdata('id_seccion', $v['id_seccion']);
					$this->session->set_userdata('sexo', $v['sexo']);
					setcookie('contador', 1, time() + 15* 60);			
								if($_SESSION['url']!=NULL && $_SESSION['url']!='' ) {
									redirect($_SESSION['url']);													

								}else{
									
									if($this->seguridad_model->bitacora(10,$v['id_usuario'],'El usuario '.$v['usuario'].' inició sesión',1))
									ir_a('index.php/inicio');
									else echo "error";									
								}	
				}
			////////////////////Fin de la verifiaciacion de usuario y contraseña
			}else{
			alerta("El usuario no esta registrado",'index.php/sessiones');	
			}
		}
		else
		{
			alerta($in." intentos. terminal bloqueada",'index.php/sessiones');
		
		}
	}
	
	/*
	*	Nombre: cerrar_session
	*	Obejtivo: Cerrar la sesion de un usuario
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function cerrar_session()
	{
		$id_user=$this->session->userdata('id_usuario');
		$user=$this->session->userdata('usuario');

		$this->session->set_userdata('nombre','');
		$this->session->set_userdata('id_usuario','');
		$this->session->set_userdata('usuario', '');	
		$this->session->set_userdata('nr','');
	   	if($this->seguridad_model->bitacora(10,$id_user,"El usuario ".$user." cerró sesión",2))
		{
	   		redirect('index.php/sessiones/');
		}else echo "error";
	}
	
	/*
	*	Nombre: cerrar_session
	*	Obejtivo: Cerrar la sesion de un usuario
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 03/07/2014
	*	Observaciones: Ninguna
	*/
	function verificar()
	{
		$in;
		if(!isset($_COOKIE['contador'])) { // Caduca en 15 minutos y se ajusta a uno la primera vez
		 	setcookie('contador', 1, time() + 15* 60); 
			//sleep (2); //es nesesario pausar debido a que se tiene que crear la cookie
			return 1;
		}
		else { 
			// si existe cookie procede a contar  
			setcookie('contador', $_COOKIE['contador'] + 1, time() + 15 * 60); 
		 	sleep (1); //es nesesario pausar debido a que se tiene que crear la cookie
			return $_COOKIE['contador'];
		}//fin else de intentos
	}


	function cambiar_pass()
	{
		$this->load->view('cambiar_pass');
	}

	function capcha()
	{
		$img = new Securimage();
		$img->show(); 
	}

	function sendmail()
	{
		header('Content-type: application/json');
		$securimage = new Securimage();
		$correo=$this->input->post('correo');
		$captcha_code=$this->input->post('captcha_code');
		if ($securimage->check($captcha_code)) {
			$letras = "ABCDEFGHJKLMNPRSTUVWXYZ98765432";
			$contra=str_shuffle($letras);
			$contra=substr($contra,0,10);
			
			$letras2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321";
			$contra2=str_shuffle($letras2);
			$contra2=substr($contra2,0,40);	
			
			$info=$this->seguridad_model->info_empleado(NULL,"id_usuario, nombre, correo",NULL,$correo);
			
			$formuInfo = array(
				'id_usuario'=>$info['id_usuario'],
				'fecha_caso'=>date('Y-m-d'),
				'nuevo_pass'=>md5($contra),
				'codigo_caso'=>$contra2
			);
			$this->seguridad_model->guardar_caso($formuInfo);
			
			$message='
				Hola '.$info['nombre'].'! Esta es tu nueva contraseña: '.$contra.'. Si la quieres activar da clic <a href="'.base_url().'/index.php/sessiones/activar/'.$contra2.'" target="_blank">aquí</a>. Tiene 3 días para activar este código.
			';
			
			$r=enviar_correo($info['correo'],"SCRS - Restablecimiento de Contraseña",$message);
						
			$correo2=$info['correo'];
			$needle='@';
			$pos=strripos($correo2, $needle);
			for($i=2;$i<$pos;$i++)
				$correo2[$i]="*";
			if($r=1)
				echo json_encode(array('status' => 1, 'message' => $correo2));
			else
				echo json_encode(array('status' => 0, 'message' => 'Ha fallado el envío del correo'));
		}
		else {
			echo json_encode(array('status' => 0, 'message' => 'El código ingresado no es corecto!'));
		}
	}
	
	function activar($codigo_caso=NULL)
	{
		$est=$caso=$this->seguridad_model->buscar_caso($codigo_caso);
		$this->index($est);
	}

	/*
	*	Nombre: ldap_login
	*	Obejtivo: Verificar si password introducido por el usuario es del Active Directory o no.
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Ultima Modificacion: 06/05/2015
	*	Observaciones:
	*/
	
	function ldap_login($user,$pass)
	{	
		
		$ldaprdn = $user.'@mtps.local';
		$ldappass = $pass;
		$ds = 'mtps.local';
		$dn = 'dc=mtps,dc=local';
		$puertoldap = 389; 
		$ldapconn = ldap_connect($ds,$puertoldap)
		or die("ERROR: No se pudo conectar con el Servidor LDAP."); 
		
		if ($ldapconn) 
		{ 
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 
			$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
			if ($ldapbind) 
			{ 
				return "login";
			}
			else 
			{ 
				return "error";
			} 
		}
		else 
		{ 
			return "error";
		}
		ldap_close($ldapconn);
	}
}
?>
