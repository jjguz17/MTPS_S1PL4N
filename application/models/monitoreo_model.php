<?php

class Monitoreo_model extends CI_Model {
    
    function __construct() 
    {
        parent::__construct();
    }
	
	function buscar_jeraquia_nivel($id_item='NULL',$id_nivel='NULL',$nivel='1')
    {
        $sentencia="SELECT
                    NI.nom10 AS nom010,
                    NI.cor10 AS cor010,
                    NI.des10 AS des010,
                    NI.nom09,
                    NI.cor09,
                    NI.des09,
                    NI.nom08,
                    NI.cor08,
                    NI.des08,
                    NI.nom07,
                    NI.cor07,
                    NI.des07,
                    NI.nom06,
                    NI.cor06,
                    NI.des06,
                    NI.nom05,
                    NI.cor05,
                    NI.des05,
                    NI.nom04,
                    NI.cor04,
                    NI.des04,
                    NI.nom03,
                    NI.cor03,
                    NI.des03,
                    NI.nom02,
                    NI.cor02,
                    NI.des02,
                    NI.nom01,
                    NI.cor01,
                    NI.des01
                    FROM pat_niveles_items AS NI
                    WHERE IFNULL(NI.niv0".$nivel.",0)=IFNULL(".$id_nivel.",IFNULL(NI.niv0".$nivel.",0)) AND IFNULL(NI.ite0".$nivel.",0)=IFNULL(".$id_item.",IFNULL(NI.ite0".$nivel.",0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function buscar_nivel_item_actividad($id_documento='NULL', $id_seccion='NULL', $id_permiso=4, $mes='NULL', $anio='NULL')
	{	
        if($mes=='NULL')
           $mes=date('m', (strtotime ("-5 day")));
        
		$sentencia="SET SESSION group_concat_max_len = 100000000";
        $query=$this->db->query($sentencia); 
		$sentencia="SELECT
                    N2.nombre_nivel AS nombre_nivel_p,
                    N.nombre_nivel,
                    I2.id_item AS id_item_p,
                    I2.correlativo_item AS correlativo_item_p,
                    I2.descripcion_item AS descripcion_item_p,
                    I2.id_padre AS id_id_padre_p,
                    GROUP_CONCAT(I.id_item) AS id_item,
                    GROUP_CONCAT(I.descripcion_item,'**') AS descripcion_item,
                    GROUP_CONCAT(A.id_actividad) AS id_actividad,
                    GROUP_CONCAT(A.meta_actividad) AS meta_actividad,
                    GROUP_CONCAT(A.unidad_medida,'**') AS unidad_medida,
                    GROUP_CONCAT(A.meta_enero) AS meta_enero,
                    GROUP_CONCAT(A.meta_febrero) AS meta_febrero,
                    GROUP_CONCAT(A.meta_marzo) AS meta_marzo,
                    GROUP_CONCAT(A.meta_abril) AS meta_abril,
                    GROUP_CONCAT(A.meta_mayo) AS meta_mayo,
                    GROUP_CONCAT(A.meta_junio) AS meta_junio,
                    GROUP_CONCAT(A.meta_julio) AS meta_julio,
                    GROUP_CONCAT(A.meta_agosto) AS meta_agosto,
                    GROUP_CONCAT(A.meta_septiembre) AS meta_septiembre,
                    GROUP_CONCAT(A.meta_octubre) AS meta_octubre,
                    GROUP_CONCAT(A.meta_noviembre) AS meta_noviembre,
                    GROUP_CONCAT(A.meta_diciembre) AS meta_diciembre,
                    GROUP_CONCAT(A.recursos_actividad) AS recursos_actividad,
                    GROUP_CONCAT(A.observaciones_actividad,'**') AS observaciones_actividad,
                    GROUP_CONCAT(E.id_estado) AS id_estado,
                    GROUP_CONCAT(E.descripcion_estado) AS descripcion_estado,
                    GROUP_CONCAT(IFNULL(L.id_logro,' ')) AS id_logro,
                    GROUP_CONCAT(IFNULL(L.cantidad_logro,' ')) AS cantidad_logro,
                    GROUP_CONCAT(IFNULL(L.gasto_logro,' ')) AS gasto_logro,
                    GROUP_CONCAT(L.observaciones_logro,'**') AS observaciones_logro
                    FROM pat_item AS I
                    INNER JOIN pat_item AS I2 ON I2.id_item = I.id_padre
                    INNER JOIN pat_nivel AS N ON N.id_nivel = I.id_nivel
                    INNER JOIN pat_nivel AS N2 ON N2.id_nivel = I2.id_nivel
                    INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
                    INNER JOIN pat_estado_actividad AS EA ON EA.id_actividad = A.id_actividad
                    INNER JOIN pat_estado_actividad_actual AS EAA ON EAA.fecha_creacion = EA.fecha_creacion AND EAA.id_actividad = EA.id_actividad
                    INNER JOIN pat_estado AS E ON EA.id_estado = E.id_estado
                    LEFT JOIN pat_logro AS L ON L.id_actividad = A.id_actividad AND L.anio_logro=".$anio." AND L.mes_logro=".$mes."
                    WHERE IFNULL(A.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(A.id_seccion,0)) AND IFNULL(N.id_documento,0)=IFNULL(".$id_documento.",IFNULL(N.id_documento,0)) AND E.id_estado=3 AND (IFNULL(A.anio_meta,0) = IFNULL(".$anio.",IFNULL(A.anio_meta,0)))
                    GROUP BY I.id_padre";
        $query=$this->db->query($sentencia);
		
        $act=(array)$query->result_array();
        $tabla='';
        $C['01']='';
        $C['02']='';
        $C['03']='';
        $C['04']='';
        $C['05']='';
        $C['06']='';
        $C['07']='';
        $C['08']='';
        $C['09']='';
        $C['010']='';
        $tabla.='<div class="table-responsive"><table class=\'table table-bordered\'>';
        $band2=true;
        $band=true;
        foreach($act as $val_act) { 
            $ida=explode(",", $val_act['id_actividad']);
            $des=substr($val_act['descripcion_item'], 0, -2);
            $des=explode("**,", $des);
            $met=explode(",", $val_act['meta_actividad']);
            $med=substr($val_act['unidad_medida'], 0, -2);
            $med=explode("**,", $med);
            $ene=explode(",", $val_act['meta_enero']);
            $feb=explode(",", $val_act['meta_febrero']);
            $mar=explode(",", $val_act['meta_marzo']);
            $abr=explode(",", $val_act['meta_abril']);
            $may=explode(",", $val_act['meta_mayo']);
            $jun=explode(",", $val_act['meta_junio']);
            $jul=explode(",", $val_act['meta_julio']);
            $ago=explode(",", $val_act['meta_agosto']);
            $sep=explode(",", $val_act['meta_septiembre']);
            $oct=explode(",", $val_act['meta_octubre']);
            $nov=explode(",", $val_act['meta_noviembre']);
            $dic=explode(",", $val_act['meta_diciembre']);
            $rec=explode(",", $val_act['recursos_actividad']);
            $est=explode(",", $val_act['id_estado']);
            $obs=substr($val_act['observaciones_actividad'], 0, -2);
            $obs=explode("**,", $obs);

            $log=explode(",", $val_act['id_logro']);
            $can=explode(",", $val_act['cantidad_logro']);
            $gas=explode(",", $val_act['gasto_logro']);
            $obl=substr($val_act['observaciones_logro'], 0, -2);
            $obl=explode("**,", $obl);
            
            $niveles=$this->buscar_jeraquia_nivel($val_act['id_item_p']);

            for ($j=10; $j >1; $j--) { 
                if($niveles[0]['cor0'.$j]!="") {
                    if($C['0'.$j]!=$niveles[0]['cor0'.$j]) {
                        $tabla.='<tr class=\'cab cab'.$j.'\' ><td colspan=\'7\' style=\'text-align: left !important;\'>'.$niveles[0]['cor0'.$j].' '.$niveles[0]['des0'.$j].'</td></tr>';
                        $C['0'.$j]=$niveles[0]['cor0'.$j];
                    }
                }
            }
            if($band2) {
				//$m=date('m', (strtotime ("-5 day")));
				switch($mes) {
					case 1:
						$m="Enero";
						break;
					case 2:
						$m="Febrero";
						break;
					case 3:
						$m="Marzo";
						break;
					case 4:
						$m="Abril";
						break;
					case 5:
						$m="Mayo";
						break;
					case 6:
						$m="Junio";
						break;
					case 7:
						$m="Julio";
						break;
					case 8:
						$m="Agosto";
						break;
					case 9:
						$m="Septiembre";
						break;
					case 10:
						$m="Octubre";
						break;
					case 11:
						$m="Noviembre";
						break;
					case 12:
						$m="Diciembre";
				}
                /*if($id_permiso==3) {
                    $m2='<select class="form-control select" name="mes" id="mes" data-placeholder="[Seleccione..]">
                        <option value="1" '.((date('m', (strtotime ("-5 day")))==1)?"selected":"").'>Enero</option>
                        <option value="2" '.((date('m', (strtotime ("-5 day")))==2)?"selected":"").'>Febrero</option>
                        <option value="3" '.((date('m', (strtotime ("-5 day")))==3)?"selected":"").'>Marzo</option>
                        <option value="4" '.((date('m', (strtotime ("-5 day")))==4)?"selected":"").'>Abril</option>
                        <option value="5" '.((date('m', (strtotime ("-5 day")))==5)?"selected":"").'>Mayo</option>
                        <option value="6" '.((date('m', (strtotime ("-5 day")))==6)?"selected":"").'>Junio</option>
                        <option value="7" '.((date('m', (strtotime ("-5 day")))==7)?"selected":"").'>Julio</option>
                        <option value="8" '.((date('m', (strtotime ("-5 day")))==8)?"selected":"").'>Agosto</option>
                        <option value="9" '.((date('m', (strtotime ("-5 day")))==9)?"selected":"").'>Septiembre</option>
                        <option value="10" '.((date('m', (strtotime ("-5 day")))==10)?"selected":"").'>Octubre</option>
                        <option value="11" '.((date('m', (strtotime ("-5 day")))==11)?"selected":"").'>Noviembre</option>
                        <option value="12" '.((date('m', (strtotime ("-5 day")))==12)?"selected":"").'>Diciembre</option>
                    </select>';
                    $m=$m2;
                }*/
                $tabla.='<tr class=\'rowCab\'>';
                $tabla.='<td style=\'text-align: center !important;\' width=\'300\'><strong>'.(($act[0]['nombre_nivel_p']!="")?$act[0]['nombre_nivel_p']:"Proceso Padre").'</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' ><strong>'.(($act[0]['nombre_nivel']!="")?$act[0]['nombre_nivel']:"Proceso").'</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' width=\'80\'><strong>Meta del Mes</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' width=\'120\'><strong>Unidad de Medida</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' width=\'90\'><strong>Logros de '.$m.'</strong></td>';  
                $tabla.='<td style=\'text-align: center !important;\' width=\'80\'><strong>Porcentaje</strong></td>';    
                $tabla.='<td style=\'text-align: center !important;\' width=\'180\'><strong>Observaciones de los resultados</strong></td>';   
                $tabla.='</tr>';
                $band2=false;
            }
            for ($i=0; $i < count($des); $i++) { 
				//$m=date('m', (strtotime ("-5 day")));
				switch($mes) {
					case 1:
						$me=$ene[$i];
						break;
					case 2:
						$me=$feb[$i];
						break;
					case 3:
						$me=$mar[$i];
						break;
					case 4:
						$me=$abr[$i];
						break;
					case 5:
						$me=$may[$i];
						break;
					case 6:
						$me=$jun[$i];
						break;
					case 7:
						$me=$jul[$i];
						break;
					case 8:
						$me=$ago[$i];
						break;
					case 9:
						$me=$sep[$i];
						break;
					case 10:
						$me=$oct[$i];
						break;
					case 11:
						$me=$nov[$i];
						break;
					case 12:
						$me=$dic[$i];
				}
                if($band) {
                    $c='tr_even';
                    $band=false;
                }
                else {
                    $c='tr_odd';
                    $band=true;
                }
                $tabla.='<tr class=\''.$c.'\'>';
                if($i==0) {
                    $tabla.='<td rowspan=\''.(count($des)).'\' class=\'tr_even\'>'.$val_act['correlativo_item_p'].' '.$val_act['descripcion_item_p'].'</td>';
                }
                $tabla.='<td>'.$des[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.$me.'</td>';
                $tabla.='<td>'.$med[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>
                    <input type=\'hidden\' name=\'id_logro[]\' value=\''.$log[$i].'\'>
					<input type=\'hidden\' name=\'id_actividad[]\' value=\''.$ida[$i].'\'>
                    <input type=\'hidden\' class=\'logcam\' name=\'cambio[]\' value=\'0\'>
					<input type=\'text\' class=\'form-control logro\' onKeyUp=\'actualizar(this, '.$me.')\' name=\'logro[]\' value=\''.(($can[$i]!=0)?$can[$i]:"").'\'>					
				</td>';
				$tabla.='<td style=\'text-align: right !important;\' class=\'por\'>'.number_format($can[$i]/$me*100,0).'%</td>';
                $tabla.='<td>
                    <textarea class=\'form-control\' id=\'observaciones_logro\' onKeyUp=\'actualizar(this, -1)\' name=\'observaciones_logro[]\'>'.$obl[$i].'</textarea>
                </td>';
                $tabla.='</tr>';
            }
        }
        $tabla.='</table></div>';
        /*if(count($val_act)==0)
            $tabla.='<tr><td colspan=\'19\' style=\'text-align: center !important;\'>(No hay registros disponibles)</td></tr>';
        $tabla.='</table></div>';*/
        return $tabla;
	}

    function guardar_logro_actividad($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_logro
                    (id_actividad, mes_logro, anio_logro, cantidad_logro, gasto_logro, observaciones_logro, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_actividad, $mes_logro, $anio_logro, '$cantidad_logro', '$gasto_logro', '$observaciones_logro', '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_logro_actividad($formuInfo)
    {
        extract($formuInfo);
        $sentencia="UPDATE pat_logro SET
                    cantidad_logro='$cantidad_logro', gasto_logro='$gasto_logro', observaciones_logro='$observaciones_logro', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
                    WHERE id_logro=".$id_logro."";
        $this->db->query($sentencia);
    }
}
?>