<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function cargacombo() {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_art.php';
    $conx=new conexion();
    //$ssql="select adm_cli_pre.* from adm_cli_pre, adm_prd where adm_prd.id=adm_cli_pre.idart and adm_cli_pre.importe>0 and adm_cli_pre.idcli=$idcli order by adm_prd.codigoproducto";
    $ssql="select * from adm_art where envasado=1 order by descripcion";    
    $adm=new adm_art_2($ssql);
    $a_id=$adm->getId();
    $a_des=$adm->getDescripcion();
    $cad="";
    for($i=0;$i<count($a_id);$i++) {
        echo '<option value="'.$a_id[$i].'">'.$a_des[$i].'</option>';
    }
    return $cad;
}
function cargacombo2() {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_prv.php';
    $conx=new conexion();
    //$ssql="select adm_cli_pre.* from adm_cli_pre, adm_prd where adm_prd.id=adm_cli_pre.idart and adm_cli_pre.importe>0 and adm_cli_pre.idcli=$idcli order by adm_prd.codigoproducto";
    $ssql="select * from adm_prv where tipo=1 order by apellido";    
    $adm=new adm_prv_2($ssql);
    $p_id=$adm->getId();
    $p_ape=$adm->getApellido();
    $p_nom=$adm->getNombre();
    $cad="";
    for($i=0;$i<count($p_id);$i++) {
        echo '<option value="'.$p_id[$i].'">'.$p_ape[$i].'</option>';
    }
    return $cad;
}
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
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
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
        width:<?= $_SESSION['anchopantalla']?>px;
        height:75px;
        z-index:1;
        margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        padding-right: 100px;
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
<form name="form1" id="form1" action="adm_band_act_varios_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />        
        
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panelmax960 letra6">
                            <div id="effect-panelmax960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all" align="center">Agregar varias Bandejas<br></br></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_env_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panelmax letra6">
                                                <div id="effect-panelmax910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Fecha</td>
                                                            <td>Artículo Proveedor</td>

                                                            <td>Temp.</td>
                                                            <td>Túnel</td>
                                                            <td>Hielo</td>
                                                            <td>Control</td>
                                                            <td>Contam. Físico</td>
                                                            <td>Kilos</td>
                                                            <td>Kg. Rechazo</td>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="date" id="item_fecha0" name="item_fecha0" value="<?= date("Y-m-d")?>" class="letra6" /></td>
                                                            <td><select name="item_producto0" id="item_producto0"><option value="">[Seleccionar]</option><?php echo cargacombo() ?></select><select name="item_proveedor0" id="item_proveedor0"><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select></td>
                                                            <td><input type="text" id="item_temperatura0" name="item_temperatura0" size="3" maxlength="3" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td><input type="text" id="item_tunel0" name="item_tunel0" size="3" maxlength="3" onkeypress="return validar_punto(event)" style="text-align: center" /></td>                                                           
                                                            <td><input type="checkbox" id="item_hielo0" name="item_hielo0" value="1" /></td>
                                                            <td><input type="checkbox" id="item_control0" name="item_control0" value="1" /></td>
                                                            <td><input type="checkbox" id="item_contaminante0" name="item_contaminante0" value="1" /></td>                                                           
                                                            <td><input type="text" id="item_kilos0" name="item_kilos0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td><input type="text" id="item_descarte0" name="item_descarte0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="Agregar" />
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
  html += '<td><input type="date" id="item_fecha' + cantidaddet + '" name="item_fecha' + cantidaddet + '" value="<?= date("Y-m-d")?>" class="letra6" /></td>';
  html += '<td><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" ><option value="">[Seleccionar]</option><?php echo cargacombo() ?></select><select name="item_proveedor' + cantidaddet + '" id="item_proveedor' + cantidaddet + '" ><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select></td>';
  html += '<td><input type="text" id="item_temperatura' + cantidaddet + '" name="item_temperatura' + cantidaddet + '" size="3" maxlength="3" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><input type="text" id="item_tunel' + cantidaddet + '" name="item_tunel' + cantidaddet + '" size="3" maxlength="3" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><input type="checkbox" id="item_hielo' + cantidaddet + '" name="item_hielo' + cantidaddet + '"  /></td>';
  html += '<td><input type="checkbox" id="item_control' + cantidaddet + '" name="item_control' + cantidaddet + '" /></td>';
  html += '<td><input type="checkbox" id="item_contaminante' + cantidaddet + '" name="item_contaminante' + cantidaddet + '" /></td>';
  html += '<td><input type="text" id="item_kilos' + cantidaddet + '" name="item_kilos' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><input type="text" id="item_descarte' + cantidaddet + '" name="item_descarte' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
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
    
            