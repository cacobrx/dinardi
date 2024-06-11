<?
/*
 * Creado el 26/05/2017 15:34:36
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: departamento.php
 */
 
class departamento_1 {
    var $id=0;
    var $descripcion="";
    var $hora1='';
    var $hora2='';
    var $hora3='';
    var $hora4='';
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from departamento where id=$id";
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->descripcion=$reg->descripcion;
            $this->hora1=$reg->hora1;
            $this->hora2=$reg->hora2;
            $this->hora3=$reg->hora3;
            $this->hora4=$reg->hora4;
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getHora1() {
        return $this->hora1;
    }

    function getHora2() {
        return $this->hora2;
    }

    function getHora3() {
        return $this->hora3;
    }

    function getHora4() {
        return $this->hora4;
    }    
  
}

class departamento_2 {
    var $id=array();
    var $descripcion=array();
    var $hora1=array();
    var $hora2=array();
    var $hora3=array();
    var $hora4=array();    
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
                array_push($this->descripcion,$reg->descripcion);
                array_push($this->hora1,$reg->hora1);
                array_push($this->hora2,$reg->hora2);
                array_push($this->hora3,$reg->hora3);
                array_push($this->hora4,$reg->hora4);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getHora1() {
        return $this->hora1;
    }

    function getHora2() {
        return $this->hora2;
    }

    function getHora3() {
        return $this->hora3;
    }

    function getHora4() {
        return $this->hora4;
    }    
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
