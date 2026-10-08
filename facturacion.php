<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 500px; }
        label { font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin: 5px 0 15px 0; box-sizing: border-box; }
        input[type="submit"] { background-color: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-weight: bold; }
        input[type="submit"]:hover { background-color: #218838; }
        hr { margin: 20px 0; }
        .resumen { background-color: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745; }
    </style>
</head>
<body>

    <div class="card">
        <h2>SISTEMA DE FACTURACION</h2>
        
        <form action="facturacion.php" method="post">
            <label for="descripcion">Descripción del artículo:</label>
            <input type="text" name="txtdescripcion" id="descripcion" required>

            <label for="cantidad">Cantidad adquirida:</label>
            <input type="number" step="any" min="1" name="txtcantidad" id="cantidad" required>

            <label for="precio">Precio unitario ($):</label>
            <input type="number" step="any" min="0" name="txtprecio" id="precio" required>

            <input type="submit" value="Emitir Factura">
        </form>

        <?php
        if (isset($_POST) && !empty($_POST)) {

            $descripcion = $_POST['txtdescripcion'];
            $cantidad = floatval($_POST['txtcantidad']);
            $precioUnitario = floatval($_POST['txtprecio']);

            $precioBruto = $cantidad * $precioUnitario;
            $montoIVA = $precioBruto * 0.12;
            $totalConIVA = $precioBruto + $montoIVA;

            $montoDescuento = 0;
            $aplicaDescuentoTexto = "NO APLICA!!! El total con IVA no supera los 150$";

            if ($totalConIVA > 150) {
                $montoDescuento = $totalConIVA * 0.15;
                $aplicaDescuentoTexto = "SI APLICA!!! Obtiene un 15% de descuento por superar los 150$";
            }

            $totalNeto = $totalConIVA - $montoDescuento;

            echo "<hr>";
            echo "<div class='resumen'>";
            echo "<h3>DETALLE DE LA FACTURA</h3>";
            echo "<strong>Descripción del Artículo:</strong> " . htmlspecialchars($descripcion) . "<br>";
            echo "<strong>Cantidad adquirida:</strong> " . number_format($cantidad, 2, ',', '.') . "<br>";
            echo "<strong>Precio unitario:</strong> $" . number_format($precioUnitario, 2, ',', '.') . "<br><br>";

            echo "<strong>DESGLOSE DE PAGO:</strong><br>";
            echo "Subtotal (Precio bruto): $" . number_format($precioBruto, 2, ',', '.') . "<br>";
            echo "IVA (12%): $" . number_format($montoIVA, 2, ',', '.') . "<br>";
            echo "Total con IVA incluido: $" . number_format($totalConIVA, 2, ',', '.') . "<br>";
            echo "Descuento: " . $aplicaDescuentoTexto . "<br>";
            
            if ($montoDescuento > 0) {
                echo "Monto descontado: -$" . number_format($montoDescuento, 2, ',', '.') . "<br>";
            }

            echo "<br><strong>MONTO TOTAL NETO A PAGAR: $" . number_format($totalNeto, 2, ',', '.') . "</strong>";
            echo "</div>";
        }
        ?>
    </div>

</body>
</html>