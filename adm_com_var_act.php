<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_act.php
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
require_once 'clases/adm_com_det.php';
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
$carteltarea="Modifica Compras Proveedores Varios";
$botoncap="Modificar!";
$adm=new adm_com_1($id);
$fecha=$adm->getFecha();
$letra=$adm->getLetra();
$ptovta=$adm->getPtovta();
$numero=$adm->getNumero();
$idprv=$adm->getIdprv();
$prv=new adm_prv_1($idprv);
//echo $idprv."aca";  
$cainro=$adm->getCainro();
$neto21=$adm->getNeto21();
$neto10=$adm->getNeto10();
$neto27=$adm->getNeto27();
$neto17=$adm->getNeto17();
$iva21=$adm->getIva21();
$iva10=$adm->getIva10();
$iva27=$adm->getIva27();
$iva17=$adm->getIva17();
$detalle=$adm->getDetalle();
$tipo=$adm->getTipo();
$impinternos=$adm->getImpinternos();
$nogravado=$adm->getNogravado();
$exento=$adm->getExento();
$periva=$adm->getPeriva();
$retiva=$adm->getRetiva();
$retiibb=$adm->getPerretiibb(); 
$fechaven=$adm->getFechaven();
$tipocom=$adm->getTipocom();
$d_des1=$adm->getDet_descriptor1();
$d_des2=$adm->getDet_descriptor2();
$d_des3=$adm->getDet_descriptor3();
$d_des4=$adm->getDet_descriptor4();
$d_det=$adm->getDet_detalle();
$d_imp=$adm->getDet_importe();
$d_id=$adm->getDet_id();
$fechaimputacion=$adm->getFechaimputacion();
$importepag=$adm->getImportepag();
$tipoganancia=$adm->getTipoganancia();
$totalfactura=$neto10+$neto21+$neto27+$neto17+$iva21+$iva10+$iva27+$iva17+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos;
$ssql="select * from adm_com_det where idcom=$id";
//echo $ssql;
$cantidaddet=count($d_id);

//$d_cantidad=count($cantidaddet);
        
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
<script type="text/javascript" src="planb.js?1.0.5"></script>
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

function get_iva17(val) {
    if(val!="" && val!=0) {
        document.form1.iva17.value=val*17.335/100;
    }
}

function get_totalfactura() {
    var total=0;
//    alert("neto21" + parseFloat(document.form1.neto21.value));
    if(document.form1.neto21.value!="")
        total+=parseFloat(document.form1.neto21.value);
//    alert(total);
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
    <form name="form1" id="form1" action="adm_com_var_act_save.php" method="post">
        <tr>
            <? include("adm_menu.php") ?>
            <input name="id" type="hidden" id="id" value="<?= $id?>" />
            <input name="primero" type="hidden" id="primero" value="1" />
            <input name="cantc" type="hidden" id="cantc" value="<?= $cantc?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $clave?>" />
            <input name="cantidaddet" id="cantidaddet" type="hidden" value="<?= count($d_id)-1?>" />
            <input name="clave" type="hidden" id="clave" value="<?= $adm->getClave()?>" />
            <input name="tipocaja" id="tipocaja" type="hidden" value="0" />
            
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <? require_once 'displayusuario.php';?>
                    <tr>
                        <td>
                            <div class="panelmax960 letra6">
                                <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                    <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                        <tr>
                                            <td colspan="2"><a href="javascript: document.form1.action='adm_com_var_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
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
                                        
                                        <tr>
                                            <td>
                                                Proveedor&nbsp;<select name="idprv" id="idprv" onblur="verificanumerocompra(this.value, document.form1.ptovta.value, document.form1.numero.value)">
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
                                                    <tr>
                                                        <td>Neto 10.5%</td>
                                                        <td>Iva 10.5%</td>
                                                        <td>Neto 21%</td>
                                                        <td>Iva 21%</td>
                                                        <td>Neto 27%</td>
                                                        <td>Iva 27%</td>
                                                        <td>Neto 17%</td>
                                                        <td>Iva 17%</td>
                                                    </tr>
                                                    <tr>
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
                                                        <td>Exento</td>
                                                        <td>No Gravado</td>
                                                        <td>Imp. Internos</td>
                                                        <td>Percepcion IVA</td>
                                                        <td>Retencion IVA</td>
                                                        <td>Per / Ret IIBB</td>
                                                        <td>Neto + IVA 17.335</td>
                                                        <td><input name="total17" id="total17" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" onblur="javascript: calculanetoiva17(this.value)" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="exento" type="text"class="letra6" id="exento" size="12" maxlength="12" value="<?= $exento?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="nogravado" type="text"class="letra6" id="nogravado" size="12" maxlength="12" value="<?= $nogravado?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="impinternos" type="text"class="letra6" id="impinternos" size="12" maxlength="12" value="<?= $impinternos?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="periva" type="text"class="letra6" id="periva" size="12" maxlength="12" value="<?= $periva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="retiva" type="text"class="letra6" id="retiva" size="12" maxlength="12" value="<?= $retiva?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
                                                        <td><input name="retiibb" type="text"class="letra6" id="retiibb" size="12" maxlength="12" value="<?= $retiibb?>" onkeypress="return validar_punto(event)" onblur="get_totalfactura()" style="text-align: center" /></td>
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
                                                        <td><input name="totalfactura" type="text" class="letra6bold" id="totalfactura" size="12" maxlength="12" style="font-size: 15px; text-align: center" readonly="readonly" style="border: none; background-color: #eeeeee; text-align: center" value="<?= $totalfactura?>" /></td>
                                                        <td><input name="importepag" id="importepag" class="letra6" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" value="<?= $importepag?>" /></td>
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
                                        <td colspan="2">
                                            <div class="panelmax960 letra6">
                                                <div id="effect-panelmax960" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">
                                                            <td>Detalle</td>
                                                            <td width="50%">Descriptores</td>
                                                            <td width="10%" align="center">Importe</td>
                                                            <td width="5%" align="center"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <? for($i=0;$i<$cantidaddet;$i++) { ?>                                                        
                                                        <tr>
                                                            <td><input type="text" id="item_detalle<?= $i?>" name="item_detalle<?= $i?>" size="50" maxlength="100" value="<?= $d_det[$i] ?>" /></td>
                                                            <td>
                                                                <select name="item_descriptor1<?= $i?>" id="item_descriptor1<?= $i?>" onchange="cargades2v(this.value, 'item_descriptor', <?= $i?>)">
                                                                    <?
                                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                                    //echo $ssql;
                                                                    $sup->cargaCombo3($ssql, $d_des1[$i], "Ninguno");
                                                                    ?>
                                                                </select> 
                                                                <select name="item_descriptor2<?= $i?>" id="item_descriptor2<?= $i?>" onchange="cargades3v(this.value, 'item_descriptor',<?= $i?>)">
                                                                    <?
                                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=".$d_des1[$i]." order by texto";
                                                                    //echo $ssql;
                                                                    $sup->cargaCombo3($ssql, $d_des2[$i], "Ninguno");
                                                                    ?>                                                                
                                                                </select><br>
                                                                <select name="item_descriptor3<?= $i?>" id="item_descriptor3<?= $i?>" onchange="cargades4v(this.value, 'item_descriptor',<?= $i?>)">
                                                                    <?
                                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=".$d_des2[$i]." order by texto";
                                                                    //echo $ssql;
                                                                    $sup->cargaCombo3($ssql, $d_des3[$i], "Ninguno");
                                                                    ?>                                                                  
                                                                </select> 
                                                                <select name="item_descriptor4<?= $i?>" id="item_descriptor4<?= $i?>">
                                                                    <?
                                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=".$d_des3[$i]." order by texto";
                                                                    //echo $ssql;
                                                                    $sup->cargaCombo3($ssql, $d_des4[$i], "Ninguno");
                                                                    ?>                                                                  
                                                                </select>
                                                            </td>
                                                            <td align="center"><input type="text" id="item_importe<?= $i?>" name="item_importe<?= $i?>" size="12" maxlength="12" value="<?= $d_imp[$i] ?>" onkeypress="return validar_punto(event)" style="text-align: center" /></td>
                                                            <td align="center"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                        </tr>
                                                        <? } ?> 
                                                    </table>
                                                </div>
                                            </div>
                                        </td>                    
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
<script>
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
  html += '<td align="center"><input name="item_importe' + cantidaddet + '" id="item_importe' + cantidaddet + '" type="text" size="12" maxlength="12" onkeypress="return validar_punto(event)" style="text-align: center" /></td>';
  html += '<td align="center"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_remito();
 });
  
});
</script>