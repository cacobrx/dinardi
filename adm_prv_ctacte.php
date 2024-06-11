<?
/*
 * Creado el 25/03/2013 12:44:38
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: hps_kit_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/prv_ctacte.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$proveedorsel=$glo->getGETPOST("proveedorsel");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipo=$glo->getGETPOST("tipo");
if($tipo=="") $tipo=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="")
    $fechafin=date("Y-m-d");
if($proveedorsel>0) {
    $inf=new ctacte_proveedores($proveedorsel, $fechaini, $fechafin, $tipo);
    $i_fec=$inf->getFecha();
    $i_det=$inf->getDetalle();
    $i_imp=$inf->getImporte();
    $i_sal=$inf->getSaldo();
    $totalcompra=0;
    $totalpago=0;
    for($i=0;$i<count($i_fec);$i++) {
        if($i_imp[$i]<0)
            $totalpago+=abs($i_imp[$i]);
        else
            $totalcompra+=$i_imp[$i];
    }
    $saldofinal=$totalcompra-$totalpago;
} else {
    $i_fec=array();
    $totalcompra=0;
    $totalpago=0;
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
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CUENTA CORRIENTE PROVEEDORES</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            <select name="tipo" id="tipo" onchange="document.form1.target='_self'; document.form1.action='adm_prv_ctacte.php'; document.form1.submit()">
                                                <?
                                                $array=array("Proveedores", "Proveedores Varios");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                ?>
                                            </select> 
                                            <select name="proveedorsel" class="letra6" id="proveedorsel">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=$tipo order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $proveedorsel, "Sel");
                                                ?>
                                            </select> | 
                                            Fecha desde <input name="fechaini" id="fechaini" class="letra6" type="date" value="<?= $fechaini?>" class="letra6" /> 
                                            hasta <input name="fechafin" id="fechafin" type="date" value="<?= $fechafin?>" class="letra6" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input name="cmdok" id="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_prv_ctacte.php'; document.form1.submit()" />
                                            <input name="cmdprn" id="cmdok" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_prv_ctacte_prn.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <tr>
                                            <td><hr></hr></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" class="letra6" cellpadding="2" cellspacing="0">
                                                    <tr class="letra6bold">
                                                        <td colspan="2" align="right">Totales&nbsp;</td>
                                                        <td align="right"><?= number_format($totalcompra,2)?></td>
                                                        <td align="right"><?= number_format($totalpago,2)?></td>
                                                        <td align="right"><?= number_format($saldofinal,2)?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><hr></hr></td>
                                                    </tr>
                                                    <tr class="letra6bold">
                                                        <td width="10%" align="center">Fecha</td>
                                                        <td width="30%">Detalle</td>
                                                        <td width="10%" align="right">Compras</td>
                                                        <td width="10%" align="right">Pagos</td>
                                                        <td width="10%" align="right">Saldo</td>
                                                        <td width="30%">&nbsp;</td>
                                                    </tr>
                                                    <? for($i=0;$i<count($i_fec);$i++) { ?>
                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                        <td><?= $dsup->getFechaNormalCorta(($i_fec[$i]))?></td>
                                                        <td><?= $i_det[$i]?></td>
                                                        <td align="right"><? if($i_imp[$i]>0) echo number_format(abs($i_imp[$i]),2)?></td>
                                                        <td align="right"><? if($i_imp[$i]<0) echo number_format(abs($i_imp[$i]),2)?></td>
                                                        <td align="right"><?= number_format($i_sal[$i],2)?></td>
                                                        <td>&nbsp;</td>
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


