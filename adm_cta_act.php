<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_cta.php';
$cfg=new planb_config_1($centrosel);
$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $carteltarea="Agrega Cuenta";
    $botoncap="Agregar!";
    $nombre="";
    $tipo=0;
    $codigo="";
} else {
    $carteltarea="Modifica Cuenta";
    $botoncap="Modificar!";
    $cta=new adm_cta_1($id);
    $nombre=$cta->getNombre();
    $tipo=$cta->getTipo();
    $codigo=$cta->getCodigo();
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
<script type="text/javascript" src="planbjs/cta.js?4"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['codigo', 'only_on_submit'],
	nombre: ['required', 'only_on_submit']
}
</script>
<? include("estilos.php");?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_cta_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require("displayusuario.php");?>
                <tr>
                    <td>
                        <div class="panel960 letra6">                                
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">                                    
                                <h3 class="ui-widget-header ui-corner-all">Agregar Cuenta</h3>            
                                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra3">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_cta_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Código</td>
                                        <td width="65%"><input name="codigo" type="text" class="letra6" id="codigo" size="20" maxlength="20" value="<?= $codigo?>" onkeypress="return validar_punto(event)" onblur="javascript: verificarcuenta(this.value)" /></td>
                                    </tr>
                                    <tr>
                                        <td width="35%"><div align="right">Nombre</div></td>
                                        <td width="65%"><input name="nombre" type="text" class="letra6" id="nombre" size="50" maxlength="50" value="<?= $nombre?>" /></td>
                                    </tr>
                                    <tr>
                                        <td width="35%"><div align="right">Tipo Cuenta</div></td>
                                        <td width="65%">
                                            <select name="tipo" id="tipo">
                                                <? 
                                                $array=array("Imputable","No Imputable");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div id="cartel" class="letraerror"></div>
                                            <input type="submit" name="cmdok" id="cmdok" value="<?= $botoncap?>" />
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
