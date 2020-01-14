$(document).ready(inicializarEventos);  

  function inicializarEventos(){
    if ($(window).width() < 600) {
      cambiarMenu();
      maquetarFicheros();
      maquetarUsuarios();
    }
    $('#deshabilitado').attr('disabled',true);
    $('#Modificar').click(function(){
      $('#deshabilitado').attr('disabled',false);
    });
  

    $("a[title='DESCARGAR']").mouseover(opcionDescarga);
    $("a[title='DESCARGAR']").mouseout(quitarAmpliacion);
  
    
    $(".grid-item").hover(function(){
    $(this).css("background-color", "rgba(200, 200, 200, 0.8)");
    $(this).css("color", "rgb(255, 0, 0)");
    }, function(){
    $(this).css("background-color", "rgba(255, 255, 255, 0.8)");
    $(this).css("color", "rgb(0, 0, 0)");
  });

    $(".grid-item").hover(function(){
      $(this).css("background-color", "rgba(200, 200, 200, 0.8)");
      $(this).css("color", "rgb(255, 0, 0)");
      }, function(){
      $(this).css("background-color", "rgba(255, 255, 255, 0.8)");
      $(this).css("color", "rgb(0, 0, 0)");
    });

    $(window).resize(function(){
        location.href = location.href;     
    });

    $("img").hover(function(){
      $(this).css("width", "3vw");
      $(this).css("height", "6vh");
      }, function(){
        $(this).css("width", "2vw");
        $(this).css("height", "4vh");
    });

  }

  function opcionDescarga(){
    $(this).css("font-size", "1.5em");
  }
  function quitarAmpliacion(){
    $(this).css("font-size", "1em");
  }

  function cambiarMenu(){
        $("<select  class='form-control' id='menu'/>").appendTo("nav");
        $("<option/>", {
        "selected": "selected",
        "value"   : "",
        "text"    : "MENÚ"
        }).appendTo("nav select");

        $("nav a").each(function() {
        var el = $(this);
        $("<option />", {
            "value"   : el.attr("href"),
            "text"    : el.text()
        }).appendTo("nav select");
        });

        $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
        });
    }

    function maquetarFicheros(){
      $(".grid-item-cabecera").css("font-size", "0.7em");
      $(".grid-cabecera-ficheros").css("grid-template-columns",  "42vw 48vw");
      $(".grid-cabecera-ficheros").css("margin-top","-8vh");
      $(".grid-cabecera-ficheros").css("margin-left", "-4vw");
      $(".grid-item-cabecera").css("padding-top","2vh");
      $(".grid-ficheros").css("grid-template-columns",  "42vw 16vw 16vw 16vw 15vw 15vw 15vw");
      $(".grid-ficheros").css("height", "70vh");
      $(".grid-ficheros").css("width", "90vw");
      $(".grid-ficheros").css("padding-left", "0");
      $("#titulo").css("font-size", "2em");
      $("span").css("display", "none");
      $("h2").css("display", "none");
      $(".grid-item").css("height","8vh");
      $(".grid-item").css("padding-top","2vh");
      $("#cabTipo").css("display", "none");
      $("#cabFecha").css("display", "none");
      $("#cabTamaño").css("display", "none");
      $(".icono").css("width","6vw");
      $("#container").css("margin", "0");
      $("#container").css("width", "100vw");
      //$("#container").css("height", "100vh");
      $(".grid-ficheros").css("margin-left", "-4vw");
      $(".grid-ficheros").css("margin-right", "0vw");
     
    }
    function maquetarUsuarios(){
      $(".grid-cabecera-usuarios").css("grid-template-columns",  "42vw 48vw");
      $(".grid-cabecera-usuarios").css("margin-top","1vh");
      $(".grid-cabecera-usuarios").css("margin-left", "1vw");
      $(".container-usuarios").css("grid-template-columns",  "42vw 16vw 16vw 16vw");
      $(".container-usuarios").css("height", "70vh");
      $(".container-usuarios").css("width", "90vw");
      $(".container-usuarios").css("padding-left", "0");
      $("#CabId").css("display", "none");
      $("#CabCorreo").css("display", "none");
      $("#CabPlan").css("display", "none");
      $(".icono").css("width","6vw");
      $("#CabEstado").css("display", "none");
      $(".container-usuarios").css("margin-left", "1vw");
      $(".container-usuarios").css("margin-right", "0vw");
    }

 



    

