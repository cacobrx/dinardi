<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_crec_act.php
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/planb_config.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_empleados.php';
require_once 'clases/datesupport.php';
require_once 'clases/horarios.php';
//require_once 'impresion/recibo.php';
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$id=$glo->getGETPOST("id");
//echo "pasa1<br>";
$adm=new adm_empleados_1($id);
$dep=$adm->getIddep();

//$hor=new
  //$cantd--;
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


<? require_once 'estilos.php';?>
</head>

<body onload="total_venta()">
    <div class="style1" id="barblue">
        <blockquote>
            <p class="titulo1"><?= $cfg->getCabecera()?></p>
        </blockquote>
    </div>
    <div id="barcentral">
        <form name="form1" id="form1" action="" method="post">
            <tr>
                <? include("adm_menu.php") ?>
                <input name="id" id="id" type="hidden" value="0" />
                <input name="idrec" id="idrec" type="hidden" value="<?= $idrec?>" />
            </tr>
            <tr>
                <td colspan="2">
                    <? require_once 'displayusuario.php'?>        
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="panel960 letra6">
                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                            <h3 class="ui-widget-header ui-corner-all">DETALLE HORARIOS DE: <?= $adm->getApellido()." ".$adm->getNombre()?> DEPARTAMENTO (<?= $adm->getDepartamento()?>)</h3>                
                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                <tr>
                                    <td width="10%"><a href="javascript: document.form1.action='adm_empleados_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    <td align="center" class="letra6bold"> Turno Mañana</td>
                                    <td align="center" class="letra6bold"> Turno Tarde</td>
                                    <td width="10%"></td>
                                </tr>

                                <tr>
                                    <td colspan="5">
                                        <h3 class="ui-widget-header ui-corner-all"></h3>                
                                        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                            <tr class="letra6bold">
                                                <td width="8%"></td>
                                                <td width="10%" align="center">Entrada</td>                                                            
                                                <td width="10%" align="center">Salida</td>
                                                <td width="10%" align="center">Total</td>
                                                <td width="2%"></td>
                                                <td width="10%" align="center">Entrada</td>                                                            
                                                <td width="10%" align="center">Salida</td>
                                                <td width="10%" align="center">Total</td>
                                                <td width="2%"></td>
                                                <td width="5%" align="right">TOTAL</td>
                                                <td width="5%" align="right">EXT</td>
                                                
                                            </tr>
                                                    <? 
//                                                    $p_fec=$adm->getR2_fecha();
//                                                    $p_com=$adm->getR2_comprobante();
//                                                    $p_imp=$adm->getR2_importe();
//                                                    $p_pag=$adm->getR2_pagado();
//                                                    for($i=0;$i<count($p_imp); $i++) { 
                                                    ?>
<!--                                                    <tr class="letra6">
                                                        <td align="left"><?= $dsup->getFechaNormalCorta($p_fec[$i])?></td>
                                                        <td align="center"><?= $p_com[$i]?></td>
                                                        <td align="right"><?= number_format($p_imp[$i],2)?></td>
                                                        <td align="right"><?= number_format($p_pag[$i],2)?></td>
                                                    </tr>-->
                                                    <? // } ?>
                                                </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="lnk">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td colspan="2"><div align="center"></div></td>
            </tr>
        </form>
    </div>
</body>
</html>