<?php
session_start();
require '../includes/db.php';

// Verificăm dacă utilizatorul este deja autentificat
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Procesăm formularul de înregistrare
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validăm dacă parolele coincid
    if ($password !== $password_confirm) {
        $error = 'Parolele nu coincid!';
    } else {
        // Criptăm parola
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Verificăm dacă email-ul există deja
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = 'Email-ul este deja utilizat!';
        } else {
            // Inserăm utilizatorul în baza de date
            $stmt = $pdo->prepare("INSERT INTO users (user_name, email, password) VALUES (:user_name, :email, :password)");
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            // După înregistrare, redirecționăm utilizatorul la pagina de login
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asigură-te că fișierul CSS este inclus -->
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
        <h1>Înregistrare</h1>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <label for="user_name">Numele complet:</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Parolă:</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirm">Confirmă Parola:</label>
            <input type="password" name="password_confirm" id="password_confirm" required>

            <button type="submit">Înregistrează-te</button>
        </form>

        <p>Ai deja un cont? <a href="login.php">Autentifică-te aici</a></p> <!-- Link către login -->
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
