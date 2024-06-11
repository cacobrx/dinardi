<?php
/*
 * creado el 4 abr. 2022 12:21:51
 * Usuario: gus
 * Archivo: consulta_afip
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';

$aud = new registra_auditoria();
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$ptovta=$cfg->getFiscalpuntoventa();
$nro=$glo->getGETPOST("nro");
$cuit=$cfg->getFiscalcuit();
$tipocom=$glo->getGETPOST("tipocom");
if($nro!="") {
    $url=$cfg->getServidorafip()."/consulta_afip.php?tipocom=$tipocom&nro=$nro&cuit=$cuit&ptovta=$ptovta";
    $resp= json_decode(file_get_contents($url));
    
//    print_r($resp);
    if($resp!="") {
        $ssql="select * from adm_cli where cuit='".$resp->DocNro."'";
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $cliente=$reg->apellido;
    }
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
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="consulta_afip.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CONSULTA COMPROBANTES FISCALES</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td width="35%" align="right">CUIT&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $cuit?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Comprobante&nbsp;</td>
                                        <td>
                                            <select name="tipocom" id="tipocom">
                                                <?
                                                $array=array("Factura", "N.Débito", "N.Crédito", "Factura CE", "N.Débito CE", "N.Crédito CE");
                                                $avalor=array(1,2,3,201,202,203);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipocom, "Sel.");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Punto de Venta&nbsp;</td>
                                        <td class="letra6bold"><?= $ptovta?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número&nbsp;</td>
                                        <td ><input name="nro" type="text" id="nro" size="8" maxlength="8" value="<?= $nro?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="Consultar" />
                                        </td>
                                    </tr>
                                    <? if($nro and $resp!="">0) { ?>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo Documento&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->DocTipo?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número Documento&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->DocNro?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Cliente&nbsp;</td>
                                        <td class="letra6bold"><?= $cliente?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha de Comprobante&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->CbteFch?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Número de Comprobante&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->CbteDesde?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe Total&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->ImpTotal?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe Neto&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->ImpNeto?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe IVA&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->ImpIVA?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe Tributo&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->ImpTrib?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Cod.Autorización&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->CodAutorizacion?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Vencimiento&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->FchVto?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Punto de Venta&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->PtoVta?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo de Comprobante&nbsp;</td>
                                        <td class="letra6bold"><?= $resp->CbteTipo?></td>
                                    </tr>
                                    <? } ?>
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
