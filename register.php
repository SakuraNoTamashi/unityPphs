<?php
include 'header.php';


try {

    //http://localhost/gamificacion/register.php?userName=JohnDoe&password=mypassword&email=johndoe@example.com&userType=admin&userGrade=A
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo": 400, "mensaje": "Error 1intentando conectar"}';
    } else {

        try {

            echo "hola";/*
            $usuario = $_POST['userName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = hash('sha256', $password);
            $userType = $_POST['userType'];
            $userGrade = $_POST['userGrade'];*/

            $usuario = $_GET['userName'];
            $email = $_GET['email'];
            $password = $_GET['password'];
            $password = hash('sha256', $password);
            $userType = $_GET['userType'];
            $userGrade = $_GET['userGrade'];


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

                echo '{"codigo": 202, "mensaje": "Usuario existe en el sistema ya registrado"}';
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
                        echo "id: " . $row['id'];
                        if ($userType == 1) {
                            $avatar_json = json_encode(["avatar" => "default"]);
                            $logros_json = json_encode(["logros" => ""]);
                            $sqlInsert = "INSERT INTO `inventarios` (`id`, `idEstudiante`, `monedas`, `logros`, `vidas`, `avatar`)
VALUES (NULL, '" . $row['id'] . "', '0', '" . $logros_json . "', '3', '" . $avatar_json . "')";
                            $resultadoInsert = $conn->query($sqlInsert);
                            if ($resultadoInsert) {
                                echo "Query executed successfully. Affected rows: " . $conn->affected_rows;
                            } else {
                                echo "Error executing query: " . $conn->error;
                            }
                        }
                    }
                } else {
                    echo '{"codigo": 401, "mensaje": "Error intentando crear el usuario"}';
                    // $response = array(
                    //     "codigo" => 401,
                    //     "mensaje" => "Error intentando crear el usuario",
                    //     "respuesta" => ""
                    // );
                    // echo json_encode($response);
                }
            }
        } catch (Exception $e) {
            echo '{"codigo": 503, "mensaje": "No hay datos para crear el usuario ' . $e->getMessage() . '"}';

            // $response = array(
            //     "codigo" => 503,
            //     "mensaje" => "No hay datos para crear el usuario+"
            // );
            // echo json_encode($response);
        }
    }
} catch (Exception $e) {

    echo '{"codigo": 400, "mensaje": "Error inten2tando conectar"}';
}
include 'footer.php';
