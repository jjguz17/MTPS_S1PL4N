<form class="form-horizontal" name="form" role="form" id="form" method="post" action="<?php echo base_url()?>index.php/promocion/guardar_ingreso_promocion" autocomplete="off">
    <div class="form-group" id="mensaje">
    </div>
    <div class="form-group">
        <label for="correo" class="col-sm-3 control-label">Usuario <span class="asterisk">*</span></label>
        <div class="col-sm-8">
            <input type="text" data-req="true" name="correo" id="correo" class="form-control" />
        </div>
    </div>
    <div class="form-group" style="margin-top: 10px;">
    	<label for="correo" class="col-sm-3 control-label">Codigo <span class="asterisk">*</span></label>
        <div class="col-sm-5">
    		<input type="text" data-req="true" class="form-control" name="captcha_code" id="captcha_code" />
       	</div>
  	</div>
    <div class="form-group" style="margin-top: 10px;">
    	<label for="correo" class="col-sm-3 control-label">&nbsp;</label>
        <div class="col-sm-4">
    		<a href="#" id="cap" onclick="document.getElementById('captcha').src = '<?php echo base_url()?>/index.php/sessiones/capcha'; return false"><img id="captcha" src="<?php echo base_url()?>/index.php/sessiones/capcha" alt="CAPTCHA Image" /></a>
       	</div>
  	</div>
    <ul class="pager wizard">
        <li><button class="btn btn-success" type="submit" name="feedbackSubmit" id="feedbackSubmit"><span class="glyphicon glyphicon-send"></span> Enviar</button></li>
	</ul>    
</form>
<script>
  	$(document).ready(function() {
		$("#feedbackSubmit").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>/index.php/sessiones/sendmail",
				data: $("#form").serialize(),
				success: function(data) {
					$("#cap").click();
					if(data.status==1) {
						$("#mensaje").html( '<div class="alert alert-success">'+
							'	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
							'	<span class="glyphicon glyphicon-exclamation-sign"></span> El <strong>envío solicitud de cambio de contraseña</strong> se ha realizado exitosamente al correo: '+data.message+
							'</div>');
						$("#correo").val("");
						$("#captcha_code").val("");						
					}
					else
						$("#mensaje").html( '<div class="alert alert-danger">'+
							'	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
							'	<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>enviar solicitud de cambio de contraseña</strong>: '+data.message+
							'</div>');
				},
				error: function(response) {
					$("#mensaje").html( '<div class="alert alert-danger">'+
										'	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
										'	<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>enviar solicitud de cambio de contraseña</strong>: Se perdió la señal de la red. Porfavor vuelva a intentarlo.'+
										'</div>');
				}
			});
			return false;
		}); 
	});
</script>