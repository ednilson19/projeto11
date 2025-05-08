<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="img/man.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Calculadora de IMC</title>
  
    <style>
        body{
            background: linear-gradient(120deg, #29b941, #cdcace) no-repeat;
             height: 100vh;
        }
       h1 {
            text-align: center;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
            margin-top: 35px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .button-container button:hover {
            background-color: #0056b3;
        }
        
        #form2 {
            display: none;
        }
        
        #calculate {
            background-color: #007bff;
        }
        
        #calculate:hover {
            background-color: #0056b3;
        }
        
        #clearResult {
            background-color: #dc3545;
            margin-left: 10px;
        }
        
        #clearResult:hover {
            background-color: #bd2130;
        }
    </style>
    <?php
        include_once 'header.php';
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#calculate').click(function(){
            // Get form values
            var age = parseInt($('#age').val());
            var gender = $('input[name="gender"]:checked').val();
            var weight = parseFloat($('#weight').val());
            var height = parseInt($('#height').val());
            var activityLevel = parseFloat($('#activityLevel').val());

            // Perform calculation
            var bmr;
            if (gender === "male") {
                bmr = 66 + (13.75 * weight) + (5 * height) - (6.8 * age);
            } else {
                bmr = 655 + (9.56 * weight) + (1.85 * height) - (4.68 * age);
            }

            var dailyCalories = bmr * activityLevel;

            // Display result
            $('#result').html("Sua necessidade diária de calorias é: " + dailyCalories.toFixed(2));
        });

        $('#clearResult').click(function(){
            $('#result').html("");
        });
    });
    </script>

</head>
<body>
  
    <form id="form1">
    <h1>Calorias Diárias</h1>
        <!-- Form 1 content -->
        <div>
            <label for="age">Idade:</label>
            <input type="number" id="age" min="13" name="age" required>
        </div>
        <div class="gender-labels">
            <label for="gender">Gênero:</label>
            <label for="male">
                <input type="radio" id="male" name="gender" value="male" required>
                Masculino
            </label>
            <label for="female">
                <input type="radio" id="female" name="gender" value="female" required>
                Feminino
            </label>
        </div>
        <div>
            <label for="weight">Peso (em kg):</label>
            <input type="number" id="weight" name="weight" required>
        </div>
        <div>
            <label for="height">Altura (em cm):</label>
            <input type="number" id="height" name="height" required>
        </div>
        <div>
            <label for="activityLevel">Nível de Atividade:</label>
            <select id="activityLevel" name="activityLevel" required>
                <option value="1.2">Sedentário (pouco ou nenhum exercício)</option>
                <option value="1.375">Levemente ativo (exercício leve/esportes 1-3 dias/semana)</option>
                <option value="1.55">Moderadamente ativo (exercício moderado/esportes 3-5 dias/semana)</option>
                <option value="1.725">Muito ativo (exercício intenso/esportes 6-7 dias/semana)</option>
                <option value="1.9">Extremamente ativo (exercício muito intenso/esportes e trabalho físico ou treinamento dobrado)</option>
            </select>
        </div>
        <div class="button-container">
            <button type="button" id="calculate">Calcular</button>
            <button type="button" id="clearResult">Limpar Resultado</button>
        </div>
        <div id="result"></div>
    </form>

</body>
</html>
