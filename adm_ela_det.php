<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela_det.php
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

$carteltarea="Modifica Elaboracion";
require_once 'clases/adm_ela.php';
$botoncap="Modificar!";
$adm=new adm_ela_1($id);
$id=$adm->getId();
$fecha=$adm->getFecha();
$turno=$adm->getTurnodes();
$horaing=$adm->getHoraing();
$horaegr=$adm->getHoraegr();
$empleados=$adm->getEmpleados();
$observacion1=$adm->getObservacion1();
$observacion2=$adm->getObservacion2();
$a_art=$adm->getDet_articulo();
$a_prv=$adm->getPrv_proveedor();
$a_kgd=$adm->getDet_kgdescarte();
$a_fec=$adm->getDet_fechaing();
$a_kgf=$adm->getDet_kilos();
$telaborado1=$adm->getTelaborado1();
$telaborado2=$adm->getTelaborado2();
$telaborado3=$adm->getTelaborado3();
//print_r($a_prv);


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
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_ela_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Turno&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $turno?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Hora ingreso / fin&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getHoraing()." / ".$adm->getHoraegr()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Hora ingreso / fin&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getHoraing1()." / ".$adm->getHoraegr1()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Empleados&nbsp;</td>
                                        <td class="letra6bold"><?= $empleados?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Observaciones 1&nbsp;</td>
                                        <td class="letra6bold"><?= $observacion1?></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Temperatura de Elaboración&nbsp;</td>
                                        <td class="letra6bold">
                                            <? 
                                            if(trim($telaborado1)!="") echo "<br>".$telaborado1."C°";
                                            if(trim($telaborado2)!="") echo "<br>".$telaborado2."C°";
                                            if(trim($telaborado3)!="") echo "<br>".$telaborado3."C°";
                                            ?>
                                        </td>
                                    </tr>                                    
                                    
                                    <tr>
                                        <td align="right">Observaciones&nbsp;</td>
                                        <td class="letra6bold"><?= $observacion2?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td  align="center" width="10%">Fecha</td>
                                                            <td>Proveedor</td>
                                                            <td align="left" width="20%">Producto</td>
                                                            <td align="right" width="10%">Kg Descarte</td>
                                                            <td align="right" width="10%">Kg Final</td>
                                                        </tr>
                                                        <? for($i=0;$i<count($a_art);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left">
                                                                <?
                                                                for($p=0;$p<count($a_prv[$i]);$p++) {
                                                                    echo $a_prv[$i][$p]." / ";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="left"><?= $a_art[$i]?></td>
                                                            <td align="right"><?= $a_kgd[$i]?></td>
                                                            <td align="right"><?= $a_kgf[$i]?></td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                            <td colspan="5"><hr></hr></td>
                                                        </tr>
                                                        <tr class="letra6bold">
                                                            <td>Total</td>
                                                            <td colspan="3">&nbsp;</td>
                                                            <td align="right"><?= number_format(array_sum($a_kgf),2)?></td>
                                                        </tr>
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
