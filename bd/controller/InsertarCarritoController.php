<?php

namespace controller;


use bd\model\Carrito as ModelCarrito;
use bd\model\Farmacia as ModelUtils;

include('..\model\carrito.php');
include('..\model\conexion.php');

session_start();

if (isset($_SESSION['user'])) {
    //Si el usuario esta logado insertamos el producto
    //Si no hay conexion activa nos conectamos
    if (!isset($pdo)) {
        $pdo = ModelUtils::conectar();
    }

    $fecha = ModelUtils::validarDatos($_POST['fecha']);
    $cantidad = ModelUtils::validarDatos($_POST['cantidad']);
    $guid = ModelUtils::validarDatos($_POST['GUID']);
    $dni = ModelUtils::validarDatos($_POST['DNI']);
    $precio = ModelUtils::validarDatos($_POST['precio']);


    //Creamos el array asociativo con los datos del producto
    $carrito_nuevo = [
        'fecha' => $_POST['fecha'],
        'cantidad' => $_POST['cantidad'],
        'GUID' => $_POST['GUID'],
        'DNI' => $_POST['DNI'],
        'precio' => $_POST['precio']
    ];

    //Insertamos el producto
    ModelCarrito::insertCarrito($pdo, $carrito_nuevo);

    //Cargamos los datos de los productos
    $datosProducto = ModelCarrito::getCarrito($pdo);

    //Cargamos la vista
    include('..\view/CarritoTienda.php');
}
