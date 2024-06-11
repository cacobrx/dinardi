<?php
/*
 * Creado el 28/06/2019 19:38:16
 * Autor: gus
 * Archivo: adm_ajuste_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'informes/ajuste.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/pdf_ajuste.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primeroajuste=$glo->getGETPOST("primeroajuste");
$adm=new ajusteinflacion($fechainiaju, $fechafinaju);
    $a_per=$adm->getAnomes();
    $a_cod=$adm->getCodigo();
    $a_nom=$adm->getNombre();
    $a_impd=$adm->getImportedebe();
    $a_imph=$adm->getImportehaber();
    $a_coefm=$adm->getCoeficientemes();
    $a_coefc=$adm->getCoeficientecierre();
    $a_coeff=$adm->getCoeficientefin();
    $a_impr=$adm->getImportereexp();
    $a_reex=$adm->getReexpresion();
    $cantidadtotal=count($a_cod);

$colu=array(8,30,55,100,130,160,190,215,240,270);
//$colu2=array(100);
$pdf=new PDF_ajuste("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>