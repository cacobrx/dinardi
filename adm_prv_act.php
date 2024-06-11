<?
/*
 * Creado el 18/01/2019 17:16:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prv_act.php
 */

function cargacombo($cc) {
    require_once 'clases/conexion.php';
    $conx=new conexion();
    //$ssql="select id as id,  from edd_centro where activo=1 order by nombre";
    $ssql="select valor as id, descripcion as campo from tablas where activo=1 and codtab='PAI' order by descripcion";    
    $rs=$conx->getConsulta($ssql);
    $p_id=array();
    $p_des=array();
    while($reg=mysqli_fetch_object($rs)) {
        array_push($p_id,$reg->id);
        array_push($p_des,$reg->campo);
    }

    $cad="";
    for($i=0;$i<count($p_id);$i++) {
        if($cc==$p_id[$i])
            echo '<option value="'.$p_id[$i].'" selected>'.$p_des[$i]." (".$p_id[$i].')</option>';
        else
            echo '<option value="'.$p_id[$i].'">'.$p_des[$i]." (".$p_id[$i].')</option>';
    }
    return $cad;
}


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup=new datesupport();
$conx=new conexion();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $carteltarea="Agrega Proveedores";
    $botoncap="Agregar!";
    $apellido='';
    $nombre='';
    $ciudad='';
    $direccion='';
    $telefono='';
    $condiva=1;
    $cuit='';
    $email='';
    $observaciones='';
    $cuenta=0;
    $retencioniibb="";
    $tipo=$tipoprv;
    $codigodinardi=0;
    $expganancia=0;
    $establecimiento1="";
    $establecimiento2="";
    $establecimiento3="";
    $facturam=0;
    $pais_id=array();
    $pais_nom=array();
    $ssql="select * from adm_prv where tipo=$tipoprv order by codigodinardi desc";
