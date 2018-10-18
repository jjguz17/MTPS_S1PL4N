<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
     <thead>
        <tr>
            <th style="background-color: #CCC; border: 1px solid #CCC;">LUGAR DE TRABAJO</th>
            <th style="background-color: #CCC; border: 1px solid #CCC;">FECHA VISITA</th>
            <th style="background-color: #CCC; border: 1px solid #CCC;">HORA VISITA</th>
            <th style="background-color: #CCC; border: 1px solid #CCC;" width="200">DIRECCIÓN</th>
            <th style="background-color: #CCC; border: 1px solid #CCC;">TIPO PROGRAMACIÓN</th>
            <th style="background-color: #CCC; border: 1px solid #CCC;">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($programaciones as $val) {
        ?>
            <tr>
                <td valign="middle" style="border: 1px solid #CCC;" align="left"><?php echo ucwords($val['nombre'])?></td>
                <td valign="middle" style="border: 1px solid #CCC;" align="center"><?php if($val['fecha']!="00/00/0000") echo $val['fecha']; else echo "&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;";?></td>
                <td valign="middle" style="border: 1px solid #CCC;" align="center"><?php if($val['hora']!="12:00 AM") echo $val['hora']; else echo "&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;";?></td>
                <td valign="middle" style="border: 1px solid #CCC;" align="left"><?php echo $val['direccion_lugar']."<br>".ucwords($val['municipio'])?></td>
                <td valign="middle" style="border: 1px solid #CCC;" align="left"><?php echo $val['tipo_programacion']?></td>
                <td valign="middle" style="border: 1px solid #CCC;" align="left"><?php echo $val['estado_programacion']?></td>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>