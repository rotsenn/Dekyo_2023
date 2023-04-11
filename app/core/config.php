<?php

    /* 
        vamos a comprobar si estamos en el servidor local o en el sercidor web
    */

    if($_SERVER['SERVER_NAME'] == "localhost")
        //Tenemos una variable global llamada $_SERVER en php. vamos a compara en que  servidor nos encontramos   
    {

        //Para servidor local
        define("ROOT", "http://localhost/website_music/public"); //Servior local(localhost)

        define("DBDRIVER", "mysql");
        define("DBHOST", "localhost");
        define("DBUSER", "root");
        define("DBPASS", "1000445752");
        define("DBNAME", "website_music_db");

    } else {

        //Para un servidor
        define("ROOT", "http://www.mywebsite.com");//Servidor web

        define("DBDRIVER", "mysql");
        define("DBHOST", "localhost");
        define("DBUSER", "root");
        define("DBPASS", "");
        define("DBNAME", "website_music_db");
        /*Tenemos dos configuraciones 
        1. una para el servidor local y 
        2. otral para el servidor web
        */
    }





    /* es una condicional que comprueba si el valor de la variable $_SERVER['SERVER_NAME'] es igual a "localhost". $_SERVER es una variable superglobal en PHP que contiene información sobre el servidor y el entorno en el que se está ejecutando el script actual.

    Si la condición es verdadera (es decir, si se está ejecutando el script en el servidor local), se define la constante ROOT con el valor "http://localhost/website_music/public". En caso contrario (es decir, si el script se está ejecutando en un servidor web), se define la constante ROOT con el valor "http://www.mywebsite.com".

    Esta constante ROOT se puede utilizar en el resto del código para referirse a la ruta base del sitio web, independientemente de si se está ejecutando en un servidor local o en un servidor web.*/

       
        


    