<?php

include 'header.php';
try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if (!$conn) {
        echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
    } else {
        if (isset($_GET['usuario']) && isset($_GET['pass']) && isset($_GET['pass2']) && isset($_GET['jugador']) && isset($_GET['nivel'])) {
 
            $usuario = $_GET['usuario'];
            $pass = $_GET['pass'];
            $pass2 = $_GET['pass2'];
            $jugador = $_GET['jugador'];
            $nivel = $_GET['nivel'];



            $sql = "SELECT * FROM `usuarios` WHERE usuario='".$usuario."';";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $sql = "UPDATE `usuarios` SET `pass`='".$pass2."',`jugador`='".$jugador."',`nivel`='".$nivel."' WHERE usuarios= '".$usuario."';" ;
                $conn->query($sql);

                $sql = "SELECT * FROM `usuarios` WHERE usuario='".$usuario."';";
                $resultado = $conn->query($sql);
                $texto='';

                while($row=$resultado->fetch_assoc()){
                    $texto="{#id#:".$row['id'].
                        ",#usuario#:#".$row['usuario'].
                        "#,#pass#:#".$row['pass'].
                        "#,#jugador#:".$row['jugador'].
                        ",#nivel#:".$row['nivel'].
                        "}";
                }
                echo '{"codigo":207, "mensaje":"usuario editado con exito", "respuesta":"'.$texto.'"}';
            } else {
                echo '{"codigo":203, "mensaje": "El usuario no existe", "respuesta":"0"}';
            }
        } else {
            echo '{"codigo":444,"mensaje": "Faltan datos para ejecutar la acción"}';
        }
    }
} catch (Exception $e) {
    echo '{"codigo":400, "mensaje": "Error intentando conectar", "respuesta":""}';
}
include 'footer.php';
?>
