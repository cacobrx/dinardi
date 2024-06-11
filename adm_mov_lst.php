<?php
/*
 * creado el 27/11/2017 16:58:26
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_prn
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_mov.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/adm_emp.php';
require_once 'clases/pdf_imprime.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$condicion="";
$textodiario=$glo->getGETPOST("textodiario");
$ntex=strlen($textomov);
$condicion="";
$ssql="select * from adm_mov1 where centro=$centrosel and idemp=$empresamain and fecha>='$fechainimov' and fecha<='$fechafinmov'";
if($asientomov!="") $condicion="asiento=$asientomov and ";
if($textomov!="") $condicion="instr(upper(detalle),'".strtoupper($textomov)."')>0 and ";
if($condicion!="") $condicion=" and ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by asiento, fecha";
//echo $ssql;
$adm=new adm_mov_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_det=$adm->getDetalle();
$a_asi=$adm->getAsiento();
$a_debe=$adm->getDebemov();
$a_haber=$adm->getHabermov();
$d_id=$adm->getDet_id();
$d_idcta=$adm->getDet_idcta();
$d_nombre=$adm->getDet_nombre();
$d_codigo=$adm->getDet_codigo();
$d_tipo=$adm->getDet_tipo();
$d_importe=$adm->getDet_importe();
$d_detalle=$adm->getDet_detalle();
$emp=new adm_emp_1($empresamain);
$empresanom=$emp->getNombre();
$colu=array(5,30,45,165,185);
$colud=array(5,30,45,165,185);
$pdf=new PDF_diario("p", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>
