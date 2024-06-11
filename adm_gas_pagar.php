<?php
/*
 * Creado el 05/10/2020 12:27:52
 * Autor: gus
 * Archivo: adm_gas_pagar.php
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
$cantidad=$glo->getGETPOST("cantidadtotal");
$condicion="";
for($i=0;$i<$cantidad;$i++) {
    $chkpag="chkpag$i";
    $$chkpag=$glo->getGETPOST($chkpag);
    if($$chkpag>0) {
        $condicion.="id=".$$chkpag." or ";
    }
}
if($condicion!="") {
    $ssql="update adm_gas set fechapago='".date("Y-m-d")."', fechamod='".date("Y-m-d H:m:s")."' where ".substr($condicion,0,strlen($condicion)-4);
    $conx->getConsulta($ssql);
    $aud->regAud("GASTOS - Pagos", $usr->getId(), "Registra gastos del día", $centrosel);
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_gas_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

