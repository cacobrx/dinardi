<?php

#----------------------------------------
# Autor: gus
# Fecha: 23/03/2015 18:36:56
# Archivo: adm_crec_fis_prn.php
#----------------------------------------
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_cped.php';
require_once 'clases/adm_cped_det.php';
require_once 'clases/adm_cli.php';
require_once 'clases/support.php';
require_once 'clases/adm_rec_pag.php';
require_once 'clases/adm_cped_det.php';
$conx=new conexion();
$glo=new globalson();
$sup=new support();
$clavemd5=$sup->generateKey();
$lim=$glo->getGETPOST("lim");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$clienteselcta=$glo->getGETPOST("clienteselcta");
$verdetalle=$glo->getGETPOST("verdetalle");
$ptovta=$glo->getGETPOST("ptovta");
$urlmain=$glo->getGETPOST("urlmain");
$idrec=$glo->getGETPOST("idrec");
$cli=new adm_cli_1($clienteselcta);
$ssql="insert into adm_fis (fecha) values ('".date("Y-m-d")."')";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$idfis=$conx->getLastId("adm_fis");
$urlvolver=$_SERVER["HTTP_REFERER"];
if($cli->getCondicioniva()==3)
    $letra="A";
else
    $letra="B";
$ssql="select * from adm_rec_pag where idrec=$idrec order by id";
//echo $ssql."<br>";
$rec=new adm_rec_pag_2($ssql);
$x_idcped=$rec->getIdcped();
$x_imp=$rec->getImporte();
$x_anomes=$rec->getAnomes();
$x_det=$rec->getDetalle();
$netori21=0;
$netocf21=0;
$netori10=0;
$netocf10=0;
$ivari21=0;
$ivacf21=0;
$ivari10=0;
$ivacf10=0;
for($i=0;$i<count($x_imp);$i++) {
    if($x_idcped[$i]>0) {
        $ssql="select * from adm_cped_det where idped=".$x_idcped[$i];
        $pdet=new adm_cped_det_2($ssql);
        $d_iva=$pdet->getIva();
        $d_can=$pdet->getCantidad();
        $d_art=$pdet->getArticulo();
        $d_pre=$pdet->getPrecio();
        for($d=0;$d<count($d_art);$d++) {
            $imp=$d_pre[$d]*$d_can[$d];
            $coef=1+($d_iva[$d]/100);
            $aux=$imp/$coef;
            if($cli->getCondicioniva()==3) {
                $netori21+=$aux;
                $ivari21+=$imp-$aux;
            } else {
                $netocf21+=$aux;
                $ivacf21+=$imp-$aux;
            }
            $ssql="insert into adm_fis_det (centro, cantidad, detalle, precio, alicuota, importe, idfis, idcli, anomes) values (";
            $ssql.="$centrosel, ".$d_can[$d].", '".$d_art[$i]."', ".$d_pre[$d].", ".$d_iva[$d].", $imp, $idfis, $clienteselcta, ".$x_anomes[$i].")";
            $conx->getConsulta($ssql);
            //echo $ssql."<br>";
        }
    } else {
        $imp=$x_imp[$i];
        $aux=$imp/1.21;
        if($cli->getCondicioniva()==3) {
            $netori21+=$aux;
            $ivari21+=$imp-$aux;
        } else {
            $netocf21+=$aux;
            $ivacf21+=$imp-$aux;
        }
        if(substr($x_det[$i],0,15)=="Abono + Recargo") {
            $ddet="Abono - Servicio Adicional";
        } else {
            $ddet="Abono";
        }
                
        $ssql="insert into adm_fis_det (centro, cantidad, detalle, precio, alicuota, importe, idfis, idcli, anomes) values (";
        $ssql.="$centrosel, 1, '$ddet ".substr($x_anomes[$i],4,2)."/".substr($x_anomes[$i],0,4)."', $imp, 21, $imp, $idfis, $clienteselcta, ".$x_anomes[$i].")";
        $conx->getConsulta($ssql);
        //echo $ssql."<br>";
    }
}
$netocf21=number_format($netocf21,2,".","");
$netori21=number_format($netori21,2,".","");
$ivacf21=number_format($ivacf21,2,".","");
$ivari21=number_format($ivari21,2,".","");
$netocf10=number_format($netocf10,2,".","");
$netori10=number_format($netori10,2,".","");
$ivacf10=number_format($ivacf10,2,".","");
$ivari10=number_format($ivari10,2,".","");
$ssql="update adm_fis set idcli=$clienteselcta, tipo='F', ptovta=$ptovta, total=".array_sum($x_imp).", letra='$letra', ";
$ssql.="netori21=$netori21, netocf21=$netocf21, ivari21=$ivari21, ivari10=$ivari10, ivacf21=$ivacf21, ivacf10=$ivacf10, anomes=".date("Ym");
$ssql.=" where id=$idfis";
$conx->getConsulta($ssql);
//echo $ssql."<br>";
?>
<html>
    <form name="form1" id="form1" action="<?= $urlvolver?>" method="post">
        <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
        <input name="fechaini" id="fechaini" type="hidden" value="<?= $fechaini?>" />
        <input name="fechafin" id="fechafin" type="hidden" value="<?= $fechafin?>" />
        <input name="clientesel" id="clientesel" type="hidden" value="<?= $clientesel?>" />
        <input name="verdetalle" id="verdetalle" type="hidden" value="<?= $verdetalle?>" />
        <input name="tipopedsel" id="tipopedsel" type="hidden" value="<?= $tipopedsel?>" />
        <input name="clienteselcta" id="clienteselcta" type="hidden" value="<?= $clienteselcta?>" />
    </form>
    <script language="javascript">
        alert("Se envia la orden para imprimir el comprobante en la terminal <?= substr("0000",0, 4 - strlen($ptovta)).$ptovta?>");
        document.form1.submit()
    </script>
        
</html>


