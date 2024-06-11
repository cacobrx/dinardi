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
require_once 'clases/adm_opg1.php';
require_once 'clases/conexion.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$limmax=$cfg->getLimmax();
$hoy=date("Y-m-d");
$condicionprv="";
if($campoopg!="") {
    $conn=$conx->conectarBase();
    $ntex=strlen($campoopg);
    if($criterioopg==1)
        $ssql="select * from adm_prv where left(upper(apellido), $ntex)='".strtoupper($campoopg)."'";
    else
        $ssql="select * from adm_prv where instr(upper(apellido),'".strtoupper($campoopg)."')>0";
    $rs=$conx->consultaBase($ssql, $conn);
    while($reg=mysqli_fetch_object($rs)) {
        $condicionprv.="idprv=".$reg->id." or ";
    }


    if($condicionprv!="")
        $condicionprv="and (".substr($condicionprv,0,strlen($condicionprv)-4).")";
    
}
    if($tipoopg>0)
        $condicionprv.="and tipo=$tipoopg";


$stot="select sum(adm_opg2.importe) as totalimporte from adm_opg2, adm_opg1 where (adm_opg1.fecha between '$fechainiopg' and '$fechafinopg') and adm_opg1.id=adm_opg2.idop and adm_opg1.centro=$centrosel $condicionprv";
$ssql="select * from adm_opg1 where $campofechaopg>='$fechainiopg' and $campofechaopg<='$fechafinopg' and adm_opg1.centro=$centrosel $condicionprv";
if($tipocontabilidadopg==1) {
    $ssql.=" and adm_opg1.numeroadj>0";
    $stot.=" and adm_opg1.numeroadj>0";
}
$ssql.=" order by $campofechaopg, id limit $limopg,$limmax";

//echo $stot."<br>";
if($conx->getCantidadReg($stot)>0) {
    $rs=$conx->getConsulta($stot);

    $rre=mysqli_fetch_object($rs);
    $total=$rre->totalimporte;
} else
    $total=0;   
//$total=0;
//echo $ssql."<br>";
$opg=new adm_opg1_2($ssql);
$a_id=$opg->getId();
$a_fec=$opg->getFecha();
$a_pro=$opg->getProveedor();
$a_imp=$opg->getTotalimporte();
$a_con=$opg->getConcepto();
$a_ret=$opg->getRetencioniibb();
$a_tip=$opg->getTipodes();
$a_rea=$opg->getRetencionganancia();
$a_nro1=$opg->getNumeroret();
$a_nro2=$opg->getNumeroretg();
$a_close=$opg->getCerrado();
$a_facturam=$opg->getFacturam();
$cantidadtotal=$opg->getMaxRegistros();

