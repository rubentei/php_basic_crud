<?php

class ControladorFormularios {

    /**
     * Registro
     */

    static public function ctrRegistro() {

        if (isset($_POST["registroNombre"])) {

            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["registroNombre"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["registroEmail"]) &&
                preg_match('/^[0-9a-zA-Z]+$/', $_POST["registroPassword"])) {

                $tabla = "registros";

                $token = md5($_POST["registroNombre"] ."+". $_POST["registroEmail"]);

                $encriptarPassword = crypt($_POST["registroPassword"], '$2a$05$xazyb1989jK56s8C2lZaqweERMG$');

                $datos = array(
                    "token" => $token,
                    "nombre" => $_POST["registroNombre"],
                    "email" => $_POST["registroEmail"],
                    "password" => $encriptarPassword
                );
    
                $respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);
    
                return $respuesta;
            } else {
                $respuesta = "error";
                return $respuesta;
            }
            
        }

    }

    /**
     * Seleccionar registros
     */

    static public function ctrSeleccionarRegistros($item, $valor) {
        $tabla = "registros";

        $respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

        return $respuesta;
    }


    /**
     * Ingreso
     */

    public function ctrIngreso() {

        if(isset($_POST["ingresoEmail"])) {

            $tabla = "registros";
            $item = "email";
            $valor = $_POST["ingresoEmail"];

            $respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

            $encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$05$xazyb1989jK56s8C2lZaqweERMG$');

            if ($respuesta["email"] ==  $_POST["ingresoEmail"] && $respuesta["password"] == $encriptarPassword) {

                ModeloFormularios::mdlActualizarIntentosFallidos($tabla, 0, $respuesta["token"]);

                $_SESSION["validarIngreso"] = "ok";
                
                echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState( null, null, window.location.href );
                }

                window.location = "index.php?pagina=inicio";
                </script>';

            } else {

                if ($respuesta["intentos_fallidos"] < 3) {

                    $intentos_fallidos = $respuesta["intentos_fallidos"] + 1;

                    ModeloFormularios::mdlActualizarIntentosFallidos($tabla, $intentos_fallidos, $respuesta["token"]);
                
                } else {

                    echo '<div class="alert alert-warning">RECAPTCHA - Validar que no eres un robot</div>';
                }

                echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState( null, null, window.location.href );
                }
                </script>';

                echo '<div class="alert alert-danger">Algo fue mal, el email o la contraseña no son válidos</div>';
            }
        }

    }

    /**
     * Actualizar registro
     * 
     */
    static public function ctrActualizarRegistro() {

        if (isset($_POST["actualizarNombre"])) {

            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["actualizarNombre"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["actualizarEmail"])
                ) {

                $tabla = "registros";

                $usuario = ModeloFormularios::mdlSeleccionarRegistros($tabla, "token", $_POST["tokenUsuario"]);
    
                $compararToken = md5($usuario["nombre"] ."+". $usuario["email"]);
        
                if ($compararToken == $_POST["tokenUsuario"]) {
                    if ($_POST["actualizarPassword"] != "") {

                        if (preg_match('/^[0-9a-zA-Z]+$/', $_POST["actualizarPassword"])) {
                            
                            $password = crypt($_POST["actualizarPassword"], '$2a$05$xazyb1989jK56s8C2lZaqweERMG$');
                        }
                        
                    } else {
                        $password = $_POST["passwordActual"];
                    }
        
       
                    $nuevoToken = md5($_POST["actualizarNombre"] ."+". $_POST["actualizarEmail"]);
                    
                    $datos = array(
                        "token" => $nuevoToken,
                        "nombre" => $_POST["actualizarNombre"],
                        "email" => $_POST["actualizarEmail"],
                        "password" => $password,
                        "old_token" => $compararToken
                    );

                    $respuesta = ModeloFormularios::mdlActualizarRegistro($tabla, $datos);
        
                    return $respuesta;
                } else {

                    $respuesta = "error";

                    return $respuesta;
                }

            } else {

                $respuesta = "error";

                return $respuesta;
            }
        }

    }

    /**
     * Eliminar registro
     */

    public function ctrEliminarRegistro() {
        if (isset($_POST["eliminarRegistro"])) {
            
            $tabla = "registros";

            $usuario = ModeloFormularios::mdlSeleccionarRegistros($tabla, "token", $_POST["eliminarRegistro"]);
            
            $compararToken = md5($usuario["nombre"] ."+". $usuario["email"]);

            if ($compararToken == $_POST["eliminarRegistro"]) {
                
                $valor = $_POST["eliminarRegistro"];

                $respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

                if ($respuesta == "ok") {
                    echo '<script>
                    if (window.history.replaceState) {
                        window.history.replaceState( null, null, window.location.href );
                    }

                    window.location = "index.php?pagina=inicio";

                    </script>';
                }

                return $respuesta;
            }

        }
    }


}