<?php
/*
 * Creado el 21/01/2019 13:01:02
 * Autor: gus
 * Archivo: adm_rem_add.php
 * planbsistemas.com.ar
 */

function cargacombo($idprv) {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_prv_pre.php';
    $conx=new conexion();
    $ssql="select adm_prv_pre.* from adm_prv_pre, adm_art where adm_art.id=adm_prv_pre.idart and adm_prv_pre.seleccionado=1 and adm_prv_pre.idprv=$idprv order by adm_art.codigodinardi";
//    echo $ssql;
    $adm=new adm_prv_pre_2($ssql);
    $p_id=$adm->getIdart();
    $p_des=$adm->getDescripcion();
    $p_rub=$adm->getRubro();
    $p_cod=$adm->getCodigo();
    $cad="";
    for($i=0;$i<count($p_id);$i++) {
        echo '<option value="'.$p_id[$i].'">'.$p_cod[$i]." - ".$p_des[$i].' ('.$p_rub[$i].')</option>';
    }
    return $cad;
}

function cargauni() {
    require_once 'clases/conexion.php';
    $conx=new conexion();
    $ssql="select valor as id, descripcion as campo from tablas where codtab='UNI' order by valor";
    $rs=$conx->getConsulta($ssql);
    $cad="";
    while($reg=mysqli_fetch_object($rs)) {
        echo '<option value="'.$reg->id.'">'.$reg->campo.'</option>';
    }
    return $cad;
}

function cargaiva() {
    require_once 'clases/conexion.php';
    $conx=new conexion();
    $cad="";
    echo '<option value="10.5" selected>10.5</option>';
    echo '<option value="21">21</option>';
    echo '<option value="27">27</option>';
    echo '<option value="0">0</option>';
    return $cad;
}


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Agrega Nuevo Remito";
$botoncap="Agregar";
$fecha=$glo->getGETPOST("fecha");
if($fecha=="") $fecha=date("Y-m-d");
$item_unidad0=1;
$idprv=$glo->getGETPOST("idprv");;
if($idprv=="") $idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$clave=$sup->generateKey();
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
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.9"></script>
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
<form name="form1" id="form1" action="adm_rem_add_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
        <input name="clave" type="hidden" id="clave" value="<?= $clave?>" />
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
                                        <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número&nbsp;</td>
                                        <td>
                                            <input name="ptovta" id="ptovta" type="text" size="4" maxlength="4" onkeypress="return validar(event)" style="text-align: center" />
                                            <input name="numero" id="numero" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" />
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td>
                                            <select name="idprv" id="idprv"onchange="javascript: document.form1.target='_self'; document.form1.action='adm_rem_add.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel")
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Patente&nbsp;</td>
                                        <td><input name="patente" id="patente" type="text" size="10" maxlength="10" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Certificado&nbsp;</td>
                                        <td>
                                            <input name="certificado1" id="certificado1" type="text" size="4" maxlength="4" onkeypress="return validar(event)" style="text-align: center"/>
                                            <input name="certificado2" id="certificado2" type="text" size="1" maxlength="1" style="text-align: center"/>
                                            <input name="certificado3" id="certificado3" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center"/>
                                        </td>
                                    </tr>                                    
                  
                                    <tr>
                                        <td align="right">Total&nbsp;</td>
                                        <td><input name="totaltotal" type="text" class="letra6" id="totaltotal" size="10" readonly="readonly"  style="text-align: center" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td width="65%"><textarea name="observaciones" id="observaciones" class="letra6" rows="5" cols="60"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panelmax910 letra6">
                                                <div id="effect-panelmax910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Producto</td>
                                                            <td>Detalle</td>
                                                            <td>Cantidad</td>
                                                            <td>Unidad</td>
                                                            <td>IVA</td>
                                                            <td>Precio</td>
                                                            <td>Total</td>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><select name="item_producto0" id="item_producto0" onchange="javascript: articulos_remito(this.value, 0)"><option value="">[Seleccionar]</option><?php echo cargacombo($idprv) ?></select></td>
                                                            <td><input type="text" id="item_descripcion0" name="item_descripcion0" size="20" maxlength="50" /></td>
                                                            <td><input type="text" id="item_cantidad0" name="item_cantidad0" size="10" maxlength="15" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_remito(0)" /></td>
                                                            <td>
                                                                <select name="item_unidad0" id="item_unidad0">
                                                                <?
                                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='UNI' order by valor";
                                                                $sup->cargaCombo3($ssql, $item_unidad);
                                                                ?>
                                                                </select>
                                                            </td>    
                                                            <td>
                                                                <select name="item_iva0" id="item_iva0">
                                                                    <?
                                                                    $array=array(10.5, 21, 27, 0);
                                                                    $sup->cargaComboArrayValor($array, $array, 10.5);
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" id="item_precio0" name="item_precio0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_remito(0)" /></td>
                                                            <td><input type="text" id="item_total0" name="item_total0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" readonly="readonly" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        
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
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_rem_add_save.php'; document.form1.submit()" />
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
  html += '<td ><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" onchange="javascript: articulos_remito(this.value, ' + cantidaddet + ')"><option value="">[Seleccionar]</option><?php echo cargacombo($idprv) ?></select></td>';
  html += '<td><input type="text" id="item_descripcion' + cantidaddet + '" name="item_descripcion' + cantidaddet + '" size="20" maxlength="50" /></td>';
  html += '<td><input type="text" id="item_cantidad' + cantidaddet + '" name="item_cantidad' + cantidaddet + '" size="10" maxlength="15" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_remito(' + cantidaddet + ')" /></td>';
  html += '<td><select name="item_unidad' + cantidaddet + '" id="item_unidad' + cantidaddet + '"><?php echo cargauni()?></select></td>';
  html += '<td><select name="item_iva' + cantidaddet + '" id="item_iva' + cantidaddet + '"><?php echo cargaiva()?></select></td>';
  html += '<td><input type="text" id="item_precio' + cantidaddet + '" name="item_precio' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: recalcula_det_remito(' + cantidaddet + ')" /></td>';
  html += '<td><input type="text" id="item_total' + cantidaddet + '" name="item_total' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" readonly="readonly" /></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_remito();
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
