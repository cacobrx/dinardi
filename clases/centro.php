<?
/*
 *Created on 21/03/11 - 21:46:45
 *Author: Gustavo
 *File: edd_centro.php
 */

class centro_1 {
  var $id=0;
  var $nombre='';
  var $ciudad='';
  var $direccion='';
  var $responsable='';
  var $telefono='';
  var $email='';


  function __construct($id, $conn="0") { 
    require_once 'clases/conexion.php';
    $conx=new conexion();
    if($conn=="0")
        $conn=$conx->conectarBase ();
    $ssql='select * from centro where id='.$id;
//    echo $ssql."\n";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->nombre=$reg->nombre;
    $this->ciudad=$reg->ciudad;
    $this->direccion=$reg->direccion;
    $this->responsable=$reg->responsable;
    $this->telefono=$reg->telefono;
    $this->email=$reg->email;

  }

  function getId() {
    return $this->id;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getCiudad() {
    return $this->ciudad;
  }

  function getDireccion() {
    return $this->direccion;
  }

  function getResponsable() {
    return $this->responsable;
  }

  function getTelefono() {
    return $this->telefono;
  }
  
  function getEmail() {
  	return $this->email;
  }
  

  
}

class centro_2 {
  var $id=array();
  var $nombre=array();
  var $ciudad=array();
  var $direccion=array();
  var $responsable=array();
  var $telefono=array();
  var $email=array();
  var $maxregistros=0;

  function __construct($ssql, $conn="0") { 
    require_once 'clases/conexion.php';
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
        array_push($this->nombre,$reg->nombre);
        array_push($this->ciudad,$reg->ciudad);
        array_push($this->direccion,$reg->direccion);
        array_push($this->responsable,$reg->responsable);
        array_push($this->telefono,$reg->telefono);

        array_push($this->email,$reg->email);
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getCiudad() {
    return $this->ciudad;
  }

  function getDireccion() {
    return $this->direccion;
  }

  function getResponsable() {
    return $this->responsable;
  }

  function getTelefono() {
    return $this->telefono;
  }
  
  
  function getEmail() {
      return $this->email;
  }

}
?>
