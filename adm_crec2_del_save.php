<?php
/*
 * Creado el 03/10/2020 17:24:31
 * Autor: gus
 * Archivo: adm_crec2_del_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_crec.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$val=$glo->getGETPOST("id");
$adm=new adm_crec2_1($val);
$idcrec=$adm->getIdcrec();
$ssql="delete from adm_crec2 where id=$val";
$conx->getConsulta($ssql);
$aud->regAud("RECIBOS - Comprobantes", $usr->getId(), "Elimina comprobante a aplicar del recibo ".$adm->getIdcrec()." / ".$adm->getComprobante()." / ".$adm->getFecha(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

