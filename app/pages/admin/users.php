<!-- 2. Ahora vamos a agregar los usuario -->
<?php 

    if($action == 'add')
    {
        
    

        /* queremos saber cuando algo fue publicado por lo que usaremos la variable del servidor($_SERVER)*/
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        /*La variable $_SERVER['REQUEST_METHOD'] contiene el método utilizado para la solicitud actual (GET, POST, etc.). La condición $_SERVER['REQUEST_METHOD'] == "POST" verifica si el método utilizado es POST.
		
		la condición $_SERVER['REQUEST_METHOD'] == "POST" && $row se cumple si la solicitud actual es una solicitud POST y si se pudo encontrar una fila en la base de datos utilizando los parámetros de la solicitud.
		*/
        {
            //Agregamops una variable por si hay errores
            $errors = [];

            //validacion de datos ******usuario*****
                
            if(empty($_POST['username']))  
                // si el campo de Nombre de usuario('username') esta vacio me lance un error
            {
                $errors['username'] = "se requiere un nombre de usuario";
            } else 
                //si el Nombre de Usuario esta ingresado
            if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
                /*estamos buscando con pre_match si hay algun caracter alfabetico en una cadena de texto. basicamente estamos buscando si lo que ingreso el usuario fueron caracteres alfabeticos de la a-zA-Z de $_POST['username']*/
                $errors['username'] = "el nombre de usuario solo puede tener letras sin spacios";
            }
            
            //validacion de datos ******email*****
                
            if(empty($_POST['email']))  
            // si el campo de Email('email') esta vacio me lance un error
            {
                $errors['email'] = "se requiere un correo electrónico";
            } else 
                //si el Email esta ingresado
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            /* se ejecuta si el campo de correo electrónico no está vacío, utiliza la función "filter_var" con el filtro "FILTER_VALIDATE_EMAIL" para validar si el correo electrónico proporcionado por el usuario es válido. Si no es válido, se agrega un mensaje de error al array de errores con el índice "email", indicando que el correo electrónico no es válido.*/
            {
                
                $errors['email'] = "correo electrónico no válido";
            }

            //validacion de datos ******password*****

            if(empty($_POST['password']))  
            // si el campo de password('password') esta vacio me lance un error
            {
                $errors['password'] = "se requiere un contraseña";
            } else 
                //si el password esta ingresado
            if($_POST['password'] != $_POST['retype_password'])
            /*se ejecuta si el campo de contraseña no está vacío, compara la contraseña ingresada con la confirmación de contraseña ("retype_password"). Si la contraseña ingresada no coincide con la confirmación de contraseña, se agrega un mensaje de error al array de errores con el índice "password", indicando que la contraseña no coincide.*/
            {
                $errors['password'] = "la contraseña no coincide";
            } else
            //validacion minimo caracteres contraseña utilizando la funcion strlen 
            if(strlen($_POST['password']) < 8)
            {
                $errors['password'] = "las contraseñas deben tener 8 caracteres o más";
            }

            //validacion de datos ******rol*****

            if(empty($_POST['role']))  
            // si el campo de role('role') esta vacio me lance un error
            {
                $errors['role'] = "se requiere un rol";
            } 

            if(empty($errors))
            //si no hay errores
            {

                $values = [];
                $values['username'] = trim($_POST['username']);
                $values['email'] = trim($_POST['email']);
                $values['role'] = trim($_POST['role']);
                $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                /*Encriptamos la contraseña con la funcion password_hash*/
                /* $values. Este arreglo se utiliza posteriormente para insertar los datos en la base de datos.

				Cada clave del arreglo $values corresponde a una columna en la tabla de la base de datos. Las claves son: 'name', 'bio', 'image', y 'user_id'.

				La función trim() se utiliza para eliminar cualquier espacio en blanco al principio y al final de las cadenas de texto que se obtienen del formulario. Esto ayuda a evitar que se inserten valores no deseados en la base de datos.*/

                $values['date'] = date("Y-m-d H:i:s");
                /*date() en PHP devuelve la fecha y hora actual del sistema en un formato específico. En este caso, el formato utilizado es Y-m-d H:i:s. Y representa el año (cuatro dígitos), m representa el mes (con ceros iniciales), d representa el día del mes (con ceros iniciales), H representa la hora en formato de 24 horas, i representa los minutos y s representa los segundos.

                Luego, el valor asignado a $values['date'] se puede utilizar para insertar la fecha y hora actual en una base de datos o para realizar otras operaciones en el código.*/

                //vamos a insertar los campos a users
                $query = "insert into users (username, email,password,role,date) values (:username,:email,:password,:role,:date)";
                db_query($query,$values);
                /* La consulta SQL se construye como una cadena de caracteres y se asigna a la variable $query. La consulta utiliza la sintaxis INSERT INTO para especificar la tabla en la que se insertarán los datos. Los nombres de las columnas que se insertarán se especifican en paréntesis después del nombre de la tabla: (name, image, user_id, bio). */
				/* La función db_query() es una función personalizada que ejecuta la consulta SQL y devuelve el resultado de la operación. En este caso, la función se utiliza para insertar los datos del formulario en la tabla de la base de datos. */

                message("Usuario Creado Con Éxito");
                redirect('admin/users');
                /* este código verifica si la solicitud actual es de tipo "POST" y, si es así, redirige(redirect) al usuario a la página "admin/users". Esto se puede utilizar, por ejemplo, para procesar un formulario enviado por el usuario y luego redirigir al usuario a otra página después de que se procesa el formulario */

            }
        }
    } else
    if($action == 'edit')
    {
        $query = "select * from users where id = :id limit 1";
        /* selecciona todos los campos de la tabla "users" donde el valor de la columna "id" coincide con el valor del parámetro de marcador de posición ":id". La consulta utiliza la cláusula "LIMIT 1" para limitar el resultado a una sola fila. */
        $row = db_query_one($query,['id'=>$id]);
        
        /* queremos saber cuando algo fue publicado por lo que usaremos la variable del servidor($_SERVER)*/
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $row)
        {
            //Agregamops una variable por si hay errores
            $errors = [];

            //validacion de datos ******usuario*****
                
            if(empty($_POST['username']))  
                // si el campo de Nombre de usuario('username') esta vacio me lance un error
            {
                $errors['username'] = "se requiere un nombre de usuario";
            } else 
                //si el Nombre de Usuario esta ingresado
            if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
                /*estamos buscando con pre_match si hay algun caracter alfabetico en una cadena de texto. basicamente estamos buscando si lo que ingreso el usuario fueron caracteres alfabeticos de la a-zA-Z de $_POST['username']*/
                $errors['username'] = "el nombre de usuario solo puede tener letras sin spacios";
            }
            
            //validacion de datos ******email*****
                
            if(empty($_POST['email']))  
            // si el campo de Email('email') esta vacio me lance un error
            {
                $errors['email'] = "se requiere un correo electrónico";
            } else 
                //si el Email esta ingresado
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            /* se ejecuta si el campo de correo electrónico no está vacío, utiliza la función "filter_var" con el filtro "FILTER_VALIDATE_EMAIL" para validar si el correo electrónico proporcionado por el usuario es válido. Si no es válido, se agrega un mensaje de error al array de errores con el índice "email", indicando que el correo electrónico no es válido.*/
            {
                
                $errors['email'] = "correo electrónico no válido";
            }

            //validacion de datos ******password*****

            if(!empty($_POST['password']))  
            //  esta línea de código se utiliza para verificar si el usuario ha proporcionado una contraseña en el formulario antes de actualizarla en la base de datos.
            {
                
                //si el password esta ingresado
                if($_POST['password'] != $_POST['retype_password'])
                /*se ejecuta si el campo de contraseña no está vacío, compara la contraseña ingresada con la confirmación de contraseña ("retype_password"). Si la contraseña ingresada no coincide con la confirmación de contraseña, se agrega un mensaje de error al array de errores con el índice "password", indicando que la contraseña no coincide.*/
                {
                    $errors['password'] = "la contraseña no coincide";
                } else
                //validacion minimo caracteres contraseña utilizando la funcion strlen 
                if(strlen($_POST['password']) < 8)
                {
                    $errors['password'] = "las contraseñas deben tener 8 caracteres o más";
                }
            }


            //validacion de datos ******rol*****

            if(empty($_POST['role']))  
            // si el campo de role('role') esta vacio me lance un error
            {
                $errors['role'] = "se requiere un rol";
            } 

            if(empty($errors))
            //si no hay errores
            {

                $values = [];
                $values['username'] = trim($_POST['username']);
                $values['email'] = trim($_POST['email']);
                $values['role'] = trim($_POST['role']);
                $values['id'] = $id;
                /*estas líneas de código crean un array asociativo $values que contiene los valores que se utilizarán en la consulta SQL para actualizar los datos de la tabla de usuarios en una base de datos. Los valores incluyen el nombre de usuario, la dirección de correo electrónico, el rol y el ID del usuario que se actualizará.*/ 


                $query = "update users set email = :email, username = :username, role = :role where id = :id limit 1";
                /*La cláusula where especifica la condición que debe cumplirse para que se actualice la fila. En este caso, la condición es que el valor de la columna id debe ser igual al valor del parámetro :id. La cláusula limit limita el número de filas actualizadas a una, lo que significa que solo se actualizará una fila.*/
                    
                
                if(!empty($_POST['password'])) 
                { 
                    $query = "update users set email = :email, password = :password, username = :username, role = :role where id = :id limit 1";
                    $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                /* estas líneas de código actualizan los datos de la tabla de la base de datos con la información enviada desde el formulario, excepto la contraseña, solo si el usuario no ha ingresado una nueva contraseña. La línea $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT); es incorrecta y no debe estar incluida en esta sección de código.*/    

                //vamos a insertar los campos a users
                db_query($query,$values);

                message("Usuario editado Con Éxito");
                redirect('admin/users');
                /* este código verifica si la solicitud actual es de tipo "POST" y, si es así, redirige(redirect) al usuario a la página "admin/users". Esto se puede utilizar, por ejemplo, para procesar un formulario enviado por el usuario y luego redirigir al usuario a otra página después de que se procesa el formulario */

            }
                    
        
        }
    } else
    //Borrar datos
    if($action == 'delete')
    {
        $query = "select * from users where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
        
        /* queremos saber cuando algo fue publicado por lo que usaremos la variable del servidor($_SERVER)*/
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $row)
        {
            //Agregamops una variable por si hay errores
            $errors = [];

            if($row['id'] == 1) 
            {
                $errors['username'] = "el administrador principal no se puede eliminar";
            }

            if(empty($errors))
            //si no hay errores
            {

                $values = [];
                $values['id'] = $id;
                /*estas líneas de código crean un array asociativo $values que contiene los valores que se utilizarán en la consulta SQL para actualizar los datos de la tabla de usuarios en una base de datos. Los valores incluyen el nombre de usuario, la dirección de correo electrónico, el rol y el ID del usuario que se actualizará.*/ 


                $query = "delete from users where id = :id limit 1";
                /*La cláusula where especifica la condición que debe cumplirse para que se actualice la fila. En este caso, la condición es que el valor de la columna id debe ser igual al valor del parámetro :id. La cláusula limit limita el número de filas actualizadas a una, lo que significa que solo se actualizará una fila.*/
                    

                //vamos a insertar los campos a users
                db_query($query,$values);

                message("Usuario eliminado Con Éxito");
                redirect('admin/users');
                /* este código verifica si la solicitud actual es de tipo "POST" y, si es así, redirige(redirect) al usuario a la página "admin/users". Esto se puede utilizar, por ejemplo, para procesar un formulario enviado por el usuario y luego redirigir al usuario a otra página después de que se procesa el formulario */

            }
                    
        
        }
    }

    

