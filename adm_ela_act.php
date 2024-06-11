<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela_act.php
 */

function cargacombo() {
    require_once 'clases/conexion.php';
    require_once 'clases/adm_prd.php';
    $conx=new conexion();
    //$ssql="select adm_cli_pre.* from adm_cli_pre, adm_prd where adm_prd.id=adm_cli_pre.idart and adm_cli_pre.importe>0 and adm_cli_pre.idcli=$idcli order by adm_prd.codigoproducto";
    $ssql="select * from adm_art where elaborado=1 order by descripcion";    
    echo $ssql;
    $adm=new adm_prd_2($ssql);
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
if($tarea=="A") {
    $carteltarea="Agrega ELABORACIÓN";
    $botoncap="Agregar!";
    $fecha=date("Y-m-d");
    $horaing=date("H:i");
    $horaegr=date("H:i");
    $horaing1=date("H:i");
    $horaegr1=date("H:i");
    $observacion1='';
    $observacion2='';
    $telaborado1="";
    $telaborado2="";
    $telaborado3="";    
    $empleados='';
    $turno=1;
} else {
    $carteltarea="Modifica ELABORACIÓN";
    require_once 'clases/adm_ela.php';
    $botoncap="Modificar!";
    $adm=new adm_ela_1($id);
    $id=$adm->getId();
    $fecha=$adm->getFecha();
    $turno=$adm->getTurno();
    $horaing=$adm->getHoraing();
    $horaegr=$adm->getHoraegr();
    $horaing1=$adm->getHoraing1();
    $horaegr1=$adm->getHoraegr1();
    $empleados=$adm->getEmpleados();
    $observacion1=$adm->getObservacion1();
    $observacion2=$adm->getObservacion2();
    $telaborado1=$adm->getTelaborado1();
    $telaborado2=$adm->getTelaborado2();
    $telaborado3=$adm->getTelaborado3();    
}
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
<form name="form1" id="form1" action="adm_ela_act_save.php" method="post">
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
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_ela_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Hora Ingreso / Agreso&nbsp;</td>
                                        <td>
                                            <input name="horaing" type="time" class="letra6" id="horaing" value="<?= $horaing?>" /> / 
                                            <input name="horaegr" type="time" class="letra6" id="horaegr" value="<?= $horaegr?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Hora Ingreso / Egreso&nbsp;</td>
                                        <td>
                                            <input name="horaing1" type="time" class="letra6" id="horaing1" value="<?= $horaing1?>" /> / 
                                            <input name="horaegr1" type="time" class="letra6" id="horaegr1" value="<?= $horaegr1?>" />
                                        </td>
                                    </tr>


                                    <tr>
                                        <td align="right">Cantidad Empleados&nbsp;</td>
                                        <td><input name="empleados" type="text"class="letra6" id="empleados" size="10" maxlength="10" value="<?= $empleados?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Temp 1 Elaboración&nbsp;</td>
                                        <td><input name="telaborado1" type="text"class="letra6" id="telaborado1" size="3" maxlength="3" value="<?= $telaborado1?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;Temp 2 Elaboración&nbsp;<input name="telaborado2" type="text"class="letra6" id="telaborado2" size="3" maxlength="3" value="<?= $telaborado2?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;Temp 3 Elaboración&nbsp;<input name="telaborado3" type="text"class="letra6" id="telaborado3" size="3" maxlength="3" value="<?= $telaborado3?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Observacion 1&nbsp;</td>
                                        <td><input name="observacion1" type="text"class="letra6" id="observacion1" size="50" maxlength="50" value="<?= $observacion1?>"/></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Observacion 2&nbsp;</td>
                                        <td><input name="observacion2" type="text"class="letra6" id="observacion2" size="50" maxlength="50" value="<?= $observacion2?>"/></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Sector&nbsp;</td>
                                        <td><input name="turno" type="text"class="letra6" id="turno" size="1" maxlength="1" value="<?= $turno?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panelmax letra6">
                                                <div id="effect-panelmax910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Fecha</td>
                                                            <td>Artículo</td>
                                                            <td width="20%">Proveedor</td>
                                                            <td>Kg descarte</td>
                                                            <td>Kg Total</td>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="date" id="item_fecha0" name="item_fecha0" class="letra6" value="<?= date("Y-m-d")?>" /></td>
                                                            <td><select name="item_producto0" id="item_producto0"><option value="">[Seleccionar]</option><?php echo cargacombo() ?></select></td>
                                                            <td>
                                                                <select name="item_proveedor0_0" id="item_proveedor0_0"><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>
                                                                <select name="item_proveedor0_1" id="item_proveedor0_1"><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>
                                                                <select name="item_proveedor0_2" id="item_proveedor0_2"><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>
                                                            </td>
                                                            <td><input type="text" id="item_kgdescarte0" name="item_kgdescarte0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td><input type="text" id="item_kgfinal0" name="item_kgfinal0" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
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
  html += '<td><input type="date" id="item_fecha' + cantidaddet + '" name="item_fecha' + cantidaddet + '" value="<?= date("Y-m-d")?>" class="letra6" /></td>';
  html += '<td><select name="item_producto' + cantidaddet + '" id="item_producto' + cantidaddet + '" ><option value="">[Seleccionar]</option><?php echo cargacombo() ?></select></td>';
  html += '<td>';
  html += '<select name="item_proveedor' + cantidaddet + '_0" id="item_proveedor' + cantidaddet + '_0" ><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>';
  html += '<select name="item_proveedor' + cantidaddet + '_1" id="item_proveedor' + cantidaddet + '_1" ><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>';
  html += '<select name="item_proveedor' + cantidaddet + '_2" id="item_proveedor' + cantidaddet + '_2" ><option value="">[Seleccionar]</option><?php echo cargacombo2() ?></select>';
  html += '</td>';
  html += '<td><input type="text" id="item_kgdescarte' + cantidaddet + '" name="item_kgdescarte' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><input type="text" id="item_kgfinal' + cantidaddet + '" name="item_kgfinal' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
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
