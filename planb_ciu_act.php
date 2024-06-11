<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/ciudades.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $carteltarea="Agrega Ciudad";
    $botoncap="Agregar!";
    $apellido;
    $ciudad="";
    $provincia=0;
    $cpostal="";
    $abreviado="";
} else {
    $carteltarea="Modifica Ciudad";
    $botoncap="Modificar!";
    $ciu=new ciudades_1($id);
    $ciudad=$ciu->getCiudad();
    $provincia=$ciu->getProvincia();
    $cpostal=$ciu->getCpostal();
    $abreviado=$ciu->getAbreviado();
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
	ciudad: ['required', 'only_on_submit'],
}
</script>

<?require_once 'estilos.php';?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="planb_ciu_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                            <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td colspan='2'><a href="javascript: document.form1.target='_self'; document.form1.action='planb_ciu_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                </tr>
                                <tr>
                                    <td width="35%" align="right">Ciudad&nbsp;</td>
                                    <td width="65%"><input name="ciudad" type="text" class="letra6" id="ciudad" size="30" maxlength="30" value="<?= $ciudad?>" /></td>
                                </tr>
                                <tr>
                                    <td align="right">Abreviado&nbsp;</td>
                                    <td><input name="abreviado" type="text" class="letra6" id="abreviado" size="5" maxlength="5" value="<?= $abreviado?>" /></td>
                                </tr>
                                <tr>
                                    <td align="right">Provincia&nbsp;</td>
                                    <td>
                                        <select name="provincia" id="provincia">
                                            <? $sup->cargaCombo("select valor as id, descripcion as campo from tablas where codtab='PRO' order by descripcion", $provincia)?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">C.Postal&nbsp;</td>
                                    <td><input name="cpostal" type="text" class="letra6" id="cpostal" size="10" maxlength="10" value="<?= $cpostal?>" /></td>
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
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
