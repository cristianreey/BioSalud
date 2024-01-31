<?php

use bd\model\Carrito;
use bd\model\Farmacia;

require_once('../model/conexion.php');
require_once('../model/carrito.php');


// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {

  // Obtener el ID del producto a eliminar
  $productoId = $_POST['producto_id'];
  var_dump($productoId);

  // Lógica para eliminar el producto del carrito
  $pdo = Farmacia::conectar();

  $filas_afectadas = Carrito::delCarrito($pdo, $productoId);
  var_dump($filas_afectadas);
  if ($filas_afectadas > 0) {
    // Éxito: redirigir a la página del carrito
    header('Location: ../view/CarritoTienda.php');
  } else {
    // Error: manejar de acuerdo a tus necesidades
    echo "Error al eliminar el producto del carrito.";
  }
} else {
  // Si no se reciben datos válidos, redirigir a la página del carrito
  header('Location: ../view/CarritoTienda.php');
}
?>