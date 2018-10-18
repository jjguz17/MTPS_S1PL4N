<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="<?php echo base_url()?>css/style.default.css" rel="stylesheet">
    <script src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url()?>js/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo base_url()?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>js/modernizr.min.js"></script>
    <script src="<?php echo base_url()?>js/retina.min.js"></script>
    <script src="<?php echo base_url()?>js/custom.js"></script>
    <title>SRCS - Sistema de Registro de Comités de SSO</title>
</head>
<body style="background: #FFF;">
    <button style="display:none" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-static"></button>
    <div class="modal fade bs-example-modal-static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sistema Bloqueado</h4>
            </div>
            <div class="modal-body">
                Ha fallado en 3 intentos consecutivos, porfavor espere hasta la(s) <strong><?php echo date("h:i A",$_COOKIE['hora']); ?></strong> para volver a intentar acceder.
            </div>
        </div>
      </div>
    </div>
    <script language="JavaScript" type="text/javascript">
        $(".btn").click();
    </script>
</body>
</html>
			