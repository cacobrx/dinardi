<?
/*
 * Creado el 07/07/2020 13:24:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas_act_save.php
 */
    
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$fecha=$glo->getGETPOST("fecha");
$idprv=$glo->getGETPOST("idprv");
$detalle=$glo->getGETPOST("detalle");
$importe=$glo->getGETPOST("importe");
$fechaven=$glo->getGETPOST("fechaven");
$descriptor1=$glo->getGETPOST("descriptor1");
$descriptor2=$glo->getGETPOST("descriptor2");
$descriptor3=$glo->getGETPOST("descriptor3");
$descriptor4=$glo->getGETPOST("descriptor4");
$fechapago=$glo->getGETPOST("fechapago");
$numero=$glo->getGETPOST("numero");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$conn=$conx->conectarBase();
if($descriptor1=="") $descriptor1=0;
if($descriptor2=="") $descriptor2=0;
if($descriptor3=="") $descriptor3=0;
if($descriptor4=="") $descriptor4=0;
if($numero=="") $numero=0;
if($tarea=="A") {
    $aud->regAud("GASTOS",$usr->getId(),"Ingresa Gastos: $fecha / $detalle / $importe / $idprv",$centrosel);
    $ssql="insert into adm_gas (fecha, idprv, importe, fechaven, numero) values ('$fecha', $idprv, $importe, '$fechaven', $numero)";
//echo $ssql;
    
} else {
    $aud->regAud("GASTOS",$usr->getId(),"Modifica Gastos: $fecha / $detalle / $importe / $idprv",$centrosel);
    $ahora=date("Y-m-d H:i:s");
    $ssql="update adm_gas set fecha='$fecha', idprv=$idprv, importe='$importe', fechaven='$fechaven', numero=$numero, fechamod='$ahora' where id=$id";
}
$conx->getConsulta($ssql);
if($tarea=="A") $id=$conx->getLastId("adm_gas");
if($fechapago!="")
    $ssql="update adm_gas set fechapago='$fechapago' where id=$id";
else
    $ssql="update adm_gas set fechapago=null where id=$id";
$conx->getConsulta($ssql);

$ssql="delete from adm_com_det where idgas=$id";
$conx->consultaBase($ssql,$conn);
$cantidaddet=$glo->getGETPOST("cantidaddet");
//echo "cantidaddet: $cantidaddet<br>";
//print_r($cantidad);
for($i=0;$i<=$cantidaddet;$i++) {
    $item_descriptor1="item_descriptor1$i";
    $item_descriptor2="item_descriptor2$i";
    $item_descriptor3="item_descriptor3$i";
    $item_descriptor4="item_descriptor4$i";
    $item_detalle="item_detalle$i";
    $item_importe="item_importe$i";

    $$item_descriptor1=$glo->getGETPOST($item_descriptor1);
    $$item_descriptor2=$glo->getGETPOST($item_descriptor2);
    $$item_descriptor3=$glo->getGETPOST($item_descriptor3);
    $$item_descriptor4=$glo->getGETPOST($item_descriptor4);
    $$item_detalle=$glo->getGETPOST($item_detalle);
    $$item_importe=$glo->getGETPOST($item_importe);

    if($$item_descriptor1=="") $$item_descriptor1=0;
    if($$item_descriptor2=="") $$item_descriptor2=0;
    if($$item_descriptor3=="") $$item_descriptor3=0;
    if($$item_descriptor4=="") $$item_descriptor4=0;
    $ssql="insert into adm_com_det (idgas, idcom, descriptor1, descriptor2, descriptor3, descriptor4, detalle, importe) values (";
    $ssql.="$id, 0, ".$$item_descriptor1.", '".$$item_descriptor2."', ".$$item_descriptor3.", ".$$item_descriptor4.", '".$$item_detalle."', ".$$item_importe.")";
//    echo $ssql."<br>";
    $conx->consultaBase($ssql,$conn);
   
    }
    

//echo $ssql;
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_gas_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
