<?php
/*
 * Creado el 07/04/2019 20:36:32
 * Autor: gus
 * Archivo: adm_che_det.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_che.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$idche=$glo->getGETPOST("idche");

$urlvolver=$glo->getGETPOST("urlvolver");
if($urlvolver=="")
    $urlvolver="adm_che_main.php";
$primero=$glo->getGETPOST("primero");
$hoy=date("Y-m-d");
$carteltarea="Detalle Cheque Propio #$idche";
$adm=new adm_che_1($idche);
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
        /*visibility:hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.20"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	destinatario: ['required', 'only_on_submit'],
        fecha: ['required', 'only_on_submit'],
        fechaorigen: ['required', 'only_on_submit'],
        importe: ['required', 'only_on_submit'],
        fechapago: ['required', 'only_on_submit']
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
<form name="form1" id="form1" action="adm_che_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="idche" type="hidden" id="idche" value="<?= $idche?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>              
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_che_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Fecha Origen&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFechaorigen())?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Vencimiento&nbsp;</td>
                                        <td class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFechapago())?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Banco&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getBancodes()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Nro Cheque&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getNrocheque()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Destinatario&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getDestinatario()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Referencias&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getReferencia()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td class="letra6bold"><?= number_format($adm->getImporte(),2)?></td>                  
                                    </tr>
                                    <tr>
                                        <td align="right">Acreditado&nbsp;</td>
                                        <td>
                                            <? if($adm->getAcreditado()==1) { ?>
                                            <i class="far fa-check-circle fa-lg"></i>
                                            <? } ?>
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
