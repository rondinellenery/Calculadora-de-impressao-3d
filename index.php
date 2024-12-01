<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculadora de Custos 3D</title>
  <style>
    /* Configurações gerais */
    body {
      font-family: Arial, sans-serif;
      background: #000;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
      background: #1a1a1a;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
    }

    h1 {
      text-align: center;
      color: #fff;
      font-size: 24px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      margin-bottom: 5px;
      font-weight: bold;
      font-size: 14px;
    }

    input, button {
      padding: 10px;
      border: 1px solid #333;
      border-radius: 5px;
      background: #333;
      color: #fff;
    }

    input:focus {
      outline: none;
      border-color: #007bff;
    }

    button {
      background: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background: #0056b3;
    }

    .tooltip {
      font-size: 12px;
      color: #aaa;
      margin-top: -10px;
      margin-bottom: 5px;
    }

    .result, .error {
      padding: 15px;
      margin-top: 20px;
      border-radius: 5px;
    }

    .result {
      background: #2ecc71;
      color: #000;
    }

    .error {
      background: #e74c3c;
      color: #fff;
    }

    /* Responsividade */
    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }

      h1 {
        font-size: 20px;
      }

      label, input, button {
        font-size: 14px;
      }

      button {
        padding: 8px;
      }
    }
  </style>
  <script>
    function showDepreciationWarning() {
      const dailyUsage = document.getElementById('daily_usage').value;
      if (dailyUsage < 4) {
        alert(
          "Atenção: Usar a impressora por menos horas por dia pode aumentar significativamente o custo da impressão devido à depreciação mais elevada."
        );
      }
    }
    function redirectToInstagram() {
    window.open("https://www.instagram.com/rondi3d", "_blank");
  }
  </script>
</head>
<body>
  <div class="container">
    <h1>Calculadora de Custos de Impressão 3D</h1>
    <form method="POST" onsubmit="showDepreciationWarning()">
      <label for="weight">Peso do material (g):</label>
      <span class="tooltip">💡 Insira o peso total fornecido pelo software de fatiamento.</span>
      <input type="number" name="weight" id="weight" value="0" required>

      <label for="time_hours">Tempo de impressão (horas):</label>
      <span class="tooltip">💡 Exemplo: Para 2h 30min, coloque 2 aqui e 30 no próximo campo.</span>
      <input type="number" name="time_hours" id="time_hours" value="0" required>

      <label for="time_minutes">Tempo de impressão (minutos):</label>
      <span class="tooltip">💡 Complemento do campo anterior. Se não houver minutos, deixe 0.</span>
      <input type="number" name="time_minutes" id="time_minutes" value="0" required>

      <label for="price_per_kg">Preço do material por kg (R$):</label>
      <span class="tooltip">💡 Exemplo: O preço do filamento ou resina usado.</span>
      <input type="number" name="price_per_kg" id="price_per_kg" value="0" required>

      <label for="energy_cost">Custo da energia elétrica (R$/kWh):</label>
      <span class="tooltip">💡 Veja sua conta de luz para saber o valor exato.</span>
      <input type="number" name="energy_cost" id="energy_cost" step="0.01" required>

      <label for="power">Consumo da impressora (Watts):</label>
      <span class="tooltip">💡 Exemplo: 120W, 150W. Consulte o manual do equipamento.</span>
      <input type="number" name="power" id="power" required>

      <label for="failure_rate">Taxa de falhas (%):</label>
      <span class="tooltip">💡 Uma margem para falhas nas impressões.</span>
      <input type="number" name="failure_rate" id="failure_rate" value="0" required>

      <label for="printer_cost">Preço da impressora (R$):</label>
      <span class="tooltip">💡 Quanto você pagou pelo equipamento.</span>
      <input type="number" name="printer_cost" id="printer_cost" required>

      <label for="daily_usage">Horas de uso por dia:</label>
      <span class="tooltip">💡 Quantas horas por dia você usa a impressora.</span>
      <input type="number" name="daily_usage" id="daily_usage" value="8" required>

      <label for="printer_life">Vida útil da impressora (meses):</label>
      <span class="tooltip">💡 Geralmente entre 12 a 36 meses.</span>
      <input type="number" name="printer_life" id="printer_life" value="12" required>

      <label for="maintenance_cost">Valor de manutenção (opcional, R$):</label>
      <span class="tooltip">💡 Exemplo: Troca de peças ou ajustes técnicos.</span>
      <input type="number" name="maintenance_cost" id="maintenance_cost" value="0">

      <label for="freight_cost">Valor fixo de frete (opcional, R$):</label>
      <span class="tooltip">💡 Quanto você cobra para entregar o produto ao cliente.</span>
      <input type="number" name="freight_cost" id="freight_cost" value="0">

      <label for="labor_margin">Margem de mão de obra (%):</label>
      <span class="tooltip">💡 Uma margem para o trabalho do operador da máquina.</span>
      <input type="number" name="labor_margin" id="labor_margin" value="0" required>

      <label for="profit_margin">Margem de lucro (%):</label>
      <span class="tooltip">💡 Quanto você quer lucrar sobre o custo total.</span>
      <input type="number" name="profit_margin" id="profit_margin" value="0" required>

      <label for="tax_margin">Percentual de imposto aplicado (%):</label>
      <span class="tooltip">💡 Taxas tributárias aplicadas ao serviço.</span>
      <input type="number" name="tax_margin" id="tax_margin" value="0" required>

      <button type="submit" onclick="redirectToInstagram()">Calcular Custo</button>
    </form>
    

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include_once "calculate_backend.php";
    }
    ?>
  </div>
</body>
<script>
  // Função para salvar os valores no Local Storage
  function saveInputsToLocalStorage() {
    const inputs = document.querySelectorAll("input");
    inputs.forEach((input) => {
      localStorage.setItem(input.id, input.value);
    });
  }

  // Função para carregar os valores do Local Storage
  function loadInputsFromLocalStorage() {
    const inputs = document.querySelectorAll("input");
    inputs.forEach((input) => {
      const savedValue = localStorage.getItem(input.id);
      if (savedValue !== null) {
        input.value = savedValue;
      }
    });
  }

  // Carregar valores quando a página é carregada
  document.addEventListener("DOMContentLoaded", loadInputsFromLocalStorage);

  // Vincular ao evento de envio do formulário
  document.querySelector("form").addEventListener("submit", saveInputsToLocalStorage);
</script>

</html>
