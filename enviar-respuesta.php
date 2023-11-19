<?php 
session_start();
        try {
        include("conexion.php");
        $conexion->exec("SET CHARACTER SET utf8");
        $consulta1 = "SELECT * FROM respuestas";
        $stmt2 = $conexion->prepare($consulta1);
        $stmt2->execute();
        $registro2 = array();
        if ($stmt2->rowCount() > 0) {

        }else{
        $consulta3 = "INSERT INTO respuestas(id,id_pregunta,id_respuesta,id_usuario,respuesta)values(1,1,1,1,'hola')";
        $stmt3 = $conexion->prepare($consulta3);
        $stmt3->execute();
        $consulta4 = "DELETE FROM respuestas";
        $stmt4 = $conexion->prepare($consulta4);
        $stmt4->execute();
        }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        try {
            include('conexion.php');
            $id_pregunta= $_POST['id-pregunta'];
            $respuesta=$_POST['pregunta'];
            if($respuesta==''){
                $_SESSION['error2']='no puedes hacer una respuesta vacia';
                header("location: respuestas.php");
                exit();
            }
            if(strlen($respuesta)>500){
                $_SESSION['error2']='La respuesta es demasiada larga';
                header("location: respuestas.php");
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
            header("location: respuestas.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    
?>