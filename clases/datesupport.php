<?php
/*
 * Created on 23/04/2009
 * Filename: datesupport.php
 * Author: Gustavo
 */

class datesupport {
   /*
    * convertFechaAct
    * 
    * Conviente la fecha del formato normal (dd/mm/yyyy) al MySql (aaaa-mm-dd)
    * 
    * @param fec fecha en formato dd/mm/aaaa
    * @return fec fecha en formato aaaa-mm-dd
    * 
    */
  function convertFechaAct($fec) {
    list( $day, $month, $year ) = split( '[/.-]', $fec );
    $dffin=$year."-".$month."-".$day;
    if ($dffin=="--")
      $dffin="";
    
    return $dffin;
   }
   
   /*
    * getFechaSQL
    * 
    * Conviente la fecha del formato normal (dd/mm/yyyy) al MySql (aaaa-mm-dd)
    * 
    * @param fec fecha en formato dd/mm/aaaa
    * @return fec fecha en formato aaaa-mm-dd
    * 
    */
  function getFechaSQL($fec) {
    //list( $day, $month, $year ) = split( '[/.-]', $fec );
      //echo "fec: $fec<br>";
      if($fec!="") {
          $afec = explode( '/', $fec );
          $day=$afec[0];
        $month=$afec[1];
        $year=$afec[2];
        $dffin=$year."-".$month."-".$day;
        if ($dffin=="--")
            $dffin="";
      } else
          $dffin="";
    
    return $dffin;
  }
   
   
   /*
    * convert2Fecha
    * 
    * Conviente la fecha del formato MySql (aaaa-mm-dd) al normal (dd/mm/aaaa)
    * 
    * @param fec fecha en formato aaaa-mm-dd
    * @return fec fecha en formato dd/mm/aaaa
    * 
    */
   function conver2Fecha($fec) {
     if(strlen($fec>8)) {
       //list($year,$month,$day) = split ('-',$fec);
       $afec = explode( '-', $fec );
       $day=$afec[2];
       $month=$afec[1];
       $year=$afec[0];
       
       $dffin=$day."/".$month."/".$year;
     } else
       $dffin="";
     return $dffin;
   } 
   
   function IsValidDate($fec) {
     if (strlen($fec)>=8) {
      //list( $day, $month, $year ) = split( '[/.-]', $fec );
      $afec = explode( '/', $fec );
      $day=$afec[0];
      $month=$afec[1];
      $year=$afec[2];
      
       if (checkdate($month,$day,$year))
         $ret=1;
       else
         $ret=0;
       //echo $fec."<br>".$day."/".$month."/".$year."<br>";
     } else {
       $ret=0;
     }
     return $ret;
   }
   
   function getMonth($fec) {
     list($year,$month,$day) = split ('-',$fec);
     return $month;
   }
   
   function getFechaHoraNormal($fec) {
     if(strlen($fec)>=19 && $fec!="0000-00-00 00:00:00") {
       $nfec=date("d/m/Y H:i",strtotime($fec));
     } else {
       $nfec="";
     }
     return $nfec;
   }
   
   function getFechaNormal($fec) {
     if(strlen($fec)>=19 && $fec!="0000-00-00 00:00:00")
       $nfec=date("d/m/Y",strtotime($fec));
     else
       $nfec="";
     return $nfec;
   }
   
   function getFechaDDMM($fec) {
     if(strlen($fec)>=19 && $fec!="0000-00-00 00:00:00")
       $nfec=date("d/m",strtotime($fec));
     else
       $nfec="";
     return $nfec;
   }   
   
   function getHoraNormal($hora) {
     if(strlen($hora)>=19 && substr($hora,0,4)!="0000")
       $nhora=date("H:i",strtotime($hora));
     else
       $nhora="";
     return $nhora;
   }
   
   function setFechaHoraMySql($fec, $hor) {
     if($fec=="")
       $dffin="";
     else {
      list( $day, $month, $year ) = split( '[/.-]', $fec );
      $dffin=$year."-".$month."-".$day;
      if ($dffin=="--")
        $dffin="";
     }
     
     if($dffin!="") {
       if(strlen($hor)==5)
         $dffin.=" $hor:00";
       else
         $dffin.=" ".date("H:i:")."00";
     }
     return $dffin;
   }
   
  function getFechaMasDias($fecha,$dias) {  
    list ($dia,$mes,$ano)=explode("-",$fecha);  
    if (!checkdate($mes,$dia,$ano)){return false;}  
    $dia=$dia+$dias;  
    $fecha=date( "d-m-Y", mktime(0,0,0,$mes,$dia,$ano) );  
    return $fecha;  
  }     

  function getFechaDif($fecha1,$fecha2,$unidad) {
//    echo "$fecha1<br>$fecha2<br>";
    $timestamp1=strtotime($fecha1);
    $timestamp2=strtotime($fecha2);
    $segundos_diferencia = $timestamp2 - $timestamp1; 
    switch($unidad) {
      case "d":
        $diferencia = $segundos_diferencia / (60 * 60 * 24); 
        break;
      case "m":
        $diferencia = $segundos_diferencia / (60 * 60 * 24 * 30);
        break;
    }
    
    return number_format($diferencia,0,".","");
    
  }       
  
