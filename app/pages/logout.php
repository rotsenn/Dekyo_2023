<?php

    /* utiliza para cerrar la sesión de usuario y redirigir al usuario a la página de inicio de sesión. */

    if(!empty($_SESSION['USER']))
    {
        unset($_SESSION['USER']);
        session_destroy();
        session_regenerate_id();
    }
    redirect('login');

    /* 
    Primero, la condición !empty($_SESSION['USER']) verifica si la variable de sesión $_SESSION['USER'] no está vacía, lo que significa que el usuario ha iniciado sesión. Si se cumple esta condición, se lleva a cabo el siguiente conjunto de instrucciones:

    unset($_SESSION['USER']): elimina la variable de sesión $_SESSION['USER'] que contiene la información del usuario.
    session_destroy(): destruye toda la información registrada en la sesión actual.
    session_regenerate_id(): regenera el identificador de sesión para mejorar la seguridad de la sesión.
    Después de cerrar la sesión de usuario, la función redirect() redirige al usuario a la página de inicio de sesión. */