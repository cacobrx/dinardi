<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_cped_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cped.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_cped where fecha>='$fechainicped' and fecha<='$fechafincped'";
if($clientecped>0) $ssql.=" and idcli=$clientecped";
$ssql.=" order by fecha, id limit $limcped, $limmax";
//echo $ssql;
$adm=new adm_cped_2($ssql);
    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_tot=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_fece=$adm->getFechaentrega();
$a_rem=$adm->getIdrem();
$a_pat=$adm->getPatente();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_can=$adm->getDet_cantidad();
$d_recipiente=$adm->getDet_recipiente();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcped)
    $cadenapaginas.=" <a href='javascript: document.form1.limcped.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_cped.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limcped" type="hidden" id="limcped" value="<?= $limcped?>" />         
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
                                        <h3 class="ui-widget-header ui-corner-all">PEDIDOS DE CLIENTES</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainicped" id="fechainicped" type="date" value="<?= $fechainicped?>" class="letra6" /> 
                                                    hasta <input name="fechafincped" id="fechafincped" type="date" value="<?= $fechafincped?>" class="letra6" /> | 
                                                    Cliente <select name="clientecped" id="clientecped" onchange="javascript: document.form1.target='_self'; document.form1.limcped.value=0; document.form1.action='register_cped.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_cli order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $clientecped, "Todos");
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Ver Detalle <input name="detallecped" id="detallecped" type="checkbox" value="1" <? if($detallecped==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limcped.value=0; document.form1.action='register_cped.php'; document.form1.submit()" /> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcped.value=0; document.form1.action='register_cped.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_cped_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_cped_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%">
                                                                <a href="javascript: document.form1.target='_self'; document.form1.action='adm_cped_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Pedido" title="Agregar Pedido"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="20%" align="center">Fec.Entrega</td>
                                                            <td align="left" aling="left">Cliente</td>
                                                            <td align="10%" aling="left">Patente</td>
                                                            <td width="10%" align="right">Total</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_cped_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Pedido" title="Modifica Pedido"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_cped_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Pedido" title="Detalle Pedido"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_cped_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Remito" width="12" height="12" border="0" title="Imprime Remito" ></i></a>                                                                                                                                     
                                                                <? if($a_rem[$i]==0) { ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_cprem_act.php'; document.form1.submit()"><i class="fas fa-registered fa-lg" alt="Agrega Remito a Orden de Pedido" title="Agrega Remito Orden de Pedido" ></i></a>                                                                   
                                                                <? } ?>
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fece[$i])?></td>
                                                            <td align="left"><?= $a_cli[$i]?></td>
                                                            <td align="left"><?= $a_pat[$i]?></td>
                                                            <td align="right"><?= number_format($a_tot[$i],2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Pedido?','adm_cped_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Pedido" title="Elimina Pedido"></i></a></td>
                                                        </tr>
                                                        <? if($detallecped==1) { ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td align="center" width="10%">Kilos</td>
                                                                            <td>Descripción</td>
                                                                            <td align="center" width="10%">Cantidad</th>
                                                                            <td align="right" width="10%">Precio</th>
                                                                            <td align="right" width="10%">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_can[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="center"><?= $d_can[$i][$d]?></td>
                                                                        <td><?= $d_art[$i][$d]?></td>
                                                                        <td align="center"><?= $d_recipiente[$i][$d]?></td>
                                                                        <td align="right"><?= number_format($d_pre[$i][$d],2)?></td>
                                                                        <td align="right"><?= number_format($d_imp[$i][$d],2)?></td>
                                                                    </tr>
                                                                    <? } ?>
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
