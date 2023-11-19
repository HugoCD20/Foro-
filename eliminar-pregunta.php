<?php 
    session_start();
    $boton=$_POST['elimina'];
    $id_pregunta=$_POST['id-pregunta'];
    if(!isset($id_pregunta)){
        header("location: index.php");
    }
    if($boton=="Cancelar"){
            header("location: index.php");
    
    }else{
        include('conexion.php');       
        $consulta4="DELETE FROM preguntas WHERE id=:id_pregunta";
        $stmt4=$conexion->prepare($consulta4);
        $stmt4->bindParam(':id_pregunta',$id_pregunta);
        $stmt4->execute();
        $_SESSION["id_pregunta"]=$id_pregunta; 
        header("location: index.php");
    }
    
?>