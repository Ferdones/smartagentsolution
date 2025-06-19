<?php
session_start();
require '../includes/db.php';

// Verificăm dacă există produse în coș
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    // Preluăm detaliile produselor din coș
    $cart_products = [];
    foreach ($_SESSION['cart'] as $product_id) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        $cart_products[] = $stmt->fetch();
    }
}

// Eliminarea produsului din coș
if (isset($_GET['remove_from_cart'])) {
    $product_id_to_remove = $_GET['remove_from_cart'];
    // Căutăm și eliminăm produsul din coș
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id_to_remove) {
        return $item != $product_id_to_remove;
    });
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindexăm array-ul
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coșul Meu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="products.php">Produse</a></li>
                <li><a href="cart.php">Coș</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Coșul meu</h1>

        <?php if (isset($cart_empty) && $cart_empty): ?>
            <p>Coșul tău este gol.</p>
        <?php else: ?>
            <div class="cart-items">
                <?php
                $total = 0; // Variabilă pentru totalul coșului
                foreach ($cart_products as $product):
                    $total += $product['price']; // Adunăm prețul fiecărui produs
                ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="cart-item-details">
                            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                            <p>Preț: <?php echo number_format($product['price'], 2); ?> RON</p>
                        </div>
                        <a href="cart.php?remove_from_cart=<?php echo $product['id']; ?>" class="remove-item">Elimină</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <p><strong>Total:</strong> <?php echo number_format($total, 2); ?> RON</p>
                <a href="checkout.php" class="checkout-button">Finalizați comanda</a>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
