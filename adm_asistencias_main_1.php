<?
/*
 * Creado el 24/07/2020 14:59:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_asistencias_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_asistencias.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_asistencias where fecha>='$fechainiasi' and fecha<='$fechafinasi'";
if($idperasi>0)
    $ssql.=" and idper=".$idperasi;
$ssql.=" order by fecha limit $limasi,".$cfg->getLimmax();
$adm=new adm_asistencias_2($ssql);
    
$a_id=$adm->getId();
$a_idp=$adm->getEmpleado();
$a_fec=$adm->getFecha();
$a_can=$adm->getCantidad();
$a_asi=$adm->getTipohorades();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limasi)
    $cadenapaginas.=" <a href='javascript: document.form1.limasi.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_asi.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limasi" type="hidden" id="limasi" value="<?= $limasi?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">TOTAL DE ASISTENCISAS EMPLEADOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php'; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainiasi" type="date" class="letra6" id="fechainiasi" value="<?= $fechainiasi?>" /> 
                                                    hasta <input name="fechafinasi" type="date" class="letra6" id="fechafinasi" value="<?= $fechafinasi?>" /> 
                                                    |&nbsp; Empleados&nbsp;<select name="idperasi" id="idperasi" onchange="javascript: document.form1.limasi.value=0; document.form1.target='_self'; document.form1.action='register_asi.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_empleados order by apellido";
                                                        $sup->cargaCombo3($ssql, $idperasi, "Todos");
                                                        ?>                                                        
                                                    </select>
                                                    <input type="submit" name="cmdOk" id="cmdOk" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limasi.value=0; document.form1.action='register_asi.php'; document.form1.submit()" />
                                                    <input type="submit" name="cmdprint" id="cmdprint" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_asistencias_prn.php'; document.form1.submit()" /> 

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
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_asistencias_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Asistencia" title="Agregar Asistencia"></i></a> 
                                                            </td>
                                                            <td width="10%" align="center">Fecha</td>                                                            
                                                            <td align="left">Empleado</td>
                                                            <td width="20%" align="left">Tipo de Asistencia</td>
                                                            <td width="33%" align="center">Cantidad Horas</td>
                                                            
                                                            <td width="5%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_asistencias_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Asistencia" title="Modifica Asistencia"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_asistencias_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Asistencia" title="Detalle Asistencia"></i></a> 
                                                            </td>
                                                            <td align="center"><?=$dsup->getfechanormalcorta($a_fec[$i])?></td>                                                            
                                                            <td align="left"><?= $a_idp[$i]?></td>
                                                            <td align="left"><?= $a_asi[$i]?></td>
                                                            <td align="center"><?= $a_can[$i]?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Asistencia?','adm_asistencias_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Asistencia" title="Elimina Asistencia"></i></a></td>
                                                        </tr>
                                                        <? } ?>
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


