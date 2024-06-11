<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_det.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Detalle Movimiento de Caja";
require_once 'clases/adm_mov_caja.php';
$botoncap="Modificar!";
$adm=new adm_mov_caja_1($id);
$id=$adm->getId();
$fecha=$adm->getFecha();
$detalle=$adm->getDetalle();
$importe=abs($adm->getImporte());
$tipocaja=$adm->getTipocaja();
$idmov=$adm->getIdmov();
$tipomov=$adm->getTipomov();
$descriptor1=$adm->getDescriptor1();
$descriptor2=$adm->getDescriptor2();
$descriptor3=$adm->getDescriptor3();
$descriptor4=$adm->getDescriptor4();
$segmento1=$adm->getSegmento1();
$segmento2=$adm->getSegmento2();
$segmento3=$adm->getSegmento3();
$segmento4=$adm->getSegmento4();
$oficina=$adm->getOficina();
$tipomov=$adm->getTipomov();
$tipopago=$adm->getTipopago();

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
<script language="JavaScript" src="scw.js"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	fecha: ['required', 'only_on_submit']
}
</script>
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
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_mov_caja_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td class="letra6bold"><?= date("d/m/Y", strtotime($adm->getFecha()))?></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="20%" align="right">Detalle&nbsp;</td>
                                        <td width="80%" class="letra6bold"><?= $adm->getDetalle()?></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td class="letra6bold"><?= number_format($adm->getImporte(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Caja&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getTipocajades()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Medio de Pago&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getTipopagodes()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getTipomovdes()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Descriptores&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getDescriptor1des()." | ".$adm->getDescriptor2des()." | ".$adm->getDescriptor3des()." | ".$adm->getDescriptor4des()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Oficina&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getOficinades()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Indice&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getIndice()?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</div>
</body>
</html>
