<?
/*
 * Creado el 25/03/2013 12:44:38
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: hps_kit_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/prv_saldos.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$proveedorsel=$glo->getGETPOST("proveedorsel");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$primero=$glo->getGETPOST("primero");
$tipo=$glo->getGETPOST("tipo");
$conceros=$glo->getGETPOST("conceros");
//if($tipo=="") $tipo=1;
if($fechafin=="")
    $fechafin=date("Y-m-d");
if($primero!="") {
    $inf=new saldo_proveedores($tipo, $conceros, $fechafin);
    $i_prv=$inf->getProveedor();
    $i_fac=$inf->getFacturas();
    $i_rec=$inf->getRecibos();
    $i_sal=$inf->getSaldo();
    $totalcompra=array_sum($i_fac);
    $totalpago=array_sum($i_rec);
    $saldofinal=$totalcompra-$totalpago;
} else {
    $i_prv=array();
    $totalcompra=0;
    $totalpago=0;
    $saldofinal=0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
        <input name="primero" type="hidden" id="primero" value="1" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">SALDO PROVEEDORES</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Tipo Proveedor                                             
                                            <select name="tipo" id="tipo">
                                                <?
                                                $array=array("Proveedores", "Proveedores Varios");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo, "Todos");
                                                ?>
                                            </select> | 
                                            Incluye Saldo en Cero <input type="checkbox" name="conceros" id="conceros" value="1" <? if($conceros==1) echo "checked='checked'"?> /> | 
                                            Fecha Final <input name="fechafin" id="fechafin" type="date" class="letra6" value="<?= $fechafin?>" /> | 

                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_prv_saldos.php'; document.form1.submit()" /> 
                                            <input type="submit" name="cmdprn" id="cmdOk" value="Imprime" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_prv_saldos_prn.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" class="letra6"  cellpadding="2" cellspacing="0">
                                                <tr class="letra6bold">
                                                    <td align="right">Totales&nbsp;</td>
                                                    <td align="right"><?= number_format($totalcompra,2)?></td>
                                                    <td align="right"><?= number_format($totalpago,2)?></td>
                                                    <td align="right"><?= number_format($saldofinal,2)?></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><hr></hr></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td width="40%">Proveedor</td>
                                                    <td width="10%" align="right">Compras</td>
                                                    <td width="10%" align="right">Pagos</td>
                                                    <td width="10%" align="right">Saldo</td>
                                                    <td width="30%">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($i_prv);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td><?= $i_prv[$i]?></td>
                                                    <td align="right"><?= number_format($i_fac[$i],2)?></td>
                                                    <td align="right"><?= number_format($i_rec[$i],2)?></td>
                                                    <td align="right"><?= number_format($i_sal[$i],2)?></td>
                                                    <td>&nbsp;</td>
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


