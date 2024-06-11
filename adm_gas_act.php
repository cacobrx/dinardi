<?
/*
 * Creado el 07/07/2020 13:24:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas_act.php
 */

function cargadescriptor() {
    require_once 'clases/conexion.php';
    $conx=new conexion();
    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
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
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($tarea=="A") {
    $carteltarea="Agrega GASTOS";
    $botoncap="Agregar!";
    $fecha=date("Y-m-d");
    $idprv=0;
    $detalle='';
    $importe=0;
    $fechaven=date("Y-m-d");
    $fechapago="";
    $numero=0;
} else {
    $carteltarea="Modifica GASTOS";
    require_once 'clases/adm_gas.php';
    $botoncap="Modificar!";
    $adm=new adm_gas_1($id);
    $id=$adm->getId();
    $fecha=$adm->getFecha();
    $idprv=$adm->getIdprv();
    $importe=$adm->getImporte();
    $fechaven=$adm->getFechaven();
    $fechapago=$adm->getFechapago();
    $numero=$adm->getNumero();
    $d_des1=$adm->getDet_descriptor1();
    $d_des2=$adm->getDet_descriptor2();
    $d_des3=$adm->getDet_descriptor3();
    $d_des4=$adm->getDet_descriptor4();
    $d_det=$adm->getDet_detalle();
    $d_imp=$adm->getDet_importe();
    $d_id=$adm->getDet_id();
    $ssql="select * from adm_com_det where idgas=$id";
    //echo $ssql;
    $cantidaddet=count($d_id);    
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
<script type="text/javascript" src="planb.js?1.1.3"></script>
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
<form name="form1" id="form1" action="adm_gas_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="tipocaja" id="tipocaja" type="hidden" value="0" />
        <? if($tarea=="A") {?>
            <input name="cantidaddet" id="cantidaddet" type="hidden" value="0" />  
        <? } else { ?>
            <input name="cantidaddet" id="cantidaddet" type="hidden" value="<?= count($d_id)-1?>" />
        <? } ?>    
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_gas_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="10%" align="right" >Fecha&nbsp;</td>
                                        <td width="90%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" required /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Proveedor&nbsp;</td>
                                        <td>
                                            <select name="idprv" id="idprv" required>
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=2 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel")
                                                ?>
                                            </select>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" value="<?= $importe?>" style="text-align: center" /></td>
                                    </tr>                                                                        
                                    <tr>
                                        <td align="right">Fecha Vencimiento&nbsp;</td>
                                        <td><input name="fechaven" type="date" class="letra6" id="fechaven" value="<?= $fechaven?>" required /></td>
                                    </tr>                 
                                    <tr>
                                        <td align="right">Fecha Pago&nbsp;</td>
                                        <td><input name="fechapago" type="date" class="letra6" id="fechapago" value="<?= $fechapago?>" /></td>
                                    </tr>     
                                    <tr>
                                        <td align="right">Número&nbsp;</td>
                                        <td><input name="numero" type="text" class="letra6" id="numero" size="10" maxlength="10" value="<?= $numero?>" style="text-align: center" /></td>
                                    </tr>                                      
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <?if($tarea=="A") {?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="panelmax960 letra6">
                                                    <div id="effect-panelmax960" class="ui-widget-content ui-corner-all">
                                                        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                            <tr class="letra6bold">
                                                                <td>Detalle</td>
                                                                <td>Descriptores</td>
                                                                <td width="10%">Importe</td>
                                                                <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" id="item_detalle0" name="item_detalle0" size="50" maxlength="100" /></td>
                                                                <td>
                                                                    <select name="item_descriptor10" id="item_descriptor10" onchange="cargades2v(this.value, 'item_descriptor', 0)">
                                                                    <?
                                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                                    //echo $ssql;
                                                                    $sup->cargaCombo3($ssql, 0, "Ninguno");
                                                                    ?>
                                                                    </select> 
                                                                    <select name="item_descriptor20" id="item_descriptor20" onchange="cargades3v(this.value, 'item_descriptor', 0)">
                                                                    </select><br>
                                                                    <select name="item_descriptor30" id="item_descriptor30" onchange="cargades4v(this.value, 'item_descriptor', 0)">
                                                                    </select>
                                                                    <select name="item_descriptor40" id="item_descriptor40">
                                                                    </select>
                                                                </td>
                                                                <td><input name="item_importe0" id="item_importe0" type="text" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                                    
                                    <? } else { ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="panelmax960 letra6">
                                                    <div id="effect-panelmax960" class="ui-widget-content ui-corner-all">
                                                        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                            <tr class="letra6bold">
                                                                <td>Detalle</td>
                                                                <td>Descriptores</td>
                                                                <td width="10%">Importe</td>
                                                                <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                            </tr>
                                                                <? for($i=0;$i<$cantidaddet;$i++) { ?>                                                        
                                                            <tr>
                                                                <td><input type="text" id="item_detalle<?= $i?>" name="item_detalle<?= $i?>" size="50" maxlength="100" value="<?= $d_det[$i] ?>" /></td>
                                                                <td>
                                                                    <select name="item_descriptor1<?= $i?>" id="item_descriptor1<?= $i?>" onchange="cargades2v(this.value, 'item_descriptor', <?= $i?>)">
                                                                        <?
                                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                                        //echo $ssql;
                                                                        $sup->cargaCombo3($ssql, $d_des1[$i], "Ninguno");
                                                                        ?>
                                                                    </select> 
                                                                    <select name="item_descriptor2<?= $i?>" id="item_descriptor2<?= $i?>" onchange="cargades3v(this.value, 'item_descriptor',<?= $i?>)">
                                                                        <?
                                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=".$d_des1[$i]." order by texto";
                                                                        //echo $ssql;
                                                                        $sup->cargaCombo3($ssql, $d_des2[$i], "Ninguno");
                                                                        ?>                                                                
                                                                    </select><br>
                                                                    <select name="item_descriptor3<?= $i?>" id="item_descriptor3<?= $i?>" onchange="cargades4v(this.value, 'item_descriptor',<?= $i?>)">
                                                                        <?
                                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=".$d_des2[$i]." order by texto";
                                                                        //echo $ssql;
                                                                        $sup->cargaCombo3($ssql, $d_des3[$i], "Ninguno");
                                                                        ?>                                                                  
                                                                    </select> 
                                                                    <select name="item_descriptor4<?= $i?>" id="item_descriptor4<?= $i?>">
                                                                        <?
                                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=".$d_des3[$i]." order by texto";
                                                                        //echo $ssql;
                                                                        $sup->cargaCombo3($ssql, $d_des4[$i], "Ninguno");
                                                                        ?>                                                                  
                                                                    </select>
                                                                </td>
                                                                <td align="center"><input type="text" id="item_importe<?= $i?>" name="item_importe<?= $i?>" size="10" maxlength="10" value="<?= $d_imp[$i] ?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                                <td align="center"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"><hr></hr></td>
                                                            </tr>
                                                                <? } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                                    
                                    <? } ?>                                                         
<!--                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>                                    -->
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
  html += '<td><input type="text" id="item_detalle' + cantidaddet + '" name="item_detalle' + cantidaddet + '" size="50" maxlength="100" /></td>';
  html += '<td><select name="item_descriptor1' + cantidaddet + '" id="item_descriptor1' + cantidaddet + '" onchange="cargades2v(this.value, \'item_descriptor\', ' + cantidaddet + ')"><?php cargadescriptor(0) ?></select> ';
  html += '<select name="item_descriptor2' + cantidaddet + '" id="item_descriptor2' + cantidaddet + '" onchange="cargades3v(this.value, \'item_descriptor\', ' + cantidaddet +')"></select><br>';
  html += '<select name="item_descriptor3' + cantidaddet + '" id="item_descriptor3' + cantidaddet + '" onchange="cargades4v(this.value, \'item_descriptor\', ' + cantidaddet +')"></select> ';
  html += '<select name="item_descriptor4' + cantidaddet + '" id="item_descriptor4' + cantidaddet + '"></select></td>';
  html += '<td align="center"><input name="item_importe' + cantidaddet + '" id="item_importe' + cantidaddet + '" type="text" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td align="center"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_remito();
 });
  
});
</script>
