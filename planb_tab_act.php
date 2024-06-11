<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/tabla.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$tarea=$glo->getGETPOST("tarea");
$tablasel=$glo->getGETPOST("tablasel");
$id=$glo->getGETPOST("id");
$codtab=$glo->getGETPOST("codtab");
$adm=new tabla_def($tablasel);
if($lim=="")
  $lim=0;
//$usr=new edd_users_1($idusr);
if($tarea=="A") {
  $carteltarea="Agrega Elemento a la Tabla";
  $botoncap="Agregar!";
  $descripcion="";
  $activo=1;
} else {
  $carteltarea="Modifica Elementeo de la Tabla";
  $botoncap="Modificar!";
  $tab=new tabla_1($id);
  $descripcion=$tab->getDescripcion();
  $activo=$tab->getActivo();
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
<form name="form1" id="form1" action="planb_tab_act_save.php" method="post">
    <tr>
    <? include("adm_menu.php") ?>
    <input name="id" type="hidden" id="id" value="<?= $id?>" />
    <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    <input name="tablasel" type="hidden" id="tablasel" value="<?= $tablasel?>" />
    <input name="lim" type="hidden" id="lim" value="<?= $lim?>" />
    <input name="codtab" type="hidden" id="codtab" value="<?= $codtab?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel700c letra6">
                            <div id="effect-panel700c" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='planb_tab_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Descripción&nbsp;</td>
                                        <td width="65%"><input name="descripcion" type="text" class="letra6" id="descripcion" size="50" maxlength="50" value="<?= $descripcion?>" /></td>
                                    </tr>
                                    <? if($adm->getActivo()==1) { ?>
                                    <tr>
                                        <td align="right">Activo&nbsp;</td>
                                        <td><input name="activo" id="activo" value="1" type="checkbox" <? if($activo==1) echo "checked='checked'"?> /></td>
                                    </tr>
                                    <? } ?>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
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
      <td colspan="2">&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
