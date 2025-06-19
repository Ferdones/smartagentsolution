<?php
session_start();
require '../includes/db.php';

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    header('Location: login.php');
    exit;
}

$success_message = '';

// Procesăm formularul de actualizare a profilului
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = htmlspecialchars($_POST['user_name']);
    $email = htmlspecialchars($_POST['email']);
    $avatar = $user['avatar']; // Dacă nu se încarcă un nou avatar, păstrăm vechiul

    // Dacă utilizatorul încarcă un avatar
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($_FILES['avatar']['type'], $allowed_types) && $_FILES['avatar']['size'] <= 2 * 1024 * 1024) {
            $avatarDir = 'uploads/avatars/';
            $avatarName = uniqid() . '-' . basename($_FILES['avatar']['name']);
            $avatarPath = $avatarDir . $avatarName;

            // Creăm directorul pentru avataruri, dacă nu există
            if (!is_dir($avatarDir)) {
                mkdir($avatarDir, 0777, true);
            }

            // Mutăm fișierul în directorul corespunzător
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)) {
                $avatar = $avatarPath;
            }
        } else {
            $success_message = "Fișierul încărcat nu este un format valid sau depășește 2MB.";
        }
    }

    // Actualizăm datele utilizatorului
    $stmt = $pdo->prepare("UPDATE users SET user_name = :user_name, email = :email, avatar = :avatar WHERE id = :id");
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    // Reîncărcăm datele utilizatorului după actualizare
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();

    if (empty($success_message)) {
        $success_message = "Profil actualizat cu succes!";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profilul Meu</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Acasă</a></li>
            <li><a href="products.php">Produse</a></li>
            <li><a href="cart.php">Coș</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Deconectare</a></li>
            <?php else: ?>
                <li><a href="login.php">Autentificare</a></li>
                <li><a href="register.php">Înregistrare</a></li>
            <?php endif; ?>

        </ul>
    </nav>
</header>

<main>
    <h1 style="text-align:center; color:#00ff00; margin-top: 1rem;">Profilul Meu</h1>

    <div class="avatar" style="text-align:center; margin-bottom: 20px;">
        <?php if ($user['avatar'] && file_exists($user['avatar'])): ?>
            <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" />
        <?php else: ?>
            <img src="default-avatar.png" alt="Avatar" />
        <?php endif; ?>
    </div>

    <?php if ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="profile.php" method="POST" enctype="multipart/form-data">
        <label for="user_name">Nume complet:</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required />

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />

        <label for="avatar">Schimbă avatarul:</label>
        <input type="file" name="avatar" id="avatar" accept="image/*" />

        <button type="submit">Salvează modificările</button>
    </form>
</main>

<footer>
    <p style="text-align:center; color:#00ff00; padding: 15px 0; margin-top: 40px;">&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
</footer>
</body>
</html>
