<style>
	small strong, .sender strong {
		color:#F0AD4E !important;
	}
	ul, ul li .sender, .sender strong {
		font-size: 16px !important;
	}
	ul li small, small strong {
		font-size: 14px !important;
	}
	.widget-messaging ul li {
		border-top: 1px solid #eee !important;
	}
  .feed li i {
  font-size: 2.875em;
  color: black;
}
.feed li .img {
  padding-right: 0px;
  padding-left: 10px;
}
</style>
<div class="col-md-3"></div>
<div class="col-lg-6 col-md-6 col-sm-6">
  <div class="main-box clearfix project-box red-box">
    <div class="main-box-body clearfix">
      <div class="project-box-header red-bg">
          <div class="name">
              <a>Resultados Búsqueda</a>
          </div>
      </div> 
      <div class="project-box-content project-box-content-nopadding">

        <div class="main-box feed">
          <header class="main-box-header clearfix">
            <h2 class="pull-left"><?php echo "".count($resultados)." resultado(s) encontrado(s) en la búsqueda de '".$buscar."'" ?></h2>
          </header>
          <div class="main-box-body clearfix">
            <ul style="text-align: left;">
              <?php
                foreach($resultados as $val) {
              ?>
                  <li class="clearfix">
                    <div class="img">
                      <a title="Ir a <?php echo $val['nombre']?>" href="<?php echo base_url()."index.php/".$val['url'] ?>"><i class="glyphicon glyphicon-share" stye="font-size: 1.25em; !important;"></i></a>
                    </div>
                    <div class="title">
                      <a href="<?php echo base_url()."index.php/".$val['url'] ?>"><?php echo $val['nombre']?></a> - <?php echo $val['padre'] ?>
                    </div>
                    <div class="post-time">
                      <?php echo $val['descripcion'] ?>
                    </div>
                  </li>
              <?php
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>