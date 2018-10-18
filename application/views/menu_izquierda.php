<div id="page-wrapper" class="nav-small container">
	<div class="row">
		<div id="nav-col">
			<section id="col-left" class="col-left-nano">
				<div id="col-left-inner" class="col-left-nano-content">
                    <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
						<ul class="nav nav-pills nav-stacked">
                            <li class="nav-header nav-header-first hidden-sm hidden-xs">
                           		Navegaci&oacute;n
                            </li>
                            <?php
								foreach($menus as $m){
									if($m[id_padre]=="") {
										$class='';
										$href=base_url().'index.php/'.$m[url_modulo];
										$imag=$m[img_modulo];
										$titu='<span>'.$m[nombre_modulo].'</span>';
										$desc=$m[descripcion_modulo];
										$child='';
										$band=false;
										foreach($menus as $sm){
											$class2='';
											if($sm[dependencia]==$m[id_modulo]) {
												if($menu_actual['id_modulo']==$sm[id_modulo]) {
													$band=true;
													$class2='class="active"';
												}
												$class='dropdown-toggle';
												$href='#';
												$child.='<li '.$class2.'><a href="'.base_url().'index.php/'.$sm[url_modulo].'">'.$sm[nombre_modulo].'</a></li>';
											}
										}
										if($menu_actual['id_modulo']==$m[id_modulo] || $band)
											$class=$class.' active';
										if($class!='') 
											$class='class="'.$class.'"';
										if($child!='') 
											$child='<ul class="submenu">'.$child.'</ul>';
							?>
										<li title="<?php echo $desc?>"><a href="<?php echo $href?>" <?php echo $class?>><i class="<?php echo $imag?>"></i> <?php echo $titu?></a><?php echo $child?></li>
							<?php
												
									}
								}
							?>
						</ul>
					</div>
				</div>
			</section>
            <div id="nav-col-submenu"></div>
        </div>
        <div id="content-wrapper">
            <div id="cont-pag" class="row">
            	<div class="col-lg-12">
            		<div class="row">
            			<div class="col-lg-12">
            				<div id="content-header" class="clearfix">
            					<div class="pull-left">
            						<ol class="breadcrumb">
                                        <?php
											if($menu_actual['nombre_modulo_padre']!="") {
												$url_padre=explode("/",$menu_actual['url_modulo_padre']);
										?>
												<li><a href="<?php echo base_url().'index.php/'.$url_padre[0] ?>"><?php echo $menu_actual['nombre_modulo_padre'] ?></a></li>
										<?php
											}
										?>	
                                        <li class="active"><span><?php echo $menu_actual['nombre_modulo'] ?></span></li>
                                        <li class="active" style="font-weight: normal;"><span><?php echo $menu_actual['descripcion_modulo'] ?></span></li>
                                    </ol>
                                	<h1><?php echo $menu_actual['nombre_modulo'] ?></h1>
            					</div>
            					<div class="pull-right hidden-xs">
            						<div class="xs-graph pull-left">
            							<div class="graph-label">
           								</div>
            						</div>
            					</div>
            				</div>
                        </div>
                    </div>