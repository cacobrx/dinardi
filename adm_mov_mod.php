<?php
/*
 * Creado el 11/07/2019 21:31:40
 * Autor: gus
 * Archivo: adm_mov_mod.php
 * planbsistemas.com.ar
 */

function cargacombo() {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_cta.php';
    $conx=new conexion();
    $ssql="select * from adm_cta where tipo=1 order by codigo";
    $adm=new adm_cta_2($ssql);
    $p_id=$adm->getId();
    $p_des=$adm->getNombre();
    $p_cod=$adm->getCodigo();
    $cad="";
    echo '<option value="0">[Sel.]</option>';
    for($i=0;$i<count($p_id);$i++) {
        echo '<option value="'.$p_id[$i].'">'.$p_cod[$i]." - ".$p_des[$i].'</option>';
    }
    return $cad;
}


require_once "user.php";
require_once "clases/globalson.php";
require_once "clases/planb_config.php";
require_once "clases/support.php";
require_once 'clases/datesupport.php';
require_once 'clases/adm_mov.php';
$dsup=new datesupport();
$sup=new support();

$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$id=$glo->getGETPOST("id");
$botoncap="Modifica";
$adm=new adm_mov_1($id);
$detalle=$adm->getDetalle();
$asiento=$adm->getAsiento();
$fecha=$adm->getFecha();
$d_idcta=$adm->getDet_idcta();
$d_detalle=$adm->getDet_detalle();
$d_importe=$adm->getDet_importe();
$d_tipo=$adm->getDet_tipo();
$carteltarea="Modifica Asiento #".$adm->getAsiento();
$canti=count($d_idcta);
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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script src="planb.js?1.0.2" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['required', 'only_on_submit'],
}


</script>

<? require_once 'estilos.php'; ?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_mov_mod_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="canti" type="hidden" id="canti" value="<?= $canti?>" />
        <input name="primeromov" type="hidden" id="primeromov" value="1" />
        <input name="cantidaddet" id="cantidaddet" type="hidden" value="<?= $canti?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_mov_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Asiento&nbsp;</td>
                                        <td><input name="asiento" id="asiento" type="text" value="<?= $asiento?>" size="6" maxlength="10" onkeypress="return validar(punto)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td width="20%" align="right">Fecha&nbsp;</td>
                                        <td width="80%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Detalle&nbsp;</td>
                                        <td><input name="detalle" type="text" class="letra6" id="detalle" size="100" maxlength="100" value="<?= $detalle?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Detalle</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" id="item_table">
                                                        <tr class="letra6">
                                                            <td wodth="40%">Cuenta</td>
                                                            <td width="35%">Detalle</td>
                                                            <td width="10%"><div align="center">Debe</div></td>
                                                            <td width="10%"><div align="center">Haber</div></td>
                                                            <td width="5%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <? for($i=0;$i<$canti;$i++) { ?>
                                                        <tr>
                                                            <td>
                                                                <select name="det_idcta<?= $i?>" id="det_idcta<?= $i?>" class="letra6">
                                                                    <? 
                                                                    $ssql="select id as id, concat_ws(' ', codigo,'-', nombre) as campo from adm_cta where tipo=1 order by codigo";
                                                                    $sup->cargaCombo3($ssql, $d_idcta[$i], "Sel.");
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input name="det_detalle<?= $i?>" id="det_detalle<?= $i?>" type="text" class="letra6" size="30" maxlength="30" value="<?= $d_detalle[$i]?>" />
                                                            </td>
                                                            <td align="center">
                                                                <input name="det_entrada<?= $i?>" id="det_entrada<?= $i?>" type="text" class="letra6" size="10" maxlength="10" style="text-align: center" onkeypress="return validar_punto(event)" onblur="Validar_Contable(<?= $canti?>)" value="<? if($d_tipo[$i]==1) echo $d_importe[$i]?>" />
                                                            </td>
                                                            <td align="center">
                                                                <input name="det_salida<?= $i?>" id="det_salida<?= $i?>" type="text" class="letra6" size="10" maxlength="10" style="text-align: center" onkeypress="return validar_punto(event)" onblur="Validar_Contable(<?= $canti?>)" value="<? if($d_tipo[$i]==2) echo $d_importe[$i]?>" />
                                                            </td>
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
                                        <td colspan="2" align="center"><input type="submit" name="cmdok" id="cmdok" value="<?= $botoncap?>" /></td>
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
  html += '<td><select class="letra6" name="det_idcta' + cantidaddet + '" id="det_idcta' + cantidaddet + '"><? cargacombo()?></select></td>';
  html += '<td><input type="text" id="det_detalle' + cantidaddet + '" name="det_detalle' + cantidaddet + '" size="30" maxlength="30" class="letra6" /></td>';
  html += '<td><input type="text" id="det_entrada' + cantidaddet + '" name="det_entrada' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" class="letra6" /></td>';
  html += '<td><input type="text" id="det_salida' + cantidaddet + '" name="det_salida' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" class="letra6" /></td>';
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
