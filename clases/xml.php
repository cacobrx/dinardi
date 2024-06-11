<?php
/*
 * Created on 24/03/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class xml {
 	function parseXML($filename) {
 		if (file_exists($filename)) {
 			$xml=simplexml_load_file($filename);
 			// esta orden muestra el resultado de xml
 			//var_dump($xml);
			return $xml; 			
 		} else {
 			echo $filename;
 			exit("Error al abrir el archivo XML");
 		}
 	}
 }
?>
