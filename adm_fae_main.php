<?php
/*
 * Creado el 25/01/2019 16:50:28
 * Autor: gus
 * Archivo: adm_fae_main.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crm.php';
require_once 'clases/adm_rem.php';
require_once 'clases/adm_prv_pre.php';
$dsup = new datesupport();
$conx=new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$botoncap="Actualizar";
$fecha=date("Y-m-d");
$idcrm=$glo->getGETPOST("idcrm");
if($idcrm=="") $idcrm=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
$calculoprecio=$glo->getGETPOST("calculoprecio");
$urlvolver=$glo->getGETPOST("urlvolver");
if($urlvolver=="") $urlvolver="adm_fae_main.php";
if($cantidaddet=="") $cantidaddet=0;
//$ssql="select * from adm_crm where idfae=0 and faena=1 order by fecha, id";
//
//$rem=new adm_crm_2($ssql);
//$r_id=$rem->getId();
//$r_det=$rem->getRemito();
//$d_pes=array();
if($idcrm>0) {
    //echo "paso1\n";
    $adm=new adm_crm_1($idcrm);
    $d_art=$adm->getFae_articulo();
    $d_ida=$adm->getFae_idart();
    $d_pes=$adm->getFae_peso();
    $d_pre=$adm->getFae_precio();
    $d_pre1=$adm->getFae_precio1();
    $d_pre2=$adm->getFae_precio2();
    $d_tot=$adm->getFae_total();
    $calculoprecio=1;
//    $d_pre=array();
//    $d_tot=array();
//    $d_pre1=array();
//    $d_pre2=array();
//    $rem=new adm_rem_1($adm->getIdrem());
//    $conn=$conx->conectarBase();
//    for($d=0;$d<count($d_art);$d++) {
//        $ppp=new adm_prv_pre_1($rem->getIdprv(), $d_ida[$d], $conn);
//        array_push($d_pre,$ppp->getImporte());
//        array_push($d_tot,$ppp->getImporte()*$d_pes[$d]);
//        array_push($d_pre1,$ppp->getPreciominimo());
//        array_push($d_pre2,$ppp->getPreciomaximo());
//    }
    $rem=new adm_rem_1($adm->getIdrem());
    $totf=array_sum($d_tot);
    $totr=$rem->getTotal();
    if($adm->getHayfaena()==0) {
        $ii=-1;
        $intervalo=.01;
        while($totf!=$totr) {
            $ii++;
            if($ii>=count($d_pre)) break;
    //        echo "totf: $totf | totr: $totr<br>";
            if($totf>$totr) {
                // achicar faena
                for($i=$ii;$i<count($d_pre);$i++) {
                    while($totf>=$totr) {
                        $d_pre[$i]-=$intervalo;
                        $d_tot[$i]=$d_pre[$i]*$d_pes[$i];
                        if($d_pre[$i]<$d_pre1[$i]) {
                            $d_pre[$i]+=$intervalo;
                            $d_tot[$i]=$d_pre[$i]*$d_pes[$i];
                            break;
                        }
                        $totf=array_sum($d_tot);
                    }
                }

            } else {
                // agandar faena
                for($i=$ii;$i<count($d_pre);$i++) {
                    while($totf<=$totr) {
                        $d_pre[$i]+=$intervalo;
                        $d_tot[$i]=$d_pre[$i]*$d_pes[$i];
                        if($d_pre[$i]>$d_pre2[$i]) {
                            $d_pre[$i]-=$intervalo;
                            $d_tot[$i]=$d_pre[$i]*$d_pes[$i];
                            break;
                        }
                        $totf=array_sum($d_tot);
                    }
                }
            }
        }
    }
}
$cantidaddet=count($d_pes);
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
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	nombre: ['required', 'only_on_submit']
}
</script>

<script language="javascript">
function preciomas(i) {
    liberar=document.getElementById("liberar").checked;
    det_precio="det_precio" + i;
    det_total="det_total" + i;
    det_preciomin="det_preciomin" + i;
    det_preciomax="det_preciomax" + i;
    det_peso="det_peso" + i;
    pre=document.getElementById(det_precio).value;
    pre2=document.getElementById(det_preciomax).value;
    pes=document.getElementById(det_peso).value;
    pre=parseFloat(pre) + parseFloat(".01");
    cantidaddet=document.getElementById("cantidaddet").value;
    
    if(liberar==false)
        if(parseFloat(pre)>parseFloat(pre2)) pre-=parseFloat(.01);
    pre=Math.round(pre*100)/100;;
    tot=parseFloat(pre) * parseFloat(pes);
    tot=Math.round(tot*100)/100;
    document.getElementById(det_precio).value=pre;
    document.getElementById(det_total).value=tot;
    totf=0;
    for(j=0;j<cantidaddet;j++) {
        det_total="det_total" + j;
        dtot=document.getElementById(det_total).value;
        totf+=parseFloat(dtot);
        
    }
    totf=Math.round(totf*100)/100;
    document.getElementById("total").value=totf;
    totr=document.getElementById("totalrem").value;
    dif=parseFloat(totf)-parseFloat(totr);
    dif=Math.round(dif*100)/100;
    document.getElementById("totaldif").value=dif;
    
}

function preciomenos(i) {
    liberar=document.getElementById("liberar").checked;
    det_precio="det_precio" + i;
    det_total="det_total" + i;
    det_preciomin="det_preciomin" + i;
    det_preciomax="det_preciomax" + i;
    det_peso="det_peso" + i;
    cantidaddet=document.getElementById("cantidaddet").value;
    pre=document.getElementById(det_precio).value;
    pre2=document.getElementById(det_preciomax).value;
    pes=document.getElementById(det_peso).value;
    pre=parseFloat(pre) - parseFloat(".01");
    if(liberar==false)
        if(parseFloat(pre)>parseFloat(pre2)) pre=parseFloat(pre) - parseFloat(".01");
    pre=Math.round(pre*100)/100;
    tot=parseFloat(pre) * parseFloat(pes);
    tot=Math.round(tot*100)/100;
    document.getElementById(det_precio).value=pre;
    document.getElementById(det_total).value=tot;
    totf=0;
    for(j=0;j<cantidaddet;j++) {
        det_total="det_total" + j;
        dtot=document.getElementById(det_total).value;
        totf+=parseFloat(dtot);
        
    }
    totf=Math.round(totf*100)/100;
    document.getElementById("total").value=totf;
    totr=document.getElementById("totalrem").value;
    dif=parseFloat(totf)-parseFloat(totr);
    dif=Math.round(dif*100)/100;
    document.getElementById("totaldif").value=dif;
    
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
<form name="form1" id="form1" action="adm_fae_main_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
        <input name="calculoprecio" id="calculoprecio" type="hidden" value="<?= $calculoprecio?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">RESUMEN DE FAENA</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <? if($idcrm==0) { ?>
                                    <tr>
                                        <td width="35%" align="right">Remito&nbsp;</td>
                                        <td width="65%">
                                            <select name="idcrm" id="idcrm" onchange="javascript: document.form1.target='_self'; document.form1.action='adm_fae_main.php'; document.form1.submit()">
                                                <?
                                                $sup->cargaComboArrayValor($r_det, $r_id, $idcrm, "Sel");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <? } else { ?>
                                    <tr>
                                        <td colspan="2"><input name="idcrm" id="idcrm" type="hidden" value="<?= $idcrm?>" /><a href="javascript: document.form1.target='_self'; document.form1.idcrm.value=0; document.form1.action='<?= $urlvolver?>'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>

                                    <tr>
                                        <td width="35%" align="right">Fecha&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($adm->getFecha())?></td>
                                    </tr>

                                    <tr>
                                        <td align="right">Remito&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getRemito()?></td>
                                    </tr>
<!--                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td class="letra6bold"><?= number_format($rem->getTotal(),2)?></td>
                                    </tr>-->
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Total Faena: <input name="total" id="total" size="10" readonly="readonly" style="border: none; font-weight: bold; text-align: right" value="<?= number_format(array_sum($d_tot),2,".","")?>" /> | Total Remito: <input name="totalrem" id="totalrem" size="10" readonly="readonly" style="border: none; font-weight: bold; text-align: right" value="<?= number_format($rem->getTotal(),2,".","")?>" /> | Diferencia: <input name="totaldif" id="totaldif" size="10" readonly="readonly" style="border: none; font-weight: bold; text-align: right" value="<?= number_format(array_sum($d_tot)-$rem->getTotal(),2,".","")?>" /> | 
                                            Liberar Precios <input name="liberar" id="liberar" type="checkbox" value="1" /> | 
                                            <input name="cmdref" id="cmdref" value="Refrescar Faena" type="button" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fae_refresh.php'; document.form1.submit()" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Producto</td>
                                                            <td width="10%" align="right">Peso</td>
                                                            <td width="10%" align="right">Importe</td>
                                                            <td width="10%" align="right">Total</td>
                                                            <td width="5%">&nbsp;</td>
                                                        </tr>
                                                         <? for($i=0;$i<count($d_pes);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td><?= $d_art[$i]?><input name="det_idart<?= $i?>" id="det_idart<?= $i?>" value="<?= $d_ida[$i]?>" type="hidden" /></td>                            
                                                            <td align="right"><input type="hidden" id="det_peso<?= $i?>" name="det_peso<?= $i?>" value="<?= $d_pes[$i]?>" /><?= number_format($d_pes[$i],2)?></td>
                                                            <td><input type="text" id="det_precio<?= $i?>" name="det_precio<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: right"  value="<?= $d_pre[$i]?>" /></td>
                                                            <td>
                                                                <input type="text" id="det_total<?= $i?>" name="det_total<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: right" value="<?= $d_tot[$i]?>" readonly="readonly" />
                                                                <input type="hidden" id="det_preciomin<?= $i?>" name="det_preciomin<?= $i?>" value="<?= $d_pre1[$i]?>" />
                                                                <input type="hidden" id="det_preciomax<?= $i?>" name="det_preciomax<?= $i?>" value="<?= $d_pre2[$i]?>" />
                                                            </td>
                                                            <td>
                                                                <a href="javascript: preciomas(<?= $i?>)"><i class="far fa-plus-square fa-lg"></i></a> 
                                                                <a href="javascript: preciomenos(<?= $i?>)"><i class="far fa-minus-square fa-lg"></i></a>
                                                            </td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <? } ?>
                                    
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_fae_main_save.php'; document.form1.submit()" />
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
