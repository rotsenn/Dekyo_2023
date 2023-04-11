<?php 
	//Vamos a comprobar si alguien es un administrador. Este código PHP comprueba si el usuario que ha iniciado sesión en el sitio web tiene permisos de administrador antes de permitir el acceso a una página de administración
	if(!is_admin())
	{
		message("Solo los administradores pueden acceder a la página de administración");
		redirect('login'); 
	}

	$section 	= $URL[1] ?? "dashboard";
	$action  	= $URL[2] ?? null;
	$id     	= $URL[3] ?? null;

	/*Lo estamos haiendo es:
	
	*/

	switch ($section) {
		case 'dashboard':
			require page('admin/dashboard');
			break;
			
		case 'users':
			require page('admin/users');
			break;

		case 'categories':
			require page('admin/categories');
			break;
		
		case 'artists':
			require page('admin/artists');
			break;

		case 'songs':
			require page('admin/songs');
			break;

		default:
			require page('admin/404');
			break;
	}
?>

<!-- Este código PHP está asignando valores a tres variables ($section, $action, y $id) basados en los elementos de una matriz $URL y luego está utilizando una declaración switch para incluir diferentes archivos dependiendo del valor de $section.

La línea $section = $URL[1] ?? "dashboard"; asigna el valor del segundo elemento de la matriz $URL a la variable $section. Si el valor no está definido, se asigna el valor "dashboard" a la variable.

La línea $action = $URL[2] ?? null; asigna el valor del tercer elemento de la matriz $URL a la variable $action. Si el valor no está definido, se asigna el valor null a la variable.

La línea $id = $URL[3] ?? null; asigna el valor del cuarto elemento de la matriz $URL a la variable $id. Si el valor no está definido, se asigna el valor null a la variable.

Luego, el código utiliza una declaración switch para incluir diferentes archivos PHP basados en el valor de $section. Si el valor de $section es "dashboard", se incluirá el archivo dashboard.php que se encuentra en el directorio admin. Si el valor de $section es "users", se incluirá el archivo users.php que se encuentra en el mismo directorio. Si $section no es "dashboard" ni "users", se incluirá el archivo 404.php que se encuentra en el mismo directorio.

En resumen, este código PHP asigna valores a las variables basados en los elementos de una matriz $URL y luego utiliza una declaración switch para incluir diferentes archivos PHP dependiendo del valor de $section. -->