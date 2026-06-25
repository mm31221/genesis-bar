<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");

$sql = "SELECT * FROM pedidos WHERE estado = 'Pendiente' ORDER BY id ASC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">
    <title>Cocina - Genesis Bar</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor">

    <h1>Pantalla de Cocina</h1>
    <p>Pedidos pendientes. La pantalla se actualiza automaticamente cada 5 segundos.</p>

    <div class="acciones">
        <a href="../index.html">Nueva comanda</a>
        <a href="comandas.php">Ver todas las comandas</a>
    </div>

    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
        <div class="cocina-grid">
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <?php
                $minutos_espera = floor((time() - strtotime($fila['hora'])) / 60);

                if ($minutos_espera <= 10) {
                    $clase_estado = "a-tiempo";
                    $texto_estado = "A tiempo";
                } elseif ($minutos_espera <= 30) {
                    $clase_estado = "demorado";
                    $texto_estado = "Demorado";
                } else {
                    $clase_estado = "atrasado";
                    $texto_estado = "Muy atrasado";
                }
                ?>

                <div class="comanda tarjeta-cocina <?php echo $clase_estado; ?>">
                    <div class="tarjeta-encabezado">
                        <h2>Comanda #<?php echo htmlspecialchars($fila['id']); ?></h2>
                        <span class="estado-tiempo"><?php echo $texto_estado; ?></span>
                    </div>

                    <p><strong>Producto:</strong> <?php echo htmlspecialchars(ucfirst($fila['producto'])); ?></p>
                    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($fila['cantidad']); ?></p>
                    <p><strong>Hora:</strong> <?php echo htmlspecialchars($fila['hora']); ?></p>
                    <p><strong>Espera:</strong> <?php echo htmlspecialchars($minutos_espera); ?> minutos</p>
                    <p><strong>Total:</strong> $<?php echo number_format($fila['total'], 0, ',', '.'); ?></p>

                    <a href="entregado.php?id=<?php echo urlencode($fila['id']); ?>&volver=cocina">Marcar entregado</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="comanda">
            <h2>No hay pedidos pendientes</h2>
            <p>Cuando se registre una nueva comanda, va a aparecer aca.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
