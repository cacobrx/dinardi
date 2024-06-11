<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_rem_exp_act.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="")
    $cantidaddet=0;
if($tarea=="A") {
    $carteltarea="Agrega Remito de Expotación";
    $botoncap="Agregar!";
    $fecha= date("Y-m-d");
    $ptovta=0;
    $numero=0;
    $exportador="";
    $buque="";
    $destino="";
    $remitente="";
    $nro="";
    $precinto="";
    $procedencia="";
    $giro="";
    $contenedor="";
    $agenciapre="";
    $transportista="";
    $balanza="";
    $cuit="";
    $certificado="";
    $serie="";
    $fiscal="";
    $nro2="";
    $patenteca="";
} else {
    $carteltarea="Modifica Remito de Expotación";
    require_once 'clases/adm_rem_exp.php';
    $botoncap="Modificar!";
    $adm=new adm_rem_exp_1($id);
    $id=$adm->getId();
    $ptovta=$adm->getPtovta();
    $numero=$adm->getNumero();
    $fecha=$adm->getFecha();
    $exportador=$adm->getExportador();
    $buque=$adm->getBuque();
    $destino=$adm->getDestino();
    $remitente=$adm->getRemitente();
    $nro=$adm->getNro();
    $precinto=$adm->getPrecinto();
    $procedencia=$adm->getProcedencia();
    $giro=$adm->getGiro();
    $contenedor=$adm->getContenedor();
    $agenciapre=$adm->getAgenciapre();
    $transportista=$adm->getTransportista();
    $balanza=$adm->getBalanza();
    $cuit=$adm->getCuit();
    $certificado=$adm->getCertificado();
    $serie=$adm->getSerie();
    $fiscal=$adm->getFiscal();
    $nro2=$adm->getNro2();
    $patenteca=$adm->getPatenteca();
    $ssql="select * from adm_rem_exp_det where idrem=$id order by id";
    $det=new adm_rem_exp_det_2($ssql);   
    $d_can=$det->getCantidad();
    $d_des=$det->getDescripcion();
    $d_kgsb=$det->getKgsbrutos();
    $d_kgsn=$det->getKgsnetos();
    $cantidaddet=count($d_can); 
}
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
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.1.19"></script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_rem_exp_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="10"><a href="javascript: document.form1.action='adm_rem_exp_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>   
                                    <tr>
                                        <td align="left">Fecha&nbsp;</td>
                                        <td><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                        <td>Pto.Venta / Número&nbsp;</td>
                                        <td><input name="ptovta" id="ptovta" type="text" size="4" maxlength="4" value="<?= $ptovta?>" style="text-align: center"/> / 
                                        <input name="numero" id="numero" type="text" size="4" maxlength="4" value="<?= $numero?>" style="text-align: center"/></td>
                                   </tr>
                                    <tr>
                                        <td width="10%" align="left">Exportador&nbsp;</td>
                                        <td width="40%"><input name="exportador" type="text" class="letra6" id="exportador" size="30" maxlength="30" value="<?= $exportador?>" /></td>                                                                       
                                        <td align="left">Empresa Transportista&nbsp;</td>
                                        <td><input name="transportista" type="text" class="letra6" id="transportista" size="30" maxlength="30" value="<?= $transportista?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Buque&nbsp;</td>
                                        <td><input name="buque" type="text" class="letra6" id="buque" size="30" maxlength="30" value="<?= $buque?>" /></td>                                    
                                        <td align="left">Cuit&nbsp;</td>
                                        <td><input name="cuit" type="text" class="letra6" id="cuit" size="11" maxlength="11" value="<?= $cuit?>" onkeypress="return validar_punto(event)"/></td>                                  
                                    </tr>
                                    <tr>
                                        <td align="left">Destino&nbsp;</td>
                                        <td><input name="destino" type="text" class="letra6" id="destino" size="30" maxlength="30" value="<?= $destino?>" /></td>                                        
                                        <td align="left">Balanza&nbsp;</td>
                                        <td><input name="balanza" type="text" class="letra6" id="balanza" size="30" maxlength="30" value="<?= $balanza?>" /></td>                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Remitente&nbsp;</td>
                                        <td><input name="remitente" type="text" class="letra6" id="remitente" size="30" maxlength="30" value="<?= $remitente?>" /></td>                                        
                                        <td align="left">Certificado&nbsp;</td>
                                        <td><input name="certificado" type="text" class="letra6" id="certificado" size="30" maxlength="30" value="<?= $certificado?>" /></td>                                                              
                                    </tr>
                                    <tr>
                                        <td align="left">P.E Nro&nbsp;</td>
                                        <td><input name="nro" type="text" class="letra6" id="nro" size="30" maxlength="30" value="<?= $nro?>" /></td>
                                        <td align="left">Serie&nbsp;</td>
                                        <td><input name="serie" type="text" class="letra6" id="serie" size="30" maxlength="30" value="<?= $serie?>" /></td>                                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Precinto Nro&nbsp;</td>
                                        <td><input name="precinto" type="text" class="letra6" id="precinto" size="30" maxlength="30" value="<?= $precinto?>" /></td>                                      
                                        <td align="left">Nro°&nbsp;</td>
                                        <td><input name="nro2" type="text" class="letra6" id="nro2" size="30" maxlength="30" value="<?= $nro2?>" /></td>                                                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Procedencia&nbsp;</td>
                                        <td><input name="procedencia" type="text" class="letra6" id="procedencia" size="30" maxlength="30" value="<?= $procedencia?>" /></td>                               
                                        <td align="left">Fiscal&nbsp;</td>
                                        <td><input name="fiscal" type="text" class="letra6" id="fisacal" size="30" maxlength="30" value="<?= $fiscal?>" /></td>                                                               
                                    </tr>
                                    <tr>
                                        <td align="left">Giro&nbsp;</td>
                                        <td><input name="giro" type="text" class="letra6" id="giro" size="30" maxlength="30" value="<?= $giro?>" /></td>                                        
                                        <td align="left">Patente Camion&nbsp;</td>
                                        <td><input name="patenteca" type="text" class="letra6" id="patenteca" size="30" maxlength="30" value="<?= $patenteca?>" /></td>                                   
                                    </tr>                                    
                                    <tr>
                                        <td align="left">Contenedor Nro&nbsp;</td>
                                        <td><input name="contenedor" type="text" class="letra6" id="contenedor" size="30" maxlength="30" value="<?= $contenedor?>" /></td>
                                        <td align="left">Precinto Agencia Nro&nbsp;</td>
                                        <td><input name="agenciapre" type="text" class="letra6" id="agenciapre" size="30" maxlength="30" value="<?= $agenciapre?>" /></td>
                                    </tr>                                                                                                     
                                    <tr>
                                        <td colspan="10"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <div class="panelmax710 letra6">
                                                <div id="effect-panelmax710" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr class="letra6bold">                                                           
                                                            <td width="8%">Cantidad</td>
                                                            <td align="left">Descripción</td>
                                                            <td width="10%">Kgs Brutos</td>
                                                            <td width="10%">Kgs Netos</td>
                                                            <td width="5%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-square"></span></button></td>
                                                        </tr>
                                                        <? for($i=0;$i<count($d_can);$i++) { ?>
                                                        <tr>                                                                
                                                            <td><input type="text" id="item_cantidad<?= $i?>" name="item_cantidad<?= $i?>" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center"  value="<?= $d_can[$i]?>" /></td>
                                                            <td><input type="text" id="item_descripcion<?= $i?>" name="item_descripcion<?= $i?>" size="50" maxlength="50"  value="<?= $d_des[$i]?>" /></td>
                                                            <td><input type="text" id="item_kgsb<?= $i?>" name="item_kgsb<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center"  value="<?= $d_kgsb[$i]?>" /></td>
                                                            <td><input type="text" id="item_kgsn<?= $i?>" name="item_kgsn<?= $i?>" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center"  value="<?= $d_kgsn[$i]?>" /></td>
                                                            <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10"><hr></hr></td>
                                    </tr>                                    
                                    <tr>
                                        <td colspan="10" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
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
<script>
$(document).ready(function(){
 
 $(document).on('click', '.add', function(){
  var html = '';
  document.getElementById("cantidaddet").value=parseInt(document.getElementById("cantidaddet").value) +1;
  cantidaddet=document.getElementById("cantidaddet").value;
  html += '<tr>';
  html += '<td><input type="text" id="item_cantidad' + cantidaddet + '" name="item_cantidad' + cantidaddet + '" size="6" maxlength="6" onkeypress="return validar_punto(event)" style="text-align: center"/></td>';
  html += '<td><input type="text" id="item_descripcion' + cantidaddet + '" name="item_descripcion' + cantidaddet + '" size="50" maxlength="50" /></td>';
  html += '<td><input type="text" id="item_kgsb' + cantidaddet + '" name="item_kgsb' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center"/></td>';
  html += '<td><input type="text" id="item_kgsn' + cantidaddet + '" name="item_kgsn' + cantidaddet + '" size="10" maxlength="10" onkeypress="return validar_punto(event)" style="text-align: center"/></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-square"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  document.form1.cantidaddet.value=parseInt(document.form1.cantidaddet.value) -1;
  $(this).closest('tr').remove();
  tot_pedido();
 });
});
</script>
