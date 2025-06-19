<?php
session_start();
require '../includes/db.php';

// Obținem detaliile produsului
$product_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $product_id);
$stmt->execute();
$product = $stmt->fetch();

// Verificăm dacă produsul a fost adăugat în coș
if (isset($_POST['add_to_cart'])) {
    // Verificăm dacă coșul există, dacă nu, îl creăm
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Adăugăm doar ID-ul produsului în coș
    $_SESSION['cart'][] = $product_id;

    // Redirecționăm către pagina de coș
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Produs</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-details img {
            max-width: 140px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            border: 1px solid #00ff00;
            margin-bottom: 1.5rem;
            background: #181818;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="products.php">Produse</a></li>
                <li><a href="cart.php">Coș</a></li>
                <li><a href="login.php">Autentificare</a></li>
                <li><a href="register.php">Înregistrare</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="product-details">
            <h1><?php echo $product['name']; ?></h1>
            <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <p class="description"><?php echo $product['description']; ?></p>
            <p class="price"><strong>Preț:</strong> <?php echo $product['price']; ?> lei</p>
            <form action="product.php?id=<?php echo $product_id; ?>" method="POST">
                <button class="add-to-cart" type="submit" name="add_to_cart">Adaugă în Coș</button>
            </form>
        </div>

        <div class="product-card">
            <img src="images/<?php echo $produs['image']; ?>" alt="<?php echo htmlspecialchars($produs['name']); ?>">
            <div class="product-info">
                <h3><?php echo htmlspecialchars($produs['name']); ?></h3>
                <p><?php echo htmlspecialchars($produs['description']); ?></p>
                <p><strong><?php echo number_format($produs['price'], 2); ?> RON</strong></p>
                <a href="product_details.php?id=<?php echo $produs['id']; ?>" class="add-to-cart-btn">Adaugă în coș</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
