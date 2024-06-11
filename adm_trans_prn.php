<?php
/*
 * creado el 10 ene. 2022 11:25:17
 * Usuario: gus
 * Archivo: adm_trans_prn
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/movbancarios.php';
require_once 'impresion/movbancarios.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipo=$glo->getGETPOST("tipo");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($tipo=="") $tipo=0;

$inf=new movbancarios($fechaini, $fechafin, $tipo);
$a_fec=$inf->getFecha();
$a_det=$inf->getDetalle();
$a_imp=$inf->getImporte();

$colu=array(5,30,185);
$pdf=new pdf_movbancarios("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
