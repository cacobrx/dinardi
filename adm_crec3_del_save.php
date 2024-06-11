<?php
/*
 * Creado el 04/10/2020 17:46:22
 * Autor: gus
 * Archivo: adm_crec3_del_save.php
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
$adm=new adm_crec3_1($id);
$idcrec=$adm->getIdcrec();
$ssql="delete from adm_crec3 where id=$id";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("RECIBOS - Forma de Pago", $usr->getId(), "Elimina forma de pago del recibo ".$adm->getIdcrec()." / ".$adm->getDetalle()." / ".$adm->getImporte(), $centrosel);
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

