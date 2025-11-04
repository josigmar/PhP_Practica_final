<?php
// Contraseña BD: V41-ljt{a&Th4b;L
class Connection {
    private $host = "localhost";
    private $user = "josemanuelsantamargarita_admin";
    private $pass = "V41-ljt{a&Th4b;L";
    private $dbname = "josemanuelsantamargarita_practica_final_php";
    
    public function getConnection() {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $conn->set_charset("utf8");
        return $conn;
    }

    public function closeConnection($conn) {
        $conn->close();
    }
}
?>