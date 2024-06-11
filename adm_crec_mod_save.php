<?php
/*
 * Creado el 04/10/2020 21:19:00
 * Autor: gus
 * Archivo: adm_crec_mod_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$numero=$glo->getGETPOST("numero");
$fecha=$glo->getGETPOST("fecha");
$idcli=$glo->getGETPOST("idcli");
$concepto=$glo->getGETPOST("concepto");
$id=$glo->getGETPOST("id");
if($numero=="") $numero=0;
$ssql="update adm_crec1 set fecha='$fecha', idcli=$idcli, numero=$numero, concepto='$concepto' where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("RECIBOS DE CLIENTE", $usr->getId(), "Modifica recibo $id | $fecha | $idcli | $numero", $centrosel);
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

