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
require_once 'clases/adm_rem.php';
require_once 'impresion/pdf_rem2.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$copiasimp=$glo->getGETPOST("copiasimp");
$carteltarea="Remito #$id";
$botoncap="Modificar";
$fecha=date("Y-m-d");
$idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_rem_1($id);
$fecha=$adm->getFecha();
$idprv=$adm->getIdprv();
$totaltotal=$adm->getTotal();
$d_idart=$adm->getDet_idart();
$d_cantidad=$adm->getDet_cantidad();
$d_precio=$adm->getDet_precio();
$d_animales=$adm->getDet_animales();
$d_kilos=$adm->getDet_kilos();
$d_total=$adm->getDet_total();
$d_descripcion=$adm->getDet_descripcion();
$d_articulo=$adm->getDet_articulo();
$d_unidad=$adm->getDet_unidaddes();
$c_cantidad=$adm->getCrm_cantidad();
$c_peso=$adm->getCrm_peso();
$c_temperatura=$adm->getCrm_temperatura();
$c_articulo=$adm->getCrm_articulo();
$c_unidad=$adm->getCrm_unidaddes();
$direccion=$adm->getDireccion();
if($adm->getNumero()>0) $carteltarea="Remito #".$adm->getPtovta ()."-".$adm->getNumero ();
if(count($c_temperatura)==0) {
    $c_temperatura=array(0);
    $c_cantidad=array(0);
    $c_obs=array("");
}
//print_r($c_cantidad);
$cantidaddet=count($d_cantidad);
$cantidadcrm=count($c_articulo);
$faena=$adm->getFaena();
$totalkilos=array_sum($d_cantidad);

$pdf= new pdf_rem2("P", "mm", "A4");
$colu=array(5,80,105,135,155,165,185);
//$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
