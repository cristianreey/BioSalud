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

    public static function updateProducto($pdo, $producto)
    {

        try {
            //Query para modificar 
            $query = "UPDATE productos set ";

            //Si no nos meten nada para modificar devolvemos error
            if (count($producto) == 0)
                return -1;

            if (isset($producto['nombre']))
                $query = $query . " nombre=:nombre";

            if (isset($producto['precio'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " precio=:precio";
            }

            if (isset($producto['stock'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " stock=:stock";
            }

            if (isset($producto['cantidad'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " cantidad=:cantidad";
            }

            if (isset($producto['descripcion'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " descripcion=:descripcion";
            }

            if (isset($producto['url'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " url=:url";
            }

            if (isset($producto['idMarca'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " idMarca=:idMarca";
            }

            if (isset($producto['idCategoria'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " idCategoria=:idCategoria";
            }

            if (isset($producto['GUID'])) {
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " where GUID=:id";
            }

            //nombre, descripcion, peso, precio, tamano where idProductos
            //Depuracion cutre mostramos la query
            echo $query . "<br/>";

            $stmt = $pdo->prepare($query);

            //Asociamos a los campos de la query los valores

            if (isset($producto['nombre']))
                $stmt->bindValue(':nombre', $producto['nombre']);

            if (isset($producto['precio']))
                $stmt->bindValue(':precio', $producto['precio']);

            if (isset($producto['stock']))
                $stmt->bindValue(':stock', $producto['stock']);

            if (isset($producto['cantidad']))
                $stmt->bindValue(':cantidad', $producto['cantidad']);

            if (isset($producto['descripcion']))
                $stmt->bindValue(':descripcion', $producto['descripcion']);

            if (isset($producto['url']))
                $stmt->bindValue(':url', $producto['url']);

            if (isset($producto['idMarca']))
                $stmt->bindValue(':idMarca', $producto['idMarca']);

            if (isset($producto['idCategoria']))
                $stmt->bindValue(':idCategoria', $producto['idCategoria']);

            if (isset($producto['GUID']))
                $stmt->bindValue(':id', $producto['GUID']);



            //Ejecutamos la query
            $stmt->execute();

            //Sacamos la cantidad de filas afectadas
            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
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
            //Realizamos una query
            $query = "SELECT * FROM productos WHERE $idCategoria = :idCategoria";

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

    public static function obtenerProductoCarrito($pdo)
    {
        try {
            // Realizamos una query sin un GUID específico, para obtener todos los productos en la tabla carrito
            $query = "SELECT productos.*
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
