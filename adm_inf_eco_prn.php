<?php
/*
 * Creado el 03/03/2020 08:50:10
 * Autor: gus
 * Archivo: adm_inf_eco.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';
require_once 'impresion/pdf_eco.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");

$conn=$conx->conectarBase();
$ssql="select * from est_informe5 where iduser=".$usr->getId();
if($ceroseco!=1) {
    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
}

$ssql.=" order by codigo";
$rs=$conx->consultaBase($ssql, $conn);
$r1=$conx->consultaBase($ssql, $conn);
$ttotal=array(0,0,0,0,0,0,0,0,0,0,0,0);                                               
                                                
$colu=array(5,40,60,80,100,120,140,160,180,200,220,240,260,280);
$pdf=new PDF_eco("L", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();

?>