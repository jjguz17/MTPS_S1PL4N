<?php
    $objeto='el <strong>empleador</strong>';
    switch($accion_transaccion) {
        case 1: 
            $accion_transaccion="guarda";
            break;
        case 2: 
            $accion_transaccion="actualiza";
            break;
        case 3: 
            $accion_transaccion="elimina";
            break;
    }
    if($estado_transaccion==1) {
        $class='success';
        $mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente! Si deseas agregar lugares de trabajo a un establecimiento presiona <a href="'.base_url().'index.php/promocion/lugares_trabajo" class="alert-link">aquí</a>.';
    }
    else {
        $class='danger';
        $mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': Se perdió la señal de la red. Porfavor vuelva a intentarlo.';
    }
    if($estado_transaccion!="" && $estado_transaccion!=NULL) {  
?>
        <div class="alert alert-<?php echo $class?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $mensaje?>
        </div>
<?php } ?>
<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <div class="panel-btns">
            <a href="#" class="tooltips ayuda" data-ayuda="1" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
            <a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
            <h3 class="panel-title">Datos del empleador</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
            <form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/promocion/guardar_promocion" autocomplete="off">
                <div id="progressWizard" class="basic-wizard">
                    
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Información General</a></li>
                        <li><a href="#ptab2" data-toggle="tab"><span>Paso 2:</span> Información Complementaria</a></li>
                    </ul>
                      
                    <div class="tab-content">
                      
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      
                        <div class="tab-pane" id="ptab1">
                            <div class="form-group">
                                <label for="nombre_institucion" class="col-sm-3 control-label">Razón Social <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" data-req="true" data-tip="x" data-min="5" name="nombre_institucion" id="nombre_institucion" class="form-control"/>
                                </div>
                            </div>
                          
                            <div class="form-group">
                                <label for="nit_empleador" class="col-sm-3 control-label">NIT del empleador <span class="asterisk">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" data-req="true" data-tip="nit" name="nit_empleador" id="nit_empleador" class="form-control" placeholder="#### - ###### - ### - #" maxlength="17"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">&nbsp;</label>
                            </div>
                        </div>
                        <div class="tab-pane" id="ptab2">
                            <div class="form-group">
                                <label for="nombre_representante" class="col-sm-3 control-label">Nombre del representante legal </label>
                                <div class="col-sm-8">
                                    <input type="text" name="nombre_representante" id="nombre_representante" class="form-control" />
                                </div>
                            </div>
                    
                            <div class="form-group">
                                <label for="id_clasificacion" class="col-sm-3 control-label">Clasificación CIIU</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_clasificacion" id="id_clasificacion" data-placeholder="[Seleccione..]">
                                        <option value=""></option>
                                        <?php
                                            foreach($clasificacion as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="form-group">
                                <label for="id_sector" class="col-sm-3 control-label">Sector</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="id_sector" id="id_sector" data-placeholder="[Seleccione..]">
                                        <option value=""></option>
                                        <?php
                                            foreach($sector as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">¿Existe sindicato?</label>
                                <div class="col-sm-4" style="margin-top: 7px;">
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" value="1" name="sindicato" id="sindicato" />
                                        <label for="sindicato">Sí</label>
                                    </div>
                                </div>
                            </div>
                      </div>   
                      

                    </div><!-- tab-content -->
                    
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="button" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
                    
                </div><!-- #basicWizard -->
            </form> 
        </div>
    </div><!-- panel -->
</div>
<div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <div class="panel-btns">
            <a href="#" class="tooltips ayuda" data-ayuda="2" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
            <a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
            <h3 class="panel-title" id="titulo-tabla">Empleadores registrados</h3>
        </div>
        <div class="panel-body" id="contenido-tabla">
                <table class="table table-hover mb30">
                    <thead>
                        <tr>
                            <th class="all">Razón Social</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($institucion as $val) {
                                echo '<tr><td>'.$val['nombre'].'</td><td><a href="#" onClick="editar('.$val['id'].');return false;" class="edit-row" data-id="'.$val['id'].'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="eliminar('.$val['id'].');return false;" class="delete-row" data-id="'.$val['id'].'"><i class="fa fa-trash-o"></i></a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
<script language="javascript" >
    $(document).ready(function(){
        $('#progressWizard').bootstrapWizard({
            'nextSelector': '.next',
            'previousSelector': '.previous',
            onNext: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#progressWizard').find('.progress-bar').css('width', $percent+'%');
            },
            onPrevious: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#progressWizard').find('.progress-bar').css('width', $percent+'%');
            },
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#progressWizard').find('.progress-bar').css('width', $percent+'%');
            }
        });
        $("#limpiar").click(function(){
            $("#formu").load(base_url()+"index.php/promocion/general_recargado");
        });     
    });
    function editar(id){
        $("#formu").load(base_url()+"index.php/promocion/general_recargado/"+id);
        return false;
    };
    function eliminar(id){
        var titulo="Alerta";
        var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
        var url=base_url()+"index.php/promocion/eliminar_institucion/"+id;
        confirmacion(titulo, mensaje, url);
        return false;
    } 
</script>