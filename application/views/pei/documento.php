<style>
	.table a.table-link {margin: 0;}
</style>
<script type="text/javascript">
    var count=-1;
</script>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>Datos del documento</a>
                </div>
            </div>               
            <form name="formu" id="formu" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/pei/guardar_documento" autocomplete="off">                  
                <input type="hidden" id="id_documento" name="id_documento">
                <input type="hidden" id="count" name="count">
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="wizard-inner">
                            <ul class="steps">
                                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Datos Generales<span class="chevron"></span></li>
                                <li data-target="#step2"><span class="badge badge-primary">2</span>Estructura<span class="chevron"></span></li>
                            </ul>
                            <div class="actions">
                                <button type="button" class="btn btn-default btn-mini btn-prev"> <i class="icon-arrow-left"></i><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-success btn-mini btn-next" data-last=""><i class="fa fa-chevron-right"></i><i class="icon-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="form-group">
                                    <label for="nombre_pei" class="col-sm-3 control-label">Nombre PEI <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nombre_pei" name="nombre_pei">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_aprobacion" class="col-sm-3 control-label">Fecha aprobación <span class="asterisk">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="userfile" class="col-sm-3 control-label">Documento <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="file" id="userfile" name="userfile">
                                        <div id="errorBlock" class="help-block"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="observacion" class="col-sm-3 control-label">Período <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="slider-range"></div>
										<span class="slider-label"></span>
                                        <input type="hidden" id="inicio_periodo" name="inicio_periodo">
                                        <input type="hidden" id="fin_periodo" name="fin_periodo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="observacion" class="col-sm-3 control-label">Observaciones </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" data-req="true" id="observacion" name="observacion"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="step-pane" id="step2">
                                <br/>
                                <textarea style="display: none" name="lista" id="nestable2-output" class="form-control" rows="3"></textarea>
                                <div class="form-group">
                                    <!--<label for="nombre_pei" class="col-sm-3 control-label">Estructura <span class="asterisk">*</span></label>-->
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-10 dd" id="nestable3">
                                        <ol id="ls" class="dd-list">
                                            <li class="dd-item dd3-item" data-id="Proceso 1" data-ind="false" data-abr="P1">
                                                <div class="dd-handle dd3-handle">Drag</div>
                                                <div class="dd3-content">
                                                    <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">Proceso 1</a>
                                                    <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">P1</a><a>)</a>
                                                    <div class="nested-links">
                                                        <a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
                                                        <a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                        <div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                            <input type="checkbox" id="checkbox-1" onclick="cambiarIndicador(this)" />
                                                            <label for="checkbox-1"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
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
                                echo '<tr><td align="left">'.$val['A'].'</td><td align="left"><a target="_blank" href="'.base_url().'documentos/'.$val['nombre_documento'].'" >'.$val['nombre_documento'].'</a></td><td><a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_documento'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a><a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar('.$val['id_documento'].');return false;\'  class=\'table-link delete-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a></td></tr>';
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
	$('#guardar').removeClass('ocultar').addClass('mostrar');
	
    var n=2; 
	var nom="";

    var updateOutput = function(e){
        count=count+1;
        $('#count').val(count);
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            try {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            }
            catch(err) {
            }
        } 
        else {
            output.val('JSON browser support required for this demo.');
        }
    };

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
                nombre_pei: {
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
                fecha_aprobacion: {
                    trigger: 'change',
                    icon: 'false',
                    validators: {                        
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        },
                        regexp: {
                            regexp: /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/,
                            message: 'Debe escribir la fecha con formato dd/mm/yyyy'
                        }
                    }
                }/*,
                userfile: {
                    trigger: 'change',
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                }*/
            }
        })
        .on('success.form.fv', function(e) {
            event.preventDefault();
            var url='<?=base_url()?>index.php/pei/guardar_documento';
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
            $("#conte-tabla").load(base_url()+"index.php/pei/documento_recargado");
            $(this).trigger("reset");
            $("#id_documento").val("");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');
            $("#step2").load(base_url()+"index.php/pei/estructura_recargado/0");
            n=2;
            $('.slider-range').val([<?=date('Y')?>, <?=date('Y')+5?>], true);
            $("#formu").data('formValidation').resetForm();
            return false;
        });        

        //toggle `popup` / `inline` mode
        $.fn.editable.defaults.mode = 'inline';     
        
        //make username editable
        $('.editable').editable();

        $('#nestable3').nestable({
            group: 1
        })
        .on('change', updateOutput);
    
        // output initial serialised data
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));

        $("#userfile").fileinput({
            'showPreview' : false,
            'showUpload' : false,
            'allowedFileExtensions' : ['pdf'],
            'elErrorContainer': '#errorBlock'
        });
		
        $('#myWizard').wizard();
        $('#id_clasificacion').select2();
        $('#fecha_aprobacion').datepicker({
            format: 'dd/mm/yyyy',
			endDate: Date()
        });
        $('.footable').dataTable({'info': false});

        /*$("#formu").submit(function(event){
            event.preventDefault();
            var url='<?=base_url()?>index.php/pei/guardar_documento';
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
            $("#conte-tabla").load(base_url()+"index.php/pei/documento_recargado");
            $(this).trigger("reset");
			$("#id_documento").val("");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');
            $("#step2").load(base_url()+"index.php/pei/estructura_recargado/0");
            n=2;
			$('.slider-range').val([<?=date('Y')?>, <?=date('Y')+5?>], true);
            return false;
        });*/

        $("#limpiar").click(function(e){
			$("#id_documento").val("");
            $('#actualizar').removeClass('mostrar').addClass('ocultar');
            $('#guardar').removeClass('ocultar').addClass('mostrar');
            $("#step2").load(base_url()+"index.php/pei/estructura_recargado/0");
            n=2;
			$('.slider-range').val([<?=date('Y')?>, <?=date('Y')+5?>], true);
            $("#formu").data('formValidation').resetForm();
        });
		
		$('.slider-range').noUiSlider({
			range: [2014, <?=date('Y')+15?>],
			start: [<?=date('Y')?>, <?=date('Y')+5?>],
			step: 1,
			connect: true,
			slide: function(){
				var values = $(this).val();				
				$(this).next('span').text(
				 	Math.round(values[0]) + ' - ' + Math.round(values[1])
				);
				$('#inicio_periodo').val(Math.round(values[0]));
				$('#fin_periodo').val(Math.round(values[1]));
			},
			set: function(){
				var values = $(this).val();				
				$(this).next('span').text(
					Math.round(values[0]) + ' - ' + Math.round(values[1])
				);
				$('#inicio_periodo').val(Math.round(values[0]));
				$('#fin_periodo').val(Math.round(values[1]));
			}
		});
		$('.slider-range').val([<?=date('Y')?>, <?=date('Y')+5?>], true);

        $('#actualizar').click(function() {
            $('#formu').formValidation('validate');
        });

        $('#guardar').click(function() {
            $('#formu').formValidation('validate');
        });
    });

    function editar(id){
        count=-1;
        $("#formu").trigger("reset");
        $("#formu").data('formValidation').resetForm();
        $('#guardar').removeClass('mostrar').addClass('ocultar');
        $('#actualizar').removeClass('ocultar').addClass('mostrar');
        var url='<?=base_url()?>index.php/pei/buscar_documento/'+id;
        var mensaje_correcto="boxspinner***Los datos se han cargado con éxito!";
        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
        var data = {id_documento:id};
        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
        $('#id_documento').val(val['valores'][0]['id_documento']);
        $('#nombre_pei').val(val['valores'][0]['nombre_pei']);
        $('.file-caption-name').html('<span class="glyphicon glyphicon-file kv-caption-icon"></span>'+val['valores'][0]['nombre_documento']);
        $('#fecha_aprobacion').val(val['valores'][0]['fecha_aprobacion']);
        $('#observacion').val(val['valores'][0]['observacion']);
		var i=val['valores'][0]['inicio_periodo'];
		var f=val['valores'][0]['fin_periodo'];
		$('.slider-range').val([i, f], true);
        $("#step2").load(base_url()+"index.php/pei/estructura_recargado/"+val['valores'][0]['id_documento']);
        return false;
    }

    function eliminar(id){
        var titulo="Alerta";
        var mensaje="¿Realmente desea eliminar este registro? Tenga en cuenta que una vez borrado no lo podrá recuperar y todos los registros heredados también se perderán.";
        var url="<?=base_url()?>index.php/pei/eliminar_documento/"+id;
        confirmacion(titulo, mensaje, url);
        setTimeout( '$("#conte-tabla").load(base_url()+"index.php/pei/documento_recargado");', 2000);
        return false;
    } 
    
    function add_proceso(e)
    {
        var $li=$(e).parents('.nested-links').parent('.dd3-content').parent('li');
        if($li.find('.dd-list:first').length==0) {
            var newOl='<ol class="dd-list"></ol>';
            $li.append(newOl);
        }
        var newItem='<li class="dd-item dd3-item" data-id="Proceso '+n+'" data-ind="false" data-abr="P'+n+'">'+
            '<div class="dd-handle dd3-handle">Drag</div>'+
            '<div class="dd3-content">'+
                '<a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">Proceso '+n+'</a> '+
                '<a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">P'+n+'</a><a>)</a>'+
                '<div class="nested-links">'+
                    '<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a> '+
                    '<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>'+
                    '<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">'+
                        '<input type="checkbox" id="checkbox-'+n+'" onclick="cambiarIndicador(this)" /> '+
                        '<label for="checkbox-'+n+'"></label>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</li>';
        $li.find('.dd-list:first').append(newItem);
        n++;
        $('.editable').editable();
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    }
    
    function del_proceso(e)
    {
        var $li=$(e).parents('.nested-links').parent('.dd3-content').parent('li');
        /*if($('#ls').children('li').length>1) {
            $li.remove();
            alert($('ls').children('li').length)
        }
        else{alert($('ls').children('li').length)}*/
        $li.remove();
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    }
    
    function cambiarId(e)
    {        
		if(nom!=$(e).val())
        	count=count-2;
		else
        	count=count-1;
        var $li=$(e).parents('li:first');
        $li.data("id",$(e).val())
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    }
    
    function cambiarAbr(e)
    {   
		if(nom!=$(e).val())
        	count=count-2;
		else
        	count=count-1;
        var $li=$(e).parents('li:first');
        $li.data("abr",$(e).val())
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    }

    function cambiarIndicador(e)
    {   
       	count=count-2;
        var $li=$(e).parents('li:first');
        $li.data("ind",e.checked)
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    }
	
	function conteo(e)
	{
        nom=$(e).val();
	}
</script>