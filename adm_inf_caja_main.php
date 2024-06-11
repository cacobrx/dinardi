<?php
/*
 * Creado el 21/10/2018 16:00:47
 * Autor: gus
 * Archivo: adm_inf_caja_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_caj_mov.php';
require_once 'clases/adm_caj.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_rec.php';
require_once 'clases/support.php';
require_once 'clases/adm_div.php';
require_once 'clases/adm_cht.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$caj=new adm_caj_1($cajacajm);

$saldoini=0;
$totalentrada=0;
$totalsalida=0;
if($cfg->getSaldoinicialcaja()==1) {
    $conn=$conx->conectarBase();

    $ssql="select sum(importedolares*cotizacion) as totdivp, sum(importedolares) as totdivd from adm_div where cajaentrada=$cajacajm and fecha<'$fechainicajm'";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
//    echo $ssql."\n";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    if($caj->getMonedapesos()==1)
        $saldoini+=$reg->totdivp;
    else
        $saldoini+=$reg->totdivd;

    $ssql="select sum(importedolares*cotizacion) as totdivp, sum(importedolares) as totdivd from adm_div where cajasalida=$cajacajm and fecha<'$fechainicajm'";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
//    echo $ssql."\n";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    if($caj->getMonedapesos()==1)
        $saldoini-=$reg->totdivp;
    else
        $saldoini-=$reg->totdivd;


    $ssql="select sum(importe) as totcht from adm_cht where cajaentrada=$cajacajm and fecha<'$fechainicajm'";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $saldoini+=$reg->totcht;


    $ssql="select sum(importefinal) as totcht from adm_cht where cajasalida=$cajacajm and fecha<'$fechainicajm'";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $saldoini-=$reg->totcht;

    $ssql="select sum(importe) as totrec from adm_rec where caja=$cajacajm and fecha<'$fechainicajm'";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $saldoini+=$reg->totrec;

    $ssql="select sum(importe) as totmov from adm_caj_mov where fecha<'$fechainicajm' and idcaj=$cajacajm and tipo=2";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $saldoini+=$reg->totmov;

    $ssql="select sum(importe) as totmov from adm_caj_mov where fecha<'$fechainicajm' and idcaj=$cajacajm and tipo=1";
    if($cfg->getFechainiciocaja()!="") $ssql.=" and fecha>='".$cfg->getFechainiciocaja ()."'";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $saldoini-=$reg->totmov;
    if($saldoini>0)
        $totalentrada+=$saldoini;
    else
        $totalsalida+=abs($saldoini);
}
$sal=$saldoini;


$ssql="select * from adm_rec where fecha>='$fechainicajm' and fecha<='$fechafincajm' and caja=$cajacajm order by fecha, id";
//echo $ssql;
$rec=new adm_rec_2($ssql);
$r_id=$rec->getId();
$r_fec=$rec->getFecha();
$r_doc=$rec->getDocumento();
$r_imp=$rec->getImporte();
$r_ape=$rec->getApellido();
$r_nom=$rec->getNombre();
$r_idc=$rec->getIdcli();
$r_pre=$rec->getIdpre();
$r_cuo=$rec->getCuota();
$totalentrada=array_sum($r_imp);
$sal+=$totalentrada;

$ssql="select * from adm_caj_mov where centro=$centrosel and fecha>='$fechainicajm' and fecha<='$fechafincajm' and idcaj=$cajacajm order by fecha, id";
//echo $ssql;
$adm=new adm_caj_mov_2($ssql);
    
$a_id=$adm->getId();
//print_r($a_id);
$a_fec=$adm->getFecha();
$a_det=$adm->getDetalle();
$a_cta=$adm->getCuenta();
$a_tip=$adm->getTipo();
$a_imp=$adm->getImporte();
$a_est=$adm->getEstado();

for($i=0;$i<count($a_tip);$i++) {
    if($a_tip[$i]==2) {
        $sal+=$a_imp[$i];
        $totalentrada+=$a_imp[$i];
    } else {
        $sal-=$a_imp[$i];
        $totalsalida+=$a_imp[$i];
    }
}


$ssql="select * from adm_caj_mov where centro=$centrosel and cajadestino=$cajacajm and pasadocaja=0 order by fecha, id";
//echo $ssql;
$pen=new adm_caj_mov_2($ssql);
    
$p_id=$pen->getId();
$p_fec=$pen->getFecha();
$p_det=$pen->getDetalle();
$p_cta=$pen->getCuenta();
$p_tip=$pen->getTipo();
$p_imp=$pen->getImporte();
$p_est=$pen->getEstado();




$ssql="select * from adm_div where cajaentrada=$cajacajm and fecha>='$fechainicajm' and fecha<='$fechafincajm' order by fecha, id";
$dive=new adm_div_2($ssql);
$ed_id=$dive->getId();
$ed_det=$dive->getCliente();
if($caj->getMonedapesos()==1)
    $ed_imp=$dive->getImportepesos();
else
    $ed_imp=$dive->getImportedolares();
$ed_fec=$dive->getFecha();
$ed_ope=$dive->getOperacion();
$ed_mon=$dive->getCajasalidades();
$sal+=array_sum($ed_imp);
$totalentrada+=array_sum($ed_imp);

$ssql="select * from adm_div where cajasalida=$cajacajm and fecha>='$fechainicajm' and fecha<='$fechafincajm' order by fecha, id";
$dive=new adm_div_2($ssql);
$sd_id=$dive->getId();
$sd_det=$dive->getCliente();
$sd_ope=$dive->getOperacion();
$sd_mon=$dive->getCajaentradades();
if($caj->getMonedapesos()==1)
    $sd_imp=$dive->getImportepesos();
else
    $sd_imp=$dive->getImportedolares();
$sd_fec=$dive->getFecha();
$sal-=array_sum($sd_imp);
$totalsalida+= array_sum($sd_imp);

$ssql="select * from adm_cht where cajasalida=$cajacajm and fecha>='$fechainicajm' and fecha<='$fechafincajm' order by fecha, id";
$cht=new adm_cht_2($ssql);
$cs_id=$cht->getId();
$cs_cli=$cht->getCliente();
$cs_nro=$cht->getNrocheque();
$cs_ban=$cht->getBancodes();
//$sal-=array_sum($cs_imp);
//$totalsalida+=array_sum($cs_imp);

$ssql="select * from adm_cht where cajaentrada=$cajacajm and fecha>='$fechainicajm' and fecha<='$fechafincajm' order by fecha, id";
$cht=new adm_cht_2($ssql);
$ce_id=$cht->getId();
$ce_cli=$cht->getCliente();
$ce_nro=$cht->getNrocheque();
$ce_ban=$cht->getBancodes();
$ce_imp=$cht->getImporte();
$sal-=array_sum($ce_imp);
$totalentrada+=array_sum($ce_imp);


$importecierre=$adm->getImportcierre();
$cantidadtotal=$adm->getMaxRegistros();
//$totalsalida=0;
//for($i=0;$i<count($a_det);$i++) {
//    if($a_tip[$i]==1) 
//        $totalsalida+=$a_imp[$i];
//    else
//        $totalentrada+=$a_imp[$i];
//}
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<? include("estilos.php");?>
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limcajm" type="hidden" id="limcajm" value="<?= $limcajm?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
                <input name="detallecajm" id="detallecajm" type="hidden" value="<?= $detallecajm?>" />
                <input name="detalledivcajm" id="detalledivcajm" type="hidden" value="<?= $detalledivcajm?>" />
                <input name="totalcaja" id="totalcaja" type="hidden" value="<?= $totalentrada-$totalsalida?>" />
                <input name="detallechtcajm" id="detallechtcajm" type="hidden" value="<?= $detallechtcajm?>" />
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">MOVIMIENTOS DE CAJA</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainicajm" id="fechainicajm" type="date" class="letra6" value="<?= $fechainicajm?>" /> 
                                                    hasta <input name="fechafincajm" id="fechafincajm" type="date" class="letra6" value="<?= $fechafincajm?>" /> | 
                                                    Caja <select name="cajacajm" id="cajacajm" onchange="javascript: document.form1.target='_self'; document.form1.limcajm.value=0; document.form1.action='register_cajm.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, nombre as campo from adm_caj order by nombre";
                                                        $sup->cargaCombo3($ssql, $cajacajm,"Sel");
                                                        ?>
                                                    </select> | 
                                                    <? if($importecierre==0) { ?> | 
                                                    Recuento Caja <input name="importecierre" id="importecierre" type="text" size="10" maxlength="10" class="letra6" onkeypress="return validar_punto(event)" style="text-align: center" /> 
                                                    <input name="cmdcerrar" id="cmdcerrar" value="Cerrar Caja del Día" type="button" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_caj_mov_cierre.php'; document.form1.submit()" /> 
                                                    <? } ?>
                                                </td>
                                            </tr>
                                            <? if($cajacajm>0) { ?>
                                            <tr>
                                                <td>
                                                    <input name="cmdok" id="cmdok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcajm.value=0; document.form1.action='register_cajm.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_inf_caja_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_inf_caja_exp.php'; document.form1.submit()" /> 
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Entradas: </span><?= number_format($totalentrada,2)?><span class="letra6"> | Salidas: </span><?= number_format($totalsalida,2)?><span class="letra6"> | TOTAL CAJA: </span><?= number_format($totalentrada-$totalsalida,2)?><span class="letra2">
                                                        <? if($importecierre>0) { ?>
                                                        | Recuento </span><?= number_format($importecierre,2)?><span class="letra6"> | Diferencia: </span><?= number_format($totalentrada-$totalsalida-$importecierre,2)?>
                                                        <? } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <? 
                                                        if(count($p_id)>0) {
                                                            for($i=0;$i<count($p_id);$i++) { ?>
                                                            <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                <td>
                                                                    <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $p_id[$i]?>; document.form1.action='adm_caj_mov_apr.php'; document.form1.submit()"><i class="far fa-check-circle fa-lg" alt="Aprobar Movimiento de Caja Pendiente" title="Aprobar Movimiento de Caja Pendiente"></i></a> 
                                                                </td>
                                                                <td align="center"><?= $p_id[$i]?></td>
                                                                <td align="center"><?= date("d/m/Y", strtotime($p_fec[$i]))?></td>
                                                                <td align="left"><?= "(".$p_cta[$i].") ".$p_det[$i]." ".$p_est[$i]?></td>
                                                                <? if($p_tip[$i]==1) { ?>
                                                                <td align="right"><?= number_format($p_imp[$i],2)?></td>
                                                                <td align="right">&nbsp;</td>
                                                                <? } else { ?>
                                                                <td align="right">&nbsp;</td>
                                                                <td align="right"><?= number_format($p_imp[$i],2)?></td>
                                                                <? } ?>
                                                                <td align="right"><?= number_format($p_imp[$i],2)?></td>
                                                                <td align="center">
                                                                    <? if($importecierre==0) { ?>
                                                                    <a href="javascript: bajareg(<?= $p_id[$i]?>,'Elimina Movimiento de Caja Pendiente?','adm_caj_mov_del.php')"><i class="fas fa-trash-alt" style="color: #CC0000" alt="Elimina Movimiento de Caja Pendiente" title="Elimina Movimiento de Caja Pendiente"></i></a>
                                                                    <? } ?>
                                                                </td>
                                                            </tr>
                                                                
                                                            <? } ?>
                                                        <tr>
                                                            <td colspan="8"><hr></hr></td>
                                                        </tr>
                                                        <? }?>


                                                        <tr class="letra6bold">
                                                            <td width="5%">
                                                                <? if($importecierre==0) { ?>
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_caj_mov_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" style="color: #449d44" alt="Agregar Movimiento de Caja" title="Agregar Movimiento de Caja"></i></a> 
                                                                <? } ?>
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="20%" align="center">Fecha</td>
                                                            <td width="38%" align="left">Detalle</td>
                                                            <td width="10%" align="right">Entrada</td>
                                                            <td width="10%" align="right">Salida</td>
                                                            <td width="10%" align="right">Saldo</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? if($saldoini!=0) { ?>
                                                            <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                <td colspan="3">&nbsp;</td>
                                                                <td>Saldo Inicial</td>
                                                                <? if($saldoini>0) { ?>
                                                                <td align="right"><?= number_format($saldoini,2)?></td>
                                                                <td>&nbsp;</td>
                                                                <? } else { ?>
                                                                <td>&nbsp;</td>
                                                                <td align="right"><?= number_format(abs($saldoini),2)?></td>
                                                                <? } ?>
                                                                <td align="right"><?= number_format($saldoini,2)?></td>
                                                            </tr>
                                                        <? } ?>
                                                        
                                                        
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($detallecajm==1) { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detallecajm.value=0; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-minus fa-lg" alt="Ocultar Ventas" title="Ocultar Ventas"></i></a>
                                                                <? } else { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detallecajm.value=1; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-plus fa-lg" alt="Mostrar Ventas" title="Mostrar Ventas"></i></a>
                                                                <? } ?>
                                                            </td>
                                                            <td align="center">&nbsp;</td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($fechainicajm))." / ".date("d/m/Y", strtotime($fechafincajm))?></td>
                                                            <td align="left">Recibos de Préstamos</td>
                                                            <td align="right"><?= number_format(array_sum($r_imp),2)?></td>
                                                            <td align="right">&nbsp;</td>
                                                            <td align="right"><?= number_format($saldoini+array_sum($r_imp),2)?></td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>
                                                        
                                                        <? 
                                                        if($detallecajm==1) { 
                                                            $salx=0;
                                                            
                                                            
                                                        for($i=0;$i<count($r_id);$i++) { 
                                                            $salx+=$r_imp[$i];
                                                        ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                            <td>&nbsp;</td>
                                                            <td align="center"><?= $r_id[$i]?></td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($r_fec[$i]))?></td>
                                                            <td align="left"><?= "(".$r_doc[$i].") ".$r_ape[$i]." ".$r_nom[$i]." - Préstamo: ".$r_pre[$i]." / Cuota: ".$r_cuo[$i]?></td>
                                                            <td align="right"><?= number_format($r_imp[$i],2)?></td>
                                                            <td align="right">&nbsp;</td>
                                                            <td align="right"><?= number_format($salx,2)?></td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>

                                                        <? } } ?>

                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($detalledivcajm==1) { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detalledivcajm.value=0; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-minus fa-lg" alt="Ocultar Detalle Divisas" title="Ocultar Detalle Divisas"></i></a>
                                                                <? } else { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detalledivcajm.value=1; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-plus fa-lg" alt="Mostrar Detalle Divisas" title="Mostrar Detalle Divisas"></i></a>
                                                                <? } ?>
                                                            </td>
                                                            <td align="center">&nbsp;</td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($fechainicajm))." / ".date("d/m/Y", strtotime($fechafincajm))?></td>
                                                            <td align="left">Operación de Compra / Venta Divisas</td>
                                                            <td align="right"><?= number_format(array_sum($ed_imp),2)?></td>
                                                            <td align="right"><?= number_format(array_sum($sd_imp),2)?></td>
                                                            <td align="right"><?= number_format($saldoini+array_sum($ed_imp)-array_sum($sd_imp)+array_sum($r_imp),2)?></td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>
                                                        <? if($detalledivcajm==1) {
                                                            $salx=0;
                                                            for($i=0;$i<count($ed_id);$i++) { 
                                                                $salx+=$ed_imp[$i];
                                                                ?>
                                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                                    <td>&nbsp;</td>
                                                                    <td align="center"><?= $ed_id[$i]?></td>
                                                                    <td align="center"><?= date("d/m/Y", strtotime($ed_fec[$i]))?></td>
                                                                    <td align="left"><?= $ed_det[$i]." (".$ed_ope[$i]." ".$ed_mon[$i].")"?></td>
                                                                    <td align="right"><?= number_format($ed_imp[$i],2)?></td>
                                                                    <td align="right">&nbsp;</td>
                                                                    <td align="right"><?= number_format($salx,2)?></td>
                                                                    <td align="center">&nbsp;</td>
                                                                </tr>
                                                            <? }
                                                            for($i=0;$i<count($sd_id);$i++) { 
                                                                $salx-=$sd_imp[$i];
                                                                ?>
                                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                                    <td>&nbsp;</td>
                                                                    <td align="center"><?= $sd_id[$i]?></td>
                                                                    <td align="center"><?= date("d/m/Y", strtotime($sd_fec[$i]))?></td>
                                                                    <td align="left"><?= $sd_det[$i]." (".$sd_ope[$i]." ".$sd_mon[$i].")"?></td>
                                                                    <td align="right">&nbsp;</td>
                                                                    <td align="right"><?= number_format($sd_imp[$i],2)?></td>
                                                                    <td align="right"><?= number_format($salx,2)?></td>
                                                                    <td align="center">&nbsp;</td>
                                                                </tr>
                                                            <? }
                                                        } ?>

                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($detallechtcajm==1) { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detallechtcajm.value=0; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-minus fa-lg" alt="Ocultar Ventas" title="Ocultar Ventas"></i></a>
                                                                <? } else { ?>
                                                                <a href="javascript: document.form1.target='_self'; document.form1.detallechtcajm.value=1; document.form1.action='register_cajm.php'; document.form1.submit()"><i class="fas fa-plus fa-lg" alt="Mostrar Ventas" title="Mostrar Ventas"></i></a>
                                                                <? } ?>
                                                            </td>
                                                            <td align="center">&nbsp;</td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($fechainicajm))." / ".date("d/m/Y", strtotime($fechafincajm))?></td>
                                                            <td align="left">Cheques de Terceros</td>
                                                            <!--<td align="right"><?= number_format(array_sum($ce_imp),2)?></td>-->
                                                            <!--<td align="right"><?= number_format(array_sum($cs_imp),2)?></td>-->
                                                            <!--<td align="right"><?= number_format($saldoini+array_sum($ed_imp)-array_sum($sd_imp)+array_sum($r_imp)+array_sum($ce_imp)-array_sum($cs_imp),2)?></td>-->
                                                            <td align="center">&nbsp;</td>
                                                        </tr>
                                                        
                                                        <? 
                                                        if($detallechtcajm==1) { 
                                                            $salx=0;
                                                        for($i=0;$i<count($ce_id);$i++) { 
                                                            $salx+=$ce_imp[$i];
                                                        ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                            <td>&nbsp;</td>
                                                            <td align="center"><?= $ce_id[$i]?></td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($ce_fec[$i]))?></td>
                                                            <td align="left"><?= $ce_ban[$i]." ".$ce_nro?></td>
                                                            <td align="right"><?= number_format($ce_imp[$i],2)?></td>
                                                            <td align="right">&nbsp;</td>
                                                            <td align="right"><?= number_format($salx,2)?></td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>

                                                        <? } 
                                                        
                                                        for($i=0;$i<count($cs_id);$i++) { 
                                                            $salx-=$cs_imp[$i];
                                                        ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                            <td>&nbsp;</td>
                                                            <td align="center"><?= $cs_id[$i]?></td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($cs_fec[$i]))?></td>
                                                            <td align="left"><?= $cs_ban[$i]." ".$cs_nro[$i]?></td>
                                                            <td align="right">&nbsp;</td>
                                                            <td align="right"><?= number_format($cs_imp[$i],2)?></td>
                                                            <td align="right"><?= number_format($salx,2)?></td>
                                                            <td align="center">&nbsp;</td>
                                                        </tr>

                                                        <? } 
                                                        
                                                        } ?>
                                                        
                                                        
                                                        <? 
//                                                        $sal=$saldoini+array_sum($ed_imp)-array_sum($sd_imp)+array_sum($r_imp)+array_sum($ce_imp)-array_sum($cs_imp);
                                                        for($i=0;$i<count($a_id);$i++) { 
                                                            if($a_tip[$i]==2)
                                                                $sal+=$a_imp[$i];
                                                            else
                                                                $sal-=$a_imp[$i];
                                                        ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($importecierre==0) { ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_caj_mov_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Caja" title="Modifica Caja"></i></a> 
                                                                <? } ?>
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($a_fec[$i]))?></td>
                                                            <td align="left"><?= "(".$a_cta[$i].") ".$a_det[$i]." ".$a_est[$i]?></td>
                                                            <? if($a_tip[$i]==2) { ?>
                                                            <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                            <td align="right">&nbsp;</td>
                                                            <? } else { ?>
                                                            <td align="right">&nbsp;</td>
                                                            <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                            <? } ?>
                                                            <td align="right"><?= number_format($sal,2)?></td>
                                                            <td align="center">
                                                                <? if($importecierre==0) { ?>
                                                                <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Movimiento de Caja?','adm_caj_mov_del.php')"><i class="fas fa-trash-alt" style="color: #CC0000" alt="Elimina Movimiento de Caja" title="Elimina Movimiento de Caja"></i></a>
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <? } ?>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</tr>
            </tr>
        </form>
    </div>
</body>
</html>

