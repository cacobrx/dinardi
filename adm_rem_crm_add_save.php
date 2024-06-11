<?php
/*
 * Creado el 09/06/2019 20:45:36
 * Autor: gus
 * Archivo: adm_rem_crm_add_save.php
 * planbsistemas.com.ar
 */

print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$conx=new conexion();
$aud=new registra_auditoria();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$fecha=$glo->getGETPOST("fecha");
$idrem=$glo->getGETPOST("idrem");
$faena=$glo->getGETPOST("faena");
$horainicio=$glo->getGETPOST("horainicio");
$cantidaddet=$glo->getGETPOST("cantidaddet");
$horafin=$glo->getGETPOST("horafin");
$observaciones=$glo->getGETPOST("observaciones");
$rem=new adm_rem_1($idrem);
$d_idart=$rem->getDet_idart();
if($faena==0) $cantidaddet=count($d_idart)-1;
$conn=$conx->conectarBase();
$ssql="select * from adm_crm where idrem=$idrem";
if($conx->getCantidadRegA($ssql, $conn)==0) {
    $ssql="insert into adm_crm (fecha, idrem, horainicio, horafin, observaciones, idope, faena) values ('$fecha', $idrem, '$horainicio', '$horafin', '$observaciones', ".$usr->getId().", $faena)";
    $conx->consultaBase($ssql, $conn);
//    echo $ssql."<br>";
    $id=$conx->getLastId("adm_crm", $conn);
} else { 
    $rm=$conx->consultaBase($ssql, $conn);
    $rmm=mysqli_fetch_object($rm);
    $id=$rmm->id;
    $ssql="update adm_crm set fecha='$fecha', horainicio='$horainicio', horafin='$horafin', observaciones='$observaciones', faena=$faena where idrem=$idrem";
    $conx->consultaBase($ssql, $conn);
}
    
$ssql="delete from adm_crm_det where idcrm=$id";
//echo $ssql."<br>";
$conx->consultaBase($ssql, $conn);
for($i=0;$i<=$cantidaddet;$i++) {
    $item_peso="item_peso$i";
    $item_temperatura="item_temperatura$i";
    $item_observaciones="item_observaciones$i";
    $item_unidad="item_unidad$i";
    $item_producto="item_producto$i";
    $idremdet="idremdet$i";
    $item_ela="item_ela$i";
    $item_env="item_env$i";
    $$idremdet=$glo->getGETPOST($idremdet);
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_peso=$glo->getGETPOST($item_peso);
    $$item_unidad=$glo->getGETPOST($item_unidad);
    $$item_temperatura=$glo->getGETPOST($item_temperatura);
    $$item_observaciones=$glo->getGETPOST($item_observaciones);
    $$item_ela=$glo->getGETPOST($item_ela);
    $$item_env=$glo->getGETPOST($item_env);
    if($$item_peso=="") $$item_peso=0;
    if($$item_temperatura=="") $$item_temperatura=0;
    if($$idremdet=="") $$idremdet=0;
    if($$item_ela=="") $$item_ela=0;
    if($$item_env=="") $$item_env=0;
    if($faena==0) {
        $aaa=$d_idart[$i];
        $ssql="insert into adm_crm_det (idcrm, idart, cantidad, temperatura, observaciones, unidad, idremdet, idela, idenv) values (";
        $ssql.="$id, $aaa, ".$$item_peso.", ".$$item_temperatura.", '".$$item_observaciones."', ".$$item_unidad.", ".$$idremdet.", ".$$item_ela.", ".$$item_env.")";
    } else {
        $aaa=$$item_producto;
        $ssql="insert into adm_crm_det (idcrm, idart, cantidad, peso, temperatura, observaciones, unidad, idremdet, idela, idenv) values (";
        $ssql.="$id, $aaa, ".$$item_peso.", ".$$item_peso.", ".$$item_temperatura.", '".$$item_observaciones."', ".$$item_unidad.", ".$$idremdet.", ".$$item_ela.", ".$$item_env.")";
    }
    $conx->consultaBase($ssql, $conn);
    if($$idremdet>0) {
        $ssql="update adm_rem_det set cantidadcrm=".$$item_peso.", idela=".$$item_ela.", idenv=".$$item_env." where id=".$$idremdet;
        $conx->consultaBase($ssql, $conn);
    }
    
//    echo $ssql."<br>";
}
$aud->regAudC("CONTROL DE REMITOS", $usr->getId(), "Agrega nuevo control del remito $idrem | #$id | $fecha | $horainicio | $horafin", $centrosel, $conn, $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_rem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

