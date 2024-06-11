<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$iva21=$glo->getGETPOST("iva21");
$iva10=$glo->getGETPOST("iva10");
$iva27=$glo->getGETPOST("iva27");
$periva=$glo->getGETPOST("periva");
$retiva=$glo->getGETPOST("retiva");
$impinternos=$glo->getGETPOST("impinternos");
$perretiibb=$glo->getGETPOST("perretiibb");
$proveedor=$glo->getGETPOST("proveedor");
if($iva21=="")
    $iva21=0;
if($iva10=="")
    $iva10=0;
if($iva27=="")
    $iva27=0;
if($periva=="")
    $periva=0;
if($retiva=="")
    $retiva=0;
if($impinternos=="")
    $impinternos=0;
if($perretiibb=="")
    $perretiibb=0;
if($proveedor=="")
    $proveedor=0;
$ssql="select * from adm_com_cta where centro=$centrosel";
if($conx->getCantidadReg($ssql)>0) {
    $ssql="update adm_com_cta set iva21=$iva21, iva10=$iva10, iva27=$iva27, periva=$periva, retiva=$retiva, perretiibb=$perretiibb, impinternos=$impinternos, proveedor=$proveedor where centro=$centrosel";
    $descripcion="Modifica cuentas de compras centro: $centrosel";
} else {
    $ssql="insert into adm_com_cta (centro, iva21, iva10, iva27, periva, retiva, perretiibb, impinternos, proveedor) values ($centrosel, $iva21, $iva10, $iva27, $periva, $retiva, $perretiibb, $impinternos, $proveedor)";
    $descripcion="Agrega cuentas de compras centro: $centrosel";
}
$conx->getConsulta($ssql);
$aud->regAud("Compras Cuentas", $idusr, $descripcion, $centrosel);
//echo $ssql."<br>";
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_prv_index.php" method="post">
            
        </form>
        <script language="javascript">
        document.form1.submit();
        </script>
    </body>
</html>
