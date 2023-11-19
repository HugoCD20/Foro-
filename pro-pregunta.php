<?php 
session_start();
    $ima=true;
    $imagen='';
    if(isset($_FILES['Foto'])){
        $file=$_FILES['Foto'];
        $nombreF=$file["name"];
        $tipo=$file["type"];
        $size=$file["size"];        
        $ruta_provisional=$file["tmp_name"];
        if($nombreF!=''){
        $dimension=getimagesize($ruta_provisional);
        $with=$dimension[0];
        $height=$dimension[1];
        $carpeta="Fotos/";
        $src=$carpeta.$nombreF;
        if($tipo != "image/jpg" && $tipo != "image/png" && $tipo != "image/JPG" && $tipo != "image/jpeg"){
            echo "La imagen no es compatible";
            $_SESSION['error']="La imagen no es compatible";
            header("location: index.php");
            exit();
            $ima=false;
        }elseif($size > 3*1024*1024){
            echo "La imagen es demasiado pesada";
            $_SESSION['error']="La imagen es demasiado pesada";
            header("location: index.php");
            exit();
            $ima=false;
        }else{
            move_uploaded_file($ruta_provisional,$src);
            $imagen="Fotos/".$nombreF;
        }
    }else{
        $imagen='sin-imagen';
    }
    }else{
          $_SESSION['error']="no es una imagen";
          header("location: index.php");
          exit();
          $ima=false;
    }
    if($ima){
       
        try {
            include('conexion.php');
            $pregunta = $_POST['pregunta'];
            if(strlen($pregunta)>500){
                $_SESSION['error']='La pregunta es demasiada larga';
                header("location: index.php");
                exit();
            }
            $idU=$_SESSION['id'];
            if($pregunta==null){
                header("location: index.php");
                exit();
            }
            $consulta = "INSERT INTO Preguntas (id_usuario,Pregunta,foto) 
                         VALUES (:idU,:pregunta,:imagen)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':idU', $idU);
            $stmt->bindParam(':pregunta', $pregunta);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->execute();
            header("location: index.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    } 
?>