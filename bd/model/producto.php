<?php

namespace bd\model;

use PDOException;
use PDO;

class Producto
{
    /**
     * Devuelve un array asociativo con todos los datos
     * de la tabla productos
     */
    public static function getProducto($pdo)
    {

        try {
            //Realizamos una query
            $query = "SELECT * FROM productos ";

            $resultado = $pdo->query($query);

            //FetchAll nos saca todos los registros de la query
            //El fetchall no se puede utilizar mas de una vez
            $resulSet = $resultado->fetchAll();
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        //Devolvemos los datos de la query
        return $resulSet;
    }

    public static function delProducto($pdo, $guid)
    {
        try {
            //Borramos todos los productos
            $query = "DELETE from productos where GUID =:id";

            //Prepararmos la ejecucion de la sentencia (statement stmt)
            $stmt = $pdo->prepare($query);

            //Asociamos el valor del parametro idproducto a la posicion de :id
            $stmt->bindValue(':id', $guid);

            $stmt->execute();

            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        } finally {
            $pdo = null;
        }
    }

    public static function insertProducto($pdo, $producto)
    {

        try {
            //HACEMOS UN EJEMPLO DE INSERT
            //En lugar de un valor que nos llega inseguro ponemos siempre ?
            //asi evitamos la inyeccion sql
            $query = "INSERT INTO productos  (nombre,precio,stock,cantidad,descripcion,url,idMarca,idCategoria)  VALUES (:nombre,:precio,:stock,:cantidad,:descripcion,:url,:idMarca,:idCategoria)";

            //De esta forma hay que preparar primero la sentencia
            $stmt = $pdo->prepare($query);

            //Asignamos el valor en el lugar de la :variable
            $stmt->bindValue(':nombre', $producto['nombre']);
            $stmt->bindValue(':precio', $producto['precio']);
            $stmt->bindValue(':stock', $producto['stock']);
            $stmt->bindValue(':cantidad', $producto['cantidad']);
            $stmt->bindValue(':descripcion', $producto['descripcion']);
            $stmt->bindValue(':url', $producto['url']);
            $stmt->bindValue(':idMarca', $producto['idMarca']);
            $stmt->bindValue(':idCategoria', $producto['idCategoria']);

            //Ejecutamos la query
            $stmt->execute();
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            $pdo = null;
        }
    }

    public static function obtenerProductosPorCategoria($pdo, $idCategoria)
    {
        try {
            $query = "SELECT p.*
                      FROM productos p
                      WHERE p.idCategoria = :idCategoria";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar si se encontraron productos
            if ($stmt->rowCount() > 0) {
                $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $productos;
            } else {
                return array();  // Devolver un array vacío si no hay productos
            }
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return null;
        }
    }

    public static function obtenerProductoCarrito($pdo)
    {
        try {
            // Realizamos una query sin un GUID específico, para obtener todos los productos en la tabla carrito
            $query = "SELECT productos.*, carrito.cantidad, carrito.precio
                      FROM productos
                      INNER JOIN carrito ON productos.GUID = carrito.GUID";

            // Preparamos la ejecución de la sentencia (statement stmt)
            $stmt = $pdo->prepare($query);

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados como un array asociativo
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Devolvemos los datos de los productos
            return $resultSet;
        } catch (PDOException $e) {
            // Manejo de errores
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
