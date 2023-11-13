<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="Style2.css">
</head>
<body>
    <header>
        <div class="content-1"><img class="imagen-1" src="https://prowly-uploads.s3.eu-west-1.amazonaws.com/uploads/5726/assets/73418/large_doctoralia-mktpl-symbol-turquoise.png">
            <h1 class="text-1">Doom</h1></div>
        <div class="content-2">
            <?php 
            session_start();             
            if(!isset($_SESSION['id'])){
                echo '<a class="link-1" href="login.php"><p class="text-2">Login/</p></a>';
                echo '<a class="link-2" href="Register.php"><p class="text-3">Register</p></a>';
                header("location:index.php");
            }else{
                $nombre=$_SESSION['nombre'];
                echo "<a class='link-2' href='Cerrar-sesion.php'><p class='text-3'>Cerrar Sesion</p></a>";
                $imagen=$_SESSION["imagen"];
                echo "<a href='actualizar-perfil.php'><div class='imagen-2'> <img class='img-1' src='$imagen'></div></a>";
                $_SESSION["id_pregunta"]=''; 
                
            }
            ?>
                      
        </div>
    </header>
    <main>
    <div class="contenedor">
    <div class="regreso"><a href="index.php"><img class="img-5" src="https://img.freepik.com/psd-gratis/diseno-flechas-degradado_23-2150390286.jpg?size=338&ext=jpg&ga=GA1.1.1826414947.1699488000&semt=ais"></a></div>
        <form method='post' action='realiza-actualizacion.php' enctype="multipart/form-data">
        <div class="box-2"><h2 class="text-5">Actualizar Perfil.</h2></div>
        <div class='box-2'>
        <div class='box-6'><p class='text-5'>Nombre de Usuario:</p>
        <input class='tex1' type='text' id='enlace1' name='usuario' placeholder='Nombre de usuario'> </div>
        </div>
        <div class='box-2'>
        <div class='nomb'><p class='text-5'>Correo:</p> 
        <input class='tex1' type='text' id='enlace1' name='Correo' placeholder='example@gmail.com'> </div>
        </div>
        <div class='box-2'>
        <div class='nomb'><p class='text-5'>Contraseña:</p>  
        <input class='tex1' id='enlace1' type='password' name='Contra' placeholder='Contraseña'> </div>
        </div>
        <div class='box-2'>
        <div class='nombres'><p class='text-5'>Foto de Perfil:</p>
        <input class='nom' type='file' id='enlace1' name='Foto' accept="image/*"></div>
        <br>
        </div><br>
        <div class='box-2'>
        <div class='envia'><input type='hidden' name='id' value='" . $id . "'><input name='accion' type='submit' value='realizar-actualizacion'></div>
        </div>
        </form><br>
            <div class="box-2">
                
                <a href="eliminar-cuenta.php"><input type="submit" value="Eliminar-cuenta"></a>
            </div>
            </div>
    </main>
    <div class="f"></div>
    <footer><h3>Elaborado por Hugo David Nogueda Hernández</h3></footer>
</body>
</html>