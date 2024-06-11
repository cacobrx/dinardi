<?php
/*
 * Creado el 06/08/2019 21:25:27
 * Autor: gus
 * Archivo: adm_com_add.php
 * planbsistemas.com.ar
 */

function cargadescriptor() {
    require_once 'clases/conexion.php';
    $conx=new conexion();
    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
    $rs=$conx->getConsulta($ssql);
    $cad="";
    while($reg=mysqli_fetch_object($rs)) {
        echo '<option value="'.$reg->id.'">'.$reg->campo.'</option>';
    }
    return $cad;
}

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
$totalfactura=0;
$carteltarea="Agrega Compras Proveedores Varios";
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
    $neto17="";
    $iva21='';
    $iva10='';
    $iva27='';    
    $iva17="";
    $impinternos='';
    $nogravado='';
    $exento='';
    $periva='';
    $retiva='';
    $retiibb=""; 
    $descriptor1=0;
    $descriptor2=0;
    $descriptor3=0;
    $descriptor4=0;
    $detalle='';
    $fechaven=date("Y-m-d", strtotime("$fec + 7 day"));
    $totaltotal=0;
    $tipocom=0;
    $tipo=1;
    $fechaimputacion=date("Y-m-d");
    $tipoganancia=0;
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
        $iva27=$glo->getGETPOST("iva27");
        $tipo=$glo->getGETPOST("tipo");
        $neto17=$glo->getGETPOST("neto17");
        $iva17=$glo->getGETPOST("iva17");
        $impinternos=$glo->getGETPOST("impinternos");
        $nogravado=$glo->getGETPOST("nogravado");
        $exento=$glo->getGETPOST("exento");
        $periva=$glo->getGETPOST("periva");
        $retiva=$glo->getGETPOST("retiva");
        $retiibb=$glo->getGETPOST("retiibb"); 
        $fechaven=$glo->getGETPOST("fechaven");
        $tipocom=$glo->getGETPOST("tipocom");
        $fechaimputacion=$glo->getGETPOST("fechaimputacion");
        $descriptor1=$glo->getGETPOST("descriptor1");
        $descriptor2=$glo->getGETPOST("descriptor2");
        $descriptor3=$glo->getGETPOST("descriptor3");
        $descriptor4=$glo->getGETPOST("descriptor4");
        $detalle=$glo->getGETPOST("detalle");
        $tipoganancia=$glo->getGETPOST("tipoganancia");
    }
}

//echo '<td><select name="item_descriptor11" id="item_descriptor11" onchange="cargades2v(this.value, "item_descriptor", 1)"><option value="908"></option><option value="642">Congelados</option><option value="647">Créditos y Gastos Bancarios</option><option value="3">Elaboración</option><option value="648">Exportación</option><option value="2">Frigorí­fico</option><option value="643">Honorarios</option><option value="644">Impuestos y Tasas</option><option value="4">Inversiones</option><option value="645">Limpieza</option><option value="887">Mantenimiento</option><option value="646">Oficina</option><option value="1">Reparto</option><option value="5">Sueldos</option></select> '
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
        width:<?= $_SESSION['anchopantalla']?>px;
        height:75px;
        z-index:1;
        margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        padding-right: 100px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.19"></script>
<script type="text/javascript" src="planbjs/compras.js?21"></script>
<script src="js/jquery-1.3.3.js" type="text/javascript"></script>
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

function get_iva17(val) {
    if(val!="" && val!=0) {
        document.form1.iva17.value=val*17.335/100;
    }
}

function get_totalfactura() {
    var total=0;
    //alert(parseFloat(document.form1.neto21.value));
    if(document.form1.neto21.value>0)
        total+=parseFloat(document.form1.neto21.value);
    if(document.form1.neto10.value>0)
        total+=parseFloat(document.form1.neto10.value);
    if(document.form1.neto27.value>0)
        total+=parseFloat(document.form1.neto27.value);
    if(document.form1.neto17.value>0)        
        total+=parseFloat(document.form1.neto17.value);
    if(document.form1.iva21.value>0)
        total+=parseFloat(document.form1.iva21.value);
    if(document.form1.iva10.value>0)
        total+=parseFloat(document.form1.iva10.value);
    if(document.form1.iva27.value>0)
        total+=parseFloat(document.form1.iva27.value);
    if(document.form1.iva17.value>0)
        total+=parseFloat(document.form1.iva17.value);
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
    
    document.form1.totalfactura.value=total;
}

function calculanetoiva17(val) {
    neto=val/1.17335;
    iva=val-neto;
    neto=Math.round(neto*100)/100;
    iva=Math.round(iva*100)/100;
    document.getElementById("neto17").value=neto;
    document.getElementById("iva17").value=iva;

}

</script>


