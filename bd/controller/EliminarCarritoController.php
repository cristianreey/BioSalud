<?php

namespace controller;


use bd\model\Carrito as ModelCarrito;
use bd\model\Farmacia as ModelUtils;

include('..\model\carrito.php');
include('..\model\conexion.php');

session_start();

if (isset($_SESSION['user'])) {
  //Si el usuario esta logado eliminamos el producto
  //Si no hay conexion activa nos conectamos
  if (!isset($pdo)){
    $pdo = ModelUtils::conectar();
  }
    
  //Eliminamos el carrito
  ModelCarrito::delCarritoCompleto($pdo);

  //Cargamos los datos de los productos
  $datosCarrito = ModelCarrito::getCarrito($pdo);

  //Cargamos la vista
  include('..\view/CarritoTienda.php');
}
