<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo": 400, "mensaje": "Error intentando conectar", "respuesta": ""}';
    } else {
        if (isset($_GET['id']) && isset($_GET['idEstudiante'])) {
            $id = $_GET['id'];
            $idEstudiante = $_GET['idEstudiante'];

            // Verificar si el id está en la tabla de profesores
            $sql = "SELECT * FROM `profesores` WHERE id='" . $id . "';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                // id encontrado en la tabla de profesores
                // Actualizar la variable "vidas" en la tabla de estudiantes para el idEstudiante correspondiente
                $sql = "UPDATE `inventarios` SET `vidas` = 3 WHERE idEstudiante='" . $idEstudiante . "';";

                if ($conn->query($sql) === TRUE) {
                    echo '{"codigo": 200, "mensaje": "Se actualizó la variable vidas del estudiante", "respuesta": ""}';
                } else {
                    echo '{"codigo": 401, "mensaje": "Error intentando actualizar la variable vidas del estudiante", "respuesta": ""}';
                }
            } else {
                echo '{"codigo": 202, "mensaje": "El id no se encuentra en la tabla de profesores", "respuesta": ""}';
            }
        } else {
            echo '{"codigo": 503, "mensaje": "No se proporcionó el id o idEstudiante", "respuesta": ""}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo": 400, "mensaje": "Error intentando conectar", "respuesta":' . $e . '}';
}

include 'footer.php';
