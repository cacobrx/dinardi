<?
//print_r($_POST);
require "user.php";
require_once "clases/globalson.php";
require_once "clases/planb_config.php";
require_once 'clases/adm_contable.php';
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="")
    $fechaini=date("Y-m-01");
if($fechafin=="")
    $fechafin=date("Y-m-d");
$primero=$glo->getGETPOST("primero");
if($primero==1) {
    $adm=new sumasysaldos($centrosel, $fechaini, $fechafin);
    $a_cta=$adm->getCodigo();
    $a_nom=$adm->getNombre();
    $a_deb=$adm->getDebitos();
    $a_cre=$adm->getCreditos();
    $a_let=$adm->getLetra();
    $a_esp=$adm->getEspacios();
    $a_sal=$adm->getSaldo();
} else
    $a_cta=array();
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
<? require_once 'estilos.php';?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="primero" id="primero" type="hidden" value="1" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">SUMAS Y SALDOS</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>Fecha desde <input name="fechaini" type="date" class="letra6" id="fechaini" value="<?= $fechaini?>" /> 
                                            hasta <input name="fechafin" type="date" class="letra6" id="fechafin" value="<?= $fechafin?>" /> | 
                                            <input name="cmdok" id="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_ss.php'; document.form1.submit()" />
                                            <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_ss_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_ss_exl.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="letra6">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="55%" align="left">Cuentas</td>
                                                    <td width="15%" align="right">D&eacute;bitos</td>
                                                    <td width="15%" align="right">Cr&eacute;ditos</td>
                                                    <td width="15%" align="right">Saldo</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><hr></hr></td>
                                                </tr>
                                                <? for($i=0;$i<count($a_cta);$i++) { ?>
                                                <tr class="<?= $a_let[$i]?>" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td><?= $a_esp[$i].$a_esp[$i].$a_cta[$i]." ".$a_nom[$i]?></td>
                                                    <td align="right"><?= number_format($a_deb[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_cre[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_sal[$i],2)?>
                                                    </td>
                                                </tr>
                                                <? } ?>
                                            </table>
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
