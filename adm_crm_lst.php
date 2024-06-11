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
require_once 'clases/adm_crm.php';
require_once 'impresion/adm_crm_lst.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$fecha=date("Y-m-d");
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_crm_1($id);
$fecha=$adm->getFecha();
$remito=$adm->getRemito();
$responsable=$adm->getResponsable();
$horainicio=$adm->getHorainicio();
$horafin=$adm->getHorafin();
$observaciones=$adm->getObservaciones();
$d_producto=$adm->getDet_articulo();
$d_cantidad=$adm->getDet_cantidad();
$d_temperatura=$adm->getDet_temperatura();
$d_observaciones=$adm->getDet_observaciones();
//print_r($c_cantidad);
$cantidaddet=count($d_cantidad);


$colu=array(10,35,135,155,175);
$colu2=array(10,50,70,90,140);
$pdf=new PDF_crm_lst("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>