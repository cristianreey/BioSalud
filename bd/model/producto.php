<?php

namespace bd\model;

use PDOException;
use PDO;

class Producto
{
   //metodo para conseguir un array asociativo de los productos
    public static function getProducto($pdo)
    {

        try {
            //Realizamos la query
            $query = "SELECT * FROM productos ";

            //ejecutsmos la consulta 
            $resultado = $pdo->query($query);

            //sacamos todos los registros de los productos
            $resulSet = $resultado->fetchAll();
        } catch (PDOException $e) {
            //en caso de error mostramos el mensaje
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        //Devolvemos los datos
        return $resulSet;
    }

    //método para borrar los productos
    public static function delProducto($pdo, $guid)
    {
        try {
            //consulta para borrar los productos
            $query = "DELETE from productos where GUID =:id";

            //Prepararmos la ejecucion de la sentencia 
            $stmt = $pdo->prepare($query);

            //Le damos el valor del parametro idproducto a la posicion de :id
            $stmt->bindValue(':id', $guid);
            //ejecutamos la query
            $stmt->execute();
            //numero de filas afectadas
            $filas_afectadas = $stmt->rowCount();
            //filas afectadas devueltas
            return $filas_afectadas;
        } catch (PDOException $e) {
                        //en caso de error mostramos el mensaje
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        } finally {
            $pdo = null;
        }
    }
    //método para insertar los productos
    public static function insertProducto($pdo, $producto)
    {

        try {
            //guardamos la consulta que vamos a realizar
            $query = "INSERT INTO productos  (nombre,precio,stock,cantidad,descripcion,url,idMarca,idCategoria)  VALUES (:nombre,:precio,:stock,:cantidad,:descripcion,:url,:idMarca,:idCategoria)";

            //Prepararmos la ejecucion de la sentencia 
            $stmt = $pdo->prepare($query);

            //le damos el valor a cada variable
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
        //en caso de error mostramos el mensaje
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            $pdo = null;
        }
    }

    //metodo para obtener los productos segun su categoria
    public static function obtenerProductosPorCategoria($pdo, $idCategoria)
    {
        try {
            //guardamos la consulta
            $query = "SELECT p.*
                      FROM productos p
                      WHERE p.idCategoria = :idCategoria";
            //preparamos la query
            $stmt = $pdo->prepare($query);
            //vinculamos el valor
            $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
            //ejecutamos la consulta
            $stmt->execute();

            // Verificar si se encontraron productos
            if ($stmt->rowCount() > 0) {
                //array de todos los productos
                $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $productos;
            } else {
                return array();  // Devolver un array vacío si no hay productos
            }
        } catch (PDOException $e) {
            //en caso de error mostramos el mensaje
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
            //en caso de error mostramos el mensaje
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
