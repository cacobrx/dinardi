<?php
/*
 * creado el 20 may. 2021 13:50:14
 * Usuario: gus
 * Archivo: adm_inf_eco_mensual
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';
require_once 'planb_def.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");
$anoeco=$glo->getGETPOST("anoeco");
$meseco=$glo->getGETPOST("meseco");
$civa=$glo->getGETPOST("civa");
if($civa=="") $civa=0;
if($meseco=="") $meseco=date("m");
if($anoeco=="") $anoeco=date("Y");
if($primero==1) {
    $fechaini=$anoeco."-".$meseco."-01";
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    $adm=new informe5($fechaini, $fechafin, $civa);
    $a_cta=$adm->getCodigo();
    $a_id=$adm->getId();
    $a_nom=$adm->getNombre();
    $a_deb=$adm->getDebitos();
    $a_cre=$adm->getCreditos();
    $a_let=$adm->getLetra();
    $a_esp=$adm->getEspacios();
    $a_sal=$adm->getSaldo();
    $a_stt=$adm->getSubtotal();
    $a_nivel=array();
//    asort($a_cta);
//    print_r($a_esp);
    
    
    $a_vvv=array();
    for($i=0;$i<count($a_cta);$i++) {
        $niv=strlen($a_cta[$i])/3;
        array_push($a_nivel,strlen($a_cta[$i])/3);
        $total=$a_sal[$i];
        if($total=="") $total=0;
    }
    
} else
    $a_cta=array();

//echo "plan: ".$est->getCantplan()."<br>";
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
<? require_once "estilos.php" ?>;
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
        <input name="primero" id="primero" type="hidden" vale="1" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CUENTA ECONÓMICA MENSUAL</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Año <input name="anoeco" id="anoeco" type="text" onkeypress="return validar(event)" style="text-align: center" size="4" maxlength="4" value="<?= $anoeco?>" /> | 
                                            Mes <select name="meseco" id="meseco">
                                                <?
                                                $sup->cargaComboArrayValor($meses, $numeromeses, $meseco);
                                                ?>
                                            </select>
                                            Incluir importe CERO <input name="ceroseco" id="ceroseco" type="checkbox" value="1" <? if($ceroseco==1) echo "checked='checked'";?> /> | 
                                            Incluir Impuestos <input name="civa" id="civa" type="checkbox" value="1" <? if($civa==1) echo "checked='checked'";?> /> | 
                                            <input name="cmdok" type="submit" value="Obtener Informe" onclick="javascript: document.form1.target='_self'; document.form1.primero.value=1; document.form1.action='adm_inf_eco_mensual.php'; document.form1.submit()" /> 
                                            <input name="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_eco_mensual_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_eco_mensual_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td>Cuenta</td>
                                                    <td width="6%" align="right">Total</td>
                                                </tr>
                                                <?
                                                $cad="";
                                                $tote=0;
                                                $tots=0;
                                                for($i=0;$i<count($a_cta);$i++) { 
                                                    if($a_sal[$i]!=0 or $ceroseco==1) {
                                                        $cad.=$a_nom[$i]."|".$a_sal[$i]."|".$a_esp[$i]."@";
                                                        if($a_sal[$i]>0 and strlen($a_cta[$i])==3) $tote+=$a_sal[$i];
                                                        if($a_sal[$i]<0 and strlen($a_cta[$i])==3) $tots+=$a_sal[$i];
                                                        $ccc="black";
                                                        switch ($a_nivel[$i]){
                                                            case 1:
                                                                $ccc=$cfg->getColordescriptor1();
                                                                break;
                                                            case 2:
                                                                $ccc=$cfg->getColordescriptor2();
                                                                break;
                                                            case 3:
                                                                $ccc=$cfg->getColordescriptor3();
                                                                break;
                                                            case 4:
                                                                $ccc=$cfg->getColordescriptor4();
                                                                break;
                                                        }
                                                    ?>
                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccc?>">
                                                        <td align="left"><?=  str_repeat('&nbsp;', strlen($a_cta[$i]))." ".$a_nom[$i]?></td>
                                                        <td align="right"><?= number_format($a_sal[$i],2)?></td>
                                                    </tr>
                                                <? } }
                                                if($cad!="") $cad=substr($cad,0,strlen($cad)-1);
                                                ?>
                                                <tr>
                                                    <td colspan="14"><hr></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>Entradas</td>
                                                    <td align="right"><?= number_format($tote,2)?></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>Salidas</td>
                                                    <td align="right"><?= number_format($tots,2)?></td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td>TOTALES</td>
                                                    <td align="right"><?= number_format($tote+$tots,2)?></td>
                                                </tr>
                                                
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
        <td>&nbsp;<input name="cad" id="cad" type="hidden" value="<?= $cad?>" /></td>
    </tr>
</form>
</div>
</body>
</html>
