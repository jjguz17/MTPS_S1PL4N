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
          <label for="anio" class="col-sm-4 control-label">Año</label>
          <div class="col-sm-4">
            <select data-req="true" class="form-control" name="anio" id="anio" data-placeholder="[Seleccione..]" >
              <option value="0"></option>
              <?php
                $i=0;
                foreach($anios as $val) {
                  if($i==0)
                    echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
                  else
                    echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                  $i++;
                }
              ?>
            </select>
          </div>
        </div>            
        <div class="form-group">
          <label for="mes" class="col-sm-4 control-label">Mes</label>
          <div class="col-sm-5" id="cont-mes">
            <select data-req="true" class="form-control" name="mes" id="mes" data-placeholder="[Seleccione..]">
              <option value="0"></option>
              <?php
                foreach($meses as $val) {
                  if($val['id']==date('m'))
                    echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
                  else
                    echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                }
              ?>
            </select>
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
              <label for="ins">Resumen de informe</label>
            </div>
            <div class="rdio rdio-success">
              <input type="radio" name="radio" value="2" id="tec" disabled="disabled" />
              <label for="tec">&nbsp;&nbsp;&nbsp;</label>
            </div>
            <div class="rdio rdio-success">
              <input type="radio" name="radio" value="3" id="sec" disabled="disabled" />
              <label for="sec">&nbsp;&nbsp;&nbsp;</label>
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
    $('#anio').change(function(){
      $("#cont-mes").load(base_url()+"index.php/inicio/meses/"+$(this).val());
    });
    $('#buscar').click(function(){
      var ex=Number($('input:radio[name=radio2]:checked').val())
      if(ex>1) {
        var f1=String($("#anio").val());
        var f2=String($("#mes").val());
        var rep=$('input:radio[name=radio]:checked').val();
        window.open(base_url()+'index.php/inicio/resultados/'+f1+'/'+f2+'/'+rep+'/'+ex);
      }
      else
        ajax_html(base_url()+'index.php/inicio/resultados', $('#cont-resultados'), "", $('#formu').serialize())
    });
  });
</script>