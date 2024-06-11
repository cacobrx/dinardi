<?
//print_r($_POST);
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_che.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
  $carteltarea="Agrega Cheque";
  $botoncap="Agregar!";
  $fechaorigen=date("Y-m-d");
  $fechapago=date("Y-m-d");
  $idbanco='';
  $nrocheque='';
  $destinatario="";
  $acreditado="";
  $referencia='';
  $importe='';
  $fechadeb=date("Y-m-d");
  $entregado=0;
} else {
  $carteltarea="Modifica Cheque";
  $botoncap="Modificar!";
  $che=new adm_che_1($id);
  $fechaorigen=$che->getFechaorigen();
  $idbanco=$che->getIdbanco();
  $nrocheque=$che->getNrocheque();
  $fechapago=$che->getFechapago();
  $referencia=$che->getReferencia();
  $destinatario=$che->getDestinatario();
  $importe=$che->getImporte();
  $acreditado=$che->getAcreditado();
  $entregado=$che->getEntregado();
  $fechadeb=$che->getFechadeb();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	width:980px;
	height:75px;
	z-index:1;
	margin-left: -480px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	destinatario: ['required', 'only_on_submit'],
        importe: ['required', 'only_on_submit'],
        fechapago: ['required', 'only_on_submit']
}
</script>

<?require_once 'estilos.php';?>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_che_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>              
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_che_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Fecha Origen&nbsp;</td>
                                        <td width="65%"><input name="fechaorigen" type="date" class="letra6" id="fechaorigen" value="<?= $fechaorigen?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Vencimiento&nbsp;</td>
                                        <td><input name="fechapago" type="date" class="letra6" id="fechapago" value="<?= $fechapago?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha Debitado&nbsp;</td>
                                        <td><input name="fechadeb" type="date" class="letra6" id="fechadeb" value="<?= $fechadeb?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Banco&nbsp;</td>
                                        <td>
                                            <select name="idbanco" id="idbanco">
                                                <?
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='BAN' order by descripcion";
                                                $sup->cargaCombo3($ssql, $idbanco, "Sel.")
                                                ?>
                                            </select>                      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Nro Cheque&nbsp;</td>
                                        <td><input name="nrocheque" type="text" class="letra6" id="nrocheque" size="20" maxlength="20" value="<?= $nrocheque?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Destinatario&nbsp</td>
                                        <td><input name="destinatario" type="text" class="letra6" id="destinatario" size="50" maxlength="50" value="<?= $destinatario?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Referencias&nbsp;</td>
                                        <td><input name="referencia" type="text" class="letra6" id="referencia" size="50" maxlength="50" value="<?= $referencia?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Importe&nbsp;</td>
                                        <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" value="<?= $importe?>" style="text-align: center" onkeypress="return validar_punto(event)" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Entregado&nbsp;</td>
                                        <td>
                                            <input name="entregado" id="entregado" type="checkbox" value="1" <? if($entregado==1) echo "checked='checked'";?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Acreditado&nbsp;</td>
                                        <td>
                                            <input name="acreditado" id="acreditado" type="checkbox" value="1" <? if($acreditado==1) echo "checked='checked'";?> />
                                        </td>
                                    </tr>    
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
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
