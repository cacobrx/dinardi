<?php
/*
 * Creado el 21/11/2018 17:57:02
 * Autor: gus
 * Archivo: adm_opg_ret_lst.php
 * planbsistemas.com.ar
 */

require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/support.php';
require_once 'clases/adm_opg1.php';
require_once 'impresion/opg_retenciones.php';
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$condicionprv="";
if($campoopg!="") {
    $conn=$conx->conectarBase();
    $ntex=strlen($campoopg);
    if($criterioopg==1)
        $ssql="select * from adm_prv where left(upper(apellido), $ntex)='".strtoupper($campoopg)."'";
    else
        $ssql="select * from adm_prv where instr(upper(apellido),'".strtoupper($campoopg)."')>0";
    $rs=$conx->consultaBase($ssql, $conn);
    while($reg=mysqli_fetch_object($rs)) {
        $condicionprv.="idprv=".$reg->id." or ";
    }
    if($condicionprv!="")
        $condicionprv="and (".substr($condicionprv,0,strlen($condicionprv)-4).")";
    
}

$hoy=date("Y-m-d");

$ssql="select * from adm_opg1 where ($campofechaopg between '$fechainiopg' and '$fechafinopg') and adm_opg1.centro=$centrosel $condicionprv and retencioniibb>0";
$ssql.=" order by numeroret";
//echo $ssql."<br>";
//echo $stot."<br>";
$opg=new adm_opg1_2($ssql);
$a_id=$opg->getId();
$a_fec=$opg->getFecha();
$a_pro=$opg->getProveedor();
$a_imp=$opg->getTotalimporte();
$a_ret=$opg->getRetencioniibb();
$a_dir=$opg->getDireccion();
$a_cuit=$opg->getCuit();
$a_nret=$opg->getNumeroret();
$colu=array(5,25, 35,140,160,250,270);
$pdf = new opg_ret( 'L', 'mm', 'A4' );
$pdf->AddPage();
$pdf->AddDetalle();
$pdf->Output();
