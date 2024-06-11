<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_band.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/bandejas.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_band where fecha>='$fechainiband' and fecha<='$fechafinband'"; 
if($proveedorband>0)
    $ssql.=" and idprv=$proveedorband";
$ssql.=" order by fecha";
//echo $ssql;
$adm=new adm_band_2($ssql);
    
$a_id=$adm->getId();
$a_art=$adm->getArticulo();
$a_fec=$adm->getFecha();
$a_prv=$adm->getProveedor();
$a_hie=$adm->getHielo();
$a_tem=$adm->getTemperatura();
$a_tun=$adm->getTunel();
$a_cnn=$adm->getControl();
$a_con=$adm->getContaminante();
$a_kgr=$adm->getKgrechazo();
$a_kg=$adm->getKg();

$colu=array(5,35,95,155,170,185,200,220,240,265);
$pdf=new PDF_band("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();