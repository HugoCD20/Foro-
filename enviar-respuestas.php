<?php 
session_start();
    $ima=true;
    if($ima){
       
        try {
            include('conexion.php');
            $id_pregunta= $_POST['id-pregunta'];
            $id_respuesta=$_POST['id-respuesta'];
            $id_pagina=$_SESSION['pagina'];
            $id_usuario=$_SESSION['id'];
            $respuesta=$_POST['pregunta'];
            if($respuesta==''){
                $_SESSION['error2']='No puedes hacer una respuesta vacia';
                header("location: http://localhost/twitter/responder.php");
                exit();
            }
            if(strlen($respuesta)>500){
                $_SESSION['error2']='La respuesta es demasiada larga';
                header("location: http://localhost/twitter/respuestas.php");
                exit();
            }
            $consulta = "INSERT INTO respuestas (id_pregunta,id_respuesta,id_usuario,respuesta) 
                         VALUES (:id_pregunta,:id_respuesta,:id_usuario,:respuesta)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->bindParam(':id_respuesta', $id_respuesta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':respuesta', $respuesta);
            $stmt->execute();       
            $_SESSION["id_pregunta"]=$id_pregunta; 
            echo $id_pagina;
            if($id_pagina=='pagina2'){
                header("location: http://localhost/twitter/mostrar-respuestas.php");
            }else{
                header("location: http://localhost/twitter/respuestas.php");
            }
           
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    } 
?>