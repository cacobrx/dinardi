<?
/*
 * Creado el 26/05/2017 15:34:36
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_empleados_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_empleados.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_empleados order by apellido, nombre limit $limemp,".$cfg->getLimmax();
$adm=new adm_empleados_2($ssql);
    
$a_id=$adm->getId();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_fec=$adm->getFechaingreso();
$a_imp=$adm->getImporte();
$a_doc=$adm->getDocumento();
$d_des=$adm->getDet_descripicion();
$d_hor1=$adm->getDet_hora1();
$d_hor2=$adm->getDet_hora2();
$d_hor3=$adm->getDet_hora3();
$d_hor4=$adm->getDet_hora4();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limemp)
    $cadenapaginas.=" <a href='javascript: document.form1.limemp.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_emp.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limemp" type="hidden" id="limemp" value="<?= $limemp?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">EMPLEADOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php';?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all">Ver Detalle <input name="detalleemp" id="detalleemp" type="checkbox" value="1" <? if($detalleemp==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limemp.value=0; document.form1.action='register_emp.php'; document.form1.submit()" />&nbsp;|&nbsp; <span class="letra6">Cantidad: </span><span class="letra6bold"><?= $cantidadtotal?></span><span class="letra6"> | Pag: </span></span><span class="lnk"><?= $cadenapaginas?></span></td>
                                            </tr>                                                      
                                            
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="5%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_empleados_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Empleados" title="Agregar Empleados"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td align="left">Nombre</td>
                                                            <td width="10%" align="left">Documento</td>
                                                            <td width="10%" align="center">Fecha Ingreso</td>
                                                            <td width="10%" align="right">Importe</td>
                                                            <td width="5%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_empleados_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Empleados" title="Modifica Empleados"></i></a> 
                                                                <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.action='adm_empleados_dep.php'; document.form1.target='_self'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Horarios Empleados" title="Horarios Recibo"></i></a>                                                            
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="left"><?= $a_ape[$i]." ".$a_nom[$i]?></td>
                                                            <td align="left"><?= $a_doc[$i]?></td>
                                                            <td align="center"><?= $dsup->getfechanormalcorta($a_fec[$i])?></td>
                                                            <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Empleados?','adm_empleados_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Empleados" title="Elimina Empleados"></i></a></td>
                                                        </tr>
                                                        <? if($detalleemp==1) { ?>
                                                        <tr>
                                                            <td colspan="5">
                                                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                                    <tr class="letra6bold">
                                                                        <td width="30%"></td>                                                            
                                                                        <td width="35%" align="center"> Turno Mañana</td>
                                                                        <td width="35%" align="center"> Turno Tarde</td>
                                                                        <td width="10%"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td align="left" width="20%" >Departamento</td>
                                                                            <td align="center" width="10%">Hora Entrada</td>
                                                                            <td align="center" width="10%">Hora Salida</td>
                                                                            <td align="center" width="10%">Hora Entrada</td>
                                                                            <td align="center" width="10%">Hora Salida</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_des[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="left"><?= $d_des[$i][$d]?></td>
                                                                        <td align="center"><?= $d_hor1[$i][$d]?></td>
                                                                        <td align="center"><?= $d_hor2[$i][$d]?></td>
                                                                        <td align="center"><?= $d_hor3[$i][$d]?></td>
                                                                        <td align="center"><?= $d_hor4[$i][$d]?></td>
                                                                    </tr>
                                                                    <? } ?>
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


