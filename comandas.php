<?php
include("conexion.php");

$sql = "SELECT * FROM pedidos ORDER BY id DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandas - Genesis Bar</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor">

    <h1>Listado de Comandas</h1>

    <a href="../index.html">Nueva comanda</a>

    <table>
        <tr>
            <th>Comanda</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha y Hora</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Accion</th>
        </tr>

        <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr class="<?php echo ($fila['estado'] == 'Entregado') ? 'entregado' : ''; ?>">
                    <td><?php echo htmlspecialchars($fila['id']); ?></td>
                    <td><?php echo htmlspecialchars($fila['producto']); ?></td>
                    <td><?php echo htmlspecialchars($fila['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($fila['hora']); ?></td>
                    <td>$<?php echo number_format($fila['total'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($fila['estado']); ?></td>
                    <td>
                        <?php if ($fila['estado'] == 'Pendiente'): ?>
                            <a href="entregado.php?id=<?php echo urlencode($fila['id']); ?>">Marcar entregado</a>
                        <?php else: ?>
                            Entregado
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Todavia no hay comandas cargadas.</td>
            </tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>
