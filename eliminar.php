<?php 
    session_start();
    $boton=$_POST['elimina'];
    if($boton==null){
        header("location:index.php");
    }
    $id_pregunta=$_POST['id-pregunta'];
    $id_respuesta=$_POST['id-respuesta'];
    $id_pagina=$_SESSION['pagina'];
    if($boton=="Cancelar"){
        if($id_pagina=='pagina2'){
            header("location: mostrar-respuestas.php");
        }else{
            header("location: respuestas.php");
        }
    }else{
        include('conexion.php');
        function mostrarRespuestas($conexion, $id_pregunta, $id_respuesta = null){
            global $bandera,$original; 
            $consulta = "SELECT * FROM respuestas WHERE id_pregunta = :id_pregunta AND id_respuesta = :id_respuesta";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->bindParam(':id_respuesta', $id_respuesta);
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
                $id_respuesta2=$registro['id'];
                $consulta3="DELETE FROM respuestas WHERE id=:id_respuesta2 AND id_pregunta=:id_pregunta";
                $stmt3=$conexion->prepare($consulta3);
                $stmt3->bindParam(':id_respuesta2',$id_respuesta2);
                $stmt3->bindParam(':id_pregunta',$id_pregunta);
                $stmt3->execute();
                mostrarRespuestas($conexion, $id_pregunta, $registro['id']);
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
        $consulta4="DELETE FROM respuestas WHERE id=:id_respuesta AND id_pregunta=:id_pregunta";
        $stmt4=$conexion->prepare($consulta4);
        $stmt4->bindParam(':id_respuesta',$id_respuesta);
        $stmt4->bindParam(':id_pregunta',$id_pregunta);
        $stmt4->execute();
        $_SESSION["id_pregunta"]=$id_pregunta; 
        if($id_pagina=='pagina2'){
            header("location: mostrar-respuestas.php");
        }else{
            header("location: respuestas.php");
        }
    }
    
?>