<?php
/*
 * creado el 20/11/2017 15:52:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_act
 */

//print_r($_POST);
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
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$canti=$glo->getGETPOST("canti");
$primeromov=$glo->getGETPOST("primeromov");
if($canti=="")
    $canti=2;
if($canti<2)
    $canti=2;
if($tarea=="A") {
    $carteltarea="Agrega Movimiento";
    $botoncap="Agregar!";
    $fecha=$glo->getGETPOST("fecha");
    if($fecha=="")
      $fecha=date("Y-m-d");
    $detalle=$glo->getGETPOST("detalle");
  
} else {
    $botoncap="Modifica";
    if($primeromov!=1) {
        $adm=new adm_mov_1($id);
        $detalle=$adm->getDetalle();
        $asiento=$adm->getAsiento();
        $fecha=$adm->getFecha();
        $d_idcta=$adm->getDet_idcta();
        $d_detalle=$adm->getDet_detalle();
        $d_importe=$adm->getDet_importe();
        $d_tipo=$adm->getDet_tipo();
        $canti=count($d_idcta);
    } else {
        $detalle=$glo->getGETPOST("detalle");
        $fecha=$glo->getGETPOST("fecha");
        $asiento=$glo->getGETPOST("asiento");
    }
    $carteltarea="Modifica Movimiento #$asiento";
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

function AjustaLinea(tipo) {
    valor=document.form1.canti.value;
//    alert(valor);
    if(tipo==0)
        valor++;
    if(tipo==1)
        valor--;
    if(valor==0)
        valor=1
    document.form1.canti.value=valor;
//    alert(document.form1.canti.value);
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
<form name="form1" id="form1" action="adm_mov_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="canti" type="hidden" id="canti" value="<?= $canti?>" />
        <input name="primeromov" type="hidden" id="primeromov" value="1" />
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
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr>
                                                            <td colspan="6"><a href="javascript: AjustaLinea(0); document.form1.action='adm_mov_act.php'; document.form1.submit()"><i class="far fa-plus-square fa-lg" alt="Agregar L&iacute;nea" title="Agregar Línea"></i></a> 
                                                                <? if($canti>2) { ?>
                                                                <a href="javascript: AjustaLinea(1); document.form1.action='adm_mov_act.php'; document.form1.submit()"><i class="far fa-minus-square fa-lg" alt="Borrar L&iacute;nea" title="Borrar Línea"></i></a>
                                                                <? } ?></td>
                                                        </tr>
                                                        <tr class="letra6">
                                                            <td wodth="40%">Cuenta</td>
                                                            <td width="35%">Detalle</td>
                                                            <td width="10%"><div align="center">Debe</div></td>
                                                            <td width="10%"><div align="center">Haber</div></td>
                                                        </tr>
                                                        <? for($i=0;$i<$canti;$i++) { 
                                                            $det_idcta="det_idcta$i";
                                                            $det_detalle="det_detalle$i";
                                                            $det_entrada="det_entrada$i";
                                                            $det_salida="det_salida$i";
                                                            if($tarea=="A") {
                                                                $$det_entrada=$glo->getGETPOST($det_entrada);
                                                                $$det_detalle=$glo->getGETPOST($det_detalle);
                                                                $$det_idcta=$glo->getGETPOST($det_idcta);
                                                                $$det_salida=$glo->getGETPOST($det_salida);
                                                            } else {
                                                                if($primeromov!=1) {
                                                                    if($d_tipo[$i]==1) {
                                                                        $$det_entrada=$d_importe[$i];
                                                                        $$det_salida="";
                                                                    } else {
                                                                        $$det_entrada="";
                                                                        $$det_salida=$d_importe[$i];
                                                                    }
                                                                    $$det_detalle=$d_detalle[$i];
                                                                    $$det_idcta=$d_idcta[$i];
                                                                } else {
                                                                    $$det_entrada=$glo->getGETPOST($det_entrada);
                                                                    $$det_detalle=$glo->getGETPOST($det_detalle);
                                                                    $$det_idcta=$glo->getGETPOST($det_idcta);
                                                                    $$det_salida=$glo->getGETPOST($det_salida);
                                                                }
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <select name="det_idcta<?= $i?>" id="det_idcta<?= $i?>" class="letra6">
                                                                    <? 
                                                                    $ssql="select id as id, concat_ws('', nombre,'-', codigo) as campo from adm_cta where tipo=1 order by nombre";
                                                                    $sup->cargaCombo3($ssql,$$det_idcta,"Sel") ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input name="det_detalle<?= $i?>" id="det_detalle<?= $i?>" type="text" class="letra6" size="30" maxlength="30" value="<?= $$det_detalle?>" />
                                                            </td>
                                                            <td align="center">
                                                                <input name="det_entrada<?= $i?>" id="det_entrada<?= $i?>" type="text" class="letra6" size="10" maxlength="10" value="<?= $$det_entrada?>" style="text-align: center" onkeypress="return validar_punto(event)" onblur="Validar_Contable(<?= $canti?>)" />
                                                            </td>
                                                            <td align="center">
                                                                <input name="det_salida<?= $i?>" id="det_salida<?= $i?>" type="text" class="letra6" size="10" maxlength="10" value="<?= $$det_salida?>" style="text-align: center" onkeypress="return validar_punto(event)" onblur="Validar_Contable(<?= $canti?>)" />
                                                            </td>
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
