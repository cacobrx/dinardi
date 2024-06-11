<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_rem_exp.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from adm_rem_exp where fecha>='$fechainiexp' and fecha<='$fechafinexp' order by id limit $limexp,".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_rem_exp_2($ssql);
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_exp=$adm->getExportador();
$a_des=$adm->getDestino();
$a_rem=$adm->getRemitente();
$d_can=$adm->getCantidad();
$d_des=$adm->getDescripcion();
$d_kgsb=$adm->getKgsbrutos();
$d_kgsn=$adm->getKgsneto();
$a_nro=$adm->getNumero();


$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limexp)
    $cadenapaginas.=" <a href='javascript: document.form1.limexp.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_rem_exp.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limexp" type="hidden" id="limexp" value="<?= $limexp?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">Remitos de Expotación</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainiexp" id="fechainiexp" type="date" value="<?= $fechainiexp?>" class="letra6" /> 
                                                    hasta <input name="fechafinexp" id="fechafinexp" type="date" value="<?= $fechafinexp?>" class="letra6" />                                                     
                                                    Ver Detalle <input name="detalleexp" id="detalleexp" type="checkbox" value="1" <? if($detalleexp==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limexp.value=0; document.form1.action='register_rem_exp.php'; document.form1.submit()" /> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limexp.value=0; document.form1.action='register_rem_exp.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_rem_exp_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_rem_exp_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="8%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_rem_exp_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Remito" title="Agregar Remito"></i></a> 
                                                            </td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="5%" align="center">Nro.</td>
                                                            <td align="left">Exportador</td>
                                                            <td width="24%" align="left">Destino</td>
                                                            <td width="24%" align="left">Remitente</td>                                                            
                                                            <td width="2%" align="right">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_rem_exp_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Remito" title="Modifica Remito"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_rem_exp_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Remito" title="Detalle Remito"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_rem_exp_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Remito" width="12" height="12" border="0" title="Imprime Remito" ></i></a>                                                                 
                                                            </td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="center"><?= $a_nro[$i]?></td>
                                                            <td align="left"><?= $a_exp[$i]?></td>
                                                            <td align="left"><?= $a_des[$i]?></td>
                                                            <td align="left"><?= $a_rem[$i]?></td>                                                      
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Remito?','adm_rem_exp_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Remito" title="Elimina Remito"></i></a></td>
                                                        </tr>
                                                        <? if($detalleexp==1) { ?>
                                                        <tr>
                                                            <td colspan="8">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td align="center" width="10%">Cantidad</td>
                                                                            <td>Descripción</td>
                                                                            <td align="center" width="15%">Kilos Brutos</td>                                                                            
                                                                            <td align="center" width="15%">Kilos Netos</td>                                                                      
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_can[$i]);$d++) { ?>
                                                                    <tr class="letra6">
                                                                        <td align="center"><?= number_format($d_can[$i][$d],0)?></td>
                                                                        <td align="left"><?= $d_des[$i][$d]?></td>
                                                                        <td align="center"><?= number_format($d_kgsb[$i][$d],3)?></td>
                                                                        <td align="center"><?= number_format($d_kgsn[$i][$d],3)?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                    <tr class="letra6bold" >
                                                                        <td align="center"><?= number_format(array_sum($d_can[$i]),0)?></td>
                                                                        <td align="right">&nbsp;</td>
                                                                        <td align="center"><?= number_format(array_sum($d_kgsb[$i]),3)?></td>
                                                                        <td align="center"><?= number_format(array_sum($d_kgsb[$i]),3)?></td>                                                                     
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"><hr></hr></td>
                                                        </tr>
                                                        <? } }?>
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


