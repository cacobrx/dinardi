<?
/*
 * Creado el 06/01/2018 14:02:30
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_caj_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_caj.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_caj order by nombre";
$adm=new adm_caj_2($ssql);
    
$a_id=$adm->getId();
$a_nom=$adm->getNombre();
$a_tip=$adm->getTipo();
$a_mon=$adm->getMonedapesos();
$cantidadtotal=$adm->getMaxRegistros();
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
<? include("estilos.php");?>
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limcaj" type="hidden" id="limcaj" value="<?= $limcaj?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
                <input name="detallecaj" id="detallecaj" type="hidden" value="<?= $detallecaj?>" />
                <input name="totalcaja" id="totalcaja" type="hidden" value="<?= $totalentrada-$totalsalida?>" />
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">CAJAS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>            
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_caj_prn.php'; document.form1.submit()" />                                                   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?>                                            
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellpadding="2" cellspacing="0" >                                                        
                                                        <tr class="letra6bold">
                                                            <td width="3%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.action='adm_caj_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Caja" title="Agregar Caja"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="20%" align="left">Nombre</td>
                                                            <td width="10%" align="center">Pesos</td>
                                                            <td width="10%" align="right">&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_caj_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Caja" title="Modifica Caja"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="left"><?= $a_nom[$i]?></td>
                                                            <td align="center">
                                                                <? if($a_mon[$i]==1) { ?>
                                                                <i class="far fa-check-circle fa-lg"></i>
                                                                <? } ?>
                                                            </td>
                                                            <td><div align="right"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Caja?','adm_caj_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Caja" title="Elimina Caja"></i></a></div></td>                      
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </td>
                                            </tr>                                            
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


