<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Registro</title>
		<link href="../css/estilos.css" rel="stylesheet">
		
		
	</head>
	<body>
		<nav></nav>
		<header><center><h1>Registro de estudiente</h1></center></header>
		<div>
			<form class="date_student" id="date_student">
				<label class="form_date">Nombre</label>
				<input class="form_date" id="nombre">
				<label class="form_date">Apellido Paterno</label>
				<input class="form_date" id="apellido_1">
				<label class="form_date">Apellido Materno</label>
				<input class="form_date" id="apellido_2">
				<label class="form_date">E-mail</label>
				<input class="form_date" type="email" id="email">
				<label class="form_date">Numero de telefono</label>
				<input class="form_date" type="tel" id="telefono">
				<label class="form_date" >Contraseña</label>
				<input class="form_date" type="password" id="password_1">
				<label class="form_date" >Reingrese contraseña</label>
				<input class="form_date" type="password" id="password_2">
				<input  type="hidden" name="recaptcha_response" id="recaptchaResponse">
				<button class="form_date" id="registrar"name="registrar" type="button">Registrar</button>
				
			</form>
			
			
			
		</div>
		
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?render=6LfVXeAUAAAAAKV_6F7zldRbTEiEWnmW15BttJNn'> 
	</script>
    <script>
		
	</script>
	<script>
		$(document).ready(inicio);
		function inicio(){
			$("#registrar").click(validar);
		}
		function validar(){
			let nombre=$("#nombre").val();
			let apellido_1=$("#apellido_1").val();
			let apellido_2=$("#apellido_2").val();
			let email=$("#email").val();
			let telefono=$("#telefono").val();
			let password_1=$("#password_2").val();
			let password_2=$("#password_2").val();
			if(password_1=!password_2)
			{
				alert("vuelve a llenar el formulario");
				console.log(password_1);
				console.log(password_2);
			} 
			else
			{
				grecaptcha.ready(function() {
					grecaptcha.execute('6LfVXeAUAAAAAKV_6F7zldRbTEiEWnmW15BttJNn', {action: 'homepage'}).then(function(token) {
						$('#date_student').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
						$.post("guardar.php",{nombre: nombre, apellido_1:apellido_1,apellido_2:apellido_2,telefono:telefono,email:email,password_2:password_2, token: token}, function(result) {
							console.log(result);
							if(result.success==true){
								alert(result.mensaje);
								redireccion();
								}else{
								alert(result.mensaje);
								
							}
						});
					});
				});
				
				
			}
		}
		
		function redireccion(){
			
			window.location.href="../inicio/inicio.php";
		}
		
	</script>
</html>