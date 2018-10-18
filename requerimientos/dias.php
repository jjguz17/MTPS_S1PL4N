<?php
	function habiles($mes,$anno){
	   $habiles = 0; 
	   // Consigo el número de días que tiene el mes mediante "t" en date()
	   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $anno));
	   // Hago un bucle obteniendo cada día en valor númerico, si es menor que 
	   // 6 (sabado) incremento $habiles
	   for($i=1;$i<=$dias_mes;$i++) {
	       if (date("N", mktime(0, 0, 0, $mes, $i, $anno))<6) $habiles++;

	       if($habiles==5) return $i.'/'.$mes.'/'.$anno;
	   }

	   return $i.'/'.$mes.'/'.$anno;
	}
	echo habiles("07","2015");
?>