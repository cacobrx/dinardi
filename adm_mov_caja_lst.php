<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_mov_caja.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/pdf_mov_caja.php';
require_once 'clases/adm_mov_caja_ini.php';

$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();

$condicion="";
if($cajamcj>0)
    $condicion.=" and tipocaja=$cajamcj";
if($textomcj!="")
    $condicion.=" and (instr(upper(detalle), '".strtoupper($textomcj)."')>0 or instr(upper(indice), '".strtoupper($textomcj)."')>0)";
if($descriptor1mcj>0)
    $condicion.=" and descriptor1=$descriptor1mcj";
if($descriptor2mcj>0)
    $condicion.=" and descriptor2=$descriptor2mcj";
if($descriptor3mcj>0)
    $condicion.=" and descriptor3=$descriptor3mcj";
if($descriptor4mcj>0)
    $condicion.=" and descriptor4=$descriptor4mcj";
if($oficinamcj>0)
    $condicion.=" and oficina=$oficinamcj";
if($tipopagomcj>0)
    $condicion.=" and tipopago=$tipopagomcj";
if($tipomovmcj>0) {
    if($tipomovmcj==1)
        $condicion.=" and tipomov=0";
    else
        $condicion.=" and tipomov=1";
}

$ssql="select * from adm_mov_caja where centro=$centrosel and eliminado=0 $condicion and fecha>='$fechainimcj' and fecha<='$fechafinmcj' order by fecha, id";
$adm=new adm_mov_caja_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_id=$adm->getid();
$a_fec=$adm->getfecha();
$a_det=$adm->getdetalle();
$a_imp=$adm->getimporte();
$a_tip=$adm->gettipocaja();
$a_tmv=$adm->getDescriptor1();
$a_des1=$adm->getDescriptor1des();
$a_des2=$adm->getDescriptor2des();
$a_des3=$adm->getDescriptor3des();
$a_des4=$adm->getDescriptor4des();
$a_ofi=$adm->getOficinades();
$sal=new Saldoinicial($fechainimcj, $cajamcj);
$saldoini=$sal->getSaldoini();

$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
$colu=array(5,15,32,125,230,250,270);
$pdf=new PDF_mov_caja_lst("L", "mm", "A4");
$pdf->AddPage();
$cartel="Listado de Movimientos de caja ".$conx->getTextoValor($cajamcj, "CAJA");
$pdf->addDetalle();
$pdf->Output();