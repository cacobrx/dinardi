<?php
/*
 * Creado el 21/01/2019 20:57:59
 * Autor: gus
 * Archivo: adm_rem_det.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Detalle Remito #$id";
$botoncap="Modificar";
$fecha=date("Y-m-d");
$idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_rem_1($id);
$fecha=$adm->getFecha();
$idprv=$adm->getIdprv();
$totaltotal=$adm->getTotal();
$d_idart=$adm->getDet_idart();
$d_cantidad=$adm->getDet_cantidad();
$d_precio=$adm->getDet_precio();
$d_animales=$adm->getDet_animales();
$d_kilos=$adm->getDet_kilos();
$d_total=$adm->getDet_total();
$d_descripcion=$adm->getDet_descripcion();
$d_articulo=$adm->getDet_articulo();
$d_unidad=$adm->getDet_unidaddes();
$c_cantidad=$adm->getCrm_cantidad();
$c_peso=$adm->getCrm_peso();
$c_temperatura=$adm->getCrm_temperatura();
$c_articulo=$adm->getCrm_articulo();
$c_unidad=$adm->getCrm_unidaddes();
$faena=$adm->getFaena();
$certificado=$adm->getCertificado();
$cantidaddet=count($d_cantidad);
$cantidadcrm=count($c_articulo);
//print_r($c_cantidad);
//echo "cantidaddet: $cantidaddet<br>";
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['required', 'only_on_submit']
}
</script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_rem_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_rem_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número&nbsp;</td>
                                        <td class="letra6Bold"><?= $sup->AddZeros($adm->getPtovta(), 4)." ".$sup->AddZeros($adm->getNumero(), 8)?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getProveedor()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Certificado&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getCertificado()?></td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right">Países&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getPaises()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Total&nbsp;</td>
                                        <td class="letra6bold"><?= number_format($adm->getTotal(),2)?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Patente&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getPatente()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">ID Compra&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getIdcom()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getObservaciones()?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                <tr class="letra6bold">
                                                    <td width="20%">Producto</td>
                                                    <td width="20%">Detalle</td>
                                                    <td width="10%" align="center">Unidad</td>
                                                    <td width="10%" align="center">Cantidad</td>
                                                    <td width="10%" align="center">Can.Control</td>
                                                    <td width="10%" align="center">Diferencia</td>
                                                    <td width="10%" align="right">Precio</td>
                                                    <td width="10%" align="right">Total</td>
                                                </tr>

                                                <? for($i=0;$i<count($d_cantidad);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td><?= $d_articulo[$i]?></td>                            
                                                    <td><?= $d_descripcion[$i]?></td>
                                                    <td align="center"><?= $d_unidad[$i]?></td>
                                                    <td align="center"><?= $d_cantidad[$i]?></td>
                                                    <? 
                                                    if(!$adm->getFaena()) {
                                                        if($c_cantidad[$i]!=-1 and $c_cantidad[$i]!="") { ?>
                                                            <td align="center"><?= $c_cantidad[$i]?></td>
                                                            <td align="center"><?= number_format($c_cantidad[$i]-$d_cantidad[$i],3)?></td>
                                                        <? } else { ?>
                                                            <td align="center">&nbsp;</td>
                                                            <td align="center">&nbsp;</td>
                                                        <? } 
                                                    } else { ?>
                                                        <td align="center">&nbsp;</td>
                                                        <td align="center">&nbsp;</td>
                                                    <? } ?>
                                                    <td align="right"><?= $d_precio[$i]?></td>
                                                    <? if(!$adm->getFaena()) {
                                                        if($c_cantidad[$i]!=-1 and $c_cantidad[$i]!="") { ?>
                                                            <td align="right"><?= $c_cantidad[$i]*$d_precio[$i]?></td>
                                                        <? } else { ?>
                                                            <td align="right"><?= $d_cantidad[$i]*$d_precio[$i]?></td>
                                                        <? } 
                                                    } else { ?>
                                                        <td align="right"><?= $d_cantidad[$i]*$d_precio[$i]?></td>
                                                    <? } ?>
                                                </tr>
                                                <? } 
                                                if($adm->getFaena()) { 
                                                    for($i=0;$i<$cantidadcrm;$i++) { ?>
                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                        <td><?= $c_articulo[$i]?></td>                            
                                                        <td>&nbsp;</td>
                                                        <td align="center"><?= $c_unidad[$i]?></td>
                                                        <td align="center"><?= $c_cantidad[$i]?></td>
                                                        <td align="center"><?= $c_cantidad[$i]?></td>
                                                        <td align="center">&nbsp;</td>
                                                        <td align="right">&nbsp;</td>
                                                        <td align="right">&nbsp;</td>
                                                    </tr>
                                                    <? }
                                                } ?>
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
<script>
