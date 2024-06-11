.<?php
/*
 * Creado el 21/01/2016 13:21:45
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_desc_extras
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_extras.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$idpersel=$glo->getGETPOST("idpersel");
$ssql="select * from adm_extras where fecha>='$fechainiext' and fecha<='$fechafinext'";
if($empleadoext>0)
    $ssql.=" and idper=$empleadoext";
$ssql.=" order by fecha, id limit $limext,".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_extras_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_idd=$adm->getIdper();
$a_nom=$adm->getPersona();
$a_imp=$adm->getImporte();
$a_per=$adm->getPersona();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limext)
    $cadenapaginas.="- <a href='javascript: document.form1.limext.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_ext.php\"; document.form1.submit()' class='can'>$j</a>";
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
        <input name="limext" type="hidden" id="limext" value="<?= $limext?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />
        
      </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">EXTRAS DE EMPLEADOS</h3>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td>
                                            <? require_once 'menuemp.php';?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainiext" id="fechainiext" class="letra6" type="date" value="<?= $fechainiext?>" /> 
                                            hasta <input name="fechafinext" id="fechafinext" class="letra6" type="date" value="<?= $fechafinext?>" /> | 
                                            Empleado <select name="empleadoext" id="empleadoext" onchange="javasscript: document.form1.target='_self'; document.form1.limext.value=0; document.form1.action='register_ext.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_empleados order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $empleadoext, "Todos");
                                                ?>
                                            </select>
                                            <input name="cmdOk" id="cmdOk" type="submit" value="Filtrar" onclick="javascript: document.form1.limext.value=0; document.form1.target='_self'; document.form1.action='register_ext.php'; document.form1.submit()" />
                                            <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_extras_prn.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdexc" id="cmdexc" value="Exporta Excel" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_extras_exl.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">Cantidad: <span class="letra6bold"><?= $cantidadtotal?></span> - Pag: <span class="lnk"><?= $cadenapaginas?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="8%">
                                                        <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_extras_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Extras" title="Agregar Extras"></i></a> 
                                                    </td>
                                                    <td width="3%" align="center">Id</td>
                                                    <td width="15%" align="center">Fecha</td>
                                                    <td width="50%" align="left">Empleado</td>
                                                    <td width="30%" align="center">Importe</td>                                                                                                      
                                                </tr>
                                                    <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_extras_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Extras" title="Modifica Extras"></i></a> 
                                                    </td>
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="left"><?= $a_per[$i]?></td>
                                                    <td align="center"><?= number_format($a_imp[$i],2)?></td>
                                                    <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Extras de Empleados?','adm_extras_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Extras" title="Elimina Extras"></i></a></td>
                                                    <td>&nbsp;</td>
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
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</div>
</body>
</html>


