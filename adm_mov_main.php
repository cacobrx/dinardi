<?php
/*
 * creado el 07/11/2017 19:00:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_main
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_mov.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$condicion="";
$ntex=strlen($textomov);
$condicion="";
$ssql="select * from adm_mov1 where centro=$centrosel and fecha>='$fechainimov' and fecha<='$fechafinmov'";
if($asientomov!="") $condicion="asiento=$asientomov and ";
if($textomov!="") $condicion="instr(upper(detalle),'".strtoupper($textomov)."')>0 and ";
if($condicion!="") $condicion=" and ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by fecha, asiento limit $limmov, ".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_mov_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_det=$adm->getDetalle();
$a_asi=$adm->getAsiento();
$a_debe=$adm->getDebemov();
$a_haber=$adm->getHabermov();
$d_id=$adm->getDet_id();
$d_idcta=$adm->getDet_idcta();
$d_nombre=$adm->getDet_nombre();
$d_codigo=$adm->getDet_codigo();
$d_tipo=$adm->getDet_tipo();
$d_importe=$adm->getDet_importe();
$d_detalle=$adm->getDet_detalle();
//print_r($d_codigo);
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limmov)
    $cadenapaginas.=" <a href='javascript: document.form1.limmov.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_mov.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limmov" type="hidden" id="limmov" value="<?= $limmov?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">MOVIMIENTOS CONTABLES</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainimov" id="fechainimov" type="date" value="<?= $fechainimov?>" class="letra6" /> 
                                                    hasta <input name="fechafinmov" id="fechafinmov" type="date" value="<?= $fechafinmov?>" class="letra6" /> | 
                                                    Texto <input name="textomov" id="textomov" type="input" value="<?= $textomov?>" /> | 
                                                    Asiento <input name="asientomov" id="asientomov" type="text" value="<?= $asientomov?>" onkeypress="return validar(event)" style="text-align: center" size="10" /> | 
                                                    Ver Detalle <input name="detallemov" id="detallemov" value="1" type="checkbox" <? if($detallemov==1) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.limmov.value=0; document.form1.action='register_mov.php'; document.form1.submit()" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="cmdok" type="submit" value="Filtrar" onclick="javascript: document.form1.limmov.value=0; document.form1.action='register_mov.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_mov_lst.php'; document.form1.submit()" /> 
                                                    <input name="cmdexc" id="cmdexc" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_mov_exc.php'; document.form1.submit()" /> | 
                                                    Texto para Impresión Libro Diario <input name="textodiario" id="textodiario" type="text" size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="5%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_mov_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Movimiento" title="Agregar Movimiento"></i></a> 
                                                            </td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="5%" align="center">Asiento</td>
                                                            <td width="55%" align="left">Detalle</td>
                                                            <td width="10%" align="right">Debe</td>
                                                            <td width="10%" align="right">Haber</td>
                                                            <td width="5%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_mov_mod.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Movimiento" title="Modifica Movimiento"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_mov_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Movimiento" title="Detalle Movimiento"></i></a> 
                                                            </td>
                                                            <td align="center"><?= date("d/m/Y", strtotime($a_fec[$i]))?></td>
                                                            <td align="center"><?= $a_asi[$i]?></td>
                                                            <td align="left"><?= $a_det[$i]?></td>
                                                            <td align="right"><?= number_format($a_debe[$i],2)?></td>
                                                            <td align="right"><?= number_format($a_haber[$i],2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Movimiento?','adm_mov_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Movimiento" title="Elimina Movimiento"></i></a></td>
                                                        </tr>
                                                        <? if($detallemov==1) { ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">

                                                                    <tr class="letra5Bold">
                                                                        <td align="left">Código</td>
                                                                        <td align="left">Cuenta</td>
                                                                        <td align="left">Detalle</td>
                                                                        <td align="right">Debe</td>
                                                                        <td align="right">Haber</td>
                                                                    </tr>
                                                                    <? for($d=0;$d<count($d_id[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra5">
                                                                        <td align="left"><?= $d_codigo[$i][$d]?></td>
                                                                        <td align="left"><?= $d_nombre[$i][$d]?></td>
                                                                        <td align="left"><?= $d_detalle[$i][$d]?></td>
                                                                        <? if($d_tipo[$i][$d]==1) { ?>
                                                                        <td align="right"><?= number_format($d_importe[$i][$d],2)?></td>
                                                                        <td align="right">&nbsp;</td>
                                                                        <? } else { ?>
                                                                        <td align="right">&nbsp;</td>
                                                                        <td align="right"><?= number_format($d_importe[$i][$d],2)?></td>
                                                                        <? } ?>
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


