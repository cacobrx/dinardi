<?php
/*
 * Creado el 06/08/2019 21:25:27
 * Autor: gus
 * Archivo: adm_com_add.php
 * planbsistemas.com.ar
 */


//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_com_cta.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_mov2.php';
require_once 'clases/adm_rem.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$id=$glo->getGETPOST("id");
$cta=new adm_com_cta_cen($centrosel);
$primero=$glo->getGETPOST("primero");
$cantc=$glo->getGETPOST("cantc");
$cantr=$glo->getGETPOST("cantr");
$clave=$glo->getGETPOST("clave");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$recalculacontable=$glo->getGETPOST("recalculacontable");
$cantidaddet=$glo->getGETPOST("cantidaddet");
$generarimporte=$glo->getGETPOST("generarimporte");
$vernc=$glo->getGETPOST("vernc");
if($vernc=="") $vernc=0;
$totalfactura=0;
$clave=$sup->generateKey();

$carteltarea="Agrega Compras";
$botoncap="Agregar!";
if($primero!=1) {
    $fecha=date("Y-m-d");
    $fec=date("Y-m-d");
    $letra="A";
    $ptovta='';
    $numero='';
    $idprv=0;
    $cainro="";
    $importeneto='';
    $neto21='';
    $neto10='';
    $neto27='';
    $iva21='';
    $iva10='';
    $iva27='';
    $impinternos='';
    $nogravado='';
    $exento='';
    $periva='';
    $retiva='';
    $retiibb=""; 
    $fechaven=date("Y-m-d", strtotime("$fec + 7 day"));
    $totaltotal=0;
    $tipocom=0;
    $tipo=1;
    $fechaimputacion=date("Y-m-d");
    $netor21='';
    $netor10='';
    $netor27='';
    $ivar21='';
    $ivar10='';
    $ivar27='';
    $netonc10="";
    $ivanc10="";
    $netonc21="";
    $ivanc21="";
    $totalnc="";
    $nogravadonc="";
    $fechanc=date("Y-m-d");
    $letranc="A";
    $ptovtanc="";
    $numeronc="";
    $cainronc="";
    
    $exentonc="";
    $impinternosnc="";
    $retiibbnc="";
    $retivanc="";
    $perivanc="";
    
} else {
    $fecha=$glo->getGETPOST("fecha");
    $letra=$glo->getGETPOST("letra");
    $ptovta=$glo->getGETPOST("ptovta");
    $numero=$glo->getGETPOST("numero");
    $idprv=$glo->getGETPOST("idprv");
    $prv=new adm_prv_1($idprv);
    $cainro=$glo->getGETPOST("cainro");
    if($generarimporte==1) {
         
    } else {
        $neto21=$glo->getgetpost("neto21");
        $neto10=$glo->getGETPOST("neto10");
        $neto27=$glo->getGETPOST("neto27");
        $iva21=$glo->getGETPOST("iva21");
        $iva10=$glo->getGETPOST("iva10");
        $tipo=$glo->getGETPOST("tipo");
        $iva27=$glo->getGETPOST("iva27");
        $impinternos=$glo->getGETPOST("impinternos");
        $nogravado=$glo->getGETPOST("nogravado");
        $exento=$glo->getGETPOST("exento");
        $periva=$glo->getGETPOST("periva");
        $retiva=$glo->getGETPOST("retiva");
        $retiibb=$glo->getGETPOST("retiibb"); 
        $fechaven=$glo->getGETPOST("fechaven");
        $tipocom=$glo->getGETPOST("tipocom");
        $fechaimputacion=$glo->getGETPOST("fechaimputacion");
        $netor21=$glo->getgetpost("netor21");
        $netor10=$glo->getGETPOST("netor10");
        $netor27=$glo->getGETPOST("netor27");
        $ivar21=$glo->getGETPOST("ivar21");
        $ivar10=$glo->getGETPOST("ivar10");
        $ivar27=$glo->getGETPOST("ivar27");
        $netonc10=$glo->getGETPOST("netonc10");
        $ivanc10=$glo->getGETPOST("ivanc10");
        $netonc21=$glo->getGETPOST("netonc21");
        $ivanc21=$glo->getGETPOST("ivanc21");
        $totalnc=$glo->getGETPOST("totalnc");
        $nogravadonc=$glo->getGETPOST("nogravadonc");
        $fechanc=$glo->getGETPOST("fechanc");
        $letranc=$glo->getGETPOST("letranc");
        $numeronc=$glo->getGETPOST("numeronc");
        $ptovtanc=$glo->getGETPOST("ptovtanc");
        $cainronc=$glo->getGETPOST("cainronc");
        $exentonc=$glo->getGETPOST("exentonc");
        $impinternosnc=$glo->getGETPOST("impinternosnc");
        $retiibbnc=$glo->getGETPOST("retiibbnc");
        $retivanc=$glo->getGETPOST("retivanc");
        $perivanc=$glo->getGETPOST("perivanc");
        if($fechanc=="") $fechanc=date("Y-m-d");
    }
}
$r_id=array();
if($idprv>0) {
    $cantc=-1;
    $ii=-1;
    $ssql="select * from adm_rem where idprv=$idprv and idcom=0 order by fecha, id";
//    echo $ssql;
    $rem=new adm_rem_2($ssql);
    $r_id=$rem->getId();
    $r_fec=$rem->getFecha();
    $r_tot=$rem->getTotal();
    $r_iva=$rem->getImporteiva();
    $r_neto=$rem->getImporteneto();
    $r_neto0=$rem->getNeto0();
    $r_neto10=$rem->getNeto10();
    $r_neto21=$rem->getNeto21();
    $r_iva0=$rem->getIva0();
    $r_iva10=$rem->getIva10();
    $r_iva21=$rem->getIva21();
    
    $r_totr=$rem->getTotalremito();
    $r_ivar=$rem->getImporteivar();
    $r_netor=$rem->getImportenetor();
    $r_netor0=$rem->getNetor0();
    $r_netor10=$rem->getNetor10();
    $r_netor21=$rem->getNetor21();
    $r_ivar0=$rem->getIvar0();
    $r_ivar10=$rem->getIvar10();
    $r_ivar21=$rem->getIvar21();
    
    $prv=new adm_prv_1($idprv);
    
//    print_r($r_tot);
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
        /*visibility:hidden;*/
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
<script type="text/javascript" src="planb.js?1.0.10"></script>
<script type="text/javascript" src="planbjs/compras.js?7"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	fecha: ['required', 'only_on_submit'],
	letra: ['required', 'only_on_submit'],
	idprv: ['required', 'only_on_submit'],
	importeneto: ['required', 'only_on_submit'],
	fechaven: ['required', 'only_on_submit'],
	ptovta: ['required', 'only_on_submit'],
	numero: ['required', 'only_on_submit']
}