?>


<?php require page('includes/admin-header') ?>

	<!-- Seccion de Administrador-->
	<section class="admin-content" style="min-height: 200px;">

        <!-- Crud usuarios Add(Agregar)-->

        <!-- la acciona agregar, crear cargara lo que sea que este dentro  -->
        <?php  if($action == 'add'):?>
            <!-- crear -> creamos el formulario para crear usuario-->
            <div style="max-width: 500px; margin: auto">
                <form method="post">
                    <h3>Agregar Nuevo Usuario</h3>

                    <input class="form-control my-1" value="<?=set_value('username')?>" type="text" name="username" placeholder="Nombre usuario">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'username' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('email')?>" type="email" name="email" placeholder="Email">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'username' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['email'])):?>
                        <small class="error"><?=$errors['email']?></small>
                    <?php endif;?>

                    <select name="role" class="form-control my-1"> 
                        <option value="">--Seleccionar rol--</option>
                        <option <?=set_select('role','usuario')?> value="usuario">Usuario</option>
                        <option <?=set_select('role','admin')?> value="admin">Administrador</option>
                    </select>
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'role' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['role'])):?>
                        <small class="error"><?=$errors['role']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="Contraseña">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'password' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['password'])):?>
                        <small class="error"><?=$errors['password']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="Confirmar Contraseña">

                    <button class="btn bg-green">Crear</button>
                    <a href="<?=ROOT?>/admin/users">
                        <button type="button" class="float-end btn">Atrás</button>
                    </a>
                </form>
            </div>
            
        <!-- la acciona Edit(editar) cargara lo que sea que este dentro  -->
        <?php  elseif($action == 'edit'):?>

            <!-- estas líneas de código realizan una consulta a una base de datos para obtener una sola fila de la tabla users donde el valor de la columna id coincide con el valor de la variable $id. -->

            <div style="max-width: 500px; margin: auto">
                <form method="post">
                    <h3>Editar Usario</h3>

                    <?php if(!empty($row)):?>

                    <input class="form-control my-1" value="<?=set_value('username',$row['username'])?>" type="text" name="username" placeholder="Nombre usuario">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'username' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('email',$row['email'])?>" type="email" name="email" placeholder="Email">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'username' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['email'])):?>
                        <small class="error"><?=$errors['email']?></small>
                    <?php endif;?>

                    <select name="role" class="form-control my-1"> 
                        <option value="">--Seleccionar rol--</option>
                        <option <?=set_select('role','usuario',$row['role'])?> value="usuario">Usuario</option>
                        <option <?=set_select('role','admin',$row['role'])?> value="admin">Administrador</option>
                    </select>
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'role' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['role'])):?>
                        <small class="error"><?=$errors['role']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="(Dejar vacía para mantener la contraseña antigua)">
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'password' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['password'])):?>
                        <small class="error"><?=$errors['password']?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="Confirmar Contraseña">

                    <button class="btn bg-green">Editar</button>
                    <a href="<?=ROOT?>/admin/users">
                        <button type="button" class="float-end btn">Atrás</button>
                    </a>

                    <?php else:?>
                        <div class="alert">Ese registro no fue encontrado</div>
                        <a href="<?=ROOT?>/admin/users">
                            <button type="button" class="float-end btn">Atrás</button>
                        </a>    
                    <?php endif;?>    

                </form>
            </div>

        <!-- la acciona eliminar cargara lo que sea que este dentro (codigo) -->
        <?php  elseif($action == 'delete'):?>
            <div style="max-width: 500px; margin: auto">
                <form method="post">
                    <h3>Eliminar Usario</h3>

                    <?php if(!empty($row)):?>

                    <div class="form-control my-1"><?=set_value('username',$row['username'])?></div>
                    <!-- lo que estamos haciendo e condicional para verificar si la matriz $error de nombre 'username' no esta vacia ejecutara el if. en resumen este codigo mostrara un mensaje de error si los campos estan vacios o contienen algun error --> 
                    <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                    <?php endif;?>
                    
                    <div class="form-control my-1"><?=set_value('email',$row['email'])?></div>
                    <div class="form-control my-1"><?=set_value('role',$row['role'])?></div>
                    
                    <button class="btn bg-red">Borrar</button>
                    <a href="<?=ROOT?>/admin/users">
                        <button type="button" class="float-end btn">Atrás</button>
                    </a>

                    <?php else:?>
                        <div class="alert">Ese registro no fue encontrado</div>
                        <a href="<?=ROOT?>/admin/users">
                            <button type="button" class="float-end btn">Atrás</button>
                        </a>    
                    <?php endif;?>    

                </form>
            </div>

        <!-- else -> de lo contrario solo estaremos viendo la vista(html) -->   
        <?php else:?>

            <?php
                $query = "select * from users order by id desc limit 20";
                $rows = db_query($query);
            ?>

            <!-- Vista usuario -->
		    <h3>Usuarios 
                <a href="<?=ROOT?>/admin/users/add">
                    <button class="float-end btn bg-purple">Agregar Nuevo</button>
                 </a>
            </h3>

            <!-- creamos un elemento table para almacenar(mostrar) los usuarios -->
            <table class="table">

                <tr>
                    <th>ID</th>
                    <th>Nombre de usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr> 

                <?php if (!empty($rows)):?>
                    <?php foreach ($rows as $row):?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><?=$row['username']?></td>
                            <td><?=$row['email']?></td>
                            <td><?=$row['role']?></td>
                            <td><?=get_date($row['date'])?></td>
                            <td>
                                <a href="<?=ROOT?>/admin/users/edit/<?=$row['id']?>">
                                    <img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg" alt="">
                                </a>
                                <a href="<?=ROOT?>/admin/users/delete/<?=$row['id']?>">
                                    <img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg" alt="">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </table> 

        <?php endif;?>

	</section>

<?php require page('includes/admin-footer') ?>

<!--1. este código PHP está incluyendo los archivos admin-header.php y admin-footer.php para mostrar una página HTML que contiene un título "Usuarios" dentro de un bloque <section> con la clase admin-content. -->