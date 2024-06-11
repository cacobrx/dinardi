<?
/*
 * Creado el 07/07/2020 12:59:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_env_act.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $carteltarea="Agrega Envasado";
    $botoncap="Agregar!";
    $idart=0;
    $tenvasado1="";
    $tenvasado2="";
    $tenvasado3="";
    $fechaing=date("Y-m-d");
    $idprv=0;
    $idprv1=0;
    $idprv2=0;
    $kgdescarte="";
    $lote="";
    $cantidad="";
    $kilos="";
    $tunel=0;
} else {
    $carteltarea="Modifica Envasado";
    require_once 'clases/adm_env.php';
    $botoncap="Modificar!";
    $adm=new adm_env_1($id);
    $id=$adm->getId();
    $idart=$adm->getIdart();
    $tenvasado1=$adm->getTenvasado1();
    $tenvasado2=$adm->getTenvasado2();
    $tenvasado3=$adm->getTenvasado3();
    $fechaing=$adm->getFechaing();
    $idprv=$adm->getIdprv();
    $idprv1=$adm->getIdprv1();
    $idprv2=$adm->getIdprv2();
    $kgdescarte=$adm->getKgdescarte();
    $lote=$adm->getLote();
    $cantidad=$adm->getCantidad();
    $kilos=$adm->getKilos();
    $tunel=$adm->getTunel();
//    echo $idprv." ".$idprv1." ".$idprv2;
}
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
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<script type="text/javascript" src="planbjs/env.js"></script>
<? require_once 'estilos.php';?>

</head>

    <body onload="codigolote1()">
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_env_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_env_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Articulo&nbsp;</td>
                                        <td>
                                            <select name="idart" id="idart" onchange="javascript: codigolote1()">
                                                <? 
                                                $ssql="select id as id, descripcion as campo from adm_art where envasado=1 order by descripcion";
                                                $sup->cargaCombo3($ssql, $idart, "Sel.") ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td>
                                            <select name="idprv" id="idprv" onchange="javascript: codigolote1()">
                                                <? 
                                                $ssql="select id as id, apellido as campo from adm_prv where tipo=1 order by apellido";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel.") ?>
                                            </select>
                                            <select name="idprv1" id="idprv1" onchange="javascript: codigolote1()">
                                                <? 
                                                $ssql="select id as id, apellido as campo from adm_prv where tipo=1 order by apellido";
                                                $sup->cargaCombo3($ssql, $idprv1, "Sel.") ?>
                                            </select>
                                            <select name="idprv2" id="idprv2" onchange="javascript: codigolote1()">
                                                <? 
                                                $ssql="select id as id, apellido as campo from adm_prv where tipo=1 order by apellido";
                                                $sup->cargaCombo3($ssql, $idprv2, "Sel.") ?>
                                            </select>
                                        </td>
                                    </tr>                                     

                                    <tr>
                                        <td align="right">Temp 1 Envasado&nbsp;</td>
                                        <td><input name="tenvasado1" type="text"class="letra6" id="tenvasado1" size="3" maxlength="3" value="<?= $tenvasado1?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;Temp 2 Envasado&nbsp;<input name="tenvasado2" type="text"class="letra6" id="tenvasado2" size="3" maxlength="3" value="<?= $tenvasado2?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;Temp 3 Envasado&nbsp;<input name="tenvasado3" type="text"class="letra6" id="tenvasado3" size="3" maxlength="3" value="<?= $tenvasado3?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Fecha Ingreso&nbsp;</td>
                                        <td><input name="fechaing" type="date" class="letra6" id="fechaing" value="<?= $fechaing?>" onblur="javascript: codigolote1()" /></td>
                                    </tr>


                                    <tr>
                                        <td align="right">Kg Descarte&nbsp;</td>
                                        <td><input name="kgdescarte" type="text"class="letra6" id="kgdescarte" size="10" maxlength="10" value="<?= $kgdescarte?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Lote&nbsp;</td>
                                        <td><input name="lote" type="text"class="letra6" id="lote" size="15" maxlength="15" value="<?= $lote?>" style="text-align: center" /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Cant. Cajas o Pencas&nbsp;</td>
                                        <td><input name="cantidad" type="text"class="letra6" id="cantidad" size="6" maxlength="10" value="<?= $cantidad?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                    
                                    <tr>
                                        <td align="right">Kilos&nbsp;</td>
                                        <td><input name="kilos" type="text"class="letra6" id="kilos" size="6" maxlength="10" value="<?= $kilos?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Túnel&nbsp;</td>
                                        <td><input name="tunel" type="text" class="letra6" id="tunel" size="2" maxlength="2" value="<?= $tunel?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
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
