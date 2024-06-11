<?php
/*
 * Creado el 22/01/2016 11:26:06
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_desc_extras_act
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/tabla.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
  $carteltarea="Agrega Extras Empleados";
  $botoncap="Agregar!";
  $importe='';
  $fecha=date("Y-m-d");
  $idper=0;
} else {
  $carteltarea="Modifica Extras de Empleados";
  require_once 'clases/adm_extras.php';
  $botoncap="Modificar!";
  $adm=new adm_extras_1($id);
  $id=$adm->getId();
  $fecha=$adm->getFecha();
  $idper=$adm->getIdper();
  $importe=$adm->getImporte();
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
	fecha: ['required', 'only_on_submit']
}
</script>


</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_extras_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>
                <tr>
                    <td colspan="2">
                        <div class="panel700c letra6">
                            <div id="effect-panel700c" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_extras_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right" width="35%">Fecha&nbsp;</td>
                                        <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Empleado&nbsp;</td>
                                        <td>
                                            <select name="idper" id="idper">
                                            <?
                                            $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_empleados order by nombre";
                                            $sup->cargaCombo3($ssql, $idper, "Seleccionar");
                                            ?>
                                            </select>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe&nbsp;<span class="letra5">(Si es negativo, corresponde a un adelanto)</span></td>
                                        <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" value="<?= $importe?>" onkeypress="return validar_punto_menos(event)" style="text-align: center" /></td>
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
</form>
</div>
</body>
</html>
