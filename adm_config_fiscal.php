<?php
/*
 * Creado el 03/07/2019 10:08:44
 * Autor: gus
 * Archivo: adm_config_fiscal.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once("clases/globalson.php");
require_once("clases/support.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$sup=new support();
$glo=new globalson();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $cfg->getTitulo()?></title>
<script type="text/javascript" src="jscolor/jscolor.js"></script>
<script language="JavaScript" src="scw.js"></script>

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
<script type="text/javascript" src="jscolor/jscolor.js"></script>
<script type="text/javascript" src="planb.js"></script>
<?include_once 'estilos.php';?>

<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_config_fiscal_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CONFIGURACIÓN DATOS FISCALES</h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra3">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr>
                                                    <td align="right">Activar Fac. Electrónica&nbsp;</td>
                                                    <td><input name="fiscalactivo" id="fiscalactivo" type="checkbox" value="1" <? if($cfg->getFiscalactivo()==1) echo "checked='checked'";?> /></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" align="right">Punto de Venta&nbsp;</td>
                                                    <td><input name="fiscalpuntoventa" id="fiscalpuntoventa" type="text" size="4" maxlength="4" value="<?= $cfg->getFiscalpuntoventa()?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" align="right">Punto de Venta FCE&nbsp;</td>
                                                    <td><input name="fiscalpuntoventafce" id="fiscalpuntoventafce" type="text" size="4" maxlength="4" value="<?= $cfg->getFiscalpuntoventafce()?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">CUIT&nbsp;</td>
                                                    <td><input name="fiscalcuit" id="fiscalcuit" type="text" size="11" maxlength="11" value="<?= $cfg->getFiscalcuit()?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">II.BB.&nbsp;</td>
                                                    <td><input name="fiscaliibb" id="fiscaliibb" type="text" size="11" maxlength="11" value="<?= $cfg->getFiscaliibb()?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Condición IVA&nbsp;</td>
                                                    <td><input name="fiscaliva" id="fiscaliva" type="text" size="30" maxlength="30" value="<?= $cfg->getFiscaliva()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Nombre Fantasía&nbsp;</td>
                                                    <td><input name="fiscalfantasia" id="fiscalfantasia" type="text" size="40" maxlength="50" value="<?= $cfg->getFiscalfantasia()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Razon Social&nbsp;</td>
                                                    <td><input name="fiscalnombre" id="fiscalnombre" type="text" size="40" maxlength="50" value="<?= $cfg->getFiscalnombre()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Dirección&nbsp;</td>
                                                    <td><input name="fiscaldireccion" id="fiscaldireccion" type="text" size="40" maxlength="50" value="<?= $cfg->getFiscaldireccion()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Ciudad&nbsp;</td>
                                                    <td><input name="fiscalciudad" id="fiscalciudad" type="text" size="40" maxlength="50" value="<?= $cfg->getFiscalciudad()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Teléfono&nbsp;</td>
                                                    <td><input name="fiscaltelefono" id="fiscaltelefono" type="text" size="30" maxlength="50" value="<?= $cfg->getFiscaltelefono()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">E-Mail&nbsp;</td>
                                                    <td><input name="fiscalmail" id="fiscalmail" type="text" size="30" maxlength="50" value="<?= $cfg->getFiscalmail()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Copias&nbsp;</td>
                                                    <td>
                                                        <select name="fiscalcopia" id="fiscalcopia">
                                                            <?
                                                            $array=array("Original", "Duplicado", "Triplicado");
                                                            $avalor=array(1,2,3);
                                                            $sup->cargaComboArrayValor($array, $avalor, $cfg->getFiscalcopia());
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Formato&nbsp;</td>
                                                    <td>
                                                        <select name="fiscalformato" id="fiscalformato">
                                                            <?
                                                            $array=array("A4", "1/2 Pagina");
                                                            $avalor=array(1,2);
                                                            $sup->cargaComboArrayValor($array, $avalor, $cfg->getFiscalformato());
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Fecha Inicio Actividades&nbsp;</td>
                                                    <td><input name="fiscalfechainicio" id="fiscalfechainicio" class="letra6" type="date" value="<?= $cfg->getFiscalfechainicio()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Responsable&nbsp;</td>
                                                    <td><input name="fiscalresponsable" id="fiscalresponsable" size="50" maxlength="50" type="text" value="<?= $cfg->getFiscalresponsable()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Cargo&nbsp;</td>
                                                    <td><input name="fiscalcargo" id="cargoresponsable" size="20" maxlength="50" type="text" value="<?= $cfg->getFiscalcargo()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">CBU&nbsp;</td>
                                                    <td><input name="cbu" id="cbu" size="22" maxlength="22" type="text" value="<?= $cfg->getCbu()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Alias&nbsp;</td>
                                                    <td><input name="aliascbu" id="aliascbu" size="50" maxlength="50" type="text" value="<?= $cfg->getAliascbu()?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Factura Directa&nbsp;</td>
                                                    <td><input name="fiscalfacturadirecta" id="fiscalfacturadirecta" value="1" type="checkbox" <? if($cfg->getFiscalfacturadirecta()==1) echo "checked='checked'";?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><input name="cmdok" id="cmdok" type="submit" value="Modificar" /></td>
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
