<?
/*
 * Creado el 29/05/2017 11:20:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: departamento_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/departamento.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from departamento order by id limit $limdep,".$cfg->getLimmax();
$adm=new departamento_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_hor1=$adm->getHora1();
$a_hor2=$adm->getHora2();
$a_hor3=$adm->getHora3();
$a_hor4=$adm->getHora4();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limdep)
    $cadenapaginas.=" <a href='javascript: document.form1.limdep.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_dep.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limdep" type="hidden" id="limdep" value="<?= $limdep?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">DEPARTAMENTOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <? require_once 'menuemp.php';?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><span class="letra6bold"><?= $cantidadtotal?></span><span class="letra6"> | Pag: </span></span><span class="lnk"><?= $cadenapaginas?></span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="20%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='departamento_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Adelantos" title="Agregar Adelantos"></i></a> 
                                                            </td>                                                            
                                                            <td width="35%" align="center"> Turno Mañana</td>
                                                            <td width="35%" align="center"> Turno Tarde</td>
                                                            <td width="10%"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="2%"></td>
                                                            <td width="18%">Departamento</td>
                                                            <td width="18%" align="center">Entrada</td>
                                                            <td width="18%" align="center">Salida</td>
                                                            <td width="18%" align="center">Entrada</td>
                                                            <td width="18%" align="center">Salida</td>
                                                            <td width="12%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='departamento_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Adelantos" title="Modifica Adelantos"></i></a> 
                                                            </td>
                                                            <td align="left"><?= $a_des[$i]?></td>
                                                            <td align="center"><?= $a_hor1[$i]?></td>
                                                            <td align="center"><?= $a_hor2[$i]?></td>
                                                            <td align="center"><?= $a_hor3[$i]?></td>
                                                            <td align="center"><?= $a_hor4[$i]?></td>
                                                            <td align="right"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Adelantos?','departamento_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Adelantos" title="Elimina Adelantos"></i></a></td>
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


