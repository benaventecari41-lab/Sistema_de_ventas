<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta #<?= str_pad($comprobante['cabecera']['id'], 5, '0', STR_PAD_LEFT) ?></title>
    <link rel="stylesheet" href="public/css/estilos.css">
    <style>
        body { background: #fff; }
        .comprobante-box {
            max-width: 650px;
            margin: 30px auto;
            border: 2px solid #1d4ed8;
            padding: 30px;
            border-radius: 8px;
        }
        .header-comp {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .info-cli {
            margin-bottom: 20px;
        }
        @media print {
            .btn-imprimir { display: none; }
        }
    </style>
</head>
<body>
    <div class="comprobante-box">
        <div class="header-comp">
            <h2>TIENDA VIRTUAL S.A.C.</h2>
            <p>RUC: 20123456789</p>
            <h3>BOLETA DE VENTA ELECTRÓNICA</h3>
            <h4>N° V001-<?= str_pad($comprobante['cabecera']['id'], 6, '0', STR_PAD_LEFT) ?></h4>
        </div>

        <div class="info-cli">
            <p><strong>Cliente:</strong> <?= htmlspecialchars($comprobante['cabecera']['cliente_nombre']) ?></p>
            <p><strong>Correo:</strong> <?= htmlspecialchars($comprobante['cabecera']['correo']) ?></p>
            <p><strong>Fecha de Emisión:</strong> <?= date('d/m/Y H:i:s', strtotime($comprobante['cabecera']['fecha'])) ?></p>
        </div>

        <table class="tabla-custom">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th>Descripción</th>
                    <th>P. Unit</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comprobante['items'] as $it): ?>
                    <tr>
                        <td><?= $it['cantidad'] ?></td>
                        <td><?= htmlspecialchars($it['nombre']) ?></td>
                        <td>S/ <?= number_format($it['precio'], 2) ?></td>
                        <td>S/ <?= number_format($it['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px;">
            <h3>TOTAL IMPORTE: S/ <?= number_format($comprobante['cabecera']['total'], 2) ?></h3>
        </div>

        <div style="text-align: center; margin-top: 30px;" class="btn-imprimir">
            <button onclick="window.print();" class="btn-exito">🖨 Imprimir Comprobante</button>
            <a href="index.php?ruta=historial" class="btn-secundario">Volver al Historial</a>
        </div>
    </div>
</body>
</html>
