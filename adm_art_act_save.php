<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art_act_save.php
 */
//print_r($_POST);    
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
$centro=$glo->getGETPOST("centro");
$descripcion=$glo->getGETPOST("descripcion");
$precio=$glo->getGETPOST("precio");
$tarea=$glo->getGETPOST("tarea");
$rubro=$glo->getGETPOST("rubro");
$codigo=$glo->getGETPOST("codigo");
$elaborado=$glo->getGETPOST("elaborado");
$envasado=$glo->getGETPOST("envasado");
$tipoenvalaje=$glo->getGETPOST("tipoenvalaje");
$cantidad=$glo->getGETPOST("cantidad");
if($elaborado=="") $elaborado=0;
if($cantidad=="") $cantidad=0;
if($codigo=="") $codigo=0;
if($rubro=="") $rubro=0;
if($tipoenvalaje=="") $tipoenvalaje=0;
if($envasado=="") $envasado=0;
$ahora=date("Y:m:d H:i:s");
if($tarea=="A") {
    $aud->regAud("Productos",$usr->getId(),"Ingresa Productos: $codigo | $descripcion",$centrosel);
    $ssql="insert into adm_art (centro, descripcion, precio, rubro, codigodinardi, envasado, cantidad, tipoenvalaje, elaborado) values ($centrosel, '$descripcion', '$precio', $rubro, $codigo, $envasado, $cantidad, $tipoenvalaje, $elaborado)";
} else {
    $aud->regAud("Productos",$usr->getId(),"Modifica Productos: $codigo | $descripcion",$centrosel);
    $ssql="update adm_art set descripcion='$descripcion', precio='$precio', rubro=$rubro, codigodinardi=$codigo, fechamod='$ahora', envasado=$envasado, cantidad=$cantidad, tipoenvalaje=$tipoenvalaje, elaborado=$elaborado where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_art_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
