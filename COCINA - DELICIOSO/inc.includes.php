<?php
// incluimos los archivos y clases generales que el sistema requiere
include ("inc.configuration.php");
include ("../../recursos/_php/class.MySQL.php");

include ("../../recursos/_php/class.TemplatePower.inc.php");

// incluimos los controladores y models propios del sistema
include ("CONTROLADOR/ingreso.controller.php");

include ("CONTROLADOR/login.controller.php");

include ("MODELO/usuario.model.php");

include ("CONTROLADOR/socio.controller.php");
include ("MODELO/socio.model.php");


include ("CONTROLADOR/libro.controller.php");
include ("MODELO/libro.model.php");


include ("CONTROLADOR/prestamo.controller.php");
include ("MODELO/prestamo.model.php");





?>