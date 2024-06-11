<?php
/*
 * Creado el 19/05/2018 16:08:59
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_art.php';
require_once 'impresion/adm_art_prn.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_art";
if($textoart!="") {
    $ssql.=" where instr(upper(descripcion), '".strtoupper($textoart)."')>0";
}
$ssql.=" order by descripcion, id";
//echo $ssql;
$adm=new adm_art_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_rub=$adm->getRubrodes();
$a_pre=$adm->getPrecio();
$a_tip=$adm->getTipoenvalajedes();
$a_env=$adm->getEnvasado();
$a_can=$adm->getCantidad();
$colu=array(5,15,80,115,150,170,185);
$pdf=new art("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>
