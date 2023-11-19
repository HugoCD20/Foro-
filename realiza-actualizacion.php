<?php
session_start();
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id=$_SESSION['id'];
        $ima = true;
        $imagen = '';

if(isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK){
    $file = $_FILES['Foto'];
    $nombreF = $file["name"];
    $tipo = $file["type"];
    $size = $file["size"];
    $ruta_provisional = $file["tmp_name"];

    if ($nombreF != '') {
        $dimension = getimagesize($ruta_provisional);
        $with = $dimension[0];
        $height = $dimension[1];
        $carpeta = "Fotos/";
        $src = $carpeta . $nombreF;

        if ($tipo != "image/jpg" && $tipo != "image/png" && $tipo != "image/JPG" && $tipo != "image/jpeg") {
            echo "La imagen no es compatible";
            $ima = false;
        } elseif ($size > 3 * 1024 * 1024) {
            echo "La imagen es demasiado pesada";
            $ima = false;
        } /*elseif($with != 800 && $height != 800){
            echo "-La imagen no cumple con el tamaño-";
            $ima=false;
        }*/ else {
            move_uploaded_file($ruta_provisional, $src);
            $imagen = "Fotos/" . $nombreF;
        }
    } else {
        $imagen = 'sin-imagen';
    }
} else {
    // No se envió ninguna foto
    $imagen = 'sin-imagen';
    $ima = false;
}



    if(!empty($id)){
        
        try {
            include('conexion.php');
            $nombreU = $_POST['usuario'];           
            $correo = $_POST['Correo'];
            $contra = $_POST['Contra'];
            if(strlen($nombreU)>100 or strlen($correo)>100 or strlen($contra)>100){
                header("location:actualizar-perfil.php");
                exit();
                $largo=false;
            }else{
                $largo=true;
            }
            if ($ima && $largo) {
                $consulta = "UPDATE registro SET foto=:imagen WHERE id=:id";
                $stmt2 = $conexion->prepare($consulta);
                $stmt2->bindParam(':imagen', $imagen);
                $stmt2->bindParam(':id', $id);
            
                if ($stmt2->execute()) {
                    echo "La foto se ha actualizado correctamente.";
                } else {
                    echo "Error al actualizar la foto.";
                }
            }
        
            if(!empty($nombreU)){
                $consulta = "update registro set NombreU=:nombreU where id=:id";
                $stmt3 = $conexion->prepare($consulta);
                $stmt3->bindParam(':nombreU',$nombreU);
                $stmt3->bindParam(':id',$id);
                $stmt3->execute();

            }
            if(!empty($correo)){
                $consulta = "update registro set Correo=:correo where id=:id";
                $stmt4 = $conexion->prepare($consulta);
                $stmt4->bindParam(':correo',$correo);
                $stmt4->bindParam(':id',$id);
                $stmt4->execute();

            }
            if(!empty($contra)){
                $consulta = "update registro set Contraseña=:contra where id=:id";
                $stmt5 = $conexion->prepare($consulta);
                $stmt5->bindParam(':contra',$contra);
                $stmt5->bindParam(':id',$id);
                $stmt5->execute();

            }
            
            header("location:index.php");
        
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
}else{
    header("location:index.php");
}
    ?>