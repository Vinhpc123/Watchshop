<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán hàng</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
    /* Layout */
    body {
        background-color: #f9fafb;
        font-size: 17px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 2.5rem;
        /* tăng padding trái/phải */
        display: block;
    }


    .hidden {
        display: none;
    }

    /* Typography */
    h2 {
        text-align: left;
        text-transform: uppercase;
        color: var(--black);
        font-size: 4rem;
    }

    .text-gray-600 {
        color: #4b5563;
    }

    h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    p.text-gray-600 {
        margin-bottom: 12px;
    }

    /* Grid POS */
    .grid-pos {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;

    }

    @media (max-width: 1023px) {
        .grid-pos {
            grid-template-columns: 1fr;
        }
    }

    /* Box/Card */
    .box {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        border: 1px solid #d1d5db;
        padding: 1rem 1rem;
        min-height: 450px;

    }


    /* Input */
    .input-search,
    .input-select {
        width: 100%;
        padding: 1rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1.5rem;
        outline: none;
        transition: border-color 0.2s;
        margin-bottom: 0.5rem;
    }

    .input-search:focus,
    .input-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    .input-label {
        display: block;
        font-size: 1.3rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        max-height: 470px;
        overflow-y: auto;
    }

    @media (max-width: 1279px) {
        .product-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Product Item */
    .product-item {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 1rem;
        cursor: pointer;
        transition: box-shadow 0.2s;
        background: #fff;
    }

    .product-item:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
    }

    .product-item .product-name {
        font-weight: 500;
        color: #1f2937;
        font-size: 1.3rem;
    }

    .product-item .product-price {
        color: #2563eb;
        font-weight: bold;
        font-size: 1.3rem;
    }

    .product-item .product-stock {
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* Cart */
    .cart-section {}

    .cart-items {
        margin-bottom: 1rem;
        max-height: 16rem;
        overflow-y: auto;
    }

    .cart-empty {
        color: #6b7280;
        text-align: center;
        padding: 2rem 0;
        font-size: 1.5rem;
    }

    .cart-summary {
        border-top: 1px solid #d1d5db;
        padding-top: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .summary-row.total {
        margin-bottom: 1rem;
    }

    .label {
        color: #4b5563;
        font-size: 1.3rem;
    }

    .value {
        font-weight: 500;
        font-size: 1.3rem;
    }

    .total-value {
        color: #2563eb;
        font-size: 1.3rem;
        font-weight: bold;
    }

    /* Cart Item */
    .cart-items .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1rem;
        /* tăng padding */
        background: #f9fafb;
        border-radius: 0.75rem;
        /* bo góc lớn hơn */
        margin-bottom: 1rem;
        /* tăng khoảng cách giữa các item */
        font-size: 1.2rem;
        /* tăng cỡ chữ */
        min-height: 70px;
    }

    .cart-items .item-info {
        flex: 1;
    }

    .cart-items .item-name {
        font-weight: 600;
        font-size: 1.3rem;
    }

    .cart-items .item-price {
        font-size: 1.3rem;
        color: #6b7280;
    }

    .cart-items .item-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cart-items .item-btn {
        width: 2rem;
        height: 2rem;
        background: #e5e7eb;
        border: none;
        border-radius: 0.25rem;
        font-size: 1.4rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .cart-items .item-btn:hover {
        background: #d1d5db;
    }

    .cart-items .remove-btn {
        color: #ef4444;
        background: none;
        border: none;
        margin-left: 0.5rem;
        cursor: pointer;
        font-size: 1rem;
    }

    .cart-items .remove-btn:hover {
        color: #b91c1c;
    }

    /* Button */
    .checkout-btn {
        width: 100%;
        padding: 14px;
        background: #8e44ad;
        color: white;
        border: none;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    .checkout-btn:hover:enabled {
        background: #1d4ed8;
    }

    .checkout-btn:disabled {
        background: #d1d5db;
        cursor: not-allowed;
    }

    /* Notification */
    #customNotification {
        position: fixed;
        top: 60px;
        /* Dưới header, có thể chỉnh lại cho phù hợp */
        right: 2rem;
        z-index: 9999;
        min-width: 260px;
        max-width: 350px;
        pointer-events: none;
    }

    .toast {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: #fff;
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
        font-size: 1.1rem;
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 1rem;
        border-left: 5px solid #2563eb;
        opacity: 1;
        transition: opacity 0.5s, transform 0.3s;
        transform: translateY(0);
    }

    .toast.success {
        color: #16a34a;
        border-left-color: #16a34a;
    }

    .toast.error {
        color: #dc2626;
        border-left-color: #dc2626;
    }

    .toast.info {
        color: #2563eb;
        border-left-color: #2563eb;
    }

    .toast.warning {
        color: #f59e42;
        border-left-color: #f59e42;
    }

    .toast.opacity-0 {
        opacity: 0;
        transform: translateY(-20px);
    }

    .toast i {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* img */
    .product-item img.product-img {
        display: block;
        margin: 0 auto 12px auto;
        background: #f3f4f6;
        border-radius: 12px;
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <!-- POS Section -->
    <div id="pos" class="section hidden">
        <div class="mb-6">
            <h2>Bán hàng (POS)</h2>
            <p class="text-gray-600">Tạo đơn hàng và thanh toán</p>
        </div>

        <div class="grid-pos">
            <!-- Product Selection -->
            <div class="product-selection">
                <div class="box">
                    <div class="mb-4">
                        <input type="text" id="posProductSearch" placeholder="Tìm sản phẩm để thêm vào giỏ..."
                            class="input-search">
                    </div>
                    <div id="posProductGrid" class="product-grid">
                        <!-- Products will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Cart and Checkout -->
            <div class="cart-section">
                <div class="box">
                    <h3>Giỏ hàng</h3>
                    <div id="cartItems" class="cart-items">
                        <p class="cart-empty">Giỏ hàng trống</p>
                    </div>

                    <div class="cart-summary">
                        <div class="summary-row">
                            <span class="label">Tạm tính:</span>
                            <span id="subtotal" class="value">0₫</span>
                        </div>
                        <div class="summary-row total">
                            <span class="label">Tổng cộng:</span>
                            <span id="total" class="value total-value">0₫</span>
                        </div>

                        <div class="mb-4">
                            <label class="input-label">Khách hàng</label>
                            <div class="input-select" style="background:#f3f4f6;pointer-events:none;user-select:none;">
                                Khách lẻ</div>
                        </div>

                        <div class="mb-4">
                            <label class="input-label">Phương thức thanh toán</label>
                            <select id="paymentMethod" class="input-select">
                                <option value="cash">Tiền mặt</option>
                                <option value="transfer">Chuyển khoản</option>
                            </select>
                        </div>

                        <button onclick="processOrder()" id="checkoutBtn" disabled class="checkout-btn">
                            Thanh toán
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="customNotification"></div>

    <?php
    $products_arr = [];
    $select_products = mysqli_query($conn, "SELECT id, name, price, image FROM products") or die('Query failed');
    while ($row = mysqli_fetch_assoc($select_products)) {
        $products_arr[] = [
            'id' =>  $row['id'],
            'name' => $row['name'],
            'category' => 'other',
            'price' => (float)$row['price'],
            'stock' => 50,
            'threshold' => 3,
            'description' => '',
            'sold' => 0,
            'image' => $row['image'] // không còn lỗi undefined
        ];
    }
    $users_arr = [];
    $select_users = mysqli_query($conn, "SELECT id, name, email FROM users") or die('Query failed');
    while ($row = mysqli_fetch_assoc($select_users)) {
        $users_arr[] = [
            'id' =>  $row['id'],
            'name' => $row['name'],
            'email' => $row['email']
        ];
    }
    ?>

    <script>
    // Data Storage
    let products = <?php echo json_encode($products_arr, JSON_UNESCAPED_UNICODE); ?>;
    let customers = <?php echo json_encode($users_arr, JSON_UNESCAPED_UNICODE); ?>;
    let cart = [];

    // Utility Functions
    function saveData() {
        localStorage.setItem('products', JSON.stringify(products));
        localStorage.setItem('customers', JSON.stringify(customers));
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    function showNotification(message, type = 'success') {
        const container = document.getElementById('customNotification');
        const iconMap = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            info: 'fa-info-circle',
            warning: 'fa-exclamation-triangle'
        };
        const notification = document.createElement('div');
        notification.className = `toast ${type}`;
        notification.innerHTML = `
            <i class="fas ${iconMap[type] || 'fa-info-circle'}"></i>
            <span>${message}</span>
        `;
        container.appendChild(notification);
        // Giới hạn tối đa 6 toast
        while (container.children.length > 4) {
            container.removeChild(container.firstChild);
        }

        setTimeout(() => {
            notification.classList.add('opacity-0');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    function loadPOS() {
        loadPOSProducts();
        updateCartDisplay();
    }

    function loadPOSProducts() {
        const searchTerm = document.getElementById('posProductSearch')?.value.toLowerCase() || '';
        let filteredProducts = products.filter(product => {
            return product.stock > 0 && product.name.toLowerCase().includes(searchTerm);
        });

        const productsHtml = filteredProducts.map(product => `
            <div class="product-item" data-id="${product.id}">
            <img 
                src="uploaded_img/${product.image || 'no-image.png'}" 
                alt="Đồng hồ ${product.name}" 
                width="120" height="120"
                loading="lazy"
                class="product-img"
            >
            <div>
                <h4 class="product-name">${product.name}</h4>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span class="product-price">${formatCurrency(product.price)}</span>
                <span class="product-stock">Còn: ${product.stock}</span>
            </div>
        </div>
        `).join('');
        const grid = document.getElementById('posProductGrid');
        grid.innerHTML = productsHtml;

        // Gán sự kiện click sau khi render xong
        grid.querySelectorAll('.product-item').forEach(item => {
            item.addEventListener('click', () => {
                const id = parseInt(item.getAttribute('data-id'));
                addToCart(id);
            });
        });
    }



    function addToCart(productId) {
        const product = products.find(p => p.id == productId);
        if (!product || product.stock === 0) return;

        const existingItem = cart.find(item => item.id == productId);

        if (existingItem) {
            if (existingItem.quantity < product.stock) {
                existingItem.quantity++;
            } else {
                showNotification('Không đủ hàng trong kho', 'error');
                return;
            }
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: 1,
                maxStock: product.stock
            });
        }
        updateCartDisplay();
        showNotification(`Đã thêm ${product.name} vào giỏ hàng`);
    }

    function removeFromCart(productId) {
        const item = cart.find(item => item.id == productId);
        cart = cart.filter(item => item.id != productId);
        updateCartDisplay();
        if (item) {
            showNotification(`Đã xóa ${item.name} khỏi giỏ hàng`, 'info');
        }
    }

    function updateQuantity(productId, change) {
        const item = cart.find(item => item.id == productId);
        if (!item) return;

        const newQuantity = item.quantity + change;

        if (newQuantity <= 0) {
            removeFromCart(productId);
        } else if (newQuantity <= item.maxStock) {
            item.quantity = newQuantity;
            updateCartDisplay();
        } else {
            showNotification('Không đủ hàng trong kho', 'error');
        }
    }

    function updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cartItems');

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="cart-empty">Giỏ hàng trống</p>';
            document.getElementById('checkoutBtn').disabled = true;
        } else {
            const cartHtml = cart.map(item => `
                <div class="cart-item">
                    <div class="item-info">
                        <p class="item-name">${item.name}</p>
                        <p class="item-price">${formatCurrency(item.price)}</p>
                    </div>
                    <div class="item-actions">
                        <button onclick="updateQuantity(${item.id}, -1)" class="item-btn">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)" class="item-btn">+</button>
                        <button onclick="removeFromCart(${item.id})" class="remove-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            cartItemsContainer.innerHTML = cartHtml;
            document.getElementById('checkoutBtn').disabled = false;
        }

        // Update totals
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('total').textContent = formatCurrency(subtotal);
    }

    function processOrder() {
        if (cart.length === 0) return;

        const customerId = null;
        const customerName = 'Khách lẻ';
        const paymentMethod = document.getElementById('paymentMethod').value;

        const order = {
            id: Date.now(),
            customerId: customerId,
            customerName: customerName,
            date: new Date().toISOString(),
            items: [...cart],
            total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
            paymentMethod: paymentMethod,
            status: 'completed'
        };

        // Update product stock and sold count
        cart.forEach(item => {
            const product = products.find(p => p.id === item.id);
            if (product) {
                product.stock -= item.quantity;
                product.sold = (product.sold || 0) + item.quantity;
            }
        });

        saveData();

        // Gửi order sang PHP để lưu vào CSDL
        fetch('add_order_pos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(order)
            })
            .then(response => response.text())
            .then(data => {
                console.log('Server response:', data);
            })
            .catch(error => {
                console.error('Error saving order:', error);
            });

        // Clear cart
        cart = [];
        updateCartDisplay();
        loadPOSProducts();

        showNotification('Đã tạo đơn hàng thành công!');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const posSection = document.getElementById('pos');
        posSection.classList.remove('hidden');
        loadPOS();
        document.getElementById('posProductSearch')?.addEventListener('input', loadPOSProducts);
    });
    </script>
</body>

</html>