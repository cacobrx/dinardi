<?php
/*
 * Creado el 25/01/2021 16:25:04
 * Autor: gus
 * Archivo: congelados.php
 * planbsistemas.com.ar
 */

class congelados {
    var $fecha=array();
    var $articulo=array();
    var $cajas=array();
    var $kilos=array();
    var $totalcajas=0;
    var $totalkilos=0;
    
    function __construct($fechaini, $fechafin, $idart, $idprv) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $xfecha=array();
        
        $f1=$fechaini;
        while($fechaini<=$fechafin) {
            array_push($this->fecha,$fechaini);
            $ssql="select adm_env.*, adm_art.descripcion as descripcion_art, adm_art.cantidad as cantidad_art from adm_env, adm_art where adm_env.fechaing='$fechaini' and adm_env.idart=adm_art.id";
            if($idart>0) $ssql.=" and adm_env.idart=$idart";
            if($idprv>0) $ssql.=" and (idprv=$idprv or idprv1=$idprv or idprv2=$idprv)";
            $ssql.=" order by adm_art.descripcion";
//            echo $ssql."<br>";
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
                    if($reg->kilos==0) {
                        array_push($xkilos,$reg->cantidad * $reg->cantidad_art);
                        array_push($xcajas,$reg->cantidad);
                    } else {
                        array_push($xkilos,$reg->kilos);
                       array_push($xcajas,$reg->cantidad);
                    }
//                    array_push($xcajas,$reg->cantidad);
                } else {
                    if($reg->kilos==0) {
                        $xkilos[$search]+=$reg->cantidad * $reg->cantidad_art;
                        $xcajas[$search]+=$reg->cantidad;
                    } else {
                        $xkilos[$search]+=$reg->kilos;
                        $xcajas[$search]+=$reg->cantidad;
                    }
                }
            }
            array_push($this->articulo,$xarticulo);
            array_push($this->cajas,$xcajas);
            array_push($this->kilos,$xkilos);
            $fechaini=date("Y-m-d", strtotime("$fechaini + 1 day"));
            $this->totalcajas+=array_sum($xcajas);
            $this->totalkilos+=array_sum($xkilos);
        }
    }
    
    function getFecha() { return $this->fecha; }
    function getArticulo() { return $this->articulo; }
    function getKilos() { return $this->kilos; }
    function getCajas() { return $this->cajas; }
    function getTotalcajas() { return $this->totalcajas; }
    function getTotalkilos() { return $this->totalkilos; }
}

class congelados_fec {
    var $articulo=array();
    var $cajas=array();
    var $kilos=array();
    var $totalcajas=0;
    var $totalkilos=0;
    
    function __construct($fechaini, $fechafin, $idart, $idprv) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $xfecha=array();
        
        $ssql="select adm_env.*, adm_art.descripcion as descripcion_art, adm_art.cantidad as cantidad_art from adm_env, adm_art where adm_env.fechaing>='$fechaini' and adm_env.fechaing<='$fechafin' and adm_env.idart=adm_art.id";
        if($idart>0) $ssql.=" and adm_env.idart=$idart";
        if($idprv>0) $ssql.=" and (idprv=$idprv or idprv1=$idprv or idprv2=$idprv)";
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
                if($reg->kilos==0) {
                    array_push($xkilos,$reg->cantidad * $reg->cantidad_art);
                    array_push($xcajas,$reg->cantidad);
                } else {
                    array_push($xkilos,$reg->kilos);
                    array_push($xcajas,$reg->cantidad);
                }
//                array_push($xcajas,$reg->cantidad);
            } else {
                if($reg->kilos==0) {
                    $xkilos[$search]+=$reg->cantidad * $reg->cantidad_art;
                    $xcajas[$search]+=$reg->cantidad;
                } else {
                    $xkilos[$search]+=$reg->kilos;
                    $xcajas[$search]+=$reg->cantidad;
                }
            }
        }
//        print_r($xcajas);
        $this->articulo=$xarticulo;
        $this->cajas=$xcajas;
        $this->kilos=$xkilos;
        $this->totalcajas=array_sum($xcajas);
        $this->totalkilos=array_sum($xkilos);
    }
    
    function getArticulo() { return $this->articulo; }
    function getKilos() { return $this->kilos; }
    function getCajas() { return $this->cajas; }
    function getTotalcajas() { return $this->totalcajas; }
    function getTotalkilos() { return $this->totalkilos; }
}