function get_iva21(val) {
    if(val!="" && val!=0) {
        document.form1.iva21.value=val*21/100;
    }
}

function get_iva10(val) {
    if(val!="" && val!=0) {
        document.form1.iva10.value=val*10.5/100;
    }
}

function get_iva27(val) {
    if(val!="" && val!=0) {
        document.form1.iva27.value=val*27/100;
    }
}

function get_totalfactura() {
    var total=0;
//    alert(document.getElementById("retiibb").value);
//    alert(parseFloat(document.form1.neto21.value));
    if(document.form1.neto21.value>0)
        total+=parseFloat(document.form1.neto21.value);
    if(document.form1.neto10.value>0)
        total+=parseFloat(document.form1.neto10.value);
    if(document.form1.neto27.value>0)
        total+=parseFloat(document.form1.neto27.value);
    if(document.form1.iva21.value>0)
        total+=parseFloat(document.form1.iva21.value);
    if(document.form1.iva10.value>0)
        total+=parseFloat(document.form1.iva10.value);
    if(document.form1.iva27.value>0)
        total+=parseFloat(document.form1.iva27.value);
    if(document.form1.nogravado.value>0)
        total+=parseFloat(document.form1.nogravado.value);
    if(document.form1.exento.value>0)
        total+=parseFloat(document.form1.exento.value);
    if(document.form1.impinternos.value>0)
        total+=parseFloat(document.form1.impinternos.value);
    if(document.form1.periva.value>0)
        total+=parseFloat(document.form1.periva.value);
    if(document.form1.retiva.value>0)
        total+=parseFloat(document.form1.retiva.value);
    if(document.form1.retiibb.value>0)
       total+=parseFloat(document.form1.retiibb.value);

        //alert(document.form1.retiibb.value);

    document.form1.totalfactura.value=total;
}

