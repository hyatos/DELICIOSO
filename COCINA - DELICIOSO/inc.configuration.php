<?php

// Visualizacion de errores
ini_set("display_error",1);
error_reporting(E_ALL);

// Seteamos el arreglo de conexión con la base de datos
$config["db"]="bibliotech";
$config["dbuser"]="root";
$config["dbpass"]="";
$config["dbhost"]="localhost";
$config["dbEngine"]="MYSQL";

// Constantes del sistema
define("_OK","OK");
define("_ERROR","Error");

?>