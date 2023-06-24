<?php
include 'header.php';
try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
    } else {
        if (isset($_GET['usuario'])) {
            $usuario = $_GET['usuario'];

            $sql = "SELECT * FROM `usuarios` WHERE usuario='".$usuario."';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                echo '{"codigo":202, "mensaje":"Usuario existe en el sistema", "respuesta":"'.$resultado.'"}';
            } else {
                echo '{"codigo":203, "mensaje": "El usuario no existe","respuesta":"0"}';
            }
        } else {
            echo '{"codigo":444,"mensaje": "Faltan datos para ejecutar la acción"}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
}
include 'footer.php';
?>
