<style> 
	.table tbody>tr>td {text-align: left;}
	.table a.table-link {margin: 0;}
</style>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>Datos del proceso</a>
                </div>
            </div>               
            <form name="formu" id="formu" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/pat/guardar_nivel" autocomplete="off">                  
                <input type="hidden" id="id_item" name="id_item">
                <input type="hidden" id="id_nivel" name="id_nivel">
                <input type="hidden" id="id_actividad" name="id_actividad">
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="wizard-inner">
                            <ul class="steps">
                                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Datos Generales<span class="chevron"></span></li>
                            </ul>
                        </div>
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="form-group">
                                    <label for="id_documento" class="col-sm-3 control-label">PEI <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select" name="id_documento" id="id_documento" data-placeholder="[Seleccione..]">
                                            <option value=""></option>
                                            <?php
                                                /*Se carga en un select los registros del PEI que se ejecuten en el año vigente*/
                                                foreach($documentos as $val) {
													if($val['inicio_periodo']<=date('Y') && $val['fin_periodo']>=date('Y'))
                                                    	echo '<option value="'.$val['id_documento'].'">'.$val['nombre_pei'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                               <?php if($id_permiso == 3) {?>
                                    <div class="form-group">
                                        <label for="anio_evaluar" class="col-sm-3 control-label">Año<span class="asterisk">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select" name="anio_evaluar" id="anio_evaluar" data-placeholder="[Seleccione..]" disabled="disabled">
                                                <option value="">
                                                </option>
                                               
                                            </select>
                                        </div>
                                </div>
                               <?php }?>
                                <div class="form-group">
                                    <label for="id_padre" id="l_id_padre" class="col-sm-3 control-label" style="text-transform: capitalize;">Proceso padre<span class="asterisk">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group input-append bootstrap-timepicker">
                                            <select class="form-control select" name="id_padre" id="id_padre" data-placeholder="[Seleccione..]" disabled="disabled">
                                                <option value=""></option>
                                            </select>
                                            <span id="pop" class="add-on input-group-addon">
                                                <i tabindex="0" data-trigger="focus" data-container="body" class="fa fa-flag popover2" data-placement="bottom"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    //El siguiente objeto HTML sólo se muestra si el usuario logueado tiene permisos de administrador en esta pantalla
                                    if($id_permiso==3) {
                                ?>
                               
                                    <div class="form-group">
                                        <label for="unidad_lider" class="col-sm-3 control-label">Unidad organizativa<span class="asterisk">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select" name="unidad_lider" id="unidad_lider" data-placeholder="[Seleccione..]" disabled="disabled">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                <?php 
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="descripcion_item" id="l_descripcion_item" class="col-sm-3 control-label" style="text-transform: capitalize;">Proceso <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control descripcion" id="descripcion_item" name="descripcion_item"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="meta_actividad" class="col-sm-3 control-label">Meta anual<span class="asterisk">*</span></label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="meta_actividad" name="meta_actividad" readonly="readonly">
                                            <span class="add-on input-group-addon">
                                                <i data-toggle="modal" href="#modal2" class="glyphicon glyphicon-tasks"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="unidad_medida" class="col-sm-3 control-label">Unidad de medida <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unidad_medida" name="unidad_medida">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recursos_actividad" class="col-sm-3 control-label">Recursos <span class="asterisk">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" id="recursos_actividad" name="recursos_actividad">
                                            <!--<span class="input-group-addon">USD</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="peso_actividad" class="col-sm-3 control-label">Peso <span class="asterisk">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">%</span>
                                            <input type="text" class="form-control" id="peso_actividad" name="peso_actividad">
                                            <!--<span class="input-group-addon">USD</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="observaciones_actividad" id="l_descripcion_item" class="col-sm-3 control-label" style="text-transform: capitalize;">Observaciones </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control descripcion" id="observaciones_actividad" name="observaciones_actividad"></textarea>
                                    </div>
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
                        <li><button class="btn btn-info" type="button" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
                        <li><button class="btn btn-warning" type="button" name="pat" id="pat"><span class="fa fa-table"></span> PAT</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>

                    </ul>
                </div>                
                <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 99999999;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Metas Mensuales</h4>
                            </div>
                            <div class="modal-body">
                                <style type="text/css">
                                    .aaa {
                                        text-align: left !important;
                                        padding-left: 1%;
                                    }
                                </style>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="meta_enero" class="col-sm-12 control-label aaa">Enero</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_enero" name="meta_enero">
                                    </div>
                                    <div class="col-sm-4">
                                    <label for="meta_febrero" class="col-sm-12 control-label aaa">Febrero</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_febrero" name="meta_febrero">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="meta_marzo" class="col-sm-12 control-label aaa">Marzo</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_marzo" name="meta_marzo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="meta_abril" class="col-sm-12 control-label aaa">Abril</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_abril" name="meta_abril">
                                    </div>
                                    <div class="col-sm-4">
                                    <label for="meta_mayo" class="col-sm-12 control-label aaa">Mayo</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_mayo" name="meta_mayo">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="meta_junio" class="col-sm-12 control-label aaa">Junio</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_junio" name="meta_junio">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="meta_julio" class="col-sm-12 control-label aaa">Julio</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_julio" name="meta_julio">
                                    </div>
                                    <div class="col-sm-4">
                                    <label for="meta_agosto" class="col-sm-12 control-label aaa">Agosto</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_agosto" name="meta_agosto">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="meta_septiembre" class="col-sm-12 control-label aaa">Septiembre</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_septiembre" name="meta_septiembre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="meta_octubre" class="col-sm-12 control-label aaa">Octubre</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_octubre" name="meta_octubre">
                                    </div>
                                    <div class="col-sm-4">
                                    <label for="meta_noviembre" class="col-sm-12 control-label aaa">Noviembre</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_noviembre" name="meta_noviembre">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="meta_diciembre" class="col-sm-12 control-label aaa">Diciembre</label>
                                        <input type="text" class="form-control meta_mensual" id="meta_diciembre" name="meta_diciembre">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div> 
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a id="nom">Registro de procesos</a>
                </div>
            </div>               
            <div class="project-box-content project-box-content-nopadding" id="conte-tabla">
                <table class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th class="all">Proceso</th>
                            <th class="all">Meta</th>
                            <th class="all" style="width:125px">Estado</th>
                            <th class="desktop tablet-l tablet-p" style="width:150px" align="center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script language="javascript" >
	
	var act_plural="procesos";
	var act_singular="proceso";
	var tabla;



     function actualizarTabla(idpadre,anio,unidad_lider=null)
       {
        $("#pop").html('<i tabindex="0" data-trigger="focus" data-container="body" class="fa fa-flag popover2" data-placement="bottom"></i> <script type="text/javascript"> /*setTimeout(function(){ $(".popover2").popover("destroy"); }, 250);*/ $(".popover2").popover({ content: "'+$("#id_padre option:selected").data("v")+'", title: "'+$("#id_padre option:selected").text()+'" }); <\/script>');
        tabla.ajax.url( base_url()+'index.php/pat/buscar_actividades/'+((idpadre!=null)?idpadre:'NULL') +'/' + ((anio!=null)?anio:'NULL') + '/'+ ((unidad_lider!=null)?unidad_lider:'NULL')).load(); 
       }
	
	$('#actualizar').removeClass('mostrar').addClass('ocultar');
	$('#guardar').removeClass('ocultar').addClass('mostrar');
	
    $(document).ready(function(){
        $('#formu').formValidation({
            err: {
                container: 'tooltip'
            },
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
                id_padre: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                
                <?php 
                    if($id_permiso==3) {
                ?>
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
                <?php
                    }
                ?>
                descripcion_item: {
                    validators: {
                        stringLength: {
                            min: 10,
                            message: 'Debe contener al menos 10 caracteres'
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                meta_actividad: {
                    icon: 'false',
                    trigger: 'blur',
                    validators: {
                        greaterThan: {
                            value: 0
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp: /^\d+(.\d+)?$/,
                            message: 'Debe escribir sólo números'
                        }
                    }
                },
                unidad_medida: {
                    validators: {
                        stringLength: {
                            min: 5,
                            message: 'Debe contener al menos 5 caracteres'
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                recursos_actividad: {
                    validators: {
                        greaterThan: {
                            value: 0
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp:  /^[0-9]+((\.)+(([0-9]{2})|([0-9]{1})))?$/,
                            message: 'Debe contener formato de moneda'
                        }
                    }
                },
                //Validador para peso_actividad
                peso_actividad: {
                    validators: {
                        greaterThan: {
                            value: 0
                        },lessThan:{
                            value: 100
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp:  /^(100(\.00?)?|[1-9]?\d(\.\d\d?)?)$/ ,
                            message: 'Debe contener formato de porcentaje'
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            e.preventDefault();
            var url='<?=base_url()?>index.php/pat/guardar_actividad';
            var mensaje_correcto;
            var mensaje_incorrecto;
            if($('#id_item').val()=="") {
                mensaje_correcto="loadingcircle***El regristo de "+act_singular+" se ha guardado éxitosamente!";
                mensaje_incorrecto="loadingcircle***Error guardando el registro de "+act_singular+"! Se perdió la conexión a la red";
            }
            else {
                mensaje_correcto="loadingcircle***El regristo de "+act_singular+" se ha actualizado éxitosamente!";
                mensaje_incorrecto="loadingcircle***Error en la actualización del registro de "+act_singular+"! Se perdió la conexión a la red";
            }
            var data = new FormData($(this)[0]);
            ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);

            
            //tabla.ajax.url(base_url()+'index.php/pat/buscar_actividades/'+$("#id_padre").val() ).load();
            $("#meta_abril,#meta_actividad,#meta_agosto,#meta_diciembre,#meta_enero,#meta_febrero,#meta_julio,#meta_junio,#meta_marzo,#meta_mayo,#meta_noviembre,#meta_octubre,#meta_septiembre,#unidad_medida,#descripcion_item,#id_actividad,#id_item,#recursos_actividad,#observaciones_actividad").val("");
            $("#formu").data('formValidation').resetForm();
            $('#peso_actividad').prop("value","");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');

            //Actualizar la tabla
        actualizarTabla($('#id_padre').val(), <?= (($id_permiso==3) ? '$("#anio_evaluar").val()': date('Y'))?>)
            return true;
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
        <?php if($id_permiso == 3){?>
        $('#anio_evaluar').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });
    <?php }?>
        tabla=$('.footable').DataTable({
			'info': false
		});
        $('#id_padre').select2();

        $("#id_documento").change(function(){
            if($(this).val()!="" && $(this).val()!=null) {
                var url='<?=base_url()?>index.php/pat/mostrar_items_padre_pat/'+$(this).val();
                var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                var data = {id_documento:$(this).val()};
                ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
                
                
                //Modificaciones para el ingreso del año (UFG)
                <?php if($id_permiso == 3){?>
                    $('#anio_evaluar').select2({
                        placeholder: "[Seleccione...]",
                        allowClear: true
                        });
                $("#anio_evaluar").html(val['pat_periodo']);
                $("#anio_evaluar").removeAttr("disabled");
                <?php }?>
                $("#id_padre").select2("destroy");
                $("#l_id_padre").html(val['nombre_nivel_p']+' <span class="asterisk">*</span>');
                $("#l_descripcion_item").html(val['nombre_nivel']+' <span class="asterisk">*</span>');
                $("#nom").html('Registro de '+val['nombre_nivel']);
				act_plural=val['nombre_nivel'];
				act_singular=val['nombre_nivel'];
                $("#nomt").html(val['nombre_nivel']);
                $("#id_padre").html(val['id_padre']);
				$("#id_nivel").val(val['id_nivel_a']);
                setTimeout(function(){                
                    $("#id_padre").select2({
                        placeholder: "[Seleccione...]",
                        allowClear: true
                    });
                }, 250);
                $("#id_padre").removeAttr("disabled");

                //Año
                
            }
            else {
                //Año
                <?php if($id_permiso == 3){?>
                $("#anio_evaluar").select2("destroy");
                $("#anio_evaluar").attr("disabled","disabled");
                $("#anio_evaluar").html('<option value=""></option>');
                <?php }?>

                $("#id_padre").select2("destroy");
                $("#l_id_padre").html('Proceso padre <span class="asterisk">*</span>');
                $("#l_descripcion_item").html('Proceso <span class="asterisk">*</span>');
                $("#nom").html('Registro de procesos');
				act_plural="procesos";
				act_singular="proceso";
                $("#nomt").html('Proceso');
                $("#id_padre").html('<option value=""></option>');
				$("#id_nivel").val("");
                setTimeout(function(){                
                    $("#id_padre").select2({
                        placeholder: "[Seleccione...]",
                        allowClear: true
                    });
                }, 250);
                $("#id_padre").val("").trigger("change");
                $("#formu").data('formValidation').resetForm();
                $("#id_padre").attr("disabled","disabled");

            
                $("#pop").html('<i tabindex="0" data-trigger="focus" data-container="body" class="fa fa-flag popover2" data-placement="bottom"></i>');
            }
        });


       //Cuando al año cambie debe actualizarse la tabla(UFG)
      <?php if($id_permiso == 3){?>
       $('#anio_evaluar').change(function()
       {
        if(($(this).val() == '') && ($('#id_padre').val() != ''))
        {
            actualizarTabla($('#id_padre').val(),null);
        }
        else if(($(this).val() != '') && ($('#id_padre').val() == ''))
        {
            actualizarTabla(null,$('#anio_evaluar').val());
        }
        else if(($(this).val() != '') && ($('#id_padre').val() != ''))
        {
            actualizarTabla($('#id_padre').val(),$('#anio_evaluar').val());
        }
        else
        {
            actualizarTabla(null,null);
        }
        
            //Fin de la modificación(UFG)
       }); 
       <?php }?>

      

        $("#id_padre").change(function(){

            //Modificación
            if(<?=(($id_permiso==3)?'$("#anio_evaluar").val() == "" && ' : '')?>  ($('#id_padre').val() != ''))
        {
           
           actualizarTabla($('#id_padre').val(), <?=(($id_permiso==3)?'null' :date('Y'))?>);
        
            //Actualizar campos
            var url='<?=base_url()?>index.php/pat/buscar_actividades_unidad/'+$(this).val();
                var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                var data = {id_padre:$(this).val()};
                ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
                
                <?php 
                    if($id_permiso==3) {
                ?>                
                        $("#unidad_lider").select2("destroy");
                        $("#unidad_lider").html(val['unidad_lider']);
                        setTimeout(function(){                
                            $("#unidad_lider").select2({
                                placeholder: "[Seleccione...]",
                                allowClear: true
                            });
                        }, 250);
                        $("#unidad_lider").removeAttr("disabled");
                <?php
                    }
                ?>
        }
        else if(<?=(($id_permiso==3)?'$("#anio_evaluar").val() !=""' : 'true')?> && ($('#id_padre').val() == ''))
        {
            actualizarTabla(null,<?=(($id_permiso==3)?'$("#anio_evaluar").val()' :date('Y')) ?>);
                //Actualizar Campos
                <?php 
                    if($id_permiso==3) {
                ?>
                        $("#unidad_lider").select2("destroy");
                        $("#unidad_lider").html('<option value=""></option>');
                        setTimeout(function(){                
                            $("#unidad_lider").select2({
                                placeholder: "[Seleccione...]",
                                allowClear: true
                            });
                        }, 250);
                        $("#unidad_lider").attr("disabled","disabled");
                <?php
                    }
                ?>
        }
        else if(<?=(($id_permiso==3)?'$("#anio_evaluar").val() != ""' : 'true')?> && ($('#id_padre').val() != ''))
        {
            actualizarTabla($('#id_padre').val(),<?=(($id_permiso==3)?'$("#anio_evaluar").val()' :date('Y')) ?>);
       //Actualizar campos
       var url='<?=base_url()?>index.php/pat/buscar_actividades_unidad/'+$(this).val();
                var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                var data = {id_padre:$(this).val()};
                ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
                
                <?php 
                    if($id_permiso==3) {
                ?>                
                        $("#unidad_lider").select2("destroy");
                        $("#unidad_lider").html(val['unidad_lider']);
                        setTimeout(function(){                
                            $("#unidad_lider").select2({
                                placeholder: "[Seleccione...]",
                                allowClear: true
                            });
                        }, 250);
                        $("#unidad_lider").removeAttr("disabled");
                <?php
                    }
                ?>
       
        }
        else
        {
            actualizarTabla(null, null);
        //Actualizar Campos
        <?php 
                    if($id_permiso==3) {
                ?>
                        $("#unidad_lider").select2("destroy");
                        $("#unidad_lider").html('<option value=""></option>');
                        setTimeout(function(){                
                            $("#unidad_lider").select2({
                                placeholder: "[Seleccione...]",
                                allowClear: true
                            });
                        }, 250);
                        $("#unidad_lider").attr("disabled","disabled");
                <?php
                    }
                ?>
        
        }

		});

       <?php
        if($id_permiso == 3)
        {?>
         $("#unidad_lider").change(function(){
            actualizarTabla($('#id_padre').val(),$('#anio_evaluar').val(),$('#unidad_lider').val());
        });
        <?php
        }
       ?>

        $(".meta_mensual").keyup(function(){
            var sum=0;
            $(".meta_mensual").each(function (index) {
                sum=sum+Number($(this).val());
            }); 
            $("#meta_actividad").val(sum);
            $("#meta_actividad").blur();
        });


        $("#pat").click(function(){
            window.location.href = base_url()+'index.php/pat/consulta_pat';
            return false;
           });        



        $("#limpiar").click(function(e){
			$("#formu").trigger("reset");
			$("#id_documento").val("").trigger("change");

            //Año añadido
            <?php if($id_permiso == 3) {?>
            $("#anio_evaluar").val("").trigger("change");           
        <?php }?>
            $("#id_padre").val("").trigger("change");
            $("#formu").data('formValidation').resetForm();
			$("#id_item").val("");
			$("#id_nivel").val("");
			$("#id_actividad").val("");
			tabla.ajax.url( base_url()+'index.php/pat/buscar_actividades/0').load();
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');
        });

        $('#actualizar').click(function() {
            $('#formu').formValidation('validate');
        });

        $('#guardar').click(function() {
            $('#formu').formValidation('validate');
        });
    });

    function editar(id){
		$("#formu").data('formValidation').resetForm();
        $('#guardar').removeClass('mostrar').addClass('ocultar');
        $('#actualizar').removeClass('ocultar').addClass('mostrar');
        var url='<?=base_url()?>index.php/pat/buscar_actividad/'+id;
        var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
        var data = {id_documento:id};
        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
		if(val['valores']!="") {		
			$('#id_item').val(val['valores'][0]['id_item']);
			//$("#id_nivel").val(val['valores'][0]['id_nivel']);
			$('#id_actividad').val(val['valores'][0]['id_actividad']);
			
			$('#descripcion_item').val(val['valores'][0]['descripcion_item']);
			$('#meta_actividad').val(val['valores'][0]['meta_actividad']);	
			$('#unidad_medida').val(val['valores'][0]['unidad_medida']);
			$('#recursos_actividad').val(val['valores'][0]['recursos_actividad']);	
			$('#observaciones_actividad').val(val['valores'][0]['observaciones_actividad']);
			$('#meta_enero').val(val['valores'][0]['meta_enero']);		
			$('#meta_febrero').val(val['valores'][0]['meta_febrero']);
			$('#meta_marzo').val(val['valores'][0]['meta_marzo']);
			$('#meta_abril').val(val['valores'][0]['meta_abril']);
			$('#meta_mayo').val(val['valores'][0]['meta_mayo']);
			$('#meta_junio').val(val['valores'][0]['meta_junio']);
			$('#meta_julio').val(val['valores'][0]['meta_julio']);
			$('#meta_agosto').val(val['valores'][0]['meta_agosto']);
			$('#meta_septiembre').val(val['valores'][0]['meta_septiembre']);
			$('#meta_octubre').val(val['valores'][0]['meta_octubre']);
			$('#meta_noviembre').val(val['valores'][0]['meta_noviembre']);
			$('#meta_diciembre').val(val['valores'][0]['meta_diciembre']);
            $('#unidad_lider').val(val['valores'][0]['id_seccion']).trigger("change");
		}
        return false;
    }
	 
	function eliminar(id){
		$("#formu").data('formValidation').resetForm();
        $('#actualizar').removeClass('mostrar').addClass('ocultar');
        $('#guardar').removeClass('ocultar').addClass('mostrar');
        var url='<?=base_url()?>index.php/pat/eliminar_actividad/'+id;
        var mensaje_correcto="loadingcircle***El registro se ha eliminado con éxito!";
        var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
        var data = {id_documento:id};
        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
        
		if(id==$("#id_item").val())
		$("#id_item,#id_actividad").val("");
        actualizarTabla((($("#id_padre").val() != null) ? $('#id_padre').val() : null),<?=($id_permiso == 3 ? '$("#anio_evaluar").val()' : date('Y'))?>);
        //tabla.ajax.url( base_url()+'index.php/pat/buscar_actividades/'+$("#id_padre").val() ).load();
        return false;
    }	
	
	function eliminar_(id) {		
		$("#modal .modal-title").html("Eliminar registro");
		$("#modal .modal-body").html("¿Realmente desea eliminar este registro ("+id+")? Tenga en cuenta que una vez borrado no lo podrá recuperar y todos los registros que dependan de él también se perderán.");
		$("#modal .btn-success").attr("onClick","eliminar("+id+")");
	}
	
	function enviar(id){
		$("#formu").data('formValidation').resetForm();
        var url='<?=base_url()?>index.php/pat/enviar_actividad/'+id;
        var mensaje_correcto="loadingcircle***El registro se ha enviado con éxito!";
        var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
        var data = {id_documento:id};
        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
		if(id==$("#id_actividad").val()) {
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');
			$("#meta_abril,#meta_actividad,#meta_agosto,#meta_diciembre,#meta_enero,#meta_febrero,#meta_julio,#meta_junio,#meta_marzo,#meta_mayo,#meta_noviembre,#meta_octubre,#meta_septiembre,#unidad_medida,#descripcion_item,#id_actividad,#id_item,#recursos_actividad,#observaciones_actividad").val("");
        }
		tabla.ajax.url( base_url()+'index.php/pat/buscar_actividades/'+$("#id_padre").val() ).load();
	}
	
	function ver(id) {
		$("#modal .modal-title").html('Actividad');
		$("#modal .modal-body").html("");
		$("#modal .modal-body").load(base_url()+"index.php/pat/buscar_actividad/"+id+"/2");
		$("#modal .btn-success").attr("onClick","cerrando_ventana()");
		$("#modal .btn-primary").css("display","none");
	}
	
	function cerrando_ventana()
	{
		setTimeout(function(){  
			$("#modal .btn-primary").css("display","inline-block");
       	}, 250);
	}
	
	function observaciones(obs) {
		$("#modal .modal-title").html("Observaciones");
		$("#modal .modal-body").html(obs);
		$("#modal .btn-success").attr("onClick","");
	}
</script>