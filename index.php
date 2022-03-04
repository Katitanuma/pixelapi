<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET,POST");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
	$servidor = "localhost"; 
	$usuario = "root"; 
	$contrasenia = ""; 
	$nombreBaseDatos = "quehaceres";
	$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


	// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
	if (isset($_GET["consultar"])){
	    $sqlQuehaceres = mysqli_query($conexionBD,"SELECT * FROM quehacer WHERE id=".$_GET["consultar"]);
	    if(mysqli_num_rows($sqlQuehaceres ) > 0){
	        $quehaceres = mysqli_fetch_all($sqlQuehaceres,MYSQLI_ASSOC);
	        echo json_encode($quehaceres);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	//borrar los quehaceres completados
	if (isset($_GET["eliminarC"])){		
	    $sqlQuehaceres = mysqli_query($conexionBD,"DELETE FROM quehacer WHERE estado=".$_GET["eliminarC"]);
	    if($sqlQuehaceres){
	        echo json_encode(["success"=>1]);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	//eliminar todo
	if (isset($_GET["eliminarTodo"])){		
	    $sqlQuehaceres = mysqli_query($conexionBD,"DELETE FROM quehacer");
	    if($sqlQuehaceres){
	        echo json_encode(["success"=>1]);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	//Inserta un nuevo quehacer
	if(isset($_GET["insertar"])){
	    $data = json_decode(file_get_contents("php://input"));
	    $nombre=$data->nombre;
	   
	    if(($nombre!="")){
	            
	    $sqlQuehaceres = mysqli_query($conexionBD,"INSERT INTO quehacer(nombre) VALUES('$nombre') ");
	    echo json_encode(["success"=>1]);
	        }
	    exit();
	}
	//Actualizar todo
	if(isset($_GET["actualizarTodo"])){	    
	    $sqlQuehaceres = mysqli_query($conexionBD,"UPDATE quehacer SET estado='1'");
	    if($sqlQuehaceres){
	        echo json_encode(["success"=>1]);
	        exit();
	    }
	    else{  echo json_encode(["success"=>0]); }
	}
	// Actualiza quehacer completado
	if(isset($_GET["actualizarC"])){
	    
	    $data = json_decode(file_get_contents("php://input"));

	    $id=(isset($data->id))?$data->id:$_GET["actualizarC"];
	    $estado=$data->estado;
	    
	    $sqlQuehaceres = mysqli_query($conexionBD,"UPDATE quehacer SET estado='$estado' WHERE id='$id'");
	    echo json_encode(["success"=>1]);
	    exit();
	}

	// Actualiza quehacer no completado
	if(isset($_GET["actualizarNC"])){
	    
	    $data = json_decode(file_get_contents("php://input"));

	    $id=(isset($data->id))?$data->id:$_GET["actualizarNC"];
	    $estado=$data->estado;
	    
	    $sqlQuehaceres = mysqli_query($conexionBD,"UPDATE quehacer SET estado='$estado' WHERE id='$id'");
	    echo json_encode(["success"=>1]);
	    exit();
	}
	// Consulta todos los registros de la tabla quehaceres
	$sqlQuehaceres = mysqli_query($conexionBD,"SELECT * FROM quehacer ");
	if(mysqli_num_rows($sqlQuehaceres) > 0){
	    $quehaceres = mysqli_fetch_all($sqlQuehaceres,MYSQLI_ASSOC);
	    echo json_encode($quehaceres);
	}
	else{ 
		echo json_encode([["success"=>0]]); 
	}


?>