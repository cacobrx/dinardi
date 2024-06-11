<?
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
<form name="form1" id="form1" action="planb_conf_save.php" method="post">
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
                                <h3 class="ui-widget-header ui-corner-all">CONFIGURACIÓN DEL SISTEMA</h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra3">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0">
                                                <tr>
                                                    <td width="33%" valign="top">
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td width="46%">Color 1</td>
                                                                <td width="54%">
                                                                    <input name="color1" id="color1" type="color" value="<?= $cfg->getColor1()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Color Barra</td>
                                                                <td>
                                                                    <input name="colorbarra" id="colorbarra" type="color" value="<?= $cfg->getColorbarra()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="67%">
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td width="36%">Titulo Pagina</td>
                                                                <td width="64%">
                                                                    <input name="titulo" class="letra3" id="titulo" value="<?= $cfg->getTitulo()?>" size="40" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Titulo Cabecera</td>
                                                                <td>
                                                                    <input name="cabecera" class="letra3" id="cabecera" value="<?= $cfg->getCabecera()?>" size="40" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Pie de Página</td>
                                                                <td>
                                                                    <input name="piepagina" class="letra3" id="piepagina" value="<?= $cfg->getPiepagina()?>" size="50" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Líneas por Página</td>
                                                                <td>
                                                                    <input name="limmax" class="letra3" id="limmax" value="<?= $cfg->getLimmax()?>" size="3" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Altura Marco</td>
                                                                <td>
                                                                    <input name="alturamarco" class="letra3" id="alturamarco" value="<?= $cfg->getAlturamarco()?>" size="3" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Punto Decimal para Excel</td>
                                                                <td>
                                                                    <select name="puntodecimal" id="puntodecimal">
                                                                        <?
                                                                        $array=array(". (punto)", ", (coma)");
                                                                        $avalor=array(".", ",");
                                                                        $sup->cargaComboArrayValor($array, $avalor, $cfg->getPuntodecimal());
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr> 
                                                            <tr>
                                                                <td>Cuenta Entrada O/Pago</td>
                                                                <td>
                                                                    <select name="cuentaentradaop" id="cuentaentradaop">
                                                                        <?
                                                                        $ssql="select id as id, concat_ws(' ', nombre, '(', codigo, ')') as campo from adm_cta where tipo=1 order by nombre";
                                                                        $sup->cargaCombo3($ssql, $cfg->getCuentaentradaop(), "Sel.");
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cuenta Salida O/Pago</td>
                                                                <td>
                                                                    <select name="cuentasalidaop" id="cuentasalidaop">
                                                                        <?
                                                                        $ssql="select id as id, concat_ws(' ', nombre, '(', codigo, ')') as campo from adm_cta where tipo=1 order by nombre";
                                                                        $sup->cargaCombo3($ssql, $cfg->getCuentasalidaop(), "Sel.");
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Días de Vencimiento Cheques</td>
                                                                <td><input name="diasvencimientocht" id="diasvencimientocht" type="text" value="<?= $cfg->getDiasvencimientocht()?>" size="3" maxlength="3" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Días anteriores al mes de Vencimiento de Cheques</td>
                                                                <td><input name="diasfinalcht" id="diasfinalcht" type="text" value="<?= $cfg->getDiasfinalcht()?>" size="3" maxlength="3" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mínimo no imponible para retenciones (bienes)</td>
                                                                <td><input name="minimoretenciones" id="minimoretenciones" type="text" value="<?= $cfg->getMinimoretenciones()?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mínimo no imponible para retenciones (servicios)</td>
                                                                <td><input name="minimoretencionesser" id="minimoretencionesser" type="text" value="<?= $cfg->getMinimoretencionesser()?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fecha inicio cuenta corriente clientes</td>
                                                                <td><input name="fechainicioctacte" id="fechainicioctacte" type="date" class="letra6" value="<?= $cfg->getFechainicioctacte()?>" required /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Color Descriptor 1</td>
                                                                <td>
                                                                    <input name="colordescriptor1" id="colordescriptor1" type="color" value="<?= $cfg->getColordescriptor1()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>    
                                                            <tr>
                                                                <td>Color Descriptor 2</td>
                                                                <td>
                                                                    <input name="colordescriptor2" id="colordescriptor2" type="color" value="<?= $cfg->getColordescriptor2()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>       
                                                            <tr>
                                                                <td>Color Descriptor 3</td>
                                                                <td>
                                                                    <input name="colordescriptor3" id="colordescriptor3" type="color" value="<?= $cfg->getColordescriptor3()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>    
                                                            <tr>
                                                                <td>Color Descriptor 4</td>
                                                                <td>
                                                                    <input name="colordescriptor4" id="colordescriptor4" type="color" value="<?= $cfg->getColordescriptor4()?>" style="border: 0" size="5" />
                                                                </td>
                                                            </tr>                                                                        
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
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
