<?php

namespace controller;


use bd\model\Producto as ModelProducto;
use bd\model\Farmacia as ModelUtils;

include('..\model\producto.php');
include('..\model\conexion.php');

session_start();

$_SESSION['user'] = "pedro";

if (isset($_SESSION['user'])) {
    //Si el usuario esta logado eliminamos el producto
    //Si no hay conexion activa nos conectamos
    if (!isset($pdo))
        $pdo = ModelUtils::conectar();

    //Cargamos el id del producto a eliminar
    $nombre = ModelUtils::validarDatos($_POST['nombre']);
    $precio = ModelUtils::validarDatos($_POST['precio']);
    $stock = ModelUtils::validarDatos($_POST['stock']);
    $cantidad = ModelUtils::validarDatos($_POST['cantidad']);
    $descripcion = ModelUtils::validarDatos($_POST['descripcion']);
    $url = ModelUtils::validarDatos($_POST['url']);
    $idMarca = ModelUtils::validarDatos($_POST['idMarca']);
    $idCategoria = ModelUtils::validarDatos($_POST['idCategoria']);

    //Creamos el array asociativo con los datos del producto
    $prod_nuevo = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'stock' => $_POST['stock'],
        'cantidad' => $_POST['cantidad'],
        'descripcion' => $_POST['descripcion'],
        'url' => $_POST['url'],
        'idMarca' => $_POST['idMarca'],
        'idCategoria' => $_POST['idCategoria']
    ];

    //Insertamos el producto
    //Habria que comprobar que se ha insertado bien
    ModelProducto::updateProducto($pdo, $prod_nuevo);

    //Cargamos la vista principal
    //Cargamos los datos de los productos
    $datosProducto = ModelProducto::getProducto($pdo);

    //Cargamos la vista
    include('..\view/Tienda.php');
}
