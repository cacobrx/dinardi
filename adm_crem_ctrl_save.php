<?php
/*
 * Creado el 18/10/2019 15:52:43
 * Autor: gus
 * Archivo: adm_crem_ctrl_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_crem.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_crem_1($id);
if($adm->getControlado()==1) {
    $ssql="update adm_crem set controlado=0 where id=$id";
    $descri="Remito $id no controlado";
} else {
    $ssql="update adm_crem set controlado=1 where id=$id";
    $descri="Remito $id controlado";
}
$conx->getConsulta($ssql);
//echo $ssql;    
$aud->regAud("REMITOS CLIENTES", $usr->getId(), $descri, $centrosel);
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

