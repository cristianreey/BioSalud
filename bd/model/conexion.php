<?php
namespace bd\model;

use PDO;
use PDOException;

class Farmacia
{
    /**
     * Conectar crea una conexion con la BD y nos devuelve la conexion
     * PDO activa o null si hay un fallo 
     */
    public static function conectar()
    {
        include('C:\xampp\htdocs\DES\BioSalud\bd\settings.inc');

        try {
            //Nos conectamos a la base de datos utilizando PDO con la cadena de conexion
            //Y el usuario y la contraseña
            //Controlamos el posible error con try catch
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $password);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $pdo;

    }

    public static function validarDatos($cadena)
    {
        $data = trim($cadena);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

}

?>