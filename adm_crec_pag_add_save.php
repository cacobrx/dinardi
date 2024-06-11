<?php
/*
 * Creado el 23/01/2021 12:15:32
 * Autor: gus
 * Archivo: adm_crec_pag_add_save.php
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
$idrec=$glo->getGETPOST("idrec");
$detallepago=$glo->getGETPOST("detallepago");
$detalle=$glo->getGETPOST("detalle");
$importe=$glo->getGETPOST("importe");
$idcht=$glo->getGETPOST("idcht");
if($idcht=="") $idcht=0;
if($importe=="") $importe=0;
//$ssql="update adm_crec3 set detallepago=$detallepago, detalle='$detalle', importe=$importe, idcht='$idcht' where id=$id";
$ssql="insert into adm_crec3 (detallepago, detalle, importe, idcht, idcrec) values ($detallepago, '$detalle', $importe, $idcht, $idrec)";
$conx->getConsulta($ssql);
$aud->regAud("DETALLE PAGO CLIENTE", $usr->getId(), "Agrega detalle pago $idrec | $detalle | $importe", $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_det.php" method="post">
            <input name="idrec" type="idrec" value="<?= $idrec?>" type="hidden" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

