<?php 
  
  // Cargamos los controladores..
  require_once 'Controladores/UsuariosCtrl.php';

  // Definimos que la aplicacon es de tipo JSON
  header ('content-type: application/json; charset=utf-8');

  //Permitimos el acceso a todos los clientes
  header('Access-Control-Allow-Origin: *');

  //Permitimos que los clientes utlicen post
  header ('Access-Control-Allow-Methods: POST');
  
  $respuesta;
  $instancia;
  
  if(isset($_GET['PATH_INFO'])){
  	// Convierte de string a array
  	$peticion = explode('/',$_GET['PATH_INFO']);
  	$recurso = array_shift($peticion);
  	$recursos_exitentes = array(
      'Usuarios_r'
  	);
  	if(in_array($recurso, $recursos_exitentes)){
  		$metodo = strtolower($_SERVER['REQUEST_METHOD']);
        if ($metodo === 'post'){
          switch ($recurso) {
          	case 'Usuarios_r':
          		$instancia = new Usuarios_r($peticion);
          		break;
          }
          $respuesta = $instancia->respuesta;
        } else {
        	$respuesta = array(
               'estado' => 2,
               'mensaje' => 'No se reconoce el metodo'
               
        	);
        }
  	} else {
  		$respuesta = array(
               'estado' => 2,
               'mensaje' => 'No se reconoce el recurso'
        	);
  	}
  } else {
  	$respuesta = array(
               'estado' => 2,
               'mensaje' => 'No se reconoce el peticion'
        	);
  }

   echo json_encode($respuesta);

?>