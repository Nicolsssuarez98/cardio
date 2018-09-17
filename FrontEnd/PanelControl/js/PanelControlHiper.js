
function listarHipers(){
  $.post('../../ApiREST/Usuarios_r/ListarHiper',
    {datos: null},
    function(data) {
      if(data.estado == 1 || data.estado == 2){
        $('#hipers').html('');
        Usuarios = data.usuarios;
        $.each(Usuarios, function(index, val) {
          cade = '';
          cade += '<tr class="white">';
          cade += '<td>'+val.id_cedula+'</td>';
          cade += '<td>'+val.nombres+'</td>';
          cade += '<td>'+val.fec_realizacion_exa+'</td>';
          cade += '<td>'+val.cons_medico_general+'</td>';
          cade += '<td>'+val.cons_enfermeria+'</td>';
          cade += '<td>'+val.cons_nutricion+'</td>';
          cade += '<td>'+val.id_medicamento+'</td>';
                  
          
         
          cade += '<td class="edit" onclick="EditarHiper('+index+')"><center><span class="glyphicon glyphicon-pencil"></span></center></td>';

          cade += '<td class="edit" onclick="EliminarHiper('+index+')"><center><span class="glyphicon glyphicon-remove"></span></center></td>';
          
          cade +='</tr>';
          $('#hipers').append(cade);
        });
      }
    }
  );
}


function EliminarHiper(index){
  datos = {
    id_hiper_arterial : Usuarios[index].id_hiper_arterial,    
    id_cedula : Usuarios[index].id_cedula,
    fec_realizacion_exa : Usuarios[index].fec_realizacion_exa,
    cf_tensionales : Usuarios[index].cf_tensionales,
    tm_signos_vitales : Usuarios[index].tm_signos_vitales,
    cons_medico_general: Usuarios[index].cons_medico_general,
    cons_enfermeria: Usuarios[index].cons_enfermeria,
    cons_nutricion: Usuarios[index].cons_nutricion,
    glicemia_basal: Usuarios[index].glicemia_basal,
    hemoglobin: Usuarios[index].hemoglobin,
    hematocritos: Usuarios[index].hematocritos,
    colesterol_total: Usuarios[index].colesterol_total,
    colesterol_hdl: Usuarios[index].colesterol_hdl,
    trigliceridos: Usuarios[index].trigliceridos,
    potasio: Usuarios[index].potasio,
    creatinina: Usuarios[index].creatinina,
    uroanalisis: Usuarios[index].uroanalisis,
    ekg: Usuarios[index].ekg,
    id_medicamento: Usuarios[index].id_medicamento,
    edu_grupal: Usuarios[index].edu_grupal,
    observaciones: Usuarios[index].observaciones,
    acciones_realizar: Usuarios[index].acciones_realizar
  }
  EliminarHipert(datos);
}

function EliminarHipert(datos){
  alerta = '';
  $.post('../../ApiREST/Usuarios_r/EliminarHiper', 
      {datos: datos}, 
      function(data) {
        if(data.estado == 1){
          console.log("entramos");
          alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
          listarHipers();
        }else{
          alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
        }
        $('#alertasss').html(alerta);
      }
    );
    return false;
}

