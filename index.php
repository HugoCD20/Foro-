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
            <?php session_start();             
            if(!isset($_SESSION['id'])){
                echo '<a class="link-1" href="login.php"><p class="text-2">Login/</p></a>';
                echo '<a class="link-2" href="Register.php"><p class="text-3">Register</p></a>';
            }else{
                $nombre=$_SESSION['nombre'];
                echo "<a class='link-2' href='Cerrar-sesion.php'><p class='text-3'>Cerrar Sesion</p></a>";
                $imagen=$_SESSION["imagen"];
                echo "<a href='actualizar-perfil.php'><div class='imagen-2'> <img class='img-1' src='$imagen'></div></a>";
                $_SESSION["id_pregunta"]=null; 
                
            }
            ?>
                      
        </div>
    </header>
    <main>
        <?php 
            if(isset($_SESSION['id'])){
        echo '<form style="width:100%;" action="pro-pregunta.php" method="post" enctype="multipart/form-data">';
        }
            ?>
        <div <?php if(!isset($_SESSION['id'])){echo "style='width:100%;'";}?>class="question"> 
        <?php         
            if(isset($_SESSION['id'])){
                $imagen=$_SESSION["imagen"];
                echo "<div class='imagen-2'> <img class='img-1' src='$imagen' alt='Profile Picture'></div>";


                
            }else{
                echo "<div class='imagen-2'> <img class='img-1' src='https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png'></div>";
            }
            ?>    
           
            <div class="question-2">
                <div class="title"><h2>Has una pregunta!!</h2></div>
                <div class="text-box"><div style="width:75%;"><input class="box" type="text" name="pregunta"></div>
                <div style="width:100%; margin-top:5px ;"><input style="width:100%;" type="file" name="Foto" accept="image/*"></div></div>     
                <?php 
                if(isset($_SESSION['id'])){
                    echo "<div class='enviar'><input type='submit' value='Enviar' id='submit'></div>";
                    if(isset($_SESSION['error'])){
                        echo "<center> <p class='error'>$_SESSION[error]</p> </center>";
                        $_SESSION['error']=null;
                    }
                    
                }else{
                    echo "<center> <p class='error'>Inicia sesion para hacer una pregunta</p> </center>";
                }                    
                    ?>       
                
            </div>
        </div>
        <?php 
            if(isset($_SESSION['id'])){
            echo "</form>";
            }
        ?>
    <div class="content-3">
    <?php 
     try {
        include("conexion.php");
        $conexion->exec("SET CHARACTER SET utf8");
        $consulta = "SELECT * FROM preguntas";
        $stmt = $conexion->prepare($consulta);
        $stmt->execute();
        $registro = array();
        if ($stmt->rowCount() > 0) {
            while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_usuario = $registro['id_usuario'];
                 $consulta2 = "SELECT * FROM registro where id = :id_usuario";
                 $stmt2 = $conexion->prepare($consulta2);
                 $stmt2->bindParam(':id_usuario', $id_usuario);
                 $stmt2->execute();
                $registro2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                echo "<form  action='decision.php' method='POST'>";
                echo "<div class='pregunta'>";
                echo " <div class='title-1'><div class='title-2'><img class='imagen-3' src='$registro2[foto]'></div>";
                echo "<div class='text-4'><p>".$registro['pregunta']."</p></div> ";
                if(isset($_SESSION['id'])){
                    if($_SESSION['id']== $id_usuario){
                        echo "<div class='botones'><button class='button-5' name='accion' value='eliminar'><img class='img-4' src='https://cdn-icons-png.flaticon.com/512/980/980403.png'></button></div></div>";
                }else{
                    echo "</div>";
                }
                }else{
                    echo "</div>";
                }
                if($registro['foto']!='sin-imagen'){
                    echo "<div class='image-3'><img class='image-4' src='$registro[foto]'></div>";
                    }
                echo " <div class='responder'><button class='button-1' name='accion' value='responder'>Responder↴</button></div>";
                echo "<input type='hidden' name='id-pregunta' value='".$registro['id']. "'>";
                echo "</div>";
                echo "</form>";
            }
        } else {
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    </div>
    </main>
    <div class="f"></div>
    <footer><h3>Elaborado por Hugo David Nogueda Hernández</h3></footer>
</body>
</html>