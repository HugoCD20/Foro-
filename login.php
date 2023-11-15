<?php 
session_start();
if(isset($_SESSION['id'])){
    header("location:index.php");
    exit();
}else{
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <header>
        <div class="content-1"><img class="imagen-1" src="https://prowly-uploads.s3.eu-west-1.amazonaws.com/uploads/5726/assets/73418/large_doctoralia-mktpl-symbol-turquoise.png">
            <h1 class="text-1">Doom</h1></div>
        <div class="content-2">
            <a class="link-2" href="index.php"><p class="text-3">Home</p></a>            
        </div>
    </header>
    
    <main>
    <div class="contenedor">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="box-2"><h2 class="text-5">INGRESAR.</h2></div>
            <div class="box-2">
                <div class="box-6"><p class="text-5">Nombre de Usuario:</p> 
                    <input class="tex1" type="text" id="enlace1" name="Nusuario" placeholder="Nombre de usuario"> </div>
            </div>
            <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $Nusuario=$_POST['Nusuario'];
                        if(empty($Nusuario)){
                            echo '<center> <p class="error">Coloca un nombre de usuario</p> </center>';
                        }
                        if(strlen($Nusuario)>100){
                            echo '<center> <p class="error">EL nombre de usuario no es valido</p> </center>';
                        }
                    }
            ?>     
            <div class="box-2">
                <div class="nomb"><p class="text-5">Contraseña:</p> 
                    <input class="tex1" id="enlace1" type="password" name="Contraseña"  placeholder="Contraseña"> </div>
            </div>
            <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $Contraseña=$_POST['Contraseña'];
                        if(empty($Contraseña)){
                            echo '<center> <p class="error">Coloca una contraseña</p> </center>';
                        }
                        if(strlen($Contraseña)>100){
                            echo '<center> <p class="error">La contraseña no es valida</p> </center>';
                        }
                    
                    }
            ?>
            <div class="box-2">
                <div class="envia"> <input class="envio" type="submit"></div>
            </div>
            <?php 
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                include("login-conexion.php");
            }
            ?>
           </form>
           <a class="enlace"  href="Register.php"><center><p>No tengo una cuenta </p></center></a>
        </div>
    </main>
    <div class="f"></div>
    <footer><h3>Elaborado por Hugo David Nogueda Hernández</h3></footer>
</body>
</html>