  function getFechaMasMes($fec,$meses) {
    //echo "$fec  $meses<br>";
    list ($ano,$mes,$dia)=explode('-',$fec); 
    for($n=1; $n<=$meses; $n++) {
      $mes++;
      if($mes==13) {
        $mes=1;
        $ano++;
      }
    }
    //echo "$ano<br>$mes<br>$dia<br>";
    $fechanueva=date("Y-m-d",mktime(0,0,0,$mes,$dia,$ano));
    $nfec=$ano."-".$mes."-".$dia;
    //echo $nfec;
    //$fechanueva=date("Y-m-d",strtotime($nfec));
    return $nfec;
  }
  
  function getFechaNormalCorta($fec) {
     if(strlen($fec)>=10 && $fec!="0000-00-00")
       $nfec=date("d/m/Y",strtotime($fec));
     else
       $nfec="";
     return $nfec;    
  }
  
  function getFechamas1($fec,$sep) {
    $a_fec=explode($sep,$fec);
    if($sep=="/") {
      $dia=$a_fec[0];
      $mes=$a_fec[1];
      $ano=$a_fec[2];
    } else {
      $dia=$a_fec[2];
      $mes=$a_fec[1];
      $ano=$a_fec[0];
    }
    if($mes==1 or $mes==3 or $mes==5 or $mes==7 or $mes==8 or $mes==10 or $mes==12)
      $diamax=31;
    if($mes==4 or $mes==6 or $mes==9 or $mes==11)
      $diamax=30;
    if($mes==2) {
      if((int)($ano/4)==$ano/4)
        $diamax=29;
      else
        $diamax=28;
    }
    $dia++;
    if($dia>$diamax) {
      $dia=1;
      $mes++;
      if($mes>12) {
        $mes=1;
        $ano++;
      }
    }
    if(strlen($dia)<2)
      $dia="0".$dia;
    if(strlen($mes)<2)
      $mes="0".$mes;
    if($sep=="/")
      $fec=$dia."/".$mes."/".$ano;
    else
      $fec=$ano."-".$mes."-".$dia;
    return $fec;
  }
  
  function getFechaProxMes($fec, $sep) {
  	$a_fec=explode($sep,$fec);
    if($sep=="/" or $sep==".") {
      $dia=$a_fec[0];
      $mes=$a_fec[1];
      $ano=$a_fec[2];
    } else {
      $dia=$a_fec[2];
      $mes=$a_fec[1];
      $ano=$a_fec[0];
    }
    $mes++;
    if($mes>12) {
    	$mes=1;
    	$ano++;
    }
    if($mes==1 or $mes==3 or $mes==5 or $mes==7 or $mes==8 or $mes==10 or $mes==12)
      $diamax=31;
    if($mes==4 or $mes==6 or $mes==9 or $mes==11)
      $diamax=30;
    if($mes==2) {
      if((int)($ano/4)==$ano/4)
        $diamax=29;
      else
        $diamax=28;
    }
    if(strlen($mes)<2)
    	$mes="0".$mes;
    if($dia>$diamax)
    	$dia=$diamax;
    if($sep=="/" or $sep==".")
      $fec=$dia.$sep.$mes.$sep.$ano;
    else
      $fec=$ano.$sep.$mes.$sep.$dia;
    return $fec;
    
  	
  }
  
  function getDiasemana($ndia) {
  	switch($ndia) {
  		case 0:
  			$ret="Domingo";
  			break;
  		case 1:
  			$ret="Lunes";
  			break;
  		case 2:
  			$ret="Martes";
  			break;
  		case 3:
  			$ret="Miercoles";
  			break;
  		case 4:
  			$ret="Jueves";
  			break;
  		case 5:
  			$ret="Viernes";
  			break;
  		case 6:
  			$ret="Sabado";
  			break;
  		default:
  			$ret="";
  			break;
  	}
  	return $ret;
  }
  
  function getNombremes($nmes) {
  	$ret="";
  	switch($nmes) {
  		case 1;
  			$ret="Enero";
  			break;
  		case 2;
  			$ret="Febrero";
  			break;
  		case 3;
  			$ret="Marzo";
  			break;
  		case 4:
  			$ret="Abril";
  			break;
  		case 5:
  			$ret="Mayo";
  			break;
  		case 6:
  			$ret="Junio";
  			break;
  		case 7:
  			$ret="Julio";
  			break;
  		case 8:
  			$ret="Agosto";
  			break;
  		case 9:
  			$ret="Septiembre";
  			break;
  		case 10:
  			$ret="Octubre";
  			break;
  		case 11:
  			$ret="Noviembre";
  			break;
  		case 12:
  			$ret="Diciembre";
  			break;
  		
  	}
  	return $ret;
  }
  
  function getCadenaFecha($fec) {
  	$cad="";
  	$cad=date("d")." de ".strtolower($this->getNombremes(date("m")))." de ".date("Y");
  	return $cad;
  }
  
    function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
       
       switch( $str_interval){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }
  
      
}

?>
