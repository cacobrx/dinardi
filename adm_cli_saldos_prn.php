<?
/*
 * Creado el 25/03/2013 12:44:38
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: hps_kit_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/clientes.php';
require_once 'impresion/adm_cli_saldos_prn.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$proveedorsel=$glo->getGETPOST("proveedorsel");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$versaldocero=$glo->getGETPOST("versaldocero");
$primero=$glo->getGETPOST("primero");
if($fechafin=="")
    $fechafin=date("Y-m-d");
if($primero!="") {
    $inf=new saldo_clientes($fechafin. $versaldocero);
    $i_cli=$inf->getCliente();
    $i_fac=$inf->getPedidos();
    $i_rec=$inf->getRecibos();
    $i_sal=$inf->getSaldo();
    $totalcompra=array_sum($i_fac);
    $totalpago=array_sum($i_rec);
    $saldofinal=$totalcompra-$totalpago;
} else {
    $i_cli=array();
    $totalcompra=0;
    $totalpago=0;
    $saldofinal=0;
}

$colu=array(5,135,160,185);
$pdf=new PDF_saldos("p", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();