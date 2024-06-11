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
require_once 'clases/adm_crec.php';
require_once 'clases/adm_rec2.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'impresion/recibo.php';
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$idrec=$glo->getGETPOST("idrec");
//echo "pasa1<br>";
$adm=new adm_crec1_1($idrec);
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
                            <h3 class="ui-widget-header ui-corner-all">DETALLE RECIBO #<?= $adm->getId()?></h3>                
                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                <tr>
                                    <td colspan="2"><a href="javascript: document.form1.action='adm_crec_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                </tr>

                                <tr>
                                    <td width="35%" align="right">Fecha Pago&nbsp;</td>
                                    <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                </tr> 
                                <tr>
                                  <td align="right">Cliente&nbsp;</td>
                                  <td class="letra6bold"><?= $adm->getCliente()?></td>
                                </tr> 
                                <tr>
                                  <td align="right">Importe&nbsp;</td>
                                  <td class="letra6bold"><?= number_format($adm->getImporte(),2)?></td>
                                </tr>
                                <tr>
                                  <td align="right">Concepto&nbsp;</td>
                                  <td class="letra6bold"><?= $adm->getConcepto()?></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="panel910 letra6">
                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                <h3 class="ui-widget-header ui-corner-all">Detalle Pagos</h3>                
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                    <tr class="letra6bold">
                                                        <td><a href="javascript: document.form1.target='_self'; document.form1.action='adm_crec_pag_add.php'; document.form1.submit()"<i class="fas fa-plus-circle fa-lg"></i></a></td>
                                                        <td width="20%">Forma de Pago</td>
                                                        <td>Detalle</td>
                                                        <td width="20%" align="right">Importe</td>
                                                        <td width="2%">&nbsp;</td>
                                                    </tr>
                                                    <? 
                                                    $d_detalle=$adm->getR3_detalle();
                                                    $d_detallepago=$adm->getR3_detallepagodes();
                                                    $d_imp=$adm->getR3_importe();
                                                    $d_id=$adm->getR3_id();
                                                    for($i=0;$i<count($d_detalle); $i++) { 
                                                    ?>
                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                        <td><a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $d_id[$i]?>; document.form1.action='adm_crec_pag_mod.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Detalle Pago" title="Modifica Detalle Pago"></i></a></td>
                                                        <td><?= $d_detallepago[$i]?></td>
                                                        <td><?= $d_detalle[$i]?></td>
                                                        <td align="right"><?= number_format($d_imp[$i],2)?></td>
                                                        <td><a href="javascript: bajareg(<?= $d_id[$i]?>,'Elimina Detalle Pago?','adm_crec_pag_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Detalle Pago" title="Elimina Detalle Pago"></i></a></td>
                                                    </tr>
                                                    <? } ?>
                                                    <tr>
                                                        <td colspan="5"><hr></hr></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Pagos</td>
                                                        <td colspan="2">&nbsp;</td>
                                                        <td align="right"><?= number_format(array_sum($d_imp),2)?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="panel910 letra6">
                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                <h3 class="ui-widget-header ui-corner-all">Comprobantes Cancelados</h3>                
                                                <table width="50%" border="0" cellspacing="0" cellpadding="2" align="center">
                                                    <tr class="letra6bold">
                                                        <td width="20%" align="left">Fecha</td>
                                                        <td width="40%" align="center">Comprobante</td>
                                                        <td width="20%" align="right">Importe</td>
                                                        <td width="20%" align="right">Pagado</td>
                                                    </tr>
                                                    <? 
                                                    $p_fec=$adm->getR2_fecha();
                                                    $p_com=$adm->getR2_comprobante();
                                                    $p_imp=$adm->getR2_importe();
                                                    $p_pag=$adm->getR2_pagado();
                                                    for($i=0;$i<count($p_imp); $i++) { 
                                                    ?>
                                                    <tr class="letra6">
                                                        <td align="left"><?= $dsup->getFechaNormalCorta($p_fec[$i])?></td>
                                                        <td align="center"><?= $p_com[$i]?></td>
                                                        <td align="right"><?= number_format($p_imp[$i],2)?></td>
                                                        <td align="right"><?= number_format($p_pag[$i],2)?></td>
                                                    </tr>
                                                    <? } ?>
                                                </table>
                                            </div>
                                        </div>
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