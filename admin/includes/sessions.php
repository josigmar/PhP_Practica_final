<?php
require_once "database.php";

class Sessions {
    public function comprobarCredenciales($email, $password) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "SELECT * FROM Clientes WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuario = $result->fetch_assoc();
        $db->closeConnection($conn);

        if ($usuario && password_verify($password, $usuario['Password'])) {
            return $usuario;
        } else {
            return null;
        }
    }

    private function log($user) {
        $username = $user['Nombre'];
        $fecha = date('d-m-Y H:i:sa');
        $registro = "[$fecha] -> $username ha iniciado sesión\n";

        //file_put_contents('./logs/actividad.log', $registro, FILE_APPEND);
        $file = "./logs/actividad.log";
        $fp = fopen($file, "a");   
        fwrite($fp, $registro);
        fclose($fp);     
    }

    public function crearSesion($usuario) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        $this->log($usuario);
    }

    public function comprobarSesion() {
        session_start();
        return isset($_SESSION['usuario']);
    }

    public function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>