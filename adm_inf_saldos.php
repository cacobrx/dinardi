<?php
/*
 * creado el 27/08/2017 17:44:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_inf_saldos
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/informes.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$clienteselcta=$glo->getGETPOST("clienteselcta");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$primero=$glo->getGETPOST("primero");
$versaldocero=$glo->getGETPOST("versaldocero");
if($versaldocero=="")
    $versaldocero=0;
if($fechafin=="")
    $fechafin=date("Y-m-d");
if($primero!="") {
    $inf=new saldo_clientes($fechaini, $fechafin, $centrosel, $versaldocero);
    $i_prv=$inf->getCliente();
    $i_ped=$inf->getPedidos();
    $i_rec=$inf->getRecibos();
    $i_sal=$inf->getSaldo();
    $i_ini=$inf->getInicial();
    $i_tel=$inf->getTelefono();
    $i_idcli=$inf->getIdcli();
    //print_r($i_idcli);
    $totalpedido=array_sum($i_ped);
    $totalrecibo=array_sum($i_rec);
    $totalinicial=array_sum($i_ini);
    $saldofinal=$totalinicial + $totalpedido - $totalrecibo;
    $totaldebe=0;
    $totalhaber=0;
    for($i=0;$i<count($i_sal);$i++) {
        if($i_sal[$i]<0)
            $totaldebe+=$i_sal[$i];
        else
            $totalhaber+=$i_sal[$i];
    }
    
} else {
    $i_prv=array();
    $totalpedido=0;
    $totalrecibo=0;
    $saldofinal=0;
    $totaldebe=0;
    $totalhaber=0;
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
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<?require_once 'estilos.php'; ?>
</head>
<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="adm_inf_saldos.php" method="post" target="_self">
        <tr>
            <? include("adm_menu.php") ?>
            <input name="id" type="hidden" id="id" value="0" />
            <input name="primero" type="hidden" id="primero" value="1" />
            <input name="idcli" type="hidden" id="idcli" />
            <input name="url" type="hidden" id="url" value="adm_cli_saldos.php" />
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <?require_once 'displayusuario.php';?>
                    <tr>
                        <td>
                            <div class="panel960 letra6">
                                <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                    <h3 class="ui-widget-header ui-corner-all">SALDOS DE CLIENTES</h3>                
                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                        <tr>
                                          <td>
                                              Fecha <input name="fechaini" id="fechaini" type="hidden" value="<?= $fechaini?>" />hasta <input name="fechafin" id="fechafin" type="date" value="<?= $fechafin?>" class="letra6" /> 
                                                  Ver Saldo Cero <input name="versaldocero" id="versaldocero" value="1" type="checkbox" <? if($versaldocero==1) echo "checked='checked'"; ?> />
                                          <input type="submit" name="cmdOk" id="cmdOk" value="Procesar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_saldos.php'; document.form1.submit()" /> 
                                          <input name="cmdPrint" id="cmdPrint" value="Imprimir" type="submit" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_saldos_prn.php'; document.form1.submit()" />  
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                          <table width="100%" border="0" class="letra6" rules="none" bordercolor="<?= $cfg->getColor2()?>">
                                              <tr bgcolor="<?= $cfg->getColor1()?>" class="letra6bold">
                                              <td align="right">&nbsp;</td>
                                              <td align="right">Totales&nbsp;</td>
                                              <td align="right"><?= number_format($totaldebe,2)?></td>
                                              <td align="right"><?= number_format($totalhaber,2)?></td>
                                              <td align="right"><?= number_format($totaldebe+$totalhaber,2)?></td>
                                            </tr>
                                            <tr class="letra6bold">
                                              <td width="40%">Cliente</td>
                                              <td width="30%" align="left">Telefono</td>
                                              <td width="10%" align="right">Debe</td>
                                              <td width="10%" align="right">Haber</td>
                                              <td width="10%">&nbsp;</td>
                                            </tr>
                                            <? for($i=0;$i<count($i_prv);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.idcli.value=<?= $i_idcli[$i]?>; document.form1.action='adm_inf_ctacte.php'; document.form1.submit()"><img src="images/lupa.png" border="0" title="Ver Cuenta Corriente" title="Ver Cuenta Corriente" /></a><?= $i_prv[$i]?></td>
                                                    <td align="left"><?= $i_tel[$i]?></td>
                                                    <td align="right"><?
                                                        if($i_sal[$i]<0)
                                                            echo number_format($i_sal[$i],2)?>
                                                        </td>
                                                    <td align="right"><?
                                                        if($i_sal[$i]>=0)
                                                            echo number_format($i_sal[$i],2)?>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            <? } ?>
                                          </table></td>
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

