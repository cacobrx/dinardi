<?php
/*
 * Creado el 17/12/2018 11:03:26
 * Autor: gus
 * Archivo: adm_crm_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crm.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
//$limmax=5;
$ssql="select adm_crm.* from adm_crm, adm_rem where adm_crm.fecha>='$fechainicrm' and adm_crm.fecha<='$fechafincrm' and adm_crm.idrem=adm_rem.id and adm_rem.faena=1";
if($remitocrm>0) $ssql.=" and adm_crm.idrem=$remitocrm";
if($proveedorcrm>0) $ssql.=" and adm_rem.idprv=$proveedorcrm";
$ssql.=" order by fecha, id limit $limcrm, ".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_crm_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getRemito();
$a_hor1=$adm->getHorainicio();
$a_hor2=$adm->getHorafin();
$a_fec=$adm->getFecha();
$a_est=$adm->getEstado();
$a_ope=$adm->getResponsable();
$a_trem=$adm->getTotalremito();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_tem=$adm->getDet_temperatura();
$d_can=$adm->getDet_cantidad();
$f_can=$adm->getFae_peso();
$f_pre=$adm->getFae_precio();
$f_tot=$adm->getFae_total();

//$d_pes=$adm->getDet_peso();
$d_obs=$adm->getDet_observaciones();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcrm)
    $cadenapaginas.=" <a href='javascript: document.form1.limcrm.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_crm.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="idcrm" type="hidden" id="idcrm" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limcrm" type="hidden" id="limcrm" value="<?= $limcrm?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="urlvolver" id="urlvolver" type="hidden" value="adm_crm_main.php" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panelmax letra6">
                                    <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">CONTROL DE FAENAS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainicrm" id="fechainicrm" type="date" value="<?= $fechainicrm?>" class="letra6" /> 
                                                    hasta <input name="fechafincrm" id="fechafincrm" type="date" value="<?= $fechafincrm?>" class="letra6" /> | 
                                                    Ver Detalle<input name="detallecrm" id="detallecrm" value="1" type="checkbox" class="form-control form-control-sm" <? if($detallecrm==1) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.limcrm.value=0; document.form1.action='register_crm.php'; document.form1.submit()"></input> |
                                                    Remito <select name="remitocrm" id="remitocrm" onchange="javascript: document.form1.target='_self'; document.form1.limcrm.value=0; document.form1.action='register_crm.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, concat_ws(' ', id, DATE_FORMAT(fecha, '%d/%m/%Y')) as campo from adm_rem where faena=1 order by id";
                                                    $sup->cargaCombo3($ssql, $remitocrm, "Todos");
                                                    ?>
                                                    </select> | 
                                                    <input name="cmdok" id="cmdok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcrm.value=0; document.form1.action='register_crm.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_crm_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_crm_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Proveedor <select name="proveedorcrm" id="proveedorcrm" onchange="javascript: document.form1.target='_self'; document.form1.limcrm.value=0; document.form1.action='register_crm.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $proveedorcrm, "Todos");
                                                        ?>
                                                    </select>
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
                                                                <!--<a href="javascript: document.form1.target='_self'; document.form1.action='adm_crm_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Remito de Entrada" title="Agregar Remito de Entrada"></i></a>--> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td align="left">Remito</td>
                                                            <td width="5%" align="right">Cantidad</td>
                                                            <td width="5%" align="center">H.Inicio</td>
                                                            <td width="5%" align="center">H.Fin</td>
                                                            <td width="10%" align="left">Responsable</td>
                                                            <td width="8%" align="right">Total Remito</td>
                                                            <td width="8%" align="right">Total Faena</td>
                                                            <td width="6%" align="right">Dif.</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_crm_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Control de Remito" title="Modifica Control de Remito"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_crm_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Control de Remito" title="Detalle Control de Remito"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_crm_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Impresión Control de Remito" title="Impresión Control de Remito"></i></a> 
                                                                <a href="javascript: document.form1.idcrm.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_fae_main.php'; document.form1.submit()"><i class="fas fa-stream fa-lg" alt="Control de Faena" title="Control de Faena"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_des[$i]?></td>
                                                            <td align="center"><?= array_sum($d_can[$i])?></td>
                                                            <td align="center"><?= substr($a_hor1[$i],0,5)?></td>
                                                            <td align="center"><?= substr($a_hor2[$i],0,5)?></td>
                                                            <td align="left"><?= $a_ope[$i]?></td>
                                                            <td align="right"><?= number_format($a_trem[$i],2)?></td>
                                                            <td align="right"><?= number_format(array_sum($f_tot[$i]),2)?></td>
                                                            <td align="right"><?= number_format($a_trem[$i]-array_sum($f_tot[$i]),2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Control de Remito?','adm_crm_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Control de Remito" title="Elimina Productos"></i></a></td>
                                                        </tr>
                                                        <? if($detallecrm==1) { ?>
                                                        <tr>
                                                            <td colspan="12">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td>Producto</td>
                                                                            <td width="10%" align="center">Cantidad</td>
                                                                            <td width="10%" align="center">Temp.</td>
                                                                            <td width="15%">Observaciones</td> 
                                                                            <td width="6%" align="right">Precio</td>
                                                                            <td width="8%" align="right">Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_can[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td><?= $d_art[$i][$d]?></td>
                                                                        <td align="center"><?= $d_can[$i][$d]?></td>
                                                                        <td align="center"><?= $d_tem[$i][$d]?></td>
                                                                        <td><?= $d_obs[$i][$d]?></td>
                                                                        <td align="right"><?= $f_pre[$i][$d]?></td>
                                                                        <td align="right"><?= $f_tot[$i][$d]?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="12"><hr></hr></td>
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


