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
                echo "<a href='actualizar-perfil.php'><div class='imagen-2'> <img class='img-1' src='$imagen'></div></a>";
                
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
            if(!isset($id_pregunta)){
                header("location:index.php");
            }
        }       
    }else{
        $id_pregunta= $_POST['id-pregunta'];
        if(!isset($id_pregunta)){
            header("location: http://localhost/twitter/index.php");
        }
    }
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
    ?>
     <div class="regreso"><a href="index.php"><img class="img-5" src="https://img.freepik.com/psd-gratis/diseno-flechas-degradado_23-2150390286.jpg?size=338&ext=jpg&ga=GA1.1.1826414947.1699488000&semt=ais"></a></div>
    </div>
    <form  action="enviar-respuesta.php" method="post" enctype="multipart/form-data">
        <div class="question-3"> 
        <?php         
        
            if(isset($_SESSION['id'])){
                $imagen=$_SESSION["imagen"];
                echo "<div class='imagen-4'> <img class='img-2' src='$imagen'></div>";

                
            }else{
                echo "<div class='imagen-4'> <img class='img-2' src='https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png'></div>";
            }
            ?>    
           
            <div class="question-2">
                <div class="title"><h2>Responder!!</h2></div>
                <div class="text-box"><div><input class="box" type="text" name="pregunta"></div>
                <?php 
                if(isset($_SESSION['id'])){
                    echo "<div class='enviar'><input type='submit' value='Enviar' id='submit'></div>";
                    
                }else{
                    echo "<center> <p class='error'>Inicia sesion para responder</p> </center>";
                }  
                if(isset($_SESSION['error2'])) {
                    echo "<center> <p class='error'>$_SESSION[error2]</p> </center>";
                    $_SESSION['error2']=null;
                }                 
                    ?>        
                </div>   
                <input type='hidden' name='id-pregunta' value='<?php echo $id_pregunta; ?>'>
            </div>
        </div>
    </form>
    <div class="question-4">
    <?php 
     try {
        $_SESSION['pagina']='pagina1';
        $_SESSION['id_respuesta']='';
        include("conexion.php");
        $conexion->exec("SET CHARACTER SET utf8");
        $consulta = "SELECT * FROM respuestas where id_pregunta=:id_pregunta and id_respuesta=:id_respuesta";
        $stmt = $conexion->prepare($consulta);
        $stmt -> bindParam(':id_pregunta',$id_pregunta);
        $stmt -> bindParam(':id_respuesta',$id_pregunta);
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
                echo "<form  action='responder.php' method='POST'>";
                echo "<div class='text-4'><div class='respuesta-1'><div class='imagen-5'> <img class='img-3' src='$registro2[foto]'></div> 
                <div class='respuesta-2'><p><strong>".$registro2['nombreU']."</strong><br>".$registro['respuesta']."</p></div></div>";
                if(isset($_SESSION['id'])){
                    if($_SESSION['id']== $id_usuario){
                            echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button><div><button class='button-5' name='accion' value='actualizar'><img class='img-4' src='https://cdn.pixabay.com/photo/2019/08/11/18/58/icon-4399697_1280.png'></button></div>
                            <div><button class='button-5' name='accion' value='eliminar'><img class='img-4' src='https://cdn-icons-png.flaticon.com/512/980/980403.png'></button></div></div> ";
                    }else{
                        echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button></div>";
                }
                }else{
                    echo "</div>";
                }
                echo "<input type='hidden' name='id-respusta' value='".$registro['id']. "'>";
                echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";                 
                echo "</form>";
                        $id_respuesta=$registro['id'];
                        //aqui inicia otro nivel de consulta------------------------------------------------------>
                        $consulta3 = "SELECT * from respuestas where id_pregunta=:id_pregunta and id_respuesta=:id_respuesta";
                        $stmt3 =$conexion->prepare($consulta3);
                        $stmt3->bindParam(':id_pregunta',$id_pregunta);
                        $stmt3->bindParam(':id_respuesta',$id_respuesta);
                        $stmt3->execute();   
                        $registro3 = array();
                        if($stmt3->rowCount()>0){
                            while($registro3=$stmt3->fetch(PDO::FETCH_ASSOC)){
                                $id_usuario = $registro3['id_usuario'];
                                $consulta5 = "SELECT * FROM registro where id = :id_usuario";
                                $stmt7 = $conexion->prepare($consulta5);
                                $stmt7->bindParam(':id_usuario', $id_usuario);
                                $stmt7->execute();
                                $registro7 = $stmt7->fetch(PDO::FETCH_ASSOC);
                                echo "<form  action='responder.php' method='POST'>";
                                echo "<div class='text-7'><div class='left-3'><div class='respuesta-1'><div class='imagen-5'>
                                        <img class='img-3' src='$registro7[foto]'></div>
                                        <p><strong>".$registro7['nombreU']."</strong> ➱ ".$registro2['nombreU']."<br>". $registro3['respuesta'] . "</p></div>";
                                        if(isset($_SESSION['id'])){
                                            if($_SESSION['id']== $id_usuario){
                                                echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button><div><button class='button-5' name='accion' value='actualizar'><img class='img-4' src='https://cdn.pixabay.com/photo/2019/08/11/18/58/icon-4399697_1280.png'></button></div>
                                                <div><button class='button-5' name='accion' value='eliminar'><img class='img-4' src='https://cdn-icons-png.flaticon.com/512/980/980403.png'></button></div></div></div>  ";
                                        }else{
                                            echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button></div></div>";
                                        }
                                        }else{
                                            echo "</div></div>";
                                        } 
                                echo "<input type='hidden' name='id-respusta' value='".$registro3['id']. "'>";
                                echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";                      
                                  echo "</form>";
                                $id_respuesta=$registro3['id'];
                                //aqui inicia otro nivel de consulta------------------------------------------------------>
                                $consulta3 = "SELECT * from respuestas where id_pregunta=:id_pregunta and id_respuesta=:id_respuesta";
                                $stmt4 =$conexion->prepare($consulta3);
                                $stmt4->bindParam(':id_pregunta',$id_pregunta);
                                $stmt4->bindParam(':id_respuesta',$id_respuesta);
                                $stmt4->execute();   
                                $registro4 = array();
                                if($stmt4->rowCount()>0){
                                    while($registro4=$stmt4->fetch(PDO::FETCH_ASSOC)){
                                        $id_usuario = $registro4['id_usuario'];
                                        $consulta6 = "SELECT * FROM registro where id = :id_usuario";
                                        $stmt6 = $conexion->prepare($consulta6);
                                        $stmt6->bindParam(':id_usuario', $id_usuario);
                                        $stmt6->execute();
                                        $registro6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                        echo "<form  action='responder.php' method='POST'>";
                                        echo "<div class='text-7'><div class='left-3'><div class='respuesta-1'><div class='imagen-5'>
                                        <img class='img-3' src='$registro6[foto]'></div>
                                        <p><strong>".$registro6['nombreU']."</strong> ➱ ".$registro7['nombreU']."<br>". $registro4['respuesta'] . "</p></div>";
                                        if(isset($_SESSION['id'])){
                                            if($_SESSION['id']== $id_usuario){
                                                echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button><div><button class='button-5' name='accion' value='actualizar'><img class='img-4' src='https://cdn.pixabay.com/photo/2019/08/11/18/58/icon-4399697_1280.png'></button></div>
                                                <div><button class='button-5' name='accion' value='eliminar'><img class='img-4' src='https://cdn-icons-png.flaticon.com/512/980/980403.png'></button></div></div></div>  ";
                                        }else{
                                            echo "<button class='button-1'name='accion' value='insertar'>Responder↴</button></div></div>";
                                    }
                                        }else{
                                            echo "</div></div>";
                                        } 
                                        echo "<input type='hidden' name='id-respusta' value='".$registro4['id']. "'>";
                                        echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";                      
                                        echo "</form>";
                                        $id_respuesta=$registro4['id'];
                                        //aqui inicia otro nivel de consulta------------------------------------------------------>
                                        $consulta4 = "SELECT * from respuestas where id_pregunta=:id_pregunta and id_respuesta=:id_respuesta";
                                        $stmt5 =$conexion->prepare($consulta3);
                                        $stmt5->bindParam(':id_pregunta',$id_pregunta);
                                        $stmt5->bindParam(':id_respuesta',$id_respuesta);
                                        $stmt5->execute();   
                                        $registro5 = array();
                                        if($stmt5->rowCount()>0){
                                            while($registro5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                echo "<form  action='mostrar-respuestas.php' method='POST'>";
                                                echo "<div class='text-7'><div class='left-4'><button class='button-3'>Ver más↴</button></div></div>";
                                                echo "<input type='hidden' name='id-respusta' value='".$registro['id']. "'>";
                                                echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";        
                                                echo "</form>";
                                            }
                                        }     
                                    }
                                }     
                                
                            }
                        }        
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