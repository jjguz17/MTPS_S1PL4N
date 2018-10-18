			<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 99999999;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Título</h4>
						</div>
						<div class="modal-body">
							Contenido
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
						</div>
					</div> 
				</div> 
			</div> 
			<div class="notification-shape shape-progress" id="notification-shape-loading-circle">
				<svg width="70px" height="70px"><path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/></svg>
			</div>
			<div class="md-overlay"></div> 
			
	        <script src="<?=base_url()?>js/bootstrap.js"></script>
	        <script src="<?=base_url()?>js/jquery.nanoscroller.min.js"></script>
	        <script src="<?=base_url()?>js/demo.js"></script>  
	         
	        <script src="<?=base_url()?>js/moment.min.js"></script>
	        <script src="<?=base_url()?>js/jquery-jvectormap-1.2.2.min.js"></script>
	        <script src="<?=base_url()?>js/jquery-jvectormap-world-merc-en.js"></script>
	        <script src="<?=base_url()?>js/gdp-data.js"></script>
	        <script src="<?=base_url()?>js/flot/jquery.flot.min.js"></script>
	        <script src="<?=base_url()?>js/flot/jquery.flot.resize.min.js"></script>
	        <script src="<?=base_url()?>js/flot/jquery.flot.time.min.js"></script>
	        <script src="<?=base_url()?>js/flot/jquery.flot.threshold.js"></script>
	        <script src="<?=base_url()?>js/flot/jquery.flot.axislabels.js"></script>
	        <script src="<?=base_url()?>js/jquery.sparkline.min.js"></script>
	        <script src="<?=base_url()?>js/skycons.js"></script> 
	        <script src="<?=base_url()?>js/wizard.js"></script>
	        <script src="<?=base_url()?>js/jquery.maskedinput.min.js"></script>
	        <script src="<?=base_url()?>js/bootstrap-datepicker.js"></script>

	        <script src="<?=base_url()?>js/select2.min.js"></script>
	        <script src="<?=base_url()?>js/dropzone.js"></script>

	        <script src="<?=base_url()?>js/fileinput.js" type="text/javascript"></script>
	        <script src="<?=base_url()?>js/fileinput_locale_es.js" type="text/javascript"></script>
	         
	        <script src="<?=base_url()?>js/scripts.js"></script>
	        <script src="<?=base_url()?>js/pace.min.js"></script>

	        <script src="<?=base_url()?>js/footable.js"></script>
	        <script src="<?=base_url()?>js/footable.sort.js"></script>
	        <script src="<?=base_url()?>js/footable.paginate.js"></script>
	        <script src="<?=base_url()?>js/footable.filter.js"></script>
	        <!---->
	        <script src="<?=base_url()?>js/modernizr.custom.js"></script>
	        <script src="<?=base_url()?>js/classie.js"></script>
	        <script src="<?=base_url()?>js/modalEffects.js"></script>
			<script src="<?=base_url()?>js/demo-skin-changer.js"></script> 

	        <script src="<?=base_url()?>js/modernizr.custom.js"></script>
	        <script src="<?=base_url()?>js/snap.svg-min.js"></script>  
	        <script src="<?=base_url()?>js/classie.js"></script>
	        <script src="<?=base_url()?>js/notificationFx.js"></script>

	        <script src="<?=base_url()?>js/jquery.dataTables.js"></script>
			<script src="<?=base_url()?>js/dataTables.fixedHeader.js"></script>
			<script src="<?=base_url()?>js/dataTables.tableTools.js"></script>
			<script src="<?=base_url()?>js/jquery.dataTables.bootstrap.js"></script>
            
            <script src="<?=base_url()?>js/jquery.nouislider.js"></script>
            <script src="<?=base_url()?>js/typeahead.min.js"></script>
            
            <script src="<?=base_url()?>js/jquery.nestable.js"></script>
			<script src="<?=base_url()?>js/bootstrap-editable.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>js/formValidation.js"></script>
    		<script type="text/javascript" src="<?=base_url()?>js/framework/bootstrap.js"></script>
            
            <script src="<?=base_url()?>js/jquery.easypiechart.min.js"></script>

	        <script src="<?=base_url()?>js/funciones.js"></script>

	        <script type="text/javascript">
	        $(document).ready(function(){
	        	$('#cont-pag').resize(function(){
	        		var h=$(this).height()+100;
	        		if(h<$(window).height())
	        			h=$(window).height();
	        		$('#content-wrapper').css({'min-height':h});
	        	})
	        	$('#cont-pag').resize();
	        });
	        </script>
        </body>
</html>