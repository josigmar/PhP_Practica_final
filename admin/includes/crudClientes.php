<?php
require_once "database.php";

class Clientes {
    public function showClientes() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Clientes";
            $result = $conn->query($sql);

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getClienteById($id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Clientes WHERE Cod_cliente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_assoc() : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function insertarCliente($nombre, $apellidos, $telefono, $email, $password) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "INSERT INTO Clientes (Nombre, Apellidos, Telefono, Email, Password) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $nombre, $apellidos, $telefono, $email, $password);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function actualizarCliente($id, $nombre, $apellidos, $telefono, $email) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "UPDATE Clientes SET Nombre=?, Apellidos=?, Telefono=?, Email=? WHERE Cod_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $nombre, $apellidos, $telefono, $email, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function eliminarCliente($id) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "DELETE FROM Clientes WHERE Cod_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function actualizarPassword($id, $password) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "UPDATE Clientes SET Password=? WHERE Cod_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>