<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art_act.php
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
    $carteltarea="Agrega Productos";
    $botoncap="Agregar!";
    $descripcion='';
    $precio='';
    $rubro=0;
    $codigo="";
    $envasado=0;
    $elaborado=0;
    $tipoenvalaje=0;
    $cantidad='';
} else {
    $carteltarea="Modifica Productos";
    require_once 'clases/adm_art.php';
    $botoncap="Modificar!";
    $adm=new adm_art_1($id);
    $id=$adm->getId();
    $descripcion=$adm->getDescripcion();
    $precio=$adm->getPrecio();
    $rubro=$adm->getRubro();
    $codigo=$adm->getCodigodinardi();
    $envasado=$adm->getEnvasado();
    $tipoenvalaje=$adm->getTipoenvalaje();
    $cantidad=$adm->getCantidad();
    $elaborado=$adm->getElaborado();
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
<form name="form1" id="form1" action="adm_art_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_art_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Código&nbsp;</td>
                                        <td><input name="codigo" id="codigo" type="text" value="<?= $codigo?>" onkeypress="return validar(event)" style="text-align: center" size="5" maxlength="5" />  </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Descripcion&nbsp;</td>
                                        <td width="65%"><input name="descripcion" type="text" class="letra6" id="descripcion" size="50" maxlength="50" value="<?= $descripcion?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Rubro&nbsp;</td>
                                        <td>
                                            <select name="rubro" id="rubro">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='RUB' order by valor";
                                                $sup->cargaCombo3($ssql, $rubro);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo Embalaje&nbsp;</td>
                                        <td>
                                            <select name="tipoenvalaje" id="tipoenvalaje">
                                                <? 
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='TENV' order by valor";
                                                $sup->cargaCombo3($ssql, $tipoenvalaje);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Cantidad&nbsp;</td>
                                        <td width="65%"><input name="cantidad" type="text" class="letra6" id="cantidad" size="10" maxlength="10" value="<?= $cantidad?>" onkeypress="return validar_punto(event)" style="text-align: center"  /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Envasado&nbsp;</td>
                                        <td><input name="envasado" id="envasado" type="checkbox" value="1" <? if($envasado==1) echo "checked='checked'"; ?> /></td>
                                    </tr>                                    
                                    <tr>
                                        <td align="right">Elaborado&nbsp;</td>
                                        <td><input name="elaborado" id="elaborado" type="checkbox" value="1" <? if($elaborado==1) echo "checked='checked'"; ?> /></td>
                                    </tr>                                    
                                    <tr>
                                        <td width="35%" align="right">Precio&nbsp;</td>
                                        <td width="65%"><input name="precio" type="text" class="letra6" id="precio" size="10" maxlength="10" value="<?= $precio?>" onkeypress="return validar_punto(event)" style="text-align: center"  /></td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
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
