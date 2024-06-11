<?php
/*
 * Creado el 21/01/2019 10:48:18
 * Autor: gus
 * Archivo: adm_rem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem.php';
require_once 'impresion/pdf_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select adm_rem.* from adm_rem inner join adm_prv on adm_rem.idprv=adm_prv.id where adm_rem.fecha>='$fechainirem' and adm_rem.fecha<='$fechafinrem'";
if($proveedorrem>0) $ssql.=" and adm_rem.idprv=$proveedorrem";
if($faenarem==1) $ssql.=" and adm_rem.faena=1";
if($sincomprasrem==1) $ssql.=" and adm_rem.idcom=0";
if($seleccionrem==1) $ssql.=" and adm_rem.seleccion=1";
if($certificadorem!="") $ssql.=" and adm_rem.certificado='".$certificadorem."'";
if($paisrem>0) $ssql.=" and instr(adm_prv.paises,'|".$paisrem."|')>0";

$ssql.=" order by fecha, id";
//echo $ssql;
$adm=new adm_rem_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getProveedor();
$a_pre=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_pat=$adm->getPatente();
$a_com=$adm->getIdcom();
$a_ff=$adm->getFaenac();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_des=$adm->getDet_descripcion();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_tot=$adm->getDet_total();
$d_can=$adm->getDet_cantidad();
$d_ani=$adm->getDet_animales();
$d_kil=$adm->getDet_kilos();
$d_uni=$adm->getDet_unidaddes();
$c_can=$adm->getCrm_cantidad();
$c_art=$adm->getCrm_articulo();
$c_uni=$adm->getCrm_unidaddes();
$a_faena=$adm->getFaena();
//print_r($d_tot);


$colu=array(5,20,40, 125, 145,155,165,185);
$colu2=array(10,85,105,125,145,165,185);
$pdf=new PDF_rem("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>