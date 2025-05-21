<?php


include 'database.php';
include_once 'header.php';

// Verifica se o formulário foi enviado e se o ID da tarefa está definido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    $sql = "UPDATE tarefas SET concluida = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tarefas WHERE user_id = $user_id";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/styleminhastarefas.css">
</head>
<body>
<div class="container">
    <h1>Minhas Tarefas 
        <span class="filter-icon" onclick="toggleFilter()">
            <i class="fa fa-magnifying-glass"></i>
        </span>
    </h1>
    
    <div class="filtro" style="display:none;">
        <div class="estado-tarefa-selecionado">
            <label for="estadotarefa">Estado:</label>
            <select id="estadotarefa" onchange="filterTasks()">
                <option value="all" >Todas</option>
                <option value="pending" selected>Pendentes</option>
                <option value="completed">Concluídas</option>
            </select>
        </div>
        <div class="prioridade-tarefa-selecionado" style="margin-top:10px;">
            <label for="prioridadetarefa">Prioridade:</label>
            <select id="prioridadetarefa" onchange="filterTasks()">
                <option value="all">Todas</option>
                <option value="alta">Alta</option>
                <option value="média">Média</option>
                <option value="baixa">Baixa</option>
            </select>
        </div>   
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table id='taskTable'>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Prioridade</th>
                        <th>Data de Conclusão</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>";

        while($row = $result->fetch_assoc()) {
            $rowClass = $row["concluida"] ? "completed" : "pending";
            $priorityClass = strtolower($row["prioridade"]);

            echo "<tr class='$rowClass $priorityClass'>
                    <td>{$row['titulo']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['prioridade']}</td>
                    <td>{$row['data_conclusao']}</td>
                    <td>";
                    
            if (!$row["concluida"]) { // Se a tarefa não estiver concluída, exibe um botão para marcar como concluída
                echo "<form action='' method='POST' style='display:inline;'>
                        <input type='hidden' name='task_id' value='{$row['id']}'>
                        <input type='submit' class='concluido' value='Concluir'>
                      </form>";
            }

            echo "</td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "Não existe tarefas criadas.";
    }

    $mysqli->close();
    ?>
</div>

<script>
function toggleFilter() {
    var filtro = document.querySelector('.filtro');
    filtro.style.display = (filtro.style.display === 'none' || filtro.style.display === '') ? 'block' : 'none';
}

function filterTasks() {
    var taskStatus = document.getElementById('estadotarefa').value;
    var priority = document.getElementById('prioridadetarefa').value;
    var rows = document.querySelectorAll('#taskTable tbody tr');

    rows.forEach(row => {
        var isCompleted = row.classList.contains('completed');
        var rowPriority = row.classList.contains('alta') ? 'alta' :
                          row.classList.contains('média') ? 'média' :
                          row.classList.contains('baixa') ? 'baixa' : '';
        var showRow = true;

        if (taskStatus !== 'all' && ((taskStatus === 'pending' && isCompleted) || (taskStatus === 'completed' && !isCompleted))) {
            showRow = false;
        }
        if (priority !== 'all' && rowPriority !== priority) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    });
}
</script>
</body>
</html>