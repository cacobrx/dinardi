<?php
/*
 * creado el 27/08/2017 17:14:23
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_inf_ctacte
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/clientes.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$idcli=$glo->getGETPOST("idcli");
$clienteselcta=$glo->getGETPOST("clienteselcta");
$primero=$glo->getGETPOST("primero");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($idcli>0)
    $clienteselcta=$glo->getGETPOST("idcli");
$url=$glo->getGETPOST("url");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="")
    $fechafin=date("Y-m-d");
if($clienteselcta>0) {
    $cli=new adm_cli_1($clienteselcta);
    $fechainicioctacte=$cli->getFechainicioctacte();
    $inf=new ctacte_clientes($clienteselcta, $fechaini, $fechafin, $fechainicioctacte, $centrosel, $cli->getSaldoini());
    $i_fec=$inf->getFecha();
    $i_det=$inf->getDetalle();
    $i_imp=$inf->getImporte();
    $i_sal=$inf->getSaldo();
    $i_sig=$inf->getSigno();
    $totaldebe=0;
    $totalhaber=0;
    for($i=0;$i<count($i_fec);$i++) {
        if($i_sig[$i]=="D")
            $totaldebe+=$i_imp[$i];
        else
            $totalhaber+=$i_imp[$i];
    }
    $saldofinal=-$totalhaber + $totaldebe;
} else {
    $i_fec=array();
    $totaldebe=0;
    $totalhaber=0;
    $saldofinal=0;
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
<script type="text/javascript" src="planb.js"></script>
<?require_once 'estilos.php';?>
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
        <input name="primero" id="primero" type="hidden" value="<?= $primero?>" />
        <input name="url" id="url" type="hidden" value="<?= $url?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CUENTA CORRIENTE CLIENTES</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            <? if($url!="") { ?>
                                            <a href="javascript: document.form1.target='_self'; document.form1.action='adm_inf_saldos.php'; document.form1.submit()"><img src="images/back.png" width="16" height="12" title="Volver" alt="Volver" /></a>
                                            <? } ?> 
                                            Cliente 
                                            <select name="clienteselcta" class="letra6" id="clienteselcta">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido,nombre, '(', id, ')') as campo from adm_cli order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $clienteselcta, "Sel");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" id="fechaini" class="letra6" type="date" value="<?= $fechaini?>" />
                                            hasta <input name="fechafin" id="fechafin" class="letra6" type="date" value="<?= $fechafin?>" /> | 
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Procesar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_cli_ctacte.php'; document.form1.submit()" /> 
                                            <input name="cmdPrint" id="cmdPrint" value="Imprimir" type="submit" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_cli_ctacte_prn.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" class="letra6">
                                                        <tr class="letra6bold" bgcolor="<?= $cfg->getColor1()?>" style="color: white; font-weight: bold">
                                                            <td colspan="2" align="right">Totales&nbsp;</td>
                                                            <td align="right"><?= number_format($totaldebe,2)?></td>
                                                            <td align="right"><?= number_format($totalhaber,2)?></td>
                                                            <td align="right"><?= number_format($saldofinal,2)?></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr class="letra6bold">
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="30%">Detalle</td>
                                                            <td width="10%" align="right">Adeudado</td>
                                                            <td width="10%" align="right">Pagos</td>
                                                            <td width="10%" align="right">Saldo</td>
                                                            <td width="30%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        $sal=0;
                                                        for($i=0;$i<count($i_fec);$i++) { 
                                                            if($i_sig[$i]=="D")
                                                                $sal+=$i_imp[$i];
                                                            else
                                                                $sal-=$i_imp[$i];
                                                            ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td><?= $dsup->getFechaNormalCorta(($i_fec[$i]))?></td>
                                                            <td><?= $i_det[$i]?></td>
                                                            <td align="right"><? if($i_sig[$i]=="D") echo number_format($i_imp[$i],2)?></td>
                                                            <td align="right"><? if($i_sig[$i]=="H") echo number_format($i_imp[$i],2)?></td>
                                                            <td align="right"><?= number_format($sal,2)?></td>
                                                            <td>&nbsp;</td>
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

