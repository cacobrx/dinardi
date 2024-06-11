<?php
/*
 * creado el 20 may. 2021 15:41:25
 * Usuario: gus
 * Archivo: adm_inf_eco_mensual_prn
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';
require_once 'planb_def.php';
require_once 'impresion/eco_mensual.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");
$anoeco=$glo->getGETPOST("anoeco");
$meseco=$glo->getGETPOST("meseco");
$cad=$glo->getGETPOST("cad");
//print_r($cad);
$colu=array(10,185);
$pdf=new eco_mensual("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();