$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limopg)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limopg.value=$ini; document.form1.action=\"register_opg.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letra6bold'>$j</span></a>";
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
	/*visibility:hidden;*/
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
    <input name="limopg" type="hidden" id="limopg" value="<?= $limopg?>" />
    <input name="tarea" type="hidden" id="tarea" value="A" />
    <input name="idop" type="hidden" id="idop" value="0" />
    <input name="id" type="hidden" id="id" value="0" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>                        
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">ÓRDENES DE PAGO PROVEEDORES</h3>                
                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainiopg" type="date" class="letra6" id="fechainiopg" value="<?= $fechainiopg?>" /> 
                                            hasta <input name="fechafinopg" type="date" class="letra6" id="fechafinopg" value="<?= $fechafinopg?>" /> | 
                                            Proveedor <input name="campoopg" type="text" class="lt_klein_blackblack" id="campoopg" value="<?= $campoopg?>" /> | 
                                            Total: <span class="letra6bold">$<?= number_format($total,2)?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" name="Submit" value="Filtrar" onClick="javascript: document.form1.target='_self'; document.form1.limopg.value=0; document.form1.action='register_opg.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Imprimir" onClick="javascript: document.form1.target='_blank'; document.form1.action='adm_opg_prn.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Imprimir Retenciones ganancias" onClick="javascript: document.form1.target='_blank'; document.form1.action='adm_opg_ret_imp.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Descargar ARBA Retenciones" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_opg_arba_retenciones.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Descargar Retenciones Ganancias SICORE" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_opg_retenciones_sicore.php'; document.form1.submit()" />
                                            <!--<input type="submit" name="Submit" value="Descargar ARBA Retenciones" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_com_arba_retenciones_des.php'; document.form1.submit()" />-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad:</span> <?= $cantidadtotal?><span class="letra6bold"> - Pag: </span><?= $cadenapaginas?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr class="letra6bold">
                                                    <td width="10%">
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.tarea.value='A'; document.form1.action='adm_opg_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Orden de Pago" title="Agregar Orden de Pago"></i></a>
                                                        <? } ?>
                                                    </td>                                                 
                                                    <td width="5%" align="center">ID</td>
                                                    <td width="2%" align="center">T</td>
                                                    <td width="6%" align="center">Fecha</td>
                                                    <td width="25%">Proveedor</td>
                                                    <td>Concepto</td>
                                                    <td width="6%" align="right">Ret.IIBB</td>
                                                    <td width="4%" align="center">Nro</td>
                                                    <td width="6%" align="right">Ret.GAN</td>
                                                    <td width="4%" align="center">Nro</td>
                                                    <td width="6%" align="right">Importe</td>
                                                    <td width="2%" align="center">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <? if($usr->getNivel()<2 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_opg_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Orden de Pago" title="Modifica Orden de Pago"></i></a>
                                                        <? } ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Orden de Pago" title="Detalle Orden de Pago"></i></a>
                                                        <a href="javascript: document.form1.target='_blank'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_prnt.php'; document.form1.submit()"><i class="fas fa-print fa-lg" alt="Imprime Orden de Pago" title="Imprime Orden de Pago"></i></a>
                                                        <? if($a_ret[$i]>0) { ?>
                                                        <a href="javascript: document.form1.target='_blank'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_ret_prn.php'; document.form1.submit()"><i class="fas fa-print fa-lg" style="color: green" alt="Imprime Retención IIBB" title="Imprime Retención IIBB"></i></a>
                                                        <? } 
                                                        if($a_rea[$i]>0) { 
                                                            if($a_facturam[$i]=="M") { ?>
                                                                <a href="javascript: document.form1.target='_blank'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_retg_prn_m.php'; document.form1.submit()"><i class="fas fa-print fa-lg" style="color: orange" alt="Imprime Retención Ganancias" title="Imprime Ganancias"></i></a>
                                                            <? } else { ?>
                                                                <a href="javascript: document.form1.target='_blank'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_retg_prn.php'; document.form1.submit()"><i class="fas fa-print fa-lg" style="color: blue" alt="Imprime Retención Ganancias" title="Imprime Ganancias"></i></a>
                                                        <? } }?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.idop.value=<?= $a_id[$i]?>; document.form1.action='adm_opg_retg_mod.php'; document.form1.submit()"><i class="far fa-calendar-check fa-lg" style="color: blue" alt="Ajusta Retención Ganancias" title="Ajusta Ganancias"></i></a>
                                                    </td>       
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= substr($a_tip[$i],0,1)?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td><?= $a_pro[$i]?></td>
                                                    <td><?= $a_con[$i]?></td>
                                                    <td align="right"><?= number_format($a_ret[$i],2)?></td>
                                                    <td align="center"><?= $a_nro1[$i]?></td>
                                                    <td align="right"><?= number_format($a_rea[$i],2)?></td>
                                                    <td align="center"><?= $a_nro2[$i]?></td>
                                                    <td align="right"><?= number_format($a_imp[$i],2)?></td>
                                                    <td align="center">
                                                        <? if($usr->getNivel()<2 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: document.form1.target='_self'; bajareg(<?= $a_id[$i]?>,'Elimina Orden de Pago?','adm_opg_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Orden de Pago" title="Elimina Orden de Pago"></i></a>
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
        <td align="center"></td>
    </tr>
</form>
</div>
</body>
</html>
