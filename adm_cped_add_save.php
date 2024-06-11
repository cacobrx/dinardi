<?php
/*
 * Creado el 13/03/2019 15:03:56
 * Autor: gus
 * Archivo: adm_cped_add_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx=new conexion();
$aud=new registra_auditoria();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$fecha=$glo->getGETPOST("fecha");
$fechaentrega=$glo->getGETPOST("fechaentrega");
$idcli=$glo->getGETPOST("idcli");
$totaltotal=$glo->getGETPOST("totaltotal");
$observaciones=$glo->getGETPOST("observaciones");
$patente=$glo->getGETPOST("patente");
$conn=$conx->conectarBase();
$ssql="insert into adm_cped (fecha, idcli, observaciones, patente) values ('$fecha', $idcli, '$observaciones', '$patente')";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
$id=$conx->getLastId("adm_cped", $conn);
if($fechaentrega!="") {
    $ssql="update adm_cped set fechaentrega='$fechaentrega' where id=$id";
    $conx->consultaBase($ssql, $conn);
}
$ssql="delete from adm_cped_det where idped=$id";
$conx->consultaBase($ssql, $conn);
$cantidad=100;
for($i=0;$i<=$cantidad;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_recipiente="item_recipiente$i";
    $item_producto="item_producto$i";
    $item_precio="item_precio$i";
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_precio=$glo->getGETPOST($item_precio);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    $$item_recipiente=$glo->getGETPOST($item_recipiente);
    if($$item_recipiente=="") $$item_recipiente=0;
    if($$item_producto>0) {
        if($$item_precio=="") $$item_precio=0;
        $ssql="insert into adm_cped_det (idped, idpro, cantidad, recipiente, precio) values (";
        $ssql.="$id, ".$$item_producto.", ".$$item_cantidad.", ".$$item_recipiente.", ".$$item_precio.")";
        $conx->consultaBase($ssql, $conn);
//        echo $ssql."<br>";
    }
}
$aud->regAudC("PEDIDOS", $usr->getId(), "Agrega nuevo pedido #$id | $fecha | $idcli | $totaltotal", $centrosel, $conn);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cped_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

