<?php
/*
 * creado el 14/04/2017 11:50:50
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_index
 */

require_once 'user.php';
require_once("clases/globalson.php");
require_once("clases/support.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$sup=new support();
$glo=new globalson();
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

.button {
   border-top: 1px solid <?= $cfg->getColorbarra()?>;
   background: <?= $cfg->getColor1()?>;
   background: -webkit-gradient(linear, left top, left bottom, from(<?= $cfg->getColor1()?>), to(<?= $cfg->getColorbarra()?>));
   background: -webkit-linear-gradient(top, <?= $cfg->getColor1()?>, <?= $cfg->getColorbarra()?>);
   background: -moz-linear-gradient(top, <?= $cfg->getColor1()?>, <?= $cfg->getColorbarra()?>);
   background: -ms-linear-gradient(top, <?= $cfg->getColor1()?>, <?= $cfg->getColorbarra()?>);
   background: -o-linear-gradient(top, <?= $cfg->getColor1()?>, <?= $cfg->getColorbarra()?>);
   padding: 5.5px 11px;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 12px;
   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
   text-decoration: none;
   vertical-align: middle;
   }
.button:hover {
   border-top-color: <?= $cfg->getColorbarra()?>;
   background: <?= $cfg->getColorbarra()?>;
   color: #ccc;
   }
.button:active {
    border-top-color: <?= $cfg->getColorbarra()?>;
    background: <?= $cfg->getColorbarra()?>;
   }

.botonlnk a:active {
	text-decoration: none;
	color: #ffffff;
	border-bottom-style: none;
	font-family: Arial;
	font-size: 16px;
}

.botonlnk a:visited {
	text-decoration: none;
	color: #000000;
	border-bottom-style: none;
	font-family: Arial;
	font-size: 16px;
}


.botonlnk a:link {
	text-decoration: none;
	color: #000000;
	font-family: Arial;
	font-size: 16px;
}

.botonlnk a:hover {
	color: #ffffff;
	font-family: Arial;
	font-size: 16px;
}
   
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<?include_once 'estilos.php';?>

<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="planb_conf_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Sistema de Gestión Integral</h3>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0">
                                                <?if($usr->getNivel()<=1) { ?>
                                                <tr>
                                                    <td width="20%" valign="top" class="button">
                                                        <span class="botonlnk"><a href="adm_art_main.php">PRODUCTOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_prv_main.php">PROVEEDORES</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_rem_main.php">REMITOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_crm_main.php">CONTROL DE REMITOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_cfa_main.php">CONTROL DE FAENA</a></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td width="20%" valign="top" class="button">
                                                        <span class="botonlnk"><a href="adm_cli_main.php">CLIENTES</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_cped_main.php">PEDIDOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_crem_main.php">REMITOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_fis_main.php">FACTURAS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_crec_main.php">COBRANZAS</a></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td width="20%" valign="top" class="button">
                                                        <span class="botonlnk"><a href="adm_ela_main.php">ELABORACION</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_env_main.php">ENVASADO</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_band_main.php">BANDEJAS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"></span>
                                                    </td>

                                                </tr>
                                                <? } else { ?>
                                                <tr>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_prv_main.php">PROVEEDORES</a></span>
                                                    </td>
                                                    <td width="20%" valign="top" class="button">
                                                        <span class="botonlnk"><a href="adm_com_main.php">COMPRAS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_opg_main.php">ORDEN DE PAGO</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_prv_ctacte.php">CUENTA CORRIENTE</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_prv_saldos.php">SALDO</a></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td width="20%" valign="top" class="button">
                                                        <span class="botonlnk"><a href="adm_cli_main.php">CLIENTES</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_fis_main.php">FACTURAS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_crec_main.php">RECIBOS</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_cli_ctacte.php">CUENTA CORRIENTE</a></span>
                                                    </td>
                                                    <td width="20%" class="button">
                                                        <span class="botonlnk"><a href="adm_cli_saldos.php">SALDOS</a></span>
                                                    </td>

                                                </tr>
                                                <? } ?>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
        </td>
    </tr>
</form>
</div>
</body>
</html>
