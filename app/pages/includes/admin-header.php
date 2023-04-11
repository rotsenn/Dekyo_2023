<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dekyo Music Website</title>
	<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?484154">
</head>
<body>
	<style>
		header a {
			color: -webkit-link;
		}

		.dropdown-list {
			background-color: white
		}
	</style>

	<header style="background-color: white; color: black;">
		<div class="logo-holder">
			<a href="<?=ROOT?>"><img class="logo" src="<?=ROOT?>/assets/images/logo_4.jpg"></a>
		</div>
		<div class="header-div">
			<div class="main-title">
				Admin Area
				<div class="socials">
					
				</div>
			</div>
			<div class="main-nav">
				<div class="nav-item"><a href="<?=ROOT?>/admin">Dashboard</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/users">Usuarios</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/songs">Canciones</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/categories">Categorias</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/artists">Artistas</a></div>
				
				
				<div class="nav-item dropdown">
					<a href="#">Hola, <?=user('username')?></a>
					<div class="dropdown-list">
						<div class="nav-item">
							<a href="<?=ROOT?>/profile">Mi Perfil</a>
						</div>
						<div class="nav-item">
							<a href="<?=ROOT?>">Sitio Web</a>
						</div>
						<div class="nav-item">
							<a href="<?=ROOT?>/logout">Cerrar Sesión</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</header>

	<!-- ahora vamos a crear una alerta para cuando se cree el usuario satisfactoriamente -->
	<?php if(message()):?>
	
		<div class="alert"><?=message('',true)?></div>

	<?php endif;?>

	<!-- este código se utiliza para mostrar un mensaje almacenado en la sesión PHP en una página HTML utilizando la función "message()" y el elemento div con la clase "alert". Si no hay ningún mensaje almacenado, no se muestra nada en la página HTML. -->
