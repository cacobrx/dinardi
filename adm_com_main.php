<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
 
$ssql="select * from adm_com where centro=$centrosel and $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and tipo=1";
if($proveedorcom>0)
    $ssql.=" and idprv=$proveedorcom";
$ssqt="select sum(neto21) as tneto21, sum(neto10) as tneto10, sum(neto27) as tneto27, sum(iva21) as tiva21, sum(iva10) as tiva10, sum(iva27) as tiva27, sum(exento) as texento, sum(nogravado) as tnogravado, sum(impinternos+periva+retiva+perretiibb) as timp";
$ssqt.=" from adm_com where $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and tipo=1";
if($proveedorcom>0)
    $ssqt.=" and idprv=$proveedorcom";
if($numerocom!="") {
    $ssql.=" and numero=$numerocom";
    $ssqt.=" and numero=$numerocom";
}
$ssqf=$ssqt." and tipocom!=2";
$ssqc=$ssqt." and tipocom=2";
//echo $ssqf."\n";
$rt=$conx->getConsulta($ssqf);
$rtt=  mysqli_fetch_object($rt);
$tneto21=$rtt->tneto21;
$tneto10=$rtt->tneto10;
$tneto27=$rtt->tneto27;
$tiva21=$rtt->tiva21;
$tiva10=$rtt->tiva10;
$tiva27=$rtt->tiva27;
$texento=$rtt->texento;
$tnogravado=$rtt->tnogravado;
$timp=$rtt->timp;

//echo $ssqc."\n";
$rc=$conx->getConsulta($ssqc);
$rcc=  mysqli_fetch_object($rc);
$tneto21-=$rcc->tneto21;
$tneto10-=$rcc->tneto10;
$tneto27-=$rcc->tneto27;
$tiva21-=$rcc->tiva21;
$tiva10-=$rcc->tiva10;
$tiva27-=$rcc->tiva27;
$texento-=$rcc->texento;
$tnogravado-=$rcc->tnogravado;
$timp-=$rcc->timp;