$('#patologia').click(function(event){
  $.post('../../ApiREST/Usuarios_r/CargarHiper',
  {datos: null}, 
  function(data) {
  if(data.estado == 1){
    $('#documento').html('');      
    Usuarios = data.usuarios;
    $.each(Usuarios, function(index, val){
      cade = '';
      cade += '<option value="' + val.id_cedula+'">' + val.nombres + ' ' + val.apellidos + '</option>';
      $('#documento').append(cade);
    });
  }
  }
  );
});

  
  
  $('#agregarHiper').click(function(event) {
    $('#CrearNuevoHiper').removeClass('hidden');
    $('#EditarHiper').addClass('hidden');



  });
  
  $('#CancelarCrearHiper').click(function(event) {
    $('#CrearNuevoHiper').addClass('hidden');
  
  });

  $('#CancelarActualizarhiper').click(function(event) {
    $('#EditarHiper').addClass('hidden');
  });


  function EditarHiper(index){
    $('#EditarHiper').removeClass('hidden');
    $('#CrearNuevoHiper').addClass('hidden');
    

    
    $('#editid_hiper').val(Usuarios[index].id_hiper_arterial);
    $('#editdocumento').val(Usuarios[index].id_cedula);
    $('#editfecha').val(Usuarios[index].fec_realizacion_exa);
    $('#editcf_tensionales').val(Usuarios[index].cf_tensionales);
    $('#edittm_signos').val(Usuarios[index].tm_signos_vitales);
    $('#editconst_medic').val(Usuarios[index].cons_medico_general);
    $('#editconst_enf').val(Usuarios[index].cons_enfermeria);
    $('#editconst_nutri').val(Usuarios[index].cons_nutricion);
    $('#editglicemia').val(Usuarios[index].glicemia_basal);
    $('#edithemo').val(Usuarios[index].hemoglobin);
    $('#edithematocritos').val(Usuarios[index].hematocritos);
    $('#editcolesterol_total').val(Usuarios[index].colesterol_total);
    $('#editcolesterol_hdl').val(Usuarios[index].colesterol_hdl);
    $('#edittrigliceridos').val(Usuarios[index].trigliceridos);
    $('#editpotasio').val(Usuarios[index].potasio);
    $('#editcreatinina').val(Usuarios[index].creatinina);
    $('#edituroanalisis').val(Usuarios[index].uroanalisis);
    $('#editekg').val(Usuarios[index].ekg);
    $('#editmedicamentos').val(Usuarios[index].id_medicamento);
    $('#editedu_grupal').val(Usuarios[index].edu_grupal);
    $('#editobservaciones').val(Usuarios[index].observaciones);
    $('#editacciones_real').val(Usuarios[index].acciones_realizar);
  }

  
  $('#CrearNuevoHiper').submit(function(event) {
    alerta = '';
    data = {
      id_cedula : $('#documento').val(),
      fec_realizacion_exa: $('#fecha').val(),
      cf_tensionales: $('#cf_tensionales').val(),
      tm_signos_vitales: $('#tm_signos').val(),
      cons_medico_general: $('#const_medic').val(),
      cons_enfermeria: $('#const_enf').val(),
      cons_nutricion: $('#const_nutri').val(),
      glicemia_basal: $('#glicemia').val(),
      hemoglobin: $('#hemo').val(),
      hematocritos: $('#hema').val(),
      colesterol_total: $('#colesterol_total').val(),
      colesterol_hdl: $('#colesterol_hdl').val(),
      trigliceridos: $('#trigliceridos').val(),
      potasio: $('#potasio').val(),
      creatinina: $('#creatinina').val(),
      uroanalisis: $('#uroanalisis').val(),
      ekg: $('#ekg').val(),
      id_medicamento: $('#medicamentos').val(),
      edu_grupal: $('#edu_grupal').val(),
      observaciones: $('#observaciones').val(),
      acciones_realizar: $('#acciones_real').val()
    }
    $.post('../../ApiREST/Usuarios_r/RegistrarHiper', 
      {datos: data}, 
      function(data) {
        if(data.estado == 1){
          alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
          $('#CrearNuevoHiper').addClass('hidden');
          listarHipers();
         
        }else{
          alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
          alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          alerta += data.mensaje+'</div>';
        }

        $('#alertasss').html(alerta);
      }
    );
    return false;
  
});

$('#EditarHiper').submit(function(event) {
  
  alerta = '';
  datos = {
    id_hiper_arterial : $('#editid_hiper').val(),    
    id_cedula : $('#editdocumento').val(),
    fec_realizacion_exa: $('#editfecha').val(),
    cf_tensionales: $('#editcf_tensionales').val(),
    tm_signos_vitales: $('#edittm_signos').val(),
    cons_medico_general: $('#editconst_medic').val(),
    cons_enfermeria: $('#editconst_enf').val(),
    cons_nutricion: $('#editconst_nutri').val(),
    glicemia_basal: $('#editglicemia').val(),
    hemoglobin: $('#edithemo').val(),
    hematocritos: $('#edithema').val(),
    colesterol_total: $('#editcolesterol_total').val(),
    colesterol_hdl: $('#editcolesterol_hdl').val(),
    trigliceridos: $('#edittrigliceridos').val(),
    potasio: $('#editpotasio').val(),
    creatinina: $('#editcreatinina').val(),
    uroanalisis: $('#edituroanalisis').val(),
    ekg: $('#editekg').val(),
    id_medicamento: $('#editmedicamentos').val(),
    edu_grupal: $('#editedu_grupal').val(),
    observaciones: $('#editobservaciones').val(),
    acciones_realizar: $('#editacciones_real').val()
  }
 ActualizarHiper_arterial(datos);
 $('#EditarHiper').addClass('hidden');
  return false;

});

function ActualizarHiper_arterial(datos){
  alerta = "";
  $.post('../../ApiREST/Usuarios_r/ActualizarHiper',
  {datos: datos}, 
  function(data) {
    console.log(data)
    if(data.estado == 1){
      alerta = '<div class="alert alert-success alert-dismissible" role="alert">';
      alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
      alerta += data.mensaje+'</div>';
      $('#CrearNuevoHiper').addClass('hidden');
      listarHipers();
    }else{
      alerta = '<div class="alert alert-danger alert-dismissible" role="alert">';
      alerta += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
      alerta += data.mensaje+'</div>';
    }

    $('#alertasss').html(alerta);
  }
);
}

  
 