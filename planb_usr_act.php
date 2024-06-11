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
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$canticentro=$glo->getGETPOST("canticentro");
if($canticentro=="") $canticentro=1;
if($tarea=="A") {
    $carteltarea="Agrega Usuario";
    $botoncap="Agregar!";
    $apellido;
    $nombre="";
    $apellido="";
    $email="";
    $nivel=1;
    $servidorafip=0;
} else {
    $carteltarea="Modifica Usuario";
    $botoncap="Modificar!";
    $adm=new usuarios_1($id);
    $apellido=$adm->getApellido();
    $nombre=$adm->getNombre();
    $email=$adm->getEmail();
    $nivel=$adm->getNivel();
    $servidorafip=$adm->getServidorafip();
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
	nombre: ['required', 'only_on_submit'],
	email: ['required', 'email', 'only_on_submit']
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
<form name="form1" id="form1" action="planb_usr_act_save.php" method="post">
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
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='planb_usr_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Nombre&nbsp;</td>
                                        <td width="65%"><input name="nombre" type="text" class="letra6" id="nombre" size="30" maxlength="30" value="<?= $nombre?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Apellido&nbsp;</td>
                                        <td><input name="apellido" type="text" class="letra6" id="apellido" size="30" maxlength="30" value="<?= $apellido?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Email (usuario)&nbsp;</td>
                                        <td><input name="email" type="text" class="letra6" id="email" size="50" maxlength="50" value="<?= $email?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Nivel&nbsp;</td>
                                        <td><select name="nivel" id="nivel">
                                            <?
                                            if($usr->getNivel()==0)
                                                $array=array(0,1,2);
                                            else 
                                                $array=array(1,2);
                                            $sup->cargaComboArrayValor($array, $array, $nivel);
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Servidor Afip&nbsp;</td>
                                        <td>
                                            <input name="servidorafip" id="servidorafip_0" type="radio" value="0" <? if($servidorafip==0) echo "checked='checked'";?> /> Local / 
                                            <input name="servidorafip" id="servidorafip_1" type="radio" value="1" <? if($servidorafip==1) echo "checked='checked'";?> /> Internet
                                        </td>
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
