<script>
// Fungsi untuk mengambil data produk dari database
async function ambilProdukDariDatabase(kataKunci = '') {
    try {
        const response = await fetch(`api.php?action=getProducts&search=${encodeURIComponent(kataKunci)}`);
        if (!response.ok) {
            throw new Error('Gagal mengambil data');
        }
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        return [];
    }
}

// Fungsi menu hamburger
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");
hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});

// Fungsi pencarian
const searchInput = document.getElementById("searchInput");
const searchQuery = document.getElementById("searchQuery");
const productsGrid = document.getElementById("productsGrid");

async function tampilkanProduk(produk) {
    productsGrid.innerHTML = "";

    if (produk.length === 0) {
        productsGrid.innerHTML = "<p>Tidak ada produk yang ditemukan.</p>";
        return;
    }

    produk.forEach((produk) => {
        const productCard = document.createElement("div");
        productCard.className = "product-card";

        productCard.innerHTML = `
        <img src="${produk.image_url}" alt="${produk.title}" class="product-image">
        <div class="product-info">
          <h3 class="product-title">${produk.title}</h3>
          <p class="product-brand">${produk.brand}</p>
          <p class="product-year">${produk.year}</p>
          <div class="product-price">
            <span class="current-price">Rp${parseInt(produk.price).toLocaleString("id-ID")}</span>
            ${produk.original_price ? `<span class="original-price">Rp${parseInt(produk.original_price).toLocaleString("id-ID")}</span>` : ""}
            ${produk.discount ? `<span class="discount">${produk.discount}%</span>` : ""}
          </div>
        </div>
      `;

        productsGrid.appendChild(productCard);
    });
}

async function cariProduk(query) {
    const kataKunci = query.toLowerCase();
    searchQuery.textContent = kataKunci;

    const produk = await ambilProdukDariDatabase(kataKunci);
    tampilkanProduk(produk);
}

// Tampilkan semua produk saat pertama kali load
window.addEventListener('DOMContentLoaded', async () => {
    const produk = await ambilProdukDariDatabase();
    tampilkanProduk(produk);
});

// Pencarian saat tombol Enter ditekan
searchInput.addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        cariProduk(this.value);
    }
});
</script>