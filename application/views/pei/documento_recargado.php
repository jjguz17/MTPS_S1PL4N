<!--<div class="filter-block pull-right">
    <div class="form-group pull-left" style="margin-bottom: 0px;">
        <input type="text" id="filter" class="form-control" placeholder="Buscar...">
        <i class="fa fa-search search-icon"></i>
    </div>
</div>-->
<table class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
    <thead>
        <tr>
            <th class="all">Año</th>
            <th class="all">Nombre</th>
            <th class="desktop tablet-l tablet-p" style="width:100px" align="center">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($documentos as $val) {
           		echo '<tr><td align="left">'.$val['A'].'</td><td align="left"><a target="_blank" href="'.base_url().'documentos/'.$val['nombre_documento'].'" >'.$val['nombre_documento'].'</a></td><td><a title=\'Editar\' href=\'#\' onClick=\'editar('.$val['id_documento'].');return false;\'  class=\'table-link edit-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a><a title=\'Eliminar\' data-toggle=\'modal\' href=\'#modal\' onClick=\'eliminar('.$val['id_documento'].');return false;\'  class=\'table-link delete-row\' data-id=\''.$val['id_documento'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a></td></tr>';
                //echo '<tr><td align="left">'.$val['A'].'</td><td align="left"><a target="_blank" href="'.base_url().'documentos/'.$val['nombre_documento'].'" >'.$val['nombre_documento'].'</a></td><td><a href="#" onClick="editar('.$val['id_documento'].');return false;" class="edit-row" data-id="'.$val['id_documento'].'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="modal" href="#modal" onClick="eliminar('.$val['id_documento'].');return false;" class="delete-row" data-id="'.$val['id_documento'].'"><i class="fa fa-trash-o"></i></a></td></tr>';
            }
        ?>
    </tbody>
</table>
<script language="javascript">
    $(document).ready(function(){
        $('.footable').dataTable({'info': false});
    });
</script>