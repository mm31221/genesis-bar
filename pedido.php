<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");

$producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];

$precios = [
    "pizza" => 12000,
    "sushi" => 18000,
    "empanadas" => 1500
];

$total = $precios[$producto] * $cantidad;
$hora = date("Y-m-d H:i:s");

$sql = "INSERT INTO pedidos (producto, cantidad, hora, total)
VALUES ('$producto', '$cantidad', '$hora', '$total')";

if (mysqli_query($conexion, $sql)) {
    $mensaje = "Pedido guardado correctamente";
} else {
    $mensaje = "ERROR SQL: " . mysqli_error($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido Registrado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">

    <h1>Pedido Registrado</h1>

    <p><?php echo $mensaje; ?></p>

    <p><strong>Producto:</strong> <?php echo ucfirst($producto); ?></p>

    <p><strong>Cantidad:</strong> <?php echo $cantidad; ?></p>

    <p><strong>Hora:</strong> <?php echo $hora; ?></p>

    <p><strong>Total:</strong> $<?php echo number_format($total, 0, ',', '.'); ?></p>

</div>

</body>
</html>