</head>
<?require_once 'estilos.php';?>
<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="adm_com_var_add_save.php" method="post">
        <tr>
            <? include("adm_menu.php") ?>
            <input name="id" type="hidden" id="id" value="<?= $id?>" />
            <input name="primero" type="hidden" id="primero" value="1" />
            <input name="cantc" type="hidden" id="cantc" value="<?= $cantc?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $clave?>" />
            <input name="generarimporte" type="hidden" id="generarimporte" value="<?= $generarimporte?>" />
            
            <input name="cantidaddet" id="cantidaddet" type="hidden" value="0" />
            <input name="prvanterior" id="prvanterior" type="hidden" value="<?= $idprv?>" />
            <input name="ptoanterior" id="ptoanterior" type="hidden" value="<?= $ptovta?>" />
            <input name="nroanterior" id="nroanterior" type="hidden" value="<?= $numero?>" />
            <input name="prv" id="prv" type="hidden" value="<?= $idprv?>" />    
            <input name="tipocaja" id="tipocaja" type="hidden" value="0" />
            
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <? require_once 'displayusuario.php';?>
                    <tr>
                        <td>
                            <div class="panelmax910 letra6">
                                <div id="effect-panelmax910" class="ui-widget-content ui-corner-all">
                                    <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                        <tr>
                                            <td colspan="2"><a href="javascript: document.form1.action='adm_com_var_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                        </tr>                                        
                                        <tr>
                                            <td>
                                                Fecha&nbsp;<input name="fecha" type="date"class="letra6" id="fecha" value="<?= $fecha?>" onblur="javascript: document.form1.fechaven.value=document.form1.fecha.value; document.form1.fechaimputacion.value=document.form1.fecha.value; VerificaCompra()" /> | 
                                                Comprobante&nbsp;<select name="tipocom" id="tipocom">
                                                    <? 
                                                    $aid=array(1,2,3);
                                                    $atex=array("Factura","Nota de Credito", "Nota de Debito");
                                                    $sup->cargaComboArrayValor($atex, $aid, $tipocom);
                                                    ?>
                                                </select>| 
                                                    Letra&nbsp;
                                                    <input name="letra" id="letra" size="2" type="text" readonly="readonly" style="text-align: center" /> | 
                                                    P.Venta&nbsp;<input name="ptovta" type="text"class="letra6" id="ptovta" size="4" maxlength="4" value="<?= $ptovta?>" onkeypress="return validar(event)" style="text-align: center" onblur="VerificaCompra()" /> | 
                                                    Numero&nbsp;<input name="numero" type="text"class="letra6" id="numero" size="8" maxlength="8" value="<?= $numero?>" onkeypress="return validar(event)" style="text-align: center" onblur="VerificaCompra()" /> 
                                                    <p style="color: yellow; background-color: red; display: none; font-weight: bold; text-align: center" id="errorrep">*** ERROR: YA FUE INGRESADO ESTE COMPROBANTE ***</p>
                                                    <p style="background-color: yellow; display: none; font-weight: bold; text-align: center" id="errorret">*** ATENCIÓN: YA EXISTE EL COMPROBANTE CON ESE NÚMERO EN OTRO PROVEEDOR ***</p>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Proveedor&nbsp;<select name="idprv" id="idprv" onchange="javascript: Letra(this.value); VerificaCompra()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=2 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel")
                                                ?>
                                                </select> | 
                                                C.A.I. Nro.&nbsp;<input name="cainro" type="text"class="letra6" id="cainro" size="15" maxlength="15" value="<?= $cainro?>" onkeypress="return validar(event)" style="text-align: center" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0">
                                                    <tr id="cartelneto">
                                                        <td width="12.5%">Neto 10.5%</td>
                                                        <td width="12.5%">Iva 10.5%</td>
                                                        <td width="12.5%">Neto 21%</td>
                                                        <td width="12.5%">Iva 21%</td>
                                                        <td width="12.5%">Neto 27%</td>
                                                        <td width="12.5%">Iva 27%</td>
                                                        <td width="12.5%">Neto 17.335%</td> 
                                                        <td width="12.5%">Iva 17.335%</td>                                                        
                                                    </tr>
                                                    <tr id="textoneto">
                                                        <td><input name="neto10" type="text" class="letra6" id="neto10" size="12" maxlength="12" value="<?= $neto10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva10" type="text" class="letra6" id="iva10" size="12" maxlength="12" value="<?= $iva10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto21" type="text" class="letra6" id="neto21" size="12" maxlength="12" value="<?= $neto21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva21" type="text" class="letra6" id="iva21" size="12" maxlength="12" value="<?= $iva21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto27" type="text" class="letra6" id="neto27" size="12" maxlength="12" value="<?= $neto27?>" onkeypress="return validar_punto(event)" onblur="get_iva27(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva27" type="text" class="letra6" id="iva27" size="12" maxlength="12" value="<?= $iva27?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto17" type="text" class="letra6" id="neto17" size="12" maxlength="12" value="<?= $neto17?>" onkeypress="return validar_punto(event)" onblur="get_iva17(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva17" type="text" class="letra6" id="iva17" size="12" maxlength="12" value="<?= $iva17?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="cartelx1">Exento</td>
                                                        <td>No Gravado</td>
                                                        <td id="cartelx2">Imp. Internos</td>
                                                        <td id="cartelx3">Percepcion IVA</td>
                                                        <td id="cartelx4">Retencion IVA</td>
                                                        <td id="cartelx5">Per / Ret IIBB</td>
                                                        <td id="cartelx6">Neto + IVA 17.335</td>
                                                        <td id="cartelx7"><input name="total17" id="total17" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: calculanetoiva17(this.value)" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="textox1"><input name="exento" type="text"class="letra6" id="exento" size="12" maxlength="12" value="<?= $exento?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="nogravado" type="text"class="letra6" id="nogravado" size="12" maxlength="12" value="<?= $nogravado?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td id="textox2"><input name="impinternos" type="text"class="letra6" id="impinternos" size="12" maxlength="12" value="<?= $impinternos?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td id="textox3"><input name="periva" type="text"class="letra6" id="periva" size="12" maxlength="12" value="<?= $periva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td id="textox4"><input name="retiva" type="text"class="letra6" id="retiva" size="12" maxlength="12" value="<?= $retiva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td id="textox5"><input name="retiibb" type="text"class="letra6" id="retiibb" size="12" maxlength="12" value="<?= $retiibb?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td colspan="2">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Vencimiento</td>
                                                        <td colspan="2">Fecha Imputación</td>
                                                        <td colspan="3">&nbsp;</td>
                                                        <td>TOTAL</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><input name="fechaven" type="date"class="letra6" id="fechaven" value="<?= $fechaven?>" /></td>
                                                        <td colspan="2"><input name="fechaimputacion" type="date"class="letra6" id="fechaimputacion" value="<?= $fechaimputacion?>" /></td>
                                                        <td colspan="3">&nbsp;</td>
                                                        <td><input name="totalfactura" type="text" class="letra6bold" id="totalfactura" size="12" maxlength="12" style="font-size: 15px; text-align: center" readonly="readonly" style="border: none; background-color: #eeeeee; text-align: center" value="<?= $totalfactura?>" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><hr></hr></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tipo de compra para Retención de Ganancia <select name="tipoganancia" id="tipoganancia">
                                                    <?
                                                    $array=array("Bienes", "Servicios");
                                                    $avalor=array(0,1);
                                                    $sup->cargaComboArrayValor($array, $avalor, $tipoganancia);
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>                                       
                                        <tr>
                                            <td>
                                                <hr></hr>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panelmax960 letra6">
                                                <div id="effect-panelmax960" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Detalle</td>
                                                            <td>Descriptores</td>
                                                            <td width="10%">Importe</td>
                                                            <td><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" id="item_detalle0" name="item_detalle0" size="50" maxlength="100" /></td>
                                                            <td>
                                                                <select name="item_descriptor10" id="item_descriptor10" onchange="cargades2v(this.value, 'item_descriptor', 0)">
                                                                <?
                                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                                //echo $ssql;
                                                                $sup->cargaCombo3($ssql, 0, "Ninguno");
                                                                ?>
                                                                </select> 
                                                                <select name="item_descriptor20" id="item_descriptor20" onchange="cargades3v(this.value, 'item_descriptor', 0)">
                                                                </select><br>
                                                                <select name="item_descriptor30" id="item_descriptor30" onchange="cargades4v(this.value, 'item_descriptor', 0)">
                                                                </select>
                                                                <select name="item_descriptor40" id="item_descriptor40">
                                                                </select>
                                                            </td>
                                                            <td><input name="item_importe0" id="item_importe0" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>                                        
                                        <tr>
                                            <td colspan="2" align="center">
                                                <div id="agregar" style="visibility: hidden"><input type="submit" name="cmdOk" id="cmdOk" value="<?= $botoncap?>" /></div>
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
function cargades2x(a, b, c) {
    alert(a + b + c);
}    
    
