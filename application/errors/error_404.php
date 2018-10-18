<?php
    $url="http://localhost/sipat/";
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>        
        <title>SIPAT | Sistema de Planificación Anual de Trabajo</title>
        
        <link rel="stylesheet" type="text/css" href="<?=$url?>css/bootstrap/bootstrap.min.css"/>
        <script src="<?=$url?>js/demo-rtl.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=$url?>css/libs/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="<?=$url?>css/libs/nanoscroller.css"/>
         
        <link rel="stylesheet" type="text/css" href="<?=$url?>css/compiled/theme_styles.css"/>
         
        <link rel="stylesheet" href="<?=$url?>css/libs/daterangepicker.css" type="text/css"/>
        <link rel="stylesheet" href="<?=$url?>css/libs/jquery-jvectormap-1.2.2.css" type="text/css"/>
        <link rel="stylesheet" href="<?=$url?>css/libs/weather-icons.css" type="text/css"/>
         
        <link type="image/x-icon" href="<?=$url?>img/favicon.png" rel="shortcut icon"/>
         
        <!--<link href='<?=$url?>css/fontsgoogleapis.css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>-->
        <!--[if lt IE 9]>
                <script src="<?=$url?>js/html5shiv.js"></script>
                <script src="<?=$url?>js/respond.min.js"></script>
            <![endif]-->
      	<style>
			#config-tool{width:350px;}
			#config-tool.closed{right:-350px;}
			.rtl #config-tool.closed{left:-350px;}
			#footer-bar {height: auto;line-height: 15px;}
			@media (max-width: 400px) {
				#config-tool{width:300px;}
				#config-tool.closed{right:-300px;}
				.rtl #config-tool.closed{left:-300px;}
			}
			@media (max-width: 350px) {
				#config-tool{width:270px;}
				#config-tool.closed{right:-270px;}
				.rtl #config-tool.closed{left:-270px;}
			}
		</style>
     	<script src="<?=$url?>js/demo-skin-changer.js"></script>  
		<script src="<?=$url?>js/jquery.js"></script>
        <script src="<?=$url?>js/bootstrap.js"></script>
        <script src="<?=$url?>js/jquery.nanoscroller.min.js"></script>
        <script src="<?=$url?>js/demo.js"></script>  
         
        <script src="<?=$url?>js/moment.min.js"></script>
        <script src="<?=$url?>js/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?=$url?>js/jquery-jvectormap-world-merc-en.js"></script>
        <script src="<?=$url?>js/gdp-data.js"></script>
        <script src="<?=$url?>js/flot/jquery.flot.min.js"></script>
        <script src="<?=$url?>js/flot/jquery.flot.resize.min.js"></script>
        <script src="<?=$url?>js/flot/jquery.flot.time.min.js"></script>
        <script src="<?=$url?>js/flot/jquery.flot.threshold.js"></script>
        <script src="<?=$url?>js/flot/jquery.flot.axislabels.js"></script>
        <script src="<?=$url?>js/jquery.sparkline.min.js"></script>
        <script src="<?=$url?>js/skycons.js"></script>
         
        <script src="<?=$url?>js/scripts.js"></script>
        <script src="<?=$url?>js/pace.min.js"></script>
	</head>

    <body id="error-page">
        
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div id="error-box">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="error-box-inner">
                                    <img src="<?=$url?>img/error-404-v3.png" alt="Have you seen this page?"/>
                                </div>
                                <h1>ERROR 404</h1>
                                <p>
                                    La página que estás buscando no se ha encontrado!<br/>
                                    La página que estás buscando puede que se haya quitado, cambiado de nombre o no está disponible.
                                </p>
                                <p>
                                    al vez usted podría intentar una búsqueda:
                                </p>
                                <div class="row"> 
                					<div class="col-xs-4">
                                    </div>
                					<div class="col-xs-4">
                                        <form action="<?php echo $url."index.php/usuarios/buscar"?>" method="post" autocomplete="off">
                                			<div class="row"> 
                								<div class="col-xs-8">
                                                    <input type="text" class="form-control" placeholder="Búsqueda de la página" /> 
                                    			</div>
                								<div class="col-xs-4">
                                                    <button class="btn btn-success">Buscar</button>
                                    			</div>
                                			</div>
                                        </form>
                                	</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </body>
</html>