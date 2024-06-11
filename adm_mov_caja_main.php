<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_mov_caja.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/adm_mov_caja_ini.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();

$condicion="";
if($cajamcj>0)
    $condicion.=" and tipocaja=$cajamcj";
if($textomcj!="")
    $condicion.=" and (instr(upper(detalle), '".strtoupper($textomcj)."')>0 or instr(upper(indice), '".strtoupper($textomcj)."')>0)";
if($descriptor1mcj>0)
    $condicion.=" and descriptor1=$descriptor1mcj";
if($descriptor2mcj>0)
    $condicion.=" and descriptor2=$descriptor2mcj";
if($descriptor3mcj>0)
    $condicion.=" and descriptor3=$descriptor3mcj";
if($descriptor4mcj>0)
    $condicion.=" and descriptor4=$descriptor4mcj";
if($oficinamcj>0)
    $condicion.=" and oficina=$oficinamcj";
if($tipopagomcj>0)
    $condicion.=" and tipopago=$tipopagomcj";
if($tipomovmcj>0) {
    if($tipomovmcj==1)
        $condicion.=" and tipomov=0";
    else
        $condicion.=" and tipomov=1";
}

$ssql="select * from adm_mov_caja where centro=$centrosel and eliminado=0 $condicion and fecha>='$fechainimcj' and fecha<='$fechafinmcj' order by fecha, id";
if($paginarmcj==1)
    $ssql.=" limit $limmcj, ".$cfg->getLimmax();
//limit $limmcj,".$cfg->getLimmax();
$adm=new adm_mov_caja_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_id=$adm->getid();
$a_fec=$adm->getfecha();
$a_det=$adm->getdetalle();
$a_imp=$adm->getimporte();
$a_tip=$adm->gettipocaja();
$a_des1=$adm->getDescriptor1des();
$a_des2=$adm->getDescriptor2des();
$a_des3=$adm->getDescriptor3des();
$a_des4=$adm->getDescriptor4des();
$a_tmv=$adm->getDescriptor1();
$a_ofi=$adm->getOficinades();
$a_pgo=$adm->getTipopagodes();
$a_ind=$adm->getIndice();
$a_idrec=$adm->getIdrec();
$a_idopg=$adm->getIdopg();

