<?php
/*
 * Creado el 20/10/2015 16:47:06
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_vta_prn_fis
 */
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_fis.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'impresion/comprobante.php';
require_once 'clases/adm_fis_det.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$conx=new conexion();
$id=$glo->getGETPOST("id");
$fis=new adm_fis_1($id);
$copiasimp=$glo->getGETPOST("copiasimp");

$pdf= new PDF_ComprobanteFiscal("P", "mm", "A4");
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->addDetalle();
$pdf->Output();
?>
