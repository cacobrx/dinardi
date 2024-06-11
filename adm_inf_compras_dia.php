<?php
/*
 * Creado el 14/08/2020 15:04:35
 * Autor: gus
 * Archivo: adm_inf_compras_dia.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/compras.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idprv=$glo->getGETPOST("idprv");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$solofaena=$glo->getGETPOST("solofaena");
$sinfaena=$glo->getGETPOST("sinfaena");
$primero=$glo->getGETPOST("primero");
if($sinfaena=="") $sinfaena=0;
if($solofaena=="") $solofaena=0;
if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($primero==1) {
    $inf=new inf_compras_prv_dia($fechaini, $fechafin, $orden, $idprv, $idart, $sinfaena, $sinfaena);
    $a_art=$inf->getArticulo();
    $a_imp=$inf->getImporte();
    $a_can=$inf->getCantidad();
    $a_iva=$inf->getIva();
    $a_neto=$inf->getNeto();
    $a_fecha=$inf->getFecha();
    $a_prov=$inf->getProveedor();
    if($informe==1)
        $a_idart=$inf->getIdart();
//    print_r($a_can);
} else {
    $a_art=array();
    $a_imp=array();
    $a_can=array();    
    $a_neto=array();
    $a_iva=array();
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
                                <h3 class="ui-widget-header ui-corner-all">Informe de Compras</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" type="date" class="letra6" id="fechaini" value="<?= $fechaini?>" /> 
                                            hasta <input name="fechafin" type="date" class="letra6" id="fechafin" value="<?= $fechafin?>" /> | 
                                            Solo Faena <input name="solofaena" id="solofaena" type="checkbox" value="1" <? if($solofaena==1) echo "checked='checked'";?> />
                                            Sin Faena <input name="sinfaena" id="sinfaena" type="checkbox" value="1" <? if($sinfaena==1) echo "checked='checked'";?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Proveedor <select name="idprv" id="idprv">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Todos");
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
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_compras_dia.php'; document.form1.submit()" />
                                            <input name="cmdPrint" id="cmdPrint" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_compras_dia_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_compras_dia_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                            <span class="letra6">Cantidad: </span><?= number_format(array_sum($a_can),0)?>
                                            <span class="letra6"> - Neto: </span><?= number_format(array_sum($a_neto),2)?>
                                            <span class="letra6"> - Iva: </span><?= number_format(array_sum($a_iva),2)?>
                                            <span class="letra6"> - Total: </span><?= number_format(array_sum($a_imp),2)?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="20%" align="left">Proveedor</td>
                                                    <td width="20%" align="left">Producto</td>
                                                    <td width="10%" align="right">Kilos</td>
                                                    <td width="10%" align="right">Precio</td>
                                                    <td width="10%" align="right">Neto</td>
                                                    <td width="10%" align="right">Iva</td>
                                                    <td width="10%" align="right">Importe</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_art);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center" title="<?= $dsup->getFechaNormalCorta($a_fecha[$i])?>"><span  style="background-color: black; color: yellow">
                                                        <?
                                                        if($i>0) {
                                                            if($a_fecha[$i]!=$a_fecha[$i-1])
                                                                echo $dsup->getFechaNormalCorta($a_fecha[$i]);
                                                        } else 
                                                            echo $dsup->getFechaNormalCorta($a_fecha[$i]);
                                                        ?>
                                                        </span></td>
                                                    <td align="left" class="letra6bold">
                                                        <?
                                                        if($i>0) {
                                                            if($a_prov[$i]!=$a_prov[$i-1])
                                                                echo $a_prov[$i];
                                                        } else 
                                                            echo $a_prov[$i];
                                                        ?>
                                                    </td>
                                                    <td align="left"><? echo  $a_art[$i]?></td>
                                                    <td align="right"><?= number_format($a_can[$i],2)?></td>
                                                    <td align="right"><? if($a_can[$i]>0) echo number_format($a_neto[$i]/$a_can[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_neto[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_iva[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_imp[$i],2)?></td>
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
        <td>&nbsp;
            <input name="a_fecha" id="a_fecha" type="hidden" value='<?= serialize($a_fecha)?>' />
            <input name="a_prov" id="a_art" type="hidden" value='<?= serialize($a_prov)?>' />
            <input name="a_art" id="a_art" type="hidden" value='<?= serialize($a_art)?>' />
            <input name="a_can" id="a_art" type="hidden" value='<?= serialize($a_can)?>' />
            <input name="a_neto" id="a_art" type="hidden" value='<?= serialize($a_neto)?>' />
            <input name="a_iva" id="a_art" type="hidden" value='<?= serialize($a_iva)?>' />
            <input name="a_imp" id="a_art" type="hidden" value='<?= serialize($a_imp)?>' />
        </td>
    </tr>
</form>
</div>
</body>
</html>


