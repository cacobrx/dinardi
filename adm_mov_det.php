<?php
/*
 * creado el 07/11/2017 19:00:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_det
 */

//print_r($_POST);
require_once "user.php";
require_once "clases/globalson.php";
require_once "clases/planb_config.php";
require_once "clases/support.php";
require_once 'clases/datesupport.php';
require_once 'clases/adm_mov.php';
$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$idmov=$glo->getGETPOST("id");
$adm=new adm_mov_1($idmov);
$carteltarea="Detalle del Movimiento #".$adm->getAsiento();
$detalle=$adm->getDetalle();
$fecha=$adm->getFecha();
$d_idcta=$adm->getDet_idcta();
$d_detalle=$adm->getDet_detalle();
$d_importe=$adm->getDet_importe();
$d_tipo=$adm->getDet_tipo();
$d_codigo=$adm->getDet_codigo();
$d_nombre=$adm->getDet_nombre();
$canti=count($d_idcta);

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
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script src="planb.js" type="text/javascript"></script>
<? require_once 'estilos.php'; ?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="#" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="idmov" type="hidden" id="idmov" value="<?= $idmov?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="canti" type="hidden" id="canti" value="<?= $canti?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_mov_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="20%" align="right">Fecha&nbsp;</td>
                                        <td width="80%" class="letra6bold"><?= date("d/m/Y", strtotime($fecha))?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Detalle&nbsp;</td>
                                        <td class="letra6bold"><?= $detalle?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6bold">
                                                            <td wodth="40%">Cuenta</td>
                                                            <td width="35%">Detalle</td>
                                                            <td width="10%"><div align="right">Debe</div></td>
                                                            <td width="10%"><div align="right">Haber</div></td>
                                                        </tr>
                                                        <? for($i=0;$i<$canti;$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td><?= $d_codigo[$i]."-".$d_nombre[$i]?></td>
                                                            <td><?= $d_detalle[$i]?></td>
                                                            <td align="right">
                                                                <? 
                                                                if($d_tipo[$i]==1) echo number_format($d_importe[$i],2);
                                                                ?>
                                                            </td>
                                                            <td align="right">
                                                                <?
                                                                if($d_tipo[$i]==2) echo number_format($d_importe[$i],2);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
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
