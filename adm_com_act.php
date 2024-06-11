<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_act.php
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
require_once 'clases/adm_com.php';
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
$carteltarea="Modifica Compras";
$botoncap="Modificar!";
$adm=new adm_com_1($id);
$fecha=$adm->getFecha();
$letra=$adm->getLetra();
$ptovta=$adm->getPtovta();
$numero=$adm->getNumero();
$idprv=$adm->getIdprv();
$prv=new adm_prv_1($idprv);
$cainro=$adm->getCainro();
$neto21=$adm->getNeto21();
$neto10=$adm->getNeto10();
$neto27=$adm->getNeto27();
$iva21=$adm->getIva21();
$iva10=$adm->getIva10();
$iva27=$adm->getIva27();
$tipo=$adm->getTipo();
$impinternos=$adm->getImpinternos();
$nogravado=$adm->getNogravado();
$exento=$adm->getExento();
$periva=$adm->getPeriva();
$retiva=$adm->getRetiva();
$retiibb=$adm->getPerretiibb(); 
$fechaven=$adm->getFechaven();
$tipocom=$adm->getTipocom();
$fechaimputacion=$adm->getFechaimputacion();
$importepag=$adm->getImportepag();
$totalfactura=$neto10+$neto21+$neto27+$iva21+$iva10+$iva27+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos;

