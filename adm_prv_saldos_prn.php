<?php
/*
 * creado el 07/12/2016 10:08:33
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_prv_saldos_prn
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/prv_saldos.php';
require_once 'impresion/prv_saldos.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$proveedorsel=$glo->getGETPOST("proveedorsel");
$fechafin=$glo->getGETPOST("fechafin");
$conceros=$glo->getGETPOST("conceros");
$tipo=$glo->getGETPOST("tipo");
$inf=new saldo_proveedores($tipo, $conceros, $fechafin);
$i_prv=$inf->getProveedor();
$i_fac=$inf->getFacturas();
$i_rec=$inf->getRecibos();
$i_sal=$inf->getSaldo();
$totalcompra=array_sum($i_fac);
$totalpago=array_sum($i_rec);
$saldofinal=$totalcompra-$totalpago;
$colu=array(10,115,145,175);
$pdf=new prv_saldos("P", "mm", "A4");
$pdf->AddPage();
$pdf->AddDetalle();
$pdf->Output();
?>
