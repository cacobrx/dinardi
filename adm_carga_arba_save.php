<?php
/*
 * Creado el 25/10/2018 12:28:29
 * Autor: gus
 * Archivo: adm_carga_arba_ver.php
 * planbsistemas.com.ar
 */

function sacarComillas($cad) {
    $ret="";
    for($k=0;$k<strlen($cad);$k++) {
        if(substr($cad,$k,1)!="\"") 
            $ret.=substr($cad,$k,1);
    }
    return $ret;
}
//print_r($_POST);
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/datesupport.php';
//require_once 'clases/adm_prd.php';
require_once("clases/support.php");
require_once 'clases/adm_cli.php';
require_once 'clases/adm_prv.php';
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
//$ssql="select * from adm_prd";
//$prd=new adm_prd_2($ssql);
//$p_cod=$prd->getCodigo();
//$p_id=$prd->getId();
$conn=$conx->conectarBase();
//print_r($_FILES);
$archivo=$glo->getGETPOST("archivo");
$tipo=$glo->getGETPOST("tipo");
$archivofin="arba/$archivo";
$cnt=0;
//echo $destino."<br>";
//echo "existe: $archivo ".file_exists($archivo)."<br>";
if (file_exists($archivofin)) { 
    $lines=file($archivofin);
//        echo "ccc: ".count($lines);
    $a_cuit=array();
    $a_importe=array();
    foreach ($lines as $line_num => $line) {
        $datos=explode(";", $line);
        array_push($a_cuit,$datos[4]);
        array_push($a_importe,$datos[8]);
    }
//        print_r($a_importe);

    if($tipo==1) {
        $ssql="select * from adm_cli order by apellido, nombre";
        $cli=new adm_cli_2($ssql);
        $x_id=$cli->getId();
        $x_ape=$cli->getApellido();
        $x_nom=$cli->getNombre();
        $x_cuit=$cli->getCuit();

    } else {
        $ssql="select * from adm_prv order by apellido, nombre";
        $prv=new adm_prv_2($ssql);
        $x_id=$prv->getId();
        $x_ape=$prv->getApellido();
        $x_nom=$prv->getNombre();
        $x_cuit=$prv->getCuit();
    }
    $x_imp=array();
    $conn=$conx->conectarBase();
    for($i=0;$i<count($x_id);$i++) {
        $search= array_search($x_cuit[$i], $a_cuit);
        if($search!==false) {
            $ppp= str_replace(",", ".", $a_importe[$search]);
            $ssql="update ";
            if($tipo==1) $ssql.=" adm_cli set percepcioniibb=$ppp"; else $ssql.=" adm_prv set retencioniibb=$ppp";
            $ssql.=" where id=".$x_id[$i];
//            echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
            $cnt++;
        }
    }
}
    
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_carga_arba.php" method="post">
            
        </form>
        <script>
            alert("Se actualizaron <?= $cnt?> registros.");
            document.form1.submit()
        </script>
    </body>
</html>