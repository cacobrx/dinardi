<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_crem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crem.php';
require_once 'impresion/pdf_crem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_crem where fecha>='$fechainicrem' and fecha<='$fechafincrem'";
if($clientecrem>0) $ssql.=" and idcli=$clientecrem";
$ssql.=" order by numero, id";
//echo $ssql;
$adm=new adm_crem_2($ssql);
    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_tot=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_fece=$adm->getFechaentrega();
$d_id=$adm->getDet_id();
$a_rem=$adm->getNumero();
$a_pat=$adm->getPatente();
$d_art=$adm->getDet_articulo();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_can=$adm->getDet_cantidad();
$d_rec=$adm->getDet_recipiente();

//print_r($d_can);
//echo "sss: ".array_sum($d_can[0]);

$colu=array(5,15,30,47,65,80,165,185);
$colu2=array(25,60,130,165, 185);
$pdf=new pdf_crem("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();