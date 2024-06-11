<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adm_rem_exp_det
 *
 * @author gus
 */

class adm_rem_exp_det_1 {
    var $id=0;
    var $centro=0;
    var $idrem=0;
    var $cantidad=0;
    var $descripcion="";
    var $kgsbrutos=0;
    var $kgsnetos=0;    


    function __construct($id,$conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_rem_exp_det where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->cantidad=$reg->cantidad;
        $this->descripcion=$reg->descripcion;
        $this->kgsbrutos=$reg->kgsbrutos;
        $this->kgsnetos=$reg->kgsnetos;
        $this->idrem=$reg->idrem;
    }

    function getId() {
        return $this->id;
    }
    
    function getIdrem() {
        return $this->idrem;
    }    

    function getCentro() {
        return $this->centro;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getKgsbrutos() {
        return $this->kgsbrutos;
    }

    function getKgsnetos() {
        return $this->kgsnetos;
    }    
  
}

class adm_rem_exp_det_2 {
    var $id=array();
    var $centro=array();
    var $cantidad=array();
    var $descripcion=array();
    var $kgsbrutos=array();
    var $kgsnetos=array();
    var $idrem=array();
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
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->descripcion,$reg->descripcion);
                array_push($this->kgsbrutos,$reg->kgsbrutos);
                array_push($this->kgsnetos,$reg->kgsnetos); 
                array_push($this->idrem,$reg->idrem);                
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdrem() {
        return $this->idrem;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getKgsbrutos() {
        return $this->kgsbrutos;
    }

    function getKgsnetos() {
        return $this->kgsnetos;
    }   

    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
?>