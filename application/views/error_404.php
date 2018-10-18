<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="error-box">
                <div class="row">
                    <div class="col-xs-12">
                        <div id="error-box-inner">
                        	<img src="img/error-404-v3.png" alt="Have you seen this page?"/>
                        </div>
                        <h1>ERROR 404</h1>
                        <p>
                            La página que estás buscando no se ha encontrado!<br/>
                            La página que estás buscando puede que se haya quitado, cambiado de nombre o no está disponible.
                        </p>
                        <p>
                        	al vez usted podría intentar una búsqueda: 
                            <form action="<?php echo base_url()."index.php/usuarios/buscar"?>" method="post"  autocomplete="off">
                                <input type="text" class="form-control" placeholder="Búsqueda de la página" /> 
                                <button class="btn btn-success">Buscar</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$('body').attr("id","error-page");
</script>