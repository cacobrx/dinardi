<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_ela.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/elaboracion.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_ela where fecha>='$fechainiela' and fecha<='$fechafinela'";
$ssql.=" order by fecha";
$adm=new adm_ela_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_hin=$adm->getHoraing();
$a_heg=$adm->getHoraegr();
$a_hin1=$adm->getHoraing1();
$a_heg1=$adm->getHoraegr1();
$a_emp=$adm->getEmpleados();
$a_prv=$adm->getPrv_proveedor();
$a_art=$adm->getDet_articulo();
$a_fin=$adm->getDet_fechaing();
$a_kgd=$adm->getDet_kgdescarte();
$a_kgf=$adm->getDet_kilos();


$colu=array(10,50,80,180);
$colu2=array(10,25,130,165,185);

$pdf=new elaboracion_prn("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
