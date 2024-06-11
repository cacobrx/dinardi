<?php
/*
 * Creado el 03/10/2019 10:00:22
 * Autor: gus
 * Archivo: ventas.php
 * planbsistemas.com.ar
 */

class inf_ventas {
    var $articulos=array();
    var $cantidad=array();
    var $importe=array();
    var $iva=array();
    var $neto=array();
    
    function __construct($fechaini, $fechafin, $orden, $idcli, $idart) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_cli_pre.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_prd";
        if($idart>0) $ssql.=" where id=$idart";
        $ssql.=" order by descripcion";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $cad=array();
        while($reg=mysqli_fetch_object($rs)) {
            $ssql="select sum(adm_crem_det.cantidad) as totcantidad, sum(adm_crem_det.cantidad*adm_crem_det.precio) as totimporte ";
            $ssql.="from adm_crem_det, adm_crem ";
            $ssql.="where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin' and adm_crem_det.idpro=".$reg->id." and adm_crem.id=adm_crem_det.idrem";
            if($idcli>0) $ssql.=" and adm_crem.idcli=$idcli ";
            
            
            $ssql="select adm_crem_det.*, adm_crem.idcli from adm_crem_det, adm_crem where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin' and adm_crem_det.idpro=".$reg->id." and adm_crem.id=adm_crem_det.idrem";
            if($idcli>0) $ssql.=" and adm_crem.idcli=$idcli";
//            echo $ssql."<br>";
            $rd=$conx->consultaBase($ssql, $conn);
            $can=0;
            $imp=0;
            $neto=0;
            $iva=0;
            while($rdd=mysqli_fetch_object($rd)) {
                $can+=$rdd->cantidad;
                $imp+=$rdd->cantidad*$rdd->precio;
                $ximp=$rdd->cantidad*$rdd->precio;
                $pre=new adm_cli_pre_1($rdd->idcli, $rdd->idpro, $conn);
                $alicuota=$pre->getAlicuota();
                $xneto=$ximp/(1+$alicuota/100);
                $xiva=$ximp-$xneto;
                $neto+=$xneto;
                $iva+=$xiva;
            }
////            echo $ssql."\n";
//            $rx=$conx->consultaBase($ssql, $conn);
//            $rxx=mysqli_fetch_object($rx);
//            if($rxx->totcantidad=="") $can=0; else $can=$rxx->totcantidad;
//            if($rxx->totimporte=="") $imp=0; else $imp=$rxx->totimporte;
            $cadx=$reg->descripcion."|$can|$imp|$neto|$iva";
            switch ($orden) {
                case 1: // x cliente
                    $or=$reg->descripcion;
                    break;
                case 2: // x cantidad
                    $or=$sup->AddZeros($can,10);
                    break;
                case 3: // x importe
                    $or=$sup->AddZeros(number_format($imp*100,2,".",""),16);
                    break;
                    
            }
//            echo "cadx: $cadx\n";
            array_push($cad,$or."|".$cadx);
        }
        sort($cad);
        if($orden>1)
            $cadd= array_reverse($cad);
        else
            $cadd=$cad;
//        print_r($cad);
        for($i=0;$i<count($cadd);$i++) {
            $xcad=explode("|",$cadd[$i]);
            if($xcad[2]>0) {
                array_push($this->articulos,$xcad[1]);
                array_push($this->cantidad,$xcad[2]);
                array_push($this->importe,$xcad[3]);
                array_push($this->neto,$xcad[4]);
                array_push($this->iva,$xcad[5]);
            }
        }
    }
    
    function getArticulo() {
        return $this->articulos;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNeto() { return $this->neto; }
    function getIva() { return $this->iva; }
    
    
    
}

class inf_ventas_cli {
    var $articulos=array();
    var $cantidad=array();
    var $importe=array();
    var $iva=array();
    var $neto=array();
    var $porcentaje=array();
    var $percepcioniibb=array();
    var $total=array();
    
