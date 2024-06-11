<?
//session_start();
//print_r($_POST);
require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_crec.php';
require_once 'clases/conexion.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$limmax=$cfg->getLimmax();
$campofecha="fecha";

$stot="select sum(adm_crec2.importe) as totalimporte from adm_crec2, adm_crec1 where (adm_crec1.fecha between '$fechainicrec' and '$fechafincrec') and adm_crec1.id=adm_crec2.idcrec";
$ssql="select * from adm_crec1 where ($campofecha between '$fechainicrec' and '$fechafincrec')";
if($clientecrec>0) {
    $stot.=" and idcli=$clientecrec";
    $ssql.=" and idcli=$clientecrec";
}
if($numerocrec!="") {
    $stot.=" and numero=$numerocrec";
    $ssql.=" and numero=$numerocrec";
}

$ssql.=" order by $campofecha limit $limcrec,$limmax";
//echo $ssql."<br>";
//echo $stot."<br>";
if($conx->getCantidadReg($stot)>0) {
    $rs=$conx->getConsulta($stot);
    $rre=mysqli_fetch_object($rs);
    $total=$rre->totalimporte;
} else
    $total=0;   
//$total=0;
//echo $ssql."<br>";
$rec=new adm_crec1_2($ssql);
$a_id=$rec->getId();
$a_fec=$rec->getFecha();
$a_cli=$rec->getCliente();
$a_imp=$rec->getImporte();
$a_con=$rec->getConcepto();
$a_num=$rec->getNumero();
$a_idcli=$rec->getIdcli();
$r2_fec=$rec->getR2_fecha();
$r2_com=$rec->getR2_comprobante();
$r2_imp=$rec->getR2_importe();
$r2_pag=$rec->getR2_pagado();
$r2_id=$rec->getR2_id();
$r3_id=$rec->getR3_id();
$r3_det=$rec->getR3_detalle();
$r3_imp=$rec->getR3_importe();
$a_close=$rec->getCerrado();

//print_r($r3_id);


//print_r($r3_imp);
$cantidadtotal=$rec->getMaxRegistros();

