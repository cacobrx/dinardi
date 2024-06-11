<?php
/*
 * creado el 06/12/2016 16:16:31
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_prv_ctacte_prn
 */
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/prv_ctacte.php';
require_once 'impresion/prv_ctacte.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$proveedorsel=$glo->getGETPOST("proveedorsel");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipo=$glo->getGETPOST("tipo");
if($fechafin=="")
$fechafin=date("Y-m-d");

$inf=new ctacte_proveedores($proveedorsel, $fechaini, $fechafin, $tipo);
$i_fec=$inf->getFecha();
$i_det=$inf->getDetalle();
$i_imp=$inf->getImporte();
$i_sal=$inf->getSaldo();
$totalcompra=0;
$totalpago=0;
for($i=0;$i<count($i_fec);$i++) {
    if($i_imp[$i]<0)
        $totalcompra+=abs($i_imp[$i]);
    else
        $totalpago+=$i_imp[$i];
}
$saldofinal=$totalpago - $totalcompra;

$prv=new adm_prv_1($proveedorsel);
$proveedor=$prv->getApellido()." ".$prv->getNombre();
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
$colu=array(5,30,145,165,185);
$pdf=new prv_ctacte("P", "mm", "A4");
$pdf->AddPage();
$cartel="CTA.CTE Proveedores";
$pdf->addDetalle();
$pdf->Output();
