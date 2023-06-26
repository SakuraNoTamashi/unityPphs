<?php

include 'header.php';
try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    $responseJson = array();
    if (!$conn) {
        $responseJson['codigo'] = 400;
        $responseJson['mensaje'] = "Error intentando conectar";
        $responseJson['respuesta'] = '';
        echo json_encode($responseJson);
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
                //Llamado a inventario
                $row = $resultado->fetch_assoc();
                $userInfo = $row;

                if (intval($row['userType']) == 1) {


                    $sql2 = "SELECT * FROM `inventarios` WHERE idEstudiante='" . intval($row['id']) . "';";
                    $resultado2 = $conn->query($sql2);
                    $row2 = $resultado2->fetch_assoc();  // Only fetch once, not in a while loop

                    if ($row2) {

                        $userInfo['coins'] = isset($row2['monedas']) ? intval($row2['monedas']) : -1;
                        $userInfo['lifes'] = isset($row2['vidas']) ? intval($row2['vidas']) : -1;
                        $userInfo['avatarIndex'] = isset($row2['avatar']) ? intval($row2['avatar']) : 0;
                        $userInfo['achievements'] = isset($row2['logros']) ? $row2['logros'] : '{"logros":""}';
                        $userInfo['level'] = isset($row2['nivel']) ? intval($row2['nivel']) : 0;
                    } else {

                        $responseJson['codigo'] = 444;
                        $responseJson['mensaje'] = "Faltan datos para ejecutar la acción de inventario";
                        $responseJson['respuesta'] = "";
                        echo json_encode($responseJson);
                    }
                }
                $userInfo['codigo'] = 202;
                $userInfo['mensaje'] = "Sesion Iniciada";
                $userInfo['respuesta'] = '';
                echo json_encode($userInfo);
            } else {
                $responseJson['codigo'] = 203;
                $responseJson['mensaje'] = "Datos Incorrectos";
                $responseJson['respuesta'] = '';
                echo json_encode($responseJson);
            }
        } else {
            $responseJson['codigo'] = 445;
            $responseJson['mensaje'] = "Faltan datos para ejecutar la acción";
            $responseJson['respuesta'] = '';
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
