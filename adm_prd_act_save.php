<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_act_save.php
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
$descripcion=$glo->getGETPOST("descripcion");
$precioventa=$glo->getGETPOST("precioventa");
$rubro=$glo->getGETPOST("rubro");
$unidad=$glo->getGETPOST("unidad");
$unidadxanimal=$glo->getGETPOST("unidadxanimal");
$kilosxanimal=$glo->getGETPOST("kilosxanimal");
$presentacion=$glo->getGETPOST("presentacion");
$codigoproducto=$glo->getGETPOST("codigoproducto");
$artproveedor=$glo->getGETPOST("artproveedor");
$envasado=$glo->getGETPOST("envasado");
$elaborado=$glo->getGETPOST("elaborado");
$artcliente=$glo->getGETPOST("artcliente");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$colorcamara=$glo->getGETPOST("colorcamara");
$colorletra=$glo->getGETPOST("colorletra");
$cantidaddet=$glo->getGETPOST("cantidaddet");

if($artproveedor=="") $artproveedor=0;
if($artcliente=="") $artcliente=0;
if($codigoproducto=="") $codigoproducto=0;
if($rubro=="") $rubro=0;
if($envasado=="") $envasado=0;
if($elaborado=="") $elaborado=0;
if($kilosxanimal=="") $kilosxanimal=0;
if($unidadxanimal=="") $unidadxanimal=0;
$conn=$conx->conectarBase();
if($tarea=="A") {
    $aud->regAud("Articulos de Venta",$usr->getId(),"Ingresa Articulos de Venta: \[$id]",$centrosel);
    $ssql="insert into adm_prd (centro, descripcion, precioventa, rubro, unidad, unidadxanimal, kilosxanimal, presentacion, codigoproducto, envasado, elaborado, colorcamara, colorletra) values ($centrosel, '$descripcion', '$precioventa', $rubro, $unidad, $unidadxanimal, $kilosxanimal, $presentacion, $codigoproducto, $envasado, $elaborado, '$colorcamara', '$colorletra')";
} else {
    $aud->regAud("Articulos de Venta",$usr->getId(),"Modifica Articulos de Venta: [$id]",$centrosel);
    $ssql="update adm_prd set descripcion='$descripcion', precioventa='$precioventa', rubro=$rubro, unidad=$unidad, unidadxanimal=$unidadxanimal, kilosxanimal=$kilosxanimal, presentacion=$presentacion, codigoproducto=$codigoproducto, fechamod='".date("Y-m-d H:i:s")."', envasado=$envasado, elaborado=$elaborado, colorcamara='$colorcamara', colorletra='$colorletra' where id=$id";
}
$conx->consultaBase($ssql, $conn);
//echo $ssql;
if($tarea=="A") $id=$conx->getLastId ("adm_prd", $conn);
$ssql="delete from adm_ubi where idart=$id";
$conx->consultaBase($ssql, $conn);

for($i=0;$i<=$cantidaddet;$i++) {
    $posicionx="posicionx_$i";
    $posiciony="posiciony_$i";
    $posicionz="posicionz_$i";
    $$posicionx=$glo->getGETPOST($posicionx);
    $$posiciony=$glo->getGETPOST($posiciony);
    $$posicionz=$glo->getGETPOST($posicionz);
    if($$posicionx!="" and $$posiciony!="" and $$posicionz!="") {
        $ssql="insert into adm_ubi (idart, posicionx, posiciony, posicionz) values ($id, ".$$posicionx.", ".$$posiciony.", ".$$posicionz.")";
//        echo $ssql."<br>";
        $conx->consultaBase($ssql, $conn);
    }
}

?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_prd_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
