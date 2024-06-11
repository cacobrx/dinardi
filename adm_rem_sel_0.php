<?php
/*
 * Creado el 08/12/2020 20:32:15
 * Autor: gus
 * Archivo: adm_rem_sel0.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$ssql="update adm_rem set seleccion=0";
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_rem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

