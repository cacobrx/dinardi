<?php
/*
 * Creado el 15/02/2021 10:39:51
 * Autor: gus
 * Archivo: elaasados.php
 * planbsistemas.com.ar
 */

class envasados {
    var $articulo=array();
    var $kilos=array();
    var $cantidad=array();  
    var $descripcion=array();
    
    function __construct($fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();   
        $xart=array();
        $xkil=array();
        $xdes=array();
        $xcan=array();        
                                
        $ssql="select adm_env.*, adm_art.descripcion from adm_env inner join adm_art on adm_env.idart=adm_art.id where adm_env.fechaing>='$fechaini' and adm_env.fechaing<='$fechafin'";
//        echo $ssql."<br>"; 
        $rs=$conx->consultaBase($ssql, $conn); 
        while($reg= mysqli_fetch_object($rs)) {  
            $search= array_search($reg->idart, $xart);
            if($search===false) {
                array_push($xart,$reg->idart);
                array_push($xdes,$reg->descripcion);
                array_push($xkil,$reg->kilos);
                array_push($xcan,$reg->cantidad);
            } else {
                $xkil[$search]+=$reg->kilos;
                $xcan[$search]+=$reg->cantidad;
                $xdes[$search]=$reg->descripcion;
            }
        }
        $this->descripcion=$xdes;
        $this->cantidad=$xcan;
        $this->kilos=$xkil;
        $this->idart=$xart;//  
    }
    
    function getIdart() { return $this->idart; }
    function getDescripcion() { return $this->descripcion; }
    function getKilos() { return $this->kilos; }
    function getCantidad() { return $this->cantidad; }
}