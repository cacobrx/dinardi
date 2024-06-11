<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela_act_save.php
 */
    
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_ela_det.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$cantidaddet=$glo->getGETPOST("cantidaddet");
$id=$glo->getGETPOST("id");
$fecha=$glo->getGETPOST("fecha");
$horaing=$glo->getGETPOST("horaing");
$horaegr=$glo->getGETPOST("horaegr");
$horaing1=$glo->getGETPOST("horaing1");
$horaegr1=$glo->getGETPOST("horaegr1");
$empleados=$glo->getGETPOST("empleados");
$observacion1=$glo->getGETPOST("observacion1");
$observacion2=$glo->getGETPOST("observacion2");
$turno=$glo->getGETPOST("turno");
$tarea=$glo->getGETPOST("tarea");
$telaborado1=$glo->getGETPOST("telaborado1");
$telaborado2=$glo->getGETPOST("telaborado2");
$telaborado3=$glo->getGETPOST("telaborado3");
if($telaborado1=="") $telaborado1=0;
if($telaborado2=="") $telaborado2=0;
if($telaborado3=="") $telaborado3=0;
if($horaing=="") $horaing=0;
if($horaegr=="") $horaegr=0;
if($horaing1=="") $horaing1=0;
if($horaegr1=="") $horaegr1=0;
if($empleados=="") $empleados=0;
$aud->regAud("Elaboracion",$usr->getId(),"Modifica Elaboracion: ",$centrosel);
$ssql="update adm_ela set fecha='$fecha', horaing='$horaing', horaegr='$horaegr', horaing1='$horaing1', horaegr1='$horaegr1', empleados=$empleados, observacion1='$observacion1', observacion2='$observacion2', turno=$turno, telaborado1=$telaborado1, telaborado2=$telaborado2, telaborado3=$telaborado3 where id=$id";
$conn=$conx->conectarBase();
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="delete from adm_ela_det where idela=$id";
//echo $ssql."<br>";
$conx->consultaBase($ssql, $conn);
$ssql="delete from adm_ela_prv where idela=$id";
$conx->consultaBase($ssql, $conn);
$cantidad=$cantidaddet;
for($i=0;$i<=$cantidad;$i++) {
    $item_fecha="item_fecha$i";
    $item_producto="item_producto$i";
    $item_kgdescarte="item_kgdescarte$i";
    $item_kgfinal="item_kgfinal$i";
    $$item_fecha=$glo->getGETPOST($item_fecha);
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_kgdescarte=$glo->getGETPOST($item_kgdescarte);
    $$item_kgfinal=$glo->getGETPOST($item_kgfinal);
    if($$item_kgfinal=="") $$item_kgfinal=0;
    if($$item_kgdescarte=="") $$item_kgdescarte=0;
    if($$item_producto>0) {        
        $ssql="insert into adm_ela_det (fechaing, idart, kgdescarte, kgfinal, idela) values (";
        $ssql.="'".$$item_fecha."', ".$$item_producto.", ".$$item_kgdescarte.", ".$$item_kgfinal.", $id)";
        $conx->consultaBase($ssql, $conn);
        //echo $ssql."<br>";
        $iddet=$conx->getLastId("adm_ela_det", $conn);
    
        $prv_proveedor0="item_proveedor$i"."_0";
        $prv_proveedor1="item_proveedor$i"."_1";
        $prv_proveedor2="item_proveedor$i"."_2";
        $$prv_proveedor0=$glo->getGETPOST($prv_proveedor0);
        $$prv_proveedor1=$glo->getGETPOST($prv_proveedor1);
        $$prv_proveedor2=$glo->getGETPOST($prv_proveedor2);

        if($$prv_proveedor0>0) {
            $ssql="insert into adm_ela_prv (idela, idprv, iddet) values ($id, ".$$prv_proveedor0.", $iddet)";
    //        echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
        }
        if($$prv_proveedor1>0) {
            $ssql="insert into adm_ela_prv (idela, idprv, iddet) values ($id, ".$$prv_proveedor1.", $iddet)";
    //        echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
        }
        if($$prv_proveedor2>0) {
            $ssql="insert into adm_ela_prv (idela, idprv, iddet) values ($id, ".$$prv_proveedor2.", $iddet)";
            $conx->consultaBase($ssql, $conn);
        }
    }
    
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_ela_main.php" method="post">
        </form>
        <script languaje="javascript">
           document.form1.submit()
        </script>
    </body>
</html>
