<?php
include 'Database.php';
include 'Cliente.php';

class ClienteModel {
   public function getClientes($ordenc) {
//obtenemos la informacion de la bdd:
        $pdo = Database::connect();
//verificamos el ordenamiento asc o desc:
        if ($ordenc == true)//asc
            $sql = "select * from clientes order by id";
        else //desc
            $sql = "select * from clientes order by id";
        $resultado = $pdo->query($sql);
//transformamos los registros en objetos de tipo Producto:
        $listadoC= array();
        foreach ($resultado as $res) {
            $cliente = new Cliente();
            $cliente->setCodigo($res['id']);
            $cliente->setNombre($res['cedula']);
            $cliente->setPrecio($res['nombres']);
            $cliente->setCantidad($res['apellidos']);
            array_push($listadoC, $cliente);
        }
        Database::disconnect();
//retornamos el listado resultante:
        return $listadoC;
    }

 public function getCliente($id) {
//Obtenemos la informacion del producto especifico:
        $pdo = Database::connect();
//Utilizamos parametros para la consulta:
        $sql = "select * from clientes where id=?";
        $consulta = $pdo->prepare($sql);
//Ejecutamos y pasamos los parametros para la consulta:
        $consulta->execute(array($id));
//Extraemos el registro especifico:
        $dato = $consulta->fetch(PDO::FETCH_ASSOC);
//Transformamos el registro obtenido a objeto:
        $cliente = new Cliente();
        $cliente->setId($dato['id']);
        $cliente->setCedula($dato['cedula']);
        $cliente->setNombres($dato['nombres']);
        $cliente->setApellidos($dato['apellidos']);
        Database::disconnect();
        return $cliente;
    }

public function crearCliente($id, $cedula, $nombres, $apellidos) {
//Preparamos la conexion a la bdd:
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//Preparamos la sentencia con parametros:
        $sql = "insert into clientes (id, cedula, nombres, apellidos) values(?,?,?,?)";
        $consulta = $pdo->prepare($sql);
//Ejecutamos y pasamos los parametros:
        try {
            $consulta->execute(array($id, $cedula, $nombres, $apellidos));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        //$consulta->execute(array($codigo, $nombre, $precio, $cantidad));
        Database::disconnect();
    }

    /**
     * Elimina un producto especifico de la bdd.
     * @param type $codigo
     */
    public function eliminarCliente($id) {
//Preparamos la conexion a la bdd:
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from clientes where id=?";
        $consulta = $pdo->prepare($sql);
//Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($id));
        Database::disconnect();
    }

    public function actualizarCliente($id, $cedula, $nombres, $apellidos) {
//Preparamos la conexión a la bdd:
        $pdo = Database::connect();
        $sql = "update clientes set cedula=?,nombres=?,apellidos=? where id=?";
        $consulta = $pdo->prepare($sql);
//Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($id, $cedula, $nombres, $apellidos));
        Database::disconnect();
    }
}
