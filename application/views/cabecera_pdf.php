<?php
	if($exportacion==3) {
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$titulo.' - PAT'.$anio." ".$periodo.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo '<style type="text/css">
			body {
				font-family: Arial, Helvetica, sans-serif;
			}
			img {
				width: 140px;
				height: auto;
				max-height: 90px;
				opacity: 0.65;
			}
			i {font-weight: normal; font-style: normal;}
			span {font-weight: normal; font-style: italic; font-size: 12px;}
			strong {font-style: italic;}
			table .table {width: 100%;border-collapse:collapse; border: 1px solid #ddd;}
			td {padding: 5px;}
			table .tr_odd td, table .tr_even td { border: 1px solid #ddd;}
			table tr td {font-size: 10px;}
			table .table tbody>tr>td {text-align: left;}
			table .tr_odd {background-color: white;}
			table .tr_even {background-color: white;}
			table .logro {text-align: right;}
			table .cab td {font-weight: bold !important;color: white !important}
			table .rowCab {background-color: aliceblue !important;}  
			table .cab1 td {background-color: #CBE9FF !important; color: #000000 !important;}  
			table .cab2 {background-color: #4EBFFF !important;}  
			table .cab3 {background-color: #00ABE6 !important;}  
			table .cab4 {background-color: #0097D5 !important;}  
			table .cab5 {background-color: #007CBD !important;}  
			table .cab6 {background-color: #006996 !important;}  
			table .cab7 {background-color: #005A86 !important;}  
			table .cab8 {background-color: #003F67 !important;}  
			table .cab9 {background-color: #002856 !important;}  
			table .cab10 {background-color: #001B3D !important;}  
        </style>';
	}
?>
<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
 	<thead>
        <tr>
            <th align="left" <?php if($exportacion==3) echo 'style="width:400px;"';?> height="110">
                <img src="<?=base_url()?>img/mtps_report.jpg" />
            </th>
            <th align="center" <?php if($exportacion==3) echo 'colspan="3"';?>>
            	<br />
                <i>MINISTERIO DE TRABAJO Y PREVISION SOCIAL</i><br />
                <strong class="ti">
                    <?=utf8_decode($titulo)?>
                </strong><br />
                <span><?=$periodo?></span>
            </th>
            <th align="right">
                <img src="<?=base_url()?>img/escudo.min.gif" style="position:absolute; right:0"/>
            </th>
        </tr>
        <tr>
            <th colspan="3" align="center">&nbsp;</th>
        </tr>
 	</thead>
</table>
<?=utf8_decode($tabla)?>