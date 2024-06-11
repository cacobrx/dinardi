<?
//session_start();
require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/tabla.php");
require_once("clases/datesupport.php");
require_once 'clases/support.php';
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$tablasel=$glo->getGETPOST("tablasel");
if($tablasel=="")
    $tablasel=0;
$adm=new tabla_def($tablasel);
//echo $tablasel." | ".$adm->getActivo();
if($lim=="")
  $lim=0;
if($tablasel>0) {
	$ctab=new tabla_1($tablasel);
	$codtab=$ctab->getValorc();
	$ssql="select * from tablas where codtab='".$ctab->getValorc()."' order by descripcion limit $lim, ".$cfg->getLimmax();
	$tab=new tabla_2($ssql);
	$a_id=$tab->getId();
	$a_des=$tab->getDescripcion();
	$a_val=$tab->getValor();
        $a_act=$tab->getActivo();
	$cantidadtotal=$tab->getMaxRegistros();
} else {
	$cantidadtotal=0;
	$a_id=array();
	$codtab="";
}
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$lim)
    $cadenapaginas.="- <a href='javascript: document.form1.lim.value=$ini; document.form1.action=\"planb_tab_main.php\"; document.form1.submit()' class='can'>$j</a>";
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
	/*visibility:hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:2;
	margin-left: -480px;
	/*visibility:hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<?include_once 'estilos.php';?>

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
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="lim" type="hidden" id="lim" value="<?= $lim?>" />
        <input name="codtab" type="hidden" id="codtab" value="<?= $codtab?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">TABLAS del SISTEMA</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td align="center">Tabla 
                                            <select name="tablasel" class="letra6bold" id="tablasel" onchange="javascript: document.form1.action='planb_tab_main.php'; document.form1.submit()">
                                                <? $sup->cargaCombo("select id as id, descripcion as campo from tablas where codtab='DEF' and centro=$centrosel order by descripcion",$tablasel,"Seleccione") ?>
                                            </select>
                                            <a href="javascript: document.form1.tarea.value='A'; document.form1.action='planb_tab_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Elemento a la Tabla" title="Agregar Elemento a la Tabla"></i></a>              
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <? if($tablasel>0) { ?>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: <?= $cantidadtotal?> - Pag: </span><span class="lnk"><?= $cadenapaginas?></span></td>
                                            </tr>
                                            <? } else {?>
                                            &nbsp;
                                            <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="15%"><input name="id" type="hidden" id="id" value="0" />
                                                    </td>
                                                    <td width="60%">Descripción</td>
                                                    <td width="20%" align="center">
                                                        <? if($adm->getActivo()==1) { ?>
                                                            Activo
                                                        <? } ?>
                                                    </td>
                                                    <td width="5%">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='planb_tab_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Elemento de la Tabla" title="Modifica Elemento de la Tabla"></i></a>
                                                        <? } ?>
                                                    </td>
                                                    <td><?= $a_des[$i]?></td>
                                                    <td align="center">
                                                        <? if($adm->getActivo() and $a_act[$i]==1) { ?>
                                                        <i class="far fa-check-circle fa-lg" style="color: green"></i>
                                                        <? } ?>
                                                    </td>
                                                    <td>
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina <?= $a_des[$i]?>?', 'planb_tab_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Elemento de la Tabla" title="Elimina Elemento de la Tabla"></i></a>
                                                        <? } ?>
                                                    </td>
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
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
