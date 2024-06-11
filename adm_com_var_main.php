<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$condicion=""; 
$ssql="select adm_com.* from adm_com, adm_prv where adm_com.centro=$centrosel and $campofechacva>='$fechainicva' and $campofechacva<='$fechafincva' and adm_com.tipo=2 and adm_com.idprv=adm_prv.id";
if($proveedorcva>0)
    $ssql.=" and adm_com.idprv=$proveedorcva";
$ssqt="select sum(totaltotal) as totalcva from adm_com where $campofechacva>='$fechainicva' and $campofechacva<='$fechafincva' and tipo=2";
if($proveedorcva>0)
    $ssqt.=" and idprv=$proveedorcva";
if($numerocva!="") {
    $ssql.=" and adm_com.numero=$numerocva";
    $ssqt.=" and adm_com.numero=$numerocva";
}
if($descriptor1cva>0)
    $condicion.="adm_com.descriptor1=$descriptor1cva and ";
if($descriptor2cva>0)
    $condicion.="adm_com.descriptor2=$descriptor2cva and ";
if($descriptor3cva>0)
    $condicion.="adm_com.descriptor3=$descriptor3cva and ";
if($descriptor4cva>0)
    $condicion.="adm_com.descriptor4=$descriptor4cva and ";
if($letracva!="") {
    if($letracva=="A+C")
        $condicion.="(adm_com.letra='A' or adm_com.letra='C') and ";
    else
        $condicion.="adm_com.letra='$letracva' and ";
}

if($condicion!="") {
    $ssqt.=" and ".substr($condicion,0,strlen($condicion)-5);
    $ssql.=" and ".substr($condicion,0,strlen($condicion)-5);
}
//echo $ssqt;
$ssqtnc=$ssqt." and tipocom=2";
$ssqt.=" and tipocom!=2";
$rt=$conx->getConsulta($ssqt);
$rtt=  mysqli_fetch_object($rt);
$totalcva=$rtt->totalcva;
//echo $ssqtnc;
$rt=$conx->getConsulta($ssqtnc);
$rtt=  mysqli_fetch_object($rt);
$totalcva-=$rtt->totalcva;
$ssql.=" order by $ordencva limit $limcva,".$cfg->getLimmax();
//$ssql="Select * from adm_com where id=2663";
$adm=new adm_com_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_neto17=$adm->getNeto17();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_iva17=$adm->getIva17();
$a_pri=$adm->getPeriva();
$a_rti=$adm->getRetiva();
$a_prb=$adm->getPerretiibb();
$a_exe=$adm->getExento();
$a_ngr=$adm->getNogravado();
$a_fev=$adm->getFechaimputacion();
$a_imi=$adm->getImpinternos();
$a_mov=$adm->getMovimiento();
$a_asi=$adm->getCantidadasientos();
$a_nasi=$adm->getAsientos();
$m_det=$adm->getMov_detallecon();
$m_ent=$adm->getMov_entrada();
$m_sal=$adm->getMov_salida();
$m_cta=$adm->getMov_cuentades();
$d_ent=$adm->getDet_entrada();
$d_sal=$adm->getDet_salida();
$d_cta=$adm->getDet_cuentades();
$a_comx=$adm->getComprobantetodo();
$d_des1=$adm->getdet_descriptor1des();
$d_des2=$adm->getDet_descriptor2des();
$d_des3=$adm->getDet_descriptor3des();
$d_des4=$adm->getDet_descriptor4des();
$importepag=$adm->getImportepag();
$a_tot=$adm->getTotaltotal();
$a_pag=$adm->getImportepag();
$d_id=$adm->getDet_id();
$a_rep=$adm->getRepetida();
$a_mal=$adm->getMalletra();
$a_close=$adm->getCerrado();

