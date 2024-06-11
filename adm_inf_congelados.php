<?php
/*
 * Creado el 14/08/2020 15:04:35
 * Autor: gus
 * Archivo: adm_inf_compras_dia.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/congelados.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$idart=$glo->getGETPOST("idart");
$idprv=$glo->getGETPOST("idprv");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$primero=$glo->getGETPOST("primero");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($primero==1) {
    $inf=new congelados($fechaini, $fechafin, $idart, $idprv);
    $a_art=$inf->getArticulo();
    $a_caj=$inf->getCajas();
    $a_kil=$inf->getKilos();
    $a_fec=$inf->getFecha();
    $totalcajas=$inf->getTotalcajas();
    $totalkilos=$inf->getTotalkilos();

//    print_r($a_fec);
//    print_r($a_art);
//    print_r($a_caj);
} else {
    $a_art=array();
    $a_kil=array();
    $a_caj=array();    
    $a_fec=array();
    $totalcajas=0;
    $totalkilos=0;

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
                                <h3 class="ui-widget-header ui-corner-all">Informe de Congelados</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" type="date" class="letra6" id="fechaini" value="<?= $fechaini?>" /> 
                                            hasta <input name="fechafin" type="date" class="letra6" id="fechafin" value="<?= $fechafin?>" /> | 
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_congelados.php'; document.form1.submit()" />
                                            <input name="cmdPrint" id="cmdPrint" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_congelados_lst.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_congelados_exl.php'; document.form1.submit()" /> 
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
                                            Producto <select name="idart" id="idart">
                                                <?
                                                $ssql="select id as id, descripcion as campo from adm_art where envasado=1 order by descripcion";
                                                $sup->cargaCombo3($ssql, $idart, "Todos");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                            <span class="letra6">Total CAJAS: </span><?= $totalcajas?><span class="letra6"> | Total KILOS: </span><?= $totalkilos?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="40%" align="left">Articulo</td>
                                                    <td width="20%" align="center">Cajas</td>
                                                    <td width="20%" align="center">Kilos</td>

                                                </tr>
                                                <? for($i=0;$i<count($a_fec);$i++) { 
                                                    if(count($a_art[$i])>0) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center" style="background-color: black; color: yellow"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <? for($d=0;$d<count($a_art[$i]);$d++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>&nbsp;</td>
                                                    <td align="left"><?= $a_art[$i][$d]?></td>
                                                    <td align="center"><?= number_format($a_caj[$i][$d],0)?></td>
                                                    <td align="center"><?= number_format($a_kil[$i][$d],2)?></td>
                                                </tr>                                                
                                                <? } ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra6bold">
                                                    <td>Total del Día</td>
                                                    <td>&nbsp;</td>
                                                    <td align="center"><?= number_format(array_sum($a_caj[$i]),2)?></td>
                                                    <td align="center"><?= number_format(array_sum($a_kil[$i]),2)?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><hr></hr></td>
                                                </tr>
                                                <? } } ?>
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


