<?php
/*
 * Creado el 03/03/2020 08:50:10
 * Autor: gus
 * Archivo: adm_inf_eco.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");
$anoeco=$glo->getGETPOST("anoeco");
if($anoeco=="") $anoeco=date("Y");
if($primero==1) {
    $fechaini=date($anoeco."-01-01");
    $fechafin=date($anoeco."-12-31");
    $adm=new informe5($fechaini, $fechafin);
    $a_cta=$adm->getCodigo();
    $a_id=$adm->getId();
    $a_nom=$adm->getNombre();
    $a_deb=$adm->getDebitos();
    $a_cre=$adm->getCreditos();
    $a_let=$adm->getLetra();
    $a_esp=$adm->getEspacios();
    $a_sal=$adm->getSaldo();
    $a_stt=$adm->getSubtotal();
    
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a01_sal=$adm->getSaldo();
    $a01_fini=$fechaini;
    $a01_ffin=$fechafin;
//    print_r($a01_sal);

    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a02_sal=$adm->getSaldo();
    $a02_fini=$fechaini;
    $a02_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a03_sal=$adm->getSaldo();
    $a03_fini=$fechaini;
    $a03_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a04_sal=$adm->getSaldo();
    $a04_fini=$fechaini;
    $a04_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a05_sal=$adm->getSaldo();
    $a05_fini=$fechaini;
    $a05_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a06_sal=$adm->getSaldo();
    $a06_fini=$fechaini;
    $a06_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a07_sal=$adm->getSaldo();
    $a07_fini=$fechaini;
    $a07_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a08_sal=$adm->getSaldo();
    $a08_fini=$fechaini;
    $a08_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a09_sal=$adm->getSaldo();
    $a09_fini=$fechaini;
    $a09_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a10_sal=$adm->getSaldo();
    $a10_fini=$fechaini;
    $a10_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a11_sal=$adm->getSaldo();
    $a11_fini=$fechaini;
    $a11_ffin=$fechafin;
    
    $fechaini=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin);
    $a12_sal=$adm->getSaldo();
    $a12_fini=$fechaini;
    $a12_ffin=$fechafin;
    
    
    
    $conn=$conx->conectarBase();
    
    $ssql="delete from est_informe5 where iduser=".$usr->getId();
    $conx->consultaBase($ssql, $conn);
    for($i=0;$i<count($a_cta);$i++) {
        $nivel=strlen($a_cta[$i])/3;
        $total=$a_sal[$i];
        $total01=$a01_sal[$i];
        $total02=$a02_sal[$i];
        $total03=$a03_sal[$i];
        $total04=$a04_sal[$i];
        $total05=$a05_sal[$i];
        $total06=$a06_sal[$i];
        $total07=$a07_sal[$i];
        $total08=$a08_sal[$i];
        $total09=$a09_sal[$i];
        $total10=$a10_sal[$i];
        $total11=$a11_sal[$i];
        $total12=$a12_sal[$i];
        if($total=="") $total=0;
        if($total01=="") $total01=0;
        if($total02=="") $total02=0;
        if($total03=="") $total03=0;
        if($total04=="") $total04=0;
        if($total05=="") $total05=0;
        if($total06=="") $total06=0;
        if($total07=="") $total07=0;
        if($total08=="") $total08=0;
        if($total09=="") $total09=0;
        if($total10=="") $total10=0;
        if($total11=="") $total11=0;
        if($total12=="") $total12=0;
        
        if($a01_sal[$i]=="") $a01_sal[$i]=0;
        if($a02_sal[$i]=="") $a02_sal[$i]=0;
        if($a03_sal[$i]=="") $a03_sal[$i]=0;
        if($a04_sal[$i]=="") $a04_sal[$i]=0;
        if($a05_sal[$i]=="") $a05_sal[$i]=0;
        if($a06_sal[$i]=="") $a06_sal[$i]=0;
        if($a07_sal[$i]=="") $a07_sal[$i]=0;
        if($a08_sal[$i]=="") $a08_sal[$i]=0;
        if($a09_sal[$i]=="") $a09_sal[$i]=0;
        if($a10_sal[$i]=="") $a10_sal[$i]=0;
        if($a11_sal[$i]=="") $a11_sal[$i]=0;
        if($a12_sal[$i]=="") $a12_sal[$i]=0;
        
        
        $ssql="insert into est_informe5 (iduser, idmov, codigo, descripcion, total, total01, total02, total03, total04, total05, ";
        $ssql.="total06, total07, total08, total09, total10, total11, total12, nivel, ";
        $ssql.="fechaini01, fechaini02, fechaini03, fechaini04, fechaini05, fechaini06, fechaini07, fechaini08, fechaini09, fechaini10, fechaini11, fechaini12, ";
        $ssql.="fechafin01, fechafin02, fechafin03, fechafin04, fechafin05, fechafin06, fechafin07, fechafin08, fechafin09, fechafin10, fechafin11, fechafin12 ";
        $ssql.=") values (".$usr->getId().", ".$a_id[$i].", '".$a_cta[$i]."', '".$a_nom[$i]."', ";
        $ssql.=$a_sal[$i].", ".$a01_sal[$i].", ".$a02_sal[$i].", ".$a03_sal[$i].", ".$a04_sal[$i].", ".$a05_sal[$i].", ";
        $ssql.=$a06_sal[$i].", ".$a07_sal[$i].", ".$a08_sal[$i].", ".$a09_sal[$i].", ".$a10_sal[$i].", ".$a11_sal[$i].", ".$a12_sal[$i].", $nivel, ";
        $ssql.="'$a01_fini', '$a02_fini', '$a03_fini', '$a04_fini', '$a05_fini', '$a06_fini', '$a07_fini', '$a08_fini', '$a09_fini', '$a10_fini', '$a11_fini', '$a12_fini', ";
        $ssql.="'$a01_ffin', '$a02_ffin', '$a03_ffin', '$a04_ffin', '$a05_ffin', '$a06_ffin', '$a07_ffin', '$a08_ffin', '$a09_ffin', '$a10_ffin', '$a11_ffin', '$a12_ffin' ";
        $ssql.=")";
        $conx->consultaBase($ssql, $conn);
//        echo $ssql."<br>";
    }
    
} else
    $a_cta=array();

//echo "plan: ".$est->getCantplan()."<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $cfg->getTitulo()?></title>
<style type="text/css">
<!--
#barblue {
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:51px;
	z-index:1;
	background-color:<?= $cfg->getColor1()?>;
        /*visibility: hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>    
<? require_once "estilos.php" ?>;
<style>
.cco a:active {
	text-decoration: none;
        color: <?= $cfg->getColordescriptor1()?>;
	border-bottom-style: none;
	font-family: Arial;
	font-size: 12px;
}

.cco a:visited {
	text-decoration: none;
	color: <?= $cfg->getColordescriptor1()?>;
	border-bottom-style: none;
	font-family: Arial;
	font-size: 12px;
}


.cco a:link {
	text-decoration: none;
	color: <?= $cfg->getColordescriptor1()?>;
	font-family: Arial;
	font-size: 12px;
}

.cco a:hover {
	color: <?= $cfg->getColordescriptor1()?>;
	font-family: Arial;
	font-size: 12px;
}
    
</style>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="primero" id="primero" type="hidden" vale="1" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CUENTA ECONÓMICA ANUAL</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Año <input name="anoeco" id="anoeco" type="text" onkeypress="return validar(event)" style="text-align: center" size="4" maxlength="4" value="<?= $anoeco?>" /> | 
                                            Incluir importe CERO <input name="ceroseco" id="ceroseco" type="checkbox" value="1" <? if($ceroseco==1) echo "checked='checked'";?> /> | 
                                            <input name="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.primero.value=1; document.form1.action='adm_inf_eco.php'; document.form1.submit()" /> 
                                            <input name="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_eco_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_eco_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td>Cuenta</td>
                                                    <td width="6%" align="right">Total</td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td width="6%" align="right"><?= $mesesa[$i]?></td>
                                                    <? } ?>
                                                </tr>
                                                <?
                                                $conn=$conx->conectarBase();
                                                $ssql="select * from est_informe5 where iduser=".$usr->getId();
                                                if($ceroseco!=1) {
                                                    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
                                                    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
                                                }
                                                
                                                $ssql.=" and codigo='000' order by codigo";
                                                $rs=$conx->consultaBase($ssql, $conn);
                                                $r1=$conx->consultaBase($ssql, $conn);
                                                $ttotal=array(0,0,0,0,0,0,0,0,0,0,0,0);
                                                $tentradas=array(0,0,0,0,0,0,0,0,0,0,0,0);
                                                $tsalidas=array(0,0,0,0,0,0,0,0,0,0,0,0);
                                                $ccc=$cfg->getColordescriptor1();
                                                while($reg1=mysqli_fetch_object($r1)) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                    <td align="left">
                                                        <?= $reg1->descripcion?>
                                                    </td>
                                                    <td align="right"><?= number_format($reg1->total/1000,0)?></td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td align="right">
                                                        <? switch ($i) {
                                                            case 0:
                                                                echo number_format($reg1->total01/1000,0);
                                                                $ttotal[0]+=$reg1->total01;
                                                                if($reg1->total01>0) $tentradas[0]+=$reg1->total01; else $tsalidas[0]+=abs($reg1->total01);
                                                                break;
                                                            case 1:
                                                                echo number_format($reg1->total02/1000,0);
                                                                $ttotal[1]+=$reg1->total02;
                                                                if($reg1->total02>0) $tentradas[1]+=$reg1->total02; else $tsalidas[1]+=abs($reg1->total02);
                                                                break;
                                                            case 2:
                                                                echo number_format($reg1->total03/1000,0);
                                                                $ttotal[2]+=$reg1->total03;
                                                                if($reg1->total03>0) $tentradas[2]+=$reg1->total03; else $tsalidas[2]+=abs($reg1->total03);
                                                                break;
                                                            case 3:
                                                                echo number_format($reg1->total04/1000,0);
                                                                $ttotal[3]+=$reg1->total04;
                                                                if($reg1->total04>0) $tentradas[3]+=$reg1->total04; else $tsalidas[3]+=abs($reg1->total04);
                                                                break;
                                                            case 4:
                                                                echo number_format($reg1->total05/1000,0);
                                                                $ttotal[4]+=$reg1->total05;
                                                                if($reg1->total05>0) $tentradas[4]+=$reg1->total05; else $tsalidas[4]+=abs($reg1->total05);
                                                                break;
                                                            case 5:
                                                                echo number_format($reg1->total06/1000,0);
                                                                $ttotal[5]+=$reg1->total06;
                                                                if($reg1->total06>0) $tentradas[5]+=$reg1->total06; else $tsalidas[5]+=abs($reg1->total06);
                                                                break;
                                                            case 6:
                                                                echo number_format($reg1->total07/1000,0);
                                                                $ttotal[6]+=$reg1->total07;
                                                                if($reg1->total07>0) $tentradas[6]+=$reg1->total07; else $tsalidas[6]+=abs($reg1->total07);
                                                                break;
                                                            case 7:
                                                                echo number_format($reg1->total08/1000,0);
                                                                $ttotal[7]+=$reg1->total08;
                                                                if($reg1->total08>0) $tentradas[7]+=$reg1->total08; else $tsalidas[7]+=abs($reg1->total08);
                                                                break;
                                                            case 8:
                                                                echo number_format($reg1->total09/1000,0);
                                                                $ttotal[8]+=$reg1->total09;
                                                                if($reg1->total09>0) $tentradas[8]+=$reg1->total09; else $tsalidas[8]+=abs($reg1->total09);
                                                                break;
                                                            case 9:
                                                                echo number_format($reg1->total10/1000,0);
                                                                $ttotal[9]+=$reg1->total10;
                                                                if($reg1->total10>0) $tentradas[9]+=$reg1->total10; else $tsalidas[9]+=abs($reg1->total10);
                                                                break;
                                                            case 10:
                                                                echo number_format($reg1->total11/1000,0);
                                                                $ttotal[10]+=$reg1->total11;
                                                                if($reg1->total11>0) $tentradas[10]+=$reg1->total11; else $tsalidas[10]+=abs($reg1->total11);
                                                                break;
                                                            case 11:
                                                                echo number_format($reg1->total12/1000,0);
//                                                                echo number_format($ttotal[5]/1000,0);
                                                                $ttotal[11]+=$reg1->total12;
                                                                if($reg1->total12>0) $tentradas[11]+=$reg1->total12; else $tsalidas[11]+=abs($reg1->total12);
                                                                break;
                                                        }?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <? }

//                                                print_r($ttotal);

                                                $ssql="select * from est_informe5 where iduser=".$usr->getId();
                                                if($ceroseco!=1) {
                                                    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
                                                    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
                                                }
                                                
                                                $ssql.=" and codigo!='000'and nivel=1 order by codigo";
                                                $rs=$conx->consultaBase($ssql, $conn);
                                                $r1=$conx->consultaBase($ssql, $conn);
//                                                $ttotal=array(0,0,0,0,0,0,0,0,0,0,0,0);
                                                while($reg1=mysqli_fetch_object($r1)) { 
                                                    $ccc="black";
                                                    switch ($reg1->nivel){
                                                        case 1:
                                                            $ccc=$cfg->getColordescriptor1();
                                                            break;
                                                        case 2:
                                                            $ccc=$cfg->getColordescriptor2();
                                                            break;
                                                        case 3:
                                                            $ccc=$cfg->getColordescriptor3();
                                                            break;
                                                        case 4:
                                                            $ccc=$cfg->getColordescriptor4();
                                                            break;
                                                    }
                                                    
                                                    
                                                ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                    <td align="left">
                                                        <a data-toggle="collapse" style="color: <?= $ccc?>" class="cco" href="#menu-<?= $reg1->codigo?>">
                                                        <?=  str_repeat('&nbsp;', strlen($reg1->codigo)-3)." ".$reg1->descripcion?>
                                                        </a>
                                                    </td>
                                                    <td align="right"><?= number_format($reg1->total/1000,0)?></td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td align="right">
                                                        <? switch ($i) {
                                                            case 0:
                                                                echo number_format($reg1->total01/1000,0);
                                                                $ttotal[0]+=$reg1->total01;
                                                                $tsalidas[0]+=abs($reg1->total01);
                                                                break;
                                                            case 1:
                                                                echo number_format($reg1->total02/1000,0);
                                                                $ttotal[1]+=$reg1->total02;
                                                                $tsalidas[1]+=abs($reg1->total02);
                                                                break;
                                                            case 2:
                                                                echo number_format($reg1->total03/1000,0);
                                                                $ttotal[2]+=$reg1->total03;
                                                                $tsalidas[2]+=abs($reg1->total03);
                                                                break;
                                                            case 3:
                                                                echo number_format($reg1->total04/1000,0);
                                                                $ttotal[3]+=$reg1->total04;
                                                                $tsalidas[3]+=abs($reg1->total04);
                                                                break;
                                                            case 4:
                                                                echo number_format($reg1->total05/1000,0);
                                                                $ttotal[4]+=$reg1->total05;
                                                                $tsalidas[4]+=abs($reg1->total05);
                                                                break;
                                                            case 5:
                                                                echo number_format($reg1->total06/1000,0);
                                                                $ttotal[5]+=$reg1->total06;
                                                                $tsalidas[5]+=abs($reg1->total06);
                                                                break;
                                                            case 6:
                                                                echo number_format($reg1->total07/1000,0);
                                                                $ttotal[6]+=$reg1->total07;
                                                                $tsalidas[6]+=abs($reg1->total07);
                                                                break;
                                                            case 7:
                                                                echo number_format($reg1->total08/1000,0);
                                                                $ttotal[7]+=$reg1->total08;
                                                                $tsalidas[7]+=abs($reg1->total08);
                                                                break;
                                                            case 8:
                                                                echo number_format($reg1->total09/1000,0);
                                                                $ttotal[8]+=$reg1->total09;
                                                                $tsalidas[8]+=abs($reg1->total09);
                                                                break;
                                                            case 9:
                                                                echo number_format($reg1->total10/1000,0);
                                                                $ttotal[9]+=$reg1->total10;
                                                                $tsalidas[9]+=abs($reg1->total10);
                                                                break;
                                                            case 10:
                                                                echo number_format($reg1->total11/1000,0);
                                                                $ttotal[10]+=$reg1->total11;
                                                                $tsalidas[10]+=abs($reg1->total11);
                                                                break;
                                                            case 11:
                                                                echo number_format($reg1->total12/1000,0);
//                                                                echo number_format($ttotal[5]/1000,0);
                                                                $ttotal[11]+=$reg1->total12;
                                                                $tsalidas[11]+=abs($reg1->total12);
                                                                break;
                                                        }?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <? 
//                                                print_r($ttotal);
                                                $ssql="select * from est_informe5 where iduser=".$usr->getId();
                                                if($ceroseco!=1) {
                                                    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
                                                    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
                                                }
                                                
                                                $ssql.=" and left(codigo,3)='".$reg1->codigo."' and nivel=2 order by codigo";
                                                $r2=$conx->consultaBase($ssql, $conn);
                                                while($r22=mysqli_fetch_object($r2)) { 
                                                    $ccc=$cfg->getColordescriptor2();
                                                    ?>
                                                <tr class="collapse" id="menu-<?= $reg1->codigo?>" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                    <td align="left">
                                                        <a data-toggle="collapse" style="color: <?= $ccc?>" href="#menu-<?= $r22->codigo?>">
                                                        <?=  str_repeat('&nbsp;', strlen($r22->codigo)-3)." ".$r22->descripcion?>
                                                        </a>
                                                    </td>
                                                    <td align="right"><?= number_format($r22->total/1000,0)?></td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td align="right">
                                                        <? switch ($i) {
                                                            case 0:
                                                                echo number_format($r22->total01/1000,0);
                                                                break;
                                                            case 1:
                                                                echo number_format($r22->total02/1000,0);
                                                                break;
                                                            case 2:
                                                                echo number_format($r22->total03/1000,0);
                                                                break;
                                                            case 3:
                                                                echo number_format($r22->total04/1000,0);
                                                                break;
                                                            case 4:
                                                                echo number_format($r22->total05/1000,0);
                                                                break;
                                                            case 5:
                                                                echo number_format($r22->total06/1000,0);
                                                                break;
                                                            case 6:
                                                                echo number_format($r22->total07/1000,0);
                                                                break;
                                                            case 7:
                                                                echo number_format($r22->total08/1000,0);
                                                                break;
                                                            case 8:
                                                                echo number_format($r22->total09/1000,0);
                                                                break;
                                                            case 9:
                                                                echo number_format($r22->total10/1000,0);
                                                                break;
                                                            case 10:
                                                                echo number_format($r22->total11/1000,0);
                                                                break;
                                                            case 11:
                                                                echo number_format($r22->total12/1000,0);
                                                                break;
                                                        }?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <?
                                                // nivel 3
                                                $ssql="select * from est_informe5 where iduser=".$usr->getId();
                                                if($ceroseco!=1) {
                                                    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
                                                    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
                                                }
                                                
                                                $ssql.=" and left(codigo,6)='".$r22->codigo."' and nivel=3 order by codigo";
//                                                echo "r22: $ssql<br>";
                                                $r3=$conx->consultaBase($ssql, $conn);
                                                while($r33=mysqli_fetch_object($r3)) { 
                                                    $ccc=$cfg->getColordescriptor3();
                                                    ?>
                                                <tr class="collapse" id="menu-<?= $r22->codigo?>" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                    <td align="left">
                                                        <a data-toggle="collapse" style="color: <?= $ccc?>" href="#menu-<?= $r33->codigo?>">
                                                        <?=  str_repeat('&nbsp;', strlen($r33->codigo)-3)." ".$r33->descripcion?>
                                                        </a>
                                                    </td>
                                                    <td align="right"><?= number_format($r33->total/1000,0)?></td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td align="right">
                                                        <? switch ($i) {
                                                            case 0:
                                                                echo number_format($r33->total01/1000,0);
                                                                break;
                                                            case 1:
                                                                echo number_format($r33->total02/1000,0);
                                                                break;
                                                            case 2:
                                                                echo number_format($r33->total03/1000,0);
                                                                break;
                                                            case 3:
                                                                echo number_format($r33->total04/1000,0);
                                                                break;
                                                            case 4:
                                                                echo number_format($r33->total05/1000,0);
                                                                break;
                                                            case 5:
                                                                echo number_format($r33->total06/1000,0);
                                                                break;
                                                            case 6:
                                                                echo number_format($r33->total07/1000,0);
                                                                break;
                                                            case 7:
                                                                echo number_format($r33->total08/1000,0);
                                                                break;
                                                            case 8:
                                                                echo number_format($r33->total09/1000,0);
                                                                break;
                                                            case 9:
                                                                echo number_format($r33->total10/1000,0);
                                                                break;
                                                            case 10:
                                                                echo number_format($r33->total11/1000,0);
                                                                break;
                                                            case 11:
                                                                echo number_format($r33->total12/1000,0);
                                                                break;
                                                        }?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <?
                                                // nivel 3
                                                $ssql="select * from est_informe5 where iduser=".$usr->getId();
                                                if($ceroseco!=1) {
                                                    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
                                                    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
                                                }
                                                
                                                $ssql.=" and left(codigo,9)='".$r33->codigo."' and nivel=4 order by codigo";
//                                                echo "r22: $ssql<br>";
                                                $r4=$conx->consultaBase($ssql, $conn);
                                                while($r44=mysqli_fetch_object($r4)) { 
                                                    $ccc=$cfg->getColordescriptor4();
                                                    ?>
                                                <tr class="collapse" id="menu-<?= $r33->codigo?>" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                    <td align="left">
                                                        <a data-toggle="collapse" style="color: <?= $ccc?>" href="#menu-<?= $r44->codigo?>">
                                                        <?=  str_repeat('&nbsp;', strlen($r44->codigo)-3)." ".$r44->descripcion?>
                                                        </a>
                                                    </td>
                                                    <td align="right"><?= number_format($r44->total/1000,0)?></td>
                                                    <? for($i=0;$i<12;$i++) { ?>
                                                    <td align="right">
                                                        <? switch ($i) {
                                                            case 0:
                                                                echo number_format($r44->total01/1000,0);
                                                                break;
                                                            case 1:
                                                                echo number_format($r44->total02/1000,0);
                                                                break;
                                                            case 2:
                                                                echo number_format($r44->total03/1000,0);
                                                                break;
                                                            case 3:
                                                                echo number_format($r44->total04/1000,0);
                                                                break;
                                                            case 4:
                                                                echo number_format($r44->total05/1000,0);
                                                                break;
                                                            case 5:
                                                                echo number_format($r44->total06/1000,0);
                                                                break;
                                                            case 6:
                                                                echo number_format($r44->total07/1000,0);
                                                                break;
                                                            case 7:
                                                                echo number_format($r44->total08/1000,0);
                                                                break;
                                                            case 8:
                                                                echo number_format($r44->total09/1000,0);
                                                                break;
                                                            case 9:
                                                                echo number_format($r44->total10/1000,0);
                                                                break;
                                                            case 10:
                                                                echo number_format($r44->total11/1000,0);
                                                                break;
                                                            case 11:
                                                                echo number_format($r44->total12/1000,0);
                                                                break;
                                                        }?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                    
                                                <? } } }?>
                                                
                                                <? } ?>
                                                <tr>
                                                    <td colspan="14"><hr></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>TOTAL ENTRADAS</td>
                                                    <td align="right"><?= number_format(($tentradas[0]+$tentradas[1]+$tentradas[2]+$tentradas[3]+$tentradas[4]+$tentradas[5]+$tentradas[6]+$tentradas[7]+$tentradas[8]+$tentradas[9]+$tentradas[10]+$tentradas[11])/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[0]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[1]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[2]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[3]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[4]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[5]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[6]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[7]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[8]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[9]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[10]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tentradas[11]/1000,0)?></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>TOTAL SALIDAS</td>
                                                    <td align="right"><?= number_format(($tsalidas[0]+$tsalidas[1]+$tsalidas[2]+$tsalidas[3]+$tsalidas[4]+$tsalidas[5]+$tsalidas[6]+$tsalidas[7]+$tsalidas[8]+$tsalidas[9]+$tsalidas[10]+$tsalidas[11])/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[0]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[1]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[2]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[3]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[4]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[5]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[6]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[7]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[8]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[9]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[10]/1000,0)?></td>
                                                    <td align="right"><?= number_format($tsalidas[11]/1000,0)?></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>SALDO FINAL</td>
                                                    <td align="right"><?= number_format(($ttotal[0]+$ttotal[1]+$ttotal[2]+$ttotal[3]+$ttotal[4]+$ttotal[5]+$ttotal[6]+$ttotal[7]+$ttotal[8]+$ttotal[9]+$ttotal[10]+$ttotal[11])/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[0]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[1]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[2]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[3]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[4]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[5]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[6]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[7]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[8]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[9]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[10]/1000,0)?></td>
                                                    <td align="right"><?= number_format($ttotal[11]/1000,0)?></td>
                                                </tr>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
