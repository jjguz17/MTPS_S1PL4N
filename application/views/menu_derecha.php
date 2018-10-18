                    </div>
                </div>
                <footer id="footer-bar" class="row" style="padding: 10px 0;">
                	<p id="footer-copyright" class="col-md-3">
                    	<img class="ues" src="<?php echo base_url();?>img/ues.min.png" height="60"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img class="escudo" src="<?php echo base_url();?>img/escudo.png" height="60"/>
                    </p>
                    <p id="footer-copyright" class="col-md-9">
                        Ministerio de Trabajo y Previsión Social - República de El Salvador C.A.<br/>
                        Alameda Juan Pablo II y 17 Ave. Norte Edificios 2,3 y 4, Centro de Gobierno, San Salvador, C.A.<br/>
                        PBX:(503)2259-3700, FAX:(503)2259-3756. asesorialaboral@mtps.gob.sv, Asesoría Laboral (503)2259-3838<br/>
                        &copy; Todos los derechos reservados UES-FMP <?=date('Y')?>
                    </p>
                </footer>
            </div>
        </div>
    </div>
</div>
<div id="config-tool" class="closed">
    <a id="config-tool-cog">
        <i class="fa fa-cog"></i>
    </a>
    <div id="config-tool-options">
        <h3 style="margin-top: 0px;">Ayuda</h3>
        <!--<ul>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-header"/>
                        <label for="config-fixed-header">
                        Fixed Header
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-sidebar"/>
                        <label for="config-fixed-sidebar">
                        Fixed Left Menu
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-footer"/>
                        <label for="config-fixed-footer">
                        Fixed Footer
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-boxed-layout"/>
                        <label for="config-boxed-layout">
                        Boxed Layout
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-rtl-layout"/>
                        <label for="config-rtl-layout">
                        Right-to-Left
                    </label>
                </div>
            </li>
        </ul>
        <br/>
        <h4>Skin Color</h4>
        <ul id="skin-colors" class="clearfix">
            <li>
                <a class="skin-changer" data-skin="" data-toggle="tooltip" title="Default" style="background-color: #34495e;"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-white" data-toggle="tooltip" title="White/Green" style="background-color: #2ecc71;"></a>
            </li>
            <li>
                <a class="skin-changer blue-gradient" data-skin="theme-blue-gradient" data-toggle="tooltip" title="Gradient"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-turquoise" data-toggle="tooltip" title="Green Sea" style="background-color: #1abc9c;"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-amethyst" data-toggle="tooltip" title="Amethyst" style="background-color: #9b59b6;"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-blue" data-toggle="tooltip" title="Blue" style="background-color: #2980b9;"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-red" data-toggle="tooltip" title="Red" style="background-color: #e74c3c;"></a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-whbl" data-toggle="tooltip" title="White/Blue" style="background-color: #3498db;"></a>
            </li>
        </ul>-->
       	<div class="tabs-wrapper">
            <ul class="nav nav-tabs" style="padding: 0 !important;">
                <li style="padding: 0;" class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-file-text"></i></a></li>
                <li style="padding: 0;"><a href="#tab-2" data-toggle="tab"><i class="glyphicon glyphicon-flash"></i></a></li>
                <!--    
                    <li style="padding: 0;"><a href="#tab-3" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i></a></li>
                    <li style="padding: 0;"><a href="#tab-4" data-toggle="tab"><i class="fa fa-pencil-square-o"></i></a></li>
                -->
            </ul>
        	<div class="tab-content" id="mayuda">
                <div class="tab-pane fade in active" id="tab-1">
                    <h5>DESCRIPCIÓN DE LA PANTALLA</h5>
                    <p><?=$ayuda[0]['descripcion_ayuda']?></p>
                    <p>Para mayor información de click <a href="<?=base_url()?>ayuda/<?=$IDM?>.pdf" target="_blank">aquí para ver el manual de usuario</a> </p>
                </div>
                <div class="tab-pane fade" id="tab-2">
                    <h5>¿PARA QUÉ SE NECESITA ESTA INFORMACIÓN?</h5>
                    <p><?=$ayuda[0]['para_que']?></p>
                </div>
                <!--
                    <div class="tab-pane fade" id="tab-3">
                        <h5>PROBLEMAS FRECUENTES</h5>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                    </div>
                    <div class="tab-pane fade" id="tab-4">
                        <h5>FORMA CORRECTA DE LLENADO DEL FORMULARIO</h5>
                        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                    </div>
                -->
            </div>
		</div>
    </div>
</div>