<?php

include 'header.php';
try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
    } else {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $usuario = $_POST['email'];
            $pass = $_POST['password'];


            /* $tableName = '`estudiantes`';

            switch ($userType) {
                case 1:
                    $tableName = '`estudiantes`';

                    break;
                case 2:
                    $tableName = '`profesores`';

                    break;
                case 1:
                    $tableName = '`padres`';

                    break;
                default:
                    $tableName = '`estudiantes`';
            }*/
            $password = hash('sha256', $pass);
            $sql = "SELECT * FROM `estudiantes` WHERE email='" . $usuario . "'AND password='" . $password . "';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $sql = "SELECT * FROM `estudiantes` WHERE email='" . $usuario . "';";
                $resultado = $conn->query($sql);
                $texto = '';

                while ($row = $resultado->fetch_assoc()) {
                    $texto = "id:" . $row['id'] .
                        "";
                }
                echo '{"codigo":202, "mensaje":"Sesion Iniciada", "respuesta":"' . $texto . '"}';
            } else {
                echo '{"codigo":203, "mensaje": "Datos Incorrectos", "respuesta":"0"}';
            }
        } else {
            echo '{"codigo":444,"mensaje": "Faltan datos para ejecutar la acción"}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
}
include 'footer.php';
