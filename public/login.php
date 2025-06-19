<?php
session_start();
require '../includes/db.php';

// Verificăm dacă utilizatorul este deja autentificat
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Procesăm formularul de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Email sau parolă incorecte.';
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profil</a></li> <!-- Link către profilul utilizatorului -->
                    <li><a href="logout.php">Deconectare</a></li> <!-- Buton de deconectare -->
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Login</h1>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Parolă:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Autentificare</button>
        </form>

        <p>Nu ai cont? <a href="register.php">Înregistrează-te aici</a></p> <!-- Link pentru înregistrare -->
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
