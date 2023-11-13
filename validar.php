<?php 
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Correo = $_POST['Correo'];
    $Contraseña = $_POST['Contraseña'];
    $Contra = $_POST['Contra'];
    $Nusuario = $_POST['Nusuario'];
    $valida = true;

    if ($Contraseña != $Contra) {
        $valida = false;
    }

    $ima = true;
    $imagen = '';

    if (isset($_FILES['foto'])) {
        $file = $_FILES['foto'];
        $nombreF = $file["name"];
        $tipo = $file["type"];
        $size = $file["size"];
        $ruta_provisional = $file["tmp_name"];

        if ($nombreF != '') {
            $dimension = getimagesize($ruta_provisional);

            if ($dimension !== false) {
                $with = $dimension[0];
                $height = $dimension[1];

                $carpeta = "Fotos/";
                $src = $carpeta . $nombreF;

                if ($tipo != "image/jpg" && $tipo != "image/png" && $tipo != "image/jpeg") {
                    echo "<br>La imagen no es compatible";
                    $ima = false;
                } elseif ($size > 3 * 1024 * 1024) {
                    echo "<br>La imagen es demasiado pesada";
                    $ima = false;
                } else {
                    move_uploaded_file($ruta_provisional, $src);
                    $imagen = "Fotos/" . $nombreF;
                }
            } else {
                echo "<br>El archivo no es una imagen válida";
                $ima = false;
            }
        } else {
            $imagen = 'https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png';
        }
    } else {
        $ima = true;
    }

    if (!$ima) {
        $ima=false;
    }

    if(!empty($Correo) && !empty($Contraseña) && !empty($Contra) && !empty($Nusuario) && $valida==true && $cor==true && $ima==true){
       
        try {
            include('conexion.php');
            $nombreU = $_POST['Nusuario'];
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contraseña'];
            $consulta = "INSERT INTO registro (nombreU, Correo, Contraseña,foto) 
                         VALUES (:nombreU, :correo, :contrasena, :imagen)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':nombreU', $nombreU);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->execute();
            header("location: http://localhost/twitter/login.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
            
        
    } 
}else{
    header("location: http://localhost/twitter/index.php");
}
    
?>