$(document).ready(function(){
 
 $(document).on('click', '.add', function(){
  var html = '';
  document.getElementById("cantidaddet").value=parseInt(document.getElementById("cantidaddet").value) +1;
  cantidaddet=document.getElementById("cantidaddet").value;
  html += '<tr>';
  html += '<td><input type="text" id="item_detalle' + cantidaddet + '" name="item_detalle' + cantidaddet + '" size="50" maxlength="100" /></td>';
  html += '<td><select name="item_descriptor1' + cantidaddet + '" id="item_descriptor1' + cantidaddet + '" onchange="cargades2v(this.value, \'item_descriptor\', ' + cantidaddet + ')"><?php cargadescriptor() ?></select> ';
  html += '<select name="item_descriptor2' + cantidaddet + '" id="item_descriptor2' + cantidaddet + '" onchange="cargades3v(this.value, \'item_descriptor\', ' + cantidaddet +')"></select><br>';
  html += '<select name="item_descriptor3' + cantidaddet + '" id="item_descriptor3' + cantidaddet + '" onchange="cargades4v(this.value, \'item_descriptor\', ' + cantidaddet +')"></select> ';
  html += '<select name="item_descriptor4' + cantidaddet + '" id="item_descriptor4' + cantidaddet + '"></select></td>';
  html += '<td><input name="item_importe' + cantidaddet + '" id="item_importe' + cantidaddet + '" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_remito();
 });
  
});
</script>
