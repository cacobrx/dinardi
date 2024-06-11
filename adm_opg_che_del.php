<?php
/*
 * Creado el 22/06/2020 09:40:01
 * Autor: gus
 * Archivo: adm_opg_che_del.php
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
require_once 'clases/adm_opg2.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$idop=$glo->getGETPOST("idop");
$opg2=new adm_opg2_1($id);
$ssql="delete from adm_opg2 where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("O/PAGO - DETALLE DE PAGO", $usr->getId(), "Elimina detalle de pago #$idop | ".$opg2->getDetalle()."|".$opg2->getImporte(),$centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_act.php" method="post">
            <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
            <input name="tarea" id="tarea" type="hidden" value="M" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

