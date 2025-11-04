<?php
require_once "database.php";

class Categorias {
    public function showCategorias() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Categorias";
            $result = $conn->query($sql);

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCategoriaById($id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Categorias WHERE indice_cat = ?";
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

    public function insertarCategoria($nombre) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "INSERT INTO Categorias (nombre_cat) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function actualizarCategoria($id, $nombre) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "UPDATE Categorias SET nombre_cat = ? WHERE indice_cat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function eliminarCategoria($id) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "DELETE FROM Categorias WHERE indice_cat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>