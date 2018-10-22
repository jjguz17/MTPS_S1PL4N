<div class="row">
    <div class="col-lg-9">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
            	<h4>Pensamiento Estratégico Institucional MTPS</h4>
            </header>
            <div class="main-box-body clearfix">
            	<!--<div class="col-md-4 col-sm-4 col-xs-12 pricing-package simple">-->
                <div class="col-md-12 col-sm-12 col-xs-12 pricing-package simple">
                    <!--<div class="pricing-package-inner">
                        <div class="package-header purple-bg">
                            <h3>Visión</h3>
                        </div>
                        <div class="package-content">-->
                            <div class="col-md-2 col-sm-2 col-xs-12 pricing-package simple">
                            	<h3>Visión</h3>
                           	</div>
                        	<div class="col-md-10 col-sm-10 col-xs-12 pricing-package simple">
                                <blockquote>
                                    <p>
                                        Ser una Institución que lidera el
                                        ámbito laboral, vinculada a la
                                        ciudadanía, que brinda servicios
                                        de calidad, con calidez, eficiencia,
                                        transparencia, teniendo como
                                        base la justicia social, la inclusión
                                        y la igualdad de género. 
                                    </p>
                                </blockquote>
                           	</div>
                        <!--</div>
                    </div>
               	</div>
            	<div class="col-md-5 col-sm-5 col-xs-12 pricing-package simple">
                    <div class="pricing-package-inner">
                        <div class="package-header green-bg">
                            <h3>Misión</h3>
                        </div>
                        <div class="package-content">-->
                            <div class="col-md-2 col-sm-2 col-xs-12 pricing-package simple pull-right">
                            	<h3>Misión</h3>
                           	</div>
                        	<div class="col-md-10 col-sm-10 col-xs-12 pricing-package simple">
                                <blockquote class="pull-right">
                                    <p>
                                        Somos la Institución rectora de
                                        la administración pública en
                                        materia de Trabajo y Previsión
                                        Social, fundamentalmente
                                        encargada de potenciar las
                                        relaciones laborales,
                                        sustentadas en el diálogo, la
                                        concertación social en un
                                        marco de equidad y justicia
                                        social.
                                    </p>
                                </blockquote>
                           	</div>
                        <!--</div>
                    </div>-->
               	</div>
                <style>
blockquote.pull-right:before {
  margin-left: 0;
  right: 25px;
}
.pricing-package {
  padding-top: 0px; padding-bottom: 0px;}</style>
</div></div></div>

                <div class="col-md-3 col-sm-12 col-xs-12 pricing-package simple">
                    <div class="pricing-package-inner">
                        <div class="package-header red-bg">
                            <h3>Valores</h3>
                        </div>
                        <div class="package-content" style="background-color: white;">
                            <ul class="package-features">
                                <li class="has-feature">
                                    Equidad
                                </li>
                                <li class="has-feature">
                                    Igualdad
                                </li>
                                <li class="has-feature">
                                    No Discriminación
                                </li>
                                <li class="has-feature">
                                    Honestidad
                                </li>
                                <li class="has-feature">
                                    Calidez
                                </li>
                                <li class="has-feature">
                                    Transparencia
                                </li>
                            </ul>
                        </div>
                    </div>

     <!--Código para poner un selector que muestre dashboard por año seleccionado-->
            <form action="index.php" method="post" name="fmanio">
                <label for="anio" class="form-control control-label"><b>Año a consultar</b></label>
                <select  class="form-control select" data-placeholder="[Seleccione..]" name="anio">
                <?php 
                $anio = ((isset($_REQUEST["anio"])) ? $_REQUEST["anio"] : date("Y"));
                for($i=$periodo["inicio_periodo"][0];$i<=$periodo["fin_periodo"][0];$i++)
                    echo '<option value="'.$i.'" '.(($i==$anio) ? 'selected' : '').' >'.$i.'</option>';
                ?>
                </select>
            </form>
               	</div>
                </div>


<?php
	$color[]="emerald";
	$color[]="gray";
	$color[]="purple";
	$color[]="emerald";
    $color[]="yellow";
	$e="#2ecc71";
	$b="#ffc107";
	$m="#e84e40";
	$i=-1;
	foreach($objetivos as $val) {
		$i++;
?>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="main-box clearfix project-box <?=$color[$i]?>-box">
                <div class="main-box-body clearfix">
                    <div class="project-box-header <?=$color[$i]?>-bg">
                        <div class="name">
                            <a href="javascript:;">
                                <?='..::'.$val['nombre_pei'].'::.. '.$val['correlativo_item']?>
                            </a>
                        </div>
                    </div>
                	<div class="col-lg-8 col-md-8 col-sm-8 vcenter">
                        <div class="project-box-content">
                            <div class="col-md-4"> 
                                <span class="chart" data-percent="<?=$val['M']?>" data-bar-color="<?php if($val['M']>=70) { if($val['M']>=95) { echo $e; } else { echo $b;  } } else { echo $m; } ?>">
                                    <span class="percent"></span>%<br/>
                                    <span class="lbl">Este Mes</span>
                                </span>
                            </div>
                            <div class="col-md-4"> 
                                <span class="chart" data-percent="<?=$val['T']?>" data-bar-color="<?php if($val['T']>=70) { if($val['T']>=95) { echo $e; } else { echo $b;  } } else { echo $m; } ?>">
                                    <span class="percent"></span>%<br/>
                                    <span class="lbl">Este Trimestre</span>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <span class="chart" data-percent="<?=$val['A']?>" data-bar-color="<?php if($val['A']>=70) { if($val['A']>=95) { echo $e; } else { echo $b;  } } else { echo $m; } ?>">
                                    <span class="percent"></span>%<br/>
                                    <span class="lbl"><?=date('Y')?></span>
                                </span>
                            </div>
                        </div>
                        <div class="project-box-footer clearfix">
                            <a href="#">
                                <span class="value"><?=$val['total']?></span>
                                <span class="label"><?=$val['nombre_nivel']?></span>
                            </a>
                            <a href="#">
                                <span class="value"><?=$val['total2']?></span>
                                <span class="label"><?=$val['nombre_nivel2']?></span>
                            </a>
                            <a href="#">
                                <span class="value"><?=$val['total3']?></span>
                                <span class="label"><?=$val['nombre_nivel3']?></span>
                            </a>
                        </div>
                    </div><!--
                    --><div class="col-lg-4 col-md-4 col-sm-4 vcenter"><br />
                        <blockquote>
                            <p><?=$val['descripcion_item']?></p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
<?php
	}
?>
<style>
.vcenter {
    display: inline-block !important;
    vertical-align: middle !important;
    float: none !important;
}
.pricing-package .package-features li {
  font-size: 1.25em;
}
</style>
<script>
window.onload = function()
{
    document.forms["fmanio"].anio.onchange = function()
    {
        document.forms["fmanio"].submit();
    }
}

	$(function() {
		$('.chart').easyPieChart({
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			},
			barColor: '#3498db',
			trackColor: '#f2f2f2',
			scaleColor: false,
			lineWidth: 8,
			size: 130,
			animate: 1500
		});
	});
</script>