    function __construct($fechaini, $fechafin, $orden, $idcli, $idart) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_cli_pre.php';
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_crem.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_cli";
        if($idart>0) $ssql.=" where id=$idcli";
        $ssql.=" order by apellido, nombre";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $cad=array();
        while($reg=mysqli_fetch_object($rs)) {
//            $ssql="select sum(adm_crem_det.cantidad) as totcantidad, sum(adm_crem_det.cantidad*adm_crem_det.precio) as totimporte ";
//            $ssql.="from adm_crem_det, adm_crem ";
//            $ssql.="where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin' and adm_crem_det.idcli=".$reg->id." and adm_crem.id=adm_crem_det.idrem";
//            if($idart>0) $ssql.=" and adm_crem.idart=$idart ";
            
            
            $ssql="select adm_crem_det.*, adm_crem.idcli from adm_crem_det, adm_crem where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin' and adm_crem.idcli=".$reg->id." and adm_crem.id=adm_crem_det.idrem";
            if($idart>0) $ssql.=" and adm_crem.idart=$idart";
//            echo $ssql."<br>";
            $rd=$conx->consultaBase($ssql, $conn);
            $can=0;
            $imp=0;
            $neto=0;
            $iva=0;
            while($rdd=mysqli_fetch_object($rd)) {
//                echo "*".$rdd->idpro."<br>";
                $can+=$rdd->cantidad;
                $imp+=$rdd->cantidad*$rdd->precio;
                $ximp=$rdd->cantidad*$rdd->precio;
                $pre=new adm_cli_pre_1($rdd->idcli, $rdd->idpro, $conn);
                $alicuota=$pre->getAlicuota();
                $xneto=$ximp/(1+$alicuota/100);
                $xiva=$ximp-$xneto;
                $neto+=$xneto;
                $iva+=$xiva;
            }
////            echo $ssql."\n";
//            $rx=$conx->consultaBase($ssql, $conn);
//            $rxx=mysqli_fetch_object($rx);
//            if($rxx->totcantidad=="") $can=0; else $can=$rxx->totcantidad;
//            if($rxx->totimporte=="") $imp=0; else $imp=$rxx->totimporte;
            $cli=new adm_cli_1($reg->id, $conn);
//            echo $reg->id."|".$reg->apellido."|".$reg->nombre."<br>";
            $cadx=$cli->getApellido()." ".$cli->getNombre()."|$can|$imp|$neto|$iva|".$cli->getPercepcioniibb();
            switch ($orden) {
                case 1: // x cliente
                    $or=$cli->getApellido()." ".$cli->getNombre();
                    break;
                case 2: // x cantidad
                    $or=$sup->AddZeros(number_format($can*100,0,".",""),10);
                    break;
                case 3: // x importe
                    $or=$sup->AddZeros(number_format($imp*100,2,".",""),16);
                    break;
                    
            }
//            echo "cadx: $cadx\n";
            array_push($cad,$or."|".$cadx);
        }
        sort($cad);
        if($orden>1)
            $cadd= array_reverse($cad);
        else
            $cadd=$cad;
//        print_r($cad);
        for($i=0;$i<count($cadd);$i++) {
            $xcad=explode("|",$cadd[$i]);
            if($xcad[2]>0) {
                array_push($this->articulos,$xcad[1]);
                array_push($this->cantidad,$xcad[2]);
                array_push($this->importe,$xcad[3]);
                array_push($this->neto,$xcad[4]);
                array_push($this->iva,$xcad[5]);
                array_push($this->percepcioniibb,$xcad[4]*$xcad[6]/100);
                array_push($this->total,$xcad[3]+$xcad[4]*$xcad[6]/100);
            }
        }
        $total_imp=array_sum($this->importe);
        $ximp=$this->importe;
        for($i=0;$i<count($ximp);$i++) {
            array_push($this->porcentaje,$ximp[$i]*100/$total_imp);
        }
    }
       
    function getArticulo() {
        return $this->articulos;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNeto() { return $this->neto; }
    function getIva() { return $this->iva; }
    function getPercepcioniibb() { return $this->percepcioniibb; }
    function getTotal() { return $this->total; }
    function getPorcentaje() { return $this->porcentaje; }
    
}
