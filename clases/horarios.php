<?php
/*
 * Creado el 13/03/2019 13:57:03
 * Autor: gus
 * Archivo: adm_cped.php
 * planbsistemas.com.ar
 */

class horarios_1 {
    var $id=0;
    var $iddep=0;
    var $idemp=0;
    var $fecha='';
    var $fechaaplica="";
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from horarios where id=$id";
//        echo $ssql;
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idemp=$reg->idemp;
        $this->fecha=$reg->fecha;
        $this->iddep=$reg->iddep;
        $this->fechaaplica=$reg->fechaaplica;
    }

    function getId() {
        return $this->id;
    }
    
    function getIddep() {
        return $this->iddep;
    }    
    
    function getIdemp() {
        return $this->idemp;
    }        
  
    function getFecha() {
        return $this->fecha;
    }

    function getFechaaplica() {
        return $this->fechaaplica;
    }    
}

class horarios {
    var $iddep=array();
    var $idemp=array();
    var $empleados=array();
    var $fecha=array();
    
    
    function __construct($contenido) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_empleados.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $separador="\r\n";
        $datos=explode($separador,$contenido);
        //print_r($datos);
        for($i=0;$i<count($datos);$i++) {
            $ddd=explode(',', $datos[$i]);
            if(count($ddd)>4) {
                $nom="";
                $ideq=substr($ddd[0], 1,strlen($ddd[0]));                
                $ssql="select * from adm_empleados where iddep=".$ideq;
                if($conx->getCantidadRegA($ssql, $conn)>0) {
                    $reg=$conx->consultaBBase($ssql,$conn);
                    $nom=$reg->apellido." ".$reg->nombre;     
                    $idemp=$reg->id;     
                }
                array_push($this->iddep,$ideq);
                array_push($this->empleado,$nom);
                array_push($this->idemp,$idemp);
                array_push($this->fecha,$ddd[3]);                
            }
        }
    }
    
    function getFecha() { return $this->fecha; }
    function getEmpleado() { return $this->empleado; }
    function getIdemp() { return $this->idemp; }
    function getIddep() { return $this->iddep; }
}


class horarios_2 {
    var $id=array();
    var $iddep=array();
    var $idemp=array();
    var $empleado=array();
    var $fecha=array();
    var $departamento=array();
    var $fechaaplica=array();
    var $maxregistros=0;
    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_empleados.php';
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
                array_push($this->fecha,$reg->fecha);    
                array_push($this->iddep,$reg->iddep);
                array_push($this->idemp,$reg->idemp);
                $emp=new adm_empleados_1($reg->idemp);
                array_push($this->empleado,$emp->getApellido()." ".$emp->getNombre());
                $dep=new departamento_1($reg->iddep);
                array_push($this->departamento,$dep->getDescripcion()); 
                array_push($this->fechaaplica, $reg->fechaaplica);
            }
        }
    }
    
    function getId() { return $this->id; }
    function getFecha() { return $this->fecha; }
    function getEmpleado() { return $this->empleado; }
    function getDepartamento() { return $this->departamento; }
    function getIdemp() { return $this->idemp; }
    function getIddep() { return $this->iddep; }
    function getFechaaplica() { return $this->fechaaplica; }
    function getMaxRegistros() {
        return $this->maxregistros;
    }    
    
}