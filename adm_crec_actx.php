<?
require("user.php");
//print_r($_POST);
require_once 'clases/conexion.php';
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_crec.php';
require_once 'clases/adm_mov.php';
require_once 'clases/adm_mov2.php';
require_once 'clases/adm_cht.php';
require_once 'clases/adm_fis.php';
$dsup=new datesupport();
$conx=new conexion();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$idrec=$glo->getGETPOST("idrec");
$canti=$glo->getGETPOST("canti");
$cantc=$glo->getGETPOST("cantc");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$idcli=$glo->getGETPOST("idcli");
$primero=$glo->getGETPOST("primero");


$errordetalle=$glo->getGETPOST("errordetalle");
$errorcontable=$glo->getGETPOST("errorcontable");
$errorpagocontable=$glo->getGETPOST("errorpagocontable");
$totaltotal="";
if($canti=="")
    $canti=1;
if($canti<1)
    $canti=1;
if($cantc=="")
    $cantc=2;
if($cantc<2)
    $cantc=2;
$mov2="adm_mov2";

$c_id=array();
$v_id=array();
if($tarea=="A") {
    $carteltarea="Agrega Recibo";
    $botoncap="Agregar!";
    $fecha=$glo->getGETPOST("fecha");
    if($fecha=="")
        $fecha=date("Y-m-d");
    
    //echo "fecha: $fecha<br>";
    $cliente=$glo->getGETPOST("cliente");
    $direccion=$glo->getGETPOST("direccion");
    $concepto=$glo->getGETPOST("concepto");
    $numero=$glo->getGETPOST("numero");
    if($numero=="") $numero=$sup->getUltimoRecibo();
//    $chtbanco=array();
//    $cht_id=array();
//    array_push($chtbanco, "Efectivo");
//    array_push($chtbanco,"Retención Ganancia");
//    array_push($cht_id,"x|0");
//    array_push($cht_id,"x|1");
//    $ssql="select * from adm_che where entregado='' and centro=$centrosel order by fechapago";
//    $cht=new adm_che_2($ssql);
//    $t_fec=$cht->getFechapago();
//    $t_ban=$cht->getBancodes();
//    $t_id=$cht->getId();
//    $t_imp=$cht->getImporte();
//    $t_nro=$cht->getNrocheque();
//    
//    for($i=0;$i<count($t_id);$i++) {
//        array_push($chtbanco,"T: ".$dsup->getFechaNormalCorta($t_fec[$i])." ".$t_ban[$i]." ".$t_nro[$i]." $".number_format($t_imp[$i])." [".$t_id[$i]."]");
//        array_push($cht_id,"t|".$t_id[$i]);
//    }
  
    if($idcli>0) {
        $ssql="select * from adm_fis where idcli=$idcli and centro=$centrosel and total > importepago order by fecha";
//        echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $c_id=$fis->getId();
        $c_fec=$fis->getFecha();
        $c_pag=$fis->getImportepago();
        $c_imp=$fis->getTotal();
        $c_per=$fis->getPercepcioniibb();
        $c_nro=$fis->getNumero();
        $c_pto=$fis->getPtovta();
        $c_let=$fis->getLetra();
        $c_com=$fis->getTipodes();
    } else
        $c_id=array();
    
} else {
    $carteltarea="MODIFICA RECIBO #$idrec";
    $botoncap="Modificar!";
    if($primero==1) {
        $canti=$glo->getGETPOST("canti");
        $idcli=$glo->getGETPOST("idcli");
        $direccion=$glo->getGETPOST("direccion");
        $concepto=$glo->getGETPOST("concepto");
        $fecha=$glo->getGETPOST("fecha");
        $numero=$glo->getGETPOST("numero");
        $rec1=new adm_crec1_1($idrec);
        $c_id=$rec1->getR2_id();
        $c_fec=$rec1->getR2_fecha();
        $c_com=$rec1->getR2_comprobante();
        $c_imp=$rec1->getR2_importe();
        $c_pag=$rec1->getR2_pagado();
        $c_ppp=$rec1->getR2_pagado();
    } else {
        $rec1=new adm_crec1_1($idrec);
        $idcli=$rec1->getIdcli();
        $direccion=$rec1->getDireccion();
        $concepto=$rec1->getConcepto();
        $fecha=$rec1->getFecha();
        $numero=$rec1->getNumero();

        $c_id=$rec1->getR2_id();
        $c_fec=$rec1->getR2_fecha();
        $c_com=$rec1->getR2_comprobante();
        $c_imp=$rec1->getR2_importe();
        $c_pag=$rec1->getR2_pagado();
        $c_ppp=$rec1->getR2_pagado();
        
        $ssql="select * from adm_fis where idcli=$idcli and centro=$centrosel and total > importepago order by fecha";
//        echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $c_id= array_merge($fis->getId());
        $c_fec=array_merge($fis->getFecha());
        $c_pag=array_merge($fis->getImportepago());
        $c_imp=array_merge($fis->getTotal());
        $c_per=array_merge($fis->getPercepcioniibb());
        $c_nro=array_merge($fis->getNumero());
        $c_pto=array_merge($fis->getPtovta());
        $c_let=array_merge($fis->getLetra());
        $c_com=array_merge($fis->getTipodes());
        for($c=1;$c<count($c_id);$c++) {
            array_push($c_ppp,"");
        }
        

        $a_id=$rec1->getR3_id();
        $a_det=$rec1->getR3_detalle();
        $a_fpg=$rec1->getR3_detallepagodes();
        $a_cht=$rec1->getR3_idcht();
        $a_imp=$rec1->getR3_importe();
        $canti=count($a_id);
    }
  
}


