<?php
/*
 * Creado el 03/07/2019 11:54:52
 * Autor: gus
 * Archivo: adm_config_fiscal_save.php
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
$fiscalpuntoventa=$glo->getGETPOST("fiscalpuntoventa");
$fiscalpuntoventafce=$glo->getGETPOST("fiscalpuntoventafce");
$fiscalfantasia=$glo->getGETPOST("fiscalfantasia"); 
$fiscalnombre=$glo->getGETPOST("fiscalnombre");    
$fiscalactivo=$glo->getGETPOST("fiscalactivo");
$fiscalcuit=$glo->getGETPOST("fiscalcuit");
$fiscaliibb=$glo->getGETPOST("fiscaliibb");
$fiscaliva=$glo->getGETPOST("fiscaliva");
$fiscaldireccion=$glo->getGETPOST("fiscaldireccion");
$fiscalciudad=$glo->getGETPOST("fiscalciudad");
$fiscaltelefono=$glo->getGETPOST("fiscaltelefono");
$fiscalmail=$glo->getGETPOST("fiscalmail");
$fiscalcopia=$glo->getGETPOST("fiscalcopia");
$fiscalformato=$glo->getGETPOST("fiscalformato");
$fiscalfechainicio=$glo->getGETPOST("fiscalfechainicio");
$fiscalfacturadirecta=$glo->getGETPOST("fiscalfacturadirecta");
$fiscalresponsable=$glo->getGETPOST("fiscalresponsable");
$cbu=$glo->getGETPOST("cbu");
$aliascbu=$glo->getGETPOST("aliascbu");
$fiscalcargo=$glo->getGETPOST("fiscalcargo");
if($fiscalpuntoventa=="") $fiscalpuntoventa=0;
if($fiscalactivo=="") $fiscalactivo=0;
if($fiscalfacturadirecta=="") $fiscalfacturadirecta=0;
$ssql="update planb_config set fiscalpuntoventa=$fiscalpuntoventa, fiscalfantasia='$fiscalfantasia', fiscalnombre='$fiscalnombre', fiscalpuntoventafce=$fiscalpuntoventafce, ";
$ssql.="fiscalactivo=$fiscalactivo, fiscalcuit='$fiscalcuit', fiscaliibb=$fiscaliibb, fiscaliva='$fiscaliva', fiscaldireccion='$fiscaldireccion', ";
$ssql.="fiscalciudad='$fiscalciudad', fiscaltelefono='$fiscaltelefono', fiscalmail='$fiscalmail', fiscalcopia=$fiscalcopia, fiscalresponsable='$fiscalresponsable', fiscalcargo='$fiscalcargo', ";
$ssql.="fiscalformato=$fiscalformato, fiscalfechainicio='$fiscalfechainicio', fiscalfacturadirecta=$fiscalfacturadirecta, cbu='$cbu', aliascbu='$aliascbu' where id=$centrosel";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_config_fiscal.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

