<?php
class Inicio extends CI_Controller
{
     
    
    
    function Inicio()
    {
    	
    	
        parent::__construct();
        date_default_timezone_set('America/El_Salvador');
        error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library("mpdf");
        $this->load->library("PHPExcel");
        $this->load->model('seguridad_model');
        $this->load->model('reportes_model');
         $this->load->model('pat_model');
        if(!$this->session->userdata('id_usuario')){
            redirect('index.php/sessiones');
        }
    }
    
    /*
    *   Nombre: index
    *   Objetivo: Carga la vista dashboard
    *   Hecha por: Leonel
    *   Modificada por: Leonel
    *   Última Modificación: 23/07/2014
    *   Observaciones: Ninguna.
    */
    function index()
    {   
        $data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),Dinicio); 
        if($data['id_permiso']!=NULL) {
        	$anio= date('Y');
        	if(isset($_REQUEST["anio"])) $anio = $_REQUEST["anio"];
			$data['periodo_pat'] = $this->pat_model->mostrar_periodo($anio);
			$data['objetivos']=$this->reportes_model->objetivos($anio);
			for($i=0; $i < count($data['objetivos']); $i++) {
				$r=$this->reportes_model->logros($anio, $data['objetivos'][$i]["id_item"]);
				$sum1 = 0;
				$sum2 = 0;
				$sum3 = 0;
				for($j=0; $j < count($r); $j++) {
					$sum1 = $sum1 + ($r[$j]["logroMesActual"] / $r[$j]["metaMesActual"] * 100);
					$sum2 = $sum2 + ($r[$j]["logroTrimestreActual"] / $r[$j]["metaTrimestreActual"] * 100);
					$sum3 = $sum3 + ($r[$j]["logroAnualActual"] / $r[$j]["metaAnualActual"] * 100);
				}
				if(count($r)>0) {
					$data['objetivos'][$i]["M"] = $sum1 / count($r);
					$data['objetivos'][$i]["T"] = $sum2 / count($r);
					$data['objetivos'][$i]["A"] = $sum3 / count($r);
					if($data['objetivos'][$i]["M"]>100)
						$data['objetivos'][$i]["M"]=100;
					if($data['objetivos'][$i]["T"]>100)
						$data['objetivos'][$i]["T"]=100;
					if($data['objetivos'][$i]["A"]>100)
						$data['objetivos'][$i]["A"]=100;
				}
				//echo "<br><br><br><br><br>".$data['objetivos'][$i]["id_item"];
			}


            pantalla('home',$data,Dinicio);
        }
        else {
            pantalla_error();
        }
    }
}
?>