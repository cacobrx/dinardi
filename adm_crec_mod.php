<?php
/*
 * Creado el 04/10/2020 21:12:58
 * Autor: gus
 * Archivo: adm_crec_mod.php
 * planbsistemas.com.ar
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
$carteltarea="Modifica Recibo";
require_once 'clases/adm_crec.php';
$botoncap="Modificar!";
$adm=new adm_crec1_1($id);
$fecha=$adm->getFecha();
$idcli=$adm->getIdcli();
$numero=$adm->getNumero();
$concepto=$adm->getConcepto();
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
<?require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="adm_crec_mod_save.php" method="post">
    <tr >
    <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td colspan='2'><a href="javascript: document.form1.target='_self'; document.form1.action='adm_crec_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Número&nbsp;</td>
                                        <td width="65%"><input name="numero" type="text" id="numero" size="8" maxlength="8" value="<?= $numero?>" onkeypress="return validar(event)" required /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td ><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Cliente&nbsp;</td>
                                        <td>
                                            <select name="idcli" id="idcli">
                                                <?
                                                $ssql="select id as id, apellido as campo from adm_cli order by apellido";
                                                $sup->cargaCombo3($ssql, $idcli);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Concepto&nbsp;</td>
                                        <td>
                                            <input name="concepto" id="concepto" type="text" size="50" value="<?= $concepto?>" />
                                        </td>
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
    <tr>
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
