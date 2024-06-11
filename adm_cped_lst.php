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
require_once 'clases/adm_cped.php';
require_once 'impresion/pdf_cped2.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Pedido #$id";
$botoncap="Modificar";
$fecha=date("Y-m-d");
$idcli=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_cped_1($id);
$fecha=$adm->getFecha();
$idcli=$adm->getIdcli();
$observaciones=$adm->getObservaciones();
$direccion=$adm->getDireccion();
$d_cantidad=$adm->getDet_cantidad();
$d_precio=$adm->getDet_precio();
$d_total=$adm->getTotal();
$d_articulo=$adm->getDet_articulo();
$d_recipiente=$adm->getDet_recipiente();
$patente=$adm->getPatente();
$cantidaddet=count($d_cantidad);


$pdf= new pdf_cped2("P", "mm", "A4");
$colu=array(10,35,130,165,185);
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
