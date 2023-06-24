<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo": 400, "mensaje": "Error intentando conectar", "respuesta": ""}';
    } else {
        if (isset($_GET['idEstudiante']) && isset($_GET['monedas'])) {
            $idEstudiante = $_GET['idEstudiante'];
            $monedas = $_GET['monedas'];

            $sql = "UPDATE `inventarios` SET `monedas` = `monedas` + " . $monedas . " WHERE idEstudiante='" . $idEstudiante . "';";

            if ($conn->query($sql) === TRUE) {
                $sql = "SELECT * FROM `inventarios` WHERE idEstudiante='" . $idEstudiante . "';";
                $resultado = $conn->query($sql);
                $texto = '';

                while ($row = $resultado->fetch_assoc()) {
                    $texto = "{#idEstudiante#:#" . $row['idEstudiante'] .
                        "#,#monedas#:#" . $row['monedas'] .
                        "}";
                }

                echo '{"codigo": 401, "mensaje": "Se actualizó el usuario", "respuesta": "' . $texto . '"}';
            } else {
                echo '{"codigo": 401, "mensaje": "Error intentando actualizar el usuario", "respuesta": ""}';
            }
        } else {
            echo '{"codigo": 503, "mensaje": "No hay datos para actualizar el usuario"}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo": 400, "mensaje": "Error intentando conectar", "respuesta":' . $e . '}';
}

include 'footer.php';
