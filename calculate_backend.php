<?php
// Captura os dados enviados pelo formulário
$weight = (float) $_POST['weight'];
$time_hours = (float) $_POST['time_hours'];
$time_minutes = (float) $_POST['time_minutes'];
$price_per_kg = (float) $_POST['price_per_kg'];
$energy_cost = (float) $_POST['energy_cost'];
$power = (float) $_POST['power'];
$failure_rate = (float) $_POST['failure_rate'];
$printer_cost = (float) $_POST['printer_cost'];
$daily_usage = (float) $_POST['daily_usage'];
$printer_life = (float) $_POST['printer_life'];
$maintenance_cost = isset($_POST['maintenance_cost']) ? (float) $_POST['maintenance_cost'] : 0;
$freight_cost = isset($_POST['freight_cost']) ? (float) $_POST['freight_cost'] : 0;
$labor_margin = (float) $_POST['labor_margin'];
$profit_margin = (float) $_POST['profit_margin'];
$tax_margin = (float) $_POST['tax_margin'];

// Cálculo do tempo total de impressão em horas decimais
$time_decimal = $time_hours + ($time_minutes / 60);

// Cálculo do custo do material
$cost_material = ($weight / 1000) * $price_per_kg;

// Cálculo do custo de energia elétrica
$power_kw = $power / 1000; // Conversão de watts para kilowatts
$energy_consumption = $power_kw * $time_decimal * $energy_cost;

// Cálculo da depreciação por hora
$monthly_hours = $daily_usage * 30; // Horas de uso mensais
$total_hours_life = $monthly_hours * $printer_life; // Total de horas de vida útil
$depreciation_per_hour = $printer_cost / $total_hours_life;
$depreciation_cost=$depreciation_per_hour * $time_decimal;

// Cálculo do custo total base
$failure_multiplier = 1 + ($failure_rate / 100); // Multiplicador para taxa de falhas
$total_cost = ($cost_material + $energy_consumption + ($depreciation_per_hour * $time_decimal) + $maintenance_cost) * $failure_multiplier;



// Adicionando margem de mão de obra (MVA)
if ($labor_margin > 0 && $labor_margin < 100) {
    $cost_with_labor = $total_cost / (1 - ($labor_margin / 100));
} else {
    echo "<div class='error'><strong>Erro:</strong> A margem de mão de obra deve estar entre 0% e 100%.</div>";
    exit;
}

// Adicionando margem de lucro (MVA)
if ($profit_margin > 0 && $profit_margin < 100) {
    $price_with_profit = $cost_with_labor / (1 - ($profit_margin / 100));
} else {
    echo "<div class='error'><strong>Erro:</strong> A margem de lucro deve estar entre 0% e 100%.</div>";
    exit;
}

// Cálculo do imposto
if ($tax_margin > 0 && $tax_margin < 100) {
    $tax_value = $price_with_profit * ($tax_margin / 100);
} else {
    $tax_value = 0;
}

// Cálculo da diferença entre o total da base sem margem - custo total com margem de mão de obra
$margem=$cost_with_labor-$total_cost;

// Preço final com frete e impostos
$final_price = $price_with_profit + $tax_value + $freight_cost;

// Exibição dos resultados
echo "<div class='result'>";
echo "<h2>Resultados</h2>";
echo "Peso do material: <strong>" . round($weight, 2) . " g</strong><br>";
echo "Tempo total de impressão: <strong>" . $time_hours . " horas e " . $time_minutes . " minutos</strong><br>";
echo "Custo do material: <strong>R$ " . number_format($cost_material, 2, ',', '.') . "</strong><br>";
echo "Custo de energia: <strong>R$ " . number_format($energy_consumption, 2, ',', '.') . "</strong><br>";
echo "Depreciação por hora: <strong>R$ " . number_format($depreciation_per_hour, 2, ',', '.') . "</strong><br>";
echo "Depreciação Total: <strong>R$ " . number_format($depreciation_cost, 2, ',', '.') . "</strong><br>";
echo "Custo de manutenção: <strong>R$ " . number_format($maintenance_cost, 2, ',', '.') . "</strong><br>";
echo "Custo total base (sem margens): <strong>R$ " . number_format($total_cost, 2, ',', '.') . "</strong><br>";
echo "Margem de mão de obra: <strong>R$ " . number_format($margem, 2, ',', '.') . "</strong><br>";
echo "Custo total com margem de mão de obra: <strong>R$ " . number_format($cost_with_labor, 2, ',', '.') . "</strong><br>";
echo "Preço com margem de lucro: <strong>R$ " . number_format($price_with_profit, 2, ',', '.') . "</strong><br>";
echo "Impostos aplicados: <strong>R$ " . number_format($tax_value, 2, ',', '.') . "</strong><br>";
echo "Frete: <strong>R$ " . number_format($freight_cost, 2, ',', '.') . "</strong><br>";
echo "<strong>Preço final total: R$ " . number_format($final_price, 2, ',', '.') . "</strong>";
echo "</div>";
?>
