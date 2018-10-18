<div class="col-md-4">
	<div class="panel panel-warning">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="11" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Filtros </h3>
        </div>
        <div class="panel-body">
  			<form name="formu" id="formu" class="form-horizontal" autocomplete="off">                
				<div class="form-group">
                    <label for="fecha_inicial" class="col-sm-4 control-label">Fecha inicio</label>
                    <div class="col-sm-6">
                    	<div class="input-group">
                            <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" value="<?php echo date('01/m/Y')?>" readonly="readonly">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      	</div>
                    </div>
                </div>            
				<div class="form-group">
                    <label for="fecha_final" class="col-sm-4 control-label">Fecha final</label>
                    <div class="col-sm-6">
                    	<div class="input-group">
                            <input type="text" class="form-control" id="fecha_final" name="fecha_final" value="<?php echo date('d/m/Y')?>" readonly="readonly">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      	</div>
                    </div>
                </div>
                
				<div class="row">                
               		<div class="col-md-4">
                    	<div class="form-group">
                    		<label class="col-sm-11 control-label">Reporte</label>
                		</div>
                    </div>
                	<div class="col-md-8">
                      	<div class="rdio rdio-success">
                        	<input type="radio" name="radio" value="1" id="ins" checked />
                        	<label for="ins">Comités capacitados</label>
                      	</div>
                      	<div class="rdio rdio-success">
                        	<input type="radio" name="radio" value="2" id="tec" />
                        	<label for="tec">Técnicos educadores</label>
                      	</div>
                      	<div class="rdio rdio-success">
                        	<input type="radio" name="radio" value="3" id="sec" />
                        	<label for="sec">Trabajadores capacitados</label>
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
                      	<div class="rdio rdio-danger">
                        	<input type="radio" name="radio2" value="1" id="pan" checked />
                        	<label for="pan">Pantalla</label>
                      	</div>
                      	<div class="rdio rdio-danger">
                        	<input type="radio" name="radio2" value="2" id="pdf" />
                        	<label for="pdf">PDF</label>
                      	</div>
                      	<div class="rdio rdio-danger">
                        	<input type="radio" name="radio2" value="3" id="cal" />
                        	<label for="cal">Hoja de cálculo</label>
                      	</div>
                	</div>
                </div>
                
                <ul class="pager wizard">
                    <li><button class="btn btn-default" type="button" name="buscar" id="buscar"><span class="fa fa-table"></span> Generar</button></li>
                    <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                </ul>
          	</form>
      	</div>
   	</div>
</div>
<div class="col-md-8">
	<div class="panel panel-warning">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="12" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Resultados </h3>
        </div>
        <div class="panel-body" id="cont-resultados">

      	</div>
   	</div>
</div>
<script>
	$(document).ready(function() {
		$('#fecha_inicial, #fecha_final').datepicker();
		$('#buscar').click(function(){
			var ex=Number($('input:radio[name=radio2]:checked').val())
			if(ex>1) {
				var f1=String($("#fecha_inicial").val());
				f1=f1.replace(/\//gi,"-");
				var f2=String($("#fecha_final").val());
				f2=f2.replace(/\//gi,"-");
				var rep=$('input:radio[name=radio]:checked').val();
				window.open(base_url()+'index.php/acreditacion/resultados/'+f1+'/'+f2+'/'+rep+'/'+ex);
			}
			else
				ajax_html(base_url()+'index.php/acreditacion/resultados', $('#cont-resultados'), "", $('#formu').serialize())
		});
	});
</script>