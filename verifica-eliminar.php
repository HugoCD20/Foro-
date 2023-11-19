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
        <div class="content-1"><img class="imagen-1" src="img/logo[1].png">
            <h1 class="text-1">Doom</h1></div>
        <div class="content-2">
        <?php session_start();             
            if(!isset($_SESSION['id'])){
                echo '<a class="link-1" href="login.php"><p class="text-2">Login/</p></a>';
                echo '<a class="link-2" href="Register.php"><p class="text-3">Register</p></a>';
            }else{
                echo '<a class="link-2" href="index.php"><p class="text-3">Home</p></a>'; 
                $imagen=$_SESSION["imagen"];
                echo "<a class='xa' href='actualizar-perfil.php'><div class='imagen-2'> <img class='img-1' src='$imagen'></div></a>";
                
            }
            ?>               
        </div>
    </header>
    
    <main>
    <div class="content-3">
    <?php 
    if(!isset($_SESSION["id_pregunta"])){
        header("location: index.php");
                exit();
    }
    if(isset($_SESSION['id_pregunta'])){
        $id_pregunta=$_SESSION["id_pregunta"]; 
        if($_SESSION['id_pregunta']==''){
            $id_pregunta= $_POST['id-pregunta'];
            if(isset($id_pregunta)){
                header("location: index.php");
                exit();
            }
        }       
    }
    ?>
    </div>
    <div class="question-4">
    <?php      
        $boton=$_SESSION["realiza"];
        if($boton=="eliminar"){        
       echo '<form action="eliminar-pregunta.php" method="post" enctype="multipart/form-data">';
       echo '<div class="question-3">'; 
       echo '<div class="question-2">';
       echo '<center><div class="title"><h2>¿Seguro qué quieres eliminar la pregunta?</h2></div></center>';
       echo ' <center> <div class="enviar"><input type="submit" value="Eliminar" id="submit" name="elimina">';            
       echo '  <input type="submit" value="Cancelar" id="submit" name="elimina"></div></div><center>';
       echo "<input type='hidden' name='id-pregunta' value=' $id_pregunta'>";
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