$prv=new adm_prv_1($idprv);
$ssql="select * from adm_rem where idprv=$idprv and idcom=$id order by fecha, id";
$rem=new adm_rem_2($ssql);
$r_id=$rem->getId();
$r_fec=$rem->getFecha();
$r_tot=$rem->getTotal();
$r_neto0=$rem->getNeto0();
$r_neto10=$rem->getNeto10();
$r_neto21=$rem->getNeto21();
$r_iva10=$rem->getIva10();
$r_iva21=$rem->getIva21();
$r_chk=array_fill(0, count($r_id), "checked='checked'");
//echo $ssql."<br>";
$ssql="select * from adm_rem where idprv=$idprv and idcom=0 order by fecha, id";
$rem=new adm_rem_2($ssql);
$x_id=$rem->getId();
$x_fec=$rem->getFecha();
$x_tot=$rem->getTotal();
$x_neto0=$rem->getNeto0();
$x_neto10=$rem->getNeto10();
$x_neto21=$rem->getNeto21();
$x_iva10=$rem->getIva10();
$x_iva21=$rem->getIva21();
for($i=0;$i<count($x_id);$i++) {
    array_push($r_id,$x_id[$i]);
    array_push($r_fec,$x_fec[$i]);
    array_push($r_tot,$x_tot[$i]);
    array_push($r_neto0,$x_neto0[$i]);
    array_push($r_neto10,$x_neto10[$i]);
    array_push($r_neto21,$x_neto21[$i]);
    array_push($r_iva10,$x_iva10[$i]);
    array_push($r_iva21,$x_iva21[$i]);
    array_push($r_chk,"");
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
<script type="text/javascript" src="planb.js?1.0.3"></script>
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
    //alert(parseFloat(document.form1.neto21.value));
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
    
    document.form1.totalfactura.value=total;
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
    <form name="form1" id="form1" action="adm_com_act_save.php" method="post">
        <tr>
            <? include("adm_menu.php") ?>
            <input name="id" type="hidden" id="id" value="<?= $id?>" />
            <input name="primero" type="hidden" id="primero" value="1" />
            <input name="cantc" type="hidden" id="cantc" value="<?= $cantc?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $clave?>" />
            <input name="cantidadrem" id="cantidadrem" type="hidden" value="<?= count($r_id)?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $adm->getClave()?>" />
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
                                            <td>
                                                Fecha&nbsp;<input name="fecha" type="date"class="letra6" id="fecha" value="<?= $fecha?>" onblur="javascript: document.form1.fechaven.value=document.form1.fecha.value; document.form1.fechaimputacion.value=document.form1.fecha.value" /> | 
                                                Comprobante&nbsp;<select name="tipocom" id="tipocom">
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
                                                    Letra&nbsp;<select name="letra" id="letra">
                                                    <?
                                                    $array=array("A","B","C","M","X");
                                                    $sup->cargaComboArrayValor($array, $array, $letra);
                                                    ?>
                                                </select> | 
                                                    P.Venta&nbsp;<input name="ptovta" type="text"class="letra6" id="ptovta" size="4" maxlength="4" value="<?= $ptovta?>" onkeypress="return validar(event)" style="text-align: center" onblur="verificanumerocompra(document.form1.idprv.value, this.value, document.form1.numero.value)" /> | 
                                                    Numero&nbsp;<input name="numero" type="text"class="letra6" id="numero" size="8" maxlength="8" value="<?= $numero?>" onkeypress="return validar(event)" style="text-align: center" onblur="verificanumerocompra(document.form1.idprv.value, document.form1.ptovta.value, this.value)" /> 
                                                <input name="errorcomprobante" id="errorcomprobante" type="text" readonly="readonly" style="border: none" class="letraerror" size="25" />
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Proveedor&nbsp;<select name="idprv" id="idprv" onblur="verificanumerocompra(this.value, document.form1.ptovta.value, document.form1.numero.value)" onchange="javascritp: document.form1.action='adm_com_add.php'; document.form1.submit()"  >
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $idprv, "Sel")
                                                ?>
                                                </select> | 

                                                C.A.I. Nro.&nbsp;<input name="cainro" type="text"class="letra6" id="cainro" size="15" maxlength="15" value="<?= $cainro?>" onkeypress="return validar(event)" style="text-align: center" />
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
                                                        <td><input name="neto10" type="text" class="letra6" id="neto10" size="10" maxlength="10" value="<?= $neto10?>" onkeypress="return validar_punto(event)" onblur="get_iva10(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva10" type="text" class="letra6" id="iva10" size="10" maxlength="10" value="<?= $iva10?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto21" type="text" class="letra6" id="neto21" size="10" maxlength="10" value="<?= $neto21?>" onkeypress="return validar_punto(event)" onblur="get_iva21(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva21" type="text" class="letra6" id="iva21" size="10" maxlength="10" value="<?= $iva21?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="neto27" type="text" class="letra6" id="neto27" size="10" maxlength="10" value="<?= $neto27?>" onkeypress="return validar_punto(event)" onblur="get_iva27(this.value); get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="iva27" type="text" class="letra6" id="iva27" size="10" maxlength="10" value="<?= $iva27?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
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
                                                        <td><input name="retiibb" type="text"class="letra6" id="retiibb" size="10" maxlength="10" value="<?= $retiibb?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vencimiento</td>
                                                        <td>Fecha Imputación</td>
                                                        <td>TOTAL</td>
                                                        <td>Pagado</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="fechaven" type="date"class="letra6" id="fechaven" value="<?= $fechaven?>" /></td>
                                                        <td><input name="fechaimputacion" type="date"class="letra6" id="fechaimputacion" value="<?= $fechaimputacion?>" /></td>
                                                        <td><input name="totalfactura" type="text" class="letra6bold" id="totalfactura" size="10" maxlength="10" style="font-size: 15px; text-align: center" readonly="readonly" style="border: none; background-color: #eeeeee; text-align: center" value="<?= $totalfactura?>" /></td>
                                                        <td><input name="importepag" id="importepag" type="text" value="<?= $importepag?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                    
                                        <tr>
                                            <td colspan="2">
                                                <div class="panel910 letra6">
                                                    <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                            <tr>
                                                                <td colspan="11">
                                                                    <input name="cmdcalcula" id="cmdcalcula" type="button" value="Calcula Importes de Compra" onclick="javascript: set_importes(<?= count($r_id)?>)" />
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
                                                                ?>
                                                            <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                <td align="center">
                                                                        <?= $r_id[$i]?>
                                                                        <input name="r_id<?= $i?>" id="r_id<?= $i?>" type="hidden" value="<?= $r_id[$i]?>" />
                                                                        <input name="r_neto0<?= $i?>" id="r_neto0<?= $i?>" type="hidden" value="<?= number_format($r_neto0[$i],2,".","")?>" />
                                                                        <input name="r_neto10<?= $i?>" id="r_neto10<?= $i?>" type="hidden" value="<?= number_format($r_neto10[$i],2,".","")?>" />
                                                                        <input name="r_neto21<?= $i?>" id="r_neto21<?= $i?>" type="hidden" value="<?= number_format($r_neto21[$i],2,".","")?>" />
                                                                        <input name="r_iva10<?= $i?>" id="r_iva10<?= $i?>" type="hidden" value="<?= number_format($r_iva10[$i],2,".","")?>" />
                                                                        <input name="r_iva21<?= $i?>" id="r_iva21<?= $i?>" type="hidden" value="<?= number_format($r_iva21[$i],2,".","")?>" />
                                                                </td>
                                                                <td align="center"><?= date("d/m/Y", strtotime($r_fec[$i]))?></td>
                                                                <td align="right"><?= number_format($r_neto0[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_neto10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_neto21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_iva10[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_iva21[$i],2)?></td>
                                                                <td align="right"><?= number_format($r_tot[$i],2)?></td>
                                                                <td align="center">
                                                                    <input name="cancela<?= $i?>" id="cancela<?= $i?>" type="checkbox"  value="<?= $r_id[$i]?>" <?= $r_chk[$i] ?> />
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <? } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td colspan="2" align="center">
                                                <input type="submit" name="cmdOk" id="cmdOk" value="<?= $botoncap?>" />
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
