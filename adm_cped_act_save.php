<?php
/*
 * Creado el 13/03/2019 21:02:20
 * Autor: gus
 * Archivo: adm_cped_act_save.php
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
$id=$glo->getGETPOST("id");
$fecha=$glo->getGETPOST("fecha");
$fechaentrega=$glo->getGETPOST("fechaentrega");
$idcli=$glo->getGETPOST("idcli");
$totaltotal=$glo->getGETPOST("totaltotal");
$observaciones=$glo->getGETPOST("observaciones");
$patente=$glo->getGETPOST("patente");
$conn=$conx->conectarBase();
$ssql="update adm_cped set fecha='$fecha', idcli=$idcli, observaciones='$observaciones', patente='$patente', fechamod='".date("Y-m-d H:i:s")."' where id=$id";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
if($fechaentrega!="") {
    $ssql="update adm_cped set fechaentrega='$fechaentrega' where id=$id";
    $conx->consultaBase($ssql, $conn);
}
//echo $ssql."<br>";
$ssql="delete from adm_cped_det where idped=$id";
//echo $ssql;
$conx->consultaBase($ssql, $conn);
$cantidad=100;
for($i=0;$i<=$cantidad;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_recipiente="item_recipiente$i";    
    $item_producto="item_producto$i";
    $item_precio="item_precio$i";
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_recipiente=$glo->getGETPOST($item_recipiente);
    $$item_precio=$glo->getGETPOST($item_precio);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    if($$item_producto>0) {
        if($$item_precio=="") $$item_precio=0;
        if($item_cantidad[$i]=="") $item_cantidad[$i]=0;
        if($item_recipiente[$i]=="") $item_recipiente[$i]=0;
        $ssql="insert into adm_cped_det (idped, idpro, cantidad, recipiente, precio) values (";
        $ssql.="$id, ".$$item_producto.", ".$$item_cantidad.", ".$$item_recipiente.", ".$$item_precio.")";
        $conx->consultaBase($ssql, $conn);
//        echo $ssql."<br>";
    }
}
$aud->regAudC("PEDIDOS", $usr->getId(), "Modifica pedido #$id | $fecha | $totaltotal", $centrosel, $conn);
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
