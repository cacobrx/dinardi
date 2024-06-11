<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_crem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crem.php';
require_once 'clases/conexion.php';
$conx=new conexion();
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_crem where fecha>='$fechainicrem' and fecha<='$fechafincrem'";
if($clientecrem>0) $ssql.=" and idcli=$clientecrem";
$ssql.=" order by numero, id limit $limcrem, $limmax";
$adm=new adm_crem_2($ssql);
    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_tot=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_fece=$adm->getFechaentrega();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
$a_fis=$adm->getFiscal();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_can=$adm->getDet_cantidad();
$a_ctrl=$adm->getControlado();
$d_recipiente=$adm->getDet_recipiente();
$a_pat=$adm->getPatente();
$totalrec=array_sum($d_recipiente);
$cantidadtotal=$adm->getMaxRegistros();
$ssql="select sum(adm_crem_det.cantidad) as totcan, sum(adm_crem_det.cantidad*adm_crem_det.precio) as totimp from adm_crem_det, adm_crem where adm_crem.id=adm_crem_det.idrem and adm_crem.fecha>='$fechainicrem' and adm_crem.fecha<='$fechafincrem'";
if($clientecrem>0) $ssql.=" and adm_crem.idcli=$clientecrem";
//echo $ssql."<br>";
$rx=$conx->getConsulta($ssql);
$rxx=mysqli_fetch_object($rx);
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcrem)
    $cadenapaginas.=" <a href='javascript: document.form1.limcrem.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_crem.php\"; document.form1.submit()' class='letra6'>$j</a>";
  else
    $cadenapaginas.=" <span class='letra6bold'>$j</span></a>";
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
<script type="text/javascript" src="planb.js?1.0.0"></script>
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
                <input name="limcrem" type="hidden" id="limcrem" value="<?= $limcrem?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">REMITOS DE CLIENTES</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainicrem" id="fechainicrem" type="date" value="<?= $fechainicrem?>" class="letra6" /> 
                                                    hasta <input name="fechafincrem" id="fechafincrem" type="date" value="<?= $fechafincrem?>" class="letra6" /> | 
                                                    Cliente <select name="clientecrem" id="clientecrem" onchange="javascript: document.form1.target='_self'; document.form1.limcrem.value=0; document.form1.action='register_crem.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_cli order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $clientecrem, "Todos");
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Copias <select name="copiasimp" id="copiasimp">
                                                        <?
                                                        $arraycopias=array("ORIGINAL","DUPLICADO","TRIPLICADO", "ORIGINAL + DUPLICADO", "ORI + DUP + TRI");
                                                        $arrayncopias=array(1,2,3,4,5);
                                                        $sup->cargaComboArrayValor($arraycopias, $arrayncopias, 1);
                                                        ?>
                                                    </select>                                                    
                                                    Ver Detalle <input name="detallecrem" id="detallecrem" type="checkbox" value="1" <? if($detallecrem==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limcrem.value=0; document.form1.action='register_crem.php'; document.form1.submit()" /> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcrem.value=0; document.form1.action='register_crem.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_crem_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_crem_exp.php'; document.form1.submit()" /> | 
                                                    Totales --> Cantidad: <span class="letra6bold"><?= number_format($rxx->totcan,0)?></span> | Importe: <span class="letra6bold"><?= number_format($rxx->totimp,2)?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="9%">
                                                                <a href="javascript: document.form1.target='_self'; document.form1.action='adm_crem_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Pedido" title="Agregar Pedido"></i></a> 
                                                            </td>
                                                            <td width="4%" align="center">ID</td>
                                                            <td width="10%" align="center">Número</td>
                                                            <td width="8%" align="center">Fecha</td>
                                                            <td width="8%" align="center">Fec.Entrega</td>
                                                            <td align="left" aling="left">Cliente</td>
                                                            <td width="8%" align="center">Fiscal</td>
                                                            <td width="7%" align="center">Patente</td>
                                                            <td width="8%" align="right">Total Kilos</td>
                                                            <td width="10%" align="right">Total</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { 
                                                            if($a_ctrl[$i]==1)
                                                                $cartelcontrola="Remito sin Control";
                                                            else
                                                                $cartelcontrola="Remito Controlado";
                                                            ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_crem_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Pedido" title="Modifica Pedido"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_crem_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Pedido" title="Detalle Pedido"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_crem_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Remito" width="12" height="12" border="0" title="Imprime Remito" ></i></a>                                                                 
                                                                <a href="javascript: bajareg(<?= $a_id[$i]?>,'<?= $cartelcontrola?>?','adm_crem_ctrl_save.php')"><i class="far fa-check-circle fa-lg" <? if($a_ctrl[$i]==1) echo "style='color: blue'";?> alt="<?= $cartelcontrola?>" title="<?= $cartelcontrola?>"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= $sup->AddZeros($a_pto[$i], 4)."-".$sup->AddZeros($a_nro[$i],8)?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fece[$i])?></td>
                                                            <td align="left"><?= $a_cli[$i]?></td>
                                                            <td align="center"><?= $a_fis[$i]?></td>
                                                            <td align="center"><?= $a_pat[$i]?></td>
                                                            <td align="right"><?= number_format(array_sum($d_can[$i]),2)?></td>
                                                            <td align="right"><?= number_format($a_tot[$i],2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Pedido?','adm_crem_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Pedido" title="Elimina Pedido"></i></a></td>
                                                        </tr>
                                                        <? if($detallecrem==1) { ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td align="center" width="10%">Cantidad</td>
                                                                            <td>Descripción</td>
                                                                            <td align="center" width="10%">Recipientes</th>
                                                                            <td align="right" width="10%">Precio</th>
                                                                            <td align="right" width="10%">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_can[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="center"><?= number_format($d_can[$i][$d],0)?></td>
                                                                        <td><?= $d_art[$i][$d]?></td>
                                                                        <td align="center"><?= $d_recipiente[$i][$d]?></td>
                                                                        <td align="right"><?= number_format($d_pre[$i][$d],5)?></td>
                                                                        <td align="right"><?= number_format($d_imp[$i][$d],2)?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                    <tr class="letra6bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="center"><?= number_format(array_sum($d_can[$i]),0)?></td>
                                                                        <td align="right">&nbsp;</td>
                                                                        <td align="center"><?= array_sum($d_recipiente[$i])?></td>
                                                                        <td align="right">&nbsp;</td>
                                                                        <td align="right"><?= number_format(array_sum($d_imp[$i]),2)?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"><hr></hr></td>
                                                        </tr>
                                                        <? } } ?>
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
                <td>&nbsp;</tr>
            </tr>
        </form>
    </div>
</body>
</html>
