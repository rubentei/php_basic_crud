<div class="d-flex justify-content-center text-center">
    <form class="p-5 bg-light" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>

            <div class="input-group">
                    
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>

                <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="registroNombre">
            </div>    
        </div>

        <div class="form-group">
            <label for="eamil">Correo electrónico:</label>

            <div class="input-group">
                    
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>

                <input type="email" class="form-control" placeholder="E-mail" id="email" name="registroEmail">
            </div>
        </div>

        <div class="form-group">
            <label for="pwd">Contraseña:</label>

            <div class="input-group">
                    
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
            
                <input type="password" class="form-control" placeholder="Contraseña" id="pwd" name="registroPassword">
            </div>
        </div>

        <?php

            /**
             * Forma en la que se instancia la clase
             * de un método no estático
             */
            // $registro = new ControladorFormularios();
            // $registro->ctrRegistro();

            /**
             * Forma en la que se instancia la clase
             * de un método estático
             */
            $registro = ControladorFormularios::ctrRegistro();
            
            if ($registro == "ok") {
                
                echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState( null, null, window.location.href );
                }
                </script>';

                echo '<div class="alert alert-success">El usuario ha sido registrado</div>';
            }

            if ($registro == "error") {
                echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState( null, null, window.location.href );
                }
                </script>';

                echo '<div class="alert alert-danger">Eror, no se permiten caracteres especiales</div>';
            }
        ?>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>