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
        <?php session_start();             
            if(!isset($_SESSION['id'])){
                echo '<a class="link-1" href="login.php"><p class="text-2">Login/</p></a>';
                echo '<a class="link-2" href="Register.php"><p class="text-3">Register</p></a>';
            }else{
                echo '<a class="link-2" href="index.php"><p class="text-3">Home</p></a>'; 
                $imagen=$_SESSION["imagen"];
                echo "<div class='imagen-2'> <img class='img-1' src='$imagen'></div>";
                
            }
            ?>              
        </div>
    </header>
    
    <main>
    <div class="content-3">
    <?php 
    if(isset($_SESSION['id_pregunta'])){
        $id_pregunta=$_SESSION["id_pregunta"]; 
        if($_SESSION['id_pregunta']==''){
            $id_pregunta= $_POST['id-pregunta'];
        }       
    }
    $accion=$_POST["accion"];
    if($accion==null){
        header('location:respuestas.php');
        exit();
    }
    if($accion=="insertar"){
     try {
        include("conexion.php");
        $conexion->exec("SET CHARACTER SET utf8");
        $consulta = "SELECT * FROM preguntas where id = :id_pregunta";
        $stmt = $conexion->prepare($consulta);        
        $stmt ->bindParam(':id_pregunta',$id_pregunta);
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
                echo "<form  action='respuestas.php' method='POST'>";
                echo "<div class='pregunta'>";
                echo " <div class='title-1'><div class='title-2'><img class='imagen-3' src='$registro2[foto]'></div>";
                echo "<div class='text-4'><p>".$registro['pregunta']."</p></div> </div>";
                if($registro['foto']!='sin-imagen'){
                    echo "<div class='image-3'><img class='image-4' src='$registro[foto]'></div>";
                    }
                echo "</div>";
                echo "</form>";
            }
        } else {
            echo '<center> <p class="error">Contraseña o correo electrónico incorrectos</p> </center>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    }
    ?>
    </div>
    <div class="question-4">
    <div class="regreso"><a href="respuestas.php"><img class="img-5" src="https://img.freepik.com/psd-gratis/diseno-flechas-degradado_23-2150390286.jpg?size=338&ext=jpg&ga=GA1.1.1826414947.1699488000&semt=ais"></a></div>
    <?php     
    $id_respuesta=$_POST['id-respusta'];
     if($accion=="insertar" || $accion=="actualizar"){
     try {
        include("conexion.php");        
        $conexion->exec("SET CHARACTER SET utf8");
        $consulta = "SELECT * FROM respuestas where id_pregunta=:id_pregunta and id=:id_respuesta";
        $stmt = $conexion->prepare($consulta);
        $stmt -> bindParam(':id_pregunta',$id_pregunta);
        $stmt -> bindParam(':id_respuesta',$id_respuesta);
        $stmt->execute();
        $registro = array();
        if ($stmt->rowCount() > 0) {
            while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='text-4'>  <p>".$registro['respuesta']."</div> ";
                echo "<input type='hidden' name='id-respusta' value='".$registro['id']. "'>";           
                echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";  
                
            }
        } else {
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    }
    ?>
    <?php  
            if($accion=='insertar'){
            echo '<form action="enviar-respuestas.php" method="post" enctype="multipart/form-data">';
            echo '<div class="question-3">'; 
            if(isset($_SESSION['id'])){
                $imagen=$_SESSION["imagen"];
                echo "<div class='imagen-4'> <img class='img-2' src='$imagen'></div>";             
            }else{
                echo "<div class='imagen-4'> <img class='img-2' src='https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png'></div>";
            }  
            echo '<div class="question-2">';
            echo '<div class="title"><h2>Responder!!</h2></div>';
            echo '   <div class="text-box"><div><input class="box" type="text" name="pregunta"></div>';
            echo '  <div class="enviar"><input type="submit" value="Responder" id="submit"></div></div>';
            echo "<input type='hidden' name='id-pregunta' value=' $id_pregunta'>";
            echo "<input type='hidden' name='id-respuesta' value=' $id_respuesta'>";
            echo '</div>';
            echo ' </div>';
            echo '</form>';
        }elseif($accion=='eliminar'){
            echo '<form action="eliminar.php" method="post" enctype="multipart/form-data">';
            echo '<div class="question-3">'; 
            echo '<div class="question-2">';
            echo '<center><div class="title"><h2>¿Seguro qué quieres eliminar el mensaje?</h2></div></center>';
            echo ' <center> <div class="enviar"><input type="submit" value="Eliminar" id="submit" name="elimina">';            
            echo '  <input type="submit" value="Cancelar" id="submit" name="elimina"></div></div><center>';
            echo "<input type='hidden' name='id-pregunta' value=' $id_pregunta'>";
            echo "<input type='hidden' name='id-respuesta' value='$id_respuesta'>";
            echo '</div>';
            echo ' </div>';
            echo '</form>';
        }elseif($accion=='actualizar'){
            echo '<form action="actualizar.php" method="post" enctype="multipart/form-data">';
            echo '<div class="question-3">'; 
            if(isset($_SESSION['id'])){
                $imagen=$_SESSION["imagen"];
                echo "<div class='imagen-4'> <img class='img-2' src='$imagen'></div>";             
            }else{
                echo "<div class='imagen-4'> <img class='img-2' src='https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png'></div>";
            }  
            echo '<div class="question-2">';
            echo '<div class="title"><h2>Editar comentario!!</h2></div>';
            echo '   <div class="text-box"><div><input class="box" type="text" name="pregunta"></div>';
            echo '  <div class="enviar"><input type="submit" value="Responder" id="submit"></div></div>';
            echo "<input type='hidden' name='id-pregunta' value=' $id_pregunta'>";
            echo "<input type='hidden' name='id-respuesta' value=' $id_respuesta'>";
            echo '</div>';
            echo ' </div>';
            echo '</form>';
        }
    ?> 
    </div>
    </main>
    <div class="f"></div>
    <footer><h3>Elaborado por Hugo David Nogueda Hernández</h3></footer>
</body>
</html>