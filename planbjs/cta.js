/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function verificarcuenta(val) {
    var ajax = ajaxobj();
    id=document.getElementById("id").value;
//    alert(id);
    ajax.open("POST", "ajaxverificarcuenta.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            ret=datos.childNodes[0].firstChild.data;
//            alert(datos.childNodes[1].firstChild.data);
            if(ret>0) {
                document.getElementById("cmdok").style.visibility = "hidden";
                document.getElementById("cartel").innerHTML="** EL CÓDIGO " + val + " YA EXISTE **";
            } else {
                document.getElementById("cmdok").style.visibility = "visible";
                document.getElementById("cartel").innerHTML="";
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&id="+id);
    
}