//print_r($a_tot);
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcva)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limcva.value=$ini; document.form1.action=\"register_cva.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letra2'>$j</span></a>";
}
$cadenapaginas=substr($cadenapaginas,1,strlen($cadenapaginas)-1);
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css?2.0.1" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1"></script>
<?require_once 'estilos.php';?>

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
        <input name="limcva" type="hidden" id="limcva" value="<?= $limcva?>" />
        <input name="idprv" type="hidden" id="idprv" value="<?= $idprv?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>                        
                <tr>
                    <td colspan="2">
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">COMPRAS PROVEEDORES VARIOS</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            <select name="campofechacva" id="campofechacva" onchange="javascript: document.form1.limcva.value=0; document.form1.target='_self'; document.form1.action='register_cva.php'; document.form1.submit()">
                                                <?
                                                $array=array("Fecha Origen", "Fecha Imputacion");
                                                $avalor=array("adm_com.fecha","adm_com.fechaimputacion");
                                                $sup->cargaComboArrayValor($array, $avalor, $campofechacva);
                                                ?>
                                            </select>
                                            desde <input name="fechainicva" type="date" class="letra6" id="fechainicva" value="<?= $fechainicva?>" /> 
                                            hasta <input name="fechafincva" type="date" class="letra6" id="fechafincva" value="<?= $fechafincva?>" /> | 
                                            Orden <select name="ordencva" id="ordencva" onchange="javascript: document.form1.target='_self'; document.form1.limcva.value=0; document.form1.action='register_cva.php'; document.form1.submit()">
                                                <?
                                                $array=array("Fecha", "Proveedor");
                                                $avalor=array("adm_com.fecha, adm_com.id", "adm_prv.apellido, adm_prv.nombre, adm_com.id");
                                                $sup->cargaComboArrayValor($array, $avalor, $ordencva)
                                                ?>
                                            </select> | 
                                            <input name="cmdpag" id="cmdpag" type="button" value="Agregar Recibo" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_opg_var_act.php'; document.form1.submit()" /> | 
                                            <input name="cmdcancela" id="cmdcancela" type="button" value="Cancela Comprobante" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_var_canc.php'; document.form1.submit()" /> | 
                                            Letra <select name="letracva" id="letracva" onchange="javascript: document.form1.target='_self'; document.form1.limcva.value=0; document.form1.action='register_cva.php'; document.form1.submit()">
                                                <?
                                                $array=array("A","C","X","A+C");
                                                $sup->cargaComboArrayValor($array, $array, $letracva, "Todos");
                                                ?>
                                            </select> 
                                            Número <input name="numerocva" id="numerocva" type="text" size="8" maxlength="8" value="<?= $numerocva?>" onkeypress="return validar(event)" style="text-align: center" />
                                            <!--<input type="submit" name="Submit" value="Descargar ARBA Retenciones" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_com_arba_retenciones.php'; document.form1.submit()" />-->
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Descriptores 
                                            <select name="descriptor1cva" id="descriptor1cva" onchange="javascript: cargades2v(this.value, 'descriptor', 'cva')">
                                                <?
                                                $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                $sup->cargaCombo3($ssql, $descriptor1cva, "Todos");
                                                ?>
                                            </select> | 
                                            <select name="descriptor2cva" id="descriptor2cva" onchange="javascript: cargades3v(this.value, 'descriptor', 'cva')">
                                                <?
                                                if($descriptor2cva!='') {
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=$descriptor1cva order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor2cva, "Todos");
                                                }
                                                ?>
                                            </select> | 
                                            <select name="descriptor3cva" id="descriptor3cva" onchange="javascript: cargades4v(this.value, 'descriptor', 'cva')">
                                                <?
                                                if($descriptor3cva!='') {
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=$descriptor2cva order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor3cva, "Todos");
                                                }
                                                ?>
                                            </select> | 
                                            <select name="descriptor4cva" id="descriptor4cva">
                                                <?
                                                if($descriptor2cva!='') {
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=$descriptor3cva order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor4cva, "Todos");
                                                }
                                                ?>
                                            </select>                                        
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td>
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcva.value=0; document.form1.action='register_cva.php'; document.form1.submit()" /> | 
<!--                                            <input type="submit" name="cmdCiti" id="cmdCiti" value="Exportar CITI" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_citi.php'; document.form1.submit()" /> 
                                            <input type="submit" name="cmdCitiIVA" id="cmdCitiIVA" value="Exportar CITI Alicuotas" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_citi_iva.php'; document.form1.submit()" /> -->
                                            <input name="cmdlst" id="cmdlst" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_com_var_lst.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdexc" id="cmdexc" value="Exporta Excel" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_var_exp.php'; document.form1.submit()" />
                                            Proveedor <select name="proveedorcva" id="proveedorcva" onchange="javascript: document.form1.limcva.value=0; document.form1.target='_self'; document.form1.action='register_cva.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=2 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $proveedorcva, "Todos");
                                                ?>
                                            </select> | 
                                            Mov.Contables <input name="movimientocva" id="movimientocva" type="checkbox" <? if($movimientocva==1) echo "checked='checked'";?> value="1" onclick="javascript: document.form1.target='_self'; document.form1.action='register_cva.php'; document.form1.submit()" /> | 
                                            Total <strong><?= number_format($totalcva,2)?></strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">Cantidad: <span class="letra6bold"><?= $cantidadtotal?></span> - Pag: <span class="lnk"><?= $cadenapaginas?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="5%">
                                                        <a href="javascript: document.form1.target='_self'; document.form1.action='adm_com_var_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Compras" title="Agregar Compras"></i></a> 
                                                    </td>
                                                    <td width="3%" align="center">#</td>
                                                    <td width="5%" align="center">Fecha</td>
                                                    <td width="3%" align="center">As.</td>
                                                    <td width="10%" align="left">Número</td>
                                                    <td align="left">Proveedor</td>
                                                    <td width="6%" align="right">Neto</td>
                                                    <td width="6%" align="right">Impuestos</td>
                                                    <td width="6%" align="right">Perc. Ret.</td>
                                                    <td width="6%" align="right">Total</td>
                                                    <td width="6%" align="right">Pagado</td>
                                                    <td width="6%" align="center">F.Imput.</td>
                                                    <td width="15%" align="left">Descriptores</td>
                                                    <td width="2%" align="center">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { 
//                                                    $ttot=$a_neto21[$i] + $a_neto10[$i] + $a_neto27[$i] + $a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i];
                                                    if($a_com[$i]==2)
                                                        $calor=-1;
                                                    else
                                                        $calor=1;
                                                    $ccolor="black";
                                                    $bgcol="white";
                                                    $nopago=0;
                                                    if(number_format($a_tot[$i],2)==number_format($a_pag[$i],2)) {
                                                        $ccolor="blue";
                                                        $nopago=1;
                                                    }
                                                    if($a_rep[$i]>1) $bgcol="yellow";
//                                                    echo $a_id[$i]." ".$a_rep[$i]." $bgcol<br>";
                                                    ;
                                                            
                                                    ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $ccolor?>; background-color: <?= $bgcol?>">
                                                    <td>
                                                        <? if($a_close[$i]==0) { ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_com_var_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Compra" title="Modifica Compra"></i></a> 
                                                        <? } ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.action='adm_com_var_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Compra" title="Detalle Compra"></i></a> 
                                                        <? if($nopago==0) { ?>
                                                        <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" />
                                                        <? } ?>
                                                    </td>
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="center"><?= $a_nasi[$i]?></td>
                                                    <td align="left" <? if($a_mal[$i]==1) echo "style=\"background-color: orange\""?>>
                                                        <? if($a_mov[$i]==0)
                                                            echo "*";
                                                        echo $a_comx[$i];
                                                        ?>
                                                    </td>
                                                    <td align="left"><?= $a_prv[$i]?></td>
                                                    <td align="right"><?= number_format(($a_neto21[$i]+$a_neto10[$i]+$a_neto27[$i]+$a_exe[$i]+$a_ngr[$i]+$a_neto17[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format(($a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_iva17[$i] + $a_imi[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format(($a_pri[$i] + $a_rti[$i] + $a_prb[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format($a_tot[$i]*$calor,2)?></td>
                                                    <td align="right"><?= number_format($a_pag[$i]*$calor,2)?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fev[$i])?></td>
                                                    <td>
                                                        <? 
                                                        for($d=0;$d<count($d_id[$i]);$d++) {
                                                            echo $d_des1[$i][$d]."/ ".$d_des2[$i][$d]."/ ".$d_des3[$i][$d]."/ ".$d_des4[$i][$d]."<br>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <? if($a_close[$i]==0) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Compras?','adm_com_var_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Compra" title="Elimina Compra"></i></a>
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <? if($movimientocva) { ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="panel700 letra6">
                                                            <div id="effect-panel700" class="ui-widget-content ui-corner-all">
                                                                <table width="100%" border="0">
                                                                    <tr class="letra5bold">
                                                                        <td width="60%">Cuenta</td>
                                                                        <td width="30%" align="right">Debe</td>
                                                                        <td width="30%" align="right">Haber</td>
                                                                    </tr>
                                                                    <? 
                                                                    $x1sal=number_format(array_sum($d_sal[$i]),2,".","");
                                                                    $x1ent=number_format(array_sum($d_ent[$i]),2,".","");
                                                                    $x2sal=number_format(array_sum($m_sal[$i]),2,".","");
                                                                    $x2ent=number_format(array_sum($m_ent[$i]),2,".","");
//                                                                    $x1sal= intval($x1sal*100);
//                                                                    $x2sal=intval($x2sal*100);
//                                                                    $x1ent=intval($x1ent*100);
//                                                                    $x2ent=intval($x2ent*100);
//                                                                    print_r($d_sal[$i]);
//                                                                    print_r($m_sal[$i]);
//                                                                    echo "x1ent: $x1ent | x2ent: $x2ent || x1sal: $x1sal | x2sal: $x2sal<br>";
                                                                    $errormov=0;
//                                                                    if(count($d_ent)==0)
//                                                                        $errormov=1;
//                                                                    if(count($d_sal)==0)
//                                                                        $errormov=1;
                                                                    if($errormov==0) {
                                                                        if((float)$x1ent!=(float)$x2ent) {
                                                                            $errormov=1;
                                                                            //echo "e: ".(float)$x1ent." | ".(float)$x2ent."<br>";
                                                                        }
                                                                    }
                                                                    if($errormov==0) {
                                                                        if($x1sal!=$x2sal) {
                                                                            $errormov=1;
                                                                            //echo "s: ".(float)$x1sal." | ".(float)$x2sal."<br>";
                                                                        }
                                                                            
                                                                    }
                                                                    //$errormov=0;
                                                                    if($errormov==0) {
                                                                        for($m=0;$m<count($d_cta[$i]);$m++) { ?>
                                                                        <tr class="letra5" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                            <td><?= $d_cta[$i][$m]?></td>
                                                                            <td align="right"><?= $d_ent[$i][$m]?></td>
                                                                            <td align="right"><?= $d_sal[$i][$m]?></td>
                                                                        </tr>
                                                                        <? }
                                                                    } else { 
                                                                        for($m=0;$m<count($m_cta[$i]);$m++) { ?>
                                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                            <td class="letra5rojo"><?= $m_cta[$i][$m]?></td>
                                                                            <td class="letra5rojo" align="right"><?= number_format($m_ent[$i][$m],2)?></td>
                                                                            <td class="letra5rojo" align="right"><?= number_format($m_sal[$i][$m],2)?></td>
                                                                        </tr>
                                                                    <? } } ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <? } 
                                                if($movimientocva) { ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <hr></hr>
                                                    </td>
                                                </tr>
                                                <? }
                                                } ?>
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
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>


