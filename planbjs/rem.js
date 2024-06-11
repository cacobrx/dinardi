/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function setseleccionrem(val, s) {
    var ajax = ajaxobj();
    //sel="sel" + i;
    ajax.open("POST", "ajaxseleccionrem.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            ret=datos.childNodes[0].firstChild.data;
//            alert(ret);
//            if(ret==1)
//                document.getElementById(sel).className="far fa-check-square";
//            else
//                document.getElementById(sel).className="far fa-square";
                
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&s="+s);
    
}

function save_rem(val, indice) {
    var ajax = ajaxobj();
    sel="controlado" + indice;
    ajax.open("POST", "ajaxsaverem.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            ret=datos.childNodes[0].firstChild.data;
//            alert(ret);
            if(ret==1)
                document.getElementById(sel).style.color="green";
            else
                document.getElementById(sel).style.color="red";
//                document.getElementById(sel).className="far fa-check-square";
//            else
//                document.getElementById(sel).className="far fa-square";
                
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}
