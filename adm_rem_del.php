<?php
/*
 * Creado el 21/01/2019 21:04:57
 * Autor: gus
 * Archivo: adm_rem_del.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_rem.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$id = $glo->getGETPOST("id");
$adm = new adm_rem_1($id);
$ssql="delete from adm_rem where id=$id";
//echo $ssql;
$conx->getConsulta($ssql);
$aud->regAud("REMITOS DE ENTRADA", $usr->getId(), "Elimina remito ".$adm->getId()." ".$adm->getFecha()." ".$adm->getProveedor()." ".$adm->getTotal(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_rem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
