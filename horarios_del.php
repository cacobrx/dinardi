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
require_once 'clases/horarios.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$id = $glo->getGETPOST("id");
$adm = new horarios_1($id);
$ssql="delete from horarios where id=$id";
//echo $ssql;
$conx->getConsulta($ssql);
$aud->regAud("HORARIOS", $usr->getId(), "Elimina Horario ".$adm->getId()." ".$adm->getFecha(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="horarios_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
