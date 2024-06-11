<?php
/*
 * creado el 05/09/2017 17:50:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_fis_cped
 */

class adm_fis_cped_1 {
    var $id=0;
    var $centro=0;
    var $idfis=0;
    var $idped=0;

    function __construct($id,$conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_fis_cped where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idfis=$reg->idfis;
        $this->idped=$reg->idped;
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdfis() {
        return $this->idfis;
    }

    function getIdped() {
        return $this->idped;
    }

}

class adm_fis_cped_2 {
    var $id=array();
    var $centro=array();
    var $idfis=array();
    var $idped=array();
    var $maxregistros=0;


    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
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
                array_push($this->centro,$reg->centro);
                array_push($this->idfis,$reg->idfis);
                array_push($this->idped,$reg->idped);
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdfis() {
        return $this->idfis;
    }

    function getIdped() {
        return $this->idped;
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
?>