$ssql="select * from tmp_cht where idcli=$idcli and usuario=".$usr->getId();
$cht=new adm_cht_2($ssql);
$cht_id=$cht->getId();
$cht_ban=$cht->getIdbanco();
$cht_bandes=$cht->getBancodes();
$cht_importe=$cht->getImporte();
$cht_nro=$cht->getNrocheque();
$cht_fechaven=$cht->getFechapago();
$cantf=count($c_id);


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
<script type="text/javascript" src="planb.js?1.0.4"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script src="planb.js" type="text/javascript"></script>
<script language="javascript">
    
var VanadiumRules = {
	errordetalle: ['required', 'only_on_submit'],
}

function AjustaLinea(tipo) {
    valor=document.form1.canti.value;
    if(tipo==0)
        valor++;
    if(tipo==1)
        valor--;
    if(valor==0)
        valor=1
    document.form1.canti.value=valor;
}

function AjustaLineaC(tipo) {
    valor=document.form1.cantc.value;
    if(tipo==0)
        valor++;
    if(tipo==1)
        valor--;
    if(valor==0)
        valor=1
    document.form1.cantc.value=valor;
}


function totalizar(cant) {
    //alert("totalizar!");
    tot=0;
    for(i=0;i<cant;i++) {
        cc='importedet' + i;
        valor=document.form1[cc].value;
        if(valor!="")
            tot+=parseFloat(valor);
        
    }
    document.form1.importe.value=tot;
//    document.form1.entrada0.value=tot;
//    document.form1.salida1.value=tot;
    
}

function pagacompletorec(i, cant, canti) {
    if(i>=0) {
        importepag="importepag" + i;
        importetot="importetot" + i;
        pagar="pagar" + i;
        if(document.form1[importepag].value!="")
            document.form1[pagar].value=parseFloat(document.form1[importetot].value) - parseFloat(document.form1[importepag].value);
        else
            document.form1[pagar].value=document.form1[importetot].value;
    }
    totpag=0;
    totconcepto='Pago ';
    for(f=0;f<cant;f++) {
        pagar="pagar"+f;
        concepto="concepto"+f;
        //alert(concepto);
        //alert(document.form1[pagar].value);
        if(document.form1[pagar].value!="") {
            totpag+=parseFloat(document.form1[pagar].value);
            totconcepto+=document.form1[concepto].value + " / ";
        }
    }
    document.form1.concepto.value=totconcepto;
    document.form1.importe.value=totpag;
    if(canti==1) {
        document.form1.detalle0.value="Efectivo";
        document.form1.importedet0.value=totpag;
        document.form1.entrada0.value=totpag;
        document.form1.salida1.value=totpag;
    }
}

