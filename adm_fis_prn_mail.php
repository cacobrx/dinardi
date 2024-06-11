<?php
/*
 * Creado el 08/11/2015 15:16:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_prn_mail
 */

//require_once 'edd_user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_fis.php';
require_once 'clases/auditoria.php';
require_once 'clases/planb_config.php';
require_once 'impresion/comprobante.php';
$aud = new registra_auditoria();
$conx = new conexion();
$centrosel=1;
$cfg=new planb_config_1(1);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$copiasimp=1;
$fis=new adm_fis_1($id);
$pdf= new PDF_ComprobanteFiscal("P", "mm", "A4");
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->addDetalle();
$pdf->Output();
?>