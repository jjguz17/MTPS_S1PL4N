<?php

class Usuario_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	
	function mostrar_menu($id_rol=NULL)
	{
		$sentencia="SELECT id_modulo, id_permiso FROM org_rol_modulo_permiso WHERE estado=1 AND id_rol='".$id_rol."'";
		$query=$this->db->query($sentencia);
		$m=(array)$query->result_array();
		$id_mod=array();
		$id_per=array();
		foreach($m as $val) { 
			$id_mod[]=$val['id_modulo'];
			$id_per[]=$val['id_permiso'];
		}
		$sentencia="SELECT id_sistema, nombre_sistema FROM org_sistema WHERE id_sistema=10";
		$query0=$this->db->query($sentencia);
		$m0=(array)$query0->result_array();
		$result='';
		foreach($m0 as $val0) { 
			$id_sistema=$val0['id_sistema'];
			$nombre_sistema=$val0['nombre_sistema'];
			$result.='<div id="MainMenu'.$id_sistema.'"><div class="list-group">';
			$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo, opciones_modulo FROM org_modulo where (dependencia IS NULL OR dependencia = 0) AND id_modulo<>77 AND id_sistema=".$id_sistema." ORDER BY orden";
			$query1=$this->db->query($sentencia);
			$m1=(array)$query1->result_array();
			
			foreach($m1 as $val1) { 
				$id_modulo=$val1['id_modulo'];
				$nombre_modulo=$val1['nombre_modulo'];
				$descripcion_modulo=$val1['descripcion_modulo'];
				$opciones_modulo=$val1['opciones_modulo'];
				
				$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo, opciones_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
				$query2=$this->db->query($sentencia);
				$m2=(array)$query2->result_array();
				
				if($query2->num_rows>0) {
					$expanded='collapse';
					for($i=0;$i<count($id_mod);$i++) {
						$ancestros=$this->buscar_padre_permisos_rol($id_mod[$i]);
						if($id_modulo==$ancestros['padre'] || $id_modulo==$ancestros['abuelo'] || $id_modulo==$ancestros['bisabuelo'])
							$expanded='';
					}
					$result.='<a href="#demo'.$id_modulo.'" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu'.$id_sistema.'">'.$nombre_modulo."</a>";
				}
				else {
					$result.='<a href="javascript:;" title="'.$descripcion_modulo.'" class="list-group-item" data-parent="#MainMenu'.$id_sistema.'"><div class="form-group" style="margin-bottom: 0px;"><label for="nombre_rol" class="col-sm-4 control-label">'.$nombre_modulo."</label>";
					$clave='';
					$clave=array_search($id_modulo, $id_mod);
					$op1='';
					$op2='';
					$op3='';
					$op4='';
					$x='';
					if($clave!==FALSE) {
						switch($id_per[$clave]) {
							case 1:
								$x=1;
								$op1='selected="selected"';
								break;
							case 2:
								$x=2;
								$op2='selected="selected"';
								break;
							case 3:
								$x=3;
								$op3='selected="selected"';
								break;
							case 4:
								$x=4;
								$op4='selected="selected"';
								break;
						}
					}
					$op='';
					if($opciones_modulo>=1) 
 						$op='<option value="'.$id_modulo.',3" '.$op3.'>Nacional</option>'.$op;
					if($opciones_modulo>=2) 
 						$op='<option value="'.$id_modulo.',4" '.$op4.'>Departamental</option>'.$op;
					if($opciones_modulo>=3) 
 						/*$op='<option value="'.$id_modulo.',2" '.$op2.'>Sección</option>'.$op;
					if($opciones_modulo>=4)*/
 						$op='<option value="'.$id_modulo.',1" '.$op1.'>Personal</option>'.$op;
					$result.='<div class="col-sm-4"><select style="width:150px" class="oculto select_rol" name="permiso[]" data-placeholder="[Seleccione...]"><option value=""></option>'.$op.'</select></div></div>';
				}	
				
				if($query2->num_rows>0)
					$result.='<div class="'.$expanded.'" id="demo'.$id_modulo.'">';
				
				foreach($m2 as $val2) {
					$id_modulo=$val2['id_modulo'];
					$nombre_modulo=$val2['nombre_modulo'];
					$descripcion_modulo=$val2['descripcion_modulo'];
					$opciones_modulo=$val2['opciones_modulo'];
					
					$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo, opciones_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
					$query3=$this->db->query($sentencia);
					$m3=(array)$query3->result_array();
					
					if($query3->num_rows>0){
						$expanded='collapse';
						for($i=0;$i<count($id_mod);$i++) {
							$ancestros=$this->buscar_padre_permisos_rol($id_mod[$i]);
							if($id_modulo==$ancestros['padre'] || $id_modulo==$ancestros['abuelo'] || $id_modulo==$ancestros['bisabuelo'])
								$expanded='';
						}
						$result.='<a href="#demo'.$id_modulo.'" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#demo'.$val1['id_modulo'].'">'.$nombre_modulo."</a>";
					}
					else {
						$result.='<a href="javascript:;" title="'.$descripcion_modulo.'" class="list-group-item" data-parent="#demo'.$val1['id_modulo'].'"><div class="form-group" style="margin-bottom: 0px;"><label for="nombre_rol" class="col-sm-4 control-label">'.$nombre_modulo."</label>";
						$clave='';
						$clave=array_search($id_modulo, $id_mod);
						$op1='';
						$op2='';
						$op3='';
						$op4='';
						$x='';
						if($clave!==FALSE) {
							switch($id_per[$clave]){
								case 1:
									$x=1;
									$op1='selected="selected"';
									break;
								case 2:
									$x=2;
									$op2='selected="selected"';
									break;
								case 3:
									$x=3;
									$op3='selected="selected"';
									break;
								case 4:
									$x=4;
									$op4='selected="selected"';
									break;
							}
						}
						$op='';
						if($opciones_modulo>=1) 
							$op='<option value="'.$id_modulo.',3" '.$op3.'>Nacional</option>'.$op;
						if($opciones_modulo>=2) 
							$op='<option value="'.$id_modulo.',4" '.$op4.'>Departamental</option>'.$op;
						if($opciones_modulo>=3) 
							/*$op='<option value="'.$id_modulo.',2" '.$op2.'>Sección</option>'.$op;
						if($opciones_modulo>=4)*/
							$op='<option value="'.$id_modulo.',1" '.$op1.'>Personal</option>'.$op;
						$result.='<div class="col-sm-4"><select style="width:150px" class="oculto select_rol" name="permiso[]" data-placeholder="[Seleccione...]"><option value=""></option>'.$op.'</select></div></div>';
					}
					
					if($query3->num_rows>0)
						$result.='<div class="'.$expanded.'" id="demo'.$id_modulo.'">';
					
					foreach($m3 as $val3) {
						$id_modulo=$val3['id_modulo'];
						$nombre_modulo=$val3['nombre_modulo'];
						$descripcion_modulo=$val3['descripcion_modulo'];
						$opciones_modulo=$val3['opciones_modulo'];
						
						$result.='<a href="javascript:;" title="'.$descripcion_modulo.'" class="list-group-item" data-parent="#demo'.$val2['id_modulo'].'"><div class="form-group" style="margin-bottom: 0px;"><label for="nombre_rol" class="col-sm-4 control-label">'.$nombre_modulo."</label>";
						$clave='';
						$clave=array_search($id_modulo, $id_mod);
						$op1='';
						$op2='';
						$op3='';
						$op4='';
						$x='';
						if($clave!==FALSE) {
							switch($id_per[$clave]){
								case 1:
									$x=1;
									$op1='selected="selected"';
									break;
								case 2:
									$x=2;
									$op2='selected="selected"';
									break;
								case 3:
									$x=3;
									$op3='selected="selected"';
									break;
								case 4:
									$x=4;
									$op4='selected="selected"';
									break;
							}
						}
						$op='';
						if($opciones_modulo>=1) 
							$op='<option value="'.$id_modulo.',3" '.$op3.'>Nacional</option>'.$op;
						if($opciones_modulo>=2) 
							$op='<option value="'.$id_modulo.',4" '.$op4.'>Departamental</option>'.$op;
						if($opciones_modulo>=3) 
							/*$op='<option value="'.$id_modulo.',2" '.$op2.'>Sección</option>'.$op;
						if($opciones_modulo>=4)*/ 
							$op='<option value="'.$id_modulo.',1" '.$op1.'>Personal</option>'.$op;
						$result.='<div class="col-sm-4"><select style="width:150px" class="oculto select_rol" name="permiso[]" data-placeholder="[Seleccione...]"><option value=""></option>'.$op.'</select></div></div>';
						$result.=' </a>';				
					}
					$result.=' </a>';
					if($query3->num_rows>0)
						$result.=' </div>';
				}
				$result.=' </a>';
				if($query2->num_rows>0)
					$result.=' </div>';
			}
			$result.='</div></div>';
		}
		return $result;
	}
	
	function guardar_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_rol
					(nombre_rol, descripcion_rol) 
					VALUES 
					('$nombre_rol', '$descripcion_rol')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function guardar_permisos_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_rol_modulo_permiso
					(id_rol, id_modulo, id_permiso, estado) 
					VALUES 
					('$id_rol', '$id_modulo', '$id_permiso', '$estado')";
		$this->db->query($sentencia);
	}
	
	function consultar_oficinas($id_seccion=NULL)
	{
		if($id_seccion!=NULL) {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador")
			);
		}
		else {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador"),
				array("id_ofi"=>1,"nom_ofi"=>"Oficina Departamental Ahuachapán"),
				array("id_ofi"=>2,"nom_ofi"=>"Oficina Departamental Cabañas"),
				array("id_ofi"=>3,"nom_ofi"=>"Oficina Departamental Chalatenango"),
				array("id_ofi"=>4,"nom_ofi"=>"Oficina Departamental Cuscatlán"),
				array("id_ofi"=>5,"nom_ofi"=>"Oficina Departamental La Libertad"),
				array("id_ofi"=>6,"nom_ofi"=>"Oficina Departamental La Unión"),
				array("id_ofi"=>7,"nom_ofi"=>"Oficina Departamental Morazán"),
				array("id_ofi"=>8,"nom_ofi"=>"Oficina Departamental San Miguel"),
				array("id_ofi"=>10,"nom_ofi"=>"Oficina Departamental San Vicente"),
				array("id_ofi"=>11,"nom_ofi"=>"Oficina Departamental Santa Ana"),
				array("id_ofi"=>12,"nom_ofi"=>"Oficina Departamental Sonsonate"),
				array("id_ofi"=>13,"nom_ofi"=>"Oficina Departamental Usulután"),
				array("id_ofi"=>14,"nom_ofi"=>"Oficina Departamental Zacatecoluca")
			);
		}
		return $oficinas;
	}
	
	function empleados_sin_usuario($id_seccion=NULL)
	{
		if($id_seccion!=NULL)
			$where_seccion="AND sir_empleado_informacion_laboral.id_seccion=".$id_seccion;
		else
			$where_seccion="";
		$sentencia="SELECT DISTINCT
					sir_empleado.id_empleado,
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
					FROM
					sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado_informacion_laboral.id_empleado = sir_empleado.id_empleado
					WHERE sir_empleado.nr NOT IN (SELECT nr FROM org_usuario WHERE nr IS NOT NULL AND nr<>'') ".$where_seccion;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function mostrar_roles($id_rol=NULL)
	{
		if($id_rol!=NULL)
			$where_rol=" WHERE id_rol=".$id_rol;
		else
			$where_rol="";
		$sentencia="SELECT id_rol, LOWER(nombre_rol) AS nombre_rol, descripcion_rol FROM org_rol".$where_rol." ORDER BY id_rol DESC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function info_adicional($id_empleado)
	{
		$sentencia="SELECT
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre,
					LOWER(CONCAT_WS('.',primer_nombre, primer_apellido)) AS usuario,
					sir_empleado.nr,
					sir_empleado.id_genero,
					sir_empleado_informacion_laboral.id_seccion
					FROM sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado_informacion_laboral.id_empleado = sir_empleado.id_empleado 
					WHERE sir_empleado.id_empleado='".$id_empleado."'
					ORDER BY id_empleado_informacion_laboral DESC LIMIT 0,1";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function guardar_usuario($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_usuario
					(nombre_completo, password, nr, sexo, usuario, id_seccion, estado) 
					VALUES 
					('$nombre_completo', '$password', '$nr', '$sexo', '$usuario', '$id_seccion', '$estado')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function guardar_permisos_usuario($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_usuario_rol
					(id_rol, id_usuario) 
					VALUES 
					('$id_rol', '$id_usuario')";
		$this->db->query($sentencia);
	}
	
	function buscar_padre_permisos_rol($id_modulo)
	{
		$sentencia="SELECT
					m4.id_modulo AS bisabuelo,
					m3.id_modulo AS abuelo,
					m2.id_modulo AS padre
					FROM
					org_modulo AS m1
					LEFT JOIN org_modulo AS m2 ON m2.id_modulo = m1.dependencia
					LEFT JOIN org_modulo AS m3 ON m3.id_modulo = m2.dependencia
					LEFT JOIN org_modulo AS m4 ON m4.id_modulo = m3.dependencia
					WHERE m1.id_modulo=".$id_modulo;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function buscar_padre_modulo_rol($id_rol,$id_modulo)
	{
		$sentencia="SELECT count(*) AS total FROM org_rol_modulo_permiso WHERE id_modulo=".$id_modulo." AND id_rol=".$id_rol."";
		$query=$this->db->query($sentencia);
	
		/*return $query->num_rows;*/
		return (array)$query->row();
	}
	
	function eliminar_permisos_rol($id_rol)
	{
		$sentencia="DELETE FROM org_rol_modulo_permiso where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function eliminar_rol($id_rol)
	{
		$sentencia="DELETE FROM org_rol where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function actualizar_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE org_rol SET nombre_rol='$nombre_rol', descripcion_rol='$descripcion_rol' where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function mostrar_usuarios($id_usuario=NULL,$id_seccion=NULL,$val=NULL)
	{
		if($id_usuario!=NULL)
			$where_usuario=" AND org_usuario.id_usuario=".$id_usuario;
		else
			$where_usuario="";
		if($id_seccion!=NULL)
			$where_seccion=" AND sir_empleado_informacion_laboral.id_seccion=".$id_seccion;
		else
			$where_seccion="";
		if($val!=NULL)
			$g=" GROUP BY org_usuario.id_usuario";
		$sentencia="SELECT DISTINCT
					org_usuario.id_usuario,
					nombre_completo,
					usuario,
					id_rol
					FROM
					org_usuario
					INNER JOIN sir_empleado ON org_usuario.nr = sir_empleado.nr 
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado.id_empleado = sir_empleado_informacion_laboral.id_empleado 
					LEFT JOIN org_usuario_rol ON org_usuario_rol.id_usuario = org_usuario.id_usuario WHERE org_usuario.estado=1 ".$where_seccion.$where_usuario.$g;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_permisos_usuario($id_usuario)
	{
		$sentencia="DELETE FROM org_rol_modulo_permiso where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function eliminar_usuario($id_usuario)
	{
		$sentencia="DELETE FROM org_usuario where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function desactivar_usuario($id_usuario)
	{
		$sentencia="UPDATE org_usuario SET estado=0 where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	function buscar_correos($id_solicitud_transporte=NULL, $id_modulo=NULL)
	{
		$sentencia="SELECT e.nombre, e.correo, e.nominal
					FROM tcm_empleado AS e
					INNER JOIN org_usuario_rol AS ur ON ur.id_usuario=e.id_usuario
					INNER JOIN org_rol AS r ON r.id_rol=ur.id_rol
					INNER JOIN org_rol_modulo_permiso AS rm ON rm.id_rol=r.id_rol AND (rm.id_permiso>=2 AND rm.id_modulo='".$id_modulo."') AND rm.id_permiso<>3
					INNER JOIN org_modulo AS m ON m.id_modulo=rm.id_modulo AND m.id_sistema=10
					INNER JOIN	
						(SELECT e.id_seccion
						FROM tcm_empleado AS e
						INNER JOIN tcm_solicitud_transporte AS s ON s.id_empleado_solicitante=e.id_empleado
						WHERE id_solicitud_transporte='".$id_solicitud_transporte."') AS s
					ON s.id_seccion=e.id_seccion
					WHERE e.correo NOT LIKE ''
					GROUP BY id_empleado;";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			$sentencia="SELECT e.nombre, e.correo, e.nominal
						FROM tcm_empleado AS e
						INNER JOIN org_usuario_rol AS ur ON ur.id_usuario=e.id_usuario
						INNER JOIN org_rol AS r ON r.id_rol=ur.id_rol
						INNER JOIN org_rol_modulo_permiso AS rm ON rm.id_rol=r.id_rol AND (rm.id_permiso=4 AND rm.id_modulo='".$id_modulo."') AND rm.id_permiso<>3
						INNER JOIN org_modulo AS m ON m.id_modulo=rm.id_modulo AND m.id_sistema=10
						INNER JOIN	
							(SELECT e.id_seccion
							FROM tcm_empleado AS e
							INNER JOIN tcm_solicitud_transporte AS s ON s.id_empleado_solicitante=e.id_empleado
							WHERE id_solicitud_transporte='".$id_solicitud_transporte."') AS s
						ON s.id_seccion NOT BETWEEN 52 AND 66
						WHERE e.correo NOT LIKE ''
						GROUP BY id_empleado;";
			$query=$this->db->query($sentencia);
			if($query->num_rows>0) {
				return (array)$query->result_array();
			}
			else {
				$sentencia="SELECT e.nombre, e.correo, e.nominal
							FROM tcm_empleado AS e
							INNER JOIN org_usuario_rol AS ur ON ur.id_usuario=e.id_usuario
							INNER JOIN org_rol AS r ON r.id_rol=ur.id_rol
							INNER JOIN org_rol_modulo_permiso AS rm ON rm.id_rol=r.id_rol AND rm.id_permiso=3 AND rm.id_modulo='".$id_modulo."'
							INNER JOIN org_modulo AS m ON m.id_modulo=rm.id_modulo AND m.id_sistema=10
							INNER JOIN	
								(SELECT e.id_seccion
								FROM tcm_empleado AS e
								INNER JOIN tcm_solicitud_transporte AS s ON s.id_empleado_solicitante=e.id_empleado
								WHERE id_solicitud_transporte='".$id_solicitud_transporte."') AS s
							ON s.id_seccion IS NULL
							WHERE e.correo NOT LIKE ''
							GROUP BY id_empleado;";
				$query=$this->db->query($sentencia);
				return (array)$query->result_array();
			}
		}
	}
	
	function buscar_correo($id_solicitud_transporte)
	{
		$sentencia="SELECT 
					tcm_empleado.nombre, 
					tcm_empleado.correo, 
					tcm_empleado.nominal, 
					DATE_FORMAT(fecha_mision,'%d-%m-%Y') AS fecha_mision,
					tcm_solicitud_transporte.estado_solicitud_transporte AS estado,
					tcm_observacion.observacion AS observacion
					FROM tcm_empleado
					INNER JOIN tcm_solicitud_transporte ON tcm_empleado.id_empleado = tcm_solicitud_transporte.id_empleado_solicitante
					LEFT JOIN tcm_observacion ON tcm_observacion.id_solicitud_transporte = tcm_solicitud_transporte.id_solicitud_transporte AND tcm_observacion.quien_realiza=2
					WHERE tcm_solicitud_transporte.id_solicitud_transporte='".$id_solicitud_transporte."';";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function eliminar_roles_usuario($id_usuario)
	{
		$sentencia="DELETE FROM org_usuario_rol where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function actualizar_usuario($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE org_usuario SET password='$password' where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function realizar_busqueda($id_usuario,$buscar)
	{
		$sentencia="SELECT DISTINCT
					m2.nombre_modulo AS padre,
					org_modulo.nombre_modulo AS nombre,
					org_modulo.descripcion_modulo AS descripcion,
					org_modulo.url_modulo AS url
					FROM org_rol
					INNER JOIN org_usuario_rol ON org_rol.id_rol = org_usuario_rol.id_rol
					INNER JOIN org_rol_modulo_permiso ON org_rol_modulo_permiso.id_rol = org_rol.id_rol
					INNER JOIN org_modulo ON org_modulo.id_modulo = org_rol_modulo_permiso.id_modulo
					INNER JOIN org_modulo AS m2 ON m2.id_modulo = org_modulo.dependencia
					WHERE org_usuario_rol.id_usuario=".$id_usuario." AND org_modulo.id_sistema=10 AND org_rol_modulo_permiso.estado=1
					AND (m2.nombre_modulo like '%".$buscar."%' OR org_modulo.nombre_modulo like '%".$buscar."%' OR org_modulo.descripcion_modulo like '%".$buscar."%' OR org_modulo.url_modulo like '%".$buscar."%')
					ORDER BY m2.orden, org_modulo.orden";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}

	function buscar_perfil($id_usuario=0)
	{
		$sentencia="SELECT 
					E.id_usuario,
					E.nombre, 
					E.nr,
					E.usuario, 
					E.correo, 
					E.seccion
					FROM tcm_empleado AS E
					WHERE E.id_usuario=".$id_usuario;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
}
?>