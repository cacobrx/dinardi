<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: horairo_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/horarios.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';

$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from horarios where fecha>='$fechainihor' and fecha<='$fechafinhor'";
if($iddephor>0)
    $ssql.=" and iddep=$iddephor";    
if($idemphor>0)
    $ssql.=" and idemp=$idemphor";    
$ssql.= " order by fecha";
$adm=new horarios_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_emp=$adm->getEmpleado();
$a_eqp=$adm->getDepartamento();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limhor)
    $cadenapaginas.=" <a href='javascript: document.form1.limhor.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_hor.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limhor" type="hidden" id="limhor" value="<?= $limhor?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">HORARIOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php';?>
                                                </td>
                                            </tr>                                              
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainihor" id="fechainihor" type="date" value="<?= $fechainihor?>" class="letra6" /> 
                                                    hasta <input name="fechafinhor" id="fechafinhor" type="date" value="<?= $fechafinhor?>" class="letra6" />
                                                    |&nbsp; Depratamento&nbsp;<select name="iddephor" id="iddephor" onchange="javascript: document.form1.limhor.value=0; document.form1.target='_self'; document.form1.action='register_hor.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, descripcion as campo from departamento order by descripcion";
                                                        $sup->cargaCombo3($ssql, $iddephor, "Todos");
                                                        ?>                                                        
                                                    </select>&nbsp;|&nbsp; Empleados&nbsp;<select name="idemphor" id="idemphor" onchange="javascript: document.form1.limhor.value=0; document.form1.target='_self'; document.form1.action='register_hor.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_empleados order by apellido";
                                                        $sup->cargaCombo3($ssql, $idemphor, "Todos");
                                                        ?>                                                        
                                                    </select>                                                 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limhor.value=0; document.form1.action='register_hor.php'; document.form1.submit()" /> 
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
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='horarios_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Productos" title="Agregar Productos"></i></a> 
                                                            </td>
                                                            <td width="8%" align="center">Departamento</td>
                                                            <td width="8%" align="center">Fecha</td>
                                                            <td width="30%" align="left">Empleado</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='horarios_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Productos" title="Modifica Productos"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_eqp[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaHoraNormal($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_emp[$i]?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Productos?','horairo_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Productos" title="Elimina Productos"></i></a></td>
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


