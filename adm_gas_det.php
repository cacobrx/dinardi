<?
/*
 * Creado el 07/07/2020 13:24:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas_det.php
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
$carteltarea="Detalle GASTOS";
require_once 'clases/adm_gas.php';
$botoncap="Modificar!";
$adm=new adm_gas_1($id);
$id=$adm->getId();
$fecha=$adm->getFecha();
$idprv=$adm->getIdprv();
$detalle=$adm->getDetalle();
$importe=$adm->getImporte();
$fechaven=$adm->getFechaven();
$descriptor1=$adm->getDescriptor1();
$descriptor2=$adm->getDescriptor2();
$descriptor3=$adm->getDescriptor3();
$descriptor4=$adm->getDescriptor4();

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
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_gas_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">ID&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $id?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td class="letra6bold"><?= $fecha?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Idprv&nbsp;</td>
                                        <td class="letra6bold"><?= $idprv?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Detalle&nbsp;</td>
                                        <td class="letra6bold"><?= $detalle?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td class="letra6bold"><?= $importe?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Fechaven&nbsp;</td>
                                        <td class="letra6bold"><?= $fechaven?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Descriptor 1&nbsp;</td>
                                        <td class="letra6bold"><?= $descriptor1?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Descriptor 2&nbsp;</td>
                                        <td class="letra6bold"><?= $descriptor2?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Descriptor 3&nbsp;</td>
                                        <td class="letra6bold"><?= $descriptor3?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Descriptor 4&nbsp;</td>
                                        <td class="letra6bold"><?= $descriptor4?></td>
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
