<?php
/*
 * creado el 10/11/2017 14:34:00
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_vta_conf_main
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_vta_conf.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$condicion="";
//$ntex=strlen($textoemp);
$ssql="select * from adm_vta_conf";
$ssql.=" order by idtipo";
//echo $ssql;
$adm=new adm_vta_conf_2($ssql);
    
$a_id=$adm->getId();
$a_cta=$adm->getidcta();
$tipocuenta=$adm->getTipocuenta();
$tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");

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
        <form name="form1" id="form1" action="adm_vta_conf_main_save.php" method="post">
            <tr>
                <? include("adm_menu.php") ?>
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">CONFIGURACIÓN CUENTAS DE VENTAS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="40%" align="tipo">Cuenta</td>
                                                            <td width="40%" align="left">Tipo</td>
                                                            <td width="20%" align="left">Debe o Haber</td>
                                                            <td width="20%" align="left">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=1;$i<count($tipos);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="left"><?= $tipos[$i]?></td>
                                                            <td align="left">
                                                                <select name="idcta<?= $i?>" id="idcta<?= $i?>">
                                                                    <?
                                                                    $ssql="select id as id, concat_ws(' ', nombre, '-', codigo) as campo from adm_cta where tipo=1 order by nombre";
                                                                    $sup->cargaCombo3($ssql, $a_cta[$i-1], "Sel.");
                                                                    ?>
                                                                </select>
                                                            </td>                                                                                                                                                       
                                                            <td>
                                                                <select name="tipocuenta" id="tipocuenta">
                                                                    <?
                                                                    $array=array("Debe","Haber");
                                                                    $avalor=array(0,1);
                                                                    $sup->cargaComboArrayValor($array, $avalor, $tipocuenta);
                                                                    ?>
                                                                </select>
                                                            </td>                                    
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><hr></hr></td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input name="cmdok" id="cmdok" type="submit" value="Modificar" />
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


