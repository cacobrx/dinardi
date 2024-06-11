<?php
/*
 * Creado el 23/01/2019 12:37:05
 * Autor: gus
 * Archivo: adm_crm_del.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_crm.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$id = $glo->getGETPOST("id");
$adm = new adm_crm_1($id);
$ssql="delete from adm_crm_det where idcrm=$id";
$conx->getConsulta($ssql);
$ssql = "delete from adm_crm where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("CONTROL DE REMITOS", $usr->getId(), "Elimina control de remito ".$adm->getId()." ".$adm->getRemito(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crm_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
