<?php
/*
 * Creado el 15/03/2016 15:54:41
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: test_afip_c
 */

//require_once 'user.php';
//require_once 'clases/planb_config.php';
require_once 'afip.php';
require_once 'globalson.php';
$glo = new globalson();
//$cfg=new planb_config_1($centrosel);
$TipoComp=$glo->getGETPOST("TipoComp");
$PtoVta=$glo->getGETPOST("PtoVta");
$nro=$glo->getGETPOST("nro");
$fiscalcuit="33712475159";
//$afip=new WsFE();
echo "tipocomp: $TipoComp<br>";
echo "PtoVta: $PtoVta<br>";
echo "Nro: $nro<br>";
echo "Cuit: $fiscalcuit<br>";
$afip=new consulta_Afip($TipoComp, $PtoVta, $nro, $fiscalcuit);
//$afip->CmpConsultar($TipoComp, $PtoVta, $nro, $cbte);
$xx=$afip->getRet();
echo "===============<br>";
print_r($xx);
echo "===============<br>";
echo $xx->CbteFch;
?>
