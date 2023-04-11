<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//validacion de datos artitas
			if(empty($_POST['name']))
			{
				$errors['name'] = "se requiere un nombre";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				/*utiliza la función preg_match() para comprobar que el valor contiene solamente letras (mayúsculas o minúsculas), espacios en blanco, y los caracteres "&" y "-".*/
				$errors['name'] = "un nombre solo puede tener letras y espacios";
			}

			//imagen
			if(!empty($_FILES['image']['name']))
			/*La expresión '!empty($_FILES['image']['name'])' es una negación, lo que significa que se cumple la condición si el campo de archivo 'image' no está vacío. Por lo tanto, el bloque de código dentro del if se ejecuta cuando se envía un archivo a través del campo 'image'*/
			{

				$folder = "uploads/";
				/* La variable $folder contiene la ruta del directorio que se desea crear. */
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
					/* Dentro del if, la función mkdir() se utiliza para crear el directorio. El segundo argumento, 0777, indica los permisos del directorio recién creado. El tercer argumento, true, indica que el directorio se creará recursivamente, es decir, si los directorios padres necesarios no existen, se crearán.

					Después de crear el directorio, la función file_put_contents() se utiliza para crear un archivo index.php vacío dentro del directorio recién creado. El archivo index.php se utiliza a menudo para evitar que los usuarios vean el contenido del directorio al acceder a él desde el navegador.
				} */

				}

				$allowed = ['image/jpeg','image/png'];
				/* se define un arreglo $allowed que contiene los tipos de archivo permitidos. En este caso, solamente se permiten los formatos de imagen jpeg y png. */
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				/* dentro del if comprueba si el archivo se ha subido sin errores ($_FILES['image']['error'] == 0) y si su tipo está dentro del arreglo $allowed (in_array($_FILES['image']['type'], $allowed)). Si ambas condiciones son verdaderas, se procede a mover el archivo subido a la carpeta de destino en el servidor. */
				{
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					/* La función move_uploaded_file() se utiliza para mover el archivo temporal desde su ubicación actual ($_FILES['image']['tmp_name']) a la nueva ubicación de destino ($destination). */
					/* Si la condición dentro del if no se cumple, se agrega un mensaje de error al arreglo $errors indicando que el tipo de archivo subido no es válido. */


				}else{
					$errors['name'] = "imagen no válida. los tipos permitidos son ". implode(",", $allowed);
				}
				

			}else{
				$errors['name'] = "se requiere una imagen";
			}
 
			if(empty($errors))
			/* if verifica si el arreglo $errors está vacío (empty($errors)). Si no hay errores, se procede a guardar los datos del artista en la base de datos. */
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['image'] 	= $destination;
				$values['user_id'] 	= user('id');
				/* $values. Este arreglo se utiliza posteriormente para insertar los datos en la base de datos.

				Cada clave del arreglo $values corresponde a una columna en la tabla de la base de datos. Las claves son: 'name', 'bio', 'image', y 'user_id'.

				La función trim() se utiliza para eliminar cualquier espacio en blanco al principio y al final de las cadenas de texto que se obtienen del formulario. Esto ayuda a evitar que se inserten valores no deseados en la base de datos.

				La variable $destination contiene la ruta donde se ha guardado la imagen subida por el usuario, por lo que esta ruta se asigna a la clave 'image' del arreglo $values.

				Finalmente, la clave 'user_id' del arreglo $values se establece en el valor devuelto por la función user('id'). Esto sugiere que el formulario está siendo utilizado dentro de una aplicación de autenticación de usuarios y que se está guardando el ID del usuario que crea el registro en la base de datos. */

				$query = "insert into artists (name,image,user_id,bio) values (:name,:image,:user_id,:bio)";
				db_query($query,$values);
				/* La consulta SQL se construye como una cadena de caracteres y se asigna a la variable $query. La consulta utiliza la sintaxis INSERT INTO para especificar la tabla en la que se insertarán los datos. Los nombres de las columnas que se insertarán se especifican en paréntesis después del nombre de la tabla: (name, image, user_id, bio). */
				/* La función db_query() es una función personalizada que ejecuta la consulta SQL y devuelve el resultado de la operación. En este caso, la función se utiliza para insertar los datos del formulario en la tabla de la base de datos. */

				message("Artista creado con Éxito");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'edit')
	//seccion actualizar datos
	{

		$query = "select * from artists where id = :id limit 1";
		/* selecciona todos los campos de la tabla "artists" donde el valor de la columna "id" coincide con el valor del parámetro de marcador de posición ":id". La consulta utiliza la cláusula "LIMIT 1" para limitar el resultado a una sola fila. 
		
		En otras palabras, la consulta busca en la tabla "artists" una sola fila que tenga el valor específico en la columna "id". El valor de ":id" probablemente se proporciona dinámicamente en algún otro lugar del código, como en un formulario o en una URL. La consulta se guarda en la variable $query para su posterior ejecución con los valores de los parámetros correspondientes.
		*/
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		/*La variable $_SERVER['REQUEST_METHOD'] contiene el método utilizado para la solicitud actual (GET, POST, etc.). La condición $_SERVER['REQUEST_METHOD'] == "POST" verifica si el método utilizado es POST.
		
		la condición $_SERVER['REQUEST_METHOD'] == "POST" && $row se cumple si la solicitud actual es una solicitud POST y si se pudo encontrar una fila en la base de datos utilizando los parámetros de la solicitud.
		*/
		{

			$errors = [];

			//validacion
			if(empty($_POST['name']))
			//si esta vacio el atributo name
			{
				$errors['name'] = "se requiere una imagen";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "un nombre solo puede tener letras sin espacios";
			}

 			//imagen
			if(!empty($_FILES['image']['name']))
			/* $_FILES es una matriz superglobal en PHP que contiene información sobre los archivos cargados en la solicitud actual. El índice 'image' en $_FILES se refiere al archivo con el atributo 'name' igual a 'image' en el formulario HTML que envió la solicitud.

			La función empty() verifica si la variable pasada como argumento está vacía o no. En este caso, la expresión !empty($_FILES['image']['name']) evalúa a true si se ha cargado un archivo en la solicitud actual y el campo 'name' del archivo es diferente de una cadena vacía. Si se ha cargado un archivo, se ejecutará el código dentro del bloque condicional. */
			{

				$folder = "uploads/";
				/* crear una carpeta llamada "uploads" si aún no existe en el directorio raíz del proyecto y de crear un archivo index.php dentro de esta carpeta. */
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}
				/*Primero, se establece la variable $folder con el nombre de la carpeta que se desea crear. Luego, la función file_exists() se utiliza para comprobar si la carpeta existe o no en el directorio raíz del proyecto. Si la carpeta no existe, se crea mediante la función mkdir(), que acepta dos argumentos: el primer argumento es el nombre de la carpeta que se desea crear, y el segundo argumento es un número que representa los permisos que se otorgarán a la carpeta (en este caso, 0777 significa que la carpeta tendrá permisos de lectura, escritura y ejecución para todos los usuarios). La opción true en el tercer argumento de mkdir() se utiliza para crear la carpeta y cualquier subdirectorio necesario.

				Finalmente, la función file_put_contents() se utiliza para crear un archivo index.php vacío dentro de la carpeta recién creada. Esto se hace para evitar que los usuarios puedan explorar los archivos dentro de la carpeta desde el navegador web.*/

				$allowed = ['image/jpeg','image/png'];
				/*se define un array llamado $allowed que contiene los tipos MIME de archivos de imagen permitidos. Los tipos MIME(tipo de dato) especifican el tipo de contenido que se encuentra en un archivo. En este caso, se permiten los tipos MIME de imágenes JPEG y PNG. */

				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				/*verifica si el archivo cargado por el usuario no tuvo errores en la subida (es decir, $_FILES['image']['error'] es igual a cero) y si su tipo MIME ($_FILES['image']['type']) se encuentra en el array de tipos MIME permitidos $allowed, utilizando la función in_array.

				Si ambas condiciones se cumplen, significa que el archivo cargado es una imagen y se permite su carga al servidor. Si una o ambas condiciones no se cumplen, significa que el archivo no se cargó correctamente o no es un tipo de imagen permitido, y se mostrará un mensaje de error en consecuencia.*/
				{
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					
					//borrar archivo antiguo
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				}else{
					$errors['name'] = "image no valid. allowed types are ". implode(",", $allowed);
				}
				/*Primero, se define la variable $destination para almacenar la ruta de destino de la nueva imagen, que es la ruta del directorio de carga $folder más el nombre de archivo de la imagen cargada $_FILES['image']['name'].

				Luego, se mueve el archivo cargado de la ubicación temporal al destino especificado usando move_uploaded_file().

				Si el archivo cargado es válido (no tiene errores y su tipo se encuentra en la lista permitida de tipos de archivos $allowed), se verifica si ya existe una imagen en la base de datos ($row['image']) y en el sistema de archivos. Si es así, se elimina el archivo antiguo usando unlink().

				Si el archivo no es válido, se establece un mensaje de error en la matriz $errors.*/

			}

			if(empty($errors))
			/* Si $errors está vacía, entonces se considera que no ha habido ningún error en el formulario y se ejecutará el código dentro de este if. */
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;
				/*inicializan un arreglo llamado $values y asignan valores a sus claves. Estas claves son name, bio, user_id, e id.

				trim($_POST['name']) toma el valor del campo name enviado a través de un formulario y elimina los espacios en blanco al inicio y al final del texto ingresado. Luego, lo asigna a la clave name del arreglo $values.
				trim($_POST['bio']) hace lo mismo que lo anterior, pero para el campo bio del formulario.
				user('id') llama a la función user() para obtener el id del usuario que está realizando la acción en la página. Luego, asigna ese id a la clave user_id del arreglo $values.
				$id es un valor previamente definido que representa el id del artista que se está actualizando, y se asigna a la clave id del arreglo $values.
				En resumen, este código construye un arreglo $values que contiene información del formulario enviado y del usuario que lo envía, y que se utilizará más adelante para actualizar la información del artista en la base de datos.*/

				$query = "update artists set name = :name,bio = :bio,user_id =:user_id where id = :id limit 1";
				/* que actualice los campos name, bio y user_id en la tabla artists para un registro específico identificado por id. La consulta utiliza marcadores de posición (p. ej., :name) para valores que se proporcionan en un arreglo $values cuando se ejecuta la consulta. La actualización se limita a un solo registro (el identificado por id y limitado por limit 1). */
				
				if(!empty($destination)){
					/*Primero, verifica si la variable $destination no está vacía utilizando la función empty(). Si la variable no está vacía, continúa con la actualización de los datos del artista.*/
					$query = "update artists set name = :name,bio = :bio,user_id =:user_id, image = :image where id = :id limit 1";
					$values['image'] 	= $destination;
					/*La variable $destination se agrega a la matriz $values como el valor del parámetro image. $destination debe contener la ruta de la imagen del artista que se ha cargado previamente en el servidor.

					La función db_query() se utiliza para ejecutar la consulta SQL y pasar los valores de los parámetros.*/
				}

				db_query($query,$values);
				/*La función db_query() se utiliza para ejecutar la consulta SQL y pasar los valores de los parámetros.*/

				message("Artista editado con Éxito");
				redirect('admin/artists');
				/* Luego, se llama a la función message() para mostrar un mensaje de éxito en la pantalla del usuario y a la función redirect() para redirigir al usuario a la página de administración de artistas. */
			}
		}
	}else
	if($action == 'delete')
	//seccion borrar
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{
 
				$values = [];
				$values['id'] 		= $id;

				$query = "delete from artists where id = :id limit 1";
				db_query($query,$values);

				//borrar imagen
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}
				/* comprueba si un archivo existe en el servidor utilizando la función file_exists() y si existe, elimina el archivo utilizando la función unlink().

				El archivo que se está verificando y eliminando se especifica a través de la variable $row['image']. Esto sugiere que $row es un array asociativo que contiene información de una fila de una tabla en una base de datos, y image es el nombre de una columna que contiene la ruta o nombre del archivo que se quiere eliminar.

				Por lo tanto, este código se utiliza comúnmente en aplicaciones web para eliminar archivos de imágenes o cualquier otro tipo de archivo asociado a un registro de una base de datos, cuando se quiere eliminar o actualizar dicho registro */

				message("Artista eliminado con Éxito");
				redirect('admin/artists');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">

	  				<h3>Agregar Nuevo Artista</h3>

	  				<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Nombre Artista">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>
 
 					<label>Imagen Artista:</label>
	  				<input class="form-control my-1" type="file" name="image">

	  				<label>Biografia Artista:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio')?></textarea>

	  				<?php if(!empty($errors['image'])):?>
	  					<small class="error"><?=$errors['image']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-green">Guardar</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Editar Artista</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="Artistname">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">

	  				<div>Imagen Artista:</div>
	  				<input class="form-control my-1" type="file" name="image">

	  				<label>Biografia Artista:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio',$row['bio'])?></textarea>

	  				<button class="btn bg-orange">Guardar</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Ese registro no fue encontrado</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Atras</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Borrar Artista</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Borrar</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Atras</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Ese registro no fue encontrado</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Atras</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from artists order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Artistas
  				<a href="<?=ROOT?>/admin/artists/add">
  					<button class="float-end btn bg-purple">Agregar Artista</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Titulo</th>
  					<th>Imagen</th>
  					<th>Acción</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['name']?></td>
		  					<td>
		  						<a href="<?=ROOT?>/artist/<?=$row['id']?>">
		  						<img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;">
		  						</a>
		  					</td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/artists/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/artists/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>