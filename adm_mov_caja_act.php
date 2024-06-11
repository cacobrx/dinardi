<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_act.php
 */

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
    $carteltarea="Agrega Movimientos de Caja";
    $botoncap="Agregar!";
    $fecha=date("Y-m-d");
    $detalle='';
    $importe="";
    $tipocaja=1;
    $descriptor1=1;
    $descriptor2=0;
    $descriptor3=0;
    $descriptor4=0;
    $segmento1=0;
    $segmento2=0;
    $segmento3=0;
    $segmento4=0;
    $oficina=0;
    $tipomov=0;

    $tipopago=1;
    $indice="";
    $idopg="";
    $idrec="";
} else {
  $carteltarea="Modifica Movimientos de Caja";
  require_once 'clases/adm_mov_caja.php';
  $botoncap="Modificar!";
  $adm=new adm_mov_caja_1($id);
  $id=$adm->getId();
  $fecha=$adm->getFecha();
  $detalle=$adm->getDetalle();
  $importe=abs($adm->getImporte());
  $tipocaja=$adm->getTipocaja();
  $idmov=$adm->getIdmov();
  $tipomov=$adm->getTipomov();
  $descriptor1=$adm->getDescriptor1();
  $descriptor2=$adm->getDescriptor2();
  $descriptor3=$adm->getDescriptor3();
  $descriptor4=$adm->getDescriptor4();
  $segmento1=$adm->getSegmento1();
  $segmento2=$adm->getSegmento2();
  $segmento3=$adm->getSegmento3();
  $segmento4=$adm->getSegmento4();
  $oficina=$adm->getOficina();
  $tipomov=$adm->getTipomov();
  $tipopago=$adm->getTipopago();
  $indice=$adm->getIndice();
  $idopg=$adm->getIdopg();
  $idrec=$adm->getIdrec();
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
<script type="text/javascript" src="planb.js?1.1.1"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	fecha: ['required', 'only_on_submit']
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
<form name="form1" id="form1" action="adm_mov_caja_act_save.php" method="post">
    <tr >
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_mov_caja_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="10%" align="right">Detalle&nbsp;</td>
                                        <td width="90%"><input name="detalle" type="text"class="letra6" id="detalle" size="100" maxlength="100" value="<?= $detalle?>" /></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td><input name="importe" type="text"class="letra6" id="importe" size="10" maxlength="10" value="<?= $importe?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <? if($tarea=="M") { ?>
                                    <tr>
                                        <td align="right">Caja&nbsp;</td>
                                        <td>
                                            <select name="tipocaja" id="tipocaja" onchange="cargades1(this.value)">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='CAJA' order by valor";
                                                $sup->cargaCombo3($ssql, $tipocaja) ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <? } else { ?>
                                    <tr>
                                        <td align="right">Caja Origen&nbsp;</td>
                                        <td>
                                            <select name="tipocaja" id="tipocaja" onchange="cargades1(this.value)">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='CAJA' order by valor";
                                                $sup->cargaCombo3($ssql, $tipocaja) ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <? }?>
                                    <tr>
                                        <td align="right">Medio de Pago&nbsp;</td>
                                        <td>
                                            <select name="tipopago" id="tipopago">
                                                <?
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='MEDIO' order by valor";
                                                $sup->cargaCombo3($ssql, $tipopago);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <td>
                                            <select name="tipomov" id="tipomov">
                                                <?
                                                $array=array("Entrada","Salida");
                                                $avalor=array(0,1);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipomov);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Descriptores&nbsp;</td>
                                        <td>
                                            <select name="descriptor1" id="descriptor1" onchange="cargades2(this.value)">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                //echo $ssql;
                                                $sup->cargaCombo3($ssql, $descriptor1, "Ninguno");
                                                ?>
                                            </select> | 
                                            <select name="descriptor2" id="descriptor2" onchange="cargades3(this.value)">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=$descriptor1 order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor2, "Ninguno");
                                                ?>
                                            </select> | 
                                            <select name="descriptor3" id="descriptor3" onchange="cargades4(this.value)">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=$descriptor2 order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor3, "Ninguno");
                                                ?>
                                            </select> | 
                                            <select name="descriptor4" id="descriptor4">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=$descriptor3 order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor4, "Ninguno");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right">Oficina&nbsp;</td>
                                        <td>
                                            <select name="oficina" id="oficina">
                                                <?
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='OFIN1' order by descripcion";
                                                $sup->cargaCombo3($ssql, $oficina, "Ninguno");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Indice&nbsp;</td>
                                        <td>
                                            <input name="indice" id="indice" value="<?= $indice?>" size="30" maxlength="30" />
                                        </td>
                                    </tr>
<!--                                    <tr>
                                        <td align="right">ID Recibo Alquiler&nbsp;</td>
                                        <td><input name="idrec" id="idrec" value="<?= $idrec?>" size="5" maxlength="5" style="text-align: center" onkeypress="return validar(event)" /></td>
                                    </tr>-->
                                    <tr>
                                        <td align="right">ID Orden de Pago&nbsp;</td>
                                        <td><input name="idopg" id="idopg" value="<?= $idopg?>" size="5" maxlength="5" style="text-align: center" onkeypress="return validar(event)" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr></hr>
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
</form>
</div>
</body>
</html>
