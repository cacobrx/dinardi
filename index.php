<?
session_start();
if(!isset($_GET['Ancho']) && !isset($_GET['Alto']) )
{
echo "<script language=\"JavaScript\">
<!-- 
document.location=\"index.php?Ancho=\"+screen.width+\"&Alto=\"+screen.height;
//-->
</script>";
} else {
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
$cfg=new planb_config_1(1);
$glo=new globalson();
$error=$glo->getGETPOST("error");
$Ancho=$glo->getGETPOST("Ancho");
$Alto=$glo->getGETPOST("Alto");
if($Ancho<800) {
    $Ancho=1024;
}
if($Ancho>1366) $Ancho=1280;
$_SESSION["anchopantalla"]=$Ancho-50;
$_SESSION["altopantalla"]=$Alto;

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
	width:700px;
	height:75px;
	z-index:2;
	margin-left: -350px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<?require_once 'estilos.php';?>
</head>

<body>
    <div class="style1" id="barblue">
        <blockquote>
            <p class="titulo1"><?= $cfg->getCabecera()?></p>
        </blockquote>
    </div>
    <div id="barcentral">
        <form name="form1" id="form1" action="login.php" method="post">
            <div class="toggler letra6">
                <div id="effect" class="ui-widget-content ui-corner-all">
                    <h3 class="ui-widget-header ui-corner-all">Ingreso al Sistema</h3>                
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td width="35%" align="right">Usuario&nbsp</td>
                                    <td width="65%"><input name="email" type="text" id="email" size="40" /></td>
                                </tr>
                                <tr>
                                    <td align="right">Clave&nbsp;</td>
                                    <td><input name="clave" type="password" id="clave" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><hr></hr></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="Submit" value="Login" />
                                    </td>
                                </tr>
                <tr>
                    <td colspan="2" align="center" class="letra6bold"><?= $cfg->getPiepagina()?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" class="letra5"><?= "$Ancho x $Alto"?></td>
                </tr>
                            </table>
                        </td>
                    </tr>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<? } ?>
