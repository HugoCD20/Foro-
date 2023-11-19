<?php 
    session_start();
    $id_pregunta=$_POST['id-pregunta'];
    if($id_pregunta==null){
        header("location:index.php");
        exit();
    }
    include('conexion.php');
    $id_respuesta=$_POST['id-respuesta'];
    $id_pagina=$_SESSION['pagina'];
    $respuesta=$_POST['pregunta'];
    $consulta4="UPDATE respuestas SET respuesta=:respuesta where id=:id_respuesta and id_pregunta=:id_pregunta";
    $stmt4=$conexion->prepare($consulta4);
    $stmt4->bindParam(':respuesta',$respuesta);
    $stmt4->bindParam(':id_respuesta',$id_respuesta);
    $stmt4->bindParam(':id_pregunta',$id_pregunta);
    $stmt4->execute();
    $_SESSION["id_pregunta"]=$id_pregunta; 
    if($id_pagina=='pagina2'){
        header("location: mostrar-respuestas.php");
    }else{
        header("location: respuestas.php");
    }
?>