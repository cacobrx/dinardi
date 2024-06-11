<?php
/*
 * Creado el 13/03/2019 15:44:29
 * Autor: gus
 * Archivo: adm_cped_act.php
 * planbsistemas.com.ar
 */

function cargacombo($idcli, $idart=0) {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_cli_pre.php';
    $conx=new conexion();
    //$ssql="select adm_cli_pre.* from adm_cli_pre, adm_prd where adm_prd.id=adm_cli_pre.idart and adm_cli_pre.importe>0 and adm_cli_pre.idcli=$idcli order by adm_prd.codigoproducto";
    $ssql="select adm_cli_pre.* from adm_cli_pre, adm_prd where adm_prd.id=adm_cli_pre.idart and adm_cli_pre.seleccionado=1 and adm_cli_pre.idcli=$idcli order by adm_prd.codigoproducto";
    $adm=new adm_cli_pre_2($ssql);
    $p_id=$adm->getIdart();
    $p_des=$adm->getDescripcion();
    $p_rub=$adm->getRubro();
    $p_cod=$adm->getCodigo();
    $cad="";
    for($i=0;$i<count($p_id);$i++) {
        if($idart==$p_id[$i])
            echo '<option selected value="'.$p_id[$i].'">'.$p_cod[$i]." - ".$p_des[$i].' ('.$p_rub[$i].')</option>';
        else
            echo '<option value="'.$p_id[$i].'">'.$p_cod[$i]." - ".$p_des[$i].' ('.$p_rub[$i].')</option>';
    }
    return $cad;
}

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cped.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Modifica Pedido #$id";
$botoncap="Modificar";
$fecha=date("Y-m-d");
$idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_cped_1($id);
$fecha=$adm->getFecha();
$idcli=$adm->getIdcli();
$fechaentrega=$adm->getFechaentrega();
$totaltotal=$adm->getTotal();
$observaciones=$adm->getObservaciones();
$d_idart=$adm->getDet_idpro();
$d_cantidad=$adm->getDet_cantidad();
$d_precio=$adm->getDet_precio();
$d_total=$adm->getDet_importe();
$d_recipiente=$adm->getDet_recipiente();
$patente=$adm->getPatente();
//print_r($d_cantidad);
$cantidaddet=count($d_cantidad);
$ssql="select * from adm_prd order by codigoproducto";
$adm=new adm_prd_2($ssql);
$p_id=$adm->getCodigoproducto();
$p_des=$adm->getDescripcion();
$p_rub=$adm->getRubrodes();
$cad="";
$p_nom=array();
for($i=0;$i<count($p_id);$i++) {
    array_push($p_nom,$p_id[$i]." - ".$p_des[$i].' ('.$p_rub[$i].')');
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
        width:<?= $_SESSION['anchopantalla']?>px;
        height:75px;
        z-index:1;
        margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        padding-right: 100px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.4"></script>
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
<form name="form1" id="form1" action="adm_cped_act_save.php" method="post">
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_cped_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Entrega&nbsp;</td>
                                        <td><input name="fechaentrega" type="date" class="letra6" id="fechaentrega" value="<?= $fechaentrega?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Cliente&nbsp;</td>
                                        <td>
                                            <select name="idcli" id="idcli">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_cli order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idcli, "Sel")
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Patente&nbsp;</td>
                                        <td><input name="patente" type="text" class="letra6" id="patente" size="7"  value="<?= $patente?>" /></td>
                                    </tr>                  
                                    <tr>
                                        <td align="right">Total&nbsp;</td>
                                        <td><input name="totaltotal" type="text" class="letra6" id="totaltotal" size="10" readonly="readonly"  style="text-align: center" value="<?= $totaltotal?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td width="65%"><textarea name="observaciones" id="observaciones" class="letra6" rows="5" cols="60"><?= $observaciones?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panelmax910 letra6">
                                                <div id="effect-panelmax910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Producto</td>
                                                            <td>Kilos</td>
                                                             <td>Cantidad</td>
                                                            <td>Precio</td>
                                                            <td>Total</td>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>

                                                        <? for($i=0;$i<count($d_cantidad);$i++) { ?>
                                                        <tr>
                                                            <td>
                                                                <select name="item_producto<?= $i?>" id="item_producto<?= $i?>" onchange="javascript: articulos_pedido(this.value, <?= $i?>)">
                                                                    <?
                                                                     cargacombo($idcli, $d_idart[$i]);
                                                                    ?>
                                                                </select>
                                                            </td>       
                                                            <td><input type="text" id="item_cantidad<?= $i?>" name="item_cantidad<?= $i?>" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(<?= $i?>)" value="<?= $d_cantidad[$i]?>" /></td>
                                                            <td><input type="text" id="item_recipiente<?= $i?>" name="item_recipiente<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(<?= $i?>)" value="<?= $d_recipiente[$i]?>" /></td>
                                                            <td><input type="text" id="item_precio<?= $i?>" name="item_precio<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(<?= $i?>)" value="<?= $d_precio[$i]?>" /></td>
                                                            <td><input type="text" id="item_total<?= $i?>" name="item_total<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" readonly="readonly" value="<?= $d_total[$i]?>" /></td>
                                                            <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_cped_act_save.php'; document.form1.submit()" />
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
  html += '<td><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" onchange="javascript: articulos_pedido(this.value, ' + cantidaddet + ')"><option value="">[Seleccionar]</option><?php echo cargacombo($idcli) ?></select></td>';
  html += '<td><input type="text" id="item_cantidad' + cantidaddet + '" name="item_cantidad' + cantidaddet + '" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(' + cantidaddet + ')" /></td>';
  html += '<td><input type="text" id="item_recipiente' + cantidaddet + '" name="item_recipiente' + cantidaddet + '" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(' + cantidaddet + ')" /></td>';
  html += '<td><input type="text" id="item_precio' + cantidaddet + '" name="item_precio' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_pedido(' + cantidaddet + ')" /></td>';
  html += '<td><input type="text" id="item_total' + cantidaddet + '" name="item_total' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" readonly="readonly" /></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_pedido();
 });
 
 $('#form1').on('submit', function(event){
  event.preventDefault();
  var error = '';
  $('.item_producto').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Seleccione PRODUCTO en la línea "+count+"</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.item_cantidad').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Ingrese CANTIDAD en la línea "+count+"</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.item_recipiente').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Ingrese RECIPIENTE en la línea "+count+"</p>";
    return false;
   }
   count = count + 1;
  });  
  
  $('.item_precio').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Ingrese PRECIO en la línea "+count+"</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
 });
 
});
</script>
