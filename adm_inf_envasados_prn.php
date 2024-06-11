<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/envasados.php';
require_once 'impresion/pdf_envasados.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");

$vta=new envasados($fechaini, $fechafin);
$a_kil=$vta->getKilos();
$a_des=$vta->getDescripcion();
$a_can=$vta->getCantidad();

$colu=array(7,30,185);
$pdf=new pdf_envasados("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>