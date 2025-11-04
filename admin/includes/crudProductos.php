<?php
require_once "database.php";

class Productos {
    public function getPopulares($limite = 4) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos ORDER BY Visitas DESC LIMIT ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limite);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getUltimos($limite = 4) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos ORDER BY Stock ASC LIMIT ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limite);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getByCategoria($categoria) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos WHERE Categoria = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $categoria);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos WHERE Cod_producto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_assoc() : [];
        } catch(Exception $e) {
            return [];
        }
    }

    public function getAll() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT Productos.*, Categorias.nombre_cat FROM Productos LEFT JOIN Categorias ON Productos.Categoria = Categorias.indice_cat ORDER BY Cod_producto ASC";
            $result = $conn->query($sql);

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch(Exception $e) {
            return [];
        }
    }

    public function getByPrecioAsc($categoria) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos WHERE Categoria = ? ORDER BY Precio ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $categoria);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getByPrecioDesc($categoria) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM Productos WHERE Categoria = ? ORDER BY Precio DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $categoria);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function sumarVisita($id) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "UPDATE Productos SET Visitas = Visitas + 1 WHERE Cod_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);        
    }

    public function insertarProducto($cod_producto,$categoria, $modelo, $marca, $peso, $precio, $stock) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "INSERT INTO Productos (Cod_producto, Categoria, Modelo, Marca, Peso, Precio, Stock, Visitas) VALUES (?,?,?,?,?,?,?,0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissidi", $cod_producto,$categoria, $modelo, $marca, $peso, $precio, $stock);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function actualizarProducto($id, $cod_producto,$categoria, $modelo, $marca, $peso, $precio, $stock) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "UPDATE Productos SET cod_producto=?, categoria=?, modelo=?, marca=?, peso=?, precio=?, stock=? WHERE Cod_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissidii", $cod_producto,$categoria, $modelo, $marca, $peso, $precio, $stock, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function eliminarProducto($id) {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "DELETE FROM Productos WHERE Cod_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function getUltimoCodigoByCategoria($categoria) {
        try {
            $db = new Connection();
            $conn = $db->getConnection();

            $sql = "SELECT MAX(Cod_producto) FROM Productos WHERE Categoria = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $categoria);
            $stmt->execute();
            $result = $stmt->get_result();

            $db->closeConnection($conn);

            return $result ? $result->fetch_assoc() : [];
        } catch (Exception $e) {
            return [];
        }
    }
}
?>