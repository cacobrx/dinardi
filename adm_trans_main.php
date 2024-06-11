<?php
/*
 * creado el 25 nov. 2021 10:56:23
 * Usuario: gus
 * Archivo: adm_trans_main
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/movbancarios.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipo=$glo->getGETPOST("tipo");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($tipo=="") $tipo=0;

$inf=new movbancarios($fechaini, $fechafin, $tipo);
$a_fec=$inf->getFecha();
$a_det=$inf->getDetalle();
$a_imp=$inf->getImporte();
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
<script type="text/javascript" src="planb.js?1.0.0"></script>
<? include("estilos.php");?>
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_fec)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">MOVIMIENTOS BANCARIOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechaini" id="fechaini" class="letra6" type="date" value="<?= $fechaini?>" /> 
                                                    hasta <input name="fechafin" id="fechafin" class="letra6" type="date" value="<?= $fechafin?>" /> |
                                                    Todos <input name="tipo" id="tipo_0" type="radio" value="0" <? if($tipo==0) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.action='adm_trans_main.php'; document.form1.submit()" /> 
                                                    Entradas <input name="tipo" id="tipo_1" type="radio" value="1" <? if($tipo==1) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.action='adm_trans_main.php'; document.form1.submit()" /> 
                                                    Salidas <input name="tipo" id="tipo_2" type="radio" value="2" <? if($tipo==2) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.action='adm_trans_main.php'; document.form1.submit()" /> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_trans_main.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_trans_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_trans_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad de Movimientos: </span><?= count($a_fec)?><span class="letra6"> | Importe Total: </span><?= number_format(array_sum($a_imp),2)?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%" align="left">Fecha</td>
                                                            <td align="left">Detalle</td>
                                                            <td width="10%" align="right">Importe</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_fec);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="left"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_det[$i]?></td>
                                                            <td align="right"><?= number_format($a_imp[$i],2)?></td>
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
                <td>&nbsp;</tr>
            </tr>
        </form>
    </div>
</body>
</html>


