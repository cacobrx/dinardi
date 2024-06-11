<?php
/*
 * Creado el 01/06/2018 22:48:21
 * Autor: gus
 * Archivo: adm_crem_del_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/auditoria.php';
require_once 'clases/pedidos.php';
require_once 'clases/conexion.php';
$aud = new registra_auditoria();
$sup = new support();
$conx=new conexion();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$adm=new pedidos_1($id);
$ssql="delete from pedidos where id=$id";
$conx->getConsulta($ssql);
$ssql="delete from pedidos_det where idped=$id";
$conx->getConsulta($ssql);
$aud->regAud("REMITOS ELIMINA", $usr->getId(), "Elimina Pedido #$id | ".$adm->getFecha()." | ".$adm->getTotal(), $centrosel, $adm->getCentro());
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

