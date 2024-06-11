<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_act.php
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
$versaldocero=$glo->getGETPOST("versaldocero");
if($tarea=="A") {
  $carteltarea="Agrega Cliente";
  $botoncap="Agregar!";
  $apellido='';
  $nombre='';
  $ciudad="";
  $celular='';
  $telefono='';
  $cuit='';
  $observaciones='';
  $email="";
  $direccion="";
  $condicioniva=1;
  $percepcioniibb="";
  $saldoini="";
  $diasvencimientofac="";
  $fechainicioctacte=date("Y-01-01");
} else {
  $carteltarea="Modifica Cliente";
  require_once 'clases/adm_cli.php';
  $botoncap="Modificar!";
  $adm=new adm_cli_1($id);
  $apellido=$adm->getApellido();
  $nombre=$adm->getNombre();
  $ciudad=$adm->getCiudad();
  $celular=$adm->getCelular();
  $telefono=$adm->getTelefono();
  $cuit=$adm->getCuit();
  $observaciones=$adm->getObservaciones();
  $email=$adm->getEmail();
  $direccion=$adm->getDireccion();
  $condicioniva=$adm->getCondicioniva();
  $percepcioniibb=$adm->getPercepcioniibb();
  $saldoini=$adm->getSaldoini();
  $diasvencimientofac=$adm->getDiasvencimientofac();
  $fechainicioctacte=$adm->getFechainicioctacte();
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
	apellido: ['required', 'only_on_submit'],
	ciudad: ['required', 'only_on_submit'],
	//telefono: ['required', 'only_on_submit'],
	condicioniva: ['required', 'only_on_submit'],
	documento: ['required', 'only_on_submit']
        
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
<form name="form1" id="form1" action="adm_cli_act_save.php" method="post">
    <tr >
    <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="primero" type="hidden" id="primero" value="1" />
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
                                        <td colspan='2'><a href="javascript: document.form1.target='_self'; document.form1.action='adm_cli_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Razón Social&nbsp;</td>
                                        <td width="65%"><input name="apellido" type="text" class="letra6" id="apellido" size="50" maxlength="50" value="<?= $apellido?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Nombre Fantasía&nbsp;</td>
                                        <td ><input name="nombre" type="text" class="letra6" id="nombre" size="50" maxlength="50" value="<?= $nombre?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Dirección&nbsp;</td>
                                        <td ><input name="direccion" type="text" class="letra6" id="direccion" size="50" maxlength="50" value="<?= $direccion?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Ciudad&nbsp;</td>
                                        <td>
                                            <select name="ciudad" id="ciudad">
                                                <?
                                                $ssql="select id as id, ciudad as campo from ciudades order by ciudad";
                                                $sup->cargaCombo3($ssql, $ciudad, "Sel.");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Email&nbsp;</td>
                                        <td>
                                            <input name="email" id="email" type="text" class="letra6" size="50" maxlength="50" value="<?= $email?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Teléfono&nbsp;</td>
                                        <td ><input name="telefono" type="text" class="letra6" id="telefono" size="20" maxlength="20" value="<?= $telefono?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Celular&nbsp;</td>
                                        <td><input name="celular" type="text" class="letra6" id="celular" size="20" maxlength="20" value="<?= $celular?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">CUIT&nbsp;</td>
                                        <td><input name="cuit" type="text" class="letra6" id="cuit" size="12" maxlength="11" value="<?= $cuit?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Condición IVA&nbsp;</td>
                                        <td>
                                            <select name="condicioniva" id="condicioniva">
                                                <?
                                                $array=array("Consumidor Final", "Exento", "Responsable Inscripto", "Monotributo");
                                                $avalor=array(1,2,3,4);
                                                $sup->cargaComboArrayValor($array, $avalor, $condicioniva);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Percepción IIBB&nbsp;</td>
                                        <td><input name="percepcioniibb" id="percepcioniibb" type="text" size="6" maxlength="6" value="<?= $percepcioniibb?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Saldo Inicial&nbsp;</td>
                                        <td><input name="saldoini" id="saldoini" type="text" size="10" maxlength="10" value="<?= $saldoini?>" onkeypress="return validar_punto_menos(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Días vencimiento fecha factura&nbsp;</td>
                                        <td><input name="diasvencimientofac" id="diasvencimientofac" type="text" size="3" maxlength="3" value="<?= $diasvencimientofac?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha de inicio de cuenta corriente&nbsp;</td>
                                        <td><input name="fechainicioctacte" id="fechainicioctacte" type="date" value="<?= $fechainicioctacte?>" class="letra6" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td>
                                            <textarea name="observaciones" cols="80" rows="5" class="letra6" id="observaciones"><?= $observaciones?></textarea>
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
