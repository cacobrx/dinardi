<?php
/*
 * Creado el 15/03/2016 15:54:41
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: test_afip_c
 */

require_once 'user.php';
require_once 'clases/planb_config.php';
require_once 'afip.php';
require_once 'clases/globalson.php';
$glo = new globalson();
$cfg=new planb_config_1($centrosel);
$TipoComp=$glo->getGETPOST("TipoComp");
$PtoVta=$cfg->getFiscalpuntoventa();
$nro=$glo->getGETPOST("nro");
$fiscalcuit=$cfg->getFiscalcuit();
echo "CUIT: $fiscalcuit<br>";
echo "PtoVenta: $PtoVta<br>";
echo "Número: $nro<br>";
echo "TipoComp: $TipoComp<br>";
//$afip=new WsFE();
$afip=new consulta_Afip($TipoComp, $PtoVta, $nro, $fiscalcuit);
//$afip->CmpConsultar($TipoComp, $PtoVta, $nro, $cbte);
$xx=$afip->getRet();
echo "===============<br>";
print_r($xx);
echo "===============<br>";
echo $xx->CbteFch;
?>
