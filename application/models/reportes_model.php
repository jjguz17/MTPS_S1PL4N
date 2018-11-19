<?php

class Reportes_model extends CI_Model {
    
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
	 
		switch($mes) {
			case 1:
				$m="Enero";
				$periodo="L.mes_logro=1";
				break;
			case 2:
				$m="Febrero";
				$periodo="L.mes_logro=2";
				break;
			case 3:
				$m="Marzo";
				$periodo="L.mes_logro=3";
				break;
			case 4:
				$m="Abril";
				$periodo="L.mes_logro=4";
				break;
			case 5:
				$m="Mayo";
				$periodo="L.mes_logro=5";
				break;
			case 6:
				$m="Junio";
				$periodo="L.mes_logro=6";
				break;
			case 7:
				$m="Julio";
				$periodo="L.mes_logro=7";
				break;
			case 8:
				$m="Agosto";
				$periodo="L.mes_logro=8";
				break;
			case 9:
				$m="Septiembre";
				$periodo="L.mes_logro=9";
				break;
			case 10:
				$m="Octubre";
				$periodo="L.mes_logro=10";
				break;
			case 11:
				$m="Noviembre";
				$periodo="L.mes_logro=11";
				break;
			case 12:
				$m="Diciembre";
				$periodo="L.mes_logro=12";
				break;
			case 13:
				$m="Evaluación 1er Trimestre";
				$periodo="(L.mes_logro=1 OR L.mes_logro=2 OR L.mes_logro=3)";
				break;
			case 14:
				$m="Evaluación 2do Trimestre";
				$periodo="(L.mes_logro=4 OR L.mes_logro=5 OR L.mes_logro=6)";
				break;
			case 15:
				$m="Evaluación 3er Trimestre";
				$periodo="(L.mes_logro=7 OR L.mes_logro=8 OR L.mes_logro=9)";
				break;
			case 16:
				$m="Evaluación 4to Trimestre";
				$periodo="(L.mes_logro=10 OR L.mes_logro=11 OR L.mes_logro=12)";
				break;
			default:
				$m="Evaluación Anual";
				$periodo="TRUE";
		}
		
