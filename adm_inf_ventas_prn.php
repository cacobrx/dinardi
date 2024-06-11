<?php
/*
 * Creado el 03/10/2019 13:39:51
 * Autor: gus
 * Archivo: adm_inf_ventas_prn.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/ventas.php';
require_once 'clases/support.php';
require_once 'impresion/ventas.php';
require_once 'clases/adm_cli.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idcli=$glo->getGETPOST("idcli");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$primero=$glo->getGETPOST("primero");
if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($informe==1)
    $inf=new inf_ventas($fechaini, $fechafin, $orden, $idcli, $idart);
else {
    $inf=new inf_ventas_cli($fechaini, $fechafin, $orden, $idcli, $idart);
    $a_por=$inf->getPorcentaje();
    $a_per=$inf->getPercepcioniibb();
    $a_tot=$inf->getTotal();
}
$a_art=$inf->getArticulo();
$a_imp=$inf->getImporte();
$a_can=$inf->getCantidad();
$a_net=$inf->getNeto();
$a_iva=$inf->getIva();
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
if($idcli>0) {
    $prv=new adm_cli_1($idcli);
    $nombre=$prv->getNombre()." ".$prv->getApellido();
}    

$colu=array(5,65,85,105,125,145,165,185);
$pdf = new pdf_inf_ventas( 'P', 'mm', 'A4' );
$pdf->AddPage(); 
$pdf->addDetalle();
$pdf->Output();
