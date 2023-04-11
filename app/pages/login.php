<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Agregamops una variable por si hay errores
        $errors = [];

        /* Ahora voy a encontrar una fila usando una consulta a base de Datos */
		$values = [];
		$values['email'] = trim($_POST['email']);
		$query = "select * from users where email = :email limit 1";
		//seleccione cada columna de los usuarios donde la columna de correo es igual a cualquier correo electronico 
		$row = db_query_one($query,$values);

        if(!empty($row))
        
        {	
			//vamos averificar la contraseña
			if(password_verify($_POST['password'], $row['password']))
			{	
				authenticate($row);
				message("Inicio de sesión Exitoso!");
				redirect('admin');
			}


        }
                
       message("email o contraseña incorrectos");
	   //no queremos decirle al usuario cual es el incorrecto por motivos de seguridad
    }

	/* Este código verifica si la solicitud HTTP recibida es una solicitud POST, y si lo es, busca en la base de datos un usuario con la dirección de correo electrónico especificada. Si encuentra un usuario, verifica si la contraseña ingresada por el usuario coincide con la contraseña almacenada en la base de datos utilizando la función password_verify(). Si las credenciales son válidas, el usuario se autentica y se le redirige a la página de administración. Si las credenciales no son válidas, se muestra un mensaje de error genérico, sin especificar si la dirección de correo electrónico o la contraseña son incorrectas, por motivos de seguridad. */
?>


<?php require page('includes/header') ?>

	<!-- Seccion de Login-->
	<section class="content">

		<div class="login-holder">

		<?php if(message()):?>
			<div class="alert"><?=message('',true)?></div>
		<?php endif;?>

			<form method="post">
				<div class="contenedor-login">	
					<center><img src="assets/images/logo_4.jpg" style="width: 150px; "></center>
					<h2>Iniciar sesión</h2>
					<input value="<?=set_value('email')?>" class="my-1 form-control" type="email" name="email" placeholder="Email">
					<input value="<?=set_value('password')?>" class="my-1 form-control" type="password" name="password" placeholder="Contraseña">
					<button class="my-1 btn bg-blue">Iniciar sesión</button>
					<hr>
					<div><a href="<?=ROOT?>/register">Crear cuenta nueva</a><div>
				</div>
			</form>
		</div>

	</section>

	<?php require page('includes/footer') ?>