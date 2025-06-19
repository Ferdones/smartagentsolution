<?php
// Pornim sesiunea dacă nu e deja pornită
if (session_status() == PHP_SESSION_NONE) session_start();

// Conectarea la baza de date
$host = 'localhost';
$dbname = 'online_store';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexiune eșuată: ' . $e->getMessage();
    exit;
}

// Verificăm dacă a fost trimis un ID valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produsul nu a fost specificat corect.";
    exit;
}

$product_id = $_GET['id'];

// Preluăm produsul din baza de date
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Dacă produsul nu a fost găsit
if (!$product) {
    echo "Produsul nu a fost găsit.";
    exit;
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
                <li><a href="cart.php">Coș</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profil</a></li> <!-- Link către profilul utilizatorului -->
                    <li><a href="logout.php">Deconectare</a></li> <!-- Buton de deconectare -->
                <?php endif; ?>
            </ul>
        </nav>
    </header>
        
<main>
    <div class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
        <p class="price">Preț: 199.00 MDL</p>
        <a href="products.php?add_to_cart=<?php echo $product['id']; ?>" class="add-to-cart">Adaugă în coș</a>
    </div>
</main>

<?php include 'footer.php'; ?>
                </body>