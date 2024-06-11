<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/envasados.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");

$vta=new envasados($fechaini, $fechafin);
$a_kil=$vta->getKilos();
$a_des=$vta->getDescripcion();
$a_can=$vta->getCantidad();

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
<script type="text/javascript" src="planb.js?1.0.2"></script>
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
    <tr>
        <? include("adm_menu.php") ?>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="0">
               <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>                                                         
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Informe de Articulos Envasados</h3>
                                <table width="100%" border="0" cellspacing="0" cellpadding="2">   
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechaini" id="fechaini" type="date" value="<?= $fechaini?>" class="letra6" /> 
                                            hasta <input name="fechafin" id="fechafin" type="date" value="<?= $fechafin?>" class="letra6" /> |                                          
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_envasados.php'; document.form1.submit()" />
                                            <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_envasados_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_envasados_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">                                           
                                                    <td width="10%" align="center">Cantidad</td>                                                    
                                                    <td align="left">Articulo</td>                                      
                                                    <td align="right">Kilos</td>                                                                                 
                                                </tr>
                                                    <? 
                                                    for($i=0;$i<count($a_can);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">                                     
                                                    <td align="center"><?= number_format($a_can[$i],0)?></td>
                                                    <td align="left"><?= $a_des[$i]?></td>
                                                    <td align="right"><?= number_format($a_kil[$i],2)?></td>                                                                                                  
                                                </tr>                                                                   
                                                 <?}?>
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
</form>
</div>
</body>
</html>