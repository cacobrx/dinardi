<?
/*
 * Creado el 18/01/2019 17:16:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prv_main.php
 */
require_once 'impresion/pdf_prv.php';
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_prv";
$condicion="";

if($textoprv!="") $condicion.="instr(upper(apellido),'".strtoupper ($textoprv)."')>0 or instr(upper(nombre),'".strtoupper ($textoprv)."')>0 and ";
if($tipoprv>0) $condicion.="tipo=$tipoprv and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by";
if($ordenprv==1)
    $ssql.=" apellido, nombre";
else
    $ssql.=" codigodinardi";
$adm=new adm_prv_2($ssql);
    
$a_id=$adm->getId();
$a_cod=$adm->getCodigodinardi();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_tel=$adm->getTelefono();
$a_cui=$adm->getCuit();
$a_ema=$adm->getEmail();

$colu=array(5,15,120,265,240,180);
$pdf=new prv("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>