<?php
session_start();
require '../includes/db.php';

// Verificăm dacă există produse în coș
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Coșul tău este gol. Te rugăm să adaugi produse în coș pentru a finaliza comanda.</p>";
    exit;
}

// Calculăm totalul
$total = 0;
$cart_products = [];

foreach ($_SESSION['cart'] as $product_id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch();
    
    if ($product) {
        $cart_products[] = $product;
        $total += $product['price']; // Acum avem detaliile produsului și putem aduna prețurile
    }
}


// Procesăm formularul de comandă
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preluăm datele din formular
    $user_name = $_POST['user_name'];   
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Salvăm comanda în baza de date
    $stmt = $pdo->prepare("INSERT INTO orders (user_name, email, address, total_price) VALUES (:user_name, :email, :address, :total_price)");
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':total_price', $total);
    $stmt->execute();

    // Ștergem produsele din coș
    unset($_SESSION['cart']);

    // Redirecționăm utilizatorul către pagina de confirmare
    header('Location: order_confirmation.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizează Comanda</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="cart.php">Coș</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profil</a></li> <!-- Link către profilul utilizatorului -->
                    <li><a href="logout.php">Deconectare</a></li> <!-- Buton de deconectare -->
                <?php endif; ?>
            </ul>
        </nav>
    </header>


    <main>
        <h1>Finalizează Comanda</h1>

        <p><strong>Total comanda:</strong> <?php echo $total; ?> lei</p>

        <form action="checkout.php" method="POST">
            <label for="user_name">Numele tău:</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="address">Adresă:</label>
            <textarea name="address" id="address" required></textarea>

            <button type="submit">Trimite Comanda</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
