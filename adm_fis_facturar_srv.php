<?php
/*
 * Creado el 07/03/2019 19:16:39
 * Autor: gus
 * Archivo: adm_fis_facturar_srv.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_fis.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
$aud = new registra_auditoria();
$cfg=new planb_config_1($centrosel);
$conx = new conexion();
$glo = new globalson();
$id=$glo->getGETPOST("id");
$fis=new adm_fis_1($id);
$cli=new adm_cli_1($fis->getIdcli());
$s_cliente=array();
array_push($s_cliente,$cli->getId());
array_push($s_cliente,$cli->getApellido()." ".$cli->getNombre());
array_push($s_cliente,$cli->getCuit());
array_push($s_cliente,$cli->getCondicioniva());
array_push($s_cliente,$cli->getDireccion()." ".$cli->getCiudaddes()); 
if($fis->getPtovta()==$cfg->getFiscalpuntoventa()) $urlafip="adm_fis_facturar_afip.php";
if($fis->getPtovta()==$cfg->getFiscalpuntoventafce()) $urlafip="adm_fis_facturar_fce_afip.php";
$fechafactura2=$fis->getFecha();
if($fis->getDocreferencia()>0) {
    $ssql="select * from adm_fis where numero=".$fis->getDocreferencia()." and ptovta=".$fis->getPtovta();
    $ff=$conx->getConsulta($ssql);
    $fff=mysqli_fetch_object($ff);
    $fechafactura2=$fff->fecha;
}
//echo $cfg->getServidorafip()."<br>";

?>
<html>
    <body>
        <form name="form1" id="form1" action="<?= $cfg->getServidorafip().'/'.$urlafip?>" method="post">
            <input name="s_cuit" id="s_cuit" type="hidden" value="<?= $cfg->getFiscalcuit()?>" />
            <input name="s_ptovta" id="s_ptovta" type="hidden" value="<?= $fis->getPtovta()?>" />
            <input name="s_fecha" id="s_fecha" type="hidden" value="<?= $fis->getFecha()?>" />
            <input name="s_fechapago" id="s_fechapago" type="hidden" value="<?= $fis->getFechapago()?>" />
            <input name="s_fechadesde" id="s_fechadesde" type="hidden" value="<?= $fis->getFechaperini()?>" />
            <input name="s_fechahasta" id="s_fechahasta" type="hidden" value="<?= $fis->getFechaperfin()?>" />
            <input name="s_codigocomp" id="s_codigocomp" type="hidden" value="<?= $fis->getCodigocomp()?>" />
            <input name="s_neto21" id="s_neto21" type="hidden" value="<?= $fis->getNetocf21()+$fis->getNetori21()?>" />
            <input name="s_neto10" id="s_neto10" type="hidden" value="<?= $fis->getNetocf10()+$fis->getNetori10()?>" />
            <input name="s_iva21" id="s_iva21" type="hidden" value="<?= $fis->getIvacf21()+$fis->getIvari21()?>" />
            <input name="s_iva10" id="s_iva10" type="hidden" value="<?= $fis->getIvacf10()+$fis->getIvari10()?>" />
            <input name="s_nogravado" id="s_nogravado" type="hidden" value="<?= $fis->getNogravado()?>" />
            <!--<input name="s_totaltotal" id="s_totaltotal" type="hidden" value="<?= $fis->getIvacf21()+$fis->getIvari21()+$fis->getIvacf21()+$fis->getIvari21()?>" />-->
            <input name="s_docreferencia" id="s_docreferencia" type="hidden" value="<?= $fis->getDocreferencia()?>" />
            <input name="s_fechafactura2" id="s_fechafactura2" type="hidden" value="<?= $fechafactura2?>" />
            <!--<input name="s_urlvolver" id="s_urlvolver" type="hidden" value="http://gus/fps/adm_fis_facturar_fin.php" />-->
            <? if($usr_safip==0) { ?>
            <input name="s_urlvolver" id="s_urlvolver" type="hidden" value="http://192.168.0.220/sistema/adm_fis_facturar_fin.php" />
            <? } else { ?>
            <input name="s_urlvolver" id="s_urlvolver" type="hidden" value="http://190.184.228.20/sistema/adm_fis_facturar_fin.php" />
            <? } ?>
            <input name="s_cliente" id="s_cliente" type="hidden" value='<?= serialize($s_cliente)?>' />
            <input name="s_tipodes" id="s_tipodes" type="hidden" value="<?= $fis->getTipodes()?>" />
            <input name="s_letra" id="s_letra" type="hidden" value="<?= $fis->getLetra()?>" />
            <input name="s_idfis" if="s_idfis" type="hidden" value="<?= $id?>" />
            <input name="s_percepcioniibb" id="s_percepcioniibb" type="hidden" value="<?= $fis->getPercepcioniibb()?>" />
            <input name="s_porcentajeiibb" id="s_porcentajeiibb" type="hidden" value="<?= $fis->getPorcentajeiibb()?>" />
            <input name="s_condicioniva" id="s_condicioniva" type="hidden" value="<?= $fis->getCondicioniva()?>" />
            <input name="s_cbu" id="s_cbu" type="hidden" value="<?= $cfg->getCbu()?>" />
            <input name="s_alias" id="s_alias" type="hidden" value="<?= $cfg->getAliascbu()?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

