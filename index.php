<?php
   session_start();

   if(isset($_SESSION['usuario'])){
     
      header("location:pagina_principal.php");
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro - HarolCamacho</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilosLogin2.css">
</head>
<body>

    <!-- Contenido principal -->
    <main>
        <div class="contenedor__todo">

            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion"> Iniciar sesión </button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse"> Registrarse </button>
                </div>
            </div>

            <!-- Formularios de login y registro -->
            <div class="contenedor__login-register">
                <!-- Login -->
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar sesión</h2>
                    <input type="text" placeholder="Correo Electrónico" name="correo">
                    <input type="password" placeholder="Contraseña" name="contrasena">
                    <button>Entrar</button>
                </form>

                <!-- Registro -->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                    <input type="text" placeholder="Correo Electrónico" name="correo">
                    <input type="text" placeholder="Usuario" name="usuario">
                    <input type="password" placeholder="Contraseña" name="contrasena">
                    <button>Registrarse</button>
                </form>
            </div>

        </div>
    </main>

    <!-- Botón Modo Administrador -->
    <button class="admin-btn" id="adminBtn">Modo Administrador</button>

<!-- Contenedor del modal de administrador -->
<div id="adminModal">
    <div id="adminModalContent">
        <div id="adminContainer">
            <h2 id="tituloAdmin">Acceso Administrador</h2>
            <input id="adminUser" type="text" placeholder="Usuario">
            <input id="adminPassword" type="password" placeholder="Contraseña">
            <button id="adminLoginBtn">Entrar</button>
        </div>
    </div>
</div>


    <script src="assets/js/adminLogin2.js"></script>
    <script src ="assets/js/script.js"></script>
</body>
</html>
