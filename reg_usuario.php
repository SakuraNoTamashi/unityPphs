<?php
include 'header.php';
try {

    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo": 400, "mensaje": "Error 1intentando conectar", "respuesta": ""}';
    } else {
        if (isset($_GET['usuario']) && isset($_GET['pass']) && isset($_GET['jugador']) && isset($_GET['nivel'])) {

            $usuario = $_GET['usuario'];
            $pass = $_GET['pass'];
            $jugador = $_GET['jugador'];
            $nivel = $_GET['nivel'];

            $sql = "SELECT * FROM `usuarios` WHERE usuario='" . $usuario . "';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                echo '{"codigo": 202, "mensaje": "Usuario existe en el sistema ya registrado", "respuesta": "' . $resultado . '"}';
            } else {
                $sql = "INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `jugador`, `nivel`)
                VALUES (NULL, '" . $usuario . "', '" . $pass . "', '" . $jugador . "', '" . $nivel . "');";

                if ($conn->query($sql) === TRUE) {

                    $sql = "SELECT * FROM `usuarios` WHERE usuario='" . $usuario . "';";
                    $resultado = $conn->query($sql);
                    $texto = '';

                    while ($row = $resultado->fetch_assoc()) {
                        $texto = "{#id#:" . $row['id'] .
                            ",#usuario#:#" . $row['usuario'] .
                            "#,#pass#:#" . $row['pass'] .
                            "#,#jugador#:" . $row['jugador'] .
                            ",#nivel#:" . $row['nivel'] .
                            "}";
                    }
                    echo '{"codigo": 401, "mensaje": "Se creó el siguiente usuario", "respuesta": "' . $texto . '"}';
                } else {
                    echo '{"codigo": 401, "mensaje": "Error intentando crear el usuario", "respuesta": ""}';
                }
            }
        } else {
            echo '{"codigo": 503, "mensaje": "No hay datos para crear el usuario"}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo": 400, "mensaje": "Error inten2tando conectar", "respuesta":' . $e . '}';
}
include 'footer.php';
