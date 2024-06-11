<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cmp_act.php
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_com.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$id=$glo->getGETPOST("id");
$carteltarea="Detalle Compra";
$botoncap="Modificar!";
$adm=new adm_com_1($id);
$id=$adm->getId();

$r_id=$adm->getRem_id();
$r_fec=$adm->getRem_fecha();
$r_neto0=$adm->getRem_neto0();
$r_neto10=$adm->getRem_neto10();
$r_neto21=$adm->getRem_neto21();
$r_iva10=$adm->getRem_iva10();
$r_iva21=$adm->getRem_iva21();
$r_tot=$adm->getRem_total();

//$ssql="select * from adm_cmp_imp where idcmp=$id";
////echo $ssql;
//$imp=new adm_cmp_imp_2($ssql);
//$i_des=$imp->getDescripcion();
//$i_cta=$imp->getCuentades();
//$i_imp=$imp->getImporte();
//$canti=count($i_des);

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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<?require_once 'estilos.php';?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr >
    <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
    </tr>
    <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="letra6">
            <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                    <tr>
                                        <td><a href="javascript: document.form1.action='adm_com_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver" /></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                                <tr>
                                                    <td width="15%">Comprobante</td>
                                                    <td width="10%">Fecha</td>
                                                    <td width="10%">Vencimiento</td>
                                                    <td width="10%">F.Imputación</td>
                                                    <td width="30%">Proveedor</td>

                                                    <td width="10%" align="right">Total</td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td><?= $adm->getTipocomdes()." ".$adm->getLetra()."-".$adm->getPtovta()."-".$adm->getNumero()?></td>
                                                    <td><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                                    <td><?= $dsup->getFechaNormalCorta($adm->getFechaven())?></td>
                                                    <td><?= $dsup->getFechaNormalCorta($adm->getFechaimputacion())?></td>
                                                    <td><?= $adm->getProveedor()?></td>

                                                    <td align="right"><?= number_format($adm->getTotaltotal(),2)?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td><hr></td></tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0">
                                                <tr>
                                                    <td width="16%">Neto 21%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getNeto21(),2)?></td>
                                                    <td width="16%">Iva 21%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getiva21(),2)?></td>
                                                    <td width="16%">Perc.Iva&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getPeriva(),2)?></td>
                                                </tr>
                                                <tr>
                                                    <td width="16%">Neto 10.5%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getNeto10(),2)?></td>
                                                    <td width="16%">Iva 10.5%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getiva10(),2)?></td>
                                                    <td width="16%">Ret.Iva&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getRetiva(),2)?></td>
                                                </tr>
                                                <tr>
                                                    <td width="16%">Neto 27%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getNeto27(),2)?></td>
                                                    <td width="16%">Iva 27%&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getiva27(),2)?></td>
                                                    <td width="16%">Perc.IIBB&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getPerretiibb(),2)?></td>
                                                </tr>
                                                <tr>
                                                    <td width="16%">Exento&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getExento(),2)?></td>
                                                    <td width="16%">&nbsp;</td>
                                                    <td width="16%">&nbsp;</td>
                                                    <td width="16%">Impuestos Varios</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getImpinternos(),2)?></td>
                                                </tr>
                                                <tr>
                                                    <td width="16%">No Gravado&nbsp;</td>
                                                    <td width="16%" class="letra6bold"><?= number_format($adm->getNogravado(),2)?></td>
                                                    <td width="16%">&nbsp;</td>
                                                    <td width="16%">&nbsp;</td>
                                                    <td width="16%">&nbsp;</td>
                                                    <td width="16%">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td><hr></td></tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr>
                                                    <td colspan="10" class="ui-widget-header ui-corner-all" align="center">Remitos</td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td width="5%" align="center">ID</td>
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="10%" align="right">No Gravado</td>
                                                    <td width="10%" align="right">Neto 10.5%</td>
                                                    <td width="10%" align="right">Neto 21%</td>
                                                    <td width="10%" align="right">IVA 10.5%</td>
                                                    <td width="10%" align="right">IVA 21%</td>
                                                    <td width="10%" align="right">Total</td>
                                                </tr>
                                                <? for($i=0;$i<count($r_id);$i++) { 
                                                    $cancela="cancela$i";
                                                    $$cancela=$glo->getGETPOST($cancela);
                                                    ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center">
                                                        <?= $r_id[$i]?>
                                                    </td>
                                                    <td align="center"><?= date("d/m/Y", strtotime($r_fec[$i]))?></td>
                                                    <td align="right"><?= number_format($r_neto0[$i],2)?></td>
                                                    <td align="right"><?= number_format($r_neto10[$i],2)?></td>
                                                    <td align="right"><?= number_format($r_neto21[$i],2)?></td>
                                                    <td align="right"><?= number_format($r_iva10[$i],2)?></td>
                                                    <td align="right"><?= number_format($r_iva21[$i],2)?></td>
                                                    <td align="right"><?= number_format($r_tot[$i],2)?></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <? } ?>
                                            </table>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Usuario <span class="letra6bold"><?= $adm->getUsuarionom()?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha y hora registro <span class="letra6bold"><?= $adm->getFechacreate()?></span></td>
                                    </tr>
                                    

                                    <tr>
                                        <td>&nbsp;</td>
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
