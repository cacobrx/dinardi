<?php
/*
 * Creado el 07/10/2019 12:48:06
 * Autor: gus
 * Archivo: inf_compras.php
 * planbsistemas.com.ar
 */

class inf_compras {
    var $articulos=array();
    var $cantidad=array();
    var $importe=array();
    var $iva=array();
    var $neto=array();
    
    function __construct($fechaini, $fechafin, $orden, $idprv, $idart) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_prv_pre.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_art";
        if($idart>0) $ssql.=" where id=$idart";
        $ssql.=" order by descripcion";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $cad=array();
        while($reg=mysqli_fetch_object($rs)) {
            $ssql="select sum(adm_rem_det.cantidad) as totcantidad, sum(adm_rem_det.cantidad*adm_rem_det.precio) as totimporte ";
            $ssql.="from adm_rem_det, adm_rem ";
            $ssql.="where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin' and adm_rem_det.idart=".$reg->id." and adm_rem.id=adm_rem_det.idrem";
            if($idprv>0) $ssql.=" and adm_rem.idprv=$idprv ";
            
            
            $ssql="select adm_rem_det.*, adm_rem.idprv from adm_rem_det, adm_rem where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin' and adm_rem_det.idart=".$reg->id." and adm_rem.id=adm_rem_det.idrem";
            if($idprv>0) $ssql.=" and adm_rem.idprv=$idprv";
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
                $pre=new adm_prv_pre_1($rdd->idprv, $rdd->idart, $conn);
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
                    $or=$sup->AddZeros(number_format($imp*100,0,".",""),16);
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