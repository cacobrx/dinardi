<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_oin.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/pdf_oin.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_oin where fecha>='$fechainioin' and fecha<='$fechafinoin' order by fecha, id";
$adm=new adm_oin_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_det=$adm->getDetalle();
$a_imp=$adm->getImporte();

$colu=array(5,25,100, 180);
$pdf = new pdf_oin( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
