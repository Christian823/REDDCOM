<?php
// Obtener la hora de entrada y la hora de salida xd
$horaEntrada = strtotime("7:30");
$horaSalida = strtotime("17:00"); 

$horasTrabajadas = ($horaSalida - $horaEntrada) / 3600; // 3600 segundos en una hora

$horasRegulares = 8;
$limiteHorasExtras = 8;

// Calcular las horas extras
if ($horasTrabajadas > $horasRegulares) {
    $horasExtras = $horasTrabajadas - $horasRegulares;
    if ($horasExtras > $limiteHorasExtras) {
        $horasExtras = $limiteHorasExtras;
    }
} else {
    $horasExtras = 0;
}


$tarifaPorHora = 4.50;
$salarioRegulares = $horasRegulares * $tarifaPorHora;
$salarioExtras = $horasExtras * $tarifaPorHora; 

$salarioTotal = $salarioRegulares + $salarioExtras;

// Mostrar resultados
echo "Horas trabajadas: " . $horasTrabajadas . " horas<br>";
echo "Horas regulares: " . $horasRegulares . " horas<br>";
echo "Horas extras: " . $horasExtras . " horas<br>";
echo "Salario por horas regulares: $" . $salarioRegulares . "<br>";
echo "Salario por horas extras: $" . $salarioExtras . "<br>";
echo "Salario total: $" . $salarioTotal;
?>

if(buttonsalida = 8 )