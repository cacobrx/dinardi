<?php
/*
 * Creado el 04/10/2020 16:41:41
 * Autor: gus
 * Archivo: adm_crec3_add_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
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
$id=$glo->getGETPOST("id");
$indice=$glo->getGETPOST("indice");
$tipopago="tipopago$indice";
$idcht="idcht$indice";
$importe="importepago$indice";
$detalle="detallepago$indice";
$$tipopago=$glo->getGETPOST($tipopago);
$$idcht=$glo->getGETPOST($idcht);
$$importe=$glo->getGETPOST($importe);
$$detalle=$glo->getGETPOST($detalle);
if($$idcht=="") $$idcht=0; 
$clave=$sup->generateKey();
$ssql="select * from adm_crec3 where detallepago=".$$tipopago." and clave='$clave' and importe=".$$importe;
//echo $ssql."<br>";
if($conx->getCantidadReg($ssql)==0) {
    $ssql="insert into adm_crec3 (idcrec, detallepago, detalle, idcht, importe, clave) values ($id, ".$$tipopago.", '".$$detalle."', ".$$idcht.", ".$$importe.", '$clave')";
    $conx->getConsulta($ssql);
//    echo $ssql."<br>";
    $aud->regAud("RECIBOS - Forma de Pago", $usr->getId(), "Agrega nuevo forma de pago al recibo $id | ".$$detalle." / ".$$importe, $centrosel);
}
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

