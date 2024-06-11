<?
/*
 * Creado el 24/07/2020 14:59:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_asistencias.php
 */
 
class adm_asistencias_1 {
    var $id=0;
    var $idper=0;
    var $fecha='';
    var $cantidad=0;
    var $empleado="";
    var $tipohora="";
    var $tipohorades="";

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_empleados.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_asistencias where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idper=$reg->idper;
        $this->fecha=$reg->fecha;
        $this->cantidad=$reg->cantidad;
        $per=new adm_empleados_1($reg->idper);
        $this->empleado=$per->getApellido()." ".$per->getNombre();        
        $this->tipohora=$reg->tipohora;
        switch ($reg->tipohora) {
            case 1:
                $this->tipohorades="Horas Trabajadas";
                break;
            case 2:
                $this->tipohorades="Horas Nocturnas";
                break;
            case 3:
                $this->tipohorades="Horas Extras";
                break;            
        }
        
    }

    function getId() {
        return $this->id;
    }
  
    function getIdper() {
        return $this->idper;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getTipohora() {
        return $this->tipohora;
    }    
    
    function getTipohorades() {
        return $this->tipohorades;
    }        
    
    function getEmpleado() {
        return $this->empleado;
    }
  
}

class adm_asistencias_2 {
    var $id=array();
    var $idper=array();
    var $fecha=array();
    var $cantidad=array();
    var $empleado=array();
    var $tipohora=array();
    var $tipohorades=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_empleados.php';
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
                array_push($this->idper,$reg->idper);
                array_push($this->fecha,$reg->fecha);
                array_push($this->cantidad,$reg->cantidad);
                $per=new adm_empleados_1($reg->idper);                
                array_push($this->empleado,$per->getApellido()." ".$per->getNombre());
                array_push($this->tipohora,$reg->tipohora);
                switch ($reg->tipohora) {
                    case 1:
                        array_push($this->tipohorades,"Horas Trabajadas");
                        break;
                    case 2:
                        array_push($this->tipohorades,"Horas Nocturnas");
                        break;
                    case 3:
                        array_push($this->tipohorades,"Horas Extras");
                        break;
                }                
                
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdper() {
        return $this->idper;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getEmpleado() {
        return $this->empleado;
    }

    function getTipohora() {
        return $this->tipohora;
    }    
    
    function getTipohorades() {
        return $this->tipohorades;
    }       
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
