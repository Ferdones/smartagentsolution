<?php
session_start();

// Verificăm dacă utilizatorul este autentificat și are rolul de admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

// Adăugăm un nou produs
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = '../uploads/' . basename($image);

    // Mutăm fișierul încărcat în directorul corespunzător
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->execute();
}

// Ștergem un produs
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    header('Location: admin.php'); // Redirecționăm pentru a actualiza lista de produse
    exit;
}

// Obținem lista de produse
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

// Obținem lista de comenzi
$stmt_orders = $pdo->query("SELECT * FROM orders");
$orders = $stmt_orders->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panou Administrativ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <h1>Panou Administrativ</h1>

        <!-- Formular pentru adăugarea unui produs -->
        <h2>Adaugă Produs</h2>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <label for="name">Nume produs:</label>
            <input type="text" name="name" id="name" required>

            <label for="description">Descriere produs:</label>
            <textarea name="description" id="description" required></textarea>

            <label for="price">Preț:</label>
            <input type="number" name="price" id="price" required>

            <label for="image">Imagine:</label>
            <input type="file" name="image" id="image" required>

            <button type="submit" name="add_product">Adaugă Produs</button>
        </form>

        <!-- Listă produse -->
        <h2>Produse Disponibile</h2>
        <table>
            <thead>
                <tr>
                    <th>Nume</th>
                    <th>Descriere</th>
                    <th>Preț</th>
                    <th>Imagine</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['price']; ?> lei</td>
                        <td><img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                        <td><a href="admin.php?delete_product=<?php echo $product['id']; ?>">Șterge</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Listă comenzi -->
        <h2>Comenzi Plasate</h2>
        <table>
            <thead>
                <tr>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Adresă</th>
                    <th>Total</th>
                    <th>Data Comenzii</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['name']; ?></td>
                        <td><?php echo $order['email']; ?></td>
                        <td><?php echo $order['address']; ?></td>
                        <td><?php echo $order['total_price']; ?> lei</td>
                        <td><?php echo $order['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
