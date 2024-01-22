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

    public static function delCarrito($pdo, $guid)
    {
        try {
            //Borramos todos los carritos
            $query = "DELETE from carrito where GUID =:GUID";

            //Prepararmos la ejecucion de la sentencia (statement stmt)
            $stmt = $pdo->prepare($query);

            //Asociamos el valor del parametro idcarrito a la posicion de :id
            $stmt->bindValue(':GUID', $guid);

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
            //Query para modificar 
            $query = "UPDATE carrito set ";

            //Si no nos meten nada para modificar devolvemos error
            if (count($carrito) == 0)
                return -1;

            if (isset($carrito['fecha']))
                $query = $query . " fecha=:fecha";

            if (isset($carrito['cantidad'])) {
                //Si la cadena de la query tiene mas caracteres de la inicial, implica que antes hay un campo 
                //Modificado y tengo que poner la ,
                if (strlen($query) > 20)
                    $query = $query . ',';
                $query = $query . " cantidad=:cantidad";
            }

            if (isset($carrito['DNI'])) {
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " DNI=:id";
            }

            if (isset($carrito['GUID'])) {
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " where GUID=:id";
            }

            if (isset($carrito['id'])) {
                if (strlen($query) > 20)
                    $query = $query . ',';

                $query = $query . " where id=:id";
            }

            //nombre, descripcion, peso, precio, tamano where idcarritos
            //Depuracion cutre mostramos la query
            echo $query . "<br/>";

            $stmt = $pdo->prepare($query);

            //Asociamos a los campos de la query los valores

            if (isset($carrito['fecha']))
                $stmt->bindValue(':fecha', $carrito['fecha']);

            if (isset($carrito['cantidad']))
                $stmt->bindValue(':cantidad', $carrito['cantidad']);

            if (isset($carrito['GUID']))
                $stmt->bindValue(':id', $carrito['GUID']);

            if (isset($carrito['DNI']))
                $stmt->bindValue(':id', $carrito['DNI']);

            if (isset($carrito['id']))
                $stmt->bindValue(':id', $carrito['id']);

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

    public static function insertCarrito($pdo, $carrito)
    {
        try {
            // HACEMOS UN EJEMPLO DE INSERT
            // En lugar de un valor que nos llega inseguro ponemos siempre ?
            // asi evitamos la inyeccion sql
            $query = "INSERT INTO carrito (fecha, cantidad, GUID, DNI) VALUES (:fecha, :cantidad, :GUID, :DNI)";

            // De esta forma hay que preparar primero la sentencia
            $stmt = $pdo->prepare($query);

            // Asignamos el valor en el lugar de la :variable
            $stmt->bindValue(':fecha', $carrito['fecha']);
            $stmt->bindValue(':cantidad', $carrito['cantidad']);
            $stmt->bindValue(':GUID', $carrito['GUID']);
            $stmt->bindValue(':DNI', $carrito['DNI']);

            // Ejecutamos la query
            $stmt->execute();
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            $pdo = null;
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
