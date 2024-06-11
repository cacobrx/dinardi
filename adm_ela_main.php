<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_ela.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_ela where fecha>='$fechainiela' and fecha<='$fechafinela'";
$ssql.=" order by fecha limit $limela,".$cfg->getLimmax();
$tot=new total_ela($fechainiela, $fechafinela);
$adm=new adm_ela_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_hin=$adm->getHoraing();
$a_heg=$adm->getHoraegr();
$a_hin1=$adm->getHoraing1();
$a_heg1=$adm->getHoraegr1();
$a_emp=$adm->getEmpleados();
$a_prv=$adm->getPrv_proveedor();
$a_art=$adm->getDet_articulo();
$a_fin=$adm->getDet_fechaing();
$a_kgd=$adm->getDet_kgdescarte();
$a_kgf=$adm->getDet_kilos();
$cantidadtotal=$adm->getMaxRegistros();
//print_r($a_art);
//print_r($a_prv);
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limela)
    $cadenapaginas.=" <a href='javascript: document.form1.limela.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_ela.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="id" type="hidden" id="id" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limela" type="hidden" id="limela" value="<?= $limela?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">ELABORACION</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainiela" id="fechainiela" type="date" value="<?= $fechainiela?>" class="letra6" /> 
                                                    hasta <input name="fechafinela" id="fechafinela" type="date" value="<?= $fechafinela?>" class="letra6" /> |                                                     
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limela.value=0; document.form1.action='register_ela.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_ela_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_ela_exp.php'; document.form1.submit()" /> 
                                                     Ver Detalle <input name="verdetalleela" id="verdetalleela" type="checkbox" value="1" <? if($verdetalleela==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limela.value=0; document.form1.action='register_ela.php'; document.form1.submit()" />
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Total: </span><?= number_format($tot->getTotal(),2)?><span class="letra6"> | Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_ela_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Elaboracion" title="Agregar Elaboracion"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="20%" align="left">Fecha</td>
                                                            <td width="20%" align="center">Hora Ingreso / Egreso</td>
                                                            <td width="20%" align="center">Hora Ingreso / Egreso</td>
                                                            <td width="20%" align="center">Empleados</td>
                                                            <td width="5%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_ela_mod.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Elaboracion" title="Modifica Elaboracion"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_ela_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Elaboracion" title="Detalle Elaboracion"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_ela_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Impresion Elaboracion" title="Impresion Elaboracion"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="left"><?= $dsup->getfechanormalcorta($a_fec[$i])?></td>
                                                            <td align="center"><?= $a_hin[$i]." / ".$a_heg[$i]?></td>
                                                            <td align="center"><?= $a_hin1[$i]." / ".$a_heg1[$i]?></td>
                                                            <td align="center"><?= $a_emp[$i]?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Elaboracion?','adm_ela_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Elaboracion" title="Elimina Elaboracion"></i></a></td>
                                                        </tr>
                                                        <? if($verdetalleela==1) { ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td align="center" width="10%">Fecha</td>
                                                                            <td>Proveedor</td>
                                                                            <td align="center" width="10%">Producto</td>
                                                                            <td align="right" width="10%">Kg descarte</td>
                                                                            <td align="right" width="10%">Kg Final</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($a_art[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="center"><?= $dsup->getfechanormalcorta($a_fin[$i][$d])?></td>
                                                                        <td>
                                                                            <?
                                                                            $prove="";
                                                                            for($p=0;$p<count($a_prv[$i][$d]);$p++) {
                                                                                if(trim($a_prv[$i][$d][$p])!="") $prove.=$a_prv[$i][$d][$p]." /";
                                                                            }
                                                                            if($prove!="") $prove=substr($prove,0,strlen($prove)-3);
                                                                            echo $prove;
                                                                            ?>
                                                                        </td>
                                                                        <td align="center"><?= $a_art[$i][$d]?></td>
                                                                        <td align="right"><?= number_format($a_kgd[$i][$d],2)?></td>
                                                                        <td align="right"><?= number_format($a_kgf[$i][$d],2)?></td>
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


