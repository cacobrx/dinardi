<?php
/*
 * Creado el 23/01/2021 12:13:32
 * Autor: gus
 * Archivo: adm_crec_pag_add.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idrec=$glo->getGETPOST("idrec");

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
    <form name="form1" id="form1" action="adm_crec_pag_add_save.php" method="post">
    <tr >
    <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="idrec" type="hidden" id="idrec" value="<?= $idrec?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Agrega Detalle de Pago</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td colspan='2'><a href="javascript: document.form1.target='_self'; document.form1.action='adm_crec_det.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo de Pago&nbsp;</td>
                                        <td>
                                            <select name="detallepago" id="detallepago">
                                                <?
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='DPG' order by valor";
                                                $sup->cargaCombo3($ssql, 0, "Sel");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Detalle&nbsp;</td>
                                        <td width="65%"><input name="detalle" type="text" id="detalle" size="50" maxlength="50" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td ><input name="importe" type="text" id="importe" required onkeypress="return validar_punto(event)" style='text-align: center' /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">ID Cheque&nbsp;</td>
                                        <td>
                                            <input name="idcht" id="idcht" type="text" size="6" onkeypress="return validar(event)" style='text-align: center' />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="Agregar" />
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
