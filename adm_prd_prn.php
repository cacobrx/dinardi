<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prd.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/pdf_prd.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_prd";
if($textoprd!="") {
    $ssql.=" where instr(upper(descripcion), '".strtoupper($textoprd)."')>0";
}
$ssql.=" order by descripcion, id limit $limprd,".$cfg->getLimmax();
$adm=new adm_prd_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_est=$adm->getEstadoproductodes();
$a_kil=$adm->getKilosxanimal();
$a_pre=$adm->getPrecioventa();
$a_cod=$adm->getCodigoproducto();

$colu=array(5,25,60,100,185);
$pdf=new PDF_prd("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>