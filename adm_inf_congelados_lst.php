<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/congelados.php';
require_once 'clases/support.php';
require_once 'impresion/inf_congelados.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$primero=$glo->getGETPOST("primero");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
$idart=$glo->getGETPOST("idart");
$idprv=$glo->getGETPOST("idprv");

$inf=new congelados($fechaini, $fechafin, $idart, $idprv);
$a_art=$inf->getArticulo();
$a_caj=$inf->getCajas();
$a_kil=$inf->getKilos();
$a_fec=$inf->getFecha();
$totalcajas=$inf->getTotalcajas();
$totalkilos=$inf->getTotalkilos();


$colu=array(10,35,165,185);
$pdf=new PDF_congelados("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();