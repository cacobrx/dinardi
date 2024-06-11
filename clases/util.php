<?php
class util {
    function getNombremes($mes,$tipo) {
        $mes--;
        switch($tipo) {
            case 1:
                $a_mes=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                break;
            case 2:
                $a_mes=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                break;
            case 3:
                $a_mes=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        }
        return $a_mes[$mes];
    }
    
    function getNumeroRec($tipocontabilidad, $centro) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_rec1 where tipocontabilidad=$tipocontabilidad and centro=$centro order by numero desc";
        //echo $ssql."<br>";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $nro=$reg->numero;
            
        } else
            $nro=0;
        $nro++;
        return $nro;
    }
    
  function getSqlcuenta0($codigo, $centrosel, $arc, $conn) {
      require_once 'clases/conexion.php';
      $conx=new conexion();
      $codigosincero="";
      for($ii=0;$ii<strlen($codigo);$ii++) {
          if(substr($codigo,$ii,1)!="0")
            $codigosincero.=substr($codigo,$ii,1);
      }
      //echo strlen($codigosincero)."<br>";
      $ssql="select * from adm_cta where left(codigo,".strlen($codigosincero).")='$codigosincero' and centro=$centrosel";
      //echo $ssql."<br>";
      $rs=$conx->consultaBase($ssql, $conn);
      $condicion="";
      while($reg=mysqli_fetch_object($rs)) {
          $condicion.="$arc.idcta=".$reg->id." or ";
      }
      if($condicion!="")
          $condicion=substr($condicion,0,strlen($condicion)-4);
      return $condicion;
  }
  
    function getNumeroOpg($idemp) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_opg1 where idemp=$idemp order by numero desc";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $nro=$reg->numero;
            
        } else
            $nro=0;
        $nro++;
        return $nro;
    }

    function getNumeroOpgAdj($idemp) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_opg1 where idemp=$idemp order by numeroadj desc";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $nro=$reg->numeroadj;
            
        } else
            $nro=0;
        $nro++;
        return $nro;
    }

    function getNumeroOpf($idemp) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_opf1 where idemp=$idemp order by numero desc";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $nro=$reg->numero;
            
        } else
            $nro=0;
        $nro++;
        return $nro;
    }

    function getNumeroOpfAdj($idemp) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_opf1 where idemp=$idemp order by numeroadj desc";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $nro=$reg->numeroadj;
            
        } else
            $nro=0;
        $nro++;
        return $nro;
    }
  
    
        
	
}