<?php
/*
 * creado el 06/12/2016 10:24:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_opg3
 */

class adm_opg3_1 {
    var $id=0;
    var $centro=0;
    var $idop=0;
    var $detalle='';
    var $importecancelado=0;
    var $importetotal=0;

    function __construct($id,$conn="0") { 
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql='select * from adm_opg2 where id='.$id;
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idop=$reg->idop;
        $this->idcom=$reg->idcom;
        $this->importecancelado=$reg->importecancelado;
        $com=new adm_com_1($reg->idcom, $conn);
        $this->importetotal=$com->getTotaltotal();
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdop() {
        return $this->idop;
    }

    function getImportecancelado() {
        return $this->importecancelado;
    }
    
    function getImportetotal() {
        return $this->importetotal;
    }

}

class adm_opg3_2 {
    var $id=array();
    var $centro=array();
    var $idop=array();
    var $importetotal=array();
    var $importecancelado=array();
    var $fecha=array();
    var $comprobante=array();
    var $idcom=array();
    var $maxregistros=0;

    function __construct($ssql,$conn="0") { 
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
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
                array_push($this->idop,$reg->idop);
                array_push($this->importecancelado,$reg->importecancelado);
                $com=new adm_com_1($reg->idcom, $conn);
                array_push($this->importetotal,$com->getTotaltotal());
                array_push($this->fecha,$com->getFecha());
                array_push($this->comprobante,$com->getComprobantetodo());
                array_push($this->idcom,$com->getId());
            }
        }
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdop() {
        return $this->idop;
    }

    function getImportecancelado() {
        return $this->importecancelado;
    }

    function getImportetotal() {
        return $this->importetotal;
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getComprobante() {
        return $this->comprobante;
    }
    
    function getIdcom() {
        return $this->idcom;
    }

}
