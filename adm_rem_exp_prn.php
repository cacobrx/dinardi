<?php
/*
 * Creado el 17/12/2018 11:03:26
 * Autor: gus
 * Archivo: adm_crm_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem_exp.php';
require_once 'impresion/pdf_rem_exp.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from adm_rem_exp where fecha>='$fechainiexp' and fecha<='$fechafinexp' order by id ";
//echo $ssql;
$adm=new adm_rem_exp_2($ssql);
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_nro=$adm->getNumero();
$a_exp=$adm->getExportador();
$a_des=$adm->getDestino();
$a_rem=$adm->getRemitente();
$d_can=$adm->getCantidad();
$d_des=$adm->getDescripcion();
$d_kgsb=$adm->getKgsbrutos();
$d_kgsn=$adm->getKgsneto();

$colu=array(5,20,35,100,150);
$colu2=array(10,30,150,180);
$pdf=new PDF_rem_exp("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>