</script>
<?require_once 'estilos.php';?>

</head>

<body onload="totalizar(<?= $canti?>); ">
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_crec_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="idrec" type="hidden" id="idrec" value="<?= $idrec?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="canti" type="hidden" id="canti" value="<?= $canti?>" />
        <input name="cantc" type="hidden" id="cantc" value="<?= $cantc?>" />
        <input name="primero" type="hidden" id="primero" value="1" />
        <input name="cantf" type="hidden" id="cantf" value="<?= $cantf?>" />
        <input name="idcht" type="hidden" id="idcht" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2" class="letra6">
                <?require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_crec_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">N&uacute;mero</td>
                                        <td><input name="numero" type="text" class="letra6" id="numero" value="<?= $numero?>" size="8" maxlength="8" style="text-align:center" onkeypress="return validar(event)" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Cliente</td>
                                        <td>
                                            <? if($tarea=="A") { ?>
                                            <select name="idcli" class="letra6" id="idcli" onchange="javascript: document.form1.action='adm_crec_act.php'; document.form1.submit()">
                                                <? $sup->cargaCombo3("select id as id, apellido as campo from adm_cli order by apellido", $idcli, "Sel") ?>
                                            </select>
                                            <? } else { ?>
                                            <select name="idcli" class="letra6" id="idcli">
                                                <? $sup->cargaCombo3("select id as id, apellido as campo from adm_cli order by apellido", $idcli, "Sel") ?>
                                            </select>
                                            <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Caja&nbsp;</td>
                                        <td>
                                            <select name="caja" id="caja">
                                                <?
                                                $ssql="select id as id, nombre as campo from adm_caj order by nombre";
                                                $sup->cargaCombo3($ssql, $caja);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <? if($idcli>0) { ?>
                                    <tr>
                                        <td width="35%" align="right">Concepto&nbsp;</td>
                                        <td width="65%"><input name="concepto" type="text" class="letra6" id="concepto" size="50" maxlength="100" value="<?= $concepto?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Total Importe&nbsp;</td>
                                        <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= $totaltotal?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Documentos a Aplicar</h3>                
                                                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6bold">
                                                            <td align="center">Fecha</td>
                                                            <td align="center">Comprobante</td>
                                                            <td align="center">Importe</td>
                                                            <td align="center">Pagado</td>
                                                            <td align="center">Pago</td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($c_id);$i++) { 
                                                            $pagar="pagar$i";
                                                            $$pagar=$glo->getGETPOST($pagar);
                                                            if($tarea=="M")
                                                                $$pagar=$c_ppp[$i];
                                                            if($tarea=="A")
                                                                $importetot=$c_imp[$i]+$c_per[$i];
                                                            else
                                                                $importetot=$c_imp[$i];
                                                            $importepag=$c_pag[$i];
                                                            if($importetot!=$importepag or $tarea=="M") {
                                                            ?>
                                                        <tr>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($c_fec[$i])?>
                                                                <input name="importetot<?= $i?>" id="importetot<?= $i?>" type="hidden" value="<?= $importetot?>" />
                                                                <input name="importepag<?= $i?>" id="importepag<?= $i?>" type="hidden" value="<?= $importepag?>" />
                                                                <input name="concepto<?= $i?>" id="concepto<?= $i?>" type="hidden" value="<?= $c_nro[$i]?>" />
                                                                <input name="idcped<?= $i?>" type="hidden" id="idcped<?= $i?>" value="<?= $c_id[$i]?>" /></td>
                                                                <td align="center"><?= $c_com[$i]."-".$c_let[$i]."-".$sup->AddZeros($c_pto[$i],4)."-".$sup->AddZeros($c_nro[$i],8)?></td>
                                                                <td align="center">
                                                                    <? if($tarea=="A")
                                                                        echo number_format($c_imp[$i]+$c_per[$i],2);
                                                                    else
                                                                        echo number_format($c_imp[$i],2);
                                                                            ?></td>
                                                                <td align="center"><?= number_format($c_pag[$i],2)?></td>
                                                                <td align="center"><input name="pagar<?= $i?>" type="text" class="letra6" id="pagar<?= $i?>" size="10" maxlength="10" style="text-align:center" value="<?= $$pagar?>" onblur="javascript: pagacompletorec(-1,<?= count($c_id)?>)" /></td>
                                                                <td align="center"><a href="javascript: pagacompletorec(<?= $i?>, <?= count($c_id)?>)"><i class="fas fa-dollar-sign fa-lg" alt="Paga completo" title="Paga completo"></i></a></td>
                                                        </tr>
                                                        <? } }?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Detalle de Pagos</h3>                
                                                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                        <tr>
                                                            <td width="8%"><a href="javascript: AjustaLinea(0); document.form1.action='adm_crec_act.php'; document.form1.submit()"><i class="far fa-plus-square fa-lg" alt="Agregar L&iacute;nea" title="Agregar L&iacute;nea"></i></a>
                                                                <? if($canti>1) { ?>
                                                                <a href="javascript: AjustaLinea(1); document.form1.action='adm_crec_act.php'; document.form1.submit()"><i class="far fa-minus-square fa-lg" alt="Borrar L&iacute;nea" width="16" height="16" border="0"></i></a>
                                                                <? } ?>
                                                            </td>
                                                            <td>Detalle de Pagos</td>
                                                            <td>Cheque Terceros</td>
                                                            <td width="18%" align="center">Importe</td>
                                                        </tr>
                                                        <? for($i=0;$i<$canti;$i++) { 
                                                            $detalle="detalle$i";
                                                            $importedet="importedet$i";
                                                            $detallepago="detallepago$i";
                                                            $chequepro="chequepro$i";
                                                            if($tarea=="A") {
                                                                if($i<count($cht_id))  {
                                                                    $$detallepago=4;
                                                                    $$detalle="Ch. ".$cht_bandes[$i]." Nro ".$cht_nro[$i]." (".$dsup->getFechaNormalCorta($cht_fechaven[$i]).")";
                                                                    $$importedet=$cht_importe[$i];
                                                                    $$chequepro=$cht_id[$i];
                                                                } else {
                                                                    $$detalle=$glo->getGETPOST($detalle);
                                                                    $$importedet=$glo->getGETPOST($importedet);
                                                                    $$detallepago=$glo->getGETPOST($detallepago);
                                                                    $$chequepro=$glo->getGETPOST($chequepro);
                                                                    if(substr($$detalle,0,3)=="Ch.") {
                                                                        $$detalle="";
                                                                        $$importedet="";
                                                                        $$detallepago=1;
                                                                        $$chequepro=0;
                                                                    }
                                                                }
                                                            } else {
                                                                if($primero==1) {
                                                                    $$detalle=$glo->getGETPOST($detalle);
                                                                    $$importedet=$glo->getGETPOST($importedet);
                                                                    $$detallepago=$glo->getGETPOST($detallepago);
                                                                    $$chequepro=$glo->getGETPOST($chequepro);
                                                                } else {
                                                                    $$importedet=$a_imp[$i];
                                                                    $$detalle=$a_det[$i];
                                                                    $$detallepago=$a_fpg[$i];
                                                                    $$chequepro=$a_cht[$i];
                                                                }
                                                            }
                                                            if(strpos($$detalle,"h. ")>0) $$detallepago=2;
                                                            if($$detallepago=="")
                                                                $$detallepago=1;
                                                            ?>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                <select name="detallepago<?= $i?>" class="letra6" id="detallepago<?= $i?>" onchange="setformadepago(this.value, <?= $i?>)">
                                                                    <? 
                                                                    $ssql="select valor as id, descripcion as campo from tablas where codtab='DPG' order by valor";
                                                                    $sup->cargaCombo3($ssql, $$detallepago);
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td width="33%">
                                                                <input name="detalle<?= $i?>" type="text" class="letra3" size="50" maxlength="50" value="<?= $$detalle?>" />
                                                                <input name="chequepro<?= $i?>" id="chequepro<?= $i?>" type="hidden" value="<?= $$chequepro?>" />
                                                            </td>
                                                            <td align="center">
                                                                <input name="importedet<?= $i?>" id="importedet<?= $i?>" type="text" class="letra3" size="10" maxlength="10" value="<?= $$importedet?>" style="text-align: center" onkeypress="return validar_punto(event)" onblur="javascript: totalizar(<?= $canti?>)" />
                                                            </td>
                                                        </tr>
                                                        <? if($i<count($cht_nro)) { ?>
                                                        <tr class="letra5">
                                                            <td colspan="2">&nbsp;</td>
                                                            <td colspan="2">
                                                            <?= "Nro: ".$cht_nro[$i]." | Fecha: ".$dsup->getFechaNormalCorta($cht_fechaven[$i])." | Banco: ".$cht_bandes[$i]." | Importe: ".number_format($cht_importe[$i],2);?> <a href="javascript: document.form1.idcht.value=<?= $cht_id[$i]?>; document.form1.action='adm_crec_cht_del.php'; document.form1.submit()"><i class="fas fa-minus-circle" style="color: #BB0000"></i></a>
                                                            </td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                            <td colspan="4">
                                                                <hr></hr>
                                                            </td>
                                                        </tr>
                                                        <? }?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Ingresos de Cheques de Terceros</h3>                
                                                    <table width="100%" border="0">
                                                        <tr>
                                                            <td width="15%">Fecha Origen</td>
                                                            <td width="15%">Fecha Vencimiento</td>
                                                            <td width="15%">Banco</td>
                                                            <td width="15%">Nro. Cheque</td>
                                                            <td width="10%">Importe</td>
                                                            <td width="20%">Nombre</td>
                                                            <td width="10%">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input name="che_fechaorigen" type="date" class="letra6" id="che_fechaorigen" value="<?= $hoy?>" /></td>
                                                            <td><input name="che_fechaven" type="date" class="letra6" id="che_fechaven" value="<?= date("Y-m-d", strtotime("$hoy + 1 day"))?>" /></td>
                                                            <td>
                                                                <select name="che_banco" class="letra6" id="che_banco">
                                                                    <? $sup->cargaCombo3("select valor as id, descripcion as campo from tablas where codtab='BAN' order by descripcion", 0, "Sel") ?>
                                                                </select>
                                                            </td>
                                                            <td><input name="che_nrocheque" id="che_nrocheque" type="text" class="letra3" size="10" maxlength="10" /></td>
                                                            <td><input name="che_importe" id="che_importe" type="text" class="letra3" size="10" maxlength="10" style="text-align: center" onkeypress="return validar_punto(event)" /></td>
                                                            <td><input name="che_nombre" id="che_nombre" type="text" class="letra3" size="20" maxlength="20" /></td>
                                                            <td><input type="submit" name="cmdIngCheque" id="cmdIngCheque" value="Ingresar Cheque" onclick="javascript: document.form1.action='adm_crec_cht_tmp_save.php'; document.form1.submit()" /></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_crec_act_save.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <? } ?>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <? if($errordetalle==1) { ?>
                <tr>
                    <td colspan="2" align="center" class="cartelerror">La suma de &quot;Detalle de Pagos&quot; debe ser igual al importe a pagar</td>
                </tr>
                <? }
                if($errorcontable==1) { ?>
                <tr>
                    <td colspan="2" align="center" class="cartelerror">El asiento contable no está balanceado</td>
                </tr>
                <? }
                if($errorpagocontable==1) { ?>
                <tr>
                    <td colspan="2" align="center" class="cartelerror">El asiento contable no concide con el total de pago</td>
                </tr>
                <? } ?>
                <tr>
                    <td colspan="2"><input type="hidden" name="errordetalle" id="errordetalle" /></td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</div>
</body>
</html>
