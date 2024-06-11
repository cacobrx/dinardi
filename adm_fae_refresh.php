<?php
/*
 * Creado el 28/01/2020 15:43:06
 * Autor: gus
 * Archivo: adm_fae_refresh.php
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
$idcrm=$glo->getGETPOST("idcrm");
$ssql="delete from adm_fae_det where idcrm=$idcrm";
$conx->getConsulta($ssql);
$aud->regAud("RESUMEN DE FAENA", $usr->getId(), "Refresca control de faena #$idcrm", $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fae_main.php" method="post">
            <input name="idcrm" id="idcrm" type="hidden" value="<?= $idcrm?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

