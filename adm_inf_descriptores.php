<?php
/*
 * creado el 20 may. 2021 10:58:57
 * Usuario: gus
 * Archivo: adm_inf_descriptores
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_com_det.php';
$aud = new registra_auditoria();
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$primero=$glo->getGETPOST("primero");
if($primero==1) {
    $ssql="select adm_com_det.*, adm_com.fecha, adm_com.ptovta, adm_com.numero from adm_com_det, adm_com where adm_com.fecha>='$fechainides' and adm_com.fecha<='$fechafindes' and adm_com_det.idcom=adm_com.id";
    $condicion="";
    if($descriptor1des>0)
        $condicion.="adm_com_det.descriptor1=$descriptor1des and ";
    if($descriptor2des>0)
        $condicion.="adm_com_det.descriptor2=$descriptor2des and ";
    if($descriptor3des>0)
        $condicion.="adm_com_det.descriptor3=$descriptor3des and ";
    if($descriptor4des>0)
        $condicion.="adm_com_det.descriptor4=$descriptor4des and ";
//    echo "textodes: $textodes\n";
    if($textodes!="") {
        $sxxx="select * from adm_clasif where instr(upper(texto),'".strtoupper($textodes)."')>0";
//        echo "aa: ".$sxxx."\n";
        $rx=$conx->getConsulta($sxxx);
        $condiciondes="";
        while($rxx=mysqli_fetch_object($rx)) {
            $condiciondes.="adm_com_det.descriptor1=".$rxx->id." or adm_com_det.descriptor2=".$rxx->id." or adm_com_det.descriptor3=".$rxx->id." or adm_com_det.descriptor4=".$rxx->id." or ";
        }
//        echo $condiciondes."\n";
        if($condiciondes!="") {
            $condiciondes="(".substr($condiciondes, 0, strlen($condiciondes)-4).")";
            $condicion.=$condiciondes." and ";
        }
        
    }
    if($condicion!="") $condicion=" and ".substr($condicion,0,strlen($condicion)-5);
    $ssql.=$condicion;
//    echo $ssql."\n";
    $adm=new adm_com_det_2_com($ssql);
    $a_id=$adm->getId();
    $a_fec=$adm->getFecha();
    $a_imp=$adm->getImporte();
    $a_des=$adm->getDetalle();
    $a_d1=$adm->getDescriptor1des();
    $a_d2=$adm->getDescriptor2des();
    $a_d3=$adm->getDescriptor3des();
    $a_d4=$adm->getDescriptor4des();
    $a_com=$adm->getComprobante();
} else
    $a_imp=array();
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
<? require_once 'estilos.php'?>        

</head>
<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="primero" id="primero" type="hidden" value="1" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Informe de Descriptores</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainides" type="date" class="letra6" id="fechainides" value="<?= $fechainides?>" /> 
                                            hasta <input name="fechafindes" type="date" class="letra6" id="fechafindes" value="<?= $fechafindes?>" /> | 
                                            Texto <input name="textodes" id="textodes" type="text" size="20" value="<?= $textodes?>" />
                                    </tr>
                                    <tr>
                                        <td>
                                            Descriptores 
                                            <select name="descriptor1des" id="descriptor1des" onchange="javascript: cargades2v(this.value, 'descriptor', 'des')">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor1des, "Todos");
                                                ?>
                                            </select> | 
                                            <select name="descriptor2des" id="descriptor2des" onchange="javascript: cargades3v(this.value, 'descriptor', 'des')">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=$descriptor1des order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor2des, "Todos");
                                                ?>
                                            </select> | 
                                            <select name="descriptor3des" id="descriptor3des" onchange="javascript: cargades4v(this.value, 'descriptor', 'des')">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=$descriptor2des order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor3des, "Todos");
                                                ?>
                                            </select> | 
                                            <select name="descriptor4des" id="descriptor4des">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=$descriptor3des order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor4des, "Todos");
                                                ?>
                                            </select>                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='register_des.php'; document.form1.submit()" />
                                            <input name="cmdPrint" id="cmdPrint" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_descriptores_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_descriptores_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">
                                            <span class="letra6">Total: </span><?= number_format(array_sum($a_imp),2)?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="10%" align="center">Compra</td>
                                                    <td align="left">Detalle</td>
                                                    <td align="left">Descriptores</td>
                                                    <td width="10%" align="right">Importe</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_imp);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="center"><?= $a_com[$i]?></td>
                                                    <td align="left"><?= $a_des[$i]?></td>
                                                    <td align="left"><?= $a_d1[$i]." /".$a_d2[$i]." /".$a_d3[$i]." /".$a_d4[$i]?></td>
                                                    <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                </tr>                                                
                                                <? } ?>
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


