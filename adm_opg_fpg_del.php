<?php
/*
 * Creado el 09/11/2018 15:21:09
 * Autor: gus
 * Archivo: adm_opg_fpg_del.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_opg2.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$id = $glo->getGETPOST("id");
$adm = new adm_opg2_1($id);
$ssql = "delete from adm_opg2 where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("O.PAGO - DETALLE DE PAGO", $usr->getId(), "Elimina Detalle de Pago " . $adm->getId() . " | " . $adm->getDetalle(). " | ".$adm->getImporte(), $centrosel);
if($adm->getIdcht()>0) {
    $ssql="update adm_cht set entregado='' where id=".$adm->getIdcht();
    $conx->getConsulta($ssql);
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_det.php" method="post">
            <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
