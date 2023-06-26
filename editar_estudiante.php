<?php
include 'header.php';

try {
    //https://localhost/gamificacion/editar_estudiante.php?email=johnd25a@example.com&userGrade=1

    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        $responseJson['codigo'] = 400;
        $responseJson['mensaje'] = "Error intentando conectar";
        $responseJson['respuesta'] = '';
        echo json_encode($responseJson);
    } else {
        try {
            /*
            $id = $_POST['id'];
            $userName = $_POST['userName'];
            $email = $_POST['email'];
            $userType = $_POST['userType'];
            $userGrade = $_POST['userGrade'];
            $avatarIndex = $_POST['avatarIndex'];
            $lifes = $_POST['lifes'];
            $level = $_POST['nivel'];
            $coins = $_POST['coins'];
            $achievements = $_POST['achievements'];
*/

            $email = $_POST['email'];

            $userGrade = $_POST['userGrade'];


            $tableName = '`estudiantes`';



            $sql = "SELECT * FROM `estudiantes` WHERE email='" . $email . "'AND userGrade='" . $userGrade . "';";
            $resultado = $conn->query($sql);
            $row = $resultado->fetch_assoc();


            if ($resultado->num_rows > 0) {
                $sql = "UPDATE `inventarios`  SET  `vidas`='3' WHERE idEstudiante='" . $row["id"] . "';";
                $conn->query($sql);

                if ($conn->affected_rows > 0) {
                    $responseJson['codigo'] = 200;
                    $responseJson['mensaje'] = "vidas de usuario reestablecidas";
                    $responseJson['respuesta'] = "";
                } else {
                    $responseJson['codigo'] = 402;
                    $responseJson['mensaje'] = "No se logro reestablecer las vidas del estudiante";
                    $responseJson['respuesta'] = "";
                }
                echo json_encode($responseJson);
            } else {
                $responseJson['codigo'] = 404;
                $responseJson['mensaje'] = "Usuario No encontrado";
                $responseJson['respuesta'] = "";
                echo json_encode($responseJson);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $responseJson['codigo'] = 444;
            $responseJson['respuesta'] = "";
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
