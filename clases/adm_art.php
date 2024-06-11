<?
/*
 * Creado el 20/04/2018 09:59:47
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art.php
 */
 
class adm_art_1 {
    var $id=0;
    var $centro=0;
    var $descripcion='';
    var $precio=0;
    var $rubro=0;
    var $rubrodes="";
    var $codigodinardi=0;
    var $tipoenvalaje=0;
    var $tipoenvalajedes="";
    var $envasado=0;
    var $elaborado=0;
    var $cantidad=0;

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_art where id=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
    //        echo $ssql;
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->descripcion=$reg->descripcion;
            $this->precio=$reg->precio;
            $this->rubro=$reg->rubro;
            $this->codigodinardi=$reg->codigodinardi;
            $this->tipoenvalaje=$reg->tipoenvalaje;
            $this->cantidad=$reg->cantidad;
            $this->envasado=$reg->envasado;
            $this->elaborado=$reg->elaborado;
            $this->rubrodes=$conx->getTextoValor($reg->rubro, "RUB", $conn);
            $this->tipoenvalajedes=$conx->getTextoValor($reg->tipoenvalaje, "TENV", $conn);
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getPrecio() {
        return $this->precio;
    }
    
    function getTipoenvalaje() {
        return $this->tipoenvalaje;
    }
    
    function getEnvasado() {
        return $this->envasado;
    }
    
    function getElaborado() {
        return $this->elaborado;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getRubro() { return $this->rubro; }
    function getRubrodes() { return $this->rubrodes; }
    function getCodigodinardi() { return $this->codigodinardi; }
    function getTipoenvalajedes() { return $this->tipoenvalajedes; }
  
}

class adm_art_2 {
    var $id=array();
    var $centro=array();
    var $descripcion=array();
    var $precio=array();
    var $rubro=array();
    var $rubrodes=array();
    var $codigodinardi=array();
    var $tipoenvalaje=array();
    var $tipoenvalajedes=array();
    var $cantidad=array();
    var $envasado=array();
    var $elaborado=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
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
                array_push($this->descripcion,$reg->descripcion);
                array_push($this->precio,$reg->precio);
                array_push($this->rubro,$reg->rubro);
                array_push($this->codigodinardi,$reg->codigodinardi);
                array_push($this->tipoenvalaje,$reg->tipoenvalaje);
                array_push($this->envasado,$reg->envasado);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->elaborado,$reg->elaborado);
                array_push($this->rubrodes,$conx->getTextoValor($reg->rubro, "RUB", $conn));
                array_push($this->tipoenvalajedes,$conx->getTextoValor($reg->tipoenvalaje, "TENV", $conn));
                
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getPrecio() {
        return $this->precio;
    }

    function getElaborado() {
        return $this->elaborado;
    }
    
    function getTipoenvalaje() {
        return $this->tipoenvalaje;
    }
    function getTipoenvalajedes() {
        return $this->tipoenvalajedes;
    }
    
    function getEnvasado() {
        return $this->envasado;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }    
    
    function getRubro() { return $this->rubro; }
    function getRubrodes() { return $this->rubrodes; }
    function getCodigodinardi() { return $this->codigodinardi; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
