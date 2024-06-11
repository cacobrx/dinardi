<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_pro.php
 */
 
class adm_pro_1 {
    var $id=0;
    var $centro=0;
    var $descripcion='';
    var $precio='';

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_pro where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->descripcion=$reg->descripcion;
        $this->precio=$reg->precio;
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
  
}

class adm_pro_2 {
    var $id=array();
    var $centro=array();
    var $descripcion=array();
    var $precio=array();
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
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
