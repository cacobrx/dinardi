<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_act.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $carteltarea="Agrega Articulos de Venta";
    $botoncap="Agregar!";
    $descripcion='';
    $precioventa="";
    $estadoproducto=0;
    $elaborado=0;
    $envasado=0;
    $unidad=0;
    $unidadxanimal="";
    $kilosxanimal="";
    $presentacion=0;
    $codigoproducto="";
    $fechacreate=date("Y-m-d");
    $fechamod=date("Y-m-d");
    $colorcamara="";
    $colorletra="";
    $posicionx=array();
    $posiciony=array();
    $posicionz=array();
    $cantidaddet=0;
} else {
    $carteltarea="Modifica Articulos de Venta";
    require_once 'clases/adm_prd.php';
    $botoncap="Modificar!";
    $adm=new adm_prd_1($id);
    $id=$adm->getId();
    $descripcion=$adm->getDescripcion();
    $precioventa=$adm->getPrecioventa();
    $estadoproducto=$adm->getEstadoproducto();
    $unidad=$adm->getUnidad();
    $elaborado=$adm->getElaborado();
    $envasado=$adm->getEnvasado();
    $unidadxanimal=$adm->getUnidadxanimal();
    $kilosxanimal=$adm->getKilosxanimal();
    $presentacion=$adm->getPresentacion();
    $codigoproducto=$adm->getCodigoproducto();
    $fechacreate=$adm->getFechacreate();
    $fechamod=$adm->getFechamod();
    $rubro=$adm->getRubro();
    $colorcamara=$adm->getColorcamara();
    $colorletra=$adm->getColorletra();
    $posicionx=$adm->getPosicionx();
    $posiciony=$adm->getPosiciony();
    $posicionz=$adm->getPosicionz();
    $cantidaddet=count($posicionx);
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
<form name="form1" id="form1" action="adm_prd_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="cantidaddet" id="cantidaddet" type="hidden" value="<?= $cantidaddet?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_prd_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Codigo del Producto&nbsp;</td>
                                        <td><input name="codigoproducto" type="text" class="letra6" id="codigoproducto" size="5" maxlength="5" value="<?= $codigoproducto?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>                  
                                    <tr>
                                        <td width="40%" align="right">Descripcion&nbsp;</td>
                                        <td width="65%"><input name="descripcion" type="text" class="letra6" id="descripcion" size="50" maxlength="50" value="<?= $descripcion?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Precio&nbsp;</td>
                                        <td><input name="precioventa" type="text" class="letra6" id="precioventa" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" value="<?= $precioventa?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Rubro&nbsp;</td>
                                        <td>
                                            <select name="rubro" id="rubro">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='RUB' order by valor";
                                                $sup->cargaCombo3($ssql, $rubro);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Unidad&nbsp;</td>
                                        <td>
                                            <select name="unidad" id="unidad">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='UNP' order by valor";
                                                $sup->cargaCombo3($ssql, $a_uni);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right">Unidad por Animal&nbsp;</td>
                                        <td><input name="unidadxanimal" type="text"class="letra6" id="unidadxanimal" size="10" maxlength="10" value="<?= $unidadxanimal?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Kilos por Animal&nbsp;</td>
                                        <td><input name="kilosxanimal" type="text"class="letra6" id="kilosxanimal" size="10" maxlength="10" value="<?= $kilosxanimal?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Presentacion&nbsp;</td>
                                        <td>
                                            <select name="presentacion" id="presentacion">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='PRP' order by valor";
                                                $sup->cargaCombo3($ssql, $a_pre);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Envasado&nbsp;</td>
                                        <td>
                                            <input name="envasado" id="envasado" type="checkbox" value="1" <? if($envasado==1) echo "checked='checked'"?> />
                                        </td>
                                    </tr>
                                                                        
                                    <tr>
                                        <td align="right">Elaboración&nbsp;</td>
                                        <td>
                                            <input name="elaborado" id="elaborado" type="checkbox" value="1" <? if($elaborado==1) echo "checked='checked'"?> />
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Color en Cámara&nbsp;</td>
                                        <td>
                                            <input name="colorcamara" id="colorcamara" type="color" value="<?= $colorcamara?>" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right">Color Letra&nbsp;</td>
                                        <td>
                                            <input name="colorletra" id="colorletra" type="color" value="<?= $colorletra?>" />
                                        </td>
                                    </tr>                                    
                  
                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                <tr class="letra6bold">
                                                    <td align="center">Ubicación</td>

                                                    <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                </tr>
                                                <? for($i=0;$i<count($posicionx);$i++) { ?>
                                                <tr>
                                                    <td align="center">
                                                        <input name="posicionx_0" id="posicionx_0" type="number" min="1" max="99" placeholder="x" value="<?= $posicionx[$i]?>" /> 
                                                        <input name="posiciony_0" id="posiciony_0" type="number" min="1" max="99" placeholder="y" value="<?= $posiciony[$i]?>" /> 
                                                        <input name="posicionz_0" id="posicionz_0" type="number" min="1" max="99" placeholder="z" value="<?= $posicionz[$i]?>" /> 
                                                    </td>
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                </tr>
                                                <? } ?>
                                            </table>

                                        </td>
                                    </tr>       
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
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
$(document).ready(function(){
 
 $(document).on('click', '.add', function(){
  var html = '';
  document.getElementById("cantidaddet").value=parseInt(document.getElementById("cantidaddet").value) +1;
  cantidaddet=document.getElementById("cantidaddet").value;
  html += '<tr>';
  html += '<td align="center"><input name="posicionx_' + cantidaddet + '" id="posicionx_' + cantidaddet + '" type="number" min="1" max="99" placeholder="x" /> <input name="posiciony_' + cantidaddet + '" id="posiciony_' + cantidaddet + '" type="number" min="1" max="99" placeholder="y" /> <input name="posicionz_' + cantidaddet + '" id="posicionz_' + cantidaddet + '" type="number" min="1" max="99" placeholder="z" /></td>';
     html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_remito();
 });
 

 
});
</script>