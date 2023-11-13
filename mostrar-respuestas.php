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
    
    <div class="question-4">
    <div class="regreso"><a href="respuestas.php"><img class="img-5" src="https://img.freepik.com/psd-gratis/diseno-flechas-degradado_23-2150390286.jpg?size=338&ext=jpg&ga=GA1.1.1826414947.1699488000&semt=ais"></a></div>
    <?php
    $_SESSION['pagina']='pagina2';
    if (isset($_SESSION['id_pregunta'])) {
        $id_pregunta = $_SESSION["id_pregunta"];
        if ($_SESSION['id_pregunta'] == '') {
            $id_pregunta = $_POST['id-pregunta'];
        }
    } else {
        $id_pregunta = $_POST['id-pregunta'];
        
    }
    if($id_pregunta==null){
        header("location:index.php");
        exit();
    }
    $_SESSION['pagina']='pagina2';
    if (isset($_SESSION['id_respuesta'])) {
        $id_respuesta = $_SESSION['id_respuesta'];
        if ($_SESSION['id_respuesta'] == '') {
            $id_respuesta = $_POST['id-respusta'];
            $_SESSION['id_respuesta']=$id_respuesta;
        }
    } else {
        $id_respuesta=$_POST['id-respusta'];
        $_SESSION['id_respuesta']=$id_respuesta;
    }
    
    $original='';
    
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
                $id_usuario = $registro['id_usuario'];
                 $consulta2 = "SELECT * FROM registro where id = :id_usuario";
                 $stmt2 = $conexion->prepare($consulta2);
                 $stmt2->bindParam(':id_usuario', $id_usuario);
                 $stmt2->execute();
                $registro2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                echo "<form  action='responder.php' method='POST'>";
                echo "<div class='text-4'><div class='respuesta-1'><div class='imagen-5'> <img class='img-3' src='$registro2[foto]'></div> 
                <div class='respuesta-2'><p><strong>".$registro2['nombreU']."</strong><br>".$registro['respuesta']."</p></div></div>";
                if(isset($_SESSION['id'])){echo "<button class='button-1'>Responder↴</button></div> ";
                }else{
                    echo "</div>";
                } 
                echo "<input type='hidden' name='id-respusta' value='".$registro['id']. "'>";
                echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";    
                $original=$registro2['nombreU'];           
                echo "</form>";
            }
        } else {
        }
      
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$bandera=true;
function mostrarRespuestas($conexion, $id_pregunta, $id_respuesta = null,$nombreU=null){
    global $original; 
    $consulta = "SELECT * FROM respuestas WHERE id_pregunta = :id_pregunta";
    if ($nombreU !== null) {
        $nombre2=$nombreU;
        $interfaz1=true;
    }else{
        $nombre2="<strong>".$original."</strong>";
        $interfaz1=false;
    }
    if ($id_respuesta !== null) {
            $consulta .= " AND id_respuesta = :id_respuesta";
        }
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id_pregunta', $id_pregunta);
    if ($id_respuesta) {
        $stmt->bindParam(':id_respuesta', $id_respuesta);
    }
    $stmt->execute();
    $registro = array();
    if($stmt->rowCount()>0){        
    while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_usuario = $registro['id_usuario'];
        // Recuperar datos de usuario
        $consulta2 = "SELECT * FROM registro WHERE id = :id_usuario";
        $stmt2 = $conexion->prepare($consulta2);
        $stmt2->bindParam(':id_usuario', $id_usuario);
        $stmt2->execute();
        $registro2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        // Mostrar respuesta con indentación según el nivel de anidación
        $id_pagina="Pagina2";
        echo "<form  action='responder.php' method='POST'>";
        if($interfaz1){
            echo "<div class='text-7'><div class='left-3'><div class='respuesta-1'><div class='imagen-5'>
        <img class='img-3' src='$registro2[foto]'></div>
        <p><strong>".$registro2['nombreU']."</strong> ➱ ".$nombre2."<br>". $registro['respuesta'] . "</p></div>";
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
        }else{
            echo "<div class='text-8'><div class='left-4'><div class='respuesta-1'><div class='imagen-5'>
        <img class='img-3' src='$registro2[foto]'></div>
        <p><strong>".$registro2['nombreU']."</strong> ➱ ".$nombre2."<br>". $registro['respuesta'] . "</p></div>";
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
        }        
        echo "<input type='hidden' name='id-respusta' value='".$registro['id']. "'>";
        echo "<input type='hidden' name='id-pregunta' value='".$id_pregunta. "'>";  
        echo "</form>";
        mostrarRespuestas($conexion, $id_pregunta, $registro['id'],$registro2['nombreU']);
    }
}else{
}
}

try {
    include("conexion.php");
    echo "<div class='respuestas-container'>";
    mostrarRespuestas($conexion, $id_pregunta,$id_respuesta);
    echo "</div>";
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