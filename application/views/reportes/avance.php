<style type="text/css">
    .form-horizontal .radio {
      padding-bottom: 7px;
      padding-top: 0;
      text-align: left;
    }
	.table tbody>tr>td {text-align: left;}
	.tr_odd {background-color: white;}
	.tr_even {background-color: white;}
	.logro {text-align: right;}
	.cab td {font-weight: bold !important;color: white !important}
	.rowCab {background-color: aliceblue !important;}
	.cab1 td {background-color: #CBE9FF !important; color: #000000 !important;}
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
<div class="col-lg-4 col-md-4 col-sm-4">
    <div class="main-box clearfix project-box yellow-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header yellow-bg">
                <div class="name">
                    <a>Filtros</a>
                </div>
            </div>               
            <form target="_blank" name="formu" id="formu" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/reportes/crear_reporte" autocomplete="off">                  
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="row">
                                	<div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="id_documento" class="col-sm-4 control-label">PEI</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select" name="id_documento" id="id_documento" data-placeholder="[Seleccione..]">
                                                    <option value=""></option>
                                                    <?php
                                                        foreach($documentos as $val) {
                                                            if($val['inicio_periodo']<=date('Y'))
                                                            	echo '<option value="'.$val['id_documento'].'">'.$val['nombre_pei'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                 	</div>
                               	</div> 
                                <div class="row">
                                    <?php
                                        if($id_permiso==3) {
                                    ?>
                                        	<div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="unidad_lider" class="col-sm-4 control-label">Unidad organizativa</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control select" name="unidad_lider" id="unidad_lider" data-placeholder="[Seleccione..]" disabled="disabled">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                     		</div>
                                    <?php
                                        }
                                    ?>
                               	</div> 
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="anio" class="col-sm-4 control-label">Año</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select" name="anio" id="anio" data-placeholder="[Seleccione..]" disabled="disabled">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                                <div class="row">                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-11 control-label">Intervalo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="radio radio-success">
                                            <input type="radio" name="radio" value="1" id="men" checked />
                                            <label for="men">Mensual</label>
                                        </div>
                                        <div class="radio radio-success">
                                            <input type="radio" name="radio" value="2" id="tri" />
                                            <label for="tri">Trimestral</label>
                                        </div>
                                        <div class="radio radio-success">
                                            <input type="radio" name="radio" value="3" id="anu" />
                                            <label for="anu">Anual</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="mes" class="col-sm-4 control-label">Período</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select" name="mes" id="mes" data-placeholder="[Seleccione..]">
                                                    <option value=""></option>
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
                                                        for ($im=0; $im < 12; $im++) {
															if(($im+1)==date('m')) {
                                                            	echo '<option value="'.($im+1).'" selected="selected">'.$me[$im].'</option>';
															}
															else {
                                                            	echo '<option value="'.($im+1).'">'.$me[$im].'</option>';
															}
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                     
                                <div class="row">                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-11 control-label">Exportación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="radio radio-danger">
                                            <input type="radio" name="radio2" value="1" id="pan" checked />
                                            <label for="pan">Pantalla</label>
                                        </div>
                                        <div class="radio radio-danger">
                                            <input type="radio" name="radio2" value="2" id="pdf" />
                                            <label for="pdf">PDF</label>
                                        </div>
                                        <div class="radio radio-danger">
                                            <input type="radio" name="radio2" value="3" id="cal" />
                                            <label for="cal">Hoja de cálculo</label>
                                        </div>
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
                        <li><button class="btn btn-default" type="button" name="generar" id="generar"><span class="fa fa-table"></span> Generar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
                </div>  
            </form>
        </div>
    </div>
</div>
<div class="col-lg-8 col-md-8 col-sm-8">
    <div class="main-box clearfix project-box yellow-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header yellow-bg">
                <div class="name">
                    <a>Resultados</a>
                </div>
            </div>               
            <div class="project-box-content project-box-content-nopadding" id="tabla">
            </div>  
        </div>
    </div>
</div>
<script language="javascript" >
	
	var m='<option value=""></option><option value="1" <?php if(date('m')==1)echo "selected"?>>Enero</option><option value="2" <?php if(date('m')==2)echo "selected"?>>Febrero</option><option value="3" <?php if(date('m')==3)echo "selected"?>>Marzo</option><option value="4" <?php if(date('m')==4)echo "selected"?>>Abril</option><option value="5" <?php if(date('m')==5)echo "selected"?>>Mayo</option><option value="6"" <?php if(date('m')==6)echo "selected"?>>Junio</option><option value="7" <?php if(date('m')==7)echo "selected"?>>Julio</option><option value="8" <?php if(date('m')==8)echo "selected"?>>Agosto</option><option value="9" <?php if(date('m')==9)echo "selected"?>>Septiembre</option><option value="10" <?php if(date('m')==10)echo "selected"?>>Octubre</option><option value="11" <?php if(date('m')==11)echo "selected"?>>Noviembre</option><option value="12" <?php if(date('m')==12)echo "selected"?>>Diciembre</option>';
	var t='<option value=""></option><option value="13" <?php if(date('m')>=1 && date('m')<=3)echo "selected"?>>1er Trimestre</option><option value="14" <?php if(date('m')>=4 && date('m')<=6)echo "selected"?>>2do Trimestre</option><option value="15" <?php if(date('m')>=7 && date('m')<=9)echo "selected"?>>3er Trimestre</option><option value="16" <?php if(date('m')>=10 && date('m')<=12)echo "selected"?>>4to Trimestre</option>';

    $(document).ready(function(){

        $('#myWizard').wizard();
        $('#id_documento').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });    
        $('#mes').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        }); 
        $('#anio').select2({
            placeholder: "[Seleccione...]",
            allowClear: true
        });

        <?php
            if($id_permiso==3) {
        ?>                
            $('#unidad_lider').select2({
                placeholder: "[Seleccione...]",
                allowClear: true
            });   

            $("#id_documento").change(function(){
                if($(this).val()!="") {
                    var url='<?=base_url()?>index.php/reportes/buscar_unidad_documento/'+$(this).val();
                    var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                    var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                    var data = {id_documento:$(this).val()};
                    ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             
                    $("#unidad_lider").select2("destroy");
                    $("#unidad_lider").html(val['unidad_lider']);
                    setTimeout(function(){                
                        $("#unidad_lider").select2({
                            placeholder: "[Seleccione...]",
                            allowClear: true
                        });
                    }, 250);
					$("#anio").select2("destroy");
                    $("#anio").html(val['anios']);
                    setTimeout(function(){                
                        $("#anio").select2({
                            placeholder: "[Seleccione...]",
                            allowClear: true
                        });
                    }, 250);
                    $("#anio").removeAttr("disabled");
                    $("#unidad_lider").removeAttr("disabled");
                }
                else {
                    $("#unidad_lider").select2("destroy");
                    $("#unidad_lider").html('<option value=""></option>');
                    $("#unidad_lider").val('').trigger("change");
                    $("#anio").val('').trigger("change");
                    setTimeout(function(){                
                        $("#unidad_lider").select2({
                            placeholder: "[Seleccione...]",
                            allowClear: true
                        });
                    }, 250);
                    $("#anio").attr("disabled","disabled");
                    $("#unidad_lider").attr("disabled","disabled");
                }
            });   
        <?php
            }
			else {
        ?>   
				$("#id_documento").change(function(){
                if($(this).val()!="") {
                    var url='<?=base_url()?>index.php/reportes/buscar_unidad_documento/'+$(this).val();
                    var mensaje_correcto=" ***Los datos se han cargado con éxito!";
                    var mensaje_incorrecto=" ***Error en la peticitión! Se perdió la conexión a la red";
                    var data = {id_documento:$(this).val()};
                    ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);             

					$("#anio").select2("destroy");
                    $("#anio").html(val['anios']);
                    setTimeout(function(){                
                        $("#anio").select2({
                            placeholder: "[Seleccione...]",
                            allowClear: true
                        });
                    }, 250);
                    $("#anio").removeAttr("disabled");
                }
                else {
                    $("#anio").val('').trigger("change");
                    setTimeout(function(){                
                        $("#unidad_lider").select2({
                            placeholder: "[Seleccione...]",
                            allowClear: true
                        });
                    }, 250);
                    $("#anio").attr("disabled","disabled");
                }
            });   
        <?php
            }
        ?>
		
		$("#tri").click(function(){
			$("#mes").html(t);
			$("#mes").select2({
				placeholder: "[Seleccione...]",
				allowClear: true
			});
            $("#mes").removeAttr("disabled");
		});
		
		$("#men").click(function(){
			$("#mes").html(m);
			$("#mes").select2({
				placeholder: "[Seleccione...]",
				allowClear: true
			});
            $("#mes").removeAttr("disabled");
		});
		
		$("#anu").click(function(){
			$("#mes").html('<option value=""></option>');
			$("#mes").select2({
				placeholder: "[Seleccione...]",
				allowClear: true
			});
			$("#mes").attr("disabled","disabled");
		});

        $("#limpiar").click(function(e){
			$("#formu").trigger("reset");
			$("#id_documento").val("").trigger("change");
            $("#mes").val("").trigger("change");
        });

        $('#generar').click(function() {
			if($("#pan").is(":checked")) {			
				var url='<?=base_url()?>index.php/reportes/crear_reporte';
				var mensaje_correcto="boxspinner***El reporte se ha generado éxitosamente!";
				var mensaje_incorrecto="boxspinner***Error en la generación del reporte! No deben quedar campos vacíos";
				var data = new FormData($("#formu")[0]);
				ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
				$("#tabla").html(val['tabla']);
			}
			else {
				$("#formu").submit();
			}
        });
    });
</script>
