<?php
/*
 * Creado el 18/03/2016 17:43:44
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_informe_afip
 */


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'planb_def.php';
require_once 'afip.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$primerogen=$glo->getGETPOST("primerogen");
$numeroini=$glo->getGETPOST("numeroini");
$numerofin=$glo->getGETPOST("numerofin");
$TipoComp=$glo->getGETPOST("TipoComp");

if($fechaini=="") {
    $fechaini=date("Y-m-d");
    //$fechaini=date("Y-m-01", strtotime("$fechaini - 1 day"));
}
if($fechafin=="") {
    $fechafin=date("Y-m-d");
    //$fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
}
$a_id=array();

// cajas

//print_r($cajasel);
$a_CbteFch=array();
$a_ImpNeto=array();
$a_ImpTotal=array();
$a_ImpIVA=array();

if($primerogen==1) {
    $adm=new informe_Afip($cfg->getFiscalpuntoventa(), $fechaini, $fechafin, $TipoComp, $cfg->getFiscalcuit());
    $a_CbteFch=$adm->getCbteFch();
    $a_DocTipo=$adm->getDocTipo();
    $a_DocNro=$adm->getDocNro();
    $a_CbteDesde=$adm->getCbteDesde();
    $a_ImpTotal=$adm->getImpTotal();
    $a_ImpNeto=$adm->getImpNeto();
    $a_ImpIVA=$adm->getImpIVA();
    $a_Resultado=$adm->getResultado();
    $a_CodAutorizacion=$adm->getCodAutorizacion();
    $a_EmisionTipo=$adm->getEmisionTipo();
    $a_FchVto=$adm->getFchVto();
    $a_FchProceso=$adm->getFchProceso();
    $a_PtoVta=$adm->getPtoVta();
    $a_CbteTipo=$adm->getCbteTipo();
    $a_cliente=$adm->getCliente();
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="primerogen" type="hidden" id="primerogen" value="1" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
                <input name="urlreg" id="urlreg" type="hidden" value="register_mov_cajas.php" />
                <input name="varcaja" id="varcaja" type="hidden" value="cajasmov" />
            </tr>
            <tr>
                <td>
                    <? require("displayusuario.php");?>
                    <div class="panel960 letra6">
                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                            <h3 class="ui-widget-header ui-corner-all">COMPROBANTES FISCALES EN AFIP</h3>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td>
                                                Fecha desde <input name="fechaini" id="fechaini" class="letra6" type="date" value="<?= $fechaini?>" /> 
                                                hasta <input name="fechafin" id="fechafin" class="letra6" type="date" value="<?= $fechafin?>" />  | 
                                                Comprobante <select name="TipoComp" id="TipoComp">
                                                    <?
                                                    $array=array("Factura A", "Nota Credito A", "Nota Debito A");
                                                    $avalor=array(1,3,2);
                                                    $sup->cargaComboArrayValor($array, $avalor, $TipoComp);
                                                    ?>
                                                </select> | 
                                                <input name="cmdok" id="cmdop" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_informe_afip.php'; document.form1.submit()" /> 
                                                <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_fis_informe_afip_prn.php'; document.form1.submit()" /> 
                                                <input name="cmdexc" id="cmdexc" type="submit" value="Exportar Excel" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_informe_afip_exc.php'; document.form1.submit()" /> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ui-widget-header ui-corner-all"><span class="letra6">Total: </span><span class="letra6bold"><?= number_format(array_sum($a_ImpTotal),2)?></span><span class="letra6"> | Neto: </span><span class="letra6bold"><?= number_format(array_sum($a_ImpNeto),2)?></span><span class="letra6"> | Iva: </span><span class="letra6bold"><?= number_format(array_sum($a_ImpIVA),2)?></span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                    <tr class="letra6bold">
                                                        <td width="8%" align="center">Fecha</td>
                                                        <td width="7%" align="center">Numero</td>
                                                        <td width="11%" align="left">Numero CAE</td>
                                                        <td width="8%" align="center">Vto. CAE</td>
                                                        <td width="13%" align="left">Fec.Proceso</td>
                                                        <td width="26%">Cliente</td>
                                                        <td width="10%" align="right">Neto</td>
                                                        <td width="8%" align="right">IVA</td>
                                                        <td width="10%" align="right">Total</td>
                                                    </tr>
                                                    <? 
                                                    $item=0;
                                                    for($i=0;$i<count($a_CbteFch);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="center"><?= substr($a_CbteFch[$i],6,2)."/".substr($a_CbteFch[$i],4,2)."/".substr($a_CbteFch[$i],0,4)?></td>
                                                            <td align="center"><?= $a_CbteDesde[$i]?></td>
                                                            <td><?= $a_CodAutorizacion[$i]?></td>
                                                            <td align="center"><?= substr($a_FchVto[$i],6,2)."/".substr($a_FchVto[$i],4,2)."/".substr($a_FchVto[$i],0,4)?></td>
                                                            <td align="left"><?= substr($a_FchProceso[$i],6,2)."/".substr($a_FchProceso[$i],4,2)."/".substr($a_FchProceso[$i],0,4)." ".substr($a_FchProceso[$i],8,2).":".substr($a_FchProceso[$i],10,2).":".substr($a_FchProceso[$i],10,2)?></td>
                                                            <td><?= $a_cliente[$i]?></td>
                                                            <td align="right"><?= number_format($a_ImpNeto[$i],2)?></td>
                                                            <td align="right"><?= number_format($a_ImpIVA[$i],2)?></td>
                                                            <td align="right"><?= number_format($a_ImpTotal[$i],2)?></td>
                                                        </tr>
                                                    <? } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </form>
    </div>
</body>
</html>


