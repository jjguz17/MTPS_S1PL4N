<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/libs/bootstrap-wizard.css">
<div class="col-lg-2 col-md-2 col-sm-2">    
</div>
<div class="col-lg-8 col-md-8 col-sm-8">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>PEI registrados</a>
                </div>
            </div>               
            <div class="project-box-content project-box-content-nopadding" id="conte-tabla">
                <table class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th class="all">Nombre</th>
                            <th class="all">Documento</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px" align="center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($documentos as $val) {
                                echo '<tr><td align="left">'.$val['nombre_pei'].'</td><td align="left"><a target="_blank" href="'.base_url().'documentos/'.$val['nombre_documento'].'" >'.$val['nombre_documento'].'</a></td><td><a title=\'Editar\' href=\'#\' onClick=\'editar_documento('.$val['id_documento'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="wizard-content">
</div>
<!--<div class="form-group">
    <label for="id_documento" class="col-sm-3 control-label">PEI</label>
    <div class="col-sm-8">
        <select class="form-control" name="id_documento" id="id_documento" data-placeholder="[Seleccione..]">
            <option value=""></option>
            <?php
                foreach($documentos as $val) {
                    echo '<option value="'.$val['id_documento'].'">'.$val['nombre_pei'].'</option>';
                }
            ?>
        </select>
    </div>
</div>-->
<script language="javascript" >	
    $(document).ready(function(){				
        /*$('#id_documento').select2();*/
        $('.footable').dataTable({'info': false});
    });

    function editar_documento(id){
		$('.wizard-modal').remove();
		$("#wizard-content").load(base_url()+"index.php/pei/wizard_pei/"+id);
        return false;
    }
</script>