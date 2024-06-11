<?
/*
 * Creado el 14/05/2014 14:52:58
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_fis.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_fis_det.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$conx=new conexion();
$xlimmax=$cfg->getLimmax ();
$condicion="adm_fis.fecha>='$fechainifis' and adm_fis.fecha<='$fechafinfis' and ";
if($clientefis>0)
    $condicion.="adm_fis.idcli=$clientefis and ";
if($numerofis>0)
    $condicion.="adm_fis.numero=$numerofis and ";
if($ptoventafis>0)
    $condicion.="adm_fis.ptovta=$ptoventafis and ";
if($letrafis!="")
    $condicion.="adm_fis.letra='$letrafis' and ";
if($tipocomfis!="")
    $condicion.="adm_fis.tipo='$tipocomfis' and ";
//if($clientefis!="") 
//    $condicion.="instr(upper(cliente), '".strtoupper($clientefis)."')>0 and ";
if($clientefis!="") {
    $partes=explode(" ", $clientefis);
    $datonombre="%";
    for($i=0;$i<count($partes);$i++) {
        $ntex=strlen($partes[$i]);
        $datonombre.=$partes[$i]."%";
    }
    $condicion.="concat_ws(' ', adm_cli.apellido, adm_cli.nombre) like '".strtoupper($datonombre)."' and ";
}

if($condicion!="")
    $condicion=" where ".substr($condicion,0,strlen($condicion)-5);


//echo $ssqt;
switch ($ordenfis) {
    case 0:
        $ordenorden="adm_fis.tipo, adm_fis.letra, adm_fis.ptovta, adm_fis.numero, adm_fis.fecha, adm_fis.id";
        break;
    case 1:
        $ordenorden="adm_fis.id";
        break;
}
$ssql="select sum(adm_fis_det.cantidad * adm_fis_det.precio) as totalfac from adm_fis_det, adm_fis, adm_cli $condicion and (adm_fis.tipo='F' or adm_fis.tipo='D') and adm_fis.id = adm_fis_det.idfis and adm_fis.idcli=adm_cli.id";
$ssql="select sum(adm_fis.total) as totalfac from adm_fis, adm_cli $condicion and (adm_fis.tipo='F' or adm_fis.tipo='D' or adm_fis.tipo='G' or adm_fis.tipo='H') and adm_cli.id=adm_fis.idcli";
$rf=$conx->getConsulta($ssql);
$rff=mysqli_fetch_object($rf);
//echo $ssql;
//$ssql="select sum(adm_fis.total) as totalcre from adm_fis $condicion and (adm_fis.tipo='C' or adm_fis.tipo='I')";
$ssql="select sum(adm_fis.total) as totalcre from adm_fis, adm_cli $condicion and (adm_fis.tipo='C' or adm_fis.tipo='I') and adm_cli.id=adm_fis.idcli";
//$ssql="select sum(adm_fis.total) as totalcre from adm_fis_det, adm_fis, adm_cli $condicion and adm_fis.tipo='C' and adm_fis.id = adm_fis_det.idfis and adm_fis.idcli=adm_cli.id";
$rc=$conx->getConsulta($ssql);
$rcc=mysqli_fetch_object($rc);
//echo $rff->totalfac." ".$rcc->totalcre."<br>";
$totaltotal=$rff->totalfac-$rcc->totalcre;
$ssql="select adm_fis.* from adm_fis, adm_cli $condicion and adm_fis.idcli=adm_cli.id order by $ordenorden";

$ssql.=" limit $limfis,$xlimmax";
$adm=new adm_fis_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_fec=$adm->getFecha();
$a_civa=$adm->getCondicionivades();
$a_tot=$adm->getTotal();
$a_per=$adm->getPercepcioniibb();
$a_pag=$adm->getImportepago();
$a_com=$adm->getTipo();
$a_comd=$adm->getTipodes();
$a_let=$adm->getLetra();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
$a_ttt=$adm->getTipopagodes();
$a_cae=$adm->getNumerocae();
$a_fee=$adm->getFechacae();

$d_id=$adm->getDet_id();
$d_det=$adm->getDet_descripcion();
$d_art=$adm->getDet_articulo();
$d_can=$adm->getDet_cantidad();
$d_iva=$adm->getDet_iva();
$d_pre=$adm->getDet_precio();
$d_imp=$adm->getDet_importe();

$a_email=$adm->getEmail();
$a_close=$adm->getCerrado();

$cantidadtotal=$adm->getMaxRegistros();

$paginas=(int)($cantidadtotal / $xlimmax);    
if ($paginas==$cantidadtotal/$xlimmax) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$xlimmax;
  $j=$i+1;
  if($ini!=$limfis)
    $cadenapaginas.=" <a href='javascript: document.form1.limfis.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_fis.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="idm" type="hidden" id="idm" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limfis" type="hidden" id="limfis" value="<?= $limfis?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="2" cellpadding="0" letra6>
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">COMPROBANTES</h3>
                                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                            <tr>
                                                <td>
                                                     Orden <select name="ordenfis" id="ordenfis" onchange="javascript: document.form1.target='_self'; document.form1.limfis.value=0; document.form1.action='register_fis.php'; document.form1.submit()">
                                                         <?
                                                         $array=array("Comp.", "ID");
                                                         $avalor=array(0,1);
                                                         $sup->cargaComboArrayValor($array, $avalor, $ordenfis);
                                                         ?>
                                                     </select> | 
                                                     Numero <input name="numerofis" id="numerofis" class="letra6" type="text" value="<?= $numerofis?>" size="10" maxlength="10" onkeypress="return validar(event)" style="text-align: center" /> | 
                                                     Letra <select name="letrafis" id="letrafis" onchange="javascript: document.form1.target='_self'; document.form1.limfis.value=0; document.form1.action='register_fis.php'; document.form1.submit()">
                                                         <?
                                                         $array=array("A","B","C");
                                                         $sup->cargaComboArrayValor($array, $array, $letrafis, "Todos");
                                                         ?>
                                                     </select> | 
                                                     Tipo <select name="tipocomfis" id="tipocomfis" onchange="javascript: document.form1.target='_self'; document.form1.limfis.value=0; document.form1.action='register_fis.php'; document.form1.submit()">
                                                         <?
                                                            $array=array("Factura","NCredito","NDebito", "Factura CE", "N.Crédito E", "N.Débito E");
                                                            $avalor=array("F","C","D","G", "H", "I");
                                                            $sup->cargaComboArrayValor($array, $avalor, $tipocomfis,"Todos");
                                                         ?>
                                                     </select> | 
                                                     P.Venta <select name="ptoventafis" id="ptoventafis" onchange="javascript: document.form1.target='_self'; document.form1.limfis.value=0; document.form1.action='register_fis.php'; document.form1.submit()">
                                                         <?
                                                         $array=array(4,8);
                                                         $sup->cargaComboArrayValor($array, $array, $ptoventafis);
                                                         ?>
                                                     </select>  
                                                    <input name="cmdciti" id="cmdciti" value="CITI Ventas" type="submit" onclick="javascript: document.form1.action='adm_fis_citi.php'; document.form1.submit()" /> 
                                                    <input name="cmdcitiiva" id="cmdcitiiva" value="CITI Alicuotas" type="submit" onclick="javascript: document.form1.action='adm_fis_citi_iva.php'; document.form1.submit()" /> | 
                                                    <input name="cmdprint" id="cmdprint" value="Imprimir" type="submit" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_fis_lst.php'; document.form1.submit()" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                      Ver Detalle <input name="detallefis" id="detallefis" type="checkbox" value="1" <? if($detallefis==1) echo "checked='checked'";?> onclick="javascript: document.form1.target='_self'; document.form1.action='register_fis.php'; document.form1.submit()" />

                                                    Fecha desde <input name="fechainifis" id="fechainifis" class="letra6" type="date" value="<?= $fechainifis?>" /> 
                                                    hasta <input name="fechafinfis" id="fechafinfis" class="letra6" type="date" value="<?= $fechafinfis?>" /> | 
                                                    <input name="cmdexp" id="cmdexp" value="Exportar Excel" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_exc.php'; document.form1.submit()" />
                                                    <input name="cmdiva" id="cmdiva" value="Imprimir Libro IVA" type="submit" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_fis_iva_prn.php'; document.form1.submit()" />
                                                    <input name="cmdivaexl" id="cmdiva" value="Exportar Libro IVA" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_iva_exl.php'; document.form1.submit()" />
                                                    <input name="numerolistado" id="numerolistado" type="text" size="5" maxlength="10" onkeypress="return validar(event)" style="text-align: center" /> | 

                                                     
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
                                                    <input name="arbaexp" id="arbaexp" type="button" value="Descargar ARBA Percepciones" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_arba_percepciones.php'; document.form1.submit()" />
                                                    <!--<input name="arbazip" id="arbazip" type="button" value="ZIP ARBA Percepciones" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_fis_arba_percepciones_zip.php'; document.form1.submit()" />-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <hr></hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cliente: <input name="clientefis" id="clientefis" value="<?= $clientefis?>" type="text" size="30" maxlength="50" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" /> |                                                 
                                                    TOTAL: <span class="letra6bold"><?= number_format($totaltotal,2)?></span> | 
                                                    <input name="cmdok" id="cmdok" value="Filtrar" type="submit" onclick="javascript: document.form1.target='_self'; document.form1.limfis.value=0; document.form1.action='register_fis.php'; document.form1.submit()" style="background-color: <?= $cfg->getColor1()?>; color: #F0F0F0" /> | 
                                                    Cuerpo Mail <textarea name="cuerpofis" id="cuerpofis" rows="2" cols="40" class="letra6"></textarea>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><span class="letra6bold"><?= $cantidadtotal?></span><span class="letra6"> | Pag: </span></span><span class="lnk"><?= $cadenapaginas?></span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%">
                                                                <?  if($usr->getNivel()<=1) { ?>
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_fis_add.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Comprobante" title="Agregar Comprobante"></i></a> 
                                                                <? } ?>
                                                            </td>
                                                            <td width="4%" align="center">Id</td>
                                                            <td width="4%" align="center">Tp</td>
                                                            <td width="8%" align="center">Fecha</td>
                                                            <td width="30%" align="left">Cliente</td>
                                                            <td width="4%" align="center">CI</td>
                                                            <td width="10%" align="right">Total</td>
                                                            <td width="10%" align="center">Comprobante</td>
                                                            <td width="10%" align="center">CAE</td>
                                                            <td width="8%" align="center">F.CAE</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { 
                                                            switch ($a_com[$i]) {
                                                                case "F":
                                                                    $doc="FC";
                                                                    break;
                                                                case "C":
                                                                    $doc="NC";
                                                                    break;
                                                                case "D":
                                                                    $doc="ND";
                                                                    break;
                                                                case "R":
                                                                    $doc="RC";
                                                                    break;
                                                            }
                                                            ?>
                                                            <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                <td>
                                                                    <? if($usr->getNivel()<=1 and $a_close[$i]==0) { ?>
                                                                    <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_fis_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Comprobante" title="Modifica Comprobante"></i></a> 
                                                                    <? } ?>
                                                                    <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_fis_det_main.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Comprobante" title="Detalle Comprobante"></i></a> 
                                                                    <? if($a_cae[$i]!="") { ?>
                                                                    <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_blank'; document.form1.action='adm_fis_prn.php'; document.form1.submit()"><i class="fas fa-print fa-lg" title="Imprime Comprobante Fiscal" alt="Imprime Comprobante Fiscal"></i></a> 
                                                                    <? if($a_email[$i]!="") { ?>
                                                                    <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_fis_mail.php'; document.form1.submit()"><i class="far fa-envelope fa-lg" title="Envía Factura x Email a <?= $a_email[$i]?>" alt="Envía Factura x Email a <?= $a_email[$i]?>"></i></a>
                                                                    <? } } else { 
                                                                       if($usr->getNivel()<=1 and $a_tot[$i]>0) { ?>
                                                                    <a href="javascript: document.form1.target='_self'; bajareg(<?= $a_id[$i]?>, 'Registra comprobante en Afip?', 'adm_fis_fac_api.php')"><i class="fas fa-file-invoice-dollar fa-lg" alt="Registra Comprobante en Afip" title="Registra Comprobante en Afip"></i></a>
                                                                    <? } }?>
                                                                </td>
                                                                <td align="center"><?= $a_id[$i]?></td>
                                                                <td align="center"><?= $a_ttt[$i]?></td>
                                                                <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>
                                                                <td align="left"><?= $a_cli[$i]?></td>
                                                                <td align="center"><?= $a_civa[$i]?></td>
                                                                <td align="right"><?= number_format($a_tot[$i],2)?></td>
                                                                <td align="center"><?= $a_comd[$i]."-".$a_let[$i]."-".$a_pto[$i]."-",$a_nro[$i]?></td>
                                                                <td align="center"><?= $a_cae[$i]?></td>
                                                                <td align="center"><?= $dsup->getFechaNormalCorta($a_fee[$i])?></td>
                                                                <td align="center">
                                                                    <? if($usr->getNivel()<=1 and $a_close[$i]==0) { ?>
                                                                    <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Comprobante?','adm_fis_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Comprobante" title="Elimina Comprobante"></i></a>
                                                                    <? } ?>
                                                                </td>
                                                            </tr>
                                                            <? if($detallefis==1) { ?>
                                                            <tr>
                                                                <td colspan="13">
                                                                    <table width="100%" border="0" class="letra5" bgcolor="#eeeeee">
                                                                        <tr class="letra5bold">
                                                                            <td width="5%" align="center">ID</td>
                                                                            <td width="65%">Detalle</td>
                                                                            <td width="10%" align="center">Cant.</td>
                                                                            <td width="10%" align="right">Precio</td>
                                                                            <td width="10%" align="right">Importe</td>
                                                                        </tr>
                                                                        <? for($d=0;$d<count($d_id[$i]);$d++) { ?>
                                                                        <tr class="letra5bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                            <td align="center"><?= $d_id[$i][$d]?></td>
                                                                            <td><?= $d_art[$i][$d]." ".$d_det[$i][$d]?></td>
                                                                            <td align="center"><?= $d_can[$i][$d]?></td>
                                                                            <td align="right"><?= number_format($d_pre[$i][$d],2)?></td>
                                                                            <td align="right"><?= number_format($d_imp[$i][$d],2)?></td>
                                                                        </tr>
                                                                        <? } ?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="13">
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