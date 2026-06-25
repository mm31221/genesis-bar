<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");

$precios = [
    "pizza" => 12000,
    "sushi" => 18000,
    "empanadas" => 1500
];

$producto = $_POST['producto'] ?? '';
$cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 0;
$id_comanda = null;
$total = 0;
$hora = date("Y-m-d H:i:s");
$mensaje = "";

if (!array_key_exists($producto, $precios)) {
    $mensaje = "El producto seleccionado no es valido.";
} elseif ($cantidad < 1) {
    $mensaje = "La cantidad debe ser mayor a cero.";
} else {
    $total = $precios[$producto] * $cantidad;

    $sql = "INSERT INTO pedidos (producto, cantidad, hora, total, estado)
            VALUES (?, ?, ?, ?, 'Pendiente')";

    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sisi", $producto, $cantidad, $hora, $total);

        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Pedido guardado correctamente.";
            $id_comanda = mysqli_insert_id($conexion);
        } else {
            $mensaje = "No se pudo guardar el pedido.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $mensaje = "No se pudo preparar el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Registrado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor">

    <h1>
        <?php if ($id_comanda): ?>
            Comanda N&ordm; <?php echo htmlspecialchars($id_comanda); ?>
        <?php else: ?>
            Pedido no registrado
        <?php endif; ?>
    </h1>

    <p><?php echo htmlspecialchars($mensaje); ?></p>

    <?php if ($id_comanda): ?>
        <p><strong>Producto:</strong> <?php echo htmlspecialchars(ucfirst($producto)); ?></p>
        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($cantidad); ?></p>
        <p><strong>Hora:</strong> <?php echo htmlspecialchars($hora); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($total, 0, ',', '.'); ?></p>
    <?php endif; ?>

    <a href="../index.html">Volver al inicio</a>
    <a href="comandas.php">Ver comandas</a>

</div>

</body>
</html>
