<?php
session_start(); // Pornește sesiunea

// Setările pentru baza de date
$host = 'localhost';
$dbname = 'online_store'; // Înlocuiește cu numele bazei tale de date
$username = 'root'; // Numele utilizatorului MySQL (de obicei 'root' în XAMPP)
$password = ''; // Parola (de obicei este goală în XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activăm erorile
} catch (PDOException $e) {
    echo 'Conexiune eșuată: ' . $e->getMessage(); // Dacă există o eroare la conexiune
    exit;
}

// Verificăm dacă există un produs adăugat în coș
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart']; // ID-ul produsului

    // Verificăm dacă coșul există deja în sesiune
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Inițializăm coșul dacă nu există
    }

    // Adăugăm produsul în coș
    $_SESSION['cart'][] = $product_id;

    // Redirecționăm utilizatorul înapoi la pagina de produse
    header('Location: products.php');
    exit;
}

// Preluăm informațiile despre coș
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; // Numărul de produse din coș

// Preluăm produsele din baza de date
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produse</title>
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
        <h1>Produse disponibile</h1>

        <!-- În products.php -->
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <div class="product-card">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p>Preț: 199.00 MDL</p>
                        <a href="products.php?add_to_cart=<?php echo $product['id']; ?>" class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Adaugă în coș</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Coșul de cumpărături -->
        <div id="cart-info">
            <span id="cart-count">Coș: <?php echo $cartCount; ?> produse</span>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>

    <script src="public/js/cart.js"></script> <!-- Include fișierul JavaScript -->
</body>
</html>
