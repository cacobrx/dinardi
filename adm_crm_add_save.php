<?php
/*
 * Creado el 18/12/2018 13:58:13
 * Autor: gus
 * Archivo: adm_rem_add_save.php
 * planbsistemas.com.ar
 */
//print_r($_POST);
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
$idrem=$glo->getGETPOST("idrem");
$horainicio=$glo->getGETPOST("horainicio");
$horafin=$glo->getGETPOST("horafin");
$observaciones=$glo->getGETPOST("observaciones");
$conn=$conx->conectarBase();
$ssql="insert into adm_crm (fecha, idrem, horainicio, horafin, observaciones, idope) values ('$fecha', $idrem, '$horainicio', '$horafin', '$observaciones', ".$usr->getId().")";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
$id=$conx->getLastId("adm_crm", $conn);
$ssql="delete from adm_crm_det where idcrm=$id";
$conx->consultaBase($ssql, $conn);
$cantidad=100;
for($i=0;$i<=$cantidad;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_producto="item_producto$i";
    $item_peso="item_peso$i";
    $item_temperatura="item_temperatura$i";
    $item_observaciones="item_observaciones$i";
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    $$item_peso=$glo->getGETPOST($item_peso);
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

