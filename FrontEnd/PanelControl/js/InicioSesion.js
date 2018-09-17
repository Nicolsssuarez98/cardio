var UsuarioActual = jQuery.parseJSON(sessionStorage.getItem('user'));

$('#IniciarSesion').click(function(event){
  event.preventDefault();
  //console.log('entramos');
  alerta = '';
  data = {
    usuario : $('#usuario').val(),
    clave : $('#clave').val()
  };

  $.post('../../ApiREST/Usuarios_r/Logear',
    {datos: data},function(res){
        if(res.estado == 1){
            sessionStorage.setItem('user',JSON.stringify(res.usuario));
            Recargar('../panelControl');
        } else {
            alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
            alerta += '<button type="button" class="close" data-dismiss="alert"'; 
            alerta += 'aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            alerta += res.mensaje+'</div>';           
        }
        $('#alertas').html('');
        $('#alertas').append(alerta);
    }
    );
});

$('#CrearNuevoUser').click(function(event) {
    event.preventDefault();
  if(!($('#user').val() == '' || $('#passs').val() == '' )){
    alerta = '';
    data = {
      usuario : $('#user').val(),
      clave : $('#passs').val(),
      estado : $('#estado').val(),
      rol : $('#rol').val()
    }
    $.post('../../ApiREST/Usuarios_r/Registrar', 
      {datos: data}, 
      function(data) {
        if(data.estado == 1){
          alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
        }else{
          alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
        }

        $('#alertass').html(alerta);
      }
    );
    return false;
  }
});

