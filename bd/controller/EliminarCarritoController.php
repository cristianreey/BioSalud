<?php 
namespace controller;


use bd\model\Carrito as ModelCarrito;
use bd\model\Farmacia as ModelUtils;

include('..\model\carrito.php');
include('..\model\conexion.php');

session_start();

$_SESSION['user']="pedro";

if (isset($_SESSION['user']))
{
//Si el usuario esta logado eliminamos el producto
//Si no hay conexion activa nos conectamos
if (!isset($pdo))
$pdo= ModelUtils::conectar();

//Eliminamos el producto
//Habria que comprobar que se ha borrado y que idProd es numerico no nulo
ModelCarrito::delCarritoCompleto($pdo);

//Cargamos la vista principal
  //Cargamos los datos de los productos
  $datosCarrito = ModelCarrito::getCarrito($pdo);

  //Cargamos la vista
  include('..\view/CarritoTienda.php');
}

?>