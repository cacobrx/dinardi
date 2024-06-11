<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ccon_main.php
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/ventas.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idcli=$glo->getGETPOST("idcli");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$primero=$glo->getGETPOST("primero");
$informe=$glo->getGETPOST("informe");
if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($primero==1) {
    if($informe==1)
        $inf=new inf_ventas($fechaini, $fechafin, $orden, $idcli, $idart);
    else {
        $inf=new inf_ventas_cli($fechaini, $fechafin, $orden, $idcli, $idart);
        $a_por=$inf->getPorcentaje();
        $a_per=$inf->getPercepcioniibb();
        $a_tot=$inf->getTotal();
    }
    $a_art=$inf->getArticulo();
    $a_imp=$inf->getImporte();
    $a_can=$inf->getCantidad();
    $a_iva=$inf->getIva();
    $a_neto=$inf->getNeto();
//    print_r($a_can);
} else {
    $a_art=array();
    $a_imp=array();
    $a_can=array();  
    $a_iva=array();
    $a_neto=array();
    $a_per=array();
    $a_tot=array();
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
<? require_once 'estilos.php'?>        

</head>
<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="primero" id="primero" type="hidden" value="1" />
        <input name="informe" id="informe" type="hidden" value="<?= $informe?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Informe de Ventas</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" type="date" class="letra6" id="fechaini" value="<?= $fechaini?>" /> 
                                            hasta <input name="fechafin" type="date" class="letra6" id="fechafin" value="<?= $fechafin?>" /> | 
                                            Orden <select name="orden" id="orden">
                                                <?
                                                $array=array("Descripción", "Cantidad Mayor", "Importe Mayor");
                                                $avalor=array(1,2,3);
                                                $sup->cargaComboArrayValor($array, $avalor, $orden);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Clientes <select name="idcli" id="idcli">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_cli order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idcli, "Todos");
                                                ?>
                                            </select> | 
                                            Productos <select name="idart" id="idart">
                                                <?
                                                $ssql="select id as id, descripcion as campo from adm_prd order by descripcion";
                                                $sup->cargaCombo3($ssql,$idart,"Todos");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Informe x Artículo" onclick="javascript: document.form1.target='_self'; document.form1.informe.value=1; document.form1.action='adm_inf_ventas.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Informe x Cliente" onclick="javascript: document.form1.target='_self'; document.form1.informe.value=2; document.form1.action='adm_inf_ventas.php'; document.form1.submit()" />
                                            <input name="cmdPrint" id="cmdPrint" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_ventas_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_ventas_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                            <span class="letra6">Cantidad: </span><?= number_format(array_sum($a_can),0)?>
                                            <span class="letra6"> - Neto: </span><?= number_format(array_sum($a_neto),2)?>
                                            <span class="letra6"> - Iva: </span><?= number_format(array_sum($a_iva),2)?>
                                            <span class="letra6"> - Importe: </span><?= number_format(array_sum($a_imp),2)?>
                                            <? if($informe==2) { ?>
                                            <span class="letra6"> - Perc.IIBB: </span><?= number_format(array_sum($a_per),2)?>
                                            <span class="letra6"> - Total: </span><?= number_format(array_sum($a_tot),2)?>
                                            <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td align="left">
                                                        <? if($informe==1) echo "Producto"; else echo "Cliente";?>
                                                    </td>
                                                    <td width="10%" align="right">Kilos</td>
                                                    <td width="10%" align="right">Neto</td>
                                                    <td width="10%" align="right">Iva</td>
                                                    <td width="10%" align="right">Importe</td>
                                                    <? if($informe==2) { ?>
                                                    <td width="10%" align="right">%</td>
                                                    <td width="10%" align="right">Perc.IIBB</td>
                                                    <td width="10%" align="right">Total</td>
                                                    <? } ?>
                                                </tr>
                                                <? for($i=0;$i<count($a_art);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="left"><?= $a_art[$i]?></td>
                                                    <td align="right"><?= number_format($a_can[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_neto[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_iva[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                    <? if($informe==2) { ?>
                                                    <td align="right"><?= number_format($a_por[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_per[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_tot[$i],2)?></td>
                                                    <? } ?>
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


