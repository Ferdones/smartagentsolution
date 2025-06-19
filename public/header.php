<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platforma de Vânzări</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="index.php">Platforma de Vânzări</a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Acasă</a></li>
                    <li><a href="products.php">Produse</a></li>
                    <li><a href="cart.php">Coș (<span id="cart-count">
                                   <li><a href="despre.php">Despre noi</a></li>
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>)</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="dropdown">
                            <a href="#" class="dropbtn">Profil</a>
                            <div class="dropdown-content">
                                <a href="profile.php">Setări Profil</a>
                                <a href="logout.php">Deconectare</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php">Autentificare</a></li>
                        <li><a href="register.php">Înregistrare</a></li>
                    <?php endif; ?>

                    <li>
                        <button id="theme-toggle">🌙</button>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
