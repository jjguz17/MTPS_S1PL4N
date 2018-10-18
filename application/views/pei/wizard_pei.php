<style>
	.table a.table-link {margin: 0;}
	.select2-drop-mask {z-index: 9999;}
</style>
<div class="wizard" id="wizard-demo">
	<h1>Crear PEI</h1>
	<script type="text/javascript">
        var ab=[];
		var can=[];
		var ind=[];
    </script>
    <?php
		$band=-1;
		foreach($estructura as $val) {
			if($band==-1) {
				$band=$val['id_nivel'];
			}
	?>	
			<script type="text/javascript">
				ab[<?=$val['id_nivel']?>]="<?=$val['abreviacion']?>";
            </script>
    		<div class="wizard-card" data-cardname="name_<?=$val['id_nivel']?>">
            	<form class="formu" id="name_<?=$val['id_nivel']?>" data-change="0">
                    <h3 style="margin-top: 0 !important;" data-id_nivel="<?=$val['id_nivel']?>"><span><?=$val['nombre_nivel']?></span></h3>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <input type="hidden" class="form-control id_nivel" id="id_nivel_<?=$val['id_nivel']?>" name="id_nivel" value="<?=$val['id_nivel']?>"/>
                            <input type="hidden" class="form-control id_item" id="id_item_<?=$val['id_nivel']?>" name="id_item"/>
                        </div>
                    </div>
					<?php
						if($val['id_padre']!="") {
					?>	
                            <div class="wizard-input-section">
                                <div class="form-group">
                                    <label for="id_padre_<?=$val['id_nivel']?>" style="text-transform: capitalize;"><?=$nom_padre?> <font color="#FF0000">*</font></label>
                                    <select class="form-control select NewSelect ddd" name="id_padre" id="id_padre_<?=$val['id_nivel']?>" data-placeholder="[Seleccione..]" style="max-width: 150px;display: block;">
                                        <option value=""></option>
                                        <?php
                                            foreach($items as $val2) {
                                                if($val2['id_nivel']==$val['id_padre'])
                                                echo '<option value="'.$val2['id_item'].'">'.$val2['correlativo_item'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
					<?php
						}
						else {
					?>	
             				<input type="hidden" id="id_padre_<?=$val['id_nivel']?>" name="id_padre" value="NULL"/>
    				<?php
						}
					?>	
                   	<input type="hidden" id="id_padre_texto_<?=$val['id_nivel']?>" class="id_padre_texto" name="id_padre_texto" value=""/>
                    <div class="wizard-input-section">
                        <div class="form-group">
                        	<div class="form-group">
                                <label for="correlativo_item_<?=$val['id_nivel']?>" style="display: block;">Código <font color="#FF0000">*</font></label>
                                <div class="input-group">
                                    <input type="text" style="width: 150px;display: inline-block;" class="form-control correlativo" id="correlativo_item_<?=$val['id_nivel']?>" name="correlativo_item">
                                    <style type="text/css">
                                        .radio, .checkbox {
                                            margin-top: 0px;
                                            margin-bottom: 0px;
                                        }
                                        .input-group-btn {
                                            float: left;
                                        }
										.formu .dropdown-menu>li>a {
											padding-left: 10px;
										}
                                    </style>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Acciones <span class="caret"></span></button>
                                        <ul class="dropdown-menu">  
											<?php
                                                if($val['id_padre']!="") {
                                            ?>	                                  
                                                <li>
                                                    <a href="javascript:;">  
                                                        <div class="checkbox-nice" style="display: inline-block;">
                                                            <input type="checkbox" class="chk an" id="agrupar_numeracion_<?=$val['id_nivel']?>" name="agrupar_numeracion" <?=$val['agrupar_numeracion']?> value="1" />
                                                            <label for="agrupar_numeracion_<?=$val['id_nivel']?>" >Agrupar numeración por <?=$nom_padre?></label>
                                                        </div>
                                                    </a>
                                                </li>
                                           	<?php
												}
											?>	
                                            <li>
                                                <a href="javascript:;">  
                                                    <div class="checkbox-nice" style="display: inline-block;">
                                                        <input type="checkbox" class="chk as" id="agregar_separador_<?=$val['id_nivel']?>" name="agregar_separador" <?=$val['agregar_separador']?> value="1" />
                                                        <label for="agregar_separador_<?=$val['id_nivel']?>" >Agregar guion medio al código</label>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> 
                                    <?php
                                        if($val['id_padre']=="") {
                                    ?>	
                                            <input type="hidden" id="agrupar_numeracion_<?=$val['id_nivel']?>" name="agrupar_numeracion" value="1"/>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <label for="descripcion_item_<?=$val['id_nivel']?>">Descripción <font color="#FF0000">*</font></label>
                            <textarea class="form-control descripcion" id="descripcion_item_<?=$val['id_nivel']?>" name="descripcion_item"></textarea>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <label for="id_seccion_<?=$val['id_nivel']?>">Unidad responsable</label>
                            <select class="form-control select ccc NewSelect" name="id_seccion" id="id_seccion_<?=$val['id_nivel']?>" data-placeholder="[Seleccione..]" style="max-width: 100%;display: block;">
                                <option value=""></option>
                                <?php
                                    foreach($seccion as $val2) {
                                        echo '<option value="'.$val2['id_seccion'].'">'.$val2['nombre_seccion'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <button class="btn btn-success agregar ver" type="button" name="agregar" id="agregar_<?=$val['id_nivel']?>"><span class="fa fa-plus"></span> Agregar</button>
                            <button class="btn btn-info actualizar noVer" type="button" name="actualizar" id="actualizar_<?=$val['id_nivel']?>"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button>
                         	<button class="btn btn-warning limpiar" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button>
                       </div>
                    </div>
                    <table id="tabla_<?=$val['id_nivel']?>" class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                        <thead>
                            <tr>
                                <th class="all" style="width:120px">Código</th>
                                <th class="all">Descripción</th>
                                <th class="desktop tablet-l tablet-p" style="width:150px" align="center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>  
                </form>
            </div>
	<?php
			$nom_padre=$val['nombre_nivel_l'];
		}
	?>
	<div class="wizard-error">
		<div class="alert alert-error">
			<strong>There was a problem</strong> with your submission. Please correct the errors and re-submit.
		</div>
	</div>
	<div class="wizard-failure">
		<div class="alert alert-error">
			<strong>There was a problem</strong> submitting the form. Please try again in a minute.
		</div>
	</div>
	<div class="wizard-success">
		<div class="alert alert-success">
			<span class="create-server-name"></span>
			El proceso fue creado <strong> con éxito.</strong>
		</div>
		<a class="btn btn-default create-another-server">Modificar</a>
		<span style="padding:0 10px">o</span>
		<a class="btn btn-primary im-done">Terminar</a>
	</div>
</div>
<script src="<?=base_url()?>js/bootstrap-wizard.js"></script>
<script type="text/javascript">
	
	var id_nivel=<?=$band?>;
	var $NS;
	$(function() {	

        $('.formu').formValidation({
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
                id_padre: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                correlativo_item: {
                    icon: 'false',
                    validators: {
                        notEmpty: {
                            message: 'No debe quedar vacío'
                        }
                    }
                },
                descripcion_item: {
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
            var $form=$(this);
            var $tabla=$form.find('.footable');
            var idn=$form.find('.id_nivel').val();
            var url='<?=base_url()?>index.php/pei/guardar_item_wizard';
            var mensaje_correcto=" ***La petición se ha completado éxitosamente!";
            var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
            var data = new FormData($form[0]);
            ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
            if(val['id_item']!="") {
                $tabla.DataTable().ajax.url( '<?=base_url()?>index.php/pei/wizard_recargado2New/'+idn ).load();
				$form.find(".ccc").val("").trigger("change");
				$form.find(".id_item").val("");
				$form.find(".descripcion").val("");
				$form.find(".actualizar").removeClass("ver").addClass("noVer");
				$form.find(".agregar").removeClass("noVer").addClass("ver");
				$form.data('formValidation').resetForm();
				setTimeout(function() {
					correlativo();
				}, 500);
            }
            return false;
        }); 
		
		$(".limpiar").click(function(e){
			var $form=$(this).parents('.formu');
			$form.trigger("reset");
            $form.find(".ddd").val("").trigger("change");
			$form.find(".ccc").val("").trigger("change");
			$form.find(".id_item").val("");
			$form.find(".correlativo").val("");
			$form.find(".descripcion").val("");
			$form.find(".actualizar").removeClass("ver").addClass("noVer");
			$form.find(".agregar").removeClass("noVer").addClass("ver");
			$form.data('formValidation').resetForm();
        });

        $('.agregar').click(function() {
            var $form=$(this).parents('.formu');
            $form.formValidation('validate');
        }); 

        $('.actualizar').click(function() {
            var $form=$(this).parents('.formu');
            $form.formValidation('validate');
        });
		
		$('.ddd').change(function(){
            var $form=$(this).parents('.formu');
			if($(this).val()!="")
				try {
					$('.id_padre_texto').val($(this).select2('data').text);
				}
				catch(err) {
				}
			else
				$('.id_padre_texto').val("");
			//alert(!$form.find('.agregar').hasClass("ver"))
            if(!$form.find('.agregar').hasClass("ver"))
                setTimeout(function() {
                    //correlativo();
                }, 500);
		});
		
		$(".chk").click(function(){
			var $form=$(this).parents('.formu');
			var e1,e2;
			if($form.find('.an').is(':checked'))
				e1=1;
			else
				e1=0;
			if($form.find('.as').is(':checked'))
				e2=1;
			else
				e2=0;
			
			setTimeout(function() {
                    correlativo();
                }, 500);

			var url='<?=base_url()?>index.php/pei/actualizar_nivel2New/'+id_nivel+'/'+e1+'/'+e2;
			var mensaje_correcto=" ***La petición se ha completado éxitosamente!";
			var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
			ajax_json(url, mensaje_correcto, mensaje_incorrecto);
		});

		$.fn.wizard.logging = false;	
		var wizard = $("#wizard-demo").wizard({
			showCancel: false,
			buttons:{
				cancelText:"Cancelar",
				nextText:"Siguiente",
				backText:"Anterior",
				submitText:"Finalizar",
				submittingText:"Guardando..."
			}
		});		
		wizard.on("submit", function(wizard) {
			var submit = {
				"hostname": $("#new-server-fqdn").val()
			};
	
			setTimeout(function() {
				wizard.trigger("success");
				wizard.hideButtons();
				wizard._submitting = false;
				wizard.showSubmitCard("success");
				wizard.updateProgressBar(0);
			}, 1000);
		});		
		wizard.on("incrementCard", function(wizard) {
            //alert("incrementCard: "+id_nivel);
			var a=id_nivel;
			var $card=wizard.el.find(".active");
			id_nivel=$card.find("a").data("id_nivel");
			var b=id_nivel;
			if(b>a) {
				actualizar_tabla(a, b);
			}
            setTimeout(function() {
                    correlativo();
                }, 500);
		});		
		wizard.on("decrementCard", function(wizard) {
			var $card=wizard.el.find(".active");
			id_nivel=$card.find("a").data("id_nivel");
            setTimeout(function() {
                    correlativo();
                }, 500);
		});	
		
		$('a.wizard-nav-link').click(function(){
            //alert("a.wizard-nav-link: "+id_nivel);
			var a=id_nivel;
			var $p=$(this).parent('li');
			if($p.hasClass("active") || $p.hasClass("already-visited")) {
				id_nivel=$(this).data("id_nivel");
			}
			var b=id_nivel;
			if(b>a) {
				actualizar_tabla(a, b);
			}
            setTimeout(function() {
                    correlativo();
                }, 500);
            //alert("a.wizard-nav-link: "+id_nivel);
		});		
		wizard.on("reset", function(wizard) {
			wizard.setSubtitle("");
			wizard.el.find("#new-server-fqdn").val("");
			wizard.el.find("#new-server-name").val("");
		});	
		wizard.el.find(".wizard-success .im-done").click(function() {
			wizard.reset().close();
			$('.wizard-nav-link').click();
		});	
		wizard.el.find(".wizard-success .create-another-server").click(function() {
			wizard.reset();
			$('.wizard-nav-link').click();
		});
		wizard.show();
        $NS=$(".NewSelect").select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        }); 

        $NS.on("change", function(e){
            var $form=$(this).parents('.formu');
            if($(this).val()!="")
                try {
                    $('.id_padre_texto').val($(this).select2('data').text);
                }
                catch(err) {
                }
            else
                $('.id_padre_texto').val("");
            //alert("s "+$form.find('.agregar').hasClass("ver"))
			//alert("r "+!$form.find('.agregar').hasClass("ver"))
            if($form.find('.agregar').hasClass("ver"))
                setTimeout(function() {
                    //alert();
                    correlativo();
                }, 500);
        });
		$('.footable').DataTable({
			'info': false,
			"bSort":false,
			"fnDrawCallback": function() {
				var oSettings = this.fnSettings();
				var iTotalRecords = oSettings.fnRecordsTotal();
				can[id_nivel]=iTotalRecords;    
			},
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                var uid = String(aData[0]);
				var res = uid.split(".", 1);
				var res2 = uid.split(res+".");
				if(isNaN(ind[res2]))
					ind[res2]=1
				else
                	ind[res2]=Number(ind[res2])+1;
            }       
		});
		$('#tabla_'+<?=$band?>).DataTable().ajax.url( '<?=base_url()?>index.php/pei/wizard_recargado2New/'+<?=$band?> ).load();
		
		setTimeout(function() {
			correlativo();
		}, 500);
	});
    
    var dd;

    function eliminar_msg(e, id_item)
    {     
        dd=e; 
        $("#modal .modal-title").html("Eliminar registro");
        $("#modal .modal-body").html("¿Realmente desea eliminar este registro? Tenga en cuenta que una vez borrado no lo podrá recuperar y todos los registros heredados también se perderán.");
        $("#modal .btn-success").attr("onClick","eliminar("+id_item+")");
    }

    function eliminar(id_item)
    {
        var $form=$(dd).parents('.formu');
        var $tabla=$form.find('.footable');
        var idn=$form.find('.id_nivel').val();
        var url='<?=base_url()?>index.php/pei/eliminar_itemNew/'+id_item;
        var mensaje_correcto=" ***La petición se ha completado éxitosamente!";
        var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
        ajax_json(url, mensaje_correcto, mensaje_incorrecto);
        $tabla.DataTable().ajax.url( '<?=base_url()?>index.php/pei/wizard_recargado2New/'+idn ).load();
    }

    function editar(e, id_item)
    {
		var $form=$(e).parents('.formu');
		$form.find(".agregar").removeClass("ver").addClass("noVer");
		$form.find(".actualizar").removeClass("noVer").addClass("ver");
        var url='<?=base_url()?>index.php/pei/editar_itemNew/'+id_item;
        var mensaje_correcto="boxspinner***La petición se ha completado éxitosamente!";
        var mensaje_incorrecto="boxspinner***Error en la peticitión! Se perdió la conexión a la red";
        ajax_json(url, mensaje_correcto, mensaje_incorrecto);
		$form.find(".ccc").val(val['valores'][0]['id_seccion']).trigger("change");
		$form.find(".id_item").val(val['valores'][0]['id_item']);
		$form.find(".correlativo").val(val['valores'][0]['correlativo_item']);
		$form.find(".descripcion").val(val['valores'][0]['descripcion_item']);
		$form.find(".ddd").val(val['valores'][0]['id_padre']).trigger("change");/*
		$form.find(".agregar").removeClass("ver").addClass("noVer");
		$form.find(".actualizar").removeClass("noVer").addClass("ver");*/
		$('.id_padre_texto').val(val['valores'][0]['id_padre_texto']);
    }

	function edit_presupuesto_row(e, id_item, correlativo) {
		var $form=$(e).parents('.formu');
		$("#modal .modal-title").html('Presupuesto Indicativo Plurianual de <b>'+correlativo+'</b>');
		$("#modal .modal-body").html("");
		$("#modal .modal-body").load(base_url()+"index.php/pei/presupuesto/"+id_item);
		$("#modal .btn-success").attr("onClick","guardar_presupuesto();return false;");
	}
	
	function actualizar_tabla(a, b) {
		var i;
		for(i=a;i<b;i++) {		
			$("#id_padre_"+(i+1)).load(base_url()+"index.php/pei/wizard_recargado/"+i);
			$("#id_padre_"+(i+1)).select2({
				placeholder: "[Seleccione...]",
				allowClear: true
			});
			$("#id_padre_"+(i+1)).val("").trigger("change");
			$("#id_padre_"+(i+1)).parents(".formu").data('formValidation').resetForm();
			$('#tabla_'+(i+1)).DataTable().ajax.url( '<?=base_url()?>index.php/pei/wizard_recargado2New/'+(i+1) ).load();
		}
	}
	
	function guardar_activo()
	{
		/*
		* Lo pongo solo para que no me de error, tengo que eliminar la llamada que hace el wizard
		*/
	}
	
	function correlativo()
	{
		//alert("AAA")
        setTimeout(function(){
			
			var $form=$("#id_padre_"+id_nivel).parents('.formu');
			var cant=1;
			if(!$form.find('.agregar').hasClass("ver")) 
				 cant=cant+1;

            if($("#id_padre_"+id_nivel).val()!="" && $("#id_padre_"+id_nivel).val()!="NULL") {
                a=ab[id_nivel];
                if($('#agregar_separador_'+id_nivel).is(':checked')) {
                    a=a+"-";
                }   
                if($('#agrupar_numeracion_'+id_nivel).is(':checked')) {
                    a=a+(Number($("#tabla_"+id_nivel+" td:contains('"+$("#id_padre_"+id_nivel).select2('data').text+"')").length)+cant);
                }   
                else {
                    a=a+(Number(can[id_nivel])+cant);  
                }  
                $("#correlativo_item_"+id_nivel).val(a);
                setTimeout(function() {
                    $('.id_padre_texto').val($("#id_padre_"+id_nivel).select2('data').text);
                }, 500);            
            }
            else {
                if($("#id_padre_"+id_nivel).val()=="NULL") {
                    a=ab[id_nivel];
                    if($('#agregar_separador_'+id_nivel).is(':checked')) {
                        a=a+"-";
                    }       
                    a=a+(Number(can[id_nivel])+cant);  
                    $("#correlativo_item_"+id_nivel).val(a);
                }
                else {
                    $("#correlativo_item_"+id_nivel).val("");
                }
                $('.id_padre_texto').val("");
            }

        }, 300);
	}
</script>