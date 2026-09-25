<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Ayam Geprek Modern</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-pos {
            background: linear-gradient(135deg, #ff4d4d, #ff1a1a);
            color: white;
            padding: 15px 25px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .category-badge, .btn-hover-nimbul, .card-menu {
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .category-badge {
            cursor: pointer;
            border: 1.5px solid #ff4d4d;
            color: #ff4d4d;
            background-color: white;
            display: inline-block;
        }
        .category-badge:hover, .btn-hover-nimbul:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 18px rgba(255, 77, 77, 0.25) !important;
        }
        .category-badge.active {
            background-color: #ff4d4d;
            color: white;
            box-shadow: 0 4px 10px rgba(255, 77, 77, 0.3);
        }
        .card-menu {
            border: none;
            border-radius: 16px;
        }
        .card-menu:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important;
        }
        .cart-section {
            background-color: white;
            border-radius: 20px;
            min-height: 85vh;
        }
        .btn-custom-danger {
            background-color: #ff4d4d;
            color: white;
            border: none;
        }
        .btn-custom-danger:hover {
            background-color: #e63939;
            color: white;
        }
        @media print {
            body * { visibility: hidden; }
            #areaStruk, #areaStruk * { visibility: visible; }
            #areaStruk {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
            }
            .btn-print-hide { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- HEADER / TOPBAR -->
    <div class="header-pos d-flex justify-content-between align-items-center shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-drumstick-bite me-2"></i>Geprek Ara Cantik😋</h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white text-danger fs-6 px-3 py-2 rounded-pill shadow-sm">
                <i class="fa-regular fa-calendar-days me-1"></i> <span id="headerDateText"><?php echo date('l, d F Y'); ?></span>
            </span>
            <button class="btn btn-light text-danger rounded-pill fw-bold btn-sm px-3 ms-1 btn-hover-nimbul" data-bs-toggle="modal" data-bs-target="#modalRiwayat">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Penjualan
            </button>
            <a href="<?php echo route('dashboard'); ?>" class="btn btn-light text-danger rounded-pill fw-bold btn-sm px-3 ms-1 btn-hover-nimbul">
                <i class="fa-solid fa-chart-line me-1"></i> Grafik Penjualan
            </a>
            <a href="<?php echo route('login'); ?>" class="btn btn-outline-light rounded-pill btn-sm px-3 ms-1 btn-hover-nimbul" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container-fluid mt-4 px-4">
        <div class="row g-4">
            
            <!-- BAGIAN KIRI: DAFTAR MENU & KATALOG -->
            <div class="col-lg-8">
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-4">
                        <div class="input-group search-box shadow-sm rounded-pill overflow-hidden bg-white">
                            <span class="input-group-text bg-white border-0 ps-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-0 shadow-none" placeholder="Cari ayam, teh...">
                        </div>
                    </div>
                    <div class="col-md-5 d-flex gap-2 justify-content-center overflow-auto py-1">
                        <span class="badge category-badge active px-3 py-2 rounded-pill fw-semibold" onclick="filterCategory('Semua', this)">Semua</span>
                        <span class="badge category-badge px-3 py-2 rounded-pill fw-semibold" onclick="filterCategory('Makanan', this)">Makanan</span>
                        <span class="badge category-badge px-3 py-2 rounded-pill fw-semibold" onclick="filterCategory('Minuman', this)">Minuman</span>
                        <span class="badge category-badge px-3 py-2 rounded-pill fw-semibold" onclick="filterCategory('Cemilan', this)">Cemilan</span>
                    </div>
                    <div class="col-md-3 text-end">
                        <button class="btn btn-custom-danger rounded-pill fw-bold btn-hover-nimbul px-3 py-2 w-100" data-bs-toggle="modal" data-bs-target="#modalTambahMenu" onclick="openAddMenuModal()">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Menu
                        </button>
                    </div>
                </div>

                <!-- Katalog Produk (Dirender Dinamis) -->
                <div class="row g-3" id="menuContainer">
                    <!-- Item menu akan dimuat otomatis via JavaScript & localStorage -->
                </div>
            </div>

            <!-- BAGIAN KANAN: KERANJANG -->
            <div class="col-lg-4">
                <div class="cart-section p-4 shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <h5 class="fw-bold mb-0"><i class="fa-solid fa-cart-shopping text-danger me-2"></i>Pesanan Baru</h5>
                            <button class="btn btn-sm btn-outline-danger rounded-pill btn-hover-nimbul" onclick="resetCart()"><i class="fa-solid fa-trash me-1"></i>Reset</button>
                        </div>
                        <div class="cart-items mb-3" id="cartContainer" style="max-height: 300px; overflow-y: auto;"></div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Total:</h5>
                            <h4 class="fw-bold text-danger mb-0" id="cartTotal">Rp 0</h4>
                        </div>

                        <label class="form-label small fw-semibold text-muted">METODE PEMBAYARAN</label>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="payment" id="cash" checked value="Cash" onchange="updatePaymentMethod()">
                                <label class="btn btn-outline-danger w-100 rounded-3 py-2 small fw-bold btn-hover-nimbul" for="cash"><i class="fa-solid fa-money-bill me-1"></i> Cash</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="payment" id="qris" value="QRIS" onchange="updatePaymentMethod()">
                                <label class="btn btn-outline-danger w-100 rounded-3 py-2 small fw-bold btn-hover-nimbul" for="qris"><i class="fa-solid fa-qrcode me-1"></i> QRIS</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">UANG DITERIMA (RP)</label>
                            <input type="number" id="cashAmount" class="form-control rounded-3" placeholder="Masukkan jumlah uang..." oninput="calculateChange()">
                            <small class="text-success fw-bold mt-1 d-block" id="changeText">Kembalian: Rp 0</small>
                        </div>

                        <button class="btn btn-custom-danger w-100 rounded-pill py-2.5 fw-bold shadow-sm btn-hover-nimbul" data-bs-toggle="modal" data-bs-target="#modalStruk" onclick="prepareReceipt()">
                            <i class="fa-solid fa-print me-2"></i>Simpan & Cetak Pesanan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL TAMBAH / EDIT MENU -->
    <div class="modal fade" id="modalTambahMenu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="fw-bold text-danger mb-0" id="modalMenuTitle"><i class="fa-solid fa-utensils me-2"></i>Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahMenu" onsubmit="handleSaveMenu(event)">
                        <input type="hidden" id="editMenuIndex" value="">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Menu</label>
                            <input type="text" id="newMenuName" class="form-control rounded-3" placeholder="Contoh: Ayam Geprek Mozzarella" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kategori</label>
                            <select id="newMenuCategory" class="form-select rounded-3" required>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Cemilan">Cemilan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Harga (Rp)</label>
                            <input type="number" id="newMenuPrice" class="form-control rounded-3" placeholder="18000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Foto Menu (Opsional)</label>
                            <input type="file" id="newMenuImage" class="form-control rounded-3" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-custom-danger w-100 rounded-pill py-2 fw-bold btn-hover-nimbul mt-2">
                            Simpan Menu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL STRUK -->
    <div class="modal fade" id="modalStruk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content rounded-4 p-3 border-0 shadow-lg" id="areaStruk">
                <div class="text-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold mb-0 text-danger">GEPREK KASIR POS</h5>
                    <small class="text-muted d-block">Jl. Raya Utama No. 12, Padang</small>
                    <small class="text-muted" id="receiptDate"></small>
                </div>
                <div id="strukItems" class="small mb-2"></div>
                <div class="border-top pt-2 small">
                    <div class="d-flex justify-content-between fw-bold fs-6">
                        <span>Total</span>
                        <span id="receiptTotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted">
                        <span>Metode:</span>
                        <span id="receiptPayment">Cash</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted">
                        <span>Bayar:</span>
                        <span id="receiptCash">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted fw-bold text-success">
                        <span>Kembali:</span>
                        <span id="receiptChange">Rp 0</span>
                    </div>
                </div>
                <div class="text-center border-top mt-3 pt-2">
                    <small class="fw-bold text-muted">Terima Kasih Atas Kunjungannya! 🙏</small>
                </div>
                <button class="btn btn-danger w-100 mt-3 rounded-pill btn-print-hide btn-hover-nimbul" onclick="window.print()">
                    <i class="fa-solid fa-print me-1"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL RIWAYAT PENJUALAN -->
    <div class="modal fade" id="modalRiwayat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="fw-bold text-danger mb-0"><i class="fa-solid fa-receipt me-2"></i>Riwayat Seluruh Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>No. Nota</th>
                                    <th>Tanggal & Jam</th>
                                    <th>Pesanan</th>
                                    <th>Metode</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let cart = [];

        // Default menu awal jika localStorage masih kosong
        const defaultMenus = [
            { name: "Ayam Geprek Level 3", category: "Makanan", price: 15000, image: "https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=300" },
            { name: "Es Teh Manis Jumbo", category: "Minuman", price: 5000, image: "https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300" },
            { name: "Kentang Goreng Keju", category: "Cemilan", price: 12000, image: "https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?w=300" }
        ];

        document.addEventListener("DOMContentLoaded", function () {
            let menus = JSON.parse(localStorage.getItem('pos_menus'));
            if (!menus || menus.length === 0) {
                localStorage.setItem('pos_menus', JSON.stringify(defaultMenus));
            }
            loadCatalog();
            renderCart();
            loadHistoryTable();
        });

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }

        // Muat Katalog Menu dari LocalStorage
        function loadCatalog() {
            const container = document.getElementById('menuContainer');
            let menus = JSON.parse(localStorage.getItem('pos_menus')) || defaultMenus;
            container.innerHTML = '';

            menus.forEach((menu, index) => {
                container.innerHTML += `
                    <div class="col-md-4 col-sm-6 menu-item" data-category="${menu.category}" data-name="${menu.name}">
                        <div class="card card-menu shadow-sm p-3 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="text-center mb-2 position-relative">
                                    <img src="${menu.image}" class="img-fluid rounded-3" style="height: 120px; width: 100%; object-fit: cover;" alt="${menu.name}">
                                    <!-- Tombol Edit & Hapus di atas gambar -->
                                    <div class="position-absolute top-0 end-0 p-2 d-flex gap-1">
                                        <button class="btn btn-sm btn-light text-primary shadow-sm rounded-circle btn-hover-nimbul" style="width: 30px; height: 30px; padding: 0;" onclick="openEditMenuModal(${index})" title="Edit Menu"><i class="fa-solid fa-pen fa-xs"></i></button>
                                        <button class="btn btn-sm btn-light text-danger shadow-sm rounded-circle btn-hover-nimbul" style="width: 30px; height: 30px; padding: 0;" onclick="deleteMenu(${index})" title="Hapus Menu"><i class="fa-solid fa-trash fa-xs"></i></button>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-1">${menu.name}</h6>
                                <p class="text-muted small mb-2">${menu.category}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fw-bold text-danger">${formatRupiah(menu.price)}</span>
                                <button class="btn btn-custom-danger btn-sm rounded-circle btn-hover-nimbul" onclick="addToCart('${menu.name}', ${menu.price})"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // Buka Modal untuk Tambah Menu Baru
        function openAddMenuModal() {
            document.getElementById('modalMenuTitle').innerHTML = '<i class="fa-solid fa-utensils me-2"></i>Tambah Menu Baru';
            document.getElementById('formTambahMenu').reset();
            document.getElementById('editMenuIndex').value = '';
        }

        // Buka Modal untuk Edit Menu
        function openEditMenuModal(index) {
            let menus = JSON.parse(localStorage.getItem('pos_menus')) || defaultMenus;
            let menu = menus[index];

            document.getElementById('modalMenuTitle').innerHTML = '<i class="fa-solid fa-pen-to-square me-2"></i>Edit Menu';
            document.getElementById('editMenuIndex').value = index;
            document.getElementById('newMenuName').value = menu.name;
            document.getElementById('newMenuCategory').value = menu.category;
            document.getElementById('newMenuPrice').value = menu.price;
            document.getElementById('newMenuImage').value = '';

            let modal = new bootstrap.Modal(document.getElementById('modalTambahMenu'));
            modal.show();
        }

        // Simpan Menu (Bisa untuk Tambah Baru atau Update Edit)
        function handleSaveMenu(e) {
            e.preventDefault();
            const index = document.getElementById('editMenuIndex').value;
            const name = document.getElementById('newMenuName').value;
            const category = document.getElementById('newMenuCategory').value;
            const price = parseFloat(document.getElementById('newMenuPrice').value);
            const fileInput = document.getElementById('newMenuImage');

            let menus = JSON.parse(localStorage.getItem('pos_menus')) || defaultMenus;
            let defaultImg = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300';

            const saveToStorage = (imgUrl) => {
                if (index === '') {
                    // Tambah menu baru
                    menus.push({ name, category, price, image: imgUrl });
                } else {
                    // Update menu yang diedit (jika tidak upload foto baru, pakai foto lama)
                    let finalImg = imgUrl || menus[index].image;
                    menus[index] = { name, category, price, image: finalImg };
                }

                localStorage.setItem('pos_menus', JSON.stringify(menus));
                loadCatalog();

                bootstrap.Modal.getInstance(document.getElementById('modalTambahMenu')).hide();
                document.getElementById('formTambahMenu').reset();
            };

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) { saveToStorage(e.target.result); };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                saveToStorage(index !== '' ? null : defaultImg);
            }
        }

        // Hapus Menu dari Katalog
        function deleteMenu(index) {
            if (confirm('Yakin ingin menghapus menu ini dari katalog?')) {
                let menus = JSON.parse(localStorage.getItem('pos_menus')) || defaultMenus;
                menus.splice(index, 1);
                localStorage.setItem('pos_menus', JSON.stringify(menus));
                loadCatalog();
            }
        }

        // Fitur Keranjang POS
        function addToCart(name, price) {
            const existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ name, price, qty: 1 });
            }
            renderCart();
        }

        function updateQty(name, amount) {
            const item = cart.find(i => i.name === name);
            if (item) {
                item.qty += amount;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.name !== name);
                }
            }
            renderCart();
        }

        function resetCart() {
            cart = [];
            document.getElementById('cashAmount').value = '';
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cartContainer');
            container.innerHTML = '';
            if (cart.length === 0) {
                container.innerHTML = '<p class="text-muted text-center my-4">Keranjang masih kosong</p>';
                document.getElementById('cartTotal').innerText = 'Rp 0';
                calculateChange();
                return;
            }
            let total = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;
                container.innerHTML += `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold mb-0 small">${item.name}</h6>
                            <small class="text-muted">${formatRupiah(item.price)}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light border rounded-circle btn-hover-nimbul" style="width: 28px; height: 28px; padding: 0;" onclick="updateQty('${item.name}', -1)">-</button>
                            <span class="fw-bold small">${item.qty}</span>
                            <button class="btn btn-sm btn-light border rounded-circle btn-hover-nimbul" style="width: 28px; height: 28px; padding: 0;" onclick="updateQty('${item.name}', 1)">+</button>
                        </div>
                    </div>
                `;
            });
            document.getElementById('cartTotal').innerText = formatRupiah(total);
            calculateChange();
        }

        function calculateChange() {
            const total = cart.reduce((sum, i) => sum + (i.price * i.qty), 0);
            const cash = parseFloat(document.getElementById('cashAmount').value) || 0;
            const change = cash - total;
            const changeText = document.getElementById('changeText');
            if (change >= 0) {
                changeText.className = 'text-success fw-bold mt-1 d-block';
                changeText.innerText = `Kembalian: ${formatRupiah(change)}`;
            } else {
                changeText.className = 'text-danger fw-bold mt-1 d-block';
                changeText.innerText = `Kurang: ${formatRupiah(Math.abs(change))}`;
            }
        }

        function updatePaymentMethod() {
            const isQris = document.getElementById('qris').checked;
            const cashInput = document.getElementById('cashAmount');
            if (isQris) {
                const total = cart.reduce((sum, i) => sum + (i.price * i.qty), 0);
                cashInput.value = total;
                cashInput.disabled = true;
            } else {
                cashInput.disabled = false;
            }
            calculateChange();
        }

        function prepareReceipt() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }
            const strukContainer = document.getElementById('strukItems');
            strukContainer.innerHTML = '';
            let total = 0;
            let itemSummary = [];

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;
                strukContainer.innerHTML += `
                    <div class="d-flex justify-content-between mb-1">
                        <span>${item.name} x${item.qty}</span>
                        <span>${formatRupiah(itemTotal)}</span>
                    </div>
                `;
                itemSummary.push(`${item.name} (${item.qty}x)`);
            });

            const cash = parseFloat(document.getElementById('cashAmount').value) || 0;
            const change = cash - total;
            const isQris = document.getElementById('qris').checked;
            const paymentMethod = isQris ? 'QRIS' : 'Cash';

            document.getElementById('receiptTotal').innerText = formatRupiah(total);
            document.getElementById('receiptPayment').innerText = paymentMethod;
            document.getElementById('receiptCash').innerText = formatRupiah(cash);
            document.getElementById('receiptChange').innerText = formatRupiah(change > 0 ? change : 0);

            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const dateTimeFull = `${dateStr} ${timeStr}`;
            document.getElementById('receiptDate').innerText = dateTimeFull;

            let historyList = JSON.parse(localStorage.getItem('pos_history')) || [];
            let newTrxId = `#TRX-${String(historyList.length + 1).padStart(3, '0')}`;

            let newTransaction = {
                id: newTrxId,
                datetime: dateTimeFull,
                items: itemSummary.join(', '),
                method: paymentMethod,
                total: total,
                dateKey: now.toISOString().slice(0, 10),
                monthKey: now.toISOString().slice(0, 7)
            };

            historyList.unshift(newTransaction);
            localStorage.setItem('pos_history', JSON.stringify(historyList));

            loadHistoryTable();

            cart = [];
            document.getElementById('cashAmount').value = '';
            renderCart();
        }

        function loadHistoryTable() {
            const historyBody = document.getElementById('historyTableBody');
            let historyList = JSON.parse(localStorage.getItem('pos_history')) || [];
            historyBody.innerHTML = '';

            if (historyList.length === 0) {
                historyBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-3">Belum ada riwayat penjualan.</td></tr>`;
                return;
            }

            historyList.forEach(trx => {
                const badgeClass = trx.method === 'QRIS' 
                    ? 'badge bg-primary-subtle text-primary fw-bold' 
                    : 'badge bg-success-subtle text-success fw-bold';

                historyBody.innerHTML += `
                    <tr>
                        <td><span class="fw-bold">${trx.id}</span></td>
                        <td><small>${trx.datetime}</small></td>
                        <td>${trx.items}</td>
                        <td><span class="${badgeClass}">${trx.method}</span></td>
                        <td class="fw-bold text-danger">${formatRupiah(trx.total)}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger rounded-pill btn-hover-nimbul" data-bs-toggle="modal" data-bs-target="#modalStruk">
                                <i class="fa-solid fa-print me-1"></i> Cetak
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        function filterCategory(category, element) {
            document.querySelectorAll('.category-badge').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
            const items = document.querySelectorAll('.menu-item');
            items.forEach(item => {
                if (category === 'Semua' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        document.getElementById('searchInput').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.menu-item');
            items.forEach(item => {
                const name = item.dataset.name.toLowerCase();
                if (name.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>