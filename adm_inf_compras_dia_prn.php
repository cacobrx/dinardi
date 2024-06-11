<?php
/*
 * Creado el 15/08/2020 13:04:41
 * Autor: gus
 * Archivo: adm_inf_compras_dia_prn.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'impresion/compras_dia.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$a_fecha= unserialize($glo->getGETPOST("a_fecha"));
$a_prov= unserialize($glo->getGETPOST("a_prov"));
$a_art= unserialize($glo->getGETPOST("a_art"));
$a_can= unserialize($glo->getGETPOST("a_can"));
$a_neto= unserialize($glo->getGETPOST("a_neto"));
$a_iva= unserialize($glo->getGETPOST("a_iva"));
$a_imp= unserialize($glo->getGETPOST("a_imp"));
$nombreemp=$cen->getNombre();
$telegonoemp=$cen->getTelefono();
$colu=array(5,25,100,190,210,230,250,270);
$pdf=new compras_dia("L", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>

