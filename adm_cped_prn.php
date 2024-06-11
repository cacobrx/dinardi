<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_cped_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cped.php';
require_once 'impresion/pdf_cped.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_cped where fecha>='$fechainicped' and fecha<='$fechafincped'";
if($clientecped>0) $ssql.=" and idcli=$clientecped";
$ssql.=" order by fecha, id limit $limcped, $limmax";
//echo $ssql;
$adm=new adm_cped_2($ssql);
    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_tot=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_fece=$adm->getFechaentrega();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_can=$adm->getDet_cantidad();

$colu=array(5,20,50,80,185);
$colu2=array(25,60,130,160,185);
$pdf=new pdf_cped("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();