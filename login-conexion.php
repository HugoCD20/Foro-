<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $Contraseña = $_POST['Contraseña'];
    $Correo = $_POST['Nusuario'];
    if(strlen($Contraseña)>100 && strlen($Correo)>100){
        $largo=false;
    }else{
        $largo=true;
    }
    if(!empty($Contraseña) && !empty($Correo) && $largo){
        try {
            include("conexion.php");
            $correo = $_POST['Nusuario'];
            $contrasena = $_POST['Contraseña'];
            $conexion->exec("SET CHARACTER SET utf8");
            $consulta = "SELECT * FROM registro WHERE NombreU=? AND Contraseña=?";
            $stmt = $conexion->prepare($consulta);
            $stmt->execute(array($correo, $contrasena));
            if ($stmt->rowCount() > 0) {
                while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['id']=$registro['id'];
                    $_SESSION['nombre']=$registro['nombreu'];
                    $_SESSION["imagen"]=$registro['foto'];
                    header("location:http://localhost/twitter/index.php");
                }
            } else {
                echo '<center> <p class="error">Contraseña o correo electrónico incorrectos</p> </center>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}else{
    header("location:http://localhost/twitter/index.php");
}
?>