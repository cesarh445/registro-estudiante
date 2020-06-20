<?php
	try{
		$usuario="root";
		$contrasena=" ";
		$c_host=new PDO('mysql:host=localhost;dbname=netview', $usuario, $contrasena);
		if($c_host==true){
		}
	}
	catch (PDOException $e){
		echo "error conection";
	}
	$nombre=$_POST["nombre"];
	$apellido_1=$_POST["apellido_1"];
	$apellido_2=$_POST["apellido_2"];
	$email=$_POST["email"];
	$telefono=$_POST["telefono"];
	$password=$_POST["password_2"];
	$captcha = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
	if(!$captcha){
		echo '<h2>Please check the the captcha form.</h2>';
		exit;
	}
	$secretKey = "6LfVXeAUAAAAAPuNJSfWQzg06ikDrLFVVADH_--0";
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$mensaje="";
	$stat="";
	
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array('secret' => $secretKey, 'response' => $captcha);
	
	$options = array(
    'http' => array(
	'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	'method'  => 'POST',
	'content' => http_build_query($data)
    )
	);
	$context  = stream_context_create($options);
	$response = file_get_contents($url, false, $context);
	$responseKeys = json_decode($response,true);
	header('Content-type: application/json');
	if($responseKeys["success"]) {
		if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}[^'\s]/",$password))
		{
			$mensaje="El formato contraseña debe contener 8 caracteres primer mayuscua y un simbolo especial ";
			$stat=false;
			//echo $stat;
			//echo $mensaje;
		}
		else
		{
			
			
			$sql="INSERT INTO usuarios(nombre,apellido_1,apellido_2,email,telefono,password) 
			VALUES(:nombre,:apellido_1,:apellido_2,:email,:telefono,:password)";
			$con=$c_host -> prepare($sql);
			$con -> bindParam(':nombre', $nombre);
			$con -> bindParam(':apellido_1', $apellido_1);
			$con -> bindParam(':apellido_2', $apellido_2);
			$con -> bindParam(':email', $email);
			$con -> bindParam(':telefono', $telefono);
			$con -> bindParam(':password', $password);
			$con-> execute();
			
			$id_usuario=$c_host->lastInsertid();
			$user="ES000".$id_usuario;
			$mensaje="Tu usuario es:".$user;
			$stat=true;
			//echo $stat;
			//echo $mensaje;
			
			$sql2="UPDATE usuarios SET usuario= :usuario WHERE id_usuario= :id_usuario";
			$con=$c_host -> prepare($sql2);
			$con -> bindParam(':usuario',$user);
			$con -> bindParam(':id_usuario',$id_usuario);
			$con -> execute();
		}
		echo json_encode(array('mensaje' => $mensaje,'success'=>$stat));
		} else {
		echo json_encode(array('mensaje' => $mensaje,'success' =>$stat));
	}
	
	
	
	
	
	
	
	
	
	
	
?>