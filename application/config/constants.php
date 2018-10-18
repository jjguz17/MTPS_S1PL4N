<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',                            'rb');
define('FOPEN_READ_WRITE',                      'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',        'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',   'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',                    'ab');
define('FOPEN_READ_WRITE_CREATE',               'a+b');
define('FOPEN_WRITE_CREATE_STRICT',             'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',        'x+b');

define('Dinicio',                               168);
define('Dplan_estrategico',                		169);
define('Dplan_anual',                     		170);
define('Dmonitoreo',                     		171);
define('Dusuario',            	         		172);
define('Dcontrol_rol',                     		173);
define('Davance',  	 		              		174);
define('Dreportes',                     		175);
define('Ddocumento',                     		176);
define('Dconfiguracion',   		       			177);
define('Dvalidacion',                 			178);
define('Dcumplimiento',                			179);
define('Dcontrol_pat',                     		180);
define('Dobjetivos',                     		181);

/*
define('Dreportes',                             91);
define('Dreportes_promociones',                 92);
define('Dpromocion_comites',                    93);
define('Ddatos_generales',                      94);
define('Dingreso_promocion',                    95);
define('Dprogramar_visita_1',                   96);
define('Dacreditacion',                         97);
define('Dprogramar_capacitacion',               98);
define('Dcontrol_asistencia',                   99);
define('Dacreditacion_comite',                  100);
define('Dverificacion',                         101);
define('Dprogramar_visita_2',                   102);
define('Dcontrol_visita',                       103);
define('Dusuario',                              104);
define('Dcontrol_rol',                          105);
define('Dcontrol_usuario',                      106);
define('Dlugares_trabajo',                      107);
define('Dparticipantes',                        108);
define('Dasignaciones',                         109);
define('Dregistrar_comite', 					125);
define('Daprobar_comite', 						126);
define('Dimprimir_acreditacion',				127);
define('Dreportes_capacitaciones', 				128);
define('Dreportes_acreditaciones', 				129);
define('Dreportes_verificaciones',				130);
define('Dasigancion_visita_1', 					132);
define('Dasigancion_visita_2', 					133);
define('Dinforme_mensual', 						134);
define('Dincumplimiento_LGPRLT', 				145);
*/

/* End of file constants.php */
/* Location: ./application/config/constants.php */
