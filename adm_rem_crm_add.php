<?php
/*
 * Creado el 09/06/2019 12:11:26
 * Autor: gus
 * Archivo: adm_rem_crm_add.php
 * planbsistemas.com.ar
 */


function cargacombo($idprv, $idart=0) {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_prv_pre.php';
    $conx=new conexion();
    //$ssql="select adm_prv_pre.* from adm_prv_pre, adm_art where adm_art.id=adm_prv_pre.idart and adm_prv_pre.importe>0 and adm_prv_pre.idprv=$idprv order by adm_art.codigodinardi";
    $ssql="select adm_prv_pre.* from adm_prv_pre, adm_art where adm_art.id=adm_prv_pre.idart and adm_prv_pre.seleccionado=1 and adm_prv_pre.idprv=$idprv order by adm_art.codigodinardi";    
    $adm=new adm_prv_pre_2($ssql);
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
$carteltarea="Agrega Nuevo Control de Remito #$idrem";
$botoncap="Agregar";
$fecha=date("Y-m-d");
$item_unidad0=1;
$item_peso0="";
$item_temperatura0="";
$item_observaciones0="";
if($idrem>0) {
    $rem=new adm_rem_1($idrem);
    $idprv=$rem->getIdprv();
    $fecha=$rem->getFecha();
} else 
    $idprv=0;   
$cantidaddet=$glo->getGETPOST("cantidaddet");
$rem=new adm_rem_1($idrem);
$r_id=$rem->getId();
$r_fec=$rem->getFecha();
$r_prv=$rem->getProveedor();
$r_idart=$rem->getDet_idart();
$d_articulo=$rem->getDet_articulo();
$d_cantidad=$rem->getDet_cantidad();
$d_unidad=$rem->getDet_unidaddes();
$d_uni=$rem->getDet_unidad();
$d_id=$rem->getDet_id();

$c_idart=$rem->getCrm_idart();
$c_cantidad=$rem->getCrm_cantidad();
$c_peso=$rem->getCrm_peso();
$c_unidad=$rem->getCrm_unidad();
$c_temperatura=$rem->getCrm_temperatura();
$c_obs=$rem->getCrm_observaciones();
$c_idela=$rem->getCrm_idela();
$c_idenv=$rem->getCrm_idenv();
if(count($c_temperatura)==0) {
    $c_temperatura=array("");
    $c_cantidad=array("");
    $c_obs=array("");
}
if($cantidaddet=="") $cantidaddet=0;
if($r_idart[0]>0)
    $faena=0;
else
    $faena=1;
$cantidaddet=count($c_cantidad);
if($faena==1) $carteltarea.=" (FAENA)";
if($faena==0) $cantidaddet=count($r_idart);
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
<form name="form1" id="form1" action="adm_rem_crm_add_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="idrem" type="hidden" id="id" value="<?= $idrem?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
        <input name="faena" id="faena" type="hidden" value="<?= $faena?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_rem_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número&nbsp;</td>
                                        <td class="letra6bold"><?= $sup->AddZeros($rem->getPtovta(),4)." ".$sup->AddZeros($rem->getNumero(), 8)?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td class="letra6Bold"><?= $rem->getProveedor()?></td>
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
                                                            <td width="30%">Producto</td>
                                                            <? if($faena==0) { ?>
                                                            <td width="10%" align="center">Cantidad</td>
                                                            <? } ?>
                                                            <td width="10%" align="center">Unidad</td>
                                                            <td width="10%" align="center">Control</td>
                                                            <td width="10%" align="center">Temp.</td>
                                                            <td>Observaciones</td> 
                                                            <td align="center">Elab</td>
                                                            <td align="center">Env.</td>
                                                            <? if($faena==1) { ?>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                            <? } ?>
                                                        </tr>
                                                        <? for($i=0;$i<$cantidaddet;$i++) { 
                                                            if($faena==0)
                                                                $idr=$d_id[$i];
                                                            else
                                                                $idr=0;
                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <input name="idremdet<?= $i?>" id="idremdet<?= $id?>" type="hidden" value="<?= $idr?>" />
                                                            <? if ($faena==0) 
                                                                echo $d_articulo[$i];
                                                            else { ?>
                                                                
                                                                <select name="item_producto<?= $i?>" id="item_producto<?= $i?>">
                                                                    <?
                                                                     cargacombo($idprv, $c_idart[$i]);
                                                                    ?>
                                                                </select>
                                                            <? } ?>
                                                            </td>                            
                                                            <? if($faena==0)  { ?>
                                                            <td align="center">
                                                                <?= $d_cantidad[$i];?>
                                                            </td>
                                                            <? } ?>
                                                            <td align="center">
                                                                <? if($faena==0) {
                                                                    echo $d_unidad[$i]; ?>
                                                                    <input name="item_unidad<?= $i?>" id="item_unidad<?= $i?>" value="<?= $d_uni[$i]?>" type="hidden" />
                                                                <? } else { ?>
                                                                <select name="item_unidad<?= $i?>" id="item_unidad<?= $i?>">
                                                                    <?
                                                                     cargauni();
                                                                    ?>
                                                                </select>
                                                                <? } ?>
                                                            </td>
                                                            <td align="center"><input type="text" id="item_peso<?= $i?>" name="item_peso<?= $i?>" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" value="<?= $c_cantidad[$i]?>" /></td>                        
                                                            <td align="center"><input type="text" id="item_temperatura<?= $i?>" name="item_temperatura<?= $i?>" class="form-control item_cantidad" size="6" maxlength="6" onkeypress="return validar_punto_menos(event)" style="text-align: center" value="<?= $c_temperatura[$i]?>" /></td>
                                                            <td><input type="text" id="item_observaciones<?= $i?>" name="item_observaciones<?= $i?>" class="form-control item_cantidad" size="20" maxlength="100" value="<?= $c_obs[$i]?>" /></td>
                                                            <td><input name="item_ela<?= $i?>" id="item_ela<?= $i?>" type="text" size="5" maxlength="5" onkeypress="return validar(event)" style="text-align: center" value="<?= $c_idela[$i]?>" /></td>
                                                            <td><input name="item_env<?= $i?>" id="item_env<?= $i?>" type="text" size="5" maxlength="5" onkeypress="return validar(event)" style="text-align: center" value="<?= $c_idenv[$i]?>" /></td>
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
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_rem_crm_add_save.php'; document.form1.submit()" />
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
//  alert(cantidaddet);
  html += '<tr>';
  html += '<td ><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" onchange="javascript: articulos_remito(this.value, ' + cantidaddet + ')"><option value="">[Seleccionar]</option><?php echo cargacombo($idprv) ?></select></td>';
  html += '<td align="center"><select name="item_unidad' + cantidaddet + '" id="item_unidad' + cantidaddet + '"><?php echo cargauni()?></select></td>';
  html += '<td align="center"><input type="text" id="item_peso' + cantidaddet + '" name="item_peso' + cantidaddet + '" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td align="center"><input type="text" id="item_tempertura' + cantidaddet + '" name="item_temperatura' + cantidaddet + '" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><input type="text" id="item_obervaciones' + cantidaddet + '" name="item_observaciones' + cantidaddet + '" size="30" maxlength="100" /></td>';
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

