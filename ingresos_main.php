<?php
/*
 * creado el 04/07/2016 12:56:24
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_pf_imp
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/horarios.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$contenido=$glo->getGETPOST("contenido");
//echo $contenido;
        
$adm=new horarios($contenido);
$a_equi=$adm->getIddep();
$a_emp=$adm->getIddep();
$a_fec=$adm->getFecha();
$search= array_search("", $a_emp);
//echo $search;
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
                <input name="id" type="hidden" id="id" value="0" />
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">INGRESOS RUTINARIOS</h3>            
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php';?>
                                                </td>
                                            </tr>     
                                            <tr>
                                                <td colspan="2">
                                                    <table width="100%" border="0">
                                                        <tr>
                                                            <td align="center">
                                                                <textarea name="contenido" id="contenido" rows="10" cols="80" placeholder="Pegar el contenido del archivo aquí"><?= $contenido?></textarea>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                                <? if($contenido!="") { ?>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= count($a_emp)?>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6Bold">
                                                            <td width="40%"></td>
                                                            <td width="6%" align="center">Departamento</td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td>Empleado</td>
                                                        </tr>
                                                            <? for($i=0;$i<count($a_equi);$i++) {
                                                                ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccolor?>; background-color: <?= $fondo?>">
                                                            <td></td>
                                                            <td align="center"><?= $a_equi[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaHoraNormal($a_fec[$i])?></td>
                                                            <td><?= $a_emp[$i]?></td>
                                                        </tr>
                                                            <? } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><hr></hr></td>
                                            </tr>
                                                <? } ?>
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <? if($contenido!="") { ?>
                                                    <input type="submit" name="Submit" value="Registrar" onclick="javascript: document.form1.action='ingresos_save.php'; document.form1.submit()" /> 
                                                        <? } ?>
                                                    <input type="submit" name="cmdchk" value="Verificar" onclick="javascript: document.form1.action='ingresos_main.php'; document.form1.submit()" /> 
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
