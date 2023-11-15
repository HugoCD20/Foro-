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
    <title>Register</title>
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
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="box-2"><h2 class="text-5">REGISTRO.</h2></div>
            
            <div class="box-2">
                <div class="nomb"><p class="text-5">Nombre de Usuario:</p> 
                    <input class="tex1" type="text" id="enlace1" name="Nusuario" placeholder="Nombre de usuario"> </div>
            </div>
            <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $Nusuario=$_POST['Nusuario'];
                        if(empty($Nusuario)){
                            echo '<center> <p class="error">Coloca un nombre de usuario</p> </center>';
                        }
                        if(strlen($Nusuario)>100){
                            echo '<center> <p class="error">Nombre de usuario demasiado largo</p> </center>';
                        }
                    }
            ?>     
            <div class="box-2">
                <div class="nomb"><p class="text-5">Correo:</p> 
                    <input class="tex1" type="text" id="enlace1" name="Correo" placeholder="example@gmail.com"> </div>                    
            </div>
            <?php 
                    $cor=true;
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $Correo=$_POST['Correo'];
                        if(empty($Correo)){
                            echo '<center> <p class="error">Coloca un correo</p> </center>';
                        }
                        if(strlen($Correo)>100){
                            echo '<center> <p class="error">Correo electronico demasiado largo</p> </center>';
                        }

                        // Filtrar el correo electrónico usando filter_var
                        $correoFiltrado = filter_var($Correo, FILTER_VALIDATE_EMAIL);                        
                        if ($correoFiltrado == false) {
                            echo '<center> <p class="error">Correo no valido</p> </center>';
                        } 
                            
                    }
            ?>
            <div class="box-2">
                <div class="nomb"><p class="text-5">Contraseña:</p> 
                    <input class="tex1" id="enlace1" type="password" name="Contraseña" placeholder="Contraseña"> </div>
            </div>
            <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $Contraseña=$_POST['Contraseña'];
                        if(empty($Contraseña)){
                            echo '<center> <p class="error">Coloca una contraseña</p> </center>';
                        }elseif(strlen($Contraseña)<3){
                            echo '<center> <p class="error">Contraseña demasiado corta</p> </center>';
                        }
                        if(strlen($Contraseña)>100){
                            echo '<center> <p class="error">Contraseña demasiada larga</p> </center>';
                        }
                    }
            ?>
            <div class="box-2">
                <div class="nomb"><p class="text-5">Confirmar Contraseña:</p> 
                    <input class="tex1" id="enlace1" type="password" name="Contra" placeholder="Confirmar contraseña"></div>               
                </div>
                <?php 
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $contraseña=$_POST['Contraseña'];
                        $Contra=$_POST['Contra'];
                        if($contraseña!=$Contra){
                            echo '<center> <p class="error">Las contraseñas no coinciden</p> </center>';
                        }
                    }
                    ?>        
            <div class="box-2">
                <div class="nomb"><p class="text-5">Sube una fotografía: <br>
                    <ul class="text-5">
                        <li>Tipo: PNG, JPG, JPEG</li>
                        <li>Peso menor o igual a 3M</li>
                        <a class="enlace" href="https://www.iloveimg.com/es/recortar-imagen" target="_blank"><li>de preferencia usa una imagen cuadrada si no es <br> cuadrada puedes dar click aqui(opcional)</li></a>
                       
                    </ul>
            </p> 
                  <input class="box-2" type="file" name="foto" accept="image/*"></div>               
              </div>    
            <div class="box-2">
                <div class="envia"> <input class="envio" type="submit"></div>
                <?php 
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
               include("validar.php");
                }
                ?>
            </div>
           </form>
           <a class="enlace"  href="login.php"><center><p>Ya tengo una cuenta</p></center></a>
       
        </div>
    </main>
    <footer><h3>Elaborado por Hugo David Nogueda Hernández</h3></footer>
</body>
</html>