<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor tarefas</title>
    <link rel="stylesheet" href="estilos/styleheader.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css" integrity="..." crossorigin="anonymous" />
</head>
<body>
<header>
    <nav class="custom-navbar">
        <div class="custom-logo">
            <h3><a href="index.php">Home</a></h3>
        </div>
        <ul class="custom-nav-link">
       
             <?php
            if(isset($_SESSION["user_id"])){
                echo "<li> <a href='criartarefa.php'>Criar tarefa</a></li>";
                echo "</li>";
            }
            ?>
            <?php
            if(isset($_SESSION["user_id"])){
                echo "<li> <a href='minhastarefas.php'>Minhas tarefas</a></li>";
                echo "</li>";
            }
            ?>
            
        
                <?php
                if(isset($_SESSION["user_id"])){
                }else{
                    echo "<li> <a href='Login.php'><i class='fa-solid fa-right-to-bracket'></i> Login/Resgistro</a></li>";
                    // echo "<li> <a href='signin.php'>Registar</a> </li>";
                }
                // verifica se o utilizador está logado
                if (isset($_SESSION['user_id'])) {

                    include_once "database.php";
                    // recebe o id do uTIzador
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT name FROM user WHERE id = $user_id";
                    $result = $mysqli->query($query);

                
                    if ($result) {
                        $user = $result->fetch_assoc();
                        $username = $user['name'];
                        echo "<li class='custom-dropdown'>";
                        echo "<a class='dropbtn'>Olá, $username <i class='fa-light fa-angle-down'></i></a>";
                        echo "<div class='custom-dropdown-content'>";
                        echo "<a href='profile.php'><i class='fa-solid fa-user-pen'></i> Perfil</a>";
                        echo "<a href='logout.php'><i class='fa-solid fa-right-from-bracket'></i> Sair</a>";
                        echo "</div>";
                        echo "</li>";
                    } else {
                        echo "<li> <a href='Login.php'>Login</a> </li>";
                    
                    }
                }
                ?>
            </li>
        </ul>
    </nav>
</header>
</body>
</html>

