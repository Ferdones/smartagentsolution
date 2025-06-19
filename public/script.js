document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartCount = document.getElementById('cart-count');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); 

            // Creăm animația
            const productId = button.getAttribute('data-product-id');
            const animation = document.createElement('div');
            animation.classList.add('cart-animation');
            animation.textContent = '✓';
            document.body.appendChild(animation);

            // Poziționare și animare spre coș
            setTimeout(() => {
                animation.style.transform = 'translate(500px, -300px)';
                animation.style.opacity = 0;
            }, 10);

            // Ștergem animația după 1 secundă
            setTimeout(() => {
                animation.remove();
            }, 1000);

            // Actualizăm numărul de produse în localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(productId);
            localStorage.setItem('cart', JSON.stringify(cart));

            // Actualizăm vizual numărul de produse
            if (cartCount) {
                cartCount.textContent = `Coș: ${cart.length} produse`;
            }
        });
    });
});

// 🔹 Funcționalitatea Dark/Light Mode
document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("theme-toggle");
    if (!themeToggle) return; // Verifică dacă elementul există

    const currentTheme = localStorage.getItem("theme") || "dark";

    if (currentTheme === "light") {
        document.body.classList.add("light-mode");
        themeToggle.textContent = "☀️";
    }

    themeToggle.addEventListener("click", () => {
        document.body.classList.toggle("light-mode");
        const newTheme = document.body.classList.contains("light-mode") ? "light" : "dark";
        localStorage.setItem("theme", newTheme);
        themeToggle.textContent = newTheme === "light" ? "☀️" : "🌙";
    });
});
 