$totalcom=$tneto21+$tneto10+$tneto27+$tiva21+$tiva10+$tiva27+$texento+$tnogravado+$timp;
$tneto=$tneto21+$tneto10+$tneto27;
$ssql.=" order by fecha limit $limcom,".$cfg->getLimmax();
//$ssql="Select * from adm_com where id=2663";
$adm=new adm_com_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_pri=$adm->getPeriva();
$a_rti=$adm->getRetiva();
$a_prb=$adm->getPerretiibb();
$a_exe=$adm->getExento();
$a_ngr=$adm->getNogravado();
$a_fev=$adm->getFechaimputacion();
$a_imi=$adm->getImpinternos();
$a_mov=$adm->getMovimiento();
$a_asi=$adm->getCantidadasientos();
$a_nasi=$adm->getAsientos();
$m_det=$adm->getMov_detallecon();
$m_ent=$adm->getMov_entrada();
$m_sal=$adm->getMov_salida();
$m_cta=$adm->getMov_cuentades();
$d_ent=$adm->getDet_entrada();
$d_sal=$adm->getDet_salida();
$d_cta=$adm->getDet_cuentades();
$a_comx=$adm->getComprobantetodo();
$a_pag=$adm->getImportepag();
$a_close=$adm->getCerrado();
//print_r($d_ent[1]);
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcom)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limcom.value=$ini; document.form1.action=\"register_com.php\"; document.form1.submit()' class='can'>$j</a>";
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
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css?2.0.1" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.1"></script>
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
        <input name="id" type="hidden" id="id" value="0" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="limcom" type="hidden" id="limcom" value="<?= $limcom?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <? require_once 'displayusuario.php'?>                        
                <tr>
                    <td colspan="2">
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">COMPRAS</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            <select name="campofechacom" id="campofechacom" onchange="javascript: document.form1.limcom.value=0; document.form1.target='_self'; document.form1.action='register_com.php'; document.form1.submit()">
                                                <?
                                                $array=array("Fecha Origen", "Fecha Imputacion");
                                                $avalor=array("fecha","fechaimputacion");
                                                $sup->cargaComboArrayValor($array, $avalor, $campofechacom);
                                                ?>
                                            </select>
                                            desde <input name="fechainicom" type="date" class="letra6" id="fechainicom" value="<?= $fechainicom?>" /> 
                                            hasta <input name="fechafincom" type="date" class="letra6" id="fechafincom" value="<?= $fechafincom?>" />
                                            <input type="submit" name="cmdOk" id="cmdOk" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limcom.value=0; document.form1.action='register_com.php'; document.form1.submit()" /> | 
                                            <input type="submit" name="cmdCiti" id="cmdCiti" value="Exportar CITI" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_citi.php'; document.form1.submit()" /> 
                                            <input type="submit" name="cmdCitiIVA" id="cmdCitiIVA" value="Exportar CITI Alicuotas" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_citi_iva.php'; document.form1.submit()" /> 

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Número <input name="numerocom" id="numerocom" type="text" size="8" maxlength="8" onkeypress="return validar(event)" style="text-align: center" value="<?= $numerocom?>" /> | 
                                            <input name="cmdlst" id="cmdlst" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_com_lst.php'; document.form1.submit()" />
                                            <input type="submit" name="cmdexc" id="cmdexc" value="Exporta Excel" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_exl.php'; document.form1.submit()" /> 
                                            <!--<input type="submit" name="Submit" value="Descargar ARBA Retenciones" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_com_arba_retenciones.php'; document.form1.submit()" />-->
                                            <input type="submit" name="Submit" value="Cancelar Comprobantes" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_com_cancelar.php'; document.form1.submit()" /> 
                                            <? if($usr->getId()==1) { ?>
                                            <input type="submit" name="Submit" value="Activar Comprobantes" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_com_activar.php'; document.form1.submit()" /> 
                                            <? } ?>
                                            <input type="submit" name="ivacompras" value="IVA Compras" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_com_iva_compras.php'; document.form1.submit()" />
                                            <input type="submit" name="ivacomprasexl" value="IVA Compras Exl" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_com_iva_compras_exl.php'; document.form1.submit()" />
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Proveedor <select name="proveedorcom" id="proveedorcom" onchange="javascript: document.form1.limcom.value=0; document.form1.target='_self'; document.form1.action='register_com.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                $sup->cargaCombo3($ssql, $proveedorcom, "Todos");
                                                ?>
                                            </select> | 
                                            Mov.Contables <input name="movimientocom" id="movimientocom" type="checkbox" <? if($movimientocom==1) echo "checked='checked'";?> value="1" onclick="javascript: document.form1.target='_self'; document.form1.action='register_com.php'; document.form1.submit()" /> | 
                                            Total <strong><?= number_format($totalcom,2)?></strong> / <strong><?= number_format($tneto,2)?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Neto: <strong><?= number_format($tneto21+$tneto10+$tneto27,2)?></strong> | 
                                            IVA: <strong><?= number_format($tiva21+$tiva10+$tiva27,2)?></strong> | 
                                            No Gravado: <strong><?= number_format($tnogravado,2)?></strong> | 
                                            Exento: <strong><?= number_format($texento,2)?></strong> | 
                                            Impuestos: <strong><?= number_format($timp,2)?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all">Cantidad: <span class="letra6bold"><?= $cantidadtotal?></span> - Pag: <span class="lnk"><?= $cadenapaginas?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="7%">
                                                        <?if($usr->getNivel()<=1) { ?>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.action='adm_com_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Compras" title="Agregar Compras"></i></a> 
                                                        <a href="javascript: marcar_desmarcar('chkpag', <?= count($a_id)?>)"><i class="far fa-check-circle fa-lg"></i></a>
                                                        <? } ?>
                                                    </td>
                                                    <td width="5%" align="center">#</td>
                                                    <td width="8%" align="center">Fecha</td>
                                                    <td width="4%" align="center">As.</td>
                                                    <td width="15%" align="left">Número</td>
                                                    <td align="left">Proveedor</td>
                                                    <td width="8%" align="right">Neto</td>
                                                    <td width="8%" align="right">Impuestos</td>
                                                    <td width="8%" align="right">Perc. Ret.</td>
                                                    <td width="8%" align="right">Total</td>
                                                    <td width="8%" align="center">F.Imput.</td>
                                                    <td width="2%" align="center">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { 
                                                    if($a_com[$i]==2)
                                                        $calor=-1;
                                                    else
                                                        $calor=1;
                                                    $tot=$a_neto21[$i] + $a_neto10[$i] + $a_neto27[$i] + $a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i];
