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
require_once 'impresion/pdf_rem_exp2.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$adm=new adm_rem_exp_1($id);
$id=$adm->getId();
$ptovta=$adm->getPtovta();
$numero=$adm->getNumero();
$fecha=$adm->getFecha();
$exportador=$adm->getExportador();
$buque=$adm->getBuque();
$destino=$adm->getDestino();
$remitente=$adm->getRemitente();
$nro=$adm->getNro();
$precinto=$adm->getPrecinto();
$procedencia=$adm->getProcedencia();
$giro=$adm->getGiro();
$contenedor=$adm->getContenedor();
$agenciapre=$adm->getAgenciapre();
$transportista=$adm->getTransportista();
$balanza=$adm->getBalanza();
$cuit=$adm->getCuit();
$certificado=$adm->getCertificado();
$serie=$adm->getSerie();
$fiscal=$adm->getFiscal();
$nro2=$adm->getNro2();
$patenteca=$adm->getPatenteca();
$d_can=$adm->getCantidad();
$d_des=$adm->getDescripcion();
$d_kgsb=$adm->getKgsbrutos();
$d_kgsn=$adm->getKgsneto();
$cantidadadm=count($d_can);


$pdf= new pdf_rem_exp2("P", "mm", "A4");
$colu=array(10,35,160,185);
//$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>