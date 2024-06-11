<?php
/*
 * Creado el 21/01/2019 20:36:06
 * Autor: gus
 * Archivo: adm_rem_act_save.php
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
$idrem=$glo->getGETPOST("idrem");
$horainicio=$glo->getGETPOST("horainicio");
$horafin=$glo->getGETPOST("horafin");
$observaciones=$glo->getGETPOST("observaciones");
$conn=$conx->conectarBase();
$ssql="update adm_crm set fecha='$fecha', idrem=$idrem, horainicio='$horainicio', horafin='$horafin', observaciones='$observaciones' where id=$id";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
$ssql="delete from adm_crm_det where idcrm=$id";
$conx->consultaBase($ssql, $conn);
$cantidad=100;
for($i=0;$i<=$cantidad;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_producto="item_producto$i";
//    $item_peso="item_peso$i";
    $item_temperatura="item_temperatura$i";
    $item_observaciones="item_observaciones$i";
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
//    $$item_peso=$glo->getGETPOST($item_peso);
    $$item_temperatura=$glo->getGETPOST($item_temperatura);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    $$item_observaciones=$glo->getGETPOST($item_observaciones);
    if($$item_producto>0) {
        if($$item_cantidad=="") $$item_cantidad=0;
        if($$item_peso=="") $$item_peso=0;
        if($$item_temperatura=="") $$item_temperatura=0;
        $ssql="insert into adm_crm_det (idcrm, idart, cantidad, temperatura, observaciones) values (";
        $ssql.="$id, ".$$item_producto.", ".$$item_cantidad.", ".$$item_temperatura.", '".$$item_observaciones."')";
        $conx->consultaBase($ssql, $conn);
//        echo $ssql."<br>";
    }
}
$aud->regAudC("CONTROL DE REMITOS", $usr->getId(), "Agrega nuevo control de remito #$id | $fecha | $horainicio | $horafin", $centrosel, $conn, $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crm_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
