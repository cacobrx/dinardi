<?php
/*
 * Creado el 21/01/2019 08:54:13
 * Autor: gus
 * Archivo: adm_prv_pre_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'impresion/pdf_cli_pre.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$botoncap="Modificar";
$adm=new adm_cli_1($id);
$carteltarea="Precios del Cliente ".strtoupper($adm->getApellido());
$pre_idart=$adm->getPre_idart();
$pre_articulo=$adm->getPre_articulo();
$pre_importe=$adm->getPre_importe();
$pre_preciominimo=$adm->getPre_preciominimo();
$pre_preciomaximo=$adm->getPre_preciomaximo();

$colu=array(10,20,125,155,183);
$pdf=new cli_pre("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>