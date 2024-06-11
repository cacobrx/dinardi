<?php
/*
 * Creado el 21/01/2019 10:42:29
 * Autor: gus
 * Archivo: adm_prv_pre_act.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_art.php';
require_once 'clases/adm_prv_pre.php';
require_once 'clases/adm_prv.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$idp=$glo->getGETPOST("idp");
$art=new adm_art_1($idp);
$carteltarea="Modifica Precio del Producto #$idp - ".$art->getDescripcion();
$botoncap="Modificar";
$adm=new adm_prv_pre_1($id, $idp);
$importe=$adm->getImporte();
$preciominimo=$adm->getPreciominimo();
$preciomaximo=$adm->getPreciomaximo();
$alicuota=$adm->getAlicuota();
$seleccionado=$adm->getSeleccionado();
if($importe==0) $importe=$art->getPrecio();
$preciofinal=number_format($importe+$importe*$alicuota/100,2,".","");

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
<script language="javascript">
    function calpreciofin() {
        ii=document.getElementById("alicuota").value;
        pp=document.getElementById("importe").value;
        pr=parseFloat(pp)+parseFloat(pp)*parseFloat(ii)/100;
        pr=Math.round(pr*100)/100;
        document.getElementById("preciofinal").value=pr;
    }
     
    function setseleccionado(val) {
        //alert(val);
        if(val!="")
            document.getElementById("seleccionado").checked=true;
        else
            document.getElementById("seleccionado").checked=false;
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
<form name="form1" id="form1" action="adm_prv_pre_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" id="id" type="hidden" value="<?= $id?>" />
        <input name="idp" id="idp" type="hidden" value="<?= $idp?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_prv_pre_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="50%" align="right">Precio&nbsp;</td>
                                        <td width="50%"><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" value="<?= $importe?>" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: calpreciofin()" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">IVA&nbsp;</td>
                                        <td><input name="alicuota" type="text" class="letra6" id="alicuota" size="6" maxlength="6" value="<?= $alicuota?>" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: calpreciofin()" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Precio Final&nbsp;</td>
                                        <td><input name="preciofinal" type="text" class="letra6" id="preciofinal" size="10" maxlength="10" value="<?= $preciofinal?>" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Precio Mínimo&nbsp;</td>
                                        <td><input name="preciominimo" type="text" class="letra6" id="preciominimo" size="10" maxlength="10" value="<?= $preciominimo?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Precio Máximo&nbsp;</td>
                                        <td><input name="preciomaximo" type="text" class="letra6" id="preciomaximo" size="10" maxlength="10" value="<?= $preciomaximo?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Seleccionar&nbsp;</td>
                                        <td><input name="seleccionado" id="seleccionado" type="checkbox" value="1" <? if($seleccionado==1) echo "checked='checked'"?> /></td>
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
