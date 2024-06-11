<?
/*
 *Created on 18/10/11 - 15:06:32
 *Author: Gustavo
 *File: ciudades.php
 */

class ciudades_1 {
    var $id=0;
    var $ciudad='';
    var $cpostal='';
    var $provincia=0;
    var $centro=0;
    var $zona=0;
    var $zonades='';
    var $abreviado='';
    var $provinciades="";

    function __construct($id,$conn="0") { 
  	if($id!=0) {
	    require_once 'clases/conexion.php';
	    $conx=new conexion();
            if($conn=="0")
                $conn=$conx->conectarBase ();
	    $ssql='select * from ciudades where id='.$id;
	    $rs=$conx->consultaBase($ssql, $conn);
	    $reg=mysqli_fetch_object($rs);
	    $this->id=$reg->id;
	    $this->ciudad=$reg->ciudad;
	    $this->cpostal=$reg->cpostal;
	    $this->provincia=$reg->provincia;
	    $this->centro=$reg->centro;
            $this->zona=$reg->zona;
            $this->abreviado=$reg->abreviado;
            $this->zonades=$conx->getTextoValorA($reg->zona, "ZON",$conn);
            $this->provinciades=$conx->getTextoValorA($reg->provincia, "PRO",$conn);
  	}
    }

    function getId() {
      return $this->id;
    }

    function getCiudad() {
      return $this->ciudad;
    }

    function getCpostal() {
      return $this->cpostal;
    }

    function getProvincia() {
      return $this->provincia;
    }

    function getCentro() {
      return $this->centro;
    }

    function getZona() {
        return $this->zona;
    }

    function getZonades() {
        return $this->zonades;
    }

    function getAbreviado() {
        return $this->abreviado;
    }

    function getProvinciades() {
        return $this->provinciades;
    }
    

}


class ciudades_2 {
    var $id=array();
    var $ciudad=array();
    var $cpostal=array();
    var $provincia=array();
    var $provinciades=array();
    var $centro=array();
    var $zona=array();
    var $zonades=array();
    var $abreviado=array();
    var $centrodes=array();
    var $maxregistros=0;

    function __construct($ssql,$conn="0") { 
        require_once 'clases/conexion.php';
        require_once 'clases/centro.php';
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
                array_push($this->ciudad,$reg->ciudad);
                array_push($this->cpostal,$reg->cpostal);
                array_push($this->provincia,$reg->provincia);
                array_push($this->centro,$reg->centro);
                array_push($this->zona,$reg->zona);
                array_push($this->abreviado,$reg->abreviado);
                array_push($this->zonades,$conx->getTextoValorA($reg->zona, "ZON",$conn));
                array_push($this->provinciades,$conx->getTextoValorA($reg->provincia,"PRO",$conn));
                $ctr=new centro_1($reg->centro,$conn);
                array_push($this->centrodes, $ctr->getNombre());
            }
        }
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getId() {
        return $this->id;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getCpostal() {
        return $this->cpostal;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getCentro() {
        return $this->centro;
    }

    function getProvinciades() {
        return $this->provinciades;
    }

    function getZona() {
        return $this->zona;
    }

    function getZonades() {
        return $this->zonades;
    }

    function getAbreviado() {
        return $this->abreviado;
    }

    function getCentrodes() {
        return $this->centrodes;
    }
  

}
?>
