<?php
/*
 * Creado el 03/10/2020 17:29:54
 * Autor: gus
 * Archivo: adm_crec2_add_save.php
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
require_once 'clases/adm_fis.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$indice=$glo->getGETPOST("indice");
$idfis="idfis$indice";
$$idfis=$glo->getGETPOST($idfis);
$fis=new adm_fis_1($$idfis);
$clave=$sup->generateKey();
$ssql="select * from adm_crec2 where idfis=".$$idfis." and clave='$clave'";
if($conx->getCantidadReg($ssql)==0) {
    $importe=$fis->getTotaltotal();
//    echo "importe: $importe<br>";
    $ssql="insert into adm_crec2 (idcrec, idfis, importe, importepago, clave) values ($id, ".$$idfis.", $importe, $importe, '$clave')";
    $conx->getConsulta($ssql);
    $aud->regAud("RECIBOS - Comprobantes", $usr->getId(), "Agrega nuevo comprobante aplicado ".$$idfis." / $importe", $centrosel);
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

