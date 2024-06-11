<?php
/*
 * Created on 05/08/2008 - 12:48:39
 * Author: Gustavo
 * File: globalson.php
 */

class globalson{
	function getGETPOST($variable) {
		if (array_key_exists($variable, $_GET)) {
  			$ret=$_GET[$variable];
		} else {
    		if (array_key_exists($variable, $_POST)) {
    		  	$ret=$_POST[$variable];
	    	} else {
      			$ret='';
    		}
		}
		return $ret;
	}
}
?>
