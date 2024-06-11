<?php
/*
 * Creado el 15/07/2015 23:10:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_det_main
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_fis_det.php';
require_once 'clases/adm_fis.php';
require_once 'clases/adm_cli.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$id=$glo->getGETPOST("id");
$url=$glo->getGETPOST("url");
if($url=="")
    $url="adm_fis_main.php";
$adm=new adm_fis_1($id);
$cli=new adm_cli_1($adm->getIdcli());
$carteltarea="Detalle Comprobante Fiscal";
$botoncap="Modificar!";
$adm=new adm_fis_1($id);
$id=$adm->getId();
$rm_nro=$adm->getRem_numero();
$ssql="select * from adm_fis_det where idfis=$id";
$det=new adm_fis_det_2($ssql);
$d_can=$det->getCantidad();
$d_det=$det->getDetalle();
$d_pre=$det->getPrecio();
$d_imp=$det->getTotal();
$d_art=$det->getArticulo();
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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
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
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
    </tr>
    <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="letra6">
            <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                    <tr>
                                        <td><a href="javascript: document.form1.action='<?= $url?>'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr>
                                                    <td width="10%">Comprobante</td>
                                                    <td width="10%">Fecha</td>
                                                    <td width="30%">Cliente</td>
                                                    <td width="10%" align="right">&nbsp;</td>
                                                    <td width="10%" align="right">&nbsp;</td>
                                                    <td width="10%" align="right">Nro.CAE</td>
                                                    <td width="20%" align="center">F.CAE</td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td><?= $adm->getTipodes()." ".$adm->getLetra()."-".$adm->getPtovta()."-".$adm->getNumero()?></td>
                                                    <td><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                                    <td><?= $adm->getCliente()?></td>
                                                    <td align="right">&nbsp;</td>
                                                    <td align="right">&nbsp;</td>
                                                    <td align="right"><?= $adm->getNumerocae()?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($adm->getFechacae())?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        Direccion <span class="letra6bold"><?= $cli->getDireccion()?></span> Ciudad <span class="letra6bold"><?= $cli->getCiudaddes()?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        CUIT <span class="letra6bold"><?= $cli->getCuit()?></span> Condicion IVA <span class="letra6bold"><?= $cli->getCondicionivades()?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                            <tr>
                                                                <td width="9%" align="right">Neto 21%</td>
                                                                <td width="9%" align="right">Neto 10.5%</td>
                                                                <td width="9%" align="right">Total Neto</td>
                                                                <td width="9%" align="right">Iva 21%</td>
                                                                <td width="9%" align="right">Iva 10.5%</td>
                                                                <td width="9%" align="right">Tota IVA</td>
                                                                <td width="9%" align="right">No Gravado</td>
                                                                <td width="9%" align="right">Subtotal</td>
                                                                <td width="9%" align="right">Percepción</td>
                                                                <td width="9%" align="right">%Perc.</td>
                                                                <td width="10%" align="right">TOTAL</td>
                                                            </tr>
                                                            <tr class="letra6bold">
                                                                <td align="right"><?= number_format($adm->getNetocf21()+$adm->getNetori21(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getNetocf10()+$adm->getNetori10(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getNeto(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getIvacf21()+$adm->getIvari21(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getIvacf10()+$adm->getIvari10(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getIva21()+$adm->getIVa10(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getNogravado(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getNeto()+$adm->getIva21()+$adm->getIVa10()+$adm->getNogravado(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getPercepcioniibb(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getPorcentajeiibb(),2)?></td>
                                                                <td align="right"><?= number_format($adm->getTotaltotal(),2)?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        Remitos <span class="letra6bold">
                                                            <? for($r=0;$r<count($rm_nro);$r++) { 
                                                                echo $rm_nro[$r]." ";
                                                            }?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        Mensaje <span class="letra6bold"><?= $adm->getError()?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td><hr></td></tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                                <tr class="letra6bold">
                                                    <td width="5%" align="center">Cant.</td>
                                                    <td width="65%">Detalle</td>
                                                    <td width="15%" align="right">Precio</td>
                                                    <td width="15%" align="right">Total</td>
                                                </tr>
                                                <? for($i=0;$i<count($d_can);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= $d_can[$i]?></td>
                                                    <td><?= $d_art[$i]." ".$d_det[$i]?></td>
                                                    <td align="right"><?= number_format($d_pre[$i],2)?></td>
                                                    <td align="right"><?= number_format($d_pre[$i]*$d_can[$i],2)?></td>
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
