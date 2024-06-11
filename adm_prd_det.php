<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_det.php
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
$carteltarea="Detalle Articulos de Venta";
require_once 'clases/adm_prd.php';
$botoncap="Modificar!";
$adm=new adm_prd_1($id);
$id=$adm->getId();
$descripcion=$adm->getDescripcion();
$precioventa=$adm->getPrecioventa();
$estadoproductodes=$adm->getEstadoproductodes();
$unidad=$adm->getUnidad();
$unidadxanimal=$adm->getUnidadxanimal();
$kilosxanimal=$adm->getKilosxanimal();
$presentaciondes=$adm->getPresentaciondes();
$codigoproducto=$adm->getCodigoproducto();
$fechacreate=$adm->getFechacreate();
$fechamod=$adm->getFechamod();

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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_prd_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="45%" align="right">ID&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $id?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Descripcion&nbsp;</td>
                                        <td class="letra6bold"><?= $descripcion?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Rubro&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getRubrodes()?></td>
                                    </tr>
                  
                  
                                    <tr>
                                        <td align="right">Unidad&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getUnidaddes()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Unidad por Animal&nbsp;</td>
                                        <td class="letra6bold"><?= $unidadxanimal?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Kilos por Animal&nbsp;</td>
                                        <td class="letra6bold"><?= $kilosxanimal?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Presentacion&nbsp;</td>
                                        <td class="letra6bold"><?= $presentaciondes?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Codigo del Producto&nbsp;</td>
                                        <td class="letra6bold"><?= $codigoproducto?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Precio de Venta&nbsp;</td>
                                        <td class="letra6bold"><?= $precioventa?></td>
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
