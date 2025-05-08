<?php
    include_once 'header.php';
    ?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de tarefas</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

      .introducao  {
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93vh;
            margin: 0;
            max-width: 8000px;
            padding: 30px;
            text-align: center;
        }

        h1 {
            font-size: 56px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        h4 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .start-button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
   

    <div class="introducao">
        <div class="conteudo">
            <h3>Bem-vindo ao Gestor de Tarefas!</h3>
            <h4>Sistema para organizar suas atividades de forma eficiente.</h4>
        </div>
    </div>
</body>

</html>
