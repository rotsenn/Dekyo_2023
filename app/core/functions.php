<?php

    function show($stuff)
	{
		echo "<pre>";
		print_r($stuff);
		echo "</pre>";

	}

    function page($file)
    {
        return "../app/pages/".$file.".php";
    }

    /*
    La primera función llamada show($stuff) toma una variable $stuff y la imprime en la página web envolviéndola en etiquetas <pre> y utilizando la función print_r(). La etiqueta <pre> es útil para mostrar la salida de manera legible y estructurada, especialmente para la salida de matrices y objetos.

    La segunda función llamada page($file) devuelve una cadena de texto que representa la ruta de un archivo PHP. La ruta devuelta es relativa a la ubicación del archivo que contiene la función, y se compone de la carpeta "../app/pages/" y el nombre del archivo pasado como argumento, más la extensión ".php".

    En resumen, la primera función es útil para imprimir variables en una página web de manera legible, mientras que la segunda función es útil para generar rutas de archivos dinámicamente en un proyecto PHP.
    */

    //------------------------------------------

    /*Creasmos una funcion para la conexion a la base de datos
        nombre de la funcion -> db_connect()
    */
    function db_connect()
    {
        $string = DBDRIVER.":hostname=".DBHOST.";dbname=".DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);

        /*
        vamos a usar PDO para prevenir inyecciones(ataques) SQL
        DBUSER -> usuario db, DBPASS -> Contraseña db
        DBDRIVER -> Controlador db
        */
        return $con;
        /*debera retornar la variable $con*/
    }


    /* 
    necesitamos otra función llamada db_query
    que se usara para ejecutar una consulta
    */
    function db_query($query, $data = array())
    {
        $con = db_connect();

        $stm = $con->prepare($query);
        if($stm)
        {
            $check = $stm->execute($data);
            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                if(is_array($result) && count($result) > 0 )
                {
                    return $result;
                }
            }
        }

        return false;
        //return false; si las cosas no salen bien
    }

    //show(db_connect());

    /*
    La función db_query es una función PHP que se utiliza para ejecutar consultas SQL en una base de datos utilizando la biblioteca de PDO. Aquí hay una descripción detallada de lo que hace cada línea de esta función:

    La función acepta dos argumentos: $query, que es la consulta SQL que se va a ejecutar, y $data, que es un arreglo que contiene los valores que se van a vincular a la consulta preparada. $data es un arreglo vacío por defecto, lo que significa que si no se proporciona ningún valor para este argumento, se utilizará un arreglo vacío.

    La función llama a otra función llamada db_connect que probablemente establece una conexión con una base de datos. Es probable que esta función devuelva un objeto PDO que se utiliza en la siguiente línea.

    La función crea un objeto preparado PDO utilizando la consulta $query pasada como argumento y lo almacena en la variable $stm.

    La función verifica si el objeto preparado $stm se creó correctamente, si no se creó, la función devuelve false.

    Si el objeto preparado $stm se creó correctamente, la función ejecuta la consulta preparada utilizando el arreglo $data como parámetro para la función execute del objeto PDO. $check se utiliza para verificar si la consulta se ejecutó correctamente.

    Si la consulta se ejecutó correctamente, la función llama a la función fetchAll del objeto preparado PDO para recuperar todos los resultados de la consulta en un arreglo asociativo. Luego, la función verifica si se devolvió un arreglo y si tiene un tamaño mayor a cero.

    Si se encontraron resultados y se almacenaron en $result, la función devuelve este arreglo. De lo contrario, la función devuelve false.

    En resumen, la función db_query se utiliza para ejecutar consultas SQL en una base de datos y devolver los resultados como un arreglo asociativo. Si se produce un error al crear la consulta preparada o al ejecutar la consulta, la función devuelve false.
    */
    

    //diplicamos funcion anterior

    function db_query_one($query, $data = array())
    {
        $con = db_connect();

        $stm = $con->prepare($query);
        if($stm)
        {
            $check = $stm->execute($data);
            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                if(is_array($result) && count($result) > 0 ){
                    return $result[0];
                }
            }
        }

        return false;
        //return false; si las cosas no salen bien
    }

    
    /*
    cuando guardas un perfil o editas un usuario es buena idea tener un mensaje en la parte superior de la sección de Administracción que diga:
        * el perfil de guardo correctamente *
    */
    function message($message = '', $clear = false)
    {
        if(!empty($message)){
            $_SESSION['message'] = $message;
        } else {

            if (!empty($_SESSION['message'])) {

                $msg = $_SESSION['message'];
                if($clear){
                    unset($_SESSION['message']);
                }
                return $msg;
            }

        }
        return false;
    }

    /*
    Las líneas de código que muestras corresponden a una función llamada message en PHP. Esta función se utiliza para gestionar mensajes entre páginas o entre solicitudes en una aplicación web.

    La función acepta dos parámetros opcionales: $message y $clear. $message es una cadena de texto que representa el mensaje que se desea guardar o recuperar. $clear es una bandera booleana que determina si el mensaje debe borrarse después de que se haya recuperado.

    La función comienza verificando si se ha pasado un mensaje. Si se ha pasado, se guarda en una variable de sesión llamada $_SESSION['message']. Si no se ha pasado un mensaje, la función verifica si hay un mensaje en $_SESSION['message']. Si existe un mensaje, se guarda en una variable llamada $msg. Si $clear es verdadero, la función borra el mensaje de $_SESSION['message']. Finalmente, la función devuelve $msg si existe, de lo contrario devuelve false.

    En resumen, la función message se utiliza para guardar y recuperar mensajes en una aplicación web a través de variables de sesión.
    */


    #Funcion rediect(de user.php)

    function redirect($page)
    /*funcion redirec($page) me dira a que pagina a la que se desea redirigir el usuario*/
    {
        header("Location: ".ROOT."/".$page);
        die;
    }

    /* Estas líneas de código definen una función llamada "redirect" que toma un 	argumento "$page" que representa la página a la que se desea redirigir al 	usuario.

	La función utiliza la función "header" de PHP para enviar una respuesta HTTP 	al navegador del usuario, lo que le indica que redirija al usuario a la página 	especificada por el argumento $page. La constante "ROOT" representa la ruta base del sitio web y se utiliza para construir la URL de la página de destino.

	Después de enviar la respuesta HTTP de redirección, la función utiliza la 	función "die" para finalizar la ejecución del script de PHP, lo que garantiza 	que el usuario sea redirigido inmediatamente a la nueva página sin que se 	ejecute ningún otro código adicional en la página actual. */


    function set_value($key, $default = '')
    {
        if(!empty($_POST[$key]))
        {
            return $_POST[$key];
        } else {

            return $default;

        }

        return '';
    }
    /* esta función se utiliza para obtener el valor de un campo de formulario enviado a través del método POST en PHP. Si el valor no está vacío, 	se devuelve el valor del campo de formulario, de lo contrario, se devuelve una 	cadena vacía. */


    function set_select($key, $value, $default = '')
    {
        if(!empty($_POST[$key]))
        {
            if ($_POST[$key] == $value) {
                return " selected ";
            }
        } else {
            if ($default == $value) {
                return " selected ";
            }
        }

        return '';
    }

    /* esta función se utiliza para preseleccionar una opción en un campo de formulario HTML select o radio, según los valores enviados a través de $_POST. Si el valor enviado a través de $_POST para la clave dada en $key es igual al valor $value, se devuelve un espacio en blanco con el atributo "selected", lo que indica que la opción debe ser seleccionada. De lo contrario, se devuelve el valor enviado a través de $_POST para la clave dada en $key o una cadena vacía si no se envió ningún valor. */


    function get_date($date)
    {
        return date("jS M,Y", strtotime($date));
    }

    /* En la función get_date(), el formato de fecha especificado es "jS M,Y", que produce una fecha en el formato "Día del mes en letras (ordinal) Mes en letras, Año". Por ejemplo, la fecha "2023-04-05" se mostraría como "5th Apr, 2023". */

    //--------------------------------------

    //Ahora vamos a crear una funcion para saber cuando se esta logueando un usuario
    function logged_in()
    {
        if(!empty($_SESSION['USER']) && is_array($_SESSION['USER'])){
            return true;
        }

        return false;
    }

    /* En particular, la función comprueba si la variable de sesión $_SESSION['USER'] 	no está vacía y es un array, lo que sugiere que se ha establecido una sesión 	para el usuario y se han almacenado algunos datos en la variable de sesión. Si 	la variable de sesión está establecida y es un array, la función devuelve 	true. Si la variable de sesión no está establecida o no es un array, la funció	n devuelve false. */

    //-------------------------------------

    //Ahora vamos a crear una funcion para saber cuando se esta logueando un administrador
    function is_admin()
    {
        if(!empty($_SESSION['USER']['role']) && $_SESSION['USER']['role'] == 'admin'){
            return true;
        }

        return false;
    }

    /* La función comprueba si la variable de sesión $_SESSION['USER']['role'] no está vacía y si su valor es "admin". Si se cumple esta condición, la función devuelve true, lo que significa que el usuario tiene un rol de "admin". Si la condición no se cumple, la función devuelve false, lo que indica que el usuario no tiene un rol de "admin". */

    //-------------------------------------

    //Ahora vamos a hacer una funcion para agarrar cualquier usuario(obtener información sobre el usuario que ha iniciado sesión en el sitio web)
    function user($column)
    {
        if(!empty($_SESSION['USER'][$column])){
            return $_SESSION['USER'][$column];
        }
    }

    /* esta función se utiliza para recuperar información específica del usuario que ha iniciado sesión en el sitio web. Por ejemplo, si se llama a user('username'), la función devolverá el nombre de usuario del usuario que ha iniciado sesión en el sitio web, siempre y cuando esté disponible en la variable de sesión $_SESSION['USER']. Si no se encuentra la información correspondiente, la función no devuelve nada. */

    //--------------------------------------

    //Sesion de Usuarios depues que se haya autenticado en el sitio web. para autenticar a un usuario en el sitio web y establecer una sesión de usuario.

    function authenticate($row)
    {
        $_SESSION['USER'] = $row;
    }

    /* esta función se utiliza para establecer una sesión de usuario después de que se haya autenticado en el sitio web. Después de llamar a esta función, se puede utilizar la variable de sesión $_SESSION['USER'] para acceder a la información del usuario y proporcionar una experiencia personalizada en el sitio web. */

    //---------------------------------------
    

    //
    function str_to_url($url)
    {
        $url = str_replace("'", "", $url);
   	    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
   	    $url = trim($url, "-");
   	    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
   	    $url = strtolower($url);
   	    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
   	
    	return $url;
    }

    function get_category($id)
    {
        $query = "select category from categories where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);

        if(!empty($row['category']))
        {
            return $row['category'];
        }

        return "Desconocido";
    }

    function esc($str)
    {
	    return nl2br(htmlspecialchars($str));
    }

    function get_artist($id)
        {
	$query = "select name from artists where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if(!empty($row['name']))
	{
		return $row['name'];
	}

	return "Desconocido";
}

