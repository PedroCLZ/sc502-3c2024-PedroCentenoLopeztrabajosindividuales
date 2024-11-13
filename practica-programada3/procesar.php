<?php
session_start();
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Procesar el formulario para agregar una transacción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $amount = (float) $_POST['amount'];
    $_SESSION['transactions'][] = ['description' => $description, 'amount' => $amount];
}

// Calcular el monto total de contado
$total_contado = array_sum(array_column($_SESSION['transactions'], 'amount'));

// Aplicar el interés del 2.6%
$total_con_interes = $total_contado * 1.026;

// Calcular el cash back (0.1%)
$cash_back = $total_contado * 0.001;

// Calcular el monto final a pagar
$monto_final = $total_con_interes - $cash_back;

// Generar el estado de cuenta en pantalla
echo "<h2>Estado de Cuenta</h2>";
echo "<ul>";
foreach ($_SESSION['transactions'] as $transaction) {
    echo "<li>{$transaction['description']}: \${$transaction['amount']}</li>";
}
echo "</ul>";
echo "<p>Total de Contado: \${$total_contado}</p>";
echo "<p>Total con Interés (2.6%): \${$total_con_interes}</p>";
echo "<p>Cash Back (0.1%): \${$cash_back}</p>";
echo "<p>Monto Final a Pagar: \${$monto_final}</p>";

// Generar el archivo de texto
$filename = "estado_cuenta.txt";
$file_content = "Estado de Cuenta\n";
foreach ($_SESSION['transactions'] as $transaction) {
    $file_content .= "{$transaction['description']}: \${$transaction['amount']}\n";
}
$file_content .= "\nTotal de Contado: \${$total_contado}\n";
$file_content .= "Total con Interés (2.6%): \${$total_con_interes}\n";
$file_content .= "Cash Back (0.1%): \${$cash_back}\n";
$file_content .= "Monto Final a Pagar: \${$monto_final}\n";

// Escribir el contenido en el archivo
file_put_contents($filename, $file_content);
echo "<p>El estado de cuenta se ha guardado en <a href='$filename' target='_blank'>$filename</a></p>";
?>
