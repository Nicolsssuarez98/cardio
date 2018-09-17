var ControlUsers = false;
var ControlHiper = false;

var UsuarioActual = jQuery.parseJSON(sessionStorage.getItem('user'));

$('#ControlPanelUser').click(function(event) {
  if(!ControlUsers){
    $('#n_img').addClass('hidden');
    listarUsers();
    ControlUsers = true;
  }else{
    ControlUsers = false;
  }
});

$('#ControlPanelHipertensionArterial').click(function(event) {
      
  if(!ControlHiper){
    $('#n_img').addClass('hidden');
    listarHipers();
    ControlHiper= true;
  }else{
    ControlHiper = false;
  }
});


jQuery(document).ready(function(){
  $(".oculto").hide();              
    $(".inf").click(function(){
          var nodo = $(this).attr("href");  
 
          if ($(nodo).is(":visible")){
               $(nodo).hide();
               return false;
          }else{
        $(".oculto").hide("slow");                             
        $(nodo).fadeToggle("fast");
        return false;
          }
    });
});


$('#CerrarSesion').click(function(event) {
  sessionStorage.removeItem('user');
  Recargar('../PanelControl');
});


