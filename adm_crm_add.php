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
    $ssql="select adm_prv_pre.* from adm_prv_pre, adm_art where adm_art.id=adm_prv_pre.idart and adm_prv_pre.importe>0 and adm_prv_pre.idprv=$idprv order by adm_art.codigodinardi";
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

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crm.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$idrem=$glo->getGETPOST("idrem");
$carteltarea="Agrega Nuevo Control de Remito";
$botoncap="Agregar";
$fecha=date("Y-m-d");
$item_unidad0=1;
if($idrem>0) {
    $rem=new adm_rem_1($idrem);
    $idprv=$rem->getIdprv();
} else 
    $idprv=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$ssql="select * from adm_rem where idcrm=0 order by fecha, id";
$rem=new adm_rem_2($ssql);
$r_id=$rem->getId();
$r_fec=$rem->getFecha();
$r_prv=$rem->getProveedor();
$r_des=array();
for($i=0;$i<count($r_id);$i++) {
    array_push($r_des,"#".$r_id[$i]." ".$dsup->getFechaNormalCorta($r_fec[$i])." ".$r_prv[$i]);
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
<form name="form1" id="form1" action="adm_crm_add_save.php" method="post">
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_crm_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Remito&nbsp;</td>
                                        <td>
                                            <select name="idrem" id="idrem" onchange="javascript: document.form1.target='_self'; document.form1.action='adm_crm_add.php'; document.form1.submit()">
                                                <?
                                                $sup->cargaComboArrayValor($r_des, $r_id, $idrem, "Sel");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Hora Inicio&nbsp;</td>
                                        <td><input type="time" name="horainicio" id="horainicio" class="letra6" value="<?= date("H:i")?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Hora Fin&nbsp;</td>
                                        <td><input type="time" name="horafin" id="horafin" class="letra6" value="<?= date("H:i")?>" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right">Orbservaciones&nbsp;</td>
                                        <td width="65%"><textarea name="onbservaciones" id="observaciones" class="letra6" rows="5" cols="60"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Producto</td>
                                                            <td align="center">Cantidad</td>
                                                            <!--<td align="center">Peso</td>-->
                                                            <td align="center">Temp.</td>
                                                            <td>Observaciones</td> 
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><select name="item_producto0" id="item_producto0" class="form-control item_producto" ><option value="">[Seleccionar]</option><?php echo cargacombo($idprv) ?></select></td>                            
                                                            <td align="center"><input type="text" id="item_cantidad0" name="item_cantidad0" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <!--<td align="center"><input type="text" id="item_peso0" name="item_peso0" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>-->                        
                                                            <td align="center"><input type="text" id="item_temperatura0" name="item_temperatura0" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto_menos(event)" style="text-align: center" /></td>
                                                            <td><input type="text" id="item_observaciones0" name="item_observaciones0" class="form-control item_cantidad" size="50" maxlength="100" /></td>
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
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_crm_add_save.php'; document.form1.submit()" />
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
  html += '<td><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" class="form-control item_producto" onchange="javascript: articulos_remito(this.value, ' + cantidaddet + ')"><option value="">[Seleccionar]</option><?php echo cargacombo($idprv) ?></select></td>';
  html += '<td align="center"><input type="text" id="item_cantidad' + cantidaddet + '" name="item_cantidad' + cantidaddet + '" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
//  html += '<td align="center"><input type="text" id="item_peso' + cantidaddet + '" name="item_peso' + cantidaddet + '" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td align="center"><input type="text" id="item_temperatura' + cantidaddet + '" name="item_temperatura' + cantidaddet + '" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto_menos(event)" style="text-align: center" /></td>';
  html += '<td><input type="text" id="item_observaciones' + cantidaddet + '" name="item_observaciones' + cantidaddet + '" class="form-control item_cantidad" size="50" maxlength="100" /></td>';
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
