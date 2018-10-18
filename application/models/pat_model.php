<?php

class Pat_model extends CI_Model {
    
    public $oficnas_departamentales=array(52,53,54,55,56,57,58,59,60,61,64); 

    public $oficnas_regionales=array(65,66); 
    
    function __construct() 
    {
        parent::__construct();
    }

    function es_oficina_departamental($id_seccion)
    {   
        if(in_array($id_seccion,$this->oficnas_departamentales)){
            return true;
        }
        else{
            return false;
        }
    }

    function es_oficina_regional($id_seccion)
    {   
        if(in_array($id_seccion,$this->oficnas_regionales)){
            return true;
        }
        else{
            return false;
        }
    }

    function buscar_items_padre_pat($id_documento='NULL', $id_seccion='NULL', $anio='NULL')
    {
        $where="";
        if($this->es_oficina_departamental($id_seccion)) { //Se verifica si el valor de $id_seccion si es oficina departamental
            $where.=" OR IFNULL(ISE.id_seccion,0)=IFNULL(10000,IFNULL(ISE.id_seccion,0))";
        }

        if($this->es_oficina_regional($id_seccion)) { //Se verifica si el valor de $id_seccion si es oficina regional
            $where.=" OR IFNULL(ISE.id_seccion,0)=IFNULL(10001,IFNULL(ISE.id_seccion,0))";
        }
        $sentencia="SELECT DISTINCT 
                    LOWER(D2.nombre_nivel) AS nombre_nivel_p,
                    LOWER(D.nombre_nivel) AS nombre_nivel,
					D.id_nivel AS id_nivel_a,
                    I.id_item,
                    I.id_nivel,
                    I.id_seccion,
                    I.correlativo_item,
                    I.descripcion_item,
                    I.id_padre
                    FROM pat_nivel AS D
                    LEFT JOIN pat_nivel AS D2 ON D2.id_nivel=D.id_padre
                    LEFT JOIN pat_item AS I ON I.id_nivel=D2.id_nivel
                    LEFT JOIN pat_item_seccion AS ISE ON ISE.id_item=I.id_item
                    LEFT JOIN pat_presupuesto AS P ON P.id_item = I.id_item
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0)) 
                    AND D.tipo_nivel=2 
                    AND (IFNULL(ISE.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(ISE.id_seccion,0))".$where.") 
                    AND (IFNULL(P.anio,0) = IFNULL(".$anio.",IFNULL(P.anio,0)))
                    ORDER BY I.id_nivel, I.id_padre";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array(); //Se retorna el obejto que contiene los registros en forma de array
    }
    
    function guardar_actividad($formuInfo)
    {
        extract($formuInfo); //Se extrae el array con la data que se va a guardar
        $sentencia="INSERT INTO pat_actividad
        (id_item, meta_actividad, unidad_medida, anio_meta, meta_enero, meta_febrero, meta_marzo, meta_abril, meta_mayo, meta_junio, meta_julio, meta_agosto, 
        meta_septiembre, meta_octubre, meta_noviembre, meta_diciembre, recursos_actividad, observaciones_actividad, id_seccion, fecha_creacion, id_usuario_crea) 
        VALUES 
        ($id_item, $meta_actividad, '$unidad_medida', $anio_meta, $meta_enero, $meta_febrero, $meta_marzo, $meta_abril, $meta_mayo, $meta_junio, $meta_julio, $meta_agosto, 
        $meta_septiembre, $meta_octubre, $meta_noviembre, $meta_diciembre, '$recursos_actividad', '$observaciones_actividad', $id_seccion, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id(); //Se retorna el id del registro que se acaba de almacenar
    }
	
	function guardar_estado_actividad($formuInfo)
	{
		extract($formuInfo);
        $sentencia="INSERT INTO pat_estado_actividad
                    (id_actividad, id_estado, observacion_estado_actividad, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_actividad, '$id_estado', '$observacion_estado_actividad', '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
	}
	
	function actualizar_actividad($formuInfo)
    {
        extract($formuInfo);
		$sentencia="UPDATE pat_actividad SET
					id_seccion=$id_seccion, id_item=$id_item, meta_actividad=$meta_actividad, unidad_medida='$unidad_medida', meta_enero=$meta_enero, meta_febrero=$meta_febrero, meta_marzo=$meta_marzo, meta_abril=$meta_abril, meta_mayo=$meta_mayo, meta_junio=$meta_junio, meta_julio=$meta_julio, meta_agosto=$meta_agosto, meta_septiembre=$meta_septiembre, meta_octubre=$meta_octubre, meta_noviembre=$meta_noviembre, meta_diciembre=$meta_diciembre, recursos_actividad='$recursos_actividad', observaciones_actividad='$observaciones_actividad', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
					WHERE id_actividad=".$id_actividad;
        $this->db->query($sentencia);
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
    
    function buscar_seccion_actividades($id_item='NULL') 
    {
        $sentencia="SELECT DISTINCT
                    ISE.id_seccion
                    FROM
                    pat_item_seccion AS ISE
                    WHERE IFNULL(ISE.id_item,0)=IFNULL(".$id_item.",IFNULL(ISE.id_item,0))";
        $query=$this->db->query($sentencia);
        $id_seccion=(array)$query->result_array();
        $where="";
        $od=$this->oficnas_departamentales;
        $or=$this->oficnas_regionales;
        foreach($id_seccion as $val) {
            if($val['id_seccion']=='10000') {
                for ($i=0; $i<count($od); $i++) { 
                    $where.=" OR id_seccion=".$od[$i];
                }
            }
            else {
                if($val['id_seccion']=='10001') {
                    for ($i=0; $i<count($or); $i++) { 
                        $where.=" OR id_seccion=".$or[$i];
                    }
                }
                else {
                    $where.=" OR id_seccion=".$val['id_seccion'];
                }

            }
        }
        $sentencia2="SELECT DISTINCT
                    id_seccion,
                    nombre_seccion
                    FROM
                    org_seccion
                    WHERE FALSE ".$where;
        $query2=$this->db->query($sentencia2);  
        return (array)$query2->result_array();
         

    }
    
    function buscar_seccion_documento($id_documento='NULL') 
    {
        $sentencia="SELECT DISTINCT
					ISE.id_seccion
					FROM pat_item_seccion AS ISE
					INNER JOIN pat_item AS I ON ISE.id_item = I.id_item
					INNER JOIN pat_nivel AS N ON I.id_nivel = N.id_nivel
                    WHERE IFNULL(N.id_documento,0)=IFNULL(".$id_documento.",IFNULL(N.id_documento,0))";
        $query=$this->db->query($sentencia);
        $id_seccion=(array)$query->result_array();
        $where="";
        $od=$this->oficnas_departamentales;
        $or=$this->oficnas_regionales;
        foreach($id_seccion as $val) {
            if($val['id_seccion']=='10000') {
                for ($i=0; $i<count($od); $i++) { 
                    $where.=" OR id_seccion=".$od[$i];
                }
            }
            else {
                if($val['id_seccion']=='10001') {
                    for ($i=0; $i<count($or); $i++) { 
                        $where.=" OR id_seccion=".$or[$i];
                    }
                }
                else {
                    $where.=" OR id_seccion=".$val['id_seccion'];
                }

            }
        }
        $sentencia2="SELECT DISTINCT
                    id_seccion,
                    nombre_seccion
                    FROM
                    org_seccion
                    WHERE FALSE ".$where;
        $query2=$this->db->query($sentencia2);  
        return (array)$query2->result_array();
    }
    
    function buscar_nivel_item_actividad_consulta($id_documento='NULL', $id_seccion='NULL', $anio_meta='NULL')
    {   
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
                    GROUP_CONCAT(E.descripcion_estado) AS descripcion_estado
                    FROM pat_item AS I
                    INNER JOIN pat_item AS I2 ON I2.id_item = I.id_padre
                    INNER JOIN pat_nivel AS N ON N.id_nivel = I.id_nivel
                    INNER JOIN pat_nivel AS N2 ON N2.id_nivel = I2.id_nivel
                    INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
                    INNER JOIN pat_estado_actividad AS EA ON EA.id_actividad = A.id_actividad
                    INNER JOIN pat_estado_actividad_actual AS EAA ON EAA.fecha_creacion = EA.fecha_creacion AND EAA.id_actividad = EA.id_actividad
                    INNER JOIN pat_estado AS E ON EA.id_estado = E.id_estado
                    WHERE IFNULL(A.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(A.id_seccion,0)) AND IFNULL(N.id_documento,0)=IFNULL(".$id_documento.",IFNULL(N.id_documento,0)) AND (E.id_estado=2 OR E.id_estado=3 OR E.id_estado=4) AND (IFNULL(A.anio_meta,0) = IFNULL(".$anio_meta.",IFNULL(A.anio_meta,0)))
                    GROUP BY I.id_padre";
        $query=$this->db->query($sentencia);
        //return (array)$query->result_array();

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
            
            $niveles=$this->buscar_jeraquia_nivel($val_act['id_item_p']);

            for ($j=10; $j >1; $j--) { 
                //$tabla.='<tr><td colspan=\'19\'>'.$C['0'.$j].' -- '.$niveles[0]['ite0'.$j].'</td></tr>';
                if($niveles[0]['cor0'.$j]!="") {
                    if($C['0'.$j]!=$niveles[0]['cor0'.$j]) {
                        $tabla.='<tr class=\'cab cab'.$j.'\' ><td colspan=\'19\' style=\'text-align: left !important;\'>'.$niveles[0]['cor0'.$j].' '.$niveles[0]['des0'.$j].'</td></tr>';
                        $C['0'.$j]=$niveles[0]['cor0'.$j];
                    }
                }
            }
            if($band2) {
                $tabla.='<tr class=\'rowCab\'>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>'.(($act[0]['nombre_nivel_p']!="")?$act[0]['nombre_nivel_p']:"Proceso Padre").'</strong></td>';
                //$tabla.='<td style=\'text-align: center !important; width:130px;\' rowspan=\'2\'><strong>Acción</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>'.(($act[0]['nombre_nivel']!="")?$act[0]['nombre_nivel']:"Proceso").'</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Meta</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Unidad de Medida</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' colspan=\'12\'><strong>Programación Anual</strong></td>';        
                $tabla.='<td style=\'text-align: center !important; width:80px;\' rowspan=\'2\'><strong>Recusros Financieros</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Observaciones</strong></td>';
                $tabla.='</tr>';
                $tabla.='<tr class=\'rowCab\'>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>E</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>F</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>M</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>A</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>M</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>J</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>J</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>A</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>S</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>O</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>N</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>D</strong></td>';
                $tabla.='</tr>';
                $band2=false;
            }
            for ($i=0; $i < count($des); $i++) { 
                if($band) {
                    $c='tr_even';
                    $band=false;
                }
                else {
                    $c='tr_odd';
                    $band=true;
                }
                $ch='';
                if($est[$i]==3)
                    $ch='checked';
                else
                    if($est[$i]!=4)
                        $ch='data-indeterminate=\'true\'';
                $tabla.='<tr class=\''.$c.'\'>';
                if($i==0) {
                    $tabla.='<td rowspan=\''.(count($des)).'\' width=\'200\' class=\'tr_even\'>'.$val_act['correlativo_item_p'].' '.$val_act['descripcion_item_p'].'</td>';
                }
                /*$tabla.='<td>
                    <input type=\'hidden\' name=\'id_actividad[]\' value=\''.$ida[$i].'\'>
                    <input type=\'hidden\' name=\'estadoa[]\' value=\''.$est[$i].'\'>
                    <input type=\'hidden\' name=\'estado[]\' class=\'est\'>
                    <input type=\'hidden\' name=\'observacion[]\' class=\'obs\'>
                    <input class=\'chka\' id=\'switch-indeterminate\' type=\'checkbox\' '.$ch.' data-on-text=\'Aprobar\' data-size=\'mini\' data-off-text=\'Rechazar\' data-label-width=\'0\' data-handle-width=\'55\' data-handle-height=\'100\' data-on-color=\'success\' data-off-color=\'danger\'>
                    <a title=\'Agregar Observación\' data-toggle=\'modal\' href=\'#modal2\' onClick=\'observaciones(this);return false;\' class=\'table-link view-row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-edit fa-stack-1x fa-inverse\'></i></span></a>
                </td>';*/
                $tabla.='<td>'.$des[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.$met[$i].'</td>';
                $tabla.='<td>'.$med[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($ene[$i]!=0)?$ene[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($feb[$i]!=0)?$feb[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($mar[$i]!=0)?$mar[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($abr[$i]!=0)?$abr[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($may[$i]!=0)?$may[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($jun[$i]!=0)?$jun[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($jul[$i]!=0)?$jul[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($ago[$i]!=0)?$ago[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($sep[$i]!=0)?$sep[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($oct[$i]!=0)?$oct[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($nov[$i]!=0)?$nov[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($dic[$i]!=0)?$dic[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($rec[$i]!=0)?"$ ".number_format($rec[$i],2):"").'</td>';
                $tabla.='<td>'.$obs[$i].'</td>';
                $tabla.='</tr>';
            }
        }
        $tabla.='</table></div>';
        /*if(count($val_act)==0)
            $tabla.='<tr><td colspan=\'19\' style=\'text-align: center !important;\'>(No hay registros disponibles)</td></tr>';
        $tabla.='</table></div>';*/
        return $tabla;
    }
	
	function buscar_nivel_item_actividad($id_documento='NULL', $id_seccion='NULL', $anio_meta='NULL')
	{	
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
                    GROUP_CONCAT(E.descripcion_estado) AS descripcion_estado
                    FROM pat_item AS I
                    INNER JOIN pat_item AS I2 ON I2.id_item = I.id_padre
                    INNER JOIN pat_nivel AS N ON N.id_nivel = I.id_nivel
                    INNER JOIN pat_nivel AS N2 ON N2.id_nivel = I2.id_nivel
                    INNER JOIN pat_actividad AS A ON A.id_item = I.id_item
                    INNER JOIN pat_estado_actividad AS EA ON EA.id_actividad = A.id_actividad
                    INNER JOIN pat_estado_actividad_actual AS EAA ON EAA.fecha_creacion = EA.fecha_creacion AND EAA.id_actividad = EA.id_actividad
                    INNER JOIN pat_estado AS E ON EA.id_estado = E.id_estado
                    WHERE IFNULL(A.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(A.id_seccion,0)) AND IFNULL(N.id_documento,0)=IFNULL(".$id_documento.",IFNULL(N.id_documento,0)) AND (E.id_estado=2 OR E.id_estado=3 OR E.id_estado=4) AND (IFNULL(A.anio_meta,0) = IFNULL(".$anio_meta.",IFNULL(A.anio_meta,0)))
                    GROUP BY I.id_padre";
        $query=$this->db->query($sentencia);
        //return (array)$query->result_array();
        echo $query."</br>";

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
            
            $niveles=$this->buscar_jeraquia_nivel($val_act['id_item_p']);

            for ($j=10; $j >1; $j--) { 
                //$tabla.='<tr><td colspan=\'19\'>'.$C['0'.$j].' -- '.$niveles[0]['ite0'.$j].'</td></tr>';
                if($niveles[0]['cor0'.$j]!="") {
                    if($C['0'.$j]!=$niveles[0]['cor0'.$j]) {
                        $tabla.='<tr class=\'cab cab'.$j.'\' ><td colspan=\'19\' style=\'text-align: left !important;\'>'.$niveles[0]['cor0'.$j].' '.$niveles[0]['des0'.$j].'</td></tr>';
                        $C['0'.$j]=$niveles[0]['cor0'.$j];
                    }
                }
            }
            if($band2) {
                $tabla.='<tr class=\'rowCab\'>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>'.(($act[0]['nombre_nivel_p']!="")?$act[0]['nombre_nivel_p']:"Proceso Padre").'</strong></td>';
                $tabla.='<td style=\'text-align: center !important; width:130px;\' rowspan=\'2\'><strong>Acción</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>'.(($act[0]['nombre_nivel']!="")?$act[0]['nombre_nivel']:"Proceso").'</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Meta</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Unidad de Medida</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' colspan=\'12\'><strong>Programación Anual</strong></td>';        
                $tabla.='<td style=\'text-align: center !important; width:80px;\' rowspan=\'2\'><strong>Recusros Financieros</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\' rowspan=\'2\'><strong>Observaciones</strong></td>';
                $tabla.='</tr>';
                $tabla.='<tr class=\'rowCab\'>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>E</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>F</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>M</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>A</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>M</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>J</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>J</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>A</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>S</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>O</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>N</strong></td>';
                $tabla.='<td style=\'text-align: center !important;\'><strong>D</strong></td>';
                $tabla.='</tr>';
                $band2=false;
            }
            for ($i=0; $i < count($des); $i++) { 
                if($band) {
                    $c='tr_even';
                    $band=false;
                }
                else {
                    $c='tr_odd';
                    $band=true;
                }
                $ch='';
                if($est[$i]==3)
                    $ch='checked';
                else
                    if($est[$i]!=4)
                        $ch='data-indeterminate=\'true\'';
                $tabla.='<tr class=\''.$c.'\'>';
                if($i==0) {
                    $tabla.='<td rowspan=\''.(count($des)).'\' width=\'200\' class=\'tr_even\'>'.$val_act['correlativo_item_p'].' '.$val_act['descripcion_item_p'].'</td>';
                }
                $tabla.='<td>
                    <input type=\'hidden\' name=\'id_actividad[]\' value=\''.$ida[$i].'\'>
                    <input type=\'hidden\' name=\'estadoa[]\' value=\''.$est[$i].'\'>
                    <input type=\'hidden\' name=\'estado[]\' class=\'est\'>
                    <input type=\'hidden\' name=\'observacion[]\' class=\'obs\'>
                    <input class=\'chka\' id=\'switch-indeterminate\' type=\'checkbox\' '.$ch.' data-on-text=\'Aprobar\' data-size=\'mini\' data-off-text=\'Rechazar\' data-label-width=\'0\' data-handle-width=\'55\' data-handle-height=\'100\' data-on-color=\'success\' data-off-color=\'danger\'>
                    <a title=\'Agregar Observación\' data-toggle=\'modal\' href=\'#modal2\' onClick=\'observaciones(this);return false;\' class=\'table-link view-row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-edit fa-stack-1x fa-inverse\'></i></span></a>
                </td>';
                $tabla.='<td>'.$des[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.$met[$i].'</td>';
                $tabla.='<td>'.$med[$i].'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($ene[$i]!=0)?$ene[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($feb[$i]!=0)?$feb[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($mar[$i]!=0)?$mar[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($abr[$i]!=0)?$abr[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($may[$i]!=0)?$may[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($jun[$i]!=0)?$jun[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($jul[$i]!=0)?$jul[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($ago[$i]!=0)?$ago[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($sep[$i]!=0)?$sep[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($oct[$i]!=0)?$oct[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($nov[$i]!=0)?$nov[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($dic[$i]!=0)?$dic[$i]:"").'</td>';
                $tabla.='<td style=\'text-align: right !important;\'>'.(($rec[$i]!=0)?"$ ".number_format($rec[$i],2):"").'</td>';
                $tabla.='<td>'.$obs[$i].'</td>';
                $tabla.='</tr>';
            }
        }
        $tabla.='</table></div>';
        /*if(count($val_act)==0)
            $tabla.='<tr><td colspan=\'19\' style=\'text-align: center !important;\'>(No hay registros disponibles)</td></tr>';
        $tabla.='</table></div>';*/
        return $tabla;
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
    
    function guardar_documento($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_documento
                    (nombre_pei, fecha_aprobacion, nombre_documento, inicio_periodo, fin_periodo, observacion, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ('$nombre_pei', '$fecha_aprobacion', '$nombre_documento', $inicio_periodo, $fin_periodo, '$observacion', '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function buscar_documentos($id_documento='NULL') 
    {
        $sentencia="SELECT 
                    D.id_documento,
					nombre_pei,
                    DATE_FORMAT(D.fecha_aprobacion,'%d/%m/%Y') AS fecha_aprobacion,
                    YEAR(D.fecha_aprobacion) AS A,
                    D.nombre_documento,
					D.inicio_periodo,
					D.fin_periodo,
                    D.observacion,
                    D.fecha_creacion,
                    D.id_usuario_crea,
                    D.fecha_modificacion,
                    D.id_usuario_modifica 
                    FROM pat_documento AS D
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
                    ORDER BY D.fecha_aprobacion DESC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
    
    function actualizar_documento($formuInfo)
    {
        extract($formuInfo);
        if($nombre_documento!="")
            $sentencia="UPDATE pat_documento SET
                        nombre_pei='$nombre_pei', fecha_aprobacion='$fecha_aprobacion', nombre_documento='$nombre_documento', inicio_periodo=$inicio_periodo, fin_periodo=$fin_periodo, observacion='$observacion', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
                        WHERE id_documento=".$id_documento;
        else
            $sentencia="UPDATE pat_documento SET
                        nombre_pei='$nombre_pei', fecha_aprobacion='$fecha_aprobacion', inicio_periodo=$inicio_periodo, fin_periodo=$fin_periodo, observacion='$observacion', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica 
                        WHERE id_documento=".$id_documento;
        $this->db->query($sentencia);
    }

    function eliminar_documento($id_documento=0)
    {
        $sentencia="DELETE FROM pat_documento WHERE id_documento=$id_documento";
        $this->db->query($sentencia);
    }

    function guardar_nivel($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_nivel
                    (id_documento, tipo_nivel, nivel, nombre_nivel, indicador, abreviacion, id_padre) 
                    VALUES 
                    ($id_documento, $tipo_nivel, $nivel, '$nombre_nivel', $indicador, '$abreviacion', $id_padre)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_nivel($formuInfo)
    {
        extract($formuInfo);
		$sentencia="UPDATE pat_nivel SET
                    nivel=$nivel, nombre_nivel='$nombre_nivel', indicador=$indicador, abreviacion='$abreviacion', id_padre=$id_padre
					WHERE id_nivel=$id_nivel";
        /*$sentencia="UPDATE pat_nivel SET
                    nombre_nivel='$nombre_nivel', indicador=$indicador, abreviacion='$abreviacion'
					WHERE id_documento=$id_documento AND nivel=$nivel AND id_padre=$id_padre";*/
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_nivel2($formuInfo)
    {
        extract($formuInfo);
		if($agrupar_numeracion=="")
			$agrupar_numeracion=0;
		if($agregar_separador=="")
			$agregar_separador=0;
		$sentencia="UPDATE pat_nivel SET
                    agrupar_numeracion=$agrupar_numeracion,
                    agregar_separador=$agregar_separador
					WHERE id_nivel=$id_nivel";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function buscar_nivel($id_documento='NULL', $tipo_nivel='NULL', $id_nivel='NULL') 
    {
        $sentencia="SELECT 
                    D.id_nivel,
                    D.id_documento,
					D.tipo_nivel,
                    D.nivel,
                    D.nombre_nivel,
					LOWER(D.nombre_nivel) AS nombre_nivel_l,
                    IF(D.indicador=1,'true','false') AS indicador,
                    D.abreviacion,
                    D.id_padre,
					IF(D.agrupar_numeracion=1,'checked=\"checked\"','') AS agrupar_numeracion,
					IF(D.agregar_separador=1,'checked=\"checked\"','') AS agregar_separador
                    FROM pat_nivel AS D
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
					AND IFNULL(D.tipo_nivel,0)=IFNULL(".$tipo_nivel.",IFNULL(D.tipo_nivel,0))
                    AND IFNULL(D.id_nivel,0)=IFNULL(".$id_nivel.",IFNULL(D.id_nivel,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function eliminar_nivel($id_documento=0)
    {
        $sentencia="DELETE FROM pat_nivel WHERE id_documento=$id_documento";
        $this->db->query($sentencia);
    }

    function buscar_items($id_documento='NULL', $id_nivel='NULL', $id_item='NULL', $id_padre='NULL', $id_seccion='NULL', $anio_meta='NULL') 
    {
        $sentencia="SELECT DISTINCT
					I.id_item,
					I.descripcion_item,
					CONCAT_WS(' ',A.meta_actividad,A.unidad_medida) AS meta,
					E.id_estado,
					E.descripcion_estado,
					D.id_documento,
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
					A.id_seccion,
					CASE WHEN EA.observacion_estado_actividad = '' THEN '(No hay observaciones)' ELSE EA.observacion_estado_actividad
					END AS observacion_estado_actividad
					FROM pat_nivel AS D
					INNER JOIN pat_item AS I ON I.id_nivel=D.id_nivel
					INNER JOIN pat_actividad AS A ON A.id_item=I.id_item
					INNER JOIN pat_estado_actividad AS EA ON EA.id_actividad=A.id_actividad
					INNER JOIN pat_estado_actividad_actual AS EAA ON EAA.fecha_creacion=EA.fecha_creacion AND EAA.id_actividad=EA.id_actividad 
					INNER JOIN pat_estado AS E ON E.id_estado=EA.id_estado
                    WHERE IFNULL(D.id_documento,0)=IFNULL(".$id_documento.",IFNULL(D.id_documento,0))
                    AND IFNULL(I.id_nivel,0)=IFNULL(".$id_nivel.",IFNULL(I.id_nivel,0))
                    AND IFNULL(I.id_item,0)=IFNULL(".$id_item.",IFNULL(I.id_item,0))
					AND IFNULL(I.id_padre,0)=IFNULL(".$id_padre.",IFNULL(I.id_padre,0))
                    AND IFNULL(A.id_seccion,0)=IFNULL(".$id_seccion.",IFNULL(A.id_seccion,0))
                    AND (IFNULL(A.anio_meta,0) = IFNULL(".$anio_meta.",IFNULL(A.anio_meta,0)))
					ORDER BY I.id_nivel, I.id_padre";
		//echo $sentencia;
        $query=$this->db->query($sentencia);
        return $query->result_array();
    }

    function historial_estado_actividad($id_actividad='NULL') 
    {
        $sentencia="SELECT 
                    DATE_FORMAT(EA.fecha_creacion,'%d/%m/%Y') AS fecha_creacion,
                    DATE_FORMAT(EA.fecha_creacion,'%h:%i %p') AS hora_creacion,
                    CASE WHEN DATE_FORMAT(EA.fecha_creacion,'%h')=1 THEN 'a la' ELSE 'a las' END AS t,
                    E.descripcion_estado,
                    U.nombre_completo,
                    EA.id_estado,
                    EA.observacion_estado_actividad
                    FROM pat_estado_actividad AS EA
                    INNER JOIN pat_estado AS E ON EA.id_estado=E.id_estado
                    INNER JOIN org_usuario AS U ON EA.id_usuario_crea=U.id_usuario
                    WHERE IFNULL(EA.id_actividad,0)=IFNULL(".$id_actividad.",IFNULL(EA.id_actividad,0))
                    ORDER BY EA.fecha_creacion DESC";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function guardar_wizard($formuInfo)
    {
        extract($formuInfo);
		if($id_seccion=="")
			$id_seccion="NULL";
        $sentencia="INSERT INTO pat_item
                    (id_nivel, id_seccion, correlativo_item, descripcion_item, id_padre, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_nivel, $id_seccion, '$correlativo_item', '$descripcion_item', $id_padre, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function eliminar_wizard($formuInfo)
    {
        extract($formuInfo);
        $sentencia="DELETE FROM pat_item WHERE id_item='$id_item'";
        $this->db->query($sentencia);
    }

    function actualizar_wizard($formuInfo)
    {
        extract($formuInfo);
		if($id_seccion=="")
			$id_seccion="NULL";
		$sentencia="UPDATE pat_item SET
                    id_padre=$id_padre, descripcion_item='$descripcion_item', fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_item='$id_item'";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }	
    
    function buscar_seccion() 
    {
        $sentencia="SELECT id_seccion, nombre_seccion FROM org_seccion
					UNION
					SELECT 10000 AS id_seccion, 'OFICINAS REGIONALES' AS nombre_seccion
					UNION
					SELECT 10001 AS id_seccion, 'OFICINAS DEPARTAMENTALES' AS nombre_seccion";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
	
	function buscar_presupuesto($id_item='NULL', $id_presupuesto='NULL') 
    {
        $sentencia="SELECT 
					id_presupuesto,
					id_item, 
					clasificacion_gasto, 
					CASE WHEN presupuesto=0 THEN NULL ELSE presupuesto END AS presupuesto, 
					anio 
					FROM pat_presupuesto
					WHERE IFNULL(id_presupuesto,0)=IFNULL(".$id_presupuesto.",IFNULL(id_presupuesto,0))
                    AND IFNULL(id_item,0)=IFNULL(".$id_item.",IFNULL(id_item,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }
	
	function buscar_unidades_apoyo($id_item='NULL') 
    {
        $sentencia="SELECT 
					ISE.id_item,
					ISE.id_seccion, 
					S.nombre_seccion, 
					ISE.id_tipo_apoyo
					FROM pat_item_seccion AS ISE
					INNER JOIN (
					SELECT id_seccion, nombre_seccion FROM org_seccion
					UNION
					SELECT 10000, 'OFICINAS REGIONALES'
					UNION
					SELECT 10001, 'OFICINAS DEPARTAMENTALES'
					) AS S ON S.id_seccion=ISE.id_seccion
					WHERE IFNULL(id_item,0)=IFNULL(".$id_item.",IFNULL(id_item,0))";
        $query=$this->db->query($sentencia);
        return (array)$query->result_array();
    }

    function guardar_presupuesto($formuInfo)
    {
        extract($formuInfo);
        $sentencia="INSERT INTO pat_presupuesto
                    (id_item, clasificacion_gasto, presupuesto, anio, fecha_creacion, id_usuario_crea) 
                    VALUES 
                    ($id_item, '$clasificacion_gasto', $presupuesto, $anio, '$fecha_creacion', $id_usuario_crea)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function actualizar_presupuesto($formuInfo)
    {
        extract($formuInfo);
		$sentencia="UPDATE pat_presupuesto SET
                    clasificacion_gasto='$clasificacion_gasto', presupuesto=$presupuesto, anio=$anio, fecha_modificacion='$fecha_modificacion', id_usuario_modifica=$id_usuario_modifica
					WHERE id_presupuesto=$id_presupuesto";
        $this->db->query($sentencia);
        return $this->db->insert_id();
    }

    function eliminar_presupuesto($formuInfo)
    {
        extract($formuInfo);
        $sentencia="DELETE FROM pat_presupuesto WHERE id_presupuesto=$id_presupuesto";
        $this->db->query($sentencia);
    }
	
	function guardar_item_seccion($formuInfo)
	{
        extract($formuInfo);
        $sentencia="INSERT INTO pat_item_seccion
                    (id_item, id_seccion, id_tipo_apoyo) 
                    VALUES 
                    ($id_item, $id_seccion, $id_tipo_apoyo)";
        $this->db->query($sentencia);
        return $this->db->insert_id();
	}
	
	function eliminar_item_seccion($id_item)
	{
        extract($formuInfo);
        $sentencia="DELETE FROM pat_item_seccion WHERE id_item=$id_item";
        $this->db->query($sentencia);
	}
}
?>