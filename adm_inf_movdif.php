<?php
/*
 * Creado el 31/05/2018 12:12:42
 * Autor: gus
 * Archivo: adm_inf_movdif.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_contable.php';
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($primero==1) {
    $adm=new diferencias_mov($centrosel,$fechaini, $fechafin);
    $a_id=$adm->getId();
    $a_des=$adm->getDescripcion();
    $a_deb=$adm->getDebe();
    $a_hab=$adm->getHaber();
    $a_sal=$adm->getSaldo();
    $a_fec=$adm->getFecha();
    $a_asi=$adm->getAsiento();
} else
    $a_id=array();

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
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<? require_once "estilos.php" ?>;
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
        <input name="primero" id="primero" type="hidden" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">DIFERENCIAS DE MOVIMIENTOS</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" type="date" class="letra6" id="fechaini" value="<?= $fechaini?>" /> 
                                            hasta <input name="fechafin" type="date" class="letra6" id="fechafin" value="<?= $fechafin?>" /> | 
                                            <input name="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.primero.value=1; document.form1.action='adm_inf_movdif.php'; document.form1.submit()" /> 
                                            <input name="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_movdif_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_movdif_exl.php'; document.form1.submit()" /> 
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
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="10%" align="center">Asiento</td>
                                                    <td width="50%">Descripci&oacute;n</td>
                                                    <td width="10%" align="right">Debe</td>
                                                    <td width="10%" align="right">Haber</td>
                                                    <td width="10%" align="right">Saldo</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="center"><?= $a_asi[$i]?></td>
                                                    <td><?= $a_des[$i]?></td>
                                                    <td align="right"><?= number_format($a_deb[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_hab[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_sal[$i],2)?></td>
                                                </tr>
                                                <? } ?>
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
