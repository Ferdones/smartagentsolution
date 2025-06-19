<?php
// filepath: c:\xampp\htdocs\Practica\public\contact.php
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="products.php">Produse</a></li>
                <li><a href="cart.php">Coș</a></li>
                <li><a href="despre.php">Despre noi</a></li>
                <li><a href="termeni.php">Termeni și condiții</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="contact" style="max-width:900px;margin:40px auto;padding:32px;background:#232323;border-radius:12px;box-shadow:0 0 12px #00ff0033;">
            <h1 style="color:#00ff00;">Contact</h1>
            <p>Pentru orice întrebări sau sugestii, ne poți contacta folosind formularul de mai jos sau direct la datele de contact.</p>
            <form method="post" action="#" style="margin-top:24px;">
                <label for="nume">Nume:</label><br>
                <input type="text" id="nume" name="nume" required style="width:100%;padding:8px;margin-bottom:12px;"><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required style="width:100%;padding:8px;margin-bottom:12px;"><br>
                <label for="mesaj">Mesaj:</label><br>
                <textarea id="mesaj" name="mesaj" rows="5" required style="width:100%;padding:8px;margin-bottom:12px;"></textarea><br>
                <button type="submit" class="checkout-button">Trimite mesajul</button>
            </form>
            <div style="margin-top:32px;">
                <h3 style="color:#00ff00;">Date de contact</h3>
                <p><strong>Email:</strong> smartagentsolution2025@gmail.com</p>
                <p><strong>Telefon:</strong> 062112076</p>
                <p>
                    <strong>Facebook:</strong> <a href="#">Facebook</a><br>
                    <strong>Instagram:</strong> <a href="#">Instagram</a>
                </p>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-cols">
            <div>
                <h4>Contact</h4>
                <p>Email: smartagentsolution2025@gmail.com</p>
                <p>Telefon: 062112076</p>
            </div>
            <div>
                <h4>Urmărește-ne</h4>
                <p>
                    <a href="#">Facebook</a> |
                    <a href="#">Instagram</a>
                </p>
            </div>
            <div>
                <h4>Informații</h4>
                <p><a href="despre.php">Despre noi</a></p>
                <p><a href="termeni.php">Termeni și condiții</a></p>
                <p><a href="contact.php">Contact</a></p>
            </div>
        </div>
        <p style="margin-top:20px;">&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>