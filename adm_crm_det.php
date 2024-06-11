<?php
/*
 * Creado el 21/01/2019 20:57:59
 * Autor: gus
 * Archivo: adm_rem_det.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crm.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Detalle del Control Remito #$id";
$botoncap="Modificar";
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
$adm=new adm_crm_1($id);
$fecha=$adm->getFecha();
$idrem=$adm->getIdrem();
$horainicio=$adm->getHorainicio();
$horafin=$adm->getHorafin();
$observaciones=$adm->getObservaciones();
$d_producto=$adm->getDet_articulo();
$d_cantidad=$adm->getDet_cantidad();
$d_temperatura=$adm->getDet_temperatura();
$d_observaciones=$adm->getDet_observaciones();
$cantidaddet=count($d_cantidad);
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
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['required', 'only_on_submit']
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
<form name="form1" id="form1" action="adm_crm_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_crm_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Remito&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getRemito()?></td>
                                    </tr>                 

                                    <tr>
                                        <td align="right">Hora Inicio&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getHorainicio()?></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Hora Fin&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getHorafin()?></td>
                                    </tr>                                    
                  
                                    <tr>
                                        <td align="right">Responsable&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getResponsable()?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td align="left">Producto</td>                                                           
                                                            <td align="center">Cantidad</td>                                                         
                                                            <td align="center">Temperatura</td>
                                                            <td>Observaciones</td>                               
                                                        </tr>

                                                        <? for($i=0;$i<count($d_cantidad);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="left"><?= $d_producto[$i]?></td>                                                                                        
                                                            <td align="center"><?= $d_cantidad[$i]?></td>                                                          
                                                            <td align="center"><?= $d_temperatura[$i]?></td>                        
                                                            <td align="left"><?= $d_observaciones[$i]?></td>                                   
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
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
<script>
