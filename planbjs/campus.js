/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function cargarcursos(centro) {
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxcargarcursos.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            var obj1 = document.getElementById("idcur");
            for (var i=0; i<obj1.options.length; i++) {
                obj1.removeChild(obj1.firstChild);
            }
            
            cantidad=datos.childNodes[0].firstChild.data;
        
            for(i=0;i<=cantidad;i++) {
                elem=datos.childNodes[i+1].firstChild.data;
                cadena=elem.split('|');
                obj1.options[i]=new Option(cadena[1], cadena[0]);
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&centro="+centro);
}

