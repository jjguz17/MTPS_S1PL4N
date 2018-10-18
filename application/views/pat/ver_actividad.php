<div class="tabs-wrapper">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-home" data-toggle="tab">Datos de la Actividad</a></li>
        <li><a href="#tab-help" data-toggle="tab">Historial</a></li>
	</ul>
	<div class="tab-content">
        <div class="tab-pane fade in active" id="tab-home">
        	<div class="panel-group accordion" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            	Información general
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
							<?php 
                                for($i=10;$i>2;$i--) {
                                    if ($jeraquia_nivel[0]['nom0'.$i]!="") {
                            ?>
                                        <div class="row">
                                            <div class="col-sm-3" style="text-align: right;"><strong><?=$jeraquia_nivel[0]['cor0'.$i]?></strong></div>
                                            <div class="col-sm-8"><?=$jeraquia_nivel[0]['des0'.$i]?></div>
                                        </div>
                            <?php
                                    }

                                }
                            ?>
                        </div>
                   	</div>
      			</div>
             	<div class="panel panel-default">
                 	<div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                Información actividad
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Estado Actual: </div>
                                <div class="col-sm-8"><strong><?=$items[0]['descripcion_estado']?></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Descripción: </div>
                                <div class="col-sm-8"><strong><?=$items[0]['descripcion_item']?></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Meta anual: </div>
                                <div class="col-sm-8"><strong><?=$items[0]['meta_actividad']?></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Unidad de medida: </div>
                                <div class="col-sm-8"><strong><?=$items[0]['unidad_medida']?></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Recursos: </div>
                                <div class="col-sm-8"><strong>$ <?=number_format($items[0]['recursos_actividad'],2)?></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" style="text-align: right;">Observaciones: </div>
                                <div class="col-sm-8"><strong><?=$items[0]['observaciones_actividad']?></strong></div>
                            </div>
                        </div>
                 	</div>
                </div>
                <div class="panel panel-default">
                 	<div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            	Desglose mensual de meta
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Enero: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_enero']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Febrero: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_febrero']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Marzo: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_marzo']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Abril: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_abril']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Mayo: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_mayo']?></strong></div>
                            </div> 
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Junio: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_junio']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Julio: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_julio']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Agosto: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_agosto']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Septiembre: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_septiembre']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Octubre: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_octubre']?></strong></div>
                            </div>  
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Noviembre: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_noviembre']?></strong></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-7" style="text-align: right;">Diciembre: </div>
                                <div class="col-sm-5"><strong><?=$items[0]['meta_diciembre']?></strong></div>
                            </div>                       
                      	</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-help">
            <style type="text/css">
                #tab-help blockquote:before {
                    font-size: 15px !important;
                    margin-left: -20px !important;
                }
                #tab-help blockquote, blockquote.pull-right {
                    padding: 10px 20px 10px 30px !important;
                    font-size: 14px !important;
                }
            </style>
            <?php
                foreach($historial_estado_actividad as $val) {
                    switch($val['id_estado']){
                        case 1:
                            $e='primary';
                            break;
                        case 2:
                            $e='info';
                            break;
                        case 3:
                            $e='success';
                            break;
                        case 4:
                            $e='danger';
                            break;
                        case 5:
                            $e='warning';
                            break;
                        default:
                            $e='default';
                    }
                    
                    $est='<span class=\'label label-'.$e.'\'>'.$val['descripcion_estado'].'</span>';
            ?>
                    <div class="row" style="text-align: justify">
                        El <strong><?=$val['fecha_creacion']?></strong> <?=$val['t']?> <strong><?=$val['hora_creacion']?></strong> se cambió el estado a <?=$est?><!-- por el usuario <strong><?=$val['nombre_completo']?></strong>-->
            <?php
                        if($val['observacion_estado_actividad']!="") {
            ?>
                            <div class="col-sm-12">
                                <blockquote>
                                    <p><?=$val['observacion_estado_actividad']?></p>
                                    <small>
                                        <cite title="Source Title"><?=$val['nombre_completo']?></cite>
                                    </small>
                                </blockquote>
                            </div>
            <?php
                }
                else echo '<br/>&nbsp;';
            ?>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>