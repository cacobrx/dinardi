<?php
/*
 * creado el 16 ago. 2023 16:21:05
 * Usuario: gus
 * Archivo: adm_rem_det_main
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/seleccion.php';
require_once 'clases/adm_rem.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select adm_rem_det.*, adm_rem.fecha, adm_prv.paises, adm_rem.certificado from adm_rem_det inner join adm_rem on adm_rem_det.idrem=adm_rem.id inner join adm_prv on adm_rem.idprv=adm_prv.id";
$ssql.=" where adm_rem.fecha>='$fechainiinf' and adm_rem.fecha<='$fechafininf'";
if($paisinf>0) $ssql.=" and instr(adm_prv.paises,'|".$paisinf."|')>0";
$a_art=explode("|",$articulosselinf);
$condicionart="";
// print_r($a_art);
for($i=0;$i<count($a_art);$i++) {
    if($a_art[$i]>0)
        $condicionart.="adm_rem_det.idart=".$a_art[$i]." or ";
}
if($condicionart!="") $condicionart=" and (".substr($condicionart,0,strlen($condicionart)-4).")";
$ssql.=$condicionart;
// echo $ssql."<br>";

$adm=new adm_rem_det($ssql);
$a_idart=$adm->getIdart();
$a_art=$adm->getArticulo();
$a_pai=$adm->getPais();
$a_fec=$adm->getFecha();
$a_cer=$adm->getCertificado();
$a_kil=$adm->getKilos();
$aic=new articulossel($articulosselinf);
$cadenaart=$aic->getCadena();

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
                                <h3 class="ui-widget-header ui-corner-all">Informe de Trazabilidad</h3>
                                <table width="100%" border="0" cellspacing="0" cellpadding="2">   
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainiinf" id="fechainiinf" type="date" value="<?= $fechainiinf?>" class="letra6" /> 
                                            hasta <input name="fechafininf" id="fechafininf" type="date" value="<?= $fechafininf?>" class="letra6" /> |                                          
                                            País <select name="paisinf" id="paisinf">
                                                <?
                                                    $ssql="select valor as id, descripcion as campo from tablas where codtab='PAI' order by descripcion";
                                                    $sup->cargaCombo3($ssql, $paisinf, "Todos");
                                                ?>
                                            </select>
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='register_inf.php'; document.form1.submit()" />
                                            <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_rem_det_main_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_rem_det_main_exp.php'; document.form1.submit()" /> | 
                                            Total <strong><?= number_format(array_sum($a_kil),2)?></strong>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td>
                                            <a><button name="cmdprod" id="cmdprod" onclick="javascript: document.form1.target='_self'; document.form1.action='selproductos.php'; document.form1.submit()">Productos</button></a> <span class="letra6bold"><?= $cadenaart?></span>
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
                                                    <td align="center">Fecha</td>                                                                                 
                                                    <td align="left">Certificado</td>                                                                                 
                                                    <td align="left">Articulo</td>                                      
                                                    <td align="left">País</td>                                      
                                                    <td align="center">Kilos</td>                                      
                                                </tr>
                                                <? 
                                                for($i=0;$i<count($a_fec);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">                                     
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="left"><?= $a_cer[$i]?></td>
                                                    <td align="left"><?= $a_art[$i]?></td>
                                                    <td align="left"><?= $a_pai[$i]?></td>                                                                                                  
                                                    <td align="center"><?= $a_kil[$i]?></td>                                                                                                  
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
    <tr>
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
