document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartCount = document.getElementById('cart-count');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Oprește comportamentul implicit al linkului

            // Creăm animația de adăugare în coș
            const productId = button.getAttribute('data-product-id');
            const animation = document.createElement('div');
            animation.classList.add('cart-animation');
            animation.textContent = '✓'; // Semnul că produsul a fost adăugat
            document.body.appendChild(animation);

            // Animația se va mișca spre coș
            setTimeout(() => {
                animation.style.transform = 'translate(500px, -300px)';
                animation.style.opacity = 0;
            }, 10);

            // Actualizăm numărul de produse din coș
            fetch('update_cart.php') // Acesta va fi un fișier care actualizează numărul de produse
                .then(response => response.json())
                .then(data => {
                    cartCount.textContent = `Coș: ${data.cartCount} produse`;
                });

            // Ștergem animația după 1 secundă
            setTimeout(() => {
                animation.remove();
            }, 1000);
        });
    });
});
document.getElementById("theme-toggle").addEventListener("click", function () {
    document.body.classList.toggle("dark-theme");

    // Salvează preferința utilizatorului
    localStorage.setItem("theme", document.body.classList.contains("dark-theme") ? "dark" : "light");
});

// Setează tema în funcție de preferințele salvate
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-theme");
}
