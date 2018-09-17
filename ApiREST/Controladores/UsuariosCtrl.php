<?php 
  require_once 'Datos/conexion_db.php';

  class Usuarios_r {
    
    public $respuesta = null;

    function __construct($peticion){
      switch ($peticion[0]) {
        case 'Listar':
          return self::Listar($this);
          break;
        case 'Registrar':
          return self::Registrar($this);
          break;
        case 'Actualizar':
          return self::Actualizar($this);
          break;
        case 'Eliminar':
          return self::Eliminar($this);
          break;
        case 'Logear':
          return self::Logear($this);
          break;
        case 'ListarHiper':
          return self::ListarHiper($this);
          break;
        case 'RegistrarHiper':
          return self::RegistrarHiper($this);
          break;
        case 'ActualizarHiper':
          return self::ActualizarHiper($this);
          break;
        case 'CargarHiper':
          return self::CargarHiper($this);
          break;
        case 'EliminarHiper':
          return self::EliminarHiper($this);
          break;
        default:
          $this->respuesta = array(
            'estado'=>2,
            'mensaje'=>'No se reconoce la petición'
          );
        
      }
    }

    private static function Listar($obj){
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "SELECT 
              usuario,clave,rol,estado
              FROM usuarios";
      $sentecia = $pdo->prepare($sql);
      if($sentecia->execute()){
        $resultado = $sentecia->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
          $obj->respuesta = array(
            'estado' => 1,
            "usuarios"=>$resultado);
        } else {
          $obj->respuesta = null;
        }
      } else {
        $obj->respuesta = null;
      }   
    }

    private static function ListarHiper($obj){
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "SELECT *, p.nombres 
                  FROM hipertension_arterial h
                  INNER JOIN pacientes p
                  ON h.id_cedula = p.id_cedula";
      $sentecia = $pdo->prepare($sql);
      if($sentecia->execute()){
        $resultado = $sentecia->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
          $obj->respuesta = array(
            'estado' => 1,
            "usuarios"=>$resultado);
        } else {
          $obj->respuesta = array(
            'estado' => 2,
            "usuarios"=>$resultado);
        }
      } else {
        $obj->respuesta = null;
      }   
    }
    
    private static function CargarHiper($obj){
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "SELECT *
                  FROM pacientes ";
      $sentecia = $pdo->prepare($sql);
      if($sentecia->execute()){
        $resultado = $sentecia->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado) {
          $obj->respuesta = array(
            'estado' => 1,
            "usuarios"=>$resultado);
        } else {
          $obj->respuesta = null;
        }
      } else {
        $obj->respuesta = null;
      }   
    }
    
    private static function Logear($obj){
      $usuario = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "SELECT * FROM usuarios
              WHERE usuario= '{$usuario['usuario']}' AND
               clave = '{$usuario['clave']}' AND 
              estado = 1";
      $sentencia = $pdo->prepare($sql);
      if ($sentencia->execute()){
        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado){
          $obj->respuesta = array(
            'estado' => 1,
            'mensaje' => 'bienvenido',
            'usuario' => $resultado
          );
        } else {
          $obj->respuesta = array(
            'estado' => 2,
            'mensaje' => 'Error de verificación de datos Usuario no existe' 
          );
        }
      }else {
        $obj->respuesta = null;
      }
    }

    private static function Registrar($obj){
      $usuario = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql_v = "SELECT usuario,clave,rol,estado 
                FROM usuarios 
                WHERE usuario = '{$usuario['usuario']}'";
      $sentencia_v = $pdo->prepare($sql_v);
      if($sentencia_v->execute()){
        $resultado_v = $sentencia_v->fetch(PDO::FETCH_OBJ);
        if ($resultado_v){
          $obj->respuesta = array(
            'estado' => 2,
            'mensaje' => 'El usuario ya esta registrado'
          );
        }else{
          $sql = "INSERT INTO usuarios (
                  usuario,clave,rol,estado)
                  VALUES(?,?,?,?)";
          $sentencia = $pdo->prepare($sql);
          $sentencia->bindParam(1,$usuario['usuario']);
          $sentencia->bindParam(2,$usuario['clave']);
          $sentencia->bindParam(3,$usuario['rol']);
          $sentencia->bindParam(4,$usuario['estado']);

          $resultado = $sentencia->execute();
          if($resultado){
             $obj->respuesta = array(
                'estado' =>1,
                'mensaje'=>'Usuario Creado Con Exito'
            );
          }
        }
      } else {
        $obj->respuesta = array(
                'estado' =>2,
                'mensaje'=>'Error Inesperado'
            );
      } 
    }

    private static function RegistrarHiper($obj){
      $usuario = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql_v = "INSERT INTO hipertension_arterial( hipertension_arterial.id_cedula,hipertension_arterial.fec_realizacion_exa,hipertension_arterial.cf_tensionales,
      hipertension_arterial.tm_signos_vitales,hipertension_arterial.cons_medico_general,hipertension_arterial.cons_enfermeria,hipertension_arterial.cons_nutricion,
      hipertension_arterial.glicemia_basal,hipertension_arterial.hemoglobin,hipertension_arterial.hematocritos, hipertension_arterial.colesterol_total, hipertension_arterial.colesterol_hdl,
      hipertension_arterial.trigliceridos, hipertension_arterial.potasio, hipertension_arterial.creatinina,hipertension_arterial.uroanalisis,hipertension_arterial.ekg,
      hipertension_arterial.id_medicamento,hipertension_arterial.edu_grupal,hipertension_arterial.observaciones,
      hipertension_arterial.acciones_realizar)
                  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $sentencia = $pdo->prepare($sql_v);
          $sentencia->bindParam(1,$usuario['id_cedula']);
          $sentencia->bindParam(2,$usuario['fec_realizacion_exa']);
          $sentencia->bindParam(3,$usuario['cf_tensionales']);
          $sentencia->bindParam(4,$usuario['tm_signos_vitales']);
          $sentencia->bindParam(5,$usuario['cons_medico_general']);
          $sentencia->bindParam(6,$usuario['cons_enfermeria']);
          $sentencia->bindParam(7,$usuario['cons_nutricion']);
          $sentencia->bindParam(8,$usuario['glicemia_basal']);
          $sentencia->bindParam(9,$usuario['hemoglobin']);
          $sentencia->bindParam(10,$usuario['hematocritos']);
          $sentencia->bindParam(11,$usuario['colesterol_total']);
          $sentencia->bindParam(12,$usuario['colesterol_hdl']);
          $sentencia->bindParam(13,$usuario['trigliceridos']);
          $sentencia->bindParam(14,$usuario['potasio']);
          $sentencia->bindParam(15,$usuario['creatinina']);
          $sentencia->bindParam(16,$usuario['uroanalisis']);
          $sentencia->bindParam(17,$usuario['ekg']);
          $sentencia->bindParam(18,$usuario['id_medicamento']);
          $sentencia->bindParam(19,$usuario['edu_grupal']);
          $sentencia->bindParam(20,$usuario['observaciones']);
          $sentencia->bindParam(21,$usuario['acciones_realizar']);

          $resultado = $sentencia->execute();
          if($resultado){
             $obj->respuesta = array(
                'estado' =>1,
                'mensaje'=>'Usuario Creado Con Exito'
            );
          }else
          $obj->respuesta = array(
            'estado' =>2,
            'mensaje'=>'error'
        );
        }

    

    private static function Eliminar($obj) {
      $usuario = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "DELETE FROM usuarios 
              WHERE usuario ='{$usuario['usuario']}'";
      
      $sentencia = $pdo->prepare($sql);
      $resultado= $sentencia->execute();
      if ($resultado){
        $obj->respuesta = array (
          "estado" => 1,
          "mensaje" => "usuario eliminado"
        );
      } else {
        $obj->respuesta = array (
          "estado" => 2,
          "mensaje" => "usuario no se elimino"
        );
      }
    }
    
    private static function EliminarHiper($obj) {
      $registroa = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();
      $sql = "DELETE FROM hipertension_arterial 
              WHERE id_hiper_arterial ='{$registroa['id_hiper_arterial']}'";
      
      $sentencia = $pdo->prepare($sql);
      $resultado= $sentencia->execute();
      if ($resultado){
        $obj->respuesta = array (
          "estado" => 1,
          "mensaje" => "Registro eliminado"
        );
      } else {
        $obj->respuesta = array (
          "estado" => 2,
          "mensaje" => "El registro no se elimino"
        );
      }
    }
    private static function Actualizar($obj){
      $usuario = $_POST['datos'];
      $pdo = Conexion_db::obtenerint()->obtenerDB();

      $comando = "UPDATE usuarios SET usuarios.clave = ?, usuarios.estado=?, usuarios.rol = ? WHERE usuarios.usuario = ?";
      $sentencia = $pdo->prepare ( $comando );
      $sentencia->bindParam ( 1, $usuario['clave'] );
      $sentencia->bindParam ( 2, $usuario['estado'] );
      $sentencia->bindParam ( 3, $usuario['rol'] );
      $sentencia->bindParam ( 4, $usuario['usuario'] );

      $resultado = $sentencia->execute ();
      if($resultado){
        $obj->respuesta = array(
            "estado" =>1,
            "mensaje"=>"Usuario Actualizado Con Exito"
          );
      }
    }



     private static function ActualizarHiper($obj){
      $usuario = $_POST['datos'];
       $pdo = Conexion_db::obtenerint()->obtenerDB();

       $comando = "UPDATE hipertension_arterial SET hipertension_arterial.id_cedula = ?,
        hipertension_arterial.fec_realizacion_exa = ?,
        hipertension_arterial.cf_tensionales=?, hipertension_arterial.tm_signos_vitales= ?,
        hipertension_arterial.cons_medico_general= ?, hipertension_arterial.cons_enfermeria= ?, hipertension_arterial.cons_nutricion= ?,
        hipertension_arterial.glicemia_basal= ?, hipertension_arterial.hemoglobin= ?, hipertension_arterial.hematocritos= ?, hipertension_arterial.colesterol_total = ?,
        hipertension_arterial.colesterol_hdl= ?, hipertension_arterial.trigliceridos= ?, hipertension_arterial.potasio= ?, hipertension_arterial.creatinina= ?,
        hipertension_arterial.uroanalisis= ?, hipertension_arterial.ekg= ?, hipertension_arterial.id_medicamento= ?, hipertension_arterial.edu_grupal= ?,
        hipertension_arterial.observaciones= ?, hipertension_arterial.acciones_realizar= ? WHERE hipertension_arterial.id_hiper_arterial = ?";
       $sentencia = $pdo->prepare ( $comando );
       $sentencia->bindParam ( 1, $usuario['id_cedula'] );
       $sentencia->bindParam ( 2, $usuario['fec_realizacion_exa'] );
       $sentencia->bindParam ( 3, $usuario['cf_tensionales'] );
       $sentencia->bindParam ( 4, $usuario['tm_signos_vitales'] );
       $sentencia->bindParam ( 5, $usuario['cons_medico_general'] );
       $sentencia->bindParam ( 6, $usuario['cons_enfermeria'] );
       $sentencia->bindParam ( 7, $usuario['cons_nutricion'] );
       $sentencia->bindParam ( 8, $usuario['glicemia_basal'] );
       $sentencia->bindParam ( 9, $usuario['hemoglobin'] );
       $sentencia->bindParam ( 10, $usuario['hematocritos'] );
       $sentencia->bindParam ( 11, $usuario['colesterol_total'] );
       $sentencia->bindParam ( 12, $usuario['colesterol_hdl'] );
       $sentencia->bindParam ( 13, $usuario['trigliceridos'] );
       $sentencia->bindParam ( 14, $usuario['potasio'] );
       $sentencia->bindParam ( 15, $usuario['creatinina'] );
       $sentencia->bindParam ( 16, $usuario['uroanalisis'] );
       $sentencia->bindParam ( 17, $usuario['ekg'] );
       $sentencia->bindParam ( 18, $usuario['id_medicamento'] );
       $sentencia->bindParam ( 19, $usuario['edu_grupal'] );
       $sentencia->bindParam ( 20, $usuario['observaciones'] );
       $sentencia->bindParam ( 21, $usuario['acciones_realizar'] );
       $sentencia->bindParam ( 22, $usuario['id_hiper_arterial'] );
       
       

       $resultado = $sentencia->execute ();
       if($resultado){
         $obj->respuesta = array(
             "estado" =>1,
             "mensaje"=>"Usuario Actualizado Con Exito"
           );
       } 
     }
      
  }
?>