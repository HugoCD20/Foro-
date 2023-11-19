<?php 
    session_start();
    include('conexion.php');
    $boton=$_POST['accion'];
    $id_pregunta=$_POST['id-pregunta'];
    if(!isset($boton)){
        header("location:index.php");
        exit();
    }    
    $_SESSION["id_pregunta"]=$id_pregunta; 
    $_SESSION["realiza"]=$boton;
    if($boton=='responder'){
        header("location: respuestas.php");
        }elseif($boton=='eliminar'){
            header("location: verifica-eliminar.php");
            }else{
                header("location: index.php");
            }
        ?>