//    echo $ssql;
    if($conx->getCantidadReg($ssql)>0) {
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $codigodinardi=$reg->codigodinardi;
    }
    $codigodinardi++;
} else {
    $carteltarea="Modifica Proveedores";
    require_once 'clases/adm_prv.php';
    $botoncap="Modificar!";
    $adm=new adm_prv_1($id);
    $id=$adm->getId();
    $apellido=$adm->getApellido();
    $nombre=$adm->getNombre();
    $ciudad=$adm->getCiudad();
    $direccion=$adm->getDireccion();
    $telefono=$adm->getTelefono();
    $condiva=$adm->getCondiva();
    $cuit=$adm->getCuit();
    $cuenta=$adm->getCuenta();
    $retencioniibb=$adm->getRetencioniibb();
    $email=$adm->getEmail();
    $observaciones=$adm->getObservaciones();
    $tipo=$adm->getTipo();
    $expganancia=$adm->getExpganancia();
    $codigodinardi=$adm->getCodigodinardi();
    $facturam=$adm->getFacturam();
    $establecimiento1=$adm->getEstablecimiento1();
    $establecimiento2=$adm->getEstablecimiento2();
    $establecimiento3=$adm->getEstablecimiento3();
    $pais_id=$adm->getPais_id();
    $pais_nom=$adm->getPais_nom();
//    print_r($pais_id);
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
<script type="text/javascript" src="planbjs/proveedordup.js?2"></script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_prv_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="cantidaddet" id="cantidaddet" type="hidden" value="<?= count($pais_id)?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_prv_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Código&nbsp;</td>
                                        <td><input name="codigodinardi" type="text" class="letra6" id="codigodinardi" size="5" maxlength="5" value="<?= $codigodinardi?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Razon Social&nbsp;</td>
                                        <td width="65%"><input name="apellido" type="text" class="letra6" id="apellido" size="50" maxlength="50" value="<?= $apellido?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Nombre Fantasia&nbsp;</td>
                                        <td width="65%"><input name="nombre" type="text" class="letra6" id="nombre" size="50" maxlength="50" value="<?= $nombre?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Ciudad&nbsp;</td>
                                        <td width="65%"><input name="ciudad" type="text" class="letra6" id="ciudad" size="50" maxlength="50" value="<?= $ciudad?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Direccion&nbsp;</td>
                                        <td width="65%"><input name="direccion" type="text" class="letra6" id="direccion" size="50" maxlength="50" value="<?= $direccion?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Telefono&nbsp;</td>
                                        <td width="65%"><input name="telefono" type="text" class="letra6" id="telefono" size="30" maxlength="30" value="<?= $telefono?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Establecimiento 1&nbsp;</td>
                                        <td><input name="establecimiento1" type="text"class="letra6" id="establecimiento1" size="5" maxlength="5" value="<?= $establecimiento1?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;
                                            Establecimiento 2&nbsp;<input name="establecimiento2" type="text"class="letra6" id="establecimiento2" size="5" maxlength="5" value="<?= $establecimiento2?>" onkeypress="return validar_punto(event)" style="text-align: center" />&nbsp;
                                            Establecimiento 3&nbsp;<input name="establecimiento3" type="text"class="letra6" id="establecimiento3" size="5" maxlength="5" value="<?= $establecimiento3?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Condicion Iva&nbsp;</td>
                                        <td>
                                            <select name="condiva" id="condiva">
                                                <? 
                                                $array=array("Consumidor Final", "Exento", "Resposable Inscripto", "Monotributo");
                                                $avalor=array(1,2,3,4);
                                                $sup->cargaComboArrayValor($array, $avalor, $condiva)
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Cuit&nbsp;</td>
                                        <td width="65%">
                                            <input name="cuit" type="text" class="letra6" id="cuit" size="11" maxlength="11" value="<?= $cuit?>" onkeypress="return validar(event)" style="text-align: center" onblur="javascript: proveedordup(this.value)" />
                                            <input name="cuitanterior" type="hidden" id="cuitanterior" value="<?= $cuit?>" />
                                            <p style="color: yellow; background-color: red; display: none; font-weight: bold; text-align: center" id="errorrep">*** ERROR: EL CUIT YA EXISTE ***</p>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="35%" align="right">Cuenta&nbsp;</td>
                                                <td width="65%">
                                                    <select name="cuenta" id="cuenta">
                                                        <? 
                                                        $ssql="select id as id,  nombre as campo from adm_cta order by id";
                                                        $sup->cargaCombo3($ssql, $cuenta, "Selccionar");
                                                        ?>
                                                    </select>
                                                </td>
                                    </tr> 
                                    
                                    <tr>
                                        <td width="35%" align="right">% Retencion IIBB&nbsp;</td>
                                        <td width="65%"><input name="retencioniibb" type="text" class="letra6" id="retencioniibb" size="6" maxlength="6" value="<?= $retencioniibb?>" onkeypress="return validar_punto(event)" style="text-align: center"  /></td>
                                    </tr> 
                  
                                    <tr>
                                        <td width="35%" align="right">Email&nbsp;</td>
                                        <td width="65%"><input name="email" type="text" class="letra6" id="email" size="50" maxlength="50" value="<?= $email?>" /></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Excepción ganancia&nbsp;</td>
                                        <td width="65%"><input name="expganancia" id="expganancia" type="checkbox" value="1" <? if($expganancia==1) echo "checked='checked'";?>  /></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Factura M&nbsp;</td>
                                        <td width="65%"><input name="facturam" id="facturam" type="checkbox" value="1" <? if($facturam==1) echo "checked='checked'";?>  /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <? if($tarea=="A") {  ?>
                                        <td class="letra6bold">
                                            <? if($tipo==1) echo "Proveedores"; else echo "Proveedores Varios";?>
                                        </td>
                                        <? } else { ?>
                                        <td>
                                            <select name="tipo" id="tipo">
                                                <?
                                                $array=array("Proveedores", "Proveedores Varios");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                ?>
                                            </select>
                                        </td>
                                        <? } ?>
                                    </tr>
                                    <tr>
                                        <td align="right">Observaciones</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <textarea name="observaciones" cols="50" rows="5" class="letra6" id="observaciones"><?= $observaciones?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                <tr class="letra6bold">
                                                    <td>Países</td>

                                                    <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                </tr>
                                                <? if($tarea=="A") { ?>
                                                <tr>
                                                    <td><select name="item_pais0" id="item_pais0" ><option value="">[Seleccionar]</option><?php echo cargacombo(0) ?></select></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <? } else { 
                                                for($c=0;$c<count($pais_id);$c++) { ?>
                                                <tr>
                                                    <td>
                                                        <select name="item_pais<?= $c?>" id="item_pais<?= $c?>" ><option value="">[Seleccionar]</option><?php echo cargacombo($pais_id[$c]) ?></select>
                                                    </td>
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                </tr>
                                                <? } } ?>
                                            </table>

                                        </td>
                                    </tr>       
                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div id="agregar">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
                                            </div>
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
  html += '<td><select name="item_pais' + cantidaddet + '" id="item_pais' + cantidaddet + '" ><option value="">[Seleccionar]</option><?php echo cargacombo(0) ?></select></td>';
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