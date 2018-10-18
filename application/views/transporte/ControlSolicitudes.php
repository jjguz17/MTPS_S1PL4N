<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do éxitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Control de Solicitudes</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>ID solicitud</th>
    <th>Fecha y Hora de Misión</th>
    <th>Sección del Solicitante</th>
    <th>Persona Solicitante</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($datos as $fila) {
?>
  <tr>
    <td><?php echo $fila->id?></td>
    <td><?php echo $fila->fecha." ".$fila->salida?></td>
    <td><?php echo ucwords($fila->seccion)?></td>
    <td><?php echo ucwords($fila->nombre)?></td>
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Aprobación de solicitud de Misión Oficial</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function dialogo(id)
	{
		$('#contenido-ventana').load(base_url()+'index.php/transporte/datos_de_solicitudes/'+id);
		return false;
	}	
	
	function Enviar(v)
	{
		document.getElementById('resp').value=v;
	}
</script>