		#$anio=2017;		        
		$sentencia="SET SESSION group_concat_max_len = 100000000";
        $query=$this->db->query($sentencia); 
		$sentencia="SELECT 
					tabla.nombre_nivel_p,
					tabla.nombre_nivel,
					tabla.id_item_p,
					tabla.correlativo_item_p,
					tabla.descripcion_item_p,
					tabla.id_id_padre_p,
					GROUP_CONCAT(tabla.id_item) AS id_item,
					GROUP_CONCAT(tabla.descripcion_item,'**') AS descripcion_item,
					GROUP_CONCAT(tabla.id_actividad) AS id_actividad,
					GROUP_CONCAT(tabla.meta_actividad) AS meta_actividad,
					GROUP_CONCAT(tabla.meta_enero+tabla.meta_febrero+tabla.meta_marzo) AS meta_1trimestre,
					GROUP_CONCAT(tabla.meta_abril+tabla.meta_mayo+tabla.meta_junio) AS meta_2trimestre,
					GROUP_CONCAT(tabla.meta_julio+tabla.meta_agosto+tabla.meta_septiembre) AS meta_3trimestre,
					GROUP_CONCAT(tabla.meta_octubre+tabla.meta_noviembre+tabla.meta_diciembre) AS meta_4trimestre,
					GROUP_CONCAT(tabla.unidad_medida,'**') AS unidad_medida,
					GROUP_CONCAT(tabla.meta_enero) AS meta_enero,
					GROUP_CONCAT(tabla.meta_febrero) AS meta_febrero,
					GROUP_CONCAT(tabla.meta_marzo) AS meta_marzo,
					GROUP_CONCAT(tabla.meta_abril) AS meta_abril,
					GROUP_CONCAT(tabla.meta_mayo) AS meta_mayo,
					GROUP_CONCAT(tabla.meta_junio) AS meta_junio,
					GROUP_CONCAT(tabla.meta_julio) AS meta_julio,
					GROUP_CONCAT(tabla.meta_agosto) AS meta_agosto,
					GROUP_CONCAT(tabla.meta_septiembre) AS meta_septiembre,
					GROUP_CONCAT(tabla.meta_octubre) AS meta_octubre,
					GROUP_CONCAT(tabla.meta_noviembre) AS meta_noviembre,
					GROUP_CONCAT(tabla.meta_diciembre) AS meta_diciembre,
					GROUP_CONCAT(tabla.recursos_actividad) AS recursos_actividad,
					GROUP_CONCAT(tabla.observaciones_actividad,'**') AS observaciones_actividad,
					GROUP_CONCAT(tabla.id_estado) AS id_estado,
					GROUP_CONCAT(tabla.descripcion_estado) AS descripcion_estado,
					GROUP_CONCAT(IFNULL(tabla.id_logro,0)) AS id_logro,
					GROUP_CONCAT(IFNULL(tabla.cantidad_logro,0)) AS cantidad_logro,
					GROUP_CONCAT(IFNULL(tabla.gasto_logro,0)) AS gasto_logro,
					GROUP_CONCAT(tabla.observaciones_logro,'**') AS observaciones_logro
					FROM (
						SELECT
						N2.nombre_nivel AS nombre_nivel_p,
						N.nombre_nivel,
						I2.id_item AS id_item_p,
						I2.correlativo_item AS correlativo_item_p,
						I2.descripcion_item AS descripcion_item_p,
						I2.id_padre AS id_id_padre_p,
						I.id_item,
						I.descripcion_item,
						A.id_actividad,
						A.meta_actividad,
						A.unidad_medida,
						A.meta_enero,
						A.meta_febrero,
						A.meta_marzo,
						A.meta_abril,
						A.meta_mayo,
						A.meta_junio,
						A.meta_julio,
						A.meta_agosto,
						A.meta_septiembre,
						A.meta_octubre,
						A.meta_noviembre,
						A.meta_diciembre,
						A.recursos_actividad,
						A.observaciones_actividad,
						E.id_estado,
						E.descripcion_estado,
						IFNULL(L.id_logro,' ') AS id_logro,
						SUM(IFNULL(L.cantidad_logro,0)) AS cantidad_logro,
						SUM(IFNULL(L.gasto_logro,0)) AS gasto_logro,
						GROUP_CONCAT(L.observaciones_logro) AS observaciones_logro
						FROM pat_item AS I
						INNER JOIN pat_item AS I2 ON I2.id_item = I.id_padre
						INNER JOIN pat_nivel AS N ON N.id_nivel = I.id_nivel
						INNER JOIN pat_nivel AS N2 ON N2.id_nivel = I2.id_nivel
						INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
						INNER JOIN pat_estado_actividad AS EA ON EA.id_actividad = A.id_actividad
						INNER JOIN pat_estado_actividad_actual AS EAA ON EAA.fecha_creacion = EA.fecha_creacion AND EAA.id_actividad = EA.id_actividad
						INNER JOIN pat_estado AS E ON EA.id_estado = E.id_estado
						LEFT JOIN pat_logro AS L ON L.id_actividad = A.id_actividad AND L.anio_logro=".$anio." AND ".$periodo."
                    	WHERE IFNULL(A.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(A.id_seccion,0)) AND IFNULL(N.id_documento,0)=IFNULL(".$id_documento.",IFNULL(N.id_documento,0)) AND E.id_estado=3 AND (IFNULL(A.anio_meta,0) = IFNULL(".$anio.",IFNULL(A.anio_meta,0)))
						GROUP BY I.id_item
					) AS tabla
					GROUP BY tabla.id_item_p";
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
        $tabla.='<div class=\'table-responsive\'><table class=\'table table-bordered\' cellpadding=\'0\' cellspacing=\'0\'>';
        $band2=true;
        $band=true;
        foreach($act as $val_act) { 
            $ida=explode(",", $val_act['id_actividad']);
            $des=substr($val_act['descripcion_item'], 0, -2);
            $des=explode("**,", $des);
            $met=explode(",", $val_act['meta_actividad']);
            $med=substr($val_act['unidad_medida'], 0, -2);
            $med=explode("**,", $med);
            $tri1=explode(",", $val_act['meta_1trimestre']);
            $tri2=explode(",", $val_act['meta_2trimestre']);
            $tri3=explode(",", $val_act['meta_3trimestre']);
            $tri4=explode(",", $val_act['meta_4trimestre']);
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

            for ($j=10; $j >=1; $j--) { 
                if($niveles[0]['cor0'.$j]!="") {
                    if($C['0'.$j]!=$niveles[0]['cor0'.$j]) {
                        $tabla.='<tr class=\'cab cab'.$j.'\' ><td colspan=\'5\' align=\'left\' style=\'text-align: left !important\'>'.$niveles[0]['cor0'.$j].' '.$niveles[0]['des0'.$j].'</td></tr>';
                        $C['0'.$j]=$niveles[0]['cor0'.$j];
                    }
                }
            }
            if($band2) {
				//$m=date('m', (strtotime ("-5 day")));
                $tabla.='<tr class=\'rowCab\'>';
                //$tabla.='<td align=\'center\' style=\'text-align: center !important\' width=\'300\'>'.(($act[0]['nombre_nivel_p']!="")?$act[0]['nombre_nivel_p']:"Proceso Padre").'</td>';
                $tabla.='<td align=\'center\' style=\'text-align: center !important; width: 400px;\' width=\'400\'>'.(($act[0]['nombre_nivel']!="")?$act[0]['nombre_nivel']:"Proceso").'</td>';
                $tabla.='<td align=\'center\' style=\'text-align: center !important\' width=\'80\'>PROGRAMADO</td>';
                $tabla.='<td align=\'center\' style=\'text-align: center !important\' width=\'90\'>LOGRADO</td>';  
                $tabla.='<td align=\'center\' style=\'text-align: center !important\' width=\'80\'>RESULTADO</td>';    
                $tabla.='<td align=\'center\' style=\'text-align: center !important\' width=\'180\'>OBSERVACIONES DE LOS RESULTADOS</td>';   
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
						break;
					case 13:
						$me=$tri1[$i];
						break;
					case 14:
						$me=$tri2[$i];
						break;
					case 15:
						$me=$tri3[$i];
						break;
					case 16:
						$me=$tri4[$i];
						break;
					default:
						$me=$met[$i];
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
                    //$tabla.='<td rowspan=\''.(count($des)).'\' class=\'tr_even\'>'.$val_act['correlativo_item_p'].' '.$val_act['descripcion_item_p'].'</td>';
                }
                $tabla.='<td align=\'left\' style=\'text-align: left !important\'>'.$des[$i].'</td>';
                $tabla.='<td align=\'right\' style=\'text-align: right !important\'>'.$me.'</td>';
                $tabla.='<td align=\'right\' style=\'text-align: right !important\'>'.(($can[$i]!="")?$can[$i]:"0").'				
				</td>';
				$tabla.='<td align=\'right\' style=\'text-align: right !important\' class=\'por\'><strong>'.number_format($can[$i]/$me*100,0).'%</strong></td>';
                $tabla.='<td>'.$obl[$i].'
                </td>';
                $tabla.='</tr>';
            }
        }
        $tabla.='</table></div>';
        /*if(count($val_act)==0)
            $tabla.='<tr><td colspan=\'19\' align=\'center\' style=\'text-align: right !important\'>(No hay registros disponibles)</td></tr>';
        $tabla.='</table></div>';*/
        return $tabla;
	}
	
	function objetivos($anio)
	{
		#$anio=2017;
		$sentencia="SELECT
					D.nombre_pei,
					I.correlativo_item,
					I.descripcion_item,
					N2.nombre_nivel,
					COUNT(DISTINCT I2.id_item) AS total,
					N3.nombre_nivel AS nombre_nivel2,
					COUNT(DISTINCT I3.id_item) AS total2,
					GROUP_CONCAT(DISTINCT I4.id_item) AS id_item,
					N4.nombre_nivel AS nombre_nivel3,
					COUNT(DISTINCT I4.id_item) AS total3,
					0 AS M,
					0 AS T,
					0 AS A
					FROM pat_nivel AS N
					LEFT JOIN pat_item AS I ON I.id_nivel = N.id_nivel
					LEFT JOIN pat_item AS I2 ON I2.id_padre = I.id_item
					LEFT JOIN pat_nivel AS N2 ON I2.id_nivel = N2.id_nivel
					LEFT JOIN pat_item AS I3 ON I3.id_padre = I2.id_item
					LEFT JOIN pat_nivel AS N3 ON I3.id_nivel = N3.id_nivel
					LEFT JOIN pat_item AS I4 ON I4.id_padre = I3.id_item
					LEFT JOIN pat_nivel AS N4 ON I4.id_nivel = N4.id_nivel
					LEFT JOIN pat_presupuesto AS P ON P.id_item = I4.id_item
					LEFT JOIN pat_item AS I5 ON I5.id_padre = P.id_item
					LEFT JOIN pat_documento AS D ON D.id_documento=N.id_documento
					WHERE N.nivel=1 AND N.tipo_nivel=1 AND P.anio=".$anio."
					GROUP BY I.id_item";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
	}
	
	function logros($anio, $actividades)
	{
		#$anio=2017;
		$sentencia="SELECT M.id_actividad, M.metaMesActual, M.logroMesActual, T.metaTrimestreActual, T.logroTrimestreActual, A.metaAnualActual, A.logroAnualActual
					FROM (
						SELECT
						A.id_actividad,
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN A.meta_enero
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN A.meta_febrero
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN A.meta_marzo
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN A.meta_abril
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN A.meta_mayo
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN A.meta_junio
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN A.meta_julio
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN A.meta_agosto
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN A.meta_septiembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN A.meta_octubre
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN A.meta_noviembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN A.meta_diciembre
						END AS metaMesActual,
						IFNULL(L.cantidad_logro, 0) AS logroMesActual
						FROM pat_item AS I
						INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
						LEFT JOIN pat_logro AS L ON L.id_actividad = A.id_actividad AND L.anio_logro = A.anio_meta AND L.mes_logro = MONTH(CURRENT_TIMESTAMP)
						WHERE CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN A.meta_enero
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN A.meta_febrero
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN A.meta_marzo
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN A.meta_abril
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN A.meta_mayo
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN A.meta_junio
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN A.meta_julio
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN A.meta_agosto
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN A.meta_septiembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN A.meta_octubre
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN A.meta_noviembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN A.meta_diciembre
						END > 0 AND A.anio_meta = ".$anio." AND I.id_padre IN (".$actividades.")
					) AS M
					INNER JOIN (
						SELECT
						A.id_actividad,
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 1 AND 3 THEN (A.meta_enero + A.meta_febrero + A.meta_marzo)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 4 AND 6 THEN (A.meta_abril + A.meta_mayo + A.meta_junio)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 7 AND 9 THEN (A.meta_julio + A.meta_agosto + A.meta_septiembre)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 10 AND 12 THEN (A.meta_octubre + A.meta_noviembre + A.meta_diciembre)
						END AS metaTrimestreActual,
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN SUM(IFNULL(L.cantidad_logro, 0)) * 3
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN SUM(IFNULL(L.cantidad_logro, 0)) + (SUM(IFNULL(L.cantidad_logro, 0)))/2
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN SUM(IFNULL(L.cantidad_logro, 0))
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN SUM(IFNULL(L.cantidad_logro, 0)) * 3
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN SUM(IFNULL(L.cantidad_logro, 0)) + (SUM(IFNULL(L.cantidad_logro, 0)))/2
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN SUM(IFNULL(L.cantidad_logro, 0))
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN SUM(IFNULL(L.cantidad_logro, 0)) * 3
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN SUM(IFNULL(L.cantidad_logro, 0)) + (SUM(IFNULL(L.cantidad_logro, 0)))/2
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN SUM(IFNULL(L.cantidad_logro, 0))
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN SUM(IFNULL(L.cantidad_logro, 0)) * 3
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN SUM(IFNULL(L.cantidad_logro, 0)) + (SUM(IFNULL(L.cantidad_logro, 0)))/2
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN SUM(IFNULL(L.cantidad_logro, 0))
						END logroTrimestreActual
						/*SUM(IFNULL(L.cantidad_logro, 0)) AS logroTrimestreActual*/
						FROM pat_item AS I
						INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
						LEFT JOIN pat_logro AS L ON L.id_actividad = A.id_actividad AND L.anio_logro = A.anio_meta AND L.mes_logro BETWEEN 
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 1 AND 3 THEN 1
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 4 AND 6 THEN 4
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 7 AND 9 THEN 7
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 10 AND 12 THEN 10
						END 
						AND 
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 1 AND 3 THEN 3
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 4 AND 6 THEN 6
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 7 AND 9 THEN 9
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 10 AND 12 THEN 12
						END
						WHERE CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 1 AND 3 THEN (A.meta_enero + A.meta_febrero + A.meta_marzo)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 4 AND 6 THEN (A.meta_abril + A.meta_mayo + A.meta_junio)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 7 AND 9 THEN (A.meta_julio + A.meta_agosto + A.meta_septiembre)
							WHEN MONTH(CURRENT_TIMESTAMP) BETWEEN 10 AND 12 THEN (A.meta_octubre + A.meta_noviembre + A.meta_diciembre)
						END > 0 AND A.anio_meta = ".$anio." AND I.id_padre IN (".$actividades.")
						GROUP BY A.id_actividad
					) AS T ON M.id_actividad = T.id_actividad
					INNER JOIN (
						SELECT
						A.id_actividad,
						/*CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN A.meta_enero
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN A.meta_enero + A.meta_febrero
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN A.meta_enero + A.meta_febrero + A.meta_marzo
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre + A.meta_noviembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre + A.meta_noviembre + A.meta_diciembre
						END AS metaAnualActual,*/
						A.meta_actividad AS metaAnualActual,
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN SUM(IFNULL(L.cantidad_logro, 0)) * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN SUM(IFNULL(L.cantidad_logro, 0))/2 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN SUM(IFNULL(L.cantidad_logro, 0))/3 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN SUM(IFNULL(L.cantidad_logro, 0))/4 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN SUM(IFNULL(L.cantidad_logro, 0))/5 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN SUM(IFNULL(L.cantidad_logro, 0))/6 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN SUM(IFNULL(L.cantidad_logro, 0))/7 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN SUM(IFNULL(L.cantidad_logro, 0))/8 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN SUM(IFNULL(L.cantidad_logro, 0))/9 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN SUM(IFNULL(L.cantidad_logro, 0))/10 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN SUM(IFNULL(L.cantidad_logro, 0))/11 * 12
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN SUM(IFNULL(L.cantidad_logro, 0))
						END logroAnualActual
						/*SUM(IFNULL(L.cantidad_logro, 0)) AS logroAnualActual*/
						FROM pat_item AS I
						INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
						LEFT JOIN pat_logro AS L ON L.id_actividad = A.id_actividad AND L.anio_logro = A.anio_meta AND L.mes_logro <= MONTH(CURRENT_TIMESTAMP)
						WHERE 
						CASE 
							WHEN MONTH(CURRENT_TIMESTAMP) = 1 THEN A.meta_enero
							WHEN MONTH(CURRENT_TIMESTAMP) = 2 THEN A.meta_enero + A.meta_febrero
							WHEN MONTH(CURRENT_TIMESTAMP) = 3 THEN A.meta_enero + A.meta_febrero + A.meta_marzo
							WHEN MONTH(CURRENT_TIMESTAMP) = 4 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril
							WHEN MONTH(CURRENT_TIMESTAMP) = 5 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo
							WHEN MONTH(CURRENT_TIMESTAMP) = 6 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio
							WHEN MONTH(CURRENT_TIMESTAMP) = 7 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio
							WHEN MONTH(CURRENT_TIMESTAMP) = 8 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto
							WHEN MONTH(CURRENT_TIMESTAMP) = 9 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 10 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre
							WHEN MONTH(CURRENT_TIMESTAMP) = 11 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre + A.meta_noviembre
							WHEN MONTH(CURRENT_TIMESTAMP) = 12 THEN A.meta_enero + A.meta_febrero + A.meta_marzo + A.meta_abril + A.meta_mayo + A.meta_junio + A.meta_julio + A.meta_agosto + A.meta_septiembre + A.meta_octubre + A.meta_noviembre + A.meta_diciembre
						END > 0 AND A.anio_meta = ".$anio." AND I.id_padre IN (".$actividades.")
						GROUP BY A.id_actividad
					) AS A ON M.id_actividad = A.id_actividad";
        $query=$this->db->query($sentencia);
		//echo "<pre>".$actividades."</pre>";
        return (array)$query->result_array();
	}



	//UFG 2018, Creando funciones para avance de logros

	function avance_pei_logros($anio, $mes='NULL', $id_seccion)
	{
		$sentencia = "select ifnull(actividad.id_seccion,0) as 'seccion', ifnull(actividad.meta,0) as 'meta', ifnull(logro.total,0) as 'realizado' from (select pat_actividad.id_seccion as id_seccion, pat_actividad.id_actividad";
		$logro_mes_evaluar = '';	
		if($mes == 'NULL')
		{
			$sentencia .= ",sum(ifnull(pat_actividad.meta_actividad),0) as 'meta' ";
			$logro_mes_evaluar .= " where ";
		}
		else if((int)$mes <=12)
		{
			$sentencia.=",sum(ifnull((
				case 
				when ". $mes."=1 then ifnull(pat_actividad.meta_enero,0)
				when ". $mes."=2 then ifnull(pat_actividad.meta_febrero,0)
				when ". $mes."=3 then ifnull(pat_actividad.meta_marzo,0)
				when ". $mes."=4 then ifnull(pat_actividad.meta_abril,0)
				when ". $mes."=5 then ifnull(pat_actividad.meta_mayo,0)
				when ". $mes."=6 then ifnull(pat_actividad.meta_junio,0)
				when ". $mes."=7 then ifnull(pat_actividad.meta_julio,0)
				when ". $mes."=8 then ifnull(pat_actividad.meta_agosto,0)
				when ". $mes."=9 then ifnull(pat_actividad.meta_septiembre,0)
				when ". $mes."=10 then ifnull(pat_actividad.meta_octubre,0)
				when ". $mes."=11 then ifnull(pat_actividad.meta_noviembre,0)
				when ". $mes."=12 then ifnull(pat_actividad.meta_diciembre,0)
				end 
			),0))as 'meta'";
			$logro_mes_evaluar .= " where pat_logro.mes_logro=".$mes." and ";
		}
		else if((int)$mes > 12)
		{
			$sentencia.=",sum(ifnull((
				case 
				when ". $mes."=13 then ifnull(pat_actividad.meta_enero,0) + ifnull(pat_actividad.meta_febrero,0) + ifnull(pat_actividad.meta_marzo,0)
				when ". $mes."=14 then ifnull(pat_actividad.meta_abril,0) + ifnull(pat_actividad.meta_mayo,0) + ifnull(pat_actividad.meta_junio,0)
				when ". $mes."=15 then ifnull(pat_actividad.meta_julio,0) + ifnull(pat_actividad.meta_agosto,0) + ifnull(pat_actividad.meta_septiembre,0)
				when ". $mes."=16 then ifnull(pat_actividad.meta_octubre,0) + ifnull(pat_actividad.meta_noviembre,0) + ifnull(pat_actividad.meta_diciembre,0)
				end 
			),0))as 'meta'";

			switch($mes)
			{
				case 13:
				$logro_mes_evaluar .= " where pat_logro.mes_logro >= 1 and pat_logro.mes_logro <= 3 and "; 
				break;
				case 14:
				$logro_mes_evaluar .= " where pat_logro.mes_logro >= 4 and pat_logro.mes_logro <= 6 and "; 
				break;
				case 15:
				$logro_mes_evaluar .= " where pat_logro.mes_logro >= 7 and pat_logro.mes_logro <= 9 and "; 
				break;
				case 16:
				$logro_mes_evaluar .= " where pat_logro.mes_logro >= 10 and pat_logro.mes_logro <= 12  and "; 
				break;
			}
		}
		 

		$sentencia.= " from pat_actividad where pat_actividad.id_seccion = ".$id_seccion." and pat_actividad.anio_meta=".$anio.") as actividad inner join (select pat_logro.id_actividad, sum(ifnull(pat_logro.cantidad_logro,0)) as 'total' from pat_logro ".$logro_mes_evaluar. " pat_logro.anio_logro= ".$anio." and pat_logro.id_actividad in(select pat_actividad.id_actividad as id_actividad from pat_actividad where pat_actividad.anio_meta=".$anio." and pat_actividad.id_seccion=".$id_seccion.")) as logro";

		return array('realizado' => $sentencia);
		$query = $this->db->query($sentencia);
			if($query->num_rows > 0)
			return array('realizado' => $sentencia);
			#return (array)$query->row();
			else return array(0,0);
	}
	
	/*
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
                    GROUP BY I.id_padre";*/
}
?>