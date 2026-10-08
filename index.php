<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cálculo de Sueldo Quincenal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 500px; }
        label { font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin: 5px 0 15px 0; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #0056b3; }
        hr { margin: 20px 0; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Calculadora de Sueldo Quincenal</h2>

        <form action="index.php" method="POST">
            
            <h3>Datos del Empleado</h3>
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="cedula">Cédula de Identidad:</label>
            <input type="text" id="cedula" name="cedula" required>

            <h3>Horas Trabajadas en la Quincena</h3>
            <label for="horas_diurnas">Horas Diurnas (675 Bs./h):</label>
            <input type="number" id="horas_diurnas" name="horas_diurnas" min="0" value="0" step="any" required>

            <label for="horas_vespertinas">Horas Vespertinas (700 Bs./h):</label>
            <input type="number" id="horas_vespertinas" name="horas_vespertinas" min="0" value="0" step="any" required>

            <label for="horas_nocturnas">Horas Nocturnas (956.23 Bs./h):</label>
            <input type="number" step="any" id="horas_nocturnas" name="horas_nocturnas" min="0" value="0" required>

            <button type="submit">Calcular Sueldo</button>

        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = $_POST['nombre'];
            $cedula = $_POST['cedula'];
            $horas_diurnas = floatval($_POST['horas_diurnas']);
            $horas_vespertinas = floatval($_POST['horas_vespertinas']);
            $horas_nocturnas = floatval($_POST['horas_nocturnas']);

            $tarifa_diurna = 675.00;
            $tarifa_vespertina = 700.00;
            $tarifa_nocturna = 956.23;

            $sueldo_diurno = $horas_diurnas * $tarifa_diurna;
            $sueldo_vespertino = $horas_vespertinas * $tarifa_vespertina;
            $sueldo_nocturno = $horas_nocturnas * $tarifa_nocturna;

            $sueldo_bruto = $sueldo_diurno + $sueldo_vespertino + $sueldo_nocturno;

            if ($sueldo_bruto < 85000) {
                $porc_ahorro = 0.001;  // 0.1%
                $porc_seguro = 0.0015; // 0.15%
            } elseif ($sueldo_bruto <= 150000) {
                $porc_ahorro = 0.0015; // 0.15%
                $porc_seguro = 0.002;  // 0.2%
            } else {
                $porc_ahorro = 0.003;  // 0.3%
                $porc_seguro = 0.0025; // 0.25%
            }

            $descuento_ahorro = $sueldo_bruto * $porc_ahorro;
            $descuento_seguro = $sueldo_bruto * $porc_seguro;
            $total_descuentos = $descuento_ahorro + $descuento_seguro;

            $sueldo_neto = $sueldo_bruto - $total_descuentos;
            ?>

            <hr>

            <h2>Recibo de Pago Quincenal</h2>

            <h3>Datos del Empleado</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
            <p><strong>Cédula:</strong> <?php echo htmlspecialchars($cedula); ?></p>

            <h3>Detalle de Ingresos</h3>
            <p><strong>Sueldo Bruto:</strong> <?php echo number_format($sueldo_bruto, 2, ',', '.'); ?> Bs.</p>

            <h3>Deducciones y Retenciones</h3>
            <p><strong>Ahorro Habitacional (<?php echo ($porc_ahorro * 100); ?>%):</strong> <?php echo number_format($descuento_ahorro, 2, ',', '.'); ?> Bs.</p>
            <p><strong>Seguro Social (<?php echo ($porc_seguro * 100); ?>%):</strong> <?php echo number_format($descuento_seguro, 2, ',', '.'); ?> Bs.</p>
            <p><strong>Total Deducciones:</strong> <?php echo number_format($total_descuentos, 2, ',', '.'); ?> Bs.</p>

            <hr>

            <h3>Sueldo Neto a Cobrar</h3>
            <p><strong>Total Neto: <?php echo number_format($sueldo_neto, 2, ',', '.'); ?> Bs.</strong></p>

            <br>
            <a href="index.php">Limpiar / Calcular de nuevo</a>

            <?php
        }
        ?>
    </div>

</body>
</html>