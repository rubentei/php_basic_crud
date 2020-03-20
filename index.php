<?php

#require() establece que el código del archivo invocado es requerido, es decir, obligatorio para el funcionamiento del programa. Por ello, si el archivo especificado en la fución require() no se encuentra saltará un error "PHP fatal error" y el programa PHP se detendrá.

require_once "./controladores/plantilla.controlador.php";

require_once "./controladores/formularios.controlador.php";
require_once "./modelos/formularios.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrTraerPlantilla();