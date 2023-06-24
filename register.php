<?php
include 'header.php';


try {

    //http://localhost/gamificacion/register.php?userName=JohnDoe&password=mypassword&email=johndoe@example.com&userType=admin&userGrade=A
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo": 400, "mensaje": "Error 1intentando conectar"}';
    } else {

        try {


            $usuario = $_POST['userName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userType = $_POST['userType'];
            $userGrade = $_POST['userGrade'];
            echo "debgg" . $email;

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

                    $sql = "SELECT * FROM " . $tableName . " WHERE email='" . $email . "';";
                    $resultado = $conn->query($sql);
                    $texto = '';

                    while ($row = $resultado->fetch_assoc()) {
                        $texto = "{#id#:" . $row['id'] .
                            ",#userName#:#" . $row['userName'] .
                            ",#email#:#" . $row['email'] .
                            "#,#password#:#" . $row['password'] .
                            "#,#userType#:" . $row['userType'] .

                            ",#userGrade#:" . $row['userGrade'] .
                            "}";
                    }

                    echo '{"codigo": 401, "mensaje": "Se creó el siguiente usuario"}';
                    // $response = array(
                    //     "codigo" => 401,
                    //     "mensaje" => "Se creó el siguiente usuario",
                    //     "respuesta" => $row
                    // );
                    // echo json_encode($response);
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
