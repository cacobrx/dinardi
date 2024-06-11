<?
/*
 * Creado el 07/07/2020 13:24:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_gas.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
$ssqltot="select sum(adm_gas.importe) as totgas from adm_gas inner join adm_com_det on adm_gas.id=adm_com_det.idgas where adm_gas.fecha>='$fechainigas' and adm_gas.fecha<='$fechafingas'";

$ssql="select adm_gas.* from adm_gas inner join adm_com_det on adm_gas.id=adm_com_det.idgas where adm_gas.fecha>='$fechainigas' and adm_gas.fecha<='$fechafingas'";
$condicion="";
if($idprvgas>0) $condicion.="adm_gas.idprv=$idprvgas and ";
if($descriptor1gas>0)
    $condicion.="adm_com_det.descriptor1=$descriptor1gas and ";
if($descriptor2gas>0)
    $condicion.="adm_com_det.descriptor2=$descriptor2gas and ";
if($descriptor3gas>0)
    $condicion.="adm_com_det.descriptor3=$descriptor3gas and ";
if($descriptor4gas>0)
    $condicion.="adm_com_det.descriptor4=$descriptor4gas and ";

if($condicion!="") $condicion=" and ".substr($condicion,0,strlen($condicion)-5);

$ssql.="$condicion order by adm_gas.fecha, adm_gas.id limit $limgas, $limmax";
$ssqltot.=$condicion;
//echo $ssqltot;
$rt=$conx->getConsulta($ssqltot);
$rtt= mysqli_fetch_object($rt);
$totalimp=$rtt->totgas;
//$ssql="select * from adm_gas ";
//$condicion="";
//$condicion="where fecha>='$fechainigas' and fecha<='$fechafingas' and ";
//if($idprvgas>0) 
//    $condicion.=" and idprv=$idprvgas";
//$ssql.="$condicion order by fecha ";
//echo $ssql;
$adm=new adm_gas_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_pro=$adm->getProveedor();
$a_det=$adm->getDet_detalle();
$a_imp=$adm->getImporte();
$a_fecv=$adm->getFechaven();
$d_id=$adm->getDet_id();
$d_des1=$adm->getDet_descriptor1des();
$d_des2=$adm->getDet_descriptor2des();
$d_des3=$adm->getDet_descriptor3des();
$d_des4=$adm->getDet_descriptor4des();
$a_cerrado=$adm->getCerrado();
$a_fecp=$adm->getFechapago();
$a_num=$adm->getNumero();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limgas)
    $cadenapaginas.=" <a href='javascript: document.form1.limgas.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_gas.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
	/*visibility:hidden;*/
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
                <input name="limgas" type="hidden" id="limgas" value="<?= $limgas?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">GASTOS</h3>   
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainigas" id="fechainigas" type="date" value="<?= $fechainigas?>" class="letra6" /> 
                                                    hasta <input name="fechafingas" id="fechafingas" type="date" value="<?= $fechafingas?>" class="letra6" /> | 
                                                    Proveedor <select name="idprvgas" id="idprvgas" onchange="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, left(concat_ws(' ', apellido, nombre),40) as campo from adm_prv where tipo=2 order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $idprvgas, "Todos");
                                                        ?>
                                                    </select>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td>
                                                Descriptores 
                                                <select name="descriptor1gas" id="descriptor1gas" onchange="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor1gas, "Todos");
                                                    ?>
                                                </select>
                                                |                                                
                                                <select name="descriptor2gas" id="descriptor2gas" onchange="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()">
                                                    <?
                                                    if($descriptor1gas>0){
                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' and dependencia=$descriptor1gas order by texto";
                                                        $sup->cargaCombo3($ssql, $descriptor2gas, "Todos");
                                                    }
                                                    ?>
                                                </select> | 
                                                <select name="descriptor3gas" id="descriptor3gas" onchange="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()">
                                                    <?
                                                    if($descriptor2gas>0){                                                    
                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' and dependencia=$descriptor2gas order by texto";
                                                        $sup->cargaCombo3($ssql, $descriptor3gas, "Todos");
                                                    }
                                                    ?>
                                                </select> | 


                                                <select name="descriptor4gas" id="descriptor4gas" onchange="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()">
                                                    <?
                                                    if($descriptor3gas>0){                                                    
                                                        $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' and dependencia=$descriptor3gas";
                                                        $sup->cargaCombo3($ssql, $descriptor4gas, "Todos");
                                                        }
                                                    ?>
                                                </select>
                                               <? echo $descriptor3gas."descas";?>                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limgas.value=0; document.form1.action='register_gas.php'; document.form1.submit()" /> 
                                                <input name="cmdlst" id="cmdlst" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_gas_lst.php'; document.form1.submit()" />
                                                <input type="submit" name="cmdexc" id="cmdexc" value="Exporta Excel" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_gas_exp.php'; document.form1.submit()" /> | 
                                                <input type="submit" name="cmdpag" id="cmdpag" value="Pagar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_gas_pagar.php'; document.form1.submit()" /> | 
                                                Total Importe: <span class="letra6bold"><?= number_format($totalimp,2)?></span>
                                            </td>
                                        </tr>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="6%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_gas_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Gastos" title="Agregar Gastos"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="5%" align="center">Nro.</td>
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="20%" align="left">Proveedor</td>                                                                                                                                                                                  
                                                            <td align="left">Descriptores</td>
                                                            <td width="10%" align="right">Importe</td> 
                                                            <td width="10%" align="center">Vencimiento</td> 
                                                            <td width="10%" align="center">Pagado</td> 
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($a_cerrado[$i]==0) { ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_gas_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Gastos" title="Modifica Gastos"></i></a> 
                                                                <?  } 
                                                                if($a_fecp[$i]=="") { ?>
                                                                <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" />
                                                                <? } ?>
                                                                <!--<a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_gas_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Gastos" title="Detalle Gastos"></i></a>--> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= $a_num[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_pro[$i]?></td>                                                                   
                                                            <td>
                                                                <? 
                                                                for($d=0;$d<count($d_id[$i]);$d++) {
                                                                    echo $d_des1[$i][$d]."/ ".$d_des2[$i][$d]."/ ".$d_des3[$i][$d]."/ ".$d_des4[$i][$d]."<br>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="right"><?= $a_imp[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fecv[$i])?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fecp[$i])?></td>
                                                            <? if($a_cerrado[$i]==0) { ?>
                                                            <td align="right"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Gastos?','adm_gas_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Gastos" title="Elimina Gastos"></i></a></td>
                                                            <? } ?>
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


