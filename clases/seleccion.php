<?php
/*
 * creado el 16 ago. 2023 15:51:31
 * Usuario: gus
 * Archivo: seleccion
 */

class articulossel {
    var $id=array();
    var $nombre=array();
    var $cadena="";
    
    function __construct($cad, $conn="0") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_art";
        $cantidad=$conx->getCantidadRegA($ssql, $conn);
        $xcad= explode("|", $cad);
        for($i=1;$i<count($xcad)-1;$i++) {
            $ssql="select * from adm_art where id=".$xcad[$i];
            $raa=$conx->consultaBBase($ssql, $conn);
            array_push($this->id,$xcad[$i]);
            array_push($this->nombre,$raa->descripcion);
            $this->cadena.=$raa->descripcion." | ";
        }
        
        if(count($xcad)==1)
            $this->cadena="*TODOS*";
        else {
            if($this->cadena!="") $this->cadena=substr($this->cadena,0,strlen($this->cadena)-3);
        }
    }
    
    function getId() {
        return $this->id;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function getCadena() {
        return $this->cadena;
    }
}

