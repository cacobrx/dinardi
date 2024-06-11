<?php
/*
 * Creado el 13/04/2020 09:05:10
 * Autor: gus
 * Archivo: adm_opg_retg_mod.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/adm_com.php';
require_once 'clases/adm_prv.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$op1=new adm_opg1_1($idop);
$proveedor=$op1->getProveedor();
$direccion=$op1->getDireccion();
$concepto=$op1->getConcepto();
$fecha=$dsup->getFechaNormalCorta($op1->getFecha());
$numeroret=$op1->getNumeroret();
$numeroretg=$op1->getNumeroretg();
$tiposer=$op1->getTiposer();
$d_fec=$op1->getD_fecha();
$d_com=$op1->getD_comprobante();
$d_imp=$op1->getD_importetotal();
$d_can=$op1->getD_importecancelado();
$d_tip=$op1->getD_tipo();
$a_det=$op1->getE_detalle();
$a_imp=$op1->getE_importe();
$d_net=$op1->getD_neto();
$a_id=$op1->getE_id();
$totaltotal=array_sum($a_imp);
$canti=count($a_imp);
$carteltarea="Recalcula RETENCIONES";
$conn=$conx->conectarBase();
$fechaini=date("Y-m-01", strtotime($op1->getFecha()));
$fechafin=$op1->getFecha();
if(strpos($concepto,"M-"))
    $ssql="select * from adm_opg1 where idprv=".$op1->getIdprv()." and fecha>='$fechaini' and fecha<='$fechafin' and id<$idop and instr(concepto,'M-')>0";
else
    $ssql="select * from adm_opg1 where idprv=".$op1->getIdprv()." and fecha>='$fechaini' and fecha<='$fechafin' and id<$idop and instr(concepto,'M-')=0";
//echo $ssql."\n";
$rs=$conx->consultaBase($ssql, $conn);
$f_neto=array();
$condicion="";
$retencionanterior=0;
while($reg=mysqli_fetch_object($rs)) {
    $condicion.="idopg=".$reg->id." or ";
    $retencionanterior+=$reg->retencionganancia;
}

if($condicion!="") {
    $ssql="select * from adm_com where ".substr($condicion,0,strlen($condicion)-4);
//    echo $ssql."\n";
    $com=new adm_com_2($ssql);
    $f_neto=$com->getNeto();
}
$prv=new adm_prv_1($op1->getIdprv());
$porcentajeiibb=$prv->getRetencioniibb();
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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<?require_once 'estilos.php'; ?>

</head>

<body onload="totalizar(<?= $canti?>)">
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="tarea" id="tarea" type="hidden" />
        <input name="id" id="id" type="hidden" />
        <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'; ?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_opg_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                      <td align="right">ID&nbsp;</td>
                                      <td class="letra6bold"><?= $op1->getId()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td class="letra6bold"><?= $dsup->getFechaNormalCorta($op1->getFecha())?></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Proveedor&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $op1->getProveedor()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Dirección&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getDireccion()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Concepto&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getConcepto()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getTipodes()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo de Compra para Ret. Ganancias&nbsp;</td>
                                        <td class="letra6bold"><? if($d_tip[0]==1) echo "Bienes"; else echo "Servicios";?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Total Importe&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getImporte(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Renteción IIBB&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getRetencioniibb(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Retención Ganancia&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getRetencionganancia(),2)?></td>
                                    </tr>
                                   <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Aplicación de Documentos</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6bold">
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="30%">Comprobante</td>
                                                            <td width="10%" align="right">Importe</td>
                                                            <td width="10%" align="right">Neto</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? for($i=0;$i<count($d_can);$i++) { ?>
                                                        <tr>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($d_fec[$i])?></td>
                                                            <td><?= $d_com[$i]?></td>
                                                            <td align="right">$<?= number_format($d_imp[$i],2)?></td>
                                                            <td align="right">$<?= number_format($d_net[$i],2)?></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Cálculo Retenciones de IIBB</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr>
                                                            <td>Número <input name="numeroret" id="numeroret" type="text" value="<?= $numeroret?>" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Importe Neto</td>
                                                            <td align="right"><?= number_format(array_sum($d_net),2)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Porcetaje a Aplicar</td>
                                                            <td align="right"><?= number_format($porcentajeiibb,2)?></td>
                                                        </tr>
                                                        <? $retencioniibb=array_sum($d_net)*$porcentajeiibb/100;?>
                                                        <tr style="background-color: black; color: yellow; font-weight: bold">
                                                            <td>Retención Final</td>
                                                            <td align="right"><?= number_format($retencioniibb,2)?></td>
                                                            <input name="retencioniibb" id="retencioniibb" type="hidden" value="<?= $retencioniibb?>" />
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><hr></hr></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center"><input name="cmdret1" id="cmdret1" type="submit" value="Ajustar Retención IIBB" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_opg_retiibb_mod_save.php'; document.form1.submit()" /></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Cálculo Retenciones de Ganancias</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr>
                                                            <td>Número <input name="numeroretg" id="numeroretg" type="text" value="<?= $numeroretg?>" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Neto Sumado Anterior</td>
                                                            <td align="right"><?= number_format(array_sum($f_neto),2)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Neto Actual</td>
                                                            <td align="right"><?= number_format(array_sum($d_net),2)?></td>
                                                        </tr>
                                                        <tr class="letra6bold">
                                                            <td>Neto Total</td>
                                                            <td align="right"><?= number_format(array_sum($f_neto)+array_sum($d_net),2)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mínimo no Imponible</td>
                                                            <td align="right">
                                                                <?
                                                                if($tiposer==1) {
                                                                    echo number_format($cfg->getMinimoretenciones(),2);
                                                                    $minimo=$cfg->getMinimoretenciones();
                                                                } else {
                                                                    echo number_format($cfg->getMinimoretencionesser(),2);
                                                                    $minimo=$cfg->getMinimoretencionesser();
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <? $netoaplicar=array_sum($f_neto)+array_sum($d_net)-$minimo;
                                                        $retencion1=(array_sum($f_neto)+array_sum($d_net)-$minimo)*2/100;
                                                        $retencionfinal=(array_sum($f_neto)+array_sum($d_net)-$minimo)*2/100-$retencionanterior;
                                                        
                                                        if($netoaplicar>0) { ?>
                                                        <tr class="letra6bold">
                                                            <td>Neto a Aplicar la Retención</td>
                                                            <td align="right"><?= number_format(array_sum($f_neto)+array_sum($d_net)-$minimo,2)?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Retención Ganancias (2% neto)</td>
                                                            <td align="right"><?= number_format($retencion1,2)?></td>
                                                        </tr>
                                                        <tr class="letra6">
                                                            <td>Retención Anterior</td>
                                                            <td align="right"><?= number_format($retencionanterior,2)?></td>
                                                        </tr>
                                                        <tr style="background-color: black; color: yellow; font-weight: bold">
                                                            <td>Retención Final</td>
                                                            <td align="right"><?= number_format($retencionfinal,2)?></td>
                                                            <input name="retencionfinal" id="retencionfinal" type="hidden" value="<?= $retencionfinal?>" />
                                                        </tr>
                                                        <? } else { ?>
                                                        <tr style="background-color: black; color: yellow; font-weight: bold">
                                                            <td>Retención Final</td>
                                                            <td align="right"><?= number_format(0,2)?></td>
                                                            <input name="retencionfinal" id="retencionfinal" type="hidden" value="0" />
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                            <td colspan="2"><hr></hr></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="center"><input name="cmdret1" id="cmdret1" type="submit" value="Ajustar Retención Ganancia" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_opg_retg_mod_save.php'; document.form1.submit()" /></td>
                                                        </tr>
                                                    </table>
                                                </div>
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
