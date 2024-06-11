<?
/*
 * Creado el 24/07/2020 14:59:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_asistencias_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_asistencias.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'planb_def.php';
require_once 'clases/asistencias.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$xmes=substr($anomesasi,4,2);
$xano=substr($anomesasi,0,4);
$fecha=array();
if($idempasi>0) {
    $inf=new asistencias($idempasi,$anomesasi);
    $fecha=$inf->getFecha();
    $horaentrada=$inf->getHoraentrada();
    $horasalida=$inf->getHorasalida();
    $totaltiempo=$inf->getTotaltiempo();
    $extras=$inf->getExtras();
//    print_r($horaentrada);
//    print_r($horasalida);
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
                <input name="marcar" type="hidden" id="marcar" value="0" />
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">TOTAL DE ASISTENCISAS EMPLEADOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php'; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Período <select name="xano" id="xano">
                                                        <?
                                                        $sup->cargaComboArrayValor($anos, $anos, $xano);
                                                        ?>
                                                    </select> / 
                                                    <select name="xmes" id="xmes">
                                                        <?
                                                        $sup->cargaComboArrayValor($meses, $numeromeses, $xmes);
                                                        ?>
                                                    </select> | 
                                                    Empleado&nbsp;<select name="idempasi" id="idempasi" onchange="javascript: document.form1.target='_self'; document.form1.action='register_asi.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_empleados order by apellido";
                                                        $sup->cargaCombo3($ssql, $idempasi, "Sel.");
                                                        ?>                                                        
                                                    </select>
                                                    <input type="submit" name="cmdOk" id="cmdOk" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.action='register_asi.php'; document.form1.submit()" />
                                                    <input type="submit" name="cmdprint" id="cmdprint" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_asistencias_prn.php'; document.form1.submit()" /> 
                                                    <input type="submit" name="cmdexp" id="cmdexp" value="Exportar" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_asistencias_prn.php'; document.form1.submit()" /> 

                                                </td>
                                            </tr>
                                            <? if($idempasi>0) { ?>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Empleado: </span><?= $inf->getEmpleado()?></td>
                                            </tr>
                                            <?  } ?>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%" align="center">Día</td>                                                            
                                                            <td width="20%" align="center">Entrada</td>
                                                            <td width="20%" align="center">Salida</td>
                                                            <td width="20%" align="center">Horas</td>
                                                            <td width="20%" align="center">Extras</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($fecha);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="center"><?= date("d", strtotime($fecha[$i]))?></td>                                                            
                                                            <td align="center"><?= $dsup->getFechaHoraNormal($horaentrada[$i])?></td>
                                                            <td align="center"><?= $dsup->getFechaHoraNormal($horasalida[$i])?></td>
                                                            <td align="center"><?= $totaltiempo[$i]?></td>
                                                            <td align="center"><?= $extras[$i]?></td>
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


