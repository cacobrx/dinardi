<?php
/*
 * creado el 31/07/2016 17:45:42
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_clasif_act
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/adm_clasif.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/conexion.php';
$conx=new conexion();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$primero=$glo->getGETPOST("primero");
$cajades=$conx->getTextoValor($cajaclf, "CAJA");

$tipoant="";
switch ($tipoclf) {
    case "DESN1":
        $tipoant="";
        $carteldes="Descriptor Nivel 1";
        $val="";
        break;
    case "DESN2":
        $tipoant="DESN1";
        $carteldes="Descriptor Nivel 2";
        $val="001";
        break;
    case "DESN3":
        $tipoant="DESN2";
        $carteldes="Descriptor Nivel 3";
        $val="001001";
        break;
    case "DESN4":
        $tipoant="DESN3";
        $carteldes="Descriptor Nivel 4";
        $val="001001001";
        break;
}
//$codtab=$glo->getGETPOST("codtab");
if($tarea=="A") {
    $carteltarea="Agrega $carteldes";
    $botoncap="Agregar!";
} else {
    $carteltarea="Modifica $carteldes";
    $botoncap="Modificar!";
}
if($primero!=1) {
    if($tarea=="A") {
        $carteltarea="Agrega $carteldes";
        $botoncap="Agregar!";
        $texto="";
        $adm=new adm_clasif_1cod($val);
        $dependencia=$adm->getId();
        $tipodep="";
        $codigodep=$sup->getNuevocodigo($tipoclf, $val);
        $activo=1;
    } else {
        $carteltarea="Modifica $carteldes";
        $botoncap="Modificar!";
        $adm=new adm_clasif_1($id);
        $texto=$adm->getTexto();
        $tipodep=$adm->getTipodep();
        $dependencia=$adm->getDependiencia();
        $activo=$adm->getActivo();
        $codigodep=$adm->getCodigodep();
    }
} else {
    $texto=$glo->getGETPOST("texto");
    $dependencia=$glo->getGETPOST("dependencia");
    $tipodep=$glo->getGETPOST("tipodep");
    $clf=new adm_clasif_1($dependencia);
    $codigodep=$sup->getNuevocodigo($tipoclf, $clf->getCodigodep());
    $activo=$glo->getGETPOST("activo");
    
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
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="eddis.js"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	descripcion: ['required', 'only_on_submit', 'length:50'],
	valor: ['required', 'only_on_submit', 'length:5', 'integer']
}
</script>
<?include_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_clasif_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="carteldes" type="hidden" id="carteldes" value="<?= $carteldes?>" />
        <input name="tipoant" id="tipoant" type="hidden" value="<?= $tipoant?>" />
        <input name="primero" id="primero" type="hidden" value="1" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan='2'><a href="javascript: document.form1.target='_self'; document.form1.action='adm_clasif_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Descripción&nbsp;</td>
                                        <td width="65%"><input name="texto" type="text" class="letra6" id="texto" size="50" maxlength="50" value="<?= $texto?>" /></td>
                                    </tr>
                                    <? if($tipoclf!="") { ?>
                                    <tr>
                                        <td align="right">Dependencia&nbsp;</td>
                                        <td>
                                            <select name="dependencia" id="dependencia" onchange="javascript: document.form1.target='_self'; document.form1.action='adm_clasif_act.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', texto, '(', codigodep, ')') as campo from adm_clasif where tipo='$tipoant' order by texto";
                                                echo $ssql;
                                                $sup->cargaCombo3($ssql, $dependencia);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                  
                                    <? } ?>
                                    <tr>
                                        <td align="right">Activo&nbsp;</td>
                                        <td><input name="activo" id="activo" value="1" type="checkbox" <? if($activo==1) echo "checked='checked'"?> /></td>
                                    </tr>  
                                    <tr>
                                        <td width="35%" align="right">Codigo dependencia&nbsp;</td>
                                        <td width="65%"><input name="codigodep" style="text-align: center" type="text" class="letra6" id="codigodep" size="15" maxlength="50" value="<?= $codigodep?>" /></td>
                                    </tr>    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center"><input type="submit" name="Submit" value="<?= $botoncap?>" /></td>
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