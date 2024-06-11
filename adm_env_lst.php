<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_env.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'impresion/envasado.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_env where fechaing>='$fechainienv' and fechaing<='$fechafinenv'"; 
if($proveedorenv>0)
    $ssql.=" and (idprv=$proveedorenv or idprv1=$proveedorenv or idprv2=$proveedorenv)";
if($articuloenv>0)
    $ssql.=" and idart=$articuloenv";
if($tunelenv!="") $ssql.=" and tunel=$tunelenv";

$ssql.=" order by fechaing";
$adm=new adm_env_2($ssql);
    
$a_id=$adm->getId();
$a_ida=$adm->getArticulo();
$a_t1=$adm->getTenvasado1();
$a_t2=$adm->getTenvasado2();
$a_t3=$adm->getTenvasado3();
$a_fec=$adm->getFechaing();
$a_idp=$adm->getProveedor();
$a_idp1=$adm->getProveedor1();
$a_idp2=$adm->getProveedor2();
$a_kgd=$adm->getKgdescarte();
$a_lot=$adm->getLote();
$a_can=$adm->getCantidad();
$a_kil=$adm->getKilos();
$a_tun=$adm->getTunel();

$colu=array(5,65,75,85,95,115,200,220,245,260,280);
$pdf=new PDF_env("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();