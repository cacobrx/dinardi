<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/conexion.php';
require_once 'impresion/opg_ret_gan.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$limmax=$cfg->getLimmax();
$hoy=date("Y-m-d");
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
    if($tipoopg>0)
        $condicionprv.="and tipo=$tipoopg";


$stot="select sum(adm_opg2.importe) as totalimporte from adm_opg2, adm_opg1 where (adm_opg1.fecha between '$fechainiopg' and '$fechafinopg') and adm_opg1.id=adm_opg2.idop and adm_opg1.centro=$centrosel $condicionprv";
$ssql="select * from adm_opg1 where ($campofechaopg between '$fechainiopg' and '$fechafinopg') and adm_opg1.centro=$centrosel $condicionprv and retencionganancia>0";
if($tipocontabilidadopg==1) {
    $ssql.=" and adm_opg1.numeroadj>0";
    $stot.=" and adm_opg1.numeroadj>0";
}
$ssql.=" order by idprv";

//echo $stot."<br>";
if($conx->getCantidadReg($stot)>0) {
    $rs=$conx->getConsulta($stot);

    $rre=mysqli_fetch_object($rs);
    $total=$rre->totalimporte;
} else
    $total=0;   
//$total=0;
//echo $ssql."<br>";
$opg=new adm_opg1_2($ssql);
$a_id=$opg->getId();
$a_fec=$opg->getFecha();
$a_pro=$opg->getProveedor();
$a_con=$opg->getConcepto();
$a_imp=$opg->getRetencionganancia();
$a_ret=$opg->getRetencioniibb();
$a_tip=$opg->getTipodes();
$a_tc=$opg->getTipo();
$a_cui=$opg->getCuit();
$a_idprv=$opg->getIdprv();
$a_num=$opg->getNumeroretg();


$colu=array(5,15,100,120,150,185);
$pdf = new opg_ret_gan( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
