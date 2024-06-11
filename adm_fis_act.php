<?
/*
 * Creado el 14/05/2014 14:52:58
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_act.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_fis_cped.php';
$dsup=new datesupport();
$sup=new support();
//$cfg=new planb_config_1($centrosel);
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$cantd=$glo->getGETPOST("cantd");
$primero=$glo->getGETPOST("primero");
$cantidadcped=$glo->getGETPOST("cantidadcped");
if($cantidadcped=="") $cantidadcped=1;
if($cantd=="")
    $cantd=1;
if($primero==1) {
    if($tarea=="A") {
        $carteltarea="Agrega Comprobante";
        $botoncap="Agregar!";
    } else {
        $carteltarea="Modifica Comprobante";
        $botoncap="Modificar!";
    }
    $idcli=$glo->getGETPOST("idcli");
    $netocf10=$glo->getGETPOST("netocf10");
    $netocf21=$glo->getGETPOST("netocf21");
    $netori10=$glo->getGETPOST("netori10");
    $netori21=$glo->getGETPOST("netori21");
    $ivacf10=$glo->getGETPOST("ivacf10");
    $ivacf21=$glo->getGETPOST("ivacf21");
    $ivari10=$glo->getGETPOST("ivari10");
    $ivari21=$glo->getGETPOST("ivari21");
    $nogravado=$glo->getGETPOST("nogravado");
    $totaltotal=$glo->getGETPOST("totaltotal");
    $importepago=$glo->getGETPOST("importepago");
    $tipocom=$glo->getGETPOST("tipocom");
    $letra=$glo->getGETPOST("letra");
    $ptovta=$glo->getGETPOST("ptovta");
    $numero=$glo->getGETPOST("numero");
    $fecha=$glo->getGETPOST("fecha");
    $tipopago=$glo->getGETPOST("tipopago");
    $imprimir=$glo->getGETPOST("imprimir");
    $docreferencia=$glo->getGETPOST("docreferencia");
    $condicioniva=$glo->getGETPOST("condicioniva");
    $nrocuit=$glo->getGETPOST("nrocuit");
    $anomes=$glo->getGETPOST("anomes");
    $cliente=$glo->getGETPOST("cliente");
    $direccion=$glo->getGETPOST("direccion");
    $ciudad=$glo->getGETPOST("ciudad");
    $totaltotal=$glo->getGETPOST("totaltotal");
    $numerocae=$glo->getGETPOST("numerocae");
    $fechacae=$glo->getGETPOST("fechacae");
    $fechaperini=$glo->getGETPOST("fechaperini");
    $fechaperfin=$glo->getGETPOST("fechaperfin");
    $idped=$glo->getGETPOST("idped");
    $subtotal=$glo->getGETPOST("subtotal");
    $recargo=$glo->getGETPOST("recargo");
    $descuento=$glo->getGETPOST("descuento");
    $percepcioniibb=$glo->getGETPOST("percepcioniibb");
    $porcentajeiibb=$glo->getGETPOST("porcentajeiibb");
//    print_r($idcped);
} else {
    if($tarea=="A") {
        $carteltarea="Agrega Comprobante";
        $botoncap="Agregar!";
        $idcli=0;
        $netocf10="";
        $netocf21="";
        $netori10="";
        $netori21="";
        $ivacf10="";
        $ivacf21="";
        $ciudad="";
        $ivari10="";
        $ivari21="";
        $nogravado="";
        $totaltotal="";
        $tipocom="F";
        $letra="B";
        $ptovta=$cfg->getFiscalpuntoventa();
        $numero="";
        $fecha=date("Y-m-d");
        $imprimir=1;
        $tipopago=0;
        $importepago="";
        $docreferencia="";
        $idrec="";
        $anomes="";
        $condicioniva="C.F.";
        $nrocuit=0;
        $numerocae="";
        $fechacae="";
        $cliente="";
        $direccion="";
        $fechaperini=date("Y-m-d");
        $fechaperfin=date("Y-m-d");
        $idped="";
        $subtotal="";
        $recargo="";
        $descuento="";
        $percepcioniibb="";
        $condicioniva=0;
        $fechapago=date("Y-m-d");
        $fechapago=date("Y-m-d", strtotime("$fechapago + 15 days"));
    } else {
        $carteltarea="Modifica Comprobante";
        require_once 'clases/adm_fis.php';
        require_once 'clases/adm_fis_det.php';
        $botoncap="Modificar!";
        $adm=new adm_fis_1($id);
        $id=$adm->getId();
        $cliente=$adm->getCliente();
        $idcli=$adm->getIdcli();
        $totaltotal=$adm->getTotaltotal();
        $importepago=$adm->getImportepago();
        $netocf21=$adm->getNetocf21();
        $netocf10=$adm->getNetocf10();
        $netori21=$adm->getNetori21();
        $netori10=$adm->getNetori10();
        $ivacf21=$adm->getIvacf21();
        $ivacf10=$adm->getIvacf10();
        $ivari21=$adm->getIvari21();
        $ivari10=$adm->getIvari10();
        $tipo=$adm->getTipo();
        $letra=$adm->getLetra();
        $ptovta=$adm->getPtovta();
        $numero=$adm->getNumero();
        $fecha=$adm->getFecha();
        $tipopago=$adm->getTipopago();
        $nogravado=$adm->getNogravado();
        $docreferencia=$adm->getDocreferencia();
        $anomes=$adm->getAnomes();
        $numerocae=$adm->getNumerocae();
        $fechacae=$adm->getFechacae();
        $fechaperini=$adm->getFechaperini();
        $fechaperfin=$adm->getFechaperfin();
        $condicioniva=$adm->getCondicioniva();
        $fechapago=$adm->getFechapago();
        $idped=$adm->getIdped();
        $percepcioniibb=$adm->getPercepcioniibb();
        $porcentajeiibb=$adm->getPorcentajeiibb();
        $ssql="select * from adm_fis_det where idfis=$id order by id";
        $det=new adm_fis_det_2($ssql);
        $d_det=$det->getDetalle();
        $d_can=$det->getCantidad();
        $d_pre=$det->getPrecio();
        $d_iva=$det->getAlicuota();
        $d_idart=$det->getIdart();
        $cantd=count($d_det);
    }
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
<script type="text/javascript" src="planb.js?1.1.19"></script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_fis_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="primero" type="hidden" id="primero" value="1" />
        <input name="cantd" type="hidden" id="cantd" value="<?= $cantd?>" />
        <input name="cantidadcped" id="cantidadcped" type="hidden" value="<?= $cantidadcped?>" />
        <input name="condicioniva" id="condicioniva" type="hidden" value="<?= $condicioniva?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_fis_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="20%">Fecha&nbsp;</td>
                                        <td width="80%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" required /></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Cliente&nbsp;</td>
                                        <td>
                                            <select name="idcli" id="idcli" onchange="javascript: datoscliente(this.value)" required>
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre, '(', id, ')') as campo from adm_cli order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idcli, "Sel");
                                                ?>
                                            </select>
                                            <!--<input name="cliente" id="cliente" type="hidden" value="<?= $cliente?>" />-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Forma de Pago&nbsp;</td>
                                        <td>
                                            <select name="tipopago" id="tipopago">
                                                <?
                                                $array=array("Contado", "Cuenta Corriente");
                                                $avalor=array(0,1);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipopago);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Percepción IIBB&nbsp;</td>
                                        <td>
                                            <input name="percepcioniibb" id="percepcioniibb" value="<?= $percepcioniibb?>" size="10" maxlength="10" type="text" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: calculatotal()" />
                                            <input name="porcentajeiibb" id="porcentajeiibb" value="<?= $porcentajeiibb?>" type="text" size="6" readonly="readonly" style="text-align: center" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Total&nbsp;</td>
                                        <td>
                                            <input name="totaltotal" id="totaltotal" value="<?= $totaltotal?>" size="10" maxlength="10" type="text" onkeypress="return validar_punto(event)" style="text-align: center" readonly />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Pagado&nbsp;</td>
                                        <td>
                                            <input name="importepago" id="importepago" value="<?= $importepago?>" size="10" maxlength="10" type="text" onkeypress="return validar_punto(event)" style="text-align: center" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Doc. Referencia&nbsp;</td>
                                        <td><input name="docreferencia" id="docreferencia" type="text" size="8" maxlength="8" value="<?= $docreferencia?>" onkeypress="return validar(event)" style="text-align: center" /></td>
                                    </tr>
                                  
                                    <tr>
                                        <td align="right">Numero CAE&nbsp;</td>
                                        <td><input name="numerocae" id="numerocae" type="text" size="20" maxlength="20" value="<?= $numerocae?>" onkeypress="return validar(event)" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Venc. CAE&nbsp;</td>
                                        <td><input name="fechacae" id="fechacae" type="date" value="<?= $fechacae?>" class="letra6" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Período desde&nbsp;</td>
                                        <td><input name="fechaperini" id="fechaperini" type="date" class="letra6" value="<?= $fechaperini?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Hasta&nbsp;</td>
                                        <td><input name="fechaperfin" id="fechaperfin" class="letra6" type="date" value="<?= $fechaperfin?>" required /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Vencimiento&nbsp;</td>
                                        <td><input name="fechapago" id="fechapago" class="letra6" type="date" value="<?= $fechapago?>" /></td>
                                    </tr>
<!--                                    <tr>
                                        <td align="right">Pedido&nbsp;</td>
                                        <td>
                                            <input name="idped" if="$idped" type="text" size="6" maxlength="10" value="<?= $idped?>" onkeypress="return validar(event)" style="text-align: center" />
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
<!--                                                <tr>
                                                    <td colspan="4">
                                                        <input name="cmdneto" id="cmdneto" type="button" value="Calcular Neto e IVA" onclick="javascript: calcular_neto_iva()" />
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td width="20%">Neto RI 10.5% <input name="netori10" id="netori10" type="text" value="<?= $netori10?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td width="20%">IVA RI 10.5% <input name="ivari10" id="ivari10" type="text" value="<?= $ivari10?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td width="20%">Neto RI 21% <input name="netori21" id="netori21" type="text" value="<?= $netori21?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td width="20%">IVA RI 21% <input name="ivari21" id="ivari21" type="text" value="<?= $ivari21?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td width="20%">No Grav. <input name="nogravado" id="nogravado" type="text" value="<?= $nogravado?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Neto CF 10.5% <input name="netocf10" id="netocf10" type="text" value="<?= $netocf10?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td>IVA CF 10.5% <input name="ivacf10" id="ivacf10" type="text" value="<?= $ivacf10?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td>Neto CF 21% <input name="netocf21" id="netocf21" type="text" value="<?= $netocf21?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td>IVA CF 21% <input name="ivacf21" id="ivacf21" type="text" value="<?= $ivacf21?>" size="10" readonly="readonly" style="text-align: center" /></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Tipo <select name="tipo" id="tipo">
                                                <? $array=array("Factura","NCredito","NDebito", "Factura CE", "N.Crédito E", "N.Débito E");
                                                $avalor=array("F","C","D","G", "H", "I");
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                ?>
                                            </select>
                                            Letra <select name="letra" id="letra">
                                                <? $array=array("A","B","C");
                                                $sup->cargaComboArrayValor($array, $array, $letra);
                                                ?>
                                            </select> 
                                            Pto.Venta <input name="ptovta" id="ptovta" type="text" size="4" maxlength="4" value="<?= $ptovta?>" style="text-align: center" /> 
                                            <!--<input name="ptovta" id="ptovta" size="4" maxlength="4" value="<?= $ptovta?>" onkeypress="return validar(event)" style="text-align: center" />--> 
                                            Numero <input name="numero" id="numero" size="8" maxlength="8" value="<?= $numero?>" onkeypress="return validar_punto(event)" style="text-align: center" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                                <tr>
                                                    <td width="30%" colspan="5"><a href="javascript: document.form1.cantd.value=parseInt(document.form1.cantd.value)+1;document.form1.action='adm_fis_act.php'; document.form1.submit()"><i class="far fa-plus-square fa-lg" alt="Agregar Línea" title="Agregar Línea"></i></a> 
                                                    <? if($cantd>1) { ?>
                                                        <a href="javascript: document.form1.cantd.value=document.form1.cantd.value-1 ;document.form1.action='adm_fis_act.php'; document.form1.submit()"><i class="far fa-minus-square fa-lg" style="color: #BB0000" alt="Borrar Línea" title="Borrar Línea"></i></a>
                                                    <? } ?> 
                                                    </td>
                                                </tr>
                                                <tr class="letra6bold">
                                                    <td width="10%" align="center">Cant.</td>
                                                    <td width="65%" align="left">Detalle</td>
                                                    <td width="10%" align="center">IVA</td>
                                                    <td width="10%" align="center">Precio</td>
                                                    <td width="10%" align="center">Total</td>
                                                </tr>
                                                <? for($i=0;$i<$cantd;$i++) { 
                                                    $det_cantidad="det_cantidad$i";
                                                    $det_detalle="det_detalle$i";
                                                    $det_precio="det_precio$i";
                                                    $det_alicuota="det_alicuota$i";
//                                                    $det_precio="det_importe$i";
                                                    $det_total="det_total$i";
                                                    $det_idart="det_idart$i";
                                                    if($primero==1) {
                                                        $$det_cantidad=$glo->getGETPOST($det_cantidad);
                                                        $$det_detalle=$glo->getGETPOST($det_detalle);
                                                        $$det_alicuota=$glo->getGETPOST($det_alicuota);
                                                        $$det_precio=$glo->getGETPOST($det_precio);
                                                        $$det_total=$glo->getGETPOST($det_total);
                                                        $$det_idart=$glo->getGETPOST($det_idart);
                                                    } else {
                                                        if($tarea=="M") {
                                                            $$det_cantidad=$d_can[$i];
                                                            $$det_detalle=$d_det[$i];
                                                            $$det_alicuota=$d_iva[$i];
                                                            $$det_precio=$d_pre[$i];
                                                            $$det_total=$d_pre[$i]*$d_can[$i];
                                                            $$det_idart=$d_idart[$i];
                                                        } else {
                                                            $$det_cantidad=$glo->getGETPOST($det_cantidad);
                                                            $$det_detalle=$glo->getGETPOST($det_detalle);
                                                            $$det_alicuota=$glo->getGETPOST($det_alicuota);
                                                            $$det_precio=$glo->getGETPOST($det_precio);
                                                            $$det_total=$glo->getGETPOST($det_total);
                                                            $$det_idart=$glo->getGETPOST($det_idart);
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td align="center"><input name="det_cantidad<?= $i?>" id="det_cantidad<?= $i?>" type="text" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" value="<?= $$det_cantidad?>" onblur="recalcula_det_venta_fis(<?= $i?>); total_venta_fis()" /></td>
                                                        <td align="left">
                                                            <!--<input name="det_detalle<?= $i?>" id="det_detalle<?= $i?>" type="text" size="50" maxlength="100" value="<?= $$detalle?>" />-->
                                                            <input name="det_detalle<?= $i?>" id="det_detalle<?= $i?>" size="50" maxlength="100" type="text" value="<?= $$det_detalle?>" />
                                                        </td>
                                                        <td align="center">
                                                            <select name="det_alicuota<?= $i?>" id="det_alicuota<?= $i?>">
                                                                <?
                                                                $array=array("21.00", "10.50", "0.00");
                                                                $sup->cargaComboArrayValor($array, $array, $$det_alicuota);
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td align="center"><input name="det_precio<?= $i?>" id="det_precio<?= $i?>" type="text" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" value="<?= $$det_precio?>" onblur="recalcula_det_venta_fis(<?= $i?>); total_venta_fis()" /></td>
                                                        <td align="center"><input name="det_total<?= $i?>" id="det_total<?= $i?>" type="text" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" value="<?= $$det_total?>" readonly="readonly" /></td>
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
