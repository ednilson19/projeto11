<?php
include 'database.php';
include_once 'header.php';

    

if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    if (empty($task)) {
        $errors = "You must fill in the activity.";
    } else {
        $user_id = $_SESSION['user_id'];
        mysqli_query(include 'database.php', "INSERT INTO actvidade_user (user_id, task) VALUES ('$user_id', '$task')");
    }
}

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    $user_id = $_SESSION['user_id'];
    mysqli_query(include 'database.php', "DELETE FROM actvidade_user WHERE id=$id AND user_id=$user_id");
    // header('location: meuplano.php');
}

$user_id = $_SESSION['user_id'];
$tasks = mysqli_query(include 'database.php', "SELECT * FROM actvidade_user WHERE user_id=$user_id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="x-icon" href="img/man.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .task_input {
            padding: 8px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 100%;
        }

        .add_btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 20.5px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .task {
            word-wrap: break-word;
            max-width: 400px;
        }

        .delete a {
            color: #ff0000;
            text-decoration: none;
        }

        .delete a:hover {
            text-decoration: underline;
        }

        .delete_btn {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            background-color: #ff0000;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="meuplano.php">
            <input type="text" name="task" class="task_input" placeholder="Adiciona a sua atividade/exercício" required>
            <button type="submit" class="add_btn" name="submit">Add</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>atividade/exercício</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                while ($row = mysqli_fetch_array($tasks)) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td class="task"><?php echo $row['task']; ?></td>
                        <td class="delete">
                            <a href="meuplano.php?del_task=<?php echo $row['id']; ?>">
                                <button type="button" class="delete_btn">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
