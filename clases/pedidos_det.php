<?
/*
 * Creado el 23/04/2018 11:03:06
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: pedidos_det.php
 */
 
class pedidos_det_1 {
    var $id=0;
    var $centro=0;
    var $idped=0;
    var $idart=0;
    var $cantidad=0;
    var $precio=0;
    var $articulo="";

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from pedidos_det where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idped=$reg->idped;
        $this->idart=$reg->idart;
        $this->cantidad=$reg->cantidad;
        $this->precio=$reg->precio;
        $art=new adm_art_1($reg->idar, $conn);
        $this->articulo=$art->getDescripcion();
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdped() {
        return $this->idped;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
  
    function getPrecio() {
        return $this->precio;
    }
    
    function getArticulo() {
        return $this->articulo;
    }
  
}

class pedidos_det_2 {
    var $id=array();
    var $centro=array();
    var $idped=array();
    var $idart=array();
    var $cantidad=array();
    var $precio=array();
    var $articulo=array();
    var $descuento=array();
    var $preciodes=array();
    var $total=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->idped,$reg->idped);
                array_push($this->idart,$reg->idart);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->precio,$reg->precio);
                array_push($this->descuento,$reg->descuento);
                array_push($this->preciodes,$reg->precio-$reg->precio*$reg->descuento/100);
                array_push($this->total,($reg->precio-$reg->precio*$reg->descuento/100)*$reg->cantidad);
                $art=new adm_art_1($reg->idart,$conn);
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
  
    function getIdped() {
        return $this->idped;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
  
    function getPrecio() {
        return $this->precio;
    }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
    
    function getArticulo() {
        return $this->articulo;
    }
    
    function getDescuento() {
        return $this->descuento;
    }
    
    function getPreciodes() {
        return $this->preciodes;
    }
    
    function getTotal() {
        return $this->total;
    }
}

?>
