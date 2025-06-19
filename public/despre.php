<?php
session_start();
require '../includes/db.php';

$sql = "SELECT * FROM produse";
$stmt = $pdo->query($sql);
$produse = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Despre noi - Magazin Online</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="products.php">Produse</a></li>
                <li><a href="despre.php">Despre noi</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="hero">
            <h1>Despre noi</h1>
            <p>Suntem pasionați de tehnologie și digital, iar misiunea noastră este să-ți oferim cele mai bune produse digitale, rapid și sigur.</p>
        </div>
    </header>
    <main>
        <section class="avantaje">
            <h2>Cine suntem?</h2>
            <div style="max-width:700px;margin:0 auto;text-align:center;">
                <p>
                    Magazinul nostru online a fost fondat în 2024 din dorința de a aduce mai aproape de tine cele mai noi și utile produse digitale. 
                    Suntem o echipă tânără, cu experiență în IT, e-commerce și suport clienți, mereu gata să te ajutăm.
                </p>
                <p>
                    Ne mândrim cu livrarea instant, plăți sigure și suport 24/7. Fiecare client contează pentru noi!
                </p>
            </div>
        </section>
        <section class="avantaje">
            <h2>Valorile noastre</h2>
            <div class="avantaje-list">
                <div class="avantaj">
                    <img src="images/fast.png" alt="Rapiditate" width="60">
                    <h3>Rapiditate</h3>
                    <p>Livrăm produsele tale digitale în câteva secunde, fără așteptare.</p>
                </div>
                <div class="avantaj">
                    <img src="images/secure.png" alt="Siguranță" width="60">
                    <h3>Siguranță</h3>
                    <p>Plăți criptate și datele tale în siguranță, mereu.</p>
                </div>
                <div class="avantaj">
                    <img src="images/support.png" alt="Suport" width="60">
                    <h3>Suport</h3>
                    <p>Suntem aici pentru tine, oricând ai nevoie de ajutor.</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>