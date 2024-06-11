<?php
/*
 * Creado el 13/03/2019 21:26:29
 * Autor: gus
 * Archivo: adm_cped_det.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cped.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_crem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conx=new conexion();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Detalle Pedido #$id";
$botoncap="Ingresar REMITO";
$fecha=date("Y-m-d");
$idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_cped_1($id);
$d_idart=$adm->getDet_idpro();
$d_cantidad=$adm->getDet_cantidad();
$d_precio=$adm->getDet_precio();
$d_total=$adm->getDet_importe();
$d_articulo=$adm->getDet_articulo();
$d_recipiente=$adm->getDet_recipiente();
$cantidaddet=count($d_cantidad);

$ssql="select * from adm_crem order by numero desc limit 1";
$crem=new adm_crem_2($ssql);
$numero=$crem->getNumero();
$nro=$numero[0]+1;
$ptovta=$crem->getPtovta();
$pto=$ptovta[0];
//$numeronuevo=$numero+1;
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
<form name="form1" id="form1" action="adm_cprem_act_save.php" method="post">
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
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_cped_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número Remito&nbsp;</td>
                                        <td>
                                            <input name="ptovta" id="ptovta" type="text" size="4" maxlength="4" onkeypress="return validar(event)" style="text-align: center" value="<?= $pto?>" /> 
                                            <input name="numero" id="numero" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" value="<?= $nro?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Fecha Remito&nbsp;</td>
                                        <td width="65%" class="letra6bold"><input name="fecharem" id="fecharem" type="date" class="letra6" value="<?= $adm->getFechaentrega()?>" required /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Cliente&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getCliente()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Patente&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getPatente()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Total&nbsp;</td>
                                        <td class="letra6bold"><?= number_format($adm->getTotal(),2)?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getObservaciones()?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Producto</td>
                                                            <td align="center">Cantidad</td>
                                                            <td align="center">Recipiente</td>
                                                            <td align="right">Precio</td>
                                                            <td align="right">Total</td>
                                                        </tr>

                                                        <? for($i=0;$i<count($d_cantidad);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td><?= $d_articulo[$i]?></td>                            
                                                            <td align="center"><?= $d_cantidad[$i]?></td>
                                                            <td align="center"><?= $d_recipiente[$i]?></td>
                                                            <td align="right"><?= $d_precio[$i]?></td>
                                                            <td align="right"><?= $d_total[$i]?></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                                <div align="center">
                                                    <input type="submit" name="Submit" value="<?= $botoncap?>" />
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
<script>