function get_totalnc() {
    var total=0;
    //alert(parseFloat(document.form1.neto21.value));
    if(document.form1.netonc21.value>0)
        total+=parseFloat(document.form1.netonc21.value);
    if(document.form1.netonc10.value>0)
        total+=parseFloat(document.form1.netonc10.value);
    if(document.form1.ivanc21.value>0)
        total+=parseFloat(document.form1.ivanc21.value);
    if(document.form1.ivanc10.value>0)
        total+=parseFloat(document.form1.ivanc10.value);
    if(document.form1.nogravadonc.value>0)
        total+=parseFloat(document.form1.nogravadonc.value);
    if(document.form1.exentonc.value>0)
        total+=parseFloat(document.form1.exentonc.value);
    if(document.form1.impinternosnc.value>0)
        total+=parseFloat(document.form1.impinternosnc.value);
    if(document.form1.perivanc.value>0)
        total+=parseFloat(document.form1.perivanc.value);
    if(document.form1.retivanc.value>0)
        total+=parseFloat(document.form1.retivanc.value);
    if(document.form1.retiibbnc.value>0)
        total+=parseFloat(document.form1.retiibbnc.value);
    
    document.form1.totalnc.value=total;
}

</script>


</head>
<?require_once 'estilos.php';?>
    <body onload="VerificaCompra()">
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="adm_com_add_save.php" method="post">
        <tr>
            <? include("adm_menu.php") ?>
            <input name="id" type="hidden" id="id" value="<?= $id?>" />
            <input name="primero" type="hidden" id="primero" value="1" />
            <input name="cantc" type="hidden" id="cantc" value="<?= $cantc?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $clave?>" />
            <input name="cantidadrem" id="cantidadrem" type="hidden" value="<?= count($r_id)?>" />
            <input name="generarimporte" type="hidden" id="generarimporte" value="<?= $generarimporte?>" />
            
            <input name="prvanterior" id="prvanterior" type="hidden" value="<?= $idprv?>" />
            <input name="ptoanterior" id="ptoanterior" type="hidden" value="<?= $ptovta?>" />
            <input name="nroanterior" id="nroanterior" type="hidden" value="<?= $numero?>" />
            <input name="prv" id="prv" type="hidden" value="<?= $idprv?>" />                                                
            
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <? require_once 'displayusuario.php';?>
                    <tr>
                        <td>
                            <div class="panel960 letra6">
                                <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                    <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                        <tr>
                                            <td colspan="2"><a href="javascript: document.form1.action='adm_com_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                        </tr>                                        
                                        <tr>
                                            <td>
                                                Fecha&nbsp;<input name="fecha" type="date"class="letra6" id="fecha" value="<?= $fecha?>" onblur="javascript: document.form1.fechaven.value=document.form1.fecha.value; document.form1.fechaimputacion.value=document.form1.fecha.value" /> | 
                                                Comprobante&nbsp;<select name="tipocom" id="tipocom" onchange="javascript: VerificaCompra()">
                                                    <? 
                                                    $aid=array(1,2,3);
                                                    $atex=array("Factura","Nota de Credito", "Nota de Debito");
                                                    $sup->cargaComboArrayValor($atex, $aid, $tipocom);
                                                    ?>
                                                </select> | 
                                                    Tipo&nbsp;<select name="tipo" id="tipo" onchange="javascript: cargaprvtipo(this.value)">
                                                    <? 
                                                    $aid=array(1,2);
                                                    $atex=array("Compra","Gasto");
                                                    $sup->cargaComboArrayValor($atex, $aid, $tipo);
                                                    ?>
                                                </select> | 
                                                    Letra&nbsp;<select name="letra" id="letra" onchange="VerificaCompra()">
                                                    <?
                                                    $array=array("A","B","C","M","X");
                                                    $sup->cargaComboArrayValor($array, $array, $letra);
                                                    ?>
                                                </select> | 
                                                    P.Venta&nbsp;<input name="ptovta" type="text"class="letra6" id="ptovta" size="4" maxlength="4" value="<?= $ptovta?>" onkeypress="return validar(event)" style="text-align: center" onblur="VerificaCompra()" /> | 
                                                    Numero&nbsp;<input name="numero" type="text"class="letra6" id="numero" size="8" maxlength="8" value="<?= $numero?>" onkeypress="return validar(event)" style="text-align: center" onblur="VerificaCompra()" /> 
                                                    <p style="color: yellow; background-color: red; display: none; font-weight: bold; text-align: center" id="errorrep">*** ERROR: YA FUE INGRESADO ESTE COMPROBANTE ***</p>
                                                    <p style="background-color: yellow; display: none; font-weight: bold; text-align: center" id="errorret">*** ATENCIÓN: YA EXISTE EL COMPROBANTE CON ESE NÚMERO EN OTRO PROVEEDOR ***</p>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Proveedor&nbsp;<select name="idprv" id="idprv" onchange="VerificaCompra(); document.form1.action='adm_com_add.php'; document.form1.submit()"  >
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=$tipo order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel")
                                                ?>
                                                </select> | 

                                                C.A.I. Nro.&nbsp;<input name="cainro" type="text"class="letra6" id="cainro" size="15" maxlength="15" value="<?= $cainro?>" onkeypress="return validar(event)" style="text-align: center" /> | 
                                                Ver Diferencias <input name="vernc" id="vernc" type="checkbox" value="1" <? if($vernc==1) echo "checked='checked'"; ?> onclick="javascript: document.form1.action='adm_com_add.php'; document.form1.submit()"  />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td>Neto 10.5%</td>
                                                        <td>Iva 10.5%</td>
                                                        <td>Neto 21%</td>
                                                        <td>Iva 21%</td>
                                                        <td>Neto 27%</td>
                                                        <td>Iva 27%</td>
                                                    </tr>
                                                    <tr>
                                                        <? if($vernc==1) { ?>
                                                        <td><input name="neto10" type="text" class="letra6" id="neto10" size="10" maxlength="10" value="<?= $neto10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva10" type="text" class="letra6" id="iva10" size="10" maxlength="10" value="<?= $iva10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto21" type="text" class="letra6" id="neto21" size="10" maxlength="10" value="<?= $neto21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva21" type="text" class="letra6" id="iva21" size="10" maxlength="10" value="<?= $iva21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto27" type="text" class="letra6" id="neto27" size="10" maxlength="10" value="<?= $neto27?>" onkeypress="return validar_punto(event)" onblur="get_iva27(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva27" type="text" class="letra6" id="iva27" size="10" maxlength="10" value="<?= $iva27?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>

<!--                                                        <td><input name="netor10" type="text" class="letra6" id="netor10" size="10" maxlength="10" value="<?= $netor10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="ivar10" type="text" class="letra6" id="ivar10" size="10" maxlength="10" value="<?= $ivar10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="netor21" type="text" class="letra6" id="netor21" size="10" maxlength="10" value="<?= $netor21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="ivar21" type="text" class="letra6" id="ivar21" size="10" maxlength="10" value="<?= $ivar21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="netor27" type="text" class="letra6" id="netor21" size="10" maxlength="10" value="<?= $netor21?>" onkeypress="return validar_punto(event)" onblur="get_iva27(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="ivar27" type="text" class="letra6" id="ivar21" size="10" maxlength="10" value="<?= $ivar21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>-->
                                                        

                                                        <? } else { ?>
                                                        <td><input name="neto10" type="text" class="letra6" id="neto10" size="10" maxlength="10" value="<?= $netor10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva10" type="text" class="letra6" id="iva10" size="10" maxlength="10" value="<?= $ivar10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto21" type="text" class="letra6" id="neto21" size="10" maxlength="10" value="<?= $netor21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva21" type="text" class="letra6" id="iva21" size="10" maxlength="10" value="<?= $ivar21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto27" type="text" class="letra6" id="neto27" size="10" maxlength="10" value="<?= $netor27?>" onkeypress="return validar_punto(event)" onblur="get_iva27(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva27" type="text" class="letra6" id="iva27" size="10" maxlength="10" value="<?= $ivar27?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <? } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Exento</td>
                                                        <td>No Gravado</td>
                                                        <td>Imp. Internos</td>
                                                        <td>Percepcion IVA</td>
                                                        <td>Retencion IVA</td>
                                                        <td>Per / Ret IIBB</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="exento" type="text"class="letra6" id="exento" size="10" maxlength="10" value="<?= $exento?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="nogravado" type="text"class="letra6" id="nogravado" size="10" maxlength="10" value="<?= $nogravado?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="impinternos" type="text"class="letra6" id="impinternos" size="10" maxlength="10" value="<?= $impinternos?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="periva" type="text"class="letra6" id="periva" size="10" maxlength="10" value="<?= $periva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="retiva" type="text"class="letra6" id="retiva" size="10" maxlength="10" value="<?= $retiva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="retiibb" type="text" class="letra6" id="retiibb" size="10" maxlength="10" value="<?= $retiibb?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vencimiento</td>
                                                        <td>Fecha Imputación</td>
                                                        <td>TOTAL</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="fechaven" type="date"class="letra6" id="fechaven" value="<?= $fechaven?>" /></td>
                                                        <td><input name="fechaimputacion" type="date"class="letra6" id="fechaimputacion" value="<?= $fechaimputacion?>" /></td>
                                                        <td><input name="totalfactura" type="text" class="letra6bold" id="totalfactura" size="10" maxlength="10" style="font-size: 15px; text-align: center" readonly="readonly" style="border: none; background-color: #eeeeee; text-align: center" value="<?= $totalfactura?>" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <? if($vernc==1) { ?>
                                        <tr>
                                            <td><hr></hr></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Fecha&nbsp;<input name="fechanc" type="date" class="letra6" id="fechanc" value="<?= $fechanc?>" onblur="javascript: document.form1.fechaven.value=document.form1.fecha.value; document.form1.fechaimputacion.value=document.form1.fecha.value" /> | 
                                                Comprobante&nbsp;<strong>NOTA DE CRÉDITO</strong> | 
                                                Letra&nbsp;<select name="letranc" id="letranc">
                                                    <?
                                                    $array=array("A","B","C","X");
                                                    $sup->cargaComboArrayValor($array, $array, $letranc);
                                                    ?>
                                                </select> | 
                                                    P.Venta&nbsp;<input name="ptovtanc" type="text" class="letra6" id="ptovtanc" size="4" maxlength="4" value="<?= $ptovtanc?>" onkeypress="return validar(event)" style="text-align: center" onblur="verificanumerocompra(document.form1.idprv.value, this.value, document.form1.numero.value)" /> | 
                                                    Numero&nbsp;<input name="numeronc" type="text" class="letra6" id="numeronc" size="8" maxlength="8" value="<?= $numeronc?>" onkeypress="return validar(event)" style="text-align: center" onblur="verificanumerocompra(document.form1.idprv.value, document.form1.ptovta.value, this.value)" /> 
                                                    CAI Nro.&nbsp;<input name="cainronc" type="text" class="letra6" id="cainronc" size="20" maxlength="20" value="<?= $cainronc?>" onkeypress="return validar(event)" style="text-align: center" onblur="verificanumerocompra(document.form1.idprv.value, document.form1.ptovta.value, this.value)" /> 
                                                <input name="errorcomprobante" id="errorcomprobante" type="text" readonly="readonly" style="border: none" class="letraerror" size="25" />
                                                
                                            </td>
                                        </tr>  
                                        
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                    <tr>
                                                        <td>No Grav. <input name="nogravadonc" type="text" class="letra6" id="nogravadonc" size="10" maxlength="10" value="<?= $nogravadonc?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td>Neto 10.5% <input name="netonc10" type="text" class="letra6" id="netonc10" size="10" maxlength="10" value="<?= $netonc10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td>Iva 10.5% <input name="ivanc10" type="text" class="letra6" id="ivanc10" size="10" maxlength="10" value="<?= $ivanc10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td>Neto 21% <input name="netonc21" type="text" class="letra6" id="netonc21" size="10" maxlength="10" value="<?= $netonc21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td>Iva 21% <input name="ivanc21" type="text" class="letra6" id="ivanc21" size="10" maxlength="10" value="<?= $ivanc21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td>Total NC <input name="totalnc" type="text" class="letra6bold" id="totalnc" size="10" maxlength="10" style="font-size: 15px; text-align: center" readonly="readonly" style="border: none; background-color: #eeeeee; text-align: center" value="<?= $totalnc?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exento <input name="exentonc" type="text" class="letra6" id="exentonc" size="10" maxlength="10" value="<?= $exentonc?>" onkeypress="return validar_punto(event)" onblur="get_totalnc()" style="text-align: center" /></td>
                                                        <td>Imp.Internos <input name="impinternosnc" type="text" class="letra6" id="impinternosnc" size="10" maxlength="10" value="<?= $impinternosnc?>" onkeypress="return validar_punto(event)" onblur="get_totalnc()" style="text-align: center" /></td>
                                                        <td>Perc. IVA <input name="perivanc" type="text" class="letra6" id="perivanc" size="10" maxlength="10" value="<?= $perivanc?>" onkeypress="return validar_punto(event)" onblur="get_totalnc()" style="text-align: center" /></td>
                                                        <td>Ret. IVA <input name="retivanc" type="text" class="letra6" id="retivanc" size="10" maxlength="10" value="<?= $retivanc?>" onkeypress="return validar_punto(event)" onblur="get_totalnc()" style="text-align: center" /></td>
                                                        <td>Ret. IIBB. <input name="retiibbnc" type="text" class="letra6" id="retiibbnc" size="10" maxlength="10" value="<?= $retiibbnc?>" onkeypress="return validar_punto(event)" onblur="get_totalnc()" style="text-align: center" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="panel910 letra6">
                                                    <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                            <tr>
                                                                <td colspan="11">
                                                                    <input name="cmdcalcula" id="cmdcalcula" type="button" value="Calcula Importes de Compra" onclick="javascript: set_importes(<?= count($r_id)?>, <?= $vernc?>)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="11" class="ui-widget-header ui-corner-all" align="center">Remitos</td>
                                                            </tr>
                                                            <tr class="letra6bold">
                                                                <td width="5%" align="center">ID</td>
                                                                <td width="10%" align="center">Fecha</td>
                                                                <td width="10%" align="right">No Gravado</td>
                                                                <td width="10%" align="right">Neto 10.5%</td>
                                                                <td width="10%" align="right">Neto 21%</td>
                                                                <td width="10%" align="right">IVA 10.5%</td>
                                                                <td width="10%" align="right">IVA 21%</td>
                                                                <td width="10%" align="right">Total</td>
                                                                <td width="10%" align="center">Cancela</td>
                                                            </tr>
                                                            <? for($i=0;$i<count($r_id);$i++) { 
                                                                $cancela="cancela$i";
                                                                $$cancela=$glo->getGETPOST($cancela);
                                                                if($r_tot[$i]>0) {
                                                                ?>
                                                            <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                <td align="center">
                                                                    <?= $r_id[$i]?>
                                                                    <input name="r_id<?= $i?>" id="r_id<?= $i?>" type="hidden" value="<?= $r_id[$i]?>" />
                                                                    <? if($vernc==1) { ?>
                                                                    <input name="r_neto0<?= $i?>" id="r_neto0<?= $i?>" type="hidden" value="<?= number_format($r_netor0[$i],2,".","")?>" />
                                                                    <input name="r_neto10<?= $i?>" id="r_neto10<?= $i?>" type="hidden" value="<?= number_format($r_netor10[$i],2,".","")?>" />
                                                                    <input name="r_neto21<?= $i?>" id="r_neto21<?= $i?>" type="hidden" value="<?= number_format($r_netor21[$i],2,".","")?>" />
                                                                    <input name="r_iva10<?= $i?>" id="r_iva10<?= $i?>" type="hidden" value="<?= number_format($r_ivar10[$i],2,".","")?>" />
                                                                    <input name="r_iva21<?= $i?>" id="r_iva21<?= $i?>" type="hidden" value="<?= number_format($r_ivar21[$i],2,".","")?>" />

                                                                    <input name="r_netor0<?= $i?>" id="r_netor0<?= $i?>" type="hidden" value="<?= number_format($r_neto0[$i],2,".","")?>" />
                                                                    <input name="r_netor10<?= $i?>" id="r_netor10<?= $i?>" type="hidden" value="<?= number_format($r_neto10[$i],2,".","")?>" />
                                                                    <input name="r_netor21<?= $i?>" id="r_netor21<?= $i?>" type="hidden" value="<?= number_format($r_neto21[$i],2,".","")?>" />
                                                                    <input name="r_ivar10<?= $i?>" id="r_ivar10<?= $i?>" type="hidden" value="<?= number_format($r_iva10[$i],2,".","")?>" />
                                                                    <input name="r_ivar21<?= $i?>" id="r_ivar21<?= $i?>" type="hidden" value="<?= number_format($r_iva21[$i],2,".","")?>" />


                                                                    <? } else { ?>
                                                                    <input name="r_neto0<?= $i?>" id="r_neto0<?= $i?>" type="hidden" value="<?= number_format($r_neto0[$i],2,".","")?>" />
                                                                    <input name="r_neto10<?= $i?>" id="r_neto10<?= $i?>" type="hidden" value="<?= number_format($r_neto10[$i],2,".","")?>" />
                                                                    <input name="r_neto21<?= $i?>" id="r_neto21<?= $i?>" type="hidden" value="<?= number_format($r_neto21[$i],2,".","")?>" />
                                                                    <input name="r_iva10<?= $i?>" id="r_iva10<?= $i?>" type="hidden" value="<?= number_format($r_iva10[$i],2,".","")?>" />
                                                                    <input name="r_iva21<?= $i?>" id="r_iva21<?= $i?>" type="hidden" value="<?= number_format($r_iva21[$i],2,".","")?>" />
                                                                    <? } ?>
                                                                </td>
                                                                <td align="center"><?= date("d/m/Y", strtotime($r_fec[$i]))?></td>
                                                                <? if($vernc==1) { ?>
                                                                <td align="right"><?= number_format($r_netor0[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_netor10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_netor21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_ivar10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_ivar21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_totr[$i],2)?></td>
                                                                <? } else { ?>
                                                                <td align="right"><?= number_format($r_neto0[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_neto10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_neto21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_iva10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_iva21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_tot[$i],2)?></td>
                                                                <? } ?>
                                                                <td align="center">
                                                                    <input name="cancela<?= $i?>" id="cancela<?= $i?>" type="checkbox"  value="<?= $r_id[$i]?>" <? if($$cancela!="") echo "checked='checked'"?> />
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                                <?  } else { ?>
                                                                    <input name="cancela<?= $i?>" id="cancela<?= $i?>" type="hidden"  value="0" />
                                                                <? } } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td colspan="2" align="center">
                                                <div id="agregar" style="visibility: hidden">
                                                <input type="submit" name="cmdOk" id="cmdOk" value="<?= $botoncap?>" />
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
