<?php
session_start();

// Verificăm dacă a fost primit un ID de produs
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Inițializăm coșul dacă nu există
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Adăugăm produsul în coș (verificăm dacă nu este deja acolo)
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id;
    }

    // Returnăm numărul de produse din coș ca răspuns AJAX
    echo json_encode(count($_SESSION['cart']));
}
?>