//                                                    echo $tot." ".$a_pag[$i]."<br>";
                                                    $ccolor="";
                                                    if(number_format($a_pag[$i],2,".","")==number_format($tot,2,".","") and $usr->getId()==1)
                                                        $ccolor="style='color: blue'";
                                                    ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" <?= $ccolor?>>
                                                    <td>
                                                        <?if($usr->getNivel()<=1 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_com_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Compra" title="Modifica Compra"></i></a> 
                                                        <? } ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.action='adm_com_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Compra" title="Detalle Compra"></i></a> 
                                                        <? if(number_format($a_pag[$i],2,".","")!=number_format($tot,2,".","") or $usr->getId()==1) { ?>
                                                        <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" /> 
                                                        <? }  else { ?>
                                                        <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="hidden" value="0" />
                                                        <? } ?>
                                                    </td>
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                    <td align="center"><?= $a_nasi[$i]?></td>
                                                    <td align="left">
                                                        <? if($a_mov[$i]==0)
                                                            echo "*";
                                                        echo $a_comx[$i];
                                                        ?>
                                                    </td>
                                                    <td align="left"><?= $a_prv[$i]?></td>
                                                    <td align="right"><?= number_format(($a_neto21[$i]+$a_neto10[$i]+$a_neto27[$i]+$a_exe[$i]+$a_ngr[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format(($a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format(($a_pri[$i] + $a_rti[$i] + $a_prb[$i])*$calor,2)?></td>
                                                    <td align="right"><?= number_format(($a_neto21[$i] + $a_neto10[$i] + $a_neto27[$i] + $a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i])*$calor,2)?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fev[$i])?></td>
                                                    <td align="center">
                                                        <?if($usr->getNivel()<=1 and $a_close[$i]==0) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Compras?','adm_com_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Compra" title="Elimina Compra"></i></a>
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <? if($movimientocom) { ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="panel700 letra6">
                                                            <div id="effect-panel700" class="ui-widget-content ui-corner-all">
                                                                <table width="100%" border="0">
                                                                    <tr class="letra5bold">
                                                                        <td width="60%">Cuenta</td>
                                                                        <td width="30%" align="right">Debe</td>
                                                                        <td width="30%" align="right">Haber</td>
                                                                    </tr>
                                                                    <? 
                                                                    $x1sal=number_format(array_sum($d_sal[$i]),2,".","");
                                                                    $x1ent=number_format(array_sum($d_ent[$i]),2,".","");
                                                                    $x2sal=number_format(array_sum($m_sal[$i]),2,".","");
                                                                    $x2ent=number_format(array_sum($m_ent[$i]),2,".","");
//                                                                    $x1sal= intval($x1sal*100);
//                                                                    $x2sal=intval($x2sal*100);
//                                                                    $x1ent=intval($x1ent*100);
//                                                                    $x2ent=intval($x2ent*100);
//                                                                    print_r($d_sal[$i]);
//                                                                    print_r($m_sal[$i]);
//                                                                    echo "x1ent: $x1ent | x2ent: $x2ent || x1sal: $x1sal | x2sal: $x2sal<br>";
                                                                    $errormov=0;
//                                                                    if(count($d_ent)==0)
//                                                                        $errormov=1;
//                                                                    if(count($d_sal)==0)
//                                                                        $errormov=1;
                                                                    if($errormov==0) {
                                                                        if((float)$x1ent!=(float)$x2ent) {
                                                                            $errormov=1;
                                                                            //echo "e: ".(float)$x1ent." | ".(float)$x2ent."<br>";
                                                                        }
                                                                    }
                                                                    if($errormov==0) {
                                                                        if($x1sal!=$x2sal) {
                                                                            $errormov=1;
                                                                            //echo "s: ".(float)$x1sal." | ".(float)$x2sal."<br>";
                                                                        }
                                                                            
                                                                    }
                                                                    //$errormov=0;
                                                                    if($errormov==0) {
                                                                        for($m=0;$m<count($d_cta[$i]);$m++) { ?>
                                                                        <tr class="letra5" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                            <td><?= $d_cta[$i][$m]?></td>
                                                                            <td align="right"><?= $d_ent[$i][$m]?></td>
                                                                            <td align="right"><?= $d_sal[$i][$m]?></td>
                                                                        </tr>
                                                                        <? }
                                                                    } else { 
                                                                        for($m=0;$m<count($m_cta[$i]);$m++) { ?>
                                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                            <td class="letra5rojo"><?= $m_cta[$i][$m]?></td>
                                                                            <td class="letra5rojo" align="right"><?= number_format($m_ent[$i][$m],2)?></td>
                                                                            <td class="letra5rojo" align="right"><?= number_format($m_sal[$i][$m],2)?></td>
                                                                        </tr>
                                                                    <? } } ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <? } 
                                                if($movimientocom) { ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <hr></hr>
                                                    </td>
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
        <td colspan="2">&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>


