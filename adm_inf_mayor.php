<?php
/*
 * creado el 23/11/2017 15:38:14
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_inf_mayor
 */

//print_r($_POST);
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_contable.php';
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
if($primero==1) {
    $adm=new libromayor($centrosel, $fechainimay, $fechafinmay, $idctamay);
    $a_cta=$adm->getIdcta();
    $a_nom=$adm->getNombre();
    $a_cod=$adm->getCodigo();
    $a_deb=$adm->getEntrada();
    $a_cre=$adm->getSalida();
    $a_sal=$adm->getSaldo();
    $m_fec=$adm->getDet_fecha();
    $m_des=$adm->getDet_descripcion();
    $m_asi=$adm->getDet_asiento();
    $m_ent=$adm->getDet_entrada();
    $m_sal=$adm->getDet_salida();
    $m_sdo=$adm->getDet_saldo();
//    print_r($a_cta);
//    echo count($a_cta);
} else
    $a_cta=array();

//echo "plan: ".$est->getCantplan()."<br>";
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
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<? require_once "estilos.php" ?>;
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
        <input name="idctamay" id="idctamay" type="hidden" value="<?= $idctamay?>" />
        <input name="primero" id="primero" type="hidden" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">LIBRO MAYOR</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainimay" type="date" class="letra6" id="fechainimay" value="<?= $fechainimay?>" /> 
                                            hasta <input name="fechafinmay" type="date" class="letra6" id="fechafinmay" value="<?= $fechafinmay?>" /> | 
                                            <input name="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.primero.value=1; document.form1.action='register_may.php'; document.form1.submit()" /> 
                                            <input name="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_mayor_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_mayor_exl.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input name="cmdcta" id="cmdcta" type="submit" value="Seleccionar Cuentas" onclick="javascript: document.form1.target='_self'; document.form1.primero.value=0; document.form1.action='adm_cta_sel.php'; document.form1.submit()" /> 
                                            Cuentas <span class="letra6bold"><?= $cuentasmay?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="10%">Asiento</td>
                                                    <td width="50%">Descripci&oacute;n</td>
                                                    <td width="10%" align="right">Debe</td>
                                                    <td width="10%" align="right">Haber</td>
                                                    <td width="10%" align="right">Saldo</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_cta);$i++) { ?>
                                                <tr class="letra6bold" style="background-color: <?= $cfg->getColor1()?>">
                                                    <td>Cuenta:</td>
                                                    <td><?= $a_cod[$i]?></td>
                                                    <td><?= $a_nom[$i]?></td>
                                                    <td align="right">$<?= number_format($a_deb[$i],2)?></td>
                                                    <td align="right">$<?= number_format($a_cre[$i],2)?></td>
                                                    <td align="right">$<?= number_format($a_sal[$i],2)?></td>
                                                </tr>
                                                <? for($m=0;$m<count($m_fec[$i]);$m++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($m_fec[$i][$m])?></td>
                                                    <td align="center"><?= $m_asi[$i][$m]?></td>
                                                    <td><?= $m_des[$i][$m]?></td>
                                                    <td align="right">$<?= number_format($m_ent[$i][$m],2)?></td>
                                                    <td align="right">$<?= number_format($m_sal[$i][$m],2)?></td>
                                                    <td align="right">$<?= number_format($m_sdo[$i][$m],2)?></td>
                                                </tr>
                                                <? } } ?>
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
