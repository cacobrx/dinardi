<?
/*
 * Creado el 29/05/2017 11:20:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_adelantos.php
 */
 
class adm_adelantos_1 {
    var $id=0;
    var $centro='';
    var $idper=0;
    var $fecha=0;
    var $personal='';
    var $importe=0;   

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once "clases/adm_empleados.php";  
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_adelantos where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idper=$reg->idper;
        $this->fecha=$reg->fecha;
        $per=new adm_empleados_1($reg->idper);
        $this->personal=$per->getApellido()."".$per->getNombre();
        $this->importe=$reg->importe;
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdper() {
        return $this->idper;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getImporte() {
        return $this->importe;
    }
    
        function getPersonal() {
        return $this->personal;
    }
    
  
}

class adm_adelantos_2 {
    var $id=array();
    var $centro=array();
    var $idper=array();
    var $fecha=array();
    var $importe=array();
    var $personal=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once "clases/adm_empleados.php";
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
                array_push($this->idper,$reg->idper);
                array_push($this->fecha,$reg->fecha);
                array_push($this->importe,$reg->importe);
                $per=new adm_empleados_1($reg->idper);
                array_push($this->personal,$per->getApellido()." ".$per->getNombre());
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdper() {
        return $this->idper;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getImporte() {
        return $this->importe;
    }

       function getPersonal() {
        return $this->personal;
    } 
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
