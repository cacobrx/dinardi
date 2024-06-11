<?
/*
 * Creado el 05/06/2020 14:54:24
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_band_act.php
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
    $carteltarea="Agrega Bandejas";
    $botoncap="Agregar!";
    $idart=0;
    $fecha=date("Y-m-d");
    $idprv=0;
    $hielo="";
    $temperatura="";
    $tunel="";
    $control="";
    $contaminante="";
    $kgrechazo="";
    $kg="";

} else {
    $carteltarea="Modifica Bandejas";
    require_once 'clases/adm_band.php';
    $botoncap="Modificar!";
    $adm=new adm_band_1($id);
    $id=$adm->getId();
    $idart=$adm->getIdart();
    $fecha=$adm->getFecha();
    $kg=$adm->getKg();
    $idprv=$adm->getIdprv();
    $hielo=$adm->getHielo();
    $temperatura=$adm->getTemperatura();
    $tunel=$adm->getTunel();
    $control=$adm->getControl();
    $contaminante=$adm->getContaminante();
    $kgrechazo=$adm->getKgrechazo();
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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['required', 'only_on_submit']
}
</script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_band_act_save.php" method="post">
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_band_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Articulo&nbsp;</td>
                                        <td>
                                            <select name="idart" id="idart">
                                                <? 
                                                $ssql="select id as id, descripcion as campo from adm_art where envasado=1 order by descripcion";
                                                $sup->cargaCombo3($ssql, $idart, "Sel.") ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td>
                                            <select name="idprv" id="idprv">
                                                <? 
                                                $ssql="select id as id, apellido as campo from adm_prv where tipo=1 order by apellido";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel.") ?>
                                            </select>
                                        </td>
                                    </tr>                  
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                  






                                    <tr>
                                        <td align="right">Temperatura&nbsp;</td>
                                        <td><input name="temperatura" type="text"class="letra6" id="temperatura" size="3" maxlength="3" value="<?= $temperatura?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Tunel&nbsp;</td>
                                        <td><input name="tunel" type="text"class="letra6" id="tunel" size="3" maxlength="3" value="<?= $tunel?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Hielo&nbsp;</td>
                                        <td><input name="hielo" id="hielo" type="checkbox" value="1" <? if($hielo==1) echo "checked='checked'"; ?> /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Control Organoleptico&nbsp;</td>
                                        <td><input name="control" id="control" type="checkbox" value="1" <? if($control==1) echo "checked='checked'"; ?> /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Contaminante fisico&nbsp;</td>
                                        <td><input name="contaminante" id="contaminante" type="checkbox" value="1" <? if($contaminante==1) echo "checked='checked'"; ?> /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Kilos&nbsp;</td>
                                        <td><input name="kg" type="text"class="letra6" id="kg" size="10" maxlength="10" value="<?= $kg?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Kg rechazo&nbsp;</td>
                                        <td><input name="kgrechazo" type="text"class="letra6" id="kgrechazo" size="10" maxlength="10" value="<?= $kgrechazo?>" onkeypress="return validar(event)" style="text-align: center" /></td>
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
