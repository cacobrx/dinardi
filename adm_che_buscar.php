<?php
/*
 * Creado el 17/04/2019 12:17:27
 * Autor: gus
 * Archivo: adm_che_buscar.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/support.php';
require_once 'clases/adm_che.php';
require_once 'clases/adm_cht.php';
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
$url=$glo->getGETPOST("url");


// variables de o/pago
$idop=$glo->getGETPOST("idop");
$tarea=$glo->getGETPOST("tarea");
$idprv=$glo->getGETPOST("idprv");
$fecha=$glo->getGETPOST("fecha");
$tipo=$glo->getGETPOST("tipo");
$importe=$glo->getGETPOST("importe");
$retenciones=$glo->getGETPOST("retenciones");
$concepto=$glo->getGETPOST("concepto");
$alicuotaret=$glo->getGETPOST("alicuotaret");
$transferencia=$glo->getGETPOST("transferencia");
$importeganancia=$glo->getGETPOST("importeganancia");
$totalpagoscht=$glo->getGETPOST("totalpagoscht");
$caja=$glo->getGETPOST("caja");
$cantd=$glo->getGETPOST("cantd");
if($transferencia=="") $transferencia=0;
if($importeganancia=="") $importeganancia=0;
if($retenciones=="") $retenciones=0;
for($i=0;$i<$cantd;$i++) {
    $pagar="pagar$i";
    $$pagar=$glo->getGETPOST($pagar);
}
//********************************
if($url=="") $url="adm_opg_act.php";

$ssql="select * from adm_cht where entregado='' and tipo=$tipo order by fechapago";
$cht=new adm_cht_2($ssql);
$a_id=$cht->getId();
$a_fori=$cht->getFechaorigen();
$a_fven=$cht->getFechapago();
$a_ban=$cht->getBancodes();
$a_nro=$cht->getNrocheque();
$a_nom=$cht->getNombre();
$a_acr=$cht->getAcreditado();
$a_imp=$cht->getImporte();
$a_cli=$cht->getCliente();
$a_ent=$cht->getEntregado();
$a_via=$cht->getTipo();
$cantidadtotal=$cht->getMaxRegistros();
$cantidadcht=$cantidadtotal;
$totalseleccionadocht=0;
for($i=0;$i<$cantidadtotal;$i++) {
    $chkcht="chkcht$i";
    $chkimporte="chkimporte$i";
    $$chkcht=$glo->getGETPOST($chkcht);
    if($$chkcht>0) {
        $$chkimporte=$glo->getGETPOST($chkimporte);
        $ccc=new adm_cht_1($$chkcht);
        $totalseleccionadocht+=$ccc->getImporte();
    }
}



$ssql="select * from adm_che where entregado=0 order by fechapago";
$che=new adm_che_2($ssql);
$a_id=$che->getId();
$a_fori=$che->getFechaorigen();
$a_fven=$che->getFechapago();
$a_ban=$che->getBancodes();
$a_nro=$che->getNrocheque();
//$a_nom=$cht->getNombre();
//$a_acr=$cht->getAcreditado();
$a_imp=$che->getImporte();
//$a_cli=$cht->getCliente();
//$a_ent=$cht->getEntregado();
//$a_via=$cht->getTipo();
$cantidadtotal=$che->getMaxRegistros();
$cantidadche=$cantidadtotal;
$totalseleccionadoche=0;
for($i=0;$i<$cantidadtotal;$i++) {
    $chkche="chkche$i";
    $chkimporte="chkimporte$i";
    $$chkche=$glo->getGETPOST($chkche);
    if($$chkche>0) {
        $$chkimporte=$glo->getGETPOST($chkimporte);
        $ccc=new adm_che_1($$chkche);
        $totalseleccionadoche+=$ccc->getImporte();
    }
}




$apagar=$importe-$retenciones-$transferencia-$importeganancia;
//echo "apagar: $apagar<br>";
//echo "$importe<br>$retenciones<br>$transferencia<br>$importeganancia";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
	/*visibility:hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<script language="javascript">
    function totalsuma(can) {
        tot=0;
        for(i=0;i<can;i++) {
            chk="chkche" + i;
            imp="chkimporte" + i;
            if(document.getElementById(chk).checked==true) {
                tot+=parseFloat(document.getElementById(imp).value);
            }
        }
        tot=Math.round(tot * 100) / 100;
        sal=value=parseFloat(document.getElementById("importe").value) -  tot - parseFloat(document.getElementById("retenciones").value) - parseFloat(document.getElementById("totalpagoscht").value) - parseFloat(document.getElementById("importeganancia").value);
        sal=Math.round(sal*100)/100;
        document.getElementById("totaltotal").value=tot;
        document.getElementById("saldototal").value=sal;
    }
    
</script>
<?require_once 'estilos.php';?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="<?= $url?>" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="limche" type="hidden" id="limche" value="<?= $limche?>" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="idche" type="hidden" id="idche" value="0" />
        <input name="filtroche" id="filtroche" type="hidden" value="<?= $filtroche?>" />
        <input name="id" type="hidden" id="id" value="0" />
        <input name="primeroche" type="hidden" id="primeroche" value="<?= $primeroche?>" />
        
        <input name="cantidadche" id="cantidadche" type="hidden" value="<?= count($a_id)?>" />
        <input name="cantidadcht" id="cantidadcht" type="hidden" value="<?= $cantidadcht?>" />
        <input name="fecha" type="hidden" id="fecha" value="<?= $fecha?>" />
        <input name="idprv" type="hidden" id="idprv" value="<?= $idprv?>" />
        <input name="idop" type="hidden" id="idop" value="<?= $idop?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="tipo" type="hidden" id="tipo" value="<?= $tipo?>" />
        <input name="importe" type="hidden" id="importe" value="<?= $importe?>" />
        <input name="retenciones" type="hidden" id="retenciones" value="<?= $retenciones?>" />
        <input name="concepto" type="hidden" id="concepto" value="<?= $concepto?>" />
        <input name="caja" type="hidden" id="caja" value="<?= $caja?>" />
        <input name="alicuotaret" type="hidden" id="alicuotaret" value="<?= $alicuotaret?>" />
        <input name="transferencia" type="hidden" id="transferencia" value="<?= $transferencia?>" />
        <input name="importeganancia" type="hidden" id="importeganancia" value="<?= $importeganancia?>" />
        <input name="totalpagoscht" id="totalpagoscht" type="hidden" value="<?= $totalpagoscht?>" />
        
        <? for($i=0;$i<$cantd;$i++) { 
            $pagar="pagar$i";
            $$pagar=$glo->getGETPOST($pagar);
            ?>
        <input name="pagar<?= $i?>" id="pagar<?= $i?>" type="hidden" value="<?= $$pagar?>" />
        <? } 
        for($i=0;$i<$cantidadcht;$i++) {
            $chkcht="chkcht$i";
            $$chkcht=$glo->getGETPOST($chkcht);
            if($$chkcht>0) { ?>
        <input name="chkcht<?= $i?>" id="chkcht<?= $i?>" type="hidden" value="<?= $$chkcht?>" />
        <? } } ?>

        
    </tr> 
    
<tr>
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <? require_once 'displayusuario.php'?> 
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">Selección de CHEQUES PROPIOS para el pago de O/PAGO</h3>              
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            <a href="javascript: document.form1.action='adm_opg_act.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a>
                                            Importe a Pagar <span class="letra6bold"><?= number_format($importe-$retenciones-$transferencia-$importeganancia,2)?></span> | 
                                            Total Seleccionado <input name="totaltotal" id="totaltotal" size="10" style="text-align: center" class="letra6bold" type="text" readonly="readonly" value="<?= $totalseleccionadoche?>" /> | 
                                            Saldo <input name="saldototal" id="saldototal" size="10" style="text-align: center" class="letra6bold" type="text" value="<?= $importe-$retenciones-$totalseleccionadoche-$transferencia-$importeganancia-$totalpagoscht?>" /> | 
                                            <input name="cmdok" id="cmdok" value="FINALIZAR" type="submit" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: <?= $cantidadtotal?></td>                      
                                    </tr>            
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <?for($i=0;$i<count($a_id);$i=$i+4) { 
                                                    $i1=$i+1;
                                                    $i2=$i+2;
                                                    $i3=$i+3;
                                                    $chk0="chkche$i";
                                                    $chk1="chkche$i1";
                                                    $chk2="chkche$i2";
                                                    $chk3="chkche$i3";
                                                    $$chk0=$glo->getGETPOST($chk0);
                                                    $$chk1=$glo->getGETPOST($chk1);
                                                    $$chk2=$glo->getGETPOST($chk2);
                                                    $$chk3=$glo->getGETPOST($chk3);
//                                                    echo "chk1: $chk1: ".$$chk1."<br>";
                                                    ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                    <td width="25%">
                                                        <input name="chkche<?= $i?>" id="chkche<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" onclick="javascript: totalsuma(<?= count($a_id)?>)" <? if($$chk0>0) echo "checked='checked'";?> /> 
                                                        <input name="chkimporte<?= $i?>" id="chkimporte<?= $i?>" type="hidden" value="<?= $a_imp[$i]?>" /> 
                                                        <?= $a_imp[$i]." | ".$a_id[$i]." | ".$a_ban[$i]." | ".$a_nro[$i]." | ".$dsup->getFechaNormalCorta($a_fven[$i])?>
                                                    </td>
                                                    <? if($i+1<count($a_id)) { ?>
                                                    <td width="25%">
                                                        <input name="chkche<?= $i+1?>" id="chkche<?= $i+1?>" type="checkbox" value="<?= $a_id[$i+1]?>" onclick="javascript: totalsuma(<?= count($a_id)?>)" <? if($$chk1>0) echo "checked='checked'";?> /> 
                                                        <input name="chkimporte<?= $i+1?>" id="chkimporte<?= $i+1?>" type="hidden" value="<?= $a_imp[$i+1]?>" /> 
                                                        <?= $a_imp[$i+1]." | ".$a_id[$i+1]." | ".$a_ban[$i+1]." | ".$a_nro[$i+1]." | ".$dsup->getFechaNormalCorta($a_fven[$i+1])?>
                                                    </td>
                                                    <? } 
                                                    if($i+2<count($a_id)) { ?>
                                                    <td width="25%">
                                                        <input name="chkche<?= $i+2?>" id="chkche<?= $i+2?>" type="checkbox" value="<?= $a_id[$i+2]?>" onclick="javascript: totalsuma(<?= count($a_id)?>)" <? if($$chk2>0) echo "checked='checked'";?> /> 
                                                        <input name="chkimporte<?= $i+2?>" id="chkimporte<?= $i+2?>" type="hidden" value="<?= $a_imp[$i+2]?>" /> 
                                                        <?= $a_imp[$i+2]." | ".$a_id[$i+2]." | ".$a_ban[$i+2]." | ".$a_nro[$i+2]." | ".$dsup->getFechaNormalCorta($a_fven[$i+2])?>
                                                    </td>
                                                    <? }
                                                    if($i+3<count($a_id)) { ?>
                                                    <td width="25%">
                                                        <input name="chkche<?= $i+3?>" id="chkche<?= $i+3?>" type="checkbox" value="<?= $a_id[$i+3]?>" onclick="javascript: totalsuma(<?= count($a_id)?>)" <? if($$chk3>0) echo "checked='checked'";?> /> 
                                                        <input name="chkimporte<?= $i+3?>" id="chkimporte<?= $i+3?>" type="hidden" value="<?= $a_imp[$i+3]?>" /> 
                                                        <?= $a_imp[$i+3]." | ".$a_id[$i+3]." | ".$a_ban[$i+3]." | ".$a_nro[$i+3]." | ".$dsup->getFechaNormalCorta($a_fven[$i+3])?>
                                                    </td>
                                                    <? } ?>
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
                <tr>
                  <td>&nbsp;</td>
               </tr>
            </table>
        </td>
    </tr>   
</form>
</div>
</body>
</html>
