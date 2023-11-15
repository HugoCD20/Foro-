<?php 
session_start();
       
        try {
            include('conexion.php');
            $id_pregunta= $_POST['id-pregunta'];
            $respuesta=$_POST['pregunta'];
            if($respuesta==''){
                $_SESSION['error2']='no puedes hacer una respuesta vacia';
                header("location: http://localhost/twitter/respuestas.php");
                exit();
            }
            if(strlen($respuesta)>500){
                $_SESSION['error2']='La respuesta es demasiada larga';
                header("location: http://localhost/twitter/respuestas.php");
                exit();
            }
            $id_usuario=$_SESSION['id'];
            $consulta = "INSERT INTO respuestas (id_pregunta,id_respuesta,id_usuario,respuesta) 
                         VALUES (:id_pregunta,:id_respuesta,:id_usuario,:respuesta)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->bindParam(':id_respuesta', $id_pregunta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':respuesta', $respuesta);
            $stmt->execute();       
            $_SESSION["id_pregunta"]=$id_pregunta; 
            header("location: http://localhost/twitter/respuestas.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    
?>