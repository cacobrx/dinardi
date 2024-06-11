<?php
/*
 * creado el 31/07/2016 17:03:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_clasif_main
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/adm_clasif.php");
require_once("clases/datesupport.php");
require_once 'clases/support.php';
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
//echo "tipoclf: $tipoclf | cajaclf: $cajaclf\n";
if($tipoclf!="") {
    //$ssql="select * from adm_clasif where caja=$cajaclf and tipo='$tipoclf' order by texto limit $limclf, ".$cfg->getLimmax();
    $ssql="select * from adm_clasif where tipo='$tipoclf'";
    if($depenclf>0 and $tipoclf!="DESN1") $ssql.=" and dependencia=$depenclf";
    $ssql.=" order by $ordenclf limit $limclf, ".$cfg->getLimmax();
//    echo $ssql;
    $adm=new adm_clasif_2($ssql);
    $a_id=$adm->getId();
    $a_tip=$adm->getTipo();
    $a_tex=$adm->getTexto();
    $a_dep=$adm->getDependenciades();
    $a_tpd=$adm->getTipodep();
    $a_cod=$adm->getCodigodep();
    $a_act=$adm->getActivo();
    $cantidadtotal=$adm->getMaxRegistros();
    switch ($tipoclf) {
        case "DESN1":
            $carteldes="Descriptor Nivel 1";
            break;
        case "DESN1":
            $carteldes="Descriptor Nivel 2";
            break;
        case "DESN1":
            $carteldes="Descriptor Nivel 3";
            break;
        case "DESN1":
            $carteldes="Descriptor Nivel 4";
            break;
    }
} else {
    $cantidadtotal=0;
    $a_id=array();
    //$codtab="";
}
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limclf)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limclf.value=$ini; document.form1.action=\"register_clf.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letrabold'>$j</span></a>";
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
        <input name="limclf" type="hidden" id="limclf" value="<?= $limclf?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">DESCRIPTORES</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td align="center">
                                            Nivel 
                                            <select name="tipoclf" id="tipoclf" onchange="javascript: document.form1.target='_self'; document.form1.limclf.value=0; document.form1.action='register_clf.php'; document.form1.submit()">
                                                <? 
                                                $array=array("Descriptor Nivel 1", "Descriptor Nivel 2", "Descriptor Nivel 3", "Descriptor Nivel 4");
                                                $avalor=array("DESN1", "DESN2", "DESN3", "DESN4");
                                                $sup->cargaComboArrayValor($array, $avalor, $tipoclf, "Sel");
                                                ?>
                                            </select> | 
                                            Orden <select name="ordenclf" id="ordenclf" onchange="javascript: document.form1.target='_self'; document.form1.limclf.value=0; document.form1.action='register_clf.php'; document.form1.submit()">
                                                <?
                                                $array=array("Texto", "Código");
                                                $avalor=array("texto", "codigodep");
                                                $sup->cargaComboArrayValor($array, $avalor, $ordenclf);
                                                ?>
                                            </select> | 
                                            <? if($tipoclf!="") { 
                                                if($tipoclf!="DESN1") { ?>
                                            <select name="depenclf" id="depenclf" onchange="javascript: document.form1.target='_self'; document.form1.limclf.value=0; document.form1.action='register_clf.php'; document.form1.submit()">
                                                    <?
                                                     switch ($tipoclf) {
                                                         case "DESN2":
                                                             $ssql="select id as id, concat(' ', texto, ' (', codigodep, ')') as campo from adm_clasif where tipo='DESN1' order by texto";
                                                             break;
                                                         case "DESN3":
                                                             $ssql="select id as id, concat(' ', texto, ' (', codigodep, ')') as campo from adm_clasif where tipo='DESN2' order by texto";
                                                             break;
                                                         case "DESN4":
                                                             $ssql="select id as id, concat(' ', texto, ' (', codigodep, ')') as campo from adm_clasif where tipo='DESN3' order by texto";
                                                             break;
                                                     }
                                                     $sup->cargaCombo3($ssql, $depenclf, "Todos");
                                                    ?>
                                            </select> 
                                                <? } ?>
                                               <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_clasif_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar" title="Agregar"></i></a> 

                                            <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <? if($tipoclf!="") { ?>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> - Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <? } else {?>
                                            &nbsp;
                                            <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="10%">
                                                        <input name="id" type="hidden" id="id" value="0" />
                                                    </td>
                                                    <td width="25%">Descripción</td>
                                                    <td width="25%">Dependencia Nivel Superior</td>
                                                    <td width="25%" align="center">Codigo dep</td>
                                                    <td width="10%" align="center">Activo</td>
                                                    <td width="5%" align="center">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <? if($usr->getNivel()<2) { ?>
                                                            <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_clasif_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica" title="Modifica"></i></a> 
                                                        <? } ?>
                                                    </td>
                                                    <td><?= $a_tex[$i]?></td>
                                                    <td align="left"><?= $a_dep[$i]?></td>
                                                    <td align="center"><?= $a_cod[$i]?></td>
                                                    <td align="center">
                                                    <? if($a_act[$i]==1) { ?>
                                                        <i class="fas fa-check-circle fa-lg" alt="Descriptor Activo" title="Descriptor Activo"></i>
                                                    <? } ?>
                                                    </td>
                                                    <td align="center">
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Comprobante?','adm_clasif_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Comprobante" title="Elimina Comprobante"></i></a>
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
