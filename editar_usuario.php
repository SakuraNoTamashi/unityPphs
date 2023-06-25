<?php
include 'header.php';

try {
    //https://localhost/gamificacion/editar_usuario.php?id=17&userName=newJhonnName&email=johnd25a@example.com&userType=1&userGrade=1&avatarIndex=6&lifes=2&nivel=1&coins=33&achievements=Nonejaja

    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        $responseJson['codigo'] = 400;
        $responseJson['mensaje'] = "Error intentando conectar";
        $responseJson['respuesta'] = '';
        echo json_encode($responseJson);
    } else {
        try {
            $id = $_GET['id'];
            $userName = $_GET['userName'];
            $email = $_GET['email'];
            $userType = $_GET['userType'];
            $userGrade = $_GET['userGrade'];
            $avatarIndex = $_GET['avatarIndex'];
            $lifes = $_GET['lifes'];
            $level = $_GET['nivel'];
            $coins = $_GET['coins'];
            $achievements = $_GET['achievements'];

            $tableName = '`estudiantes`';

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
            }

            $sql = "UPDATE " . $tableName . " SET `userName`='" . $userName . "', `userGrade`='" . $userGrade . "' WHERE email='" . $email . "';";
            echo $sql;
            $resultado = $conn->query($sql);
            echo $conn->affected_rows;
            if ($conn->affected_rows > 0) {
                $sql = "UPDATE `inventarios`  SET `monedas`='" . $coins . "', `vidas`='" . $lifes . "', `avatar`='" . $avatarIndex . "', `nivel`='" . $level .  "', `logros`='" . $achievements . "' WHERE idEstudiante='" . $id . "';";
                $conn->query($sql);

                if ($conn->affected_rows > 0) {
                    $responseJson['codigo'] = 200;
                    $responseJson['mensaje'] = "Usuario e inventario editados con éxito";
                    $responseJson['respuesta'] = $texto;
                } else {
                    $responseJson['codigo'] = 202;
                    $responseJson['mensaje'] = "Usuario editado con éxito pero no inventario";
                    $responseJson['respuesta'] = $texto;
                }
                echo json_encode($responseJson);
            } else {
                $responseJson['codigo'] = 200;
                $responseJson['mensaje'] = "El usuario ya tenia esa informacion o no existe";
                $responseJson['respuesta'] = "0";
                echo json_encode($responseJson);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $responseJson['codigo'] = 444;
            $responseJson['mensaje'] = "Faltan datos paaara ejecutar la accssión";
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
