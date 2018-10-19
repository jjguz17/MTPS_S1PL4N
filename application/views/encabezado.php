<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>        
        <title>SIPLAN | Sistema de Planificación </title>
        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/bootstrap/bootstrap.min.css"/>
        <script src="<?=base_url()?>js/demo-rtl.js"></script>

        <script src="<?=base_url()?>js/prueba.js"></script>

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/nanoscroller.css"/>
         
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/compiled/theme_styles.css"/>

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/nifty-component.css"/>
        
        <link rel="stylesheet" href="<?=base_url()?>css/compiled/wizard.css" type="text/css">        
        <link rel="stylesheet" href="<?=base_url()?>css/libs/jquery-jvectormap-1.2.2.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>css/libs/weather-icons.css" type="text/css"/>

        <link rel="stylesheet" href="<?=base_url()?>css/libs/dropzone.css" type="text/css">
        <link rel="stylesheet" href="<?=base_url()?>css/libs/datepicker.css" type="text/css"/> 
        <link rel="stylesheet" href="<?=base_url()?>css/libs/daterangepicker.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>css/libs/bootstrap-timepicker.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>css/libs/select2.css" type="text/css"/>

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-default.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-style-growl.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-style-bar.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-style-attached.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-style-other.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/ns-style-theme.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/jquery.nouislider.css">

        <link rel="stylesheet" href="<?=base_url()?>css/fileinput.css" media="all" type="text/css" />
        <link rel="stylesheet" href="<?=base_url()?>css/libs/footable.core.css" type="text/css"/>
        
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/bootstrap-editable.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/formValidation.css"/>
         
        <link type="image/x-icon" href="<?=base_url()?>img/favicon.png" rel="shortcut icon"/>
         
        <!--<link href='<?=base_url()?>css/fontsgoogleapis.css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>-->
        <!--[if lt IE 9]>
                <script src="<?=base_url()?>js/html5shiv.js"></script>
                <script src="<?=base_url()?>js/respond.min.js"></script>
            <![endif]-->
      	<style>
			#config-tool {width: 350px;}
			#config-tool.closed {right: -350px;}
			.rtl #config-tool.closed {left: -350px;}
			#footer-bar {height: auto;line-height: 15px;}
			#sidebar-nav .nav li .submenu>li>a {padding-left: 55px;font-size: 0.8em;}
            .wizard .wizard-inner .actions {z-index: 1;}
            #sidebar-nav .nav>li>a>span {margin-left: 25px;font-size: 0.75em;font-weight: 100;}
            .select2-container .select2-choice {margin: -2px;text-align: left;}
            .has-error .select2-container .select2-choice {border-color: #e84e40 !important;}
            .has-success .select2-container .select2-choice {border-color: #8bc34a !important;}
            
            .has-success .form-control {border-color: #e7ebee !important;}
            .has-success .select2-container .select2-choice {border-color: #e7ebee !important;}
            .has-success .form-control:focus {border-color: #e7ebee !important;box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 6px #e7ebee !important;}
            .has-success .input-group-addon {border-color: #e7ebee !important;background-color: white !important;color: #555 !important;}
			.has-success .help-block, .has-success .control-label {color: black !important;}
			
            .select2-container {padding: 0;}
            .asterisk {color: red;}
            .project-box-content-nopadding {padding: 5px !important;}
            .ocultar {display: none;}
            .mostrar {display: inline-block;}
            .shape-progress path {stroke: #003940;}
            .ns-effect-loadingcircle{width:350px !important;}
            #header-navbar .profile-dropdown>a>img {display: none;}
            #mayuda h5 {color: #e84e40;font-weight: bold;}
            #mayuda .tab-pane {font-size: 12px;}
            .table tbody>tr>td:first-child {font-size: 12px;font-weight: 300;}
            .table tbody>tr>td {padding: 5px;}
            textarea {resize:none;}
			.editable-container.editable-inline {position: absolute;top: 0px;z-index: 1;}
			.editable-container.editable-inline button {font-size: 7px;}
			.editable-container.editable-inline .editable-buttons {font-size: 7px;padding-top: 3px;}
            .file-caption { text-align: left !important}
            .cnl {float: right;top: -2px;padding-left: 0px;z-index: 0;margin-left: 5px;}
            .nested-link {font-size: 18px;}
			.breadcrumb>.active {margin: 0;}
			.breadcrumb>li span {padding-left: 0;}
			a.wizard-nav-link {line-height: 25px;margin: 10px 0;}
			.modal {z-index: 9999;}
			.ver {display: inline-block !important;}
			.noVer {display: none !important;}
			.notification-shape {z-index: 9999999999999999;}
			.select2-drop-multi {z-index: 9999999999999999;}
            .select2-container.select2-container-multi .select2-search-choice-close {top: 6px;}
			.project-box .project-box-header.green-bg .name a:hover {background: initial;}
            .select2-container.select2-container-disabled .select2-choice {cursor: not-allowed;background-color: #eee !important;opacity: 1;}
            @media (max-width: 800px) {
                .project-box-content-nopadding {padding: 30px 20px 5px !important;}
            }
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
		<script src="<?=base_url()?>js/jquery.js"></script>

        <script type="text/javascript">
			var val;
            function base_url() {
                return "<?php echo base_url()?>";
            }
        </script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/nestable.css">
	</head>
	<body class="theme-red fixed-header fixed-leftmenu pace-done">