//$sal=new Saldoinicial($fechainimcj, $cajamcj);
//$saldoini=$sal->getSaldoini();
$saldoini=0;
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limmcj)
    $cadenapaginas.=" <a href='javascript: document.form1.target=\"_self\"; document.form1.limmcj.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_mcj.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
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
                <input name="limmcj" type="hidden" id="limmcj" value="<?= $limmcj?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td colspan="2">
                    <? require("displayusuario.php");?>
                    <div class="panelmax letra6">
                        <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                            <h3 class="ui-widget-header ui-corner-all">MOVIMIENTOS DE CAJA</h3>
                            <tr>
                                <td colspan="2">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td colspan="3">
                                                Fecha desde <input name="fechainimcj" id="fechainimcj" type="date" value="<?= $fechainimcj?>" class="letra6" /> hasta <input name="fechafinmcj" id="fechafinmcj" type="date" value="<?= $fechafinmcj?>" class="letra6" /> 
                                                | Caja 
                                                <select name="cajamcj" id="cajamcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select valor as id, descripcion as campo from tablas where codtab='CAJA'";
                                                    if($usr->getNivel()>0)
                                                        $ssql.=" and valorc='0'";
                                                    $ssql.=" order by descripcion";
                                                    $sup->cargaCombo3($ssql, $cajamcj);
                                                    ?>
                                                </select> | Movimiento <select name="tipomovmcj" id="tipomovmcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $array=array("Entradas","Salidas");
                                                    $avalor=array(1,2);
                                                    $sup->cargaComboArrayValor($array, $avalor, $tipomovmcj, "Todos");
                                                    ?>
                                                </select> | 
                                                Buscar <input name="textomcj" id="textomcj" type="text" value="<?= $textomcj?>" /> | 
                                                <input name="cmdok" id="cmdok" value="Filtrar" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()" /> 
                                                <input name="cmdprn" id="cmdprn" value="Imprimir" type="submit" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_mov_caja_lst.php'; document.form1.submit()" /> 
                                                <input name="cmdexc" id="cmdexc" value="Exportar Excel" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_mov_caja_exc.php'; document.fom1.submit()" /> 
                                                <select name="formatoexc" id="formatoexc">
                                                    <?
                                                    $array=array(". decimal", ", decimal");
                                                    $avalor=array(0,1);
                                                    $sup->cargaComboArrayValor($array, $avalor, 0);
                                                    ?>
                                                </select>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Descriptores 
                                                <select name="descriptor1mcj" id="descriptor1mcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN1' order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor1mcj, "Todos");
                                                    ?>
                                                </select> | 
                                                <select name="descriptor2mcj" id="descriptor2mcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN2' order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor2mcj, "Todos");
                                                    ?>
                                                </select> | 
                                                <select name="descriptor3mcj" id="descriptor3mcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN3' order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor3mcj, "Todos");
                                                    ?>
                                                </select> | 
                                                <select name="descriptor4mcj" id="descriptor4mcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select id as id, texto as campo from adm_clasif where tipo='DESN4' order by texto";
                                                    $sup->cargaCombo3($ssql, $descriptor4mcj, "Todos");
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
      
                                        <tr>
                                            <td>
                                                Oficina 
                                                <select name="oficinamcj" id="oficinamcj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select valor as id, descripcion as campo from tablas where codtab='OFIN1' order by descripcion";
                                                    $sup->cargaCombo3($ssql, $oficinamcj, "Todos");
                                                    ?>
                                                </select> | 
                                                Tipo de Gasto 
                                                <select name="tipopagomcj" id="tipopagocmj" onchange="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $ssql="select valor as id, descripcion as campo from tablas where codtab='MEDIO' order by descripcion";
                                                    $sup->cargaCombo3($ssql, $tipopagomcj, "Todos");
                                                    ?>
                                                </select>
                                                <select name="vistamcj" id="vistamcj" onchange="javascript: document.form1.target='_self'; document.form1.action='register_mcj.php'; document.form1.submit()">
                                                    <?
                                                    $array=array("Vista 1", "Vista 2");
                                                    $avalor=array(1,2);
                                                    $sup->cargaComboArrayValor($array, $avalor,$vistamcj);
                                                    ?>
                                                </select> || 
                                                <a href="javascript: document.form1.target='_self'; document.form1.action='adm_mov_caja_main.php'; document.form1.submit()"><i class="fas fa-refresh fa-lg" alt="Refrescar" title="refrescar"></i></a> 
                                                <input name="filtrook" id="cmdprn" value="Limpiar Filtros" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.action='register_mcj_reset.php'; document.form1.submit()" /> | 
                                                <input name="cmdexct" id="cmdexct" value="Excel Todas las Cajas" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_mov_caja_exc_t.php'; document.form1.submit()" />
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="ui-widget-header ui-corner-all"><span class="letra6"><input name="paginarmcj" id="paginarmcj" type="checkbox" value="1" <? if($paginarmcj==1) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.limmcj.value=0; document.form1.action='register_mcj.php'; document.form1.submit()" /> Paginar | Cantidad: </span><span class="letra6bold"><?= $cantidadtotal?></span>
                                                <? if($paginarmcj==1) { ?>
                                                - Pag: <?= $cadenapaginas?>
                                                <? } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                    <tr class="letra6bold">
                                                        <td width="3%">
                                                            <? if($usr->getNivel()<2) { ?>
                                                            <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_mov_caja_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Moviemiento de caja" title="movimiento de Caja"></i></a> 
                                                            <? } ?>
                                                        </td>
                                                        <td width="3%" align="center">Id</td>
                                                        <td width="6%" align="center">Fecha</td>
                                                        <td width="24%" align="left">Detalle</td>
                                                        <td>Descriptor</td>
                                                        <? if($vistamcj==1) { ?>
                                                        <td width="8%">Oficina</td>
                                                        <? } else { ?>
                                                        <td width="11%">Indice</td>
                                                        <td width="6%" align="center">Id Rec</td>
                                                        <td width="6%" align="center">Id OPG</td>
                                                        <? } ?>
                                                        <td width="7%">Pago</td>
                                                        <td width="6%" align="right">Importe</td>
                                                        <td width="6%" align="right">Saldo</td>
                                                        <td width="2%">&nbsp;</td>
                                                    </tr>
<!--                                                    <tr>
                                                        <td colspan="2">&nbsp;</td>
                                                        <td align="center"><?= date("d/m/Y", strtotime("$fechainimcj - 1 day"))?></td>
                                                        <td>Saldo Inicial</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td align="right"><?= number_format($saldoini,2)?></td>
                                                    </tr>-->
                                                    <? 
                                                    $saldo=$saldoini;
                                                    for($i=0;$i<count($a_id);$i++) { 
                                                        $saldo+=$a_imp[$i];
                                                        $des=$a_des1[$i]."/".$a_des2[$i]."/".$a_des3[$i]."/".$a_des4[$i];
                                                        
                                                        ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <? if($usr->getNivel()<2) { ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_mov_caja_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Movimiento de Caja" title="Modifica Movimiento de Caja"></i></a> 
                                                                <? } ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_mov_caja_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Movimiento de caja" title="Detalle Moviemiento de caja"></i></a> 
                                                            </td>
                                                        <td align="center"><?= $a_id[$i]?></td>
                                                        <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_det[$i]?></td>
                                                            <td><?= $des?></td>
                                                            <? if($vistamcj==1) { ?>
                                                            <td><?= $a_ofi[$i]?></td>
                                                            <? } else { ?>
                                                            <td><?= $a_ind[$i]?></td>
                                                            <td align="center"><?= $a_idrec[$i]?></td>
                                                            <td align="center"><?= $a_idopg[$i]?></td>
                                                            <? } ?>
                                                            <td><?= $a_pgo[$i]?></td>
                                                            <td align="right"><?= number_format($a_imp[$i],2);?></td>
                                                            <td align="right"><?= number_format($saldo,2)?></td>
                                                            <td align="center">
                                                                <? if($usr->getNivel()<2) { ?>
                                                                <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Movimientos de Caja?','adm_mov_caja_eli.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Orden de Pago" title="Elimina Orden de Pago"></i></a>
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                    <? } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </form>
    </div>
</body>
</html>


