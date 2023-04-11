<?php 

	session_start();

	require "../app/core/init.php";
	
	$URL = $_GET['url'] ?? 'home';
	$URL = explode("/", $URL);


	$file = page(strtolower($URL[0]));
	if(file_exists($file))
	{
		require $file;
	} else {
		require page("404");
	}

/* 	Array
(
    [0] => categorias
    [1] => country
)
 */
 /*
	Esta lineas son para ver que valor estamos
	obteniendo de la url
 */

 /*
	Normalmente los enlaces son asi :
		website.com?page=gategoria&id=$
	lo queremos cambiar a
		website.com/categoria/4

		Esto es mucho mas limpio para la busqueda de
		motores de google

	--------------
	lo que sucede es que si yo ingreso un enlace
	o direccion no valida lo que hicimos fue implementar una estructura de codigo mas limpia a la url 

	ejm -> http://localhost/website_music/public/adsdasdasd

	si tenemos esa direccion de codigo no valida
	simpre me llevara a la pagina de inicio(index.php)
 */

 /*
	Estas líneas de código corresponden a un archivo de configuración de Apache conocido como ".htaccess".

	Lo que hacen es habilitar el "mod_rewrite" de Apache, que es una función que permite reescribir o redirigir URLs de forma dinámica. En otras palabras, estas líneas permiten la creación de URLs amigables para los motores de búsqueda y los usuarios.

	Las tres líneas de "RewriteCond" verifican si el archivo solicitado por el usuario no existe en el servidor (primera línea(
	RewriteCond %{REQUEST_FILENAME} !-f)) o si no es un directorio válido (segunda línea(RewriteCond %{REQUEST_FILENAME} !-d)). Si ambas condiciones se cumplen, la tercera línea(RewriteCond ^(.*)$ index.php?url=$1 [L;QSA]) redirige la solicitud a un archivo llamado "index.php" y pasa el valor de la URL solicitada como un parámetro llamado "url".

	En resumen, estas líneas de código permiten la implementación de una estructura de URL más amigable para el usuario y también pueden ser útiles para implementar ciertas funcionalidades en una aplicación web.
	*/


	//----------------------

	/*

	User-agent: *
	Disallow: /admin/


	Estas líneas de código corresponden al archivo robots.txt que se utiliza para comunicar a los motores de búsqueda cómo deben rastrear y acceder al contenido del sitio web.

	La primera línea indica que la regla de acceso se aplica a todos los robots de los motores de búsqueda que visitan el sitio web. El asterisco (*) significa que la regla se aplica a cualquier robot que visite el sitio.

	La segunda línea indica que se deben bloquear todos los archivos y carpetas que se encuentran en el directorio "/admin/" del sitio web. Esto significa que los motores de búsqueda no indexarán ni mostrarán los archivos o páginas que se encuentran en ese directorio.

	En resumen, estas líneas de código impiden que los motores de búsqueda accedan y muestren los contenidos en la carpeta /admin/ del sitio web, lo que ayuda a proteger la información confidencial o que no debe ser pública.

	*/