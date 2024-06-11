<?php
/*
 * Creado el 23/01/2021 13:25:26
 * Autor: gus
 * Archivo: adm_crec_pag_del.php
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
$idrec=$glo->getGETPOST("idrec");
$id=$glo->getGETPOST("id");
$adm=new adm_crec3_1($id);
$idcrec=$adm->getIdcrec();
$ssql="delete from adm_crec3 where id=$id";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("RECIBOS - Forma de Pago", $usr->getId(), "Elimina forma de pago del recibo ".$adm->getIdcrec()." / ".$adm->getDetalle()." / ".$adm->getImporte(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_det.php" method="post">
            <input name="idrec" id="idrec" value="<?= $idrec?>" type="hidden" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

