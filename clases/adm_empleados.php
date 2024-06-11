<?
/*
 * Creado el 26/05/2017 15:34:36
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_empleados.php
 */
 
class adm_empleados_1 {
    var $id=0;
    var $centro=0;
    var $nombre='';
    var $apellido='';
    var $documento=0;
    var $fechaingreso='';
    var $importe=0;
    var $iddep=0;
    var $departamento="";
    var $det_hora1=array();
    var $det_hora2=array();
    var $det_hora3=array();
    var $det_hora4=array();    

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/departamento.php';
        require_once 'clases/horarios.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_empleados where id=$id";
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->nombre=$reg->nombre;
            $this->apellido=$reg->apellido;
            $this->documento=$reg->documento;
            $this->fechaingreso=$reg->fechaingreso;
            $this->importe=$reg->importe;
            $this->iddep=$reg->iddep;
            $dep=new departamento_1($reg->iddep);
            $this->departamento=$dep->getDescripcion();
//            $dep=new horarios($reg->iddep);
//            $this->departamento=$dep->getDescripcion(); 
              
                  
            
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getNombre() {
        return $this->nombre;
    }
  
    function getApellido() {
        return $this->apellido;
    }
  
    function getDocumento() {
        return $this->documento;
    }
  
    function getFechaingreso() {
        return $this->fechaingreso;
    }   
    
    function getImporte() {
        return $this->importe;
    }
    
    function getIddep() { return $this->iddep; }
    function getDepartamento() { return $this->departamento; }
    function getDet_hora1() { return $this->det_hora1; }
    function getDet_hora2() { return $this->det_hora2; }
    function getDet_hora3() { return $this->det_hora3; }
    function getDet_hora4() { return $this->det_hora4; }    
  
}

class adm_empleados_2 {
    var $id=array();
    var $centro=array();
    var $nombre=array();
    var $apellido=array();
    var $documento=array();
    var $fechaingreso=array();
    var $importe=array();
    var $iddep=array();
    var $departamento=array();
    var $det_descripcion=array();
    var $det_hora1=array();
    var $det_hora2=array();
    var $det_hora3=array();
    var $det_hora4=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/departamento.php';
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
                array_push($this->nombre,$reg->nombre);
                array_push($this->apellido,$reg->apellido);
                array_push($this->documento,$reg->documento);
                array_push($this->fechaingreso,$reg->fechaingreso);
                array_push($this->importe,$reg->importe);
                array_push($this->iddep,$reg->iddep);
                $dep=new departamento_1($reg->iddep);
                array_push($this->departamento,$dep->getDescripcion());
                $ssql="select * from departamento where id=".$reg->iddep;
//                echo $ssql;
                $det=new departamento_2($ssql, $conn);
                array_push($this->det_descripcion,$det->getDescripcion());
                array_push($this->det_hora1,$det->getHora1());                
                array_push($this->det_hora2,$det->getHora2());                
                array_push($this->det_hora3,$det->getHora3());                
                array_push($this->det_hora4,$det->getHora4());                
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getNombre() {
        return $this->nombre;
    }
  
    function getApellido() {
        return $this->apellido;
    }
    
    function getDocumento() {
        return $this->documento;
    }
  
    function getFechaingreso() {
        return $this->fechaingreso;
    }
  
    function getImporte() {
        return $this->importe;
    }
    
    function getIddep() { return $this->iddep; }
    function getDepartamento() { return $this->departamento; }
    function getDet_descripicion() { return $this->det_descripcion; }
    function getDet_hora1() { return $this->det_hora1; }
    function getDet_hora2() { return $this->det_hora2; }
    function getDet_hora3() { return $this->det_hora3; }
    function getDet_hora4() { return $this->det_hora4; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
