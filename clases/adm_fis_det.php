<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adm_fis_det
 *
 * @author gus
 */

class adm_fis_det_1 {
    var $id=0;
    var $centro=0;
    var $detalle='';
    var $cantidad=0;
    var $precio=0;
    var $alicuota=0;
    var $total=0;


    function __construct($id,$conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_fis_det where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->detalle=$reg->detalle;
        $this->ip=$reg->ip;
        $this->cantidad=$reg->cantidad;
        $this->precio=$reg->precio;
        $this->alicuota=$reg->alicuota;
        $this->total=$reg->cantidad*$reg->precio;
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getAlicuota() {
        return $this->alicuota;
    }
    
    function getTotal() {
        return $this->total;
    }
  
}

class adm_fis_det_2 {
    var $id=array();
    var $centro=array();
    var $articulo=array();
    var $idart=array();
    var $detalle=array();
    var $cantidad=array();
    var $precio=array();
    var $alicuota=array();
    var $total=array();
    var $maxregistros=0;


    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
              $ssqltot=$ssql;
            else
              $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->detalle,$reg->detalle);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->precio,$reg->precio);
                array_push($this->alicuota,$reg->alicuota);
                array_push($this->total,$reg->cantidad*$reg->precio);
                array_push($this->idart,$reg->idart);
                $art=new adm_art_1($reg->idart,0,0,$conn);
                array_push($this->articulo,$art->getDescripcion());
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getAlicuota() {
        return $this->alicuota;
    }
    
    function getTotal() {
        return $this->total;
    }
    
    function getIdart() {
        return $this->idart;
    }
    
    function getArticulo() {
        return $this->articulo;
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
?>