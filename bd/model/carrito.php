<?php

namespace bd\model;

use PDOException;

class Carrito
{
    /**
     * Devuelve un array asociativo con todos los datos
     * de la tabla carritos
     */
    public static function getCarrito($pdo)
    {

        try {
            //Realizamos una query
            $query = "SELECT * FROM carrito";

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

    public static function delCarrito($pdo, $idProducto)
    {
        try {
            // Borramos el producto del carrito
            $query = "DELETE FROM carrito WHERE GUID = :GUID";

            // Preparamos la ejecución de la sentencia (statement stmt)
            $stmt = $pdo->prepare($query);

            // Asociamos el valor del parámetro id al marcador :id
            $stmt->bindValue(':GUID', $idProducto);

            // Ejecutamos la consulta
            $stmt->execute();

            // Devolvemos la cantidad de filas afectadas
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Manejo de errores
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;  // Indica un error
        } finally {
            // Cerramos la conexión en el bloque finally
            $pdo = null;
        }
    }

    public static function delCarritoCompleto($pdo)
    {
        try {
            // Borramos todos los carritos
            $query = "DELETE FROM carrito";

            // Ejecutamos la consulta
            $resultado = $pdo->exec($query);

            // No es necesario realizar un fetchAll después de un DELETE
            // Devolvemos el resultado de la ejecución (número de filas afectadas)
            return $resultado;
        } catch (PDOException $e) {
            // Manejo de errores
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        } finally {
            // Cerramos la conexión en el bloque finally
            $pdo = null;
        }
    }

    public static function updateCarrito($pdo, $carrito)
    {
        try {
            // Query para modificar 
            $query = "UPDATE carrito SET";

            // Si no nos meten nada para modificar devolvemos error
            if (count($carrito) == 0)
                return -1;

            // Construir la parte SET de la consulta
            $setClause = "";

            if (isset($carrito['fecha'])) {
                $setClause .= " fecha = :fecha";
            }

            if (isset($carrito['cantidad'])) {
                if (!empty($setClause)) {
                    $setClause .= ",";
                }
                $setClause .= " cantidad = :cantidad";
            }

            // Agregar la parte SET a la consulta
            $query .= $setClause;

            // Añadir la condición WHERE
            $query .= " WHERE GUID = :GUID";

            // Depuración cutre mostramos la query
            echo $query . "<br/>";

            // Preparamos la consulta
            $stmt = $pdo->prepare($query);

            // Asociamos a los campos de la query los valores
            if (isset($carrito['fecha'])) {
                $stmt->bindValue(':fecha', $carrito['fecha']);
            }

            if (isset($carrito['cantidad'])) {
                $stmt->bindValue(':cantidad', $carrito['cantidad']);
            }

            // Agregamos la vinculación para el GUID
            $stmt->bindValue(':GUID', $carrito['GUID']);

            // Ejecutamos la query
            $stmt->execute();

            // Sacamos la cantidad de filas afectadas
            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            $pdo = null;
        }
    }

    public static function insertCarrito($pdo, $carrito)
    {
        try {
            // Verificamos si el producto ya existe en el carrito
            $productoExistente = false;

            // Obtenemos el carrito completo
            $carritoCompleto = self::getCarrito($pdo);

            // Iteramos sobre los productos en el carrito
            foreach ($carritoCompleto as $productoActual) {
                if ($productoActual['GUID'] == $carrito['GUID']) {
                    // Si el producto ya está en el carrito, actualizamos la cantidad y el precio
                    $productoExistente = true;
                    $query = "UPDATE carrito SET cantidad = :cantidad + cantidad, precio = :precio * cantidad WHERE  GUID = :GUID";
                    break; // Salimos del bucle porque ya encontramos el producto
                }
            }

            // Si el producto no existe en el carrito, realizamos la inserción
            if (!$productoExistente) {
                $query = "INSERT INTO carrito (fecha, cantidad, GUID, DNI, precio) VALUES (:fecha, :cantidad, :GUID, :DNI, :precio * :cantidad)";
            }

            // Preparamos la sentencia
            $stmt = $pdo->prepare($query);

            if ($productoExistente) {
                $stmt->bindValue(':cantidad', $carrito['cantidad']);
                $stmt->bindValue(':GUID', $carrito['GUID']);
                $stmt->bindValue(':precio', $carrito['precio']);
                $stmt->bindValue(':cantidad', $carrito['precio']);

            } else {
                // Asignamos los valores
                $stmt->bindValue(':fecha', $carrito['fecha']);
                $stmt->bindValue(':cantidad', $carrito['cantidad']);
                $stmt->bindValue(':GUID', $carrito['GUID']);
                $stmt->bindValue(':DNI', $carrito['DNI']);
                $stmt->bindValue(':precio', $carrito['precio']);
            }




            // Ejecutamos la query
            $stmt->execute();

            // Devolvemos la cantidad de filas afectadas
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Manejo de errores
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            // No cierres la conexión aquí, déjalo para el código que llama a esta función
        }
    }



    public static function getProductoCarrito($pdo)
    {

        try {
            //Realizamos una query
            $query = "SELECT GUID FROM carrito";

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
}
