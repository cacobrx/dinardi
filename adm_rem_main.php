<?php
/*
 * Creado el 21/01/2019 10:48:18
 * Autor: gus
 * Archivo: adm_rem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem.php';
require_once 'clases/seleccion.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$totaltodo=$glo->getGETPOST("totaltodo");
if($totaltodo=="") $totaltodo=0;
$totalkilos=$glo->getGETPOST("totalkilos");
if($totalkilos=="") $totalkilos=0;
$limmax=$cfg->getLimmax();


//$limmax=5;
$ssql="select adm_rem.* from adm_rem inner join adm_prv on adm_rem.idprv=adm_prv.id where adm_rem.fecha>='$fechainirem' and adm_rem.fecha<='$fechafinrem'";
if($proveedorrem>0) $ssql.=" and adm_rem.idprv=$proveedorrem";
if($faenarem==1) $ssql.=" and adm_rem.faena=1";
if($sincomprasrem==1) $ssql.=" and adm_rem.idcom=0";
if($seleccionrem==1) $ssql.=" and adm_rem.seleccion=1";
if($certificadorem!="") $ssql.=" and adm_rem.certificado='".$certificadorem."'";
if($paisrem>0) $ssql.=" and instr(adm_prv.paises,'|".$paisrem."|')>0";
//$adm=new adm_rem_2($ssql);
//$ttt=$adm->getDet_total();
//$totaltodo=0;
//for($i=0;$i<count($ttt);$i++) {
//    //print_r($ttt[$i]);
//    $totaltodo+=array_sum($ttt[$i]);
//}

//$totaltodo=0;

$ssql.=" order by fecha, id limit $limrem, $limmax";
//echo $ssql;
$adm=new adm_rem_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getProveedor();
$a_pre=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_idcom=$adm->getIdcom();
$a_pat=$adm->getPatente();
$a_num=$adm->getNumero();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_des=$adm->getDet_descripcion();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_tot=$adm->getDet_total();
$d_can=$adm->getDet_cantidad();
$d_ani=$adm->getDet_animales();
$d_kil=$adm->getDet_kilos();
$d_uni=$adm->getDet_unidaddes();
$c_can=$adm->getCrm_cantidad();
$c_art=$adm->getCrm_articulo();
$c_uni=$adm->getCrm_unidaddes();
$d_iva=$adm->getDet_alicuota();
$a_sel=$adm->getSeleccion();
$a_ctrl=$adm->getControlado();
$e_idela=$adm->getCrm_idela();
$e_idenv=$adm->getCrm_idenv();
$e_fechaela=$adm->getFechaela();
$e_fechaenv=$adm->getFechaenv();
$a_pai=$adm->getPaises();
$a_cer=$adm->getCertificado();
//print_r($d_can);

$a_faena=$adm->getFaena();
$a_ff=$adm->getFaenac();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limrem)
    $cadenapaginas.=" <a href='javascript: document.form1.limrem.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_rem.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.0"></script>
<script type="text/javascript" src="planbjs/rem.js?8"></script>
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
                <input name="idrem" type="hidden" id="idrem" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limrem" type="hidden" id="limrem" value="<?= $limrem?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panelmax letra6">
                                    <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">REMITOS DE ENTRADA</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainirem" id="fechainirem" type="date" value="<?= $fechainirem?>" class="letra6" /> 
                                                    hasta <input name="fechafinrem" id="fechafinrem" type="date" value="<?= $fechafinrem?>" class="letra6" /> | 
                                                    Proveedor <select name="proveedorrem" id="proveedorrem" onchange="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $proveedorrem, "Todos");
                                                        ?>
                                                    </select>
                                                    Certificado
                                                    <input name="cer1rem" id="cer1rem" type="text" size="4" maxlength="4" onkeypress="return validar(event)" style="text-align: center" value="<?= substr($certificadorem, 0,4)?>"/>
                                                    <input name="letrarem" id="letrarem" type="text" size="1" maxlength="1" style="text-align: center" value="<?= substr($certificadorem, 4,1)?>"/>
                                                    <input name="cer2rem" id="cer2rem" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" value="<?= substr($certificadorem, 5,8)?>"/> | 
                                                    País <select name="paisrem" id="paisrem" onchange="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select valor as id, descripcion as campo from tablas where codtab='PAI' order by descripcion";
                                                        $sup->cargaCombo3($ssql, $paisrem, "Todos");
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Solo Seleccionados <input name="seleccionrem" id="seleccionrem" type="checkbox" value="1" <? if($seleccionrem==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()" /> | 
                                                    <a href="javascript: document.form1.target='_self'; document.form1.action='adm_rem_sel_0.php'; document.form1.submit()">Limpiar Selec.</a>
                                                    Ver Detalle <input name="detallerem" id="detallerem" type="checkbox" value="1" <? if($detallerem==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()" /> | 
                                                    Sólo Faena <input name="faenarem" id="faenarem" type="checkbox" value="1" <? if($faenarem==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()" /> | 
                                                    Remitos Sin Compra <input name="sincomprasrem" id="sincomprasrem" type="checkbox" value="1" <? if($sincomprasrem==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()" /> | 
                                                    <a href="javascript: document.form1.target='_self'; document.form1.action='adm_rem_vertotal.php'; document.form1.submit()">Ver Totales</a> <strong><?= number_format($totaltodo,2)?></strong> | Cantidad <strong><?=$totalkilos?></strong> | 
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Copias <select name="copiasimp" id="copiasimp">
                                                        <?
                                                        $arraycopias=array("ORIGINAL","DUPLICADO","TRIPLICADO", "ORIGINAL + DUPLICADO", "ORI + DUP + TRI");
                                                        $arrayncopias=array(1,2,3,4,5);
                                                        $sup->cargaComboArrayValor($arraycopias, $arrayncopias, 1);
                                                        ?>
                                                    </select>                                                    
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limrem.value=0; document.form1.action='register_rem.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_rem_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkprn2" id="chkprn" type="submit" value="Imprimir Detalle" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_rem_prn2.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_rem_exp.php'; document.form1.submit()" /> 
                                                    <!--<input name="cmdinf" id="cmdinf" type="submit" value="Informe" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_rem_det_main.php'; document.form1.submit()" />-->
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
                                                                <a href="javascript: document.form1.target='_self'; document.form1.action='adm_rem_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Remito" title="Agregar Remito"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="8%" align="center">Fecha</td>
                                                            <td align="left">Proveedor</td>
                                                            <td align="left">Certificado</td>
                                                            <td width="15%" align="left">Países</td>
                                                            <td align="center" width="7%">Nro.</td>
                                                            <td align="center" width="7%">Patente</td>
                                                            <td align="center" width="2%">F</td>
                                                            <td align="center" width="5%">Cm</td>
                                                            <td align="right" width="6%">Cantidad</td>
                                                            <td width="10%" align="right">Total</td>
                                                            <td width="1%">&nbsp;</td>
                                                        </tr>
                                                        <?                                                         
                                                        for($i=0;$i<count($a_id);$i++) {  ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_rem_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Remito" title="Modifica Remito"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_rem_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Remito" title="Detalle Remito"></i></a> 
                                                                <a href="javascript: document.form1.idrem.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_rem_crm_add.php'; document.form1.submit()"><i class="fab fa-rev fa-lg" alt="Control Remito" title="Control Remito"></i></a>   
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_rem_lst.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Remito" width="12" height="12" border="0" title="Imprime Remito" ></i></a>                                                                 
                                                                <? 
                                                                $ssee=0;                                                                   
                                                                if($a_sel[$i]==0) $ssee=1;                                                                
                                                                ?>
                                                                <input name="chksel<?= $i?>" id="chksel<?= $i?>" type="checkbox" value="1" <? if($a_sel[$i]==1) echo "checked='checked'";?> onclick="javascript: setseleccionrem(<?= $a_id[$i]?>, <?= $ssee?>)" />
                                                                    <? if($a_ctrl[$i]==1) { ?>
                                                                        <i id="controlado<?= $i?>" class="far fa-check-circle fa-lg" alt="Remito Controlado" title="Remito Controlado" style="color: green" onclick="javascript: save_rem(<?= $a_id[$i]?>, <?= $i?>)"></i> 
                                                                    <? } else { ?>
                                                                        <i id="controlado<?= $i?>" class="far fa-check-circle fa-lg" alt="Remito No Controlado" title="Remito No Controlado" style="color: red" onclick="javascript: save_rem(<?= $a_id[$i]?>, <?= $i?>)"></i>
                                                                   <? } ?>                                                                    
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                            <td align="left"><?= $a_des[$i]?></td>
                                                            <td align="left"><?= $a_cer[$i]?></td>
                                                            <td align="left"><?= $a_pai[$i]?></td>
                                                            <td align="center"><?= $a_num[$i]?></td>
                                                            <td align="center"><?= $a_pat[$i]?></td>
                                                            <td align="center">
                                                                <? if($a_ff[$i]==1) { ?>
                                                                <i class="fas fa-piggy-bank fa-lg"></i>
                                                                <? } ?>
                                                            </td>
                                                            <td align="center"><?= $a_idcom[$i]?></td>
                                                            <td align="right">
                                                                <?
                                                                if($a_ff[$i]==1)
                                                                    echo array_sum($d_can[$i]);
                                                                else
                                                                    echo array_sum($c_can[$i]);
                                                                ?>
                                                            </td>
                                                            <td align="right"><?= number_format(array_sum($d_tot[$i]),2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Remito?','adm_rem_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Remito" title="Elimina Remito"></i></a></td>
                                                        </tr>
                                                        <? if($detallerem==1) { ?>
                                                        <tr>
                                                            <td colspan="11">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <thead class="thead-light">
                                                                        <tr class="letra6bold">
                                                                            <td width="30%">Producto</td>
                                                                            <td >Detalle</td>
                                                                            <td align="center" width="4%">Unidad</td>
                                                                            <td align="center" width="6%">Cantidad</td>
                                                                            <td align="center" width="6%">Can.Ctrol</td>
                                                                            <td align="center" width="6%">Dif.</td>
                                                                            <td align="right" width="4%">IVA</td>
                                                                            <td align="right" width="6%">Precio</td>
                                                                            <td align="right" width="6%">Total</td>
                                                                            <td align="center" width="8%">Elaboración</td>
                                                                            <td align="center" width="8%">Envasado</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <? for($d=0;$d<count($d_can[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td><?= $d_art[$i][$d]?></td>
                                                                        <td><?= $d_des[$i][$d]?></td>
                                                                        <td align="center"><?= $d_uni[$i][$d]?></td>
                                                                        <td align="center"><?= $d_can[$i][$d]?></td>
                                                                        <? 
                                                                        if(!$a_faena[$i]) {
                                                                            if($c_can[$i][$d]==-1 or $c_can[$i][$d]=="") { ?>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            <? } else { ?>
                                                                                <td align="center"><?= $c_can[$i][$d]?></td>
                                                                                <td align="center"><?= number_format($c_can[$i][$d] - $d_can[$i][$d],3)?></td>
                                                                            <? } 
                                                                        } else { ?>
                                                                            <td>&nbsp;</td>
                                                                            <td>&nbsp;</td>
                                                                        <? } ?>
                                                                        <td align="right"><?= number_format($d_iva[$i][$d],2)?></td>
                                                                        <td align="right"><?= number_format($d_pre[$i][$d],4)?></td>
                                                                        <td align="right">
                                                                            <? 
                                                                            if($a_faena[$i]==1)
                                                                                echo number_format($d_can[$i][$d]*$d_pre[$i][$d],4);
                                                                            else {
                                                                                if(count($c_can[$i])>0) { 
                                                                                    if($c_can[$i][$d]>0) 
                                                                                        echo number_format($c_can[$i][$d]*$d_pre[$i][$d],4);
                                                                                    else
                                                                                        echo number_format($d_can[$i][$d]*$d_pre[$i][$d],4);
                                                                                } else 
                                                                                    echo number_format($d_can[$i][$d]*$d_pre[$i][$d],4);
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <? if($a_faena[$i]==0) { ?>
                                                                        <td align="center"><?= "(".$e_idela[$i][$d].") ".$dsup->getFechaNormalCorta($e_fechaela[$i][$d])?></td>
                                                                        <td align="center"><?= "(".$e_idenv[$i][$d].") ".$dsup->getFechaNormalCorta($e_fechaenv[$i][$d])?></td>
                                                                        <? } ?>
                                                                    </tr>
                                                                    <? } 
                                                                    if($a_faena[$i]==1) {
                                                                    for($d=0;$d<count($c_can[$i]);$d++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td><?= $c_art[$i][$d]?></td>
                                                                        <td>&nbsp;</td>
                                                                        <td align="center"><?= $c_uni[$i][$d]?></td>
                                                                        <td align="center"><?= $c_can[$i][$d]?></td>
                                                                        <td align="center"><?= $c_can[$i][$d]?></td>
                                                                        <td colspan="4">&nbsp;</td>
                                                                        <td align="center">
                                                                            <?
                                                                            if($e_idela[$i][$d]>0) echo  "(".$e_idela[$i][$d].") ".$dsup->getFechaNormalCorta($e_fechaela[$i][$d]);?>
                                                                        </td>
                                                                        <td align="center">
                                                                            <? if($e_idenv[$i][$d]>0) echo "(".$e_idenv[$i][$d].") ".$dsup->getFechaNormalCorta($e_fechaenv[$i][$d])?>
                                                                        </td>
                                                                    </tr>
                                                                    <? } }?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="11"><hr></hr></td>
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
