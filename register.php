<?php
include 'header.php';


try {

    //http://localhost/gamificacion/register.php?userName=JohnDoe&password=mypassword&email=johndoe@example.com&userType=admin&userGrade=A
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        $responseJson['codigo'] = 400;
        $responseJson['mensaje'] = "Error intentando conectar";
        $responseJson['respuesta'] = '';
        echo json_encode($responseJson);
    } else {

        try {

            $usuario = $_POST['userName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = hash('sha256', $password);
            $userType = $_POST['userType'];
            $userGrade = $_POST['userGrade'];
            /*
            $usuario = $_GET['userName'];
            $email = $_GET['email'];
            $password = $_GET['password'];
            $password = hash('sha256', $password);
            $userType = $_GET['userType'];
            $userGrade = $_GET['userGrade'];
*/

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
            $sql = "SELECT * FROM " . $tableName . " WHERE email='" . $email . "';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $responseJson['codigo'] = 202;
                $responseJson['mensaje'] = "Usuario existe en el sistema ya registrado";
                $responseJson['respuesta'] = '';
                echo json_encode($responseJson);
            } else {
                $sql = "INSERT INTO $tableName (`id`, `userName`, `email`, `password`, `userType`, `userGrade`)
    VALUES (NULL, '" . $usuario . "', '" . $email . "', '" . $password . "', '" . $userType . "', '" . $userGrade . "')";


                if ($conn->query($sql) === TRUE) {
                    $sqlSelect = "SELECT * FROM " . $tableName . " WHERE email='" . $email . "';";
                    $resultadoSelect = $conn->query($sqlSelect);
                    $texto = '';

                    while ($row = $resultadoSelect->fetch_assoc()) {
                        $texto = "{#id#:" . $row['id'] .
                            ",#userName#:#" . $row['userName'] .
                            ",#email#:#" . $row['email'] .
                            "#,#password#:#" . $row['password'] .
                            "#,#userType#:" . $row['userType'] .
                            ",#userGrade#:" . $row['userGrade'] .
                            "}";

                        if ($userType == 1) {
                            $logros_json = json_encode(["logros" => ""]);
                            $sqlInsert = "INSERT INTO `inventarios` (`id`, `idEstudiante`, `monedas`, `logros`, `vidas`, `avatar`)
                            VALUES (NULL, '" . $row['id'] . "', '0', '" . $logros_json . "', '3', '" . 0 . "')";
                            $resultadoInsert = $conn->query($sqlInsert);
                            if ($resultadoInsert) {
                                $responseJson['codigo'] = 200;
                                $responseJson['mensaje'] = "Registrado e inventario creado";
                                $responseJson['respuesta'] = '';
                                echo $responseJson;
                            } else {
                                $responseJson['codigo'] = 401;
                                $responseJson['mensaje'] = "Error intentando crear el usuario";
                                $responseJson['respuesta'] = '';
                                echo $responseJson;
                            }
                        }
                    }
                } else {
                    $responseJson['codigo'] = 401;
                    $responseJson['mensaje'] = "Error intentando crear el usuario";
                    $responseJson['respuesta'] = '';
                    echo json_encode($responseJson);
                    // $response = array(
                    //     "codigo" => 401,
                    //     "mensaje" => "Error intentando crear el usuario",
                    //     "respuesta" => ""
                    // );
                    // echo json_encode($response);
                }
            }
        } catch (Exception $e) {
            $responseJson['codigo'] = 503;
            $responseJson['mensaje'] = "No hay datos para crear el usuario";
            $responseJson['respuesta'] = '';
            echo json_encode($responseJson);


            // $response = array(
            //     "codigo" => 503,
            //     "mensaje" => "No hay datos para crear el usuario+"
            // );
            // echo json_encode($response);
        }
    }
} catch (Exception $e) {

    $responseJson['codigo'] = 400;
    $responseJson['mensaje'] = "Error intentando conectar";
    $responseJson['respuesta'] = '';
    echo json_encode($responseJson);
}
include 'footer.php';
