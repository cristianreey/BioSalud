<?php
// Archivo: funciones.php

include("./conexion.php");
use ejemplo\Farmacia;

function obtenerProductosDesdeBaseDeDatos()
{
    global $conn;

    try {

        $conn = Farmacia::conectar();

        $query = "SELECT * FROM productos";
        $result = $conn->query($query);

        if (!$result) {
            die("Error al obtener productos: " . $conn->error);
        }

        $productos = array();
        $row = '';
        while ($row = $result->fetchAll()) {
            $productos[] = $row;
        }

        return $productos;

    } catch (Exception $e) {
        echo $e;
    }
}
function obtenerProductoDesdeBaseDeDatosPorId($producto_id)
{
    $pdo = Farmacia::conectar("host", "dbname", "usuario", "password");

    try {
        $query = "SELECT * FROM productos WHERE id = :producto_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->execute();

        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $producto;
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

obtenerProductosDesdeBaseDeDatos();
