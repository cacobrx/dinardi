<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_ela.php';
require_once 'clases/adm_ela_det.php';
require_once 'impresion/elaboracion.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_ela_1($id);
$fecha=$adm->getFecha();
$turno=$adm->getTurno();
$horaing=$adm->getHoraing();
$horaegr=$adm->getHoraegr();
$empleados=$adm->getEmpleados();
$observacion1=$adm->getObservacion1();
$observacion2=$adm->getObservacion2();
$p_prv=$adm->getPrv_proveedor();
$d_id=$adm->getDet_id();
$d_fec=$adm->getDet_fechaing();
$d_art=$adm->getDet_articulo();
$d_kgd=$adm->getDet_kgdescarte();
$d_kgf=$adm->getDet_kilos();


$colu=array(5,60,85,250,270);
$colu2=array(10,50,70,90,185);
$pdf=new PDF_ela("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();

