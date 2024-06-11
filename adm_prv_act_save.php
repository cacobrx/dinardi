<?
/*
 * Creado el 18/01/2019 17:16:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prv_act_save.php
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
$centro=$glo->getGETPOST("centro");
$nombre=$glo->getGETPOST("nombre");
$apellido=$glo->getGETPOST("apellido");
$ciudad=$glo->getGETPOST("ciudad");
$direccion=$glo->getGETPOST("direccion");
$telefono=$glo->getGETPOST("telefono");
$cuit=$glo->getGETPOST("cuit");
$condiva=$glo->getGETPOST("condiva");
$observaciones=$glo->getGETPOST("observaciones");
$email=$glo->getGETPOST("email");
$retencioniibb=$glo->getGETPOST("retencioniibb");
$cuenta=$glo->getGETPOST("cuenta");
$tarea=$glo->getGETPOST("tarea");
$codigodinardi=$glo->getGETPOST("codigodinardi");
$expganancia=$glo->getGETPOST("expganancia");
$facturam=$glo->getGETPOST("facturam");
$establecimiento1=$glo->getGETPOST("establecimiento1");
$establecimiento2=$glo->getGETPOST("establecimiento2");
$establecimiento3=$glo->getGETPOST("establecimiento3");
if($establecimiento1=="") $establecimiento1=0;
if($establecimiento2=="") $establecimiento2=0;
if($establecimiento3=="") $establecimiento3=0;
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="") $cantidaddet=0;
if($facturam=="") $facturam=0;
if($expganancia=="")
    $expganancia=0;
$id=$glo->getGETPOST("id");
$tipo=$glo->getGETPOST("tipo");
if($condiva=="") $condiva=1;
if($retencioniibb=="") $retencioniibb=0;
if($cuenta=="") $cuenta=0;
if($codigodinardi=="") $codigodinardi=0;
if($tarea=="A") {
    $aud->regAud("PROVEEDORES",$usr->getId(),"Ingresa Proveedor: $apellido $nombre",$centrosel);
    $ssql="insert into adm_prv (centro, nombre, apellido, direccion, ciudad, telefono, cuit, condiva, observaciones, email, cuenta, retencioniibb, tipo, codigodinardi, expganancia, facturam, establecimiento1, establecimiento2, establecimiento3) values ($centrosel, '$nombre', '$apellido', '$direccion', '$ciudad', '$telefono', '$cuit', '$condiva', '$observaciones', '$email', $cuenta, $retencioniibb, $tipoprv, $codigodinardi, $expganancia, $facturam, $establecimiento1, $establecimiento2, $establecimiento3)";
} else {
    $aud->regAud("PROVEEDORES",$usr->getId(),"Modifica Proveedor: $apellido $nombre",$centrosel);
    $ssql="update adm_prv set nombre='$nombre', apellido='$apellido', direccion='$direccion', ciudad='$ciudad', telefono='$telefono', cuit='$cuit', cuenta=$cuenta, retencioniibb=$retencioniibb, condiva=$condiva, observaciones='$observaciones', email='$email', tipo=$tipo, codigodinardi=$codigodinardi, expganancia=$expganancia, facturam=$facturam, establecimiento1=$establecimiento1, establecimiento2=$establecimiento2, establecimiento3=$establecimiento3, fechamod='".date("Y-m-d H:i:s")."' where id=$id";
}
//echo $ssql."<br>";
$conx->getConsulta($ssql);

$cad="";
for($i=0;$i<=$cantidaddet;$i++) {
    $pais="item_pais$i";
    $$pais=$glo->getGETPOST($pais);
//    echo "centro: $centro | ".$$centro."<br>";
    if($$pais>0) {
        $cad.=$$pais."|";
    }
    
}
if($cad!="") $cad=substr($cad,0, strlen($cad)-1);
$ssql="update adm_prv set paises='|$cad|' where id=$id";
$conx->getConsulta($ssql);

?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_prv_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>