<?php
/*
 * Creado el 15/02/2021 10:39:51
 * Autor: gus
 * Archivo: elaasados.php
 * planbsistemas.com.ar
 */

class elaboracion {
    var $fecha=array();
    var $articulo=array();
    var $kilos=array();
    var $totalkilos=0;
    
    function __construct($fechaini, $fechafin, $idart, $idprv) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $xfecha=array();
        
        $f1=$fechaini;
        while($fechaini<=$fechafin) {
            array_push($this->fecha,$fechaini);
            $ssql="select adm_ela_det.*, adm_art.descripcion as descripcion_art from adm_ela_det, adm_ela, adm_art, adm_ela_prv where adm_ela.fecha='$fechaini' and adm_art.id=adm_ela_det.idart and adm_ela_det.idela=adm_ela.id and adm_ela_prv.idela=adm_ela.id and adm_ela_prv.iddet=adm_ela_det.id";
            if($idart>0) $ssql.=" and adm_ela_det.idart=$idart";
            if($idprv>0) $ssql.=" and adm_ela_prv.idprv=$idprv";
            $ssql.=" order by adm_art.descripcion";
//            echo $ssql."\n";
            $rs=$conx->consultaBase($ssql, $conn);
            $xarticulo=array();
            $xkilos=array();
            $xidart=array();
            while($reg=mysqli_fetch_object($rs)) {
                $search= array_search($reg->idart, $xidart);
                if($search===false) {
                    array_push($xarticulo,$reg->descripcion_art);
                    array_push($xidart,$reg->idart);
                    array_push($xkilos,$reg->kgfinal);
                } else {
                    $xkilos[$search]+=$reg->kgfinal;
                }
            }
            array_push($this->articulo,$xarticulo);
            array_push($this->kilos,$xkilos);
            $fechaini=date("Y-m-d", strtotime("$fechaini + 1 day"));
            $this->totalkilos+=array_sum($xkilos);
        }
    }
    
    function getFecha() { return $this->fecha; }
    function getArticulo() { return $this->articulo; }
    function getKilos() { return $this->kilos; }
    function getTotalkilos() { return $this->totalkilos; }
}

class elaboracion_fec {
    var $articulo=array();
    var $kilos=array();
    var $totalkilos=0;
    
    function __construct($fechaini, $fechafin, $idart, $idprv) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $xfecha=array();
        
        $ssql="select adm_ela_det.*, adm_art.descripcion as descripcion_art from adm_ela_det, adm_ela, adm_art, adm_ela_prv where adm_ela.fecha>='$fechaini' and adm_ela.fecha<='$fechafin' and adm_art.id=adm_ela_det.idart and adm_ela_det.idela=adm_ela.id and adm_ela_prv.idela=adm_ela.id and adm_ela_prv.iddet=adm_ela_det.id";
        if($idart>0) $ssql.=" and adm_ela_det.idart=$idart";
        if($idprv>0) $ssql.=" and adm_ela_prv.idprv=$idprv";
        $ssql.=" order by adm_art.descripcion";
        //echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $xarticulo=array();
        $xcajas=array();
        $xkilos=array();
        $xidart=array();
        while($reg=mysqli_fetch_object($rs)) {
            $search= array_search($reg->idart, $xidart);
            if($search===false) {
                array_push($xarticulo,$reg->descripcion_art);
                array_push($xidart,$reg->idart);
                array_push($xkilos,$reg->kgfinal);
            } else {
                $xkilos[$search]+=$reg->kgfinal;
            }
        }
//        print_r($xcajas);
        $this->articulo=$xarticulo;
        $this->kilos=$xkilos;
        $this->totalkilos=array_sum($xkilos);
    }
    
    function getArticulo() { return $this->articulo; }
    function getKilos() { return $this->kilos; }
    function getTotalkilos() { return $this->totalkilos; }
}

