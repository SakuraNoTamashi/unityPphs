<?php
include 'header.php';
try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
    } else {
        echo '{"codigo":200, "mensaje": "conectado correctamente"}';
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
}
include 'footer.php';
?>