<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="login-box">
                <div id="login-box-holder">
                    <div class="row">
                        <div class="col-xs-12">
                            <header id="login-header">
                                <div id="login-logo">
                                	<img src="<?=base_url()?>img/logo.png" alt=""/>
                                </div>
                            </header>
                            <div id="login-box-inner">
                               	<form role="form" action="<?php echo base_url();?>index.php/sessiones/iniciar_session" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input class="form-control" type="text" placeholder="Usuario" name="user" id="user">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="password" class="form-control" placeholder="Contraseña" name="pass" id="pass">
                                    </div>
                                    <div id="remember-me-wrapper">
                                        <div class="row">
                                            <a data-toggle="modal" href="#modal" onClick="cambioContraseña();return false;" id="login-forget-link" class="col-xs-12">
                                            ¿Olvidó su contraseña?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                        	<button type="submit" class="btn btn-success col-xs-12">Ingresar</button>
                                        </div>
                                    </div>                                    
                            	</form>
                            </div>
                      	</div>
                 	</div>
             	</div>
            </div>
        </div>
    </div>
</div> 
<footer id="footer" style="width:100%; max-width:600px; margin: 0 auto;">
	<div class="text-center padder">        
        <div class="signup-footer">        
            <div class="text-center padder">
                <img class="ues" src="<?php echo base_url();?>img/ues.min.png" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img class="escudo" src="<?php echo base_url();?>img/escudo.png" />
            </div>            
            <div  style="font-size: 11px;">
                Ministerio de Trabajo y Previsión Social - República de El Salvador C.A.<br/>
                Alameda Juan Pablo II y 17 Ave. Norte Edificios 2,3 y 4, Centro de Gobierno, San Salvador, C.A.<br/>
                PBX:(503)2259-3700, FAX:(503)2259-3756. asesorialaboral@mtps.gob.sv, Asesoría Laboral (503)2259-3838<br/>
                &copy; Todos los derechos reservados UES-FMP 2014
            </div>            
        </div>
 	</div>
</footer>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('body').attr("id","login-page");
	});
    function cambioContraseña(){
        $("#modal .modal-title").html('Solicitud de cambio de contraseña');
        $("#modal .modal-body").html("");
        $("#modal .modal-body").load(base_url()+"index.php/sessiones/cambiar_pass");
        //$("#modal .btn-success").attr("onClick","cerrando_ventana()");
        $("#modal .modal-footer").css("display","none");
    }
</script>
