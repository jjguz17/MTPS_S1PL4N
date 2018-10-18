<?php
if($exportacion==3) {
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$nombre.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	if($exportacion==2 || $exportacion==3) {
		if($exportacion==3) {
?>
    <table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
    	 <thead>
            <tr>
                <th align="left" id="imagen" height="110" colspan="2">
                    <img src="<?=base_url()?>img/mtps_report.jpg" />
                </th>
                <th align="center">
                    <strong class="ti">
                        MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
                        DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL Y EMPLEO<br />
                        DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL<br />
                        SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES<br /><br />
                        PROMOCIONES REALIZADAS POR TÉCNICO EDUCADOR
                    </strong>
                </th>
                <th align="right">
                    <img src="<?=base_url()?>img/escudo.min.gif" style="position:absolute; right:0"/>
                </th>
            </tr>
            <tr>
            	<th colspan="4" align="center">&nbsp;</th>
            </tr>
<?php
		}
		else {
?>
	<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
    	 <thead>
<?php
		}
?>
            <tr>
            	<?php
					$css='';
					if($exportacion==2 || $exportacion==3) {
						$css='background-color: #CCC; border: 1px solid #CCC;';
					}
				?>
                <th style="<?php echo $css;?>" width="25" valign="middle">N°</th>
                <th style="<?php echo $css;?>" width="200" valign="middle">SECCIÓN</th>
                <th style="<?php echo $css;?>" width="340" valign="middle">TÉCNICO EDUCADOR</th>
                <th style="<?php echo $css;?>" width="100" valign="middle">TOTAL</th>
            </tr>
        </thead>
<?php 
	}
	if($exportacion!=2 && $exportacion!=3) {
?>  
    <table class="display table responsive no-wrap" style="width: 100%;">
        <thead>
            <tr>
                <th class="all" width="50">N°</th>
                <th class="desktop">SECCIÓN</th>
                <th class="all">TÉCNICO EDUCADOR</th>
                <th class="desktop tablet-l tablet-p" style="width:95px;">TOTAL</th>
            </tr>
        </thead>
<?php 
	}
?> 
        <tbody>
            <?php
                foreach($info as $val) {
					
			?>
            	<tr>
                	<?php
						$css="";
                        if($exportacion==2 || $exportacion==3) {
							$css='border: 1px solid #CCC;';
                        }
                    ?>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['numero']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo ucwords($val['seccion'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo ucwords($val['nombre'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="right"><?php echo $val['total']?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
<?php if($exportacion==1) { ?>
<script>
	$('.table').DataTable({
		"sPaginationType": "simple",
		responsive: true
	});
	$("select").chosen({
		'width': '100%',
		'min-width': '100px',
		'white-space': 'nowrap',
		no_results_text: "Sin resultados!"
	});
</script>
<?php } ?>