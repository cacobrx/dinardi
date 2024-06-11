<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($id=="")
    $id=$usr->getId();
$carteltarea="Modifica Clave";
$botoncap="Modificar!";
$jug=new usuarios_1($id);
$apellido=$jug->getApellido();
$nombre=$jug->getNombre();
$email=$jug->getEmail();
if($usr->getNivel()==0)
    $url="planb_usr_main.php";
else
    $url="adm_index.php";
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
<form name="form1" id="form1" action="" method="post" onsubmit="return validar_clave()">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="url" type="hidden" id="url" value="<?= $url?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel700c letra6">
                            <div id="effect-panel700c" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <? if($usr->getNivel()==0) { ?>
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='<?= $url?>'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <? } ?>
                                    <tr>
                                        <td width="35%" align="right">Nombre&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $jug->getNombre()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Apellido&nbsp;</td>
                                        <td class="letra6bold"><?= $jug->getApellido()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Email&nbsp;</td>
                                        <td class="letra6bold"><?= $jug->getEmail()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Nueva Clave&nbsp;</td>
                                        <td class="letra6bold"><input name="clave" type="text" class="letra6" id="clave" size="20" maxlength="20" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Envía Mail?&nbsp;</td>
                                        <td>
                                            <input name="enviamail" id="enviamail" type="checkbox" value="1" checked="checked" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='planb_usr_pwd_save.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
