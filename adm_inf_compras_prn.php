<?php
/*
 * Creado el 07/10/2019 21:24:38
 * Autor: gus
 * Archivo: adm_inf_compras_prn.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/compras.php';
require_once 'clases/support.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_cli.php';
require_once 'impresion/compras.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idprv=$glo->getGETPOST("idprv");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$informe=$glo->getGETPOST("informe");
$primero=$glo->getGETPOST("primero");
$solofaena=$glo->getGETPOST("solofaena");
$sinfaena=$glo->getGETPOST("sinfaena");
if($sinfaena=="") $sinfaena=0;
if($solofaena=="") $solofaena=0;
if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");

if($informe==1)
    $inf=new inf_compras($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena);
else
    $inf=new inf_compras_prv($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena);
$a_art=$inf->getArticulo();
$a_imp=$inf->getImporte();
$a_can=$inf->getCantidad();
$a_net=$inf->getNeto();
$a_iva=$inf->getIva();
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
if($idprv>0) {
    $prv=new adm_prv_1($idprv);
    $nombre=$prv->getNombre()." ".$prv->getApellido();
}

    

$colu=array(10,125,145,165,185);
$pdf = new pdf_inf_compras( 'P', 'mm', 'A4' );
$pdf->AddPage(); 
$pdf->addDetalle();
$pdf->Output();
