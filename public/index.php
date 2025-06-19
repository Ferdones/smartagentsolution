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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazin Online - Pagina Principală</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Courier+New&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="products.php">Produse</a></li>
                <li><a href="cart.php">Coș</a></li>
                <li><a href="despre.php">Despre noi</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profil</a></li>
                    <li><a href="logout.php">Deconectare</a></li>
                <?php else: ?>
                    <li><a href="login.php">Autentificare</a></li>
                    <li><a href="register.php">Înregistrare</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="hero">
<svg class="hero-img" width="90" height="90" viewBox="0 0 24 24" fill="#00ff00"><path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm-9.83-2l.94-2h7.72l.94 2h2.24l-1.1-2.32c-.16-.34-.5-.68-.9-.68h-9.45l-.94-2h11.39c.41 0 .75-.34.75-.75s-.34-.75-.75-.75h-12.03l-.94-2h13.97c.41 0 .75-.34.75-.75s-.34-.75-.75-.75h-14.61l-.94-2h16.55c.41 0 .75-.34.75-.75s-.34-.75-.75-.75h-17.19c-.41 0-.75.34-.75.75s.34.75.75.75h.94l3.6 7.59-1.35 2.41c-.16.28-.25.61-.25.95 0 1.1.9 2 2 2h12c.41 0 .75-.34.75-.75s-.34-.75-.75-.75h-12z"/></svg>            <h1>Bine ai venit la Magazinul nostru Online!</h1>
            <p>Descoperă cele mai noi și populare produse digitale, la un click distanță.</p>
            <a href="products.php" class="checkout-button">Vezi toate produsele</a>
        </div>
    </header>

    <main>
        <section class="avantaje">
            <h2>De ce să alegi magazinul nostru?</h2>
            <div class="avantaje-list">
                <div class="avantaj">
                    <img src="images/fast.png" alt="Livrare rapidă" width="60">
                    <h3>Livrare rapidă</h3>
                    <p>Primești produsele digitale instant, direct pe email.</p>
                </div>
                <div class="avantaj">
                    <img src="images/secure.png" alt="Plăți sigure" width="60">
                    <h3>Plăți sigure</h3>
                    <p>Toate tranzacțiile sunt criptate și 100% sigure.</p>
                </div>
                <div class="avantaj">
                    <img src="images/support.png" alt="Suport 24/7" width="60">
                    <h3>Suport 24/7</h3>
                    <p>Echipa noastră te ajută oricând ai nevoie.</p>
                </div>
            </div>
        </section>

        <section class="produse">
            <h2>Produse Populare</h2>
            <div class="product-list">
                <?php foreach ($produse as $produs): ?>
                    <div class="product-card" style="position:relative;">
                        <?php if (!empty($produs['popular'])): ?>
                            <span class="badge-popular">Popular</span>
                        <?php endif; ?>
                        <img src="images/<?php echo $produs['image']; ?>" alt="<?php echo htmlspecialchars($produs['name']); ?>">
                        <h3><?php echo htmlspecialchars($produs['name']); ?></h3>
                        <div class="product-rating">★★★★☆</div>
                        <p><?php echo htmlspecialchars($produs['description']); ?></p>
                        <p><strong>199.00 MDL</strong></p>
                        <a href="product_details.php?id=<?php echo $produs['id']; ?>">Vezi detalii</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align:center; margin-top:2rem;">
                <a href="products.php" class="checkout-button">Vezi toate produsele</a>
            </div>
        </section>

        <section class="testimoniale">
            <h2>Ce spun clienții noștri</h2>
            <div class="testimoniale-list">
                <div class="testimonial">
                    <p>"Super rapid și simplu! Recomand cu încredere."</p>
                    <span>- Andrei P.</span>
                </div>
                <div class="testimonial">
                    <p>"Produse digitale de calitate, suport excelent."</p>
                    <span>- Maria L.</span>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-cols">
            <div>
                <h4>Contact</h4>
                <p>Email: smartagentsolution2025@gmail.com</p>
                <p>Telefon: </p>
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
            </div>
        </div>
        <p style="margin-top:20px;">&copy; 2025 Magazin Online. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>