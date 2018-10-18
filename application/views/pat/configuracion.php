<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>Datos del proceso</a>
                </div>
            </div>               
            <form name="formu" id="formu" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/pat/guardar_nivel" autocomplete="off">                  
                <input type="hidden" id="id_nivel" name="id_nivel">
                <input type="hidden" id="id_documento" name="id_documento">
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="wizard-inner">
                            <ul class="steps">
                                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Datos Generales<span class="chevron"></span></li>
                            </ul>
                            <!--<div class="actions">
                                <button type="button" class="btn btn-default btn-mini btn-prev"> <i class="icon-arrow-left"></i><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-success btn-mini btn-next" data-last=""><i class="fa fa-chevron-right"></i><i class="icon-arrow-right"></i></button>
                            </div>-->
                        </div>
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="form-group">
                                    <label for="nombre_nivel" class="col-sm-3 control-label">Nombre Proceso <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nombre_nivel" name="nombre_nivel">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="abreviacion" class="col-sm-3 control-label">Abreviatura <span class="asterisk">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="abreviacion" name="abreviacion">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_padre" class="col-sm-3 control-label">Dependencia <span class="asterisk">*</span></label>
                                  	<div class="col-sm-8">
                                        <select class="form-control select" name="id_padre" id="id_padre" data-placeholder="[Seleccione..]" disabled="disabled">
                                            <option value=""></option>
                                        </select>
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
                        <!--<li><button class="btn btn-success" type="button" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>-->
                        <li><button class="btn btn-info" type="button" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
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
                    <a>Documentos registrados</a>
                </div>
            </div>               
            <div class="project-box-content project-box-content-nopadding" id="conte-tabla">
                <table class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th class="all">Año</th>
                            <th class="all">Nombre</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px" align="center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($documentos as $val) {
                                echo '<tr><td align="left">'.$val['A'].'</td><td align="left"><a target="_blank" href="'.base_url().'documentos/'.$val['nombre_documento'].'" >'.$val['nombre_documento'].'</a></td><td><a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_documento'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script language="javascript" >
	
	$('#actualizar').removeClass('mostrar').addClass('ocultar');
	//$('#guardar').removeClass('ocultar').addClass('mostrar');
	
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
                abreviacion: {
                    validators: {
                        stringLength: {
                            min: 1,
                            message: 'Debe contener al menos 1 caracter'
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp: /^[a-z]+$/i,
                            message: 'Debe escribir sólo letras'
                        }
                    }
                },
                nombre_nivel: {
                    validators: {                        
                        stringLength: {
                            min: 10,
                            message: 'Debe contener al menos 10 caracteres'
                        },
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp: /^[a-z|\' ']+$/i,
                            message: 'Debe escribir sólo letras y espacios en blanco'
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
                }
            }
        })
        .on('success.form.fv', function(e) {
            event.preventDefault();
            var url='<?=base_url()?>index.php/pat/guardar_nivel';
            if($('#id_documento').val()=="") {
                var mensaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
                var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
            }
            else {
                var mensajesaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
                var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
            }
            var data = new FormData($(this)[0]);
            ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
            $(this).trigger("reset");
            $("#formu").data('formValidation').resetForm();
            $("#id_padre").select2("destroy");
            $("#id_padre").html('<option value=""></option>');
            setTimeout(function(){                
                $("#id_padre").select2({
                    placeholder: "[Seleccione...]",
                    allowClear: true
                });
            }, 250);
            $("#id_padre").attr("disabled","disabled");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            //$('#guardar').removeClass('ocultar').addClass('mostrar');
            return false;
        });

        $('#myWizard').wizard();
        $('#id_padre').select2();
        $('.footable').dataTable({'info': false});

        /*$("#formu").submit(function(event){
            event.preventDefault();
            var url='<?=base_url()?>index.php/pat/guardar_nivel';
            if($('#id_documento').val()=="") {
                var mensaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
                var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
            }
            else {
                var mensajesaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
                var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
            }
            var data = new FormData($(this)[0]);
            ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
            $(this).trigger("reset");
			$("#id_padre").select2("destroy");
			$("#id_padre").html('<option value=""></option>');
			setTimeout(function(){				  
				$("#id_padre").select2({
					placeholder: "[Seleccione...]",
					allowClear: true
				});
			}, 250);
			$("#id_padre").attr("disabled","disabled");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            //$('#guardar').removeClass('ocultar').addClass('mostrar');
            return false;
        });*/
		
        $("#limpiar").click(function(e){
            $("#formu").data('formValidation').resetForm();
			$("#id_nivel").val("");
			$('#id_documento').val("");
			$("#id_padre").select2("destroy");
			$("#id_padre").html('<option value=""></option>');
			setTimeout(function(){				  
				$("#id_padre").select2({
					placeholder: "[Seleccione...]",
					allowClear: true
				});
			}, 250);
			$("#id_padre").attr("disabled","disabled");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            //$('#guardar').removeClass('ocultar').addClass('mostrar');
        });

        $('#actualizar').click(function() {
            $('#formu').formValidation('validate');
        });

        $('#guardar').click(function() {
            $('#formu').formValidation('validate');
        });
    });

    function editar(id){
		$("#formu").trigger("reset");
        //$('#guardar').removeClass('mostrar').addClass('ocultar');
        $('#actualizar').removeClass('ocultar').addClass('mostrar');
        var url='<?=base_url()?>index.php/pat/mostrar_niveles_recargado/'+id;
        var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
        var data = {id_documento:id};
        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
		if(val['valores']!="") {
			$("#id_nivel").val(val['valores'][0]['id_nivel']);
			$('#id_documento').val(val['valores'][0]['id_documento']);
			$('#nombre_nivel').val(val['valores'][0]['nombre_nivel']);
			$('#abreviacion').val(val['valores'][0]['abreviacion']);		
		}
		else {
			$('#id_documento').val(id);
		}
		
        $("#id_padre").select2("destroy");
		$("#id_padre").html(val['id_padre']);
		setTimeout(function(){				  
			$("#id_padre").select2({
				placeholder: "[Seleccione...]",
				allowClear: true
			});
		}, 250);
		$("#id_padre").removeAttr("disabled");
		if(val['valores']!="") {
			$("#id_padre").val(val['valores'][0]['id_padre']).trigger("change");
		}
		$("#formu").data('formValidation').resetForm();
        return false;
    }
</script>