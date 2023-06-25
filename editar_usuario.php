<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        $responseJson['codigo'] = 400;
        $responseJson['mensaje'] = "Error intentando conectar";
        $responseJson['respuesta'] = '';
        echo json_encode($responseJson);
    } else {
        try {
            $usuario = $_GET['usuario'];
            $pass = $_GET['pass'];
            $pass2 = $_GET['pass2'];
            $jugador = $_GET['jugador'];
            $nivel = $_GET['nivel'];

            $tableName = '`usuarios`';
            $sql = "SELECT * FROM " . $tableName . " WHERE usuario='" . $usuario . "';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $sql = "UPDATE " . $tableName . " SET `password`='" . $pass2 . "', `jugador`='" . $jugador . "', `nivel`='" . $nivel . "' WHERE usuario='" . $usuario . "';";
                $conn->query($sql);

                $sql = "SELECT * FROM " . $tableName . " WHERE usuario='" . $usuario . "';";
                $resultado = $conn->query($sql);
                $texto = '';

                while ($row = $resultado->fetch_assoc()) {
                    $texto = "{#id#:" . $row['id'] .
                        ",#usuario#:#" . $row['usuario'] .
                        "#,#password#:#" . $row['password'] .
                        "#,#jugador#:" . $row['jugador'] .
                        ",#nivel#:" . $row['nivel'] .
                        "}";
                }
                $responseJson['codigo'] = 207;
                $responseJson['mensaje'] = "Usuario editado con éxito";
                $responseJson['respuesta'] = $texto;
                echo json_encode($responseJson);
            } else {
                $responseJson['codigo'] = 203;
                $responseJson['mensaje'] = "El usuario no existe";
                $responseJson['respuesta'] = "0";
                echo json_encode($responseJson);
            }
        } catch (Exception $e) {
            $responseJson['codigo'] = 444;
            $responseJson['mensaje'] = "Faltan datos para ejecutar la acción";
            echo json_encode($responseJson);
        }
    }
} catch (Exception $e) {
    $responseJson['codigo'] = 400;
    $responseJson['mensaje'] = "Error intentando conectar";
    $responseJson['respuesta'] = '';
    echo json_encode($responseJson);
}
include 'footer.php';