$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcrec)
    $cadenapaginas.="- <a href='javascript: document.form1.limcrec.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_crec.php\"; document.form1.submit()' class='can'>$j</a>";
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
	z-index:1;
	margin-left: -480px;
	/*visibility:hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?5"></script>
<script type="text/javascript" src="planbjs/crec.js?15"></script>
<?require_once 'estilos.php';?>
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
        <input name="limcrec" type="hidden" id="limcrec" value="<?= $limcrec?>" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="idrec" type="hidden" id="idrec" value="0" />
        <input name="id" type="hidden" id="id" value="0" />
        <input name="indice" type="hidden" id="indice" value="0" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2" class="letra6">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">RECIBOS  DE CLIENTES</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainicrec" type="date" class="letra6" id="fechainicrec" value="<?= $fechainicrec?>" /> 
                                            hasta <input name="fechafincrec" type="date" class="letra6" id="fechafincrec" value="<?= $fechafincrec?>" /> | 
                                            Cliente <select name="clientecrec" id="clientecrec" onchange="javascript: document.form1.target='_self'; document.form1.limcrec.value=0; document.form1.action='register_crec.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, apellido as campo from adm_cli order by apellido";
                                                $sup->cargaCombo3($ssql,$clientecrec,"Todos");
                                                ?>
                                            </select> | 
                                            Ver Detalle <input name="detallecrec" id="detallecrec" type="checkbox" value="1" <? if($detallecrec==1) echo "checked='checked'"; ?> onclick="javascript: document.form1.target='_self'; document.form1.action='register_crec.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Recibo <input name="numerocrec" id="numerocrec" value="<?= $numerocrec?>" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" /> | 
                                            Total: <span class="letra6bold">$<?= number_format($total,2)?></span> | 
                                            <input type="submit" name="cmdok" value="Filtrar" onClick="javascript: document.form1.target='_self'; document.form1.limcrec.value=0; document.form1.action='register_crec.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdprn" value="Imprimir" onClick="javascript: document.form1.target='_blank'; document.form1.action='adm_crec_lst.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdexp" value="Exportar" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_crec_exp.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> - Pag: </span><?= $cadenapaginas?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr class="letra6bold">
                                                    <td width="7%">
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_crec_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Recibo" title="Agregar Recibo"></i></a>
                                                        <? } ?>
                                                    </td>
                                                    <td width="5%" align="center">Nro.</td>
                                                    <td width="10%" align="center">Fecha</td>
                                                    <td width="25%">Cliente</td>
                                                    <td width="40%">Concepto</td>
                                                    <td width="10%" align="right">Importe</td>
                                                    <td width="3%" align="center">&nbsp;</td>
                                                </tr>
                                                <? 
                                                for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                    <td>
                                                        <? if($usr->getNivel()<2 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_crec_mod.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Recibo" border="0" title="Modifica Recibo"></i></a>
                                                        <? } ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.idrec.value=<?= $a_id[$i]?>; document.form1.action='adm_crec_det.php'; document.form1.target='_self'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Recibo" title="Detalle Recibo"></i></a>
                                                        <a href="javascript: document.form1.idrec.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_crec_prn.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Recibo" title="Imprime Recibo"></i></a>
                                                    </td>
                                                    <td align="center"><?= $a_num[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td><?= $a_cli[$i]?></td>
                                                    <td><?= $a_con[$i]?></td>
                                                    <td align="right">$<?= number_format($a_imp[$i],2)?></td>
                                                    <td align="center">
                                                        <? if($usr->getNivel()<2 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Recibo?','adm_crec_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Recibo" title="Elimina Recibo"></i></a> 
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <? if($detallecrec==1) { ?>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="panel700c letra6">
                                                            <div id="effect-panel700c" class="ui-widget-content ui-corner-all">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <tr>
                                                                        <td colspan="5" align="center" class="ui-widget-header ui-corner-all">Documentos Aplicados</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" id="datosapli<?= $i?>" style="display: none">
                                                                                <tr>
                                                                                    <td>
                                                                                        <select name="idfis<?= $i?>" id="idfis<?= $i?>">
                                                                                            <?
                                                                                            $sup->cargaComboArrayValor($f_id, $f_com, 0, "Sel");
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.indice.value=<?= $i?>; document.form1.action='adm_crec2_add_save.php'; document.form1.submit()"><i class="far fa-save"></i></a>&nbsp;<a href="javascript: hidediv('datosapli', '<?= $i?>')"><i class="fa fa-ban" aria-hidden="true"></i></a>                                                                            
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        </tr>
                                                                    </tr>
                                                                    <tr class="letra6bold">
                                                                        <td width="5%"><a href="#" onclick="javascript: crec2(<?= $a_idcli[$i]?>, '<?= $i?>'); showdiv('datosapli', '<?= $i?>')"><i class="fas fa-plus-circle" title="Agregar documento a aplicar"></i></a></td>
                                                                        <td width="10%"align="center">Fecha</td>
                                                                        <td width="20%">Comprobante</td>
                                                                        <td width="10%" align="right">Importe</td>
                                                                        <td width="10%" align="right">Pagado</td>
                                                                    </tr>
                                                                    <? for($i2=0;$i2<count($r2_fec[$i]); $i2++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                                        <td>
                                                                            <a href="javascript: document.form1.target='_self'; bajareg('<?= $r2_id[$i][$i2]?>', 'Elimina comprobante aplicado?', 'adm_crec2_del_save.php')"><i class="fas fa-trash-alt" style="color: darkred" title="Borrar documento a aplicar"></a></i>
                                                                        </td>
                                                                        <td align="center"><?= $dsup->getFechaNormalCorta($r2_fec[$i][$i2])?></td>
                                                                        <td><?= $r2_com[$i][$i2]?></td>
                                                                        <td align="right"><?= number_format($r2_imp[$i][$i2],2)?></td>
                                                                        <td align="right"><?= number_format($r2_pag[$i][$i2],2)?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                    <tr class="letra6bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td colspan="2"></td>
                                                                        <td>Total</td>
                                                                        <td align="right"><?= number_format(array_sum($r2_imp[$i]),2)?></td>
                                                                        <td align="right"><?= number_format(array_sum($r2_pag[$i]),2)?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="panel700c letra6">
                                                            <div id="effect-panel700c" class="ui-widget-content ui-corner-all">
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <tr>
                                                                        <td colspan="4" align="center" class="ui-widget-header ui-corner-all">Detalle de los Pagos</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" id="datospag<?= $i?>" style="display: none">
                                                                                <tr>
                                                                                    <td>
                                                                                        <select name="tipopago<?= $i?>" id="tipopago<?= $i?>">
                                                                                            <?
                                                                                            $ssql="select valor as id, descripcion as campo from tablas where codtab='DPG' order by valor";
                                                                                            $sup->cargaCombo3($ssql, 1);
                                                                                            ?>
                                                                                        </select> 
                                                                                        <input name="idcht<?= $i?>" id="idcht<?= $i?>" size="5" maxlength="10" placeholder="ID.Cheq" onkeypress="return validar(event)" style="text-align: center" /> 
                                                                                        <input name="detallepago<?= $i?>" id="detallepago<?= $i?>" size="30" maxlength="50" placeholder="Detalle del pago" /> 
                                                                                        <input name="importepago<?= $i?>" id="importepago<?= $i?>" size="10" maxlength="10" placeholder="Importe" onkeypress="return validar_punto(event)" style="text-align: center" />
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.indice.value=<?= $i?>; document.form1.action='adm_crec3_add_save.php'; document.form1.submit()"><i class="far fa-save"></i></a>&nbsp;<a href="javascript: hidediv('datospag', '<?= $i?>')"><i class="fa fa-ban" aria-hidden="true"></i></a> 
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        </tr>
                                                                    </tr>
                                                                    <tr class="letra6bold">
                                                                        <td width="5%"><a href="#" onclick="javascript: showdiv('datospag', '<?= $i?>')"><i class="fas fa-plus-circle" title="Agregar forma de pago"></i></a></td>
                                                                        <td width="20%">Detalle</td>
                                                                        <td width="10%" align="right">Importe</td>
                                                                    </tr>
                                                                    <? for($i3=0;$i3<count($r3_det[$i]); $i3++) { ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                                        <td>
                                                                            <a href="javascript: document.form1.target='_self'; bajareg('<?= $r3_id[$i][$i3]?>', 'Elimina forma de pago?', 'adm_crec3_del_save.php')"><i class="fas fa-trash-alt" style="color: darkred" title="Borrar forma de pago"></a></i>
                                                                        </td>
                                                                        <td><?= $r3_det[$i][$i3]?></td>
                                                                        <td align="right"><?= number_format($r3_imp[$i][$i3],2)?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                    <tr class="letra6bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td></td>
                                                                        <td>Total</td>
                                                                        <td align="right"><?= number_format(array_sum($r3_imp[$i]),2)?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><hr></hr></td>
                                                </tr>
                                                <? } 
                                                } ?>
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
