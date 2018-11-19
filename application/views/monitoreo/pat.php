<style>
	.table tbody>tr>td {text-align: left;}
    .tr_odd {background-color: aliceblue;}
    .tr_even {background-color: white;}
	.logro {text-align: right;}
    .cab td {font-weight: bold !important;color: white !important}
    .rowCab {background-color: #CBE9FF !important;}
    .cab2 {background-color: #4EBFFF !important;}
    .cab3 {background-color: #00ABE6 !important;}
    .cab4 {background-color: #0097D5 !important;}
    .cab5 {background-color: #007CBD !important;}
    .cab6 {background-color: #006996 !important;}
    .cab7 {background-color: #005A86 !important;}
    .cab8 {background-color: #003F67 !important;}
    .cab9 {background-color: #002856 !important;}
    .cab10 {background-color: #001B3D !important;}
</style>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>Datos del proceso</a>
                </div>
            </div>               
            <form name="formu" id="formu" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/pat/validar_actividad" autocomplete="off">                  
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="wizard-inner">
                            <ul class="steps">
                                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Matriz de programación de actividades<span class="chevron"></span></li>
                            </ul>
                            <!--<div class="actions">
                                <button type="button" class="btn btn-default btn-mini btn-prev"> <i class="icon-arrow-left"></i><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-success btn-mini btn-next" data-last=""><i class="fa fa-chevron-right"></i><i class="icon-arrow-right"></i></button>
                            </div>-->
                        </div>
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="row">
                                	<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="id_documento" class="col-sm-3 control-label">PEI <span class="asterisk">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control select" name="id_documento" id="id_documento" data-placeholder="[Seleccione..]">
                                                    <option value=""></option>
                                                    <?php
                                                        foreach($documentos as $val) {
															if($val['inicio_periodo']<=date('Y') && $val['fin_periodo']>=date('Y'))
                                                            	echo '<option value="'.$val['id_documento'].'">'.$val['nombre_pei'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                 	</div>
                                    <?php
                                        if($id_permiso==3) {
                                    ?>
                                        	<div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="unidad_lider" class="col-sm-3 control-label">Unidad organizativa<span class="asterisk">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control select" name="unidad_lider" id="unidad_lider" data-placeholder="[Seleccione..]" disabled="disabled">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach($seccion as $val) {
                                                                    //echo '<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                     		</div>
                                    <?php
                                        }
                                    ?>
                               	</div>
                                <?php
                                    if($id_permiso==3) {
                                ?>
                                <!--Año-->        
                                <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="anio_evaluar" class="col-sm-3 control-label">Año<span class="asterisk">*</span></label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control select" name="anio_evaluar" id="anio_evaluar" data-placeholder="[Seleccione..]" disabled="disabled" >
                                                       <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="mes" class="col-sm-3 control-label">Mes<span class="asterisk">*</span></label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control select" name="mes" id="mes" data-placeholder="[Seleccione..]" disabled="disabled">
                                                            <?php
                                                                $me[]='Enero';
                                                                $me[]='Febrero';
                                                                $me[]='Marzo';
                                                                $me[]='Abril';
                                                                $me[]='Mayo';
                                                                $me[]='Junio';
                                                                $me[]='Julio';
                                                                $me[]='Agosto';
                                                                $me[]='Septiembre';
                                                                $me[]='Octubre';
                                                                $me[]='Noviembre';
                                                                $me[]='Diciembre';
                                                                if($id_permiso == 3){for($iadmin=0;$iadmin<count($me);$iadmin++)echo '<option value="'.($iadmin+1).'">'.$me[$iadmin].'</option>';}
                                                                else{
                                                                for ($im=0; $im < date('m', (strtotime ("-15 day"))); $im++) { 
                                                                    echo '<option value="'.($im+1).'" selected>'.$me[$im].'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <div class="row" id="matriz" style="padding: 0 10px 20px 10px;">
                                    
                                </div>
                            </div>
                        </div>
                        <!--Aquí estaban los botones-->
                    </div>
                </div>
                <div class="project-box-footer clearfix">
                </div>
                <div class="project-box-ultrafooter clearfix">
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="button" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
                </div>             
                <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 99999999;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Observaciones</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="observacionM" name="observacionM"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal" onClick="cerrar_observacion()">Aceptar</button>
                            </div>
                        </div> 
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>

<script language="javascript" >

	var tabla;
	
    $(document).ready(function(){

        $('#formu').formValidation({
            err: {
                container: 'tooltip'
            },
            //trigger: 'blur',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_documento: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                //Año a evaluar
                anio_evaluar: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                unidad_lider: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                mes: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            e.preventDefault();
            var url='<?=base_url()?>index.php/monitoreo/actualizar_pat';
            var mensaje_correcto="loadingcircle***Los regristos del PAT se han actualizado éxitosamente!";
            var mensaje_incorrecto="loadingcircle***Error actualizando los registros del PAT! Se perdió la conexión a la red";
            var data = new FormData($(this)[0]);
            ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
            <?php
                if($id_permiso==3) {
            ?>
                    $("#unidad_lider").change();
            <?php
                }
                else {
            ?>
                    $("#id_documento").change();
            <?php
                }
            ?>
            //$("#limpiar").click();
            return false;
        });   

        $('#myWizard').wizard();
        $('#id_documento').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });
        $('#unidad_lider').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });       
        $('#mes').select2({
            placeholder: "[Seleccione...]"
        });

        //Año
        $('#anio_evaluar').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });
        tabla=$('.footable').DataTable({
			'info': false
		});

        <?php
            if($id_permiso==3) {
        ?>
                $("#id_documento").change(function(){
                    if($(this).val()!="") {
                        var url='<?=base_url()?>index.php/pat/buscar_unidad_documento/'+$(this).val();
                        var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                        var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                        var data = {id_documento:$(this).val()};
                        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             
        				$("#unidad_lider").select2("destroy");
        				$("#unidad_lider").html(val['unidad_lider']);

                        //Año
                        $("#anio_evaluar").select2("destroy");
                        $("#anio_evaluar").html(val['periodo']);

        				setTimeout(function(){                
        					$("#unidad_lider").select2({
        						placeholder: "[Seleccione...]",
        						allowClear: true
        					});
                            //Año
                            $("#anio_evaluar").select2({
                                placeholder: "[Seleccioe...]",
                                allowClear: true
                            });
        				}, 250);
        				$("#unidad_lider").removeAttr("disabled");
                        //Año
                        $("#anio_evaluar").removeAttr("disabled");
    
                        $("#mes").removeAttr("disabled");
        			}
        			else {
        				$("#unidad_lider").select2("destroy");
        				$("#unidad_lider").html('<option value=""></option>');
                        $("#unidad_lider").val('').trigger("change");

                        //Año
                        $("#anio_evaluar").select2("destroy");
        				$("#anio_evaluar").html('<option value=""></option>');
                        $("#anio_evaluar").val('').trigger("change");
        				setTimeout(function(){                
        					$("#unidad_lider").select2({
        						placeholder: "[Seleccione...]",
        						allowClear: true
        					});
                            //Año
                            $("#anio_evaluar").select2({
                                placeholder: "[Seleccioe...]",
                                allowClear: true
                            });
        				}, 250);
                        $("#formu").data('formValidation').resetForm();
                        $("#unidad_lider").attr("disabled","disabled");
                        //Año
                        $("#anio_evaluar").attr("disabled","disabled");
                        
                        $("#mes").attr("disabled","disabled");
        			}
        		});   
                

                $("#anio_evaluar").change(function(){
                    if($("#unidad_lider").val()!="" && $("#anio_evaluar").val() != "") {
                        var url='<?=base_url()?>index.php/monitoreo/buscar_nivel_item_actividad/'+$("#id_documento").val()+'/'+$("#unidad_lider").val()+'/'+$("#mes").val() +'/'+$("#anio_evaluar").val();
                        var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
                        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
                        var data = {id_documento:$("#id_documento").val(),id_seccion:$(this).val()};
                        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             
                        $("#matriz").html(val['tabla']);
                    }
                    else {
                        $("#matriz").html('');
                    }
                });
                $("#mes").change(function(){ 
                    if($("#unidad_lider").val()!="") {
                        var url='<?=base_url()?>index.php/monitoreo/buscar_nivel_item_actividad/'+$("#id_documento").val()+'/'+$("#unidad_lider").val()+'/'+$(this).val() +'/'+$("#anio_evaluar").val();
                        var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
                        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
                        var data = {id_documento:$("#id_documento").val(),id_seccion:$(this).val()};
                        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             
                        $("#matriz").html(val['tabla']);
                    }
                    else {
                        $("#matriz").html('');
                    }
                });

                $("#unidad_lider").change(function(){ 
                    var url='<?=base_url()?>index.php/monitoreo/buscar_nivel_item_actividad/'+$("#id_documento").val()+'/'+$(this).val()+'/'+$("#mes").val()+'/'+$("#anio_evaluar").val();
       
       
        <?php
            }
            else {
        ?>  
                $("#id_documento").change(function(){ 
                    var url='<?=base_url()?>index.php/monitoreo/buscar_nivel_item_actividad/'+$(this).val()+'/<?=$seccion['id_seccion']?>';
        <?php
            }
        ?>
            if($(this).val()!="") {                
                var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
                var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
                var data = {id_documento:$("#id_documento").val(),id_seccion:$(this).val()};
                ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             
                $("#matriz").html(val['tabla']);
            }
            else {
                $("#matriz").html('');
            }
        });

        $("#limpiar").click(function(e){
			$("#formu").trigger("reset");
			$("#id_documento").val("").trigger("change");
            $("#formu").data('formValidation').resetForm();
			$("#matriz").html('');
        });

        $('#guardar').click(function() {
            $('#formu').formValidation('validate');
        });
    });

    function actualizar(e, m)
    {
        var $tr=$(e).parents('tr');
        $tr.find('.logcam').val("1");
        if(Number(m)>0) {
            $tr.find('.por').html(number_format(Number($(e).val())/Number(m)*100, 0)+"%");
        }
        else {
            if(Number(m)==0) {
                $tr.find('.por').html("0%");
            }
        }
    } 
</script>
