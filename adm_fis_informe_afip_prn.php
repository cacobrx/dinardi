<?php
/*
 * Creado el 18/03/2016 20:54:27
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_informe_afip_prn
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'planb_def.php';
require_once 'afip.php';
require_once 'clases/pdf_imprime.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$primerogen=$glo->getGETPOST("primerogen");
$numeroini=$glo->getGETPOST("numeroini");
$numerofin=$glo->getGETPOST("numerofin");
$TipoComp=$glo->getGETPOST("TipoComp");

$a_id=array();

// cajas

//print_r($cajasel);
$a_CbteFch=array();
$a_ImpNeto=array();
$a_ImpTotal=array();
$a_ImpIVA=array();

$adm=new informe_Afip($cfg->getFiscalpuntoventa(), $fechaini, $fechafin, $TipoComp, $cfg->getFiscalcuit());
$a_CbteFch=$adm->getCbteFch();
$a_DocTipo=$adm->getDocTipo();
$a_DocNro=$adm->getDocNro();
$a_CbteDesde=$adm->getCbteDesde();
$a_ImpTotal=$adm->getImpTotal();
$a_ImpNeto=$adm->getImpNeto();
$a_ImpIVA=$adm->getImpIVA();
$a_Resultado=$adm->getResultado();
$a_CodAutorizacion=$adm->getCodAutorizacion();
$a_EmisionTipo=$adm->getEmisionTipo();
$a_FchVto=$adm->getFchVto();
$a_FchProceso=$adm->getFchProceso();
$a_PtoVta=$adm->getPtoVta();
$a_CbteTipo=$adm->getCbteTipo();
$a_cliente=$adm->getCliente();
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
//$colu=array(5,25,40,70,100,130,150,170);
$colu=array(3,20,30,55,75,105,150,167,185);

$pdf = new PDF_informe_AFIP( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>


