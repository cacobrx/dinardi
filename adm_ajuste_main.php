<?php
/*
 * Creado el 28/06/2019 19:38:16
 * Autor: gus
 * Archivo: adm_ajuste_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'informes/ajuste.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primeroajuste=$glo->getGETPOST("primeroajuste");
if($primeroajuste==1) {
    $adm=new ajusteinflacion($fechainiaju, $fechafinaju);
    $a_per=$adm->getAnomes();
    $a_cod=$adm->getCodigo();
    $a_nom=$adm->getNombre();
    $a_impd=$adm->getImportedebe();
    $a_imph=$adm->getImportehaber();
    $a_coefm=$adm->getCoeficientemes();
    $a_coefc=$adm->getCoeficientecierre();
    $a_coeff=$adm->getCoeficientefin();
    $a_impr=$adm->getImportereexp();
    $a_reex=$adm->getReexpresion();
    $cantidadtotal=count($a_cod);
} else {
    $a_per=array();
    $cantidadtotal=0;
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
        /*visibility: hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:2;
	margin-left: -480px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
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
        <input name="id" type="hidden" id="id" value="0" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="limaju" type="hidden" id="limaju" value="<?= $limaju?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="primeroajuste" type="hidden" id="primeroajuste" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />      
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">                                
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">                                    
                                <h3 class="ui-widget-header ui-corner-all">AJUSTE POR INFLACIÓN</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>                                            
                                            Fecha desde <input name="fechainiaju" id="fechainiaju" type="date" class="letra6" value="<?= $fechainiaju?>" /> 
                                            hasta <input name="fechafinaju" id="fechafinaju" type="date" class="letra6" value="<?= $fechafinaju ?>" /> | 
                                            <input name="cmdok" type="submit" value="Buscar" onclick="javascript: document.form1.target='_self'; document.form1.primeroajuste.value=1; document.form1.limaju.value=0; document.form1.action='register_aju.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdprn" id="cmdprn" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_ajuste_prn.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                            <span class="letra6">Cantidad: </span><?= $cantidadtotal?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="8%" align="center">Período</td>
                                                    <td width="8%" align="left">Cuenta</td>
                                                    <td align="left">Nombre</td>
                                                    <td width="10%" align="right">Debe</td>
                                                    <td width="10%" align="right">Haber</td>
                                                    <td width="8%" align="right">Coef.Mes</td>
                                                    <td width="8%" align="right">Coef.Cierre</td>                                       
                                                    <td width="8%" align="right">Coef.Final</td>                                       
                                                    <td width="10%" align="right">Imp.Reexp</td>                                       
                                                    <td width="10%" align="right">Reexpresión</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_per);$i++) { 
                                                    $xc=$a_cod[$i];
                                                    $ttd=0;
                                                    $tth=0;
                                                    $ttr1=0;
                                                    $ttr2=0;
                                                    while($xc==$a_cod[$i]) {
                                                        $ttd+=$a_impd[$i];
                                                        $tth+=$a_imph[$i];
                                                        $ttr1+=$a_impr[$i];
                                                        $ttr2+=$a_reex[$i];
                                                    ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= substr($a_per[$i],4,2)."/".substr($a_per[$i],0,4)?></td>
                                                    <td align="left"><?= $a_cod[$i]?></td>
                                                    <td align="left"><?= $a_nom[$i]?></td>
                                                    <td align="right"><?= number_format($a_impd[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_imph[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_coefm[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_coefc[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_coeff[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_impr[$i],2)?></td>
                                                    <td align="right"><?= number_format($a_reex[$i],2)?></td>
                                                </tr>
                                                <? 
                                                $j=$i+1;
                                                if($j>=count($a_cod)) break;
                                                
                                                $i++;
                                                    } ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra6bold">
                                                    <td colspan="3">Total</td>
                                                    <td align="right"><?= number_format($ttd,2)?></td>
                                                    <td align="right"><?= number_format($tth,2)?></td>
                                                    <td align="right">&nbsp;</td>
                                                    <td align="right">&nbsp;</td>
                                                    <td align="right">&nbsp;</td>
                                                    <td align="right"><?= number_format($ttr1,2)?></td>
                                                    <td align="right"><?= number_format($ttr2,2)?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="10"><hr></hr></td>
                                                </tr>
                                                <?
                                                } ?>
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