<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
  <link rel="stylesheet" href="css/jquery-ui.css">
  <!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
  <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>

    <script src="js/polyfiller.js"></script>
    <script>
        webshims.setOptions('forms-ext', {types: 'date'});
        webshims.polyfill('forms forms-ext');
    </script>

  
<style>
  .toggler {
    width: 500px;
    height: 100%;
    left: 50%;
    margin-left: 150px;
  }
  #effect {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  #button {
    padding: .5em 1em;
    text-decoration: none;
  }

  .listado {
    width: 960px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #listadoe {
    position: relative;
    width: 945px;
    height: 100%;
    padding: 0.4em;
  }
  #listadoe h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  .panel1 {
    width: 400px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel1 {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel1 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panel2 {
    width: 400px;
    height: 100%;
    left: 50%;
    margin-left: 420px;
  }
  #effect-panel2 {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel2 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panel960 {
    width: 960px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel960 {
    position: relative;
    width: 945px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel960 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  .panel910 {
    width: 910px;
    height: 100%;
    left: 50%;
    margin-left: 10px;
  }
  #effect-panel910 {
    position: relative;
    width: 910px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel910 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  .panel700 {
    width: 700px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel700 {
    position: relative;
    width: 688px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel700 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  .panel700c {
    width: 700px;
    height: 100%;
    left: 50%;
    margin-left: 130px;
  }
  #effect-panel700c {
    position: relative;
    width: 688px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel700c h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  
  .panel600 {
    width: 650px;
    height: 100%;
    left: 50%;
    margin-left: 10px;
  }
  #effect-panel600 {
    position: relative;
    width: 650px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel600 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panel500L {
    width: 500px;
    height: 100%;
    left: 50%;
    margin-left: 10px;
  }
  #effect-panel500L {
    position: relative;
    width: 500px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel500L h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  
  .panel500 {
    width: 500px;
    height: 100%;
    left: 50%;
    margin-left: 150px;
  }
  #effect-panel500 {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel500 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panel400 {
    width: 400px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel400 {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel400 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  

  .panel400R {
    width: 400px;
    height: 100%;
    left: 50%;
    margin-left: 200px;
  }
  #effect-panel400R {
    position: relative;
    width: 400px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel400R h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  
  .panel200 {
    width: 200px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel200 {
    position: relative;
    width: 200px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel200 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panel280 {
    width: 280px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panel300 {
    position: relative;
    width: 280px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panel300 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  
  .panelmax {
    width: <?= $_SESSION["anchopantalla"]?>px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panelmax {
    position: relative;
    width: <?= $_SESSION["anchopantalla"]?>px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panelmax h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }

  .panelmax910 {
    width: <?= $_SESSION["anchopantalla"]?>px;
    height: 100%;
    left: 50%;
    margin-left: 0px;
  }
  #effect-panelmax910 {
    position: relative;
    width: <?= $_SESSION["anchopantalla"] -20?>px;
    height: 100%;
    padding: 0.4em;
  }
  #effect-panelmax910 h3 {
    margin: 0;
    padding: 0.4em;
    text-align: center;
  }
  

</style>
  <script>
  $(function() {
    // run the currently selected effect
    function runEffect() {
      // get effect type from
      var selectedEffect = $( "#effectTypes" ).val();
 
      // most effect types need no options passed by default
      var options = {};
      // some effects have required parameters
      if ( selectedEffect === "scale" ) {
        options = { percent: 0 };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: 200, height: 60 } };
      }
 
      // run the effect
      $( "#effect" ).toggle( selectedEffect, options, 500 );
    };
 
    // set effect from select menu value
    $( "#button" ).click(function() {
      runEffect();
      return false;
    });
  });
  </script>  
  
  <script>
  $(function() {
    $( "#accordion" ).accordion(( "option", "active", 0 ));
// getter
    var active = $( "#accordion" ).accordion( "option", "active" );
 
// setter
    $( "#accordion" ).accordion( "option", "active", 0 );  });
  </script>
  <style>
  #resizable { width: 150px; height: 150px; padding: 0.5em; }
  #resizable h3 { text-align: center; margin: 0; }
  </style>
  <script>
  $(function() {
    $( "#resizable" ).resizable();
  });
  </script>
  <script>
  $(function() {
    $( "#dialog" ).dialog();
  });
  </script>
  <script>
  $(function() {
    $( "#radio" ).buttonset();
  });
  
   
  </script>
  
<style>
.ui-menu { 
overflow: hidden;
font: 13px Arial;
z-index:100;
}
.ui-menu .ui-menu {
overflow: visible !important;
}
.ui-menu > li { 
float: left;
display: block;
width: auto !important;
}
.ui-menu ul li {
display:block;
float:none;
}
.ui-menu ul li ul {
left:120px !important;
width:100%;
}
.ui-menu ul li ul li {
width:auto;
}
.ui-menu ul li ul li a {
float:left;
}
.ui-menu > li {
margin: 5px 5px !important;
padding: 0 0 !important;
}
.ui-menu > li > a { 
float: left;
display: block;
clear: both;
overflow: hidden;
}
.ui-menu .ui-menu-icon { 
margin-top: 0.3em !important;
}
.ui-menu .ui-menu .ui-menu li { 
float: left;
display: block;
}
</style>

<script>
$(function () {
$("#menu").menu({position: {at: "left bottom"}});;
});

</script>
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>  



