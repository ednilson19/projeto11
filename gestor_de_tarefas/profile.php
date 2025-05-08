<?php
include_once 'header.php';
include 'database.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$sql = sprintf("SELECT name, email, password_hash FROM user WHERE id = %d", $_SESSION["user_id"]);
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_password"])) {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    
    if (empty($old_password)) {
        $errors[] = "Senha antiga é obrigatória";
    } elseif (!password_verify($old_password, $user['password_hash'])) {
        $errors[] = "Senha antiga incorreta";
    }
    if (empty($new_password)) {
        $errors[] = "Nova senha é obrigatória";
    } elseif (strlen($new_password) < 8) {
        $errors[] = "Nova senha deve ter pelo menos 8 caracteres";
    } elseif ($new_password !== $confirm_password) {
        $errors[] = "Nova senha e confirmação de senha não coincidem";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = sprintf(
            "UPDATE user SET password_hash = '%s' WHERE id = %d",
            $mysqli->real_escape_string($hashed_password),
            $_SESSION["user_id"]
        );
        $mysqli->query($sql);
        header("Location: profile.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_account"])) {
    $sql = sprintf("DELETE FROM user WHERE id = %d", $_SESSION["user_id"]);
    $mysqli->query($sql);
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="estilos/styleprofile.css">
</head>
<body>
    <main>
        <h1>Perfil</h1>
        <p>Nome: <?= htmlspecialchars($user["name"]) ?></p>
        <p>Email: <?= htmlspecialchars($user["email"]) ?></p><br>

        <h2>Mudar senha</h2>
        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="update_password" value="1">
            <div>
                <label for="old_password">Senha antiga:</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            <div>
                <label for="new_password">Nova senha:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div>
                <label for="confirm_password">Repita a senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div>
                <button type="submit">Atualizar senha</button>
            </div>
        </form>

        <h2>Eliminar conta</h2>
        <form id="deleteForm" method="post">
            <input type="hidden" name="delete_account" value="1">
            <div>
                <button type="button" id="deleteButton" class="apagarconta">Apagar conta</button>
            </div>
        </form>
    </main>

    <div id="deleteModal" class="modal">
        <div class="modal-content" style="width: 400px;">
            <h2>Confirmar eliminação da conta</h2>
            <p>Tem certeza de que deseja apagar sua conta? Essa ação não pode ser desfeita.</p>
            <div>
                <button id="confirmDelete" type="submit" class="deleteAccount">Apagar conta</button>
                <button id="cancelDelete" type="button" class="cancel">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("deleteModal");
        var deleteButton = document.getElementById("deleteButton");
        var cancelDelete = document.getElementById("cancelDelete");
        var confirmDelete = document.getElementById("confirmDelete");

        deleteButton.onclick = function() {
            modal.style.display = "block";
        }

        cancelDelete.onclick = function() {
            modal.style.display = "none";
        }

        confirmDelete.onclick = function() {
            document.getElementById("deleteForm").submit();
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
