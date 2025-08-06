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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">


    <style>
    .table-container {
        overflow-x: auto;
        margin: 2rem auto;
        max-width: 1200px;
        padding: 1rem;
        background: var(--white);
        border-radius: .5rem;
        box-shadow: var(--box-shadow);
    }

    /* Bảng chính */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1.7rem;
        min-width: 700px;
        /* đảm bảo bảng không bị bóp quá nhỏ */
    }

    .user-table thead {
        background: #f1f1f1;
    }

    .user-table th,
    .user-table td {
        padding: 1.2rem 1.5rem;
        border: 1px solid #ccc;
        text-align: left;
        white-space: nowrap;
        /* giữ chữ không bị xuống dòng */
    }

    /* Nút xóa */
    .user-table td a.delete-btn {
        background: #e74c3c;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: .3rem;
        text-decoration: none;
        font-size: 1.4rem;
    }

    .user-table td a.delete-btn:hover {
        background: #c0392b;
    }

    /* --- Responsive --- */
    @media screen and (max-width: 768px) {
        .table-container {
            padding: 0.5rem;
        }

        .user-table {
            font-size: 1.4rem;
            min-width: unset;
        }

        .user-table th,
        .user-table td {
            padding: 0.8rem;
            font-size: 1.3rem;
        }

        .user-table td a.delete-btn {
            padding: 0.4rem 0.8rem;
            font-size: 1.2rem;
        }
    }

    @media screen and (max-width: 480px) {
        .user-table {
            font-size: 1.2rem;
        }

        .user-table th,
        .user-table td {
            padding: 0.5rem;
        }

        .user-table td a.delete-btn {
            padding: 0.3rem 0.6rem;
            font-size: 1.1rem;
        }
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    /* Notification container */
    #customNotification {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Toast notification */
    .toast {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 12px 20px;
        border-radius: 8px;
        color: #fff;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeInSlide 0.3s ease, fadeOutSlide 0.5s ease 2.5s forwards;
    }

    /* Background color by type */
    .toast.success {
        background-color: #22c55e;
    }

    /* green */
    .toast.error {
        background-color: #ef4444;
    }

    /* red */
    .toast.info {
        background-color: #3b82f6;
    }

    /* blue */
    .toast.warning {
        background-color: #f59e0b;
    }

    /* yellow */

    /* Animations */
    @keyframes fadeInSlide {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOutSlide {
        to {
            opacity: 0;
            transform: translateX(30px);
        }
    }
    </style>

</head>

<body class="bg-gray-50">

    <?php include 'admin_header.php'; ?>

    <!-- POS Section -->
    <div id="pos" class="section hidden max-w-[1600px] mx-auto px-6 py-8 text-[17px] leading-relaxed">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Bán hàng (POS)</h2>
            <p class="text-gray-600">Tạo đơn hàng và thanh toán</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="mb-4">
                        <input type="text" id="posProductSearch" placeholder="Tìm sản phẩm để thêm vào giỏ..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div id="posProductGrid"
                        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                        <!-- Products will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Cart and Checkout -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Giỏ hàng</h3>
                    <div id="cartItems" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        <p class="text-gray-500 text-center py-8 text-base">Giỏ hàng trống</p>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 text-base">Tạm tính:</span>
                            <span id="subtotal" class="font-medium text-base">0₫</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-semibold">Tổng cộng:</span>
                            <span id="total" class="text-xl font-bold text-blue-600">0₫</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-base font-medium text-gray-700 mb-2">Khách hàng</label>
                            <select id="posCustomer"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-base">
                                <option value="">Khách lẻ</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-base font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                            <select id="paymentMethod"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-base">
                                <option value="cash">Tiền mặt</option>
                                <option value="transfer">Chuyển khoản</option>
                            </select>
                        </div>

                        <button onclick="processOrder()" id="checkoutBtn" disabled
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 text-white py-3 rounded-lg font-medium transition-colors text-base">
                            Thanh toán
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="customNotification" class="fixed top-6 right-6 z-50 space-y-2"></div>


    <!-- js  -->
    <?php
    $products_arr = [];
    $select_products = mysqli_query($conn, "SELECT id, name, price FROM products") or die('Query failed');
    while ($row = mysqli_fetch_assoc($select_products)) {
        $products_arr[] = [
            'id' =>  $row['id'],
            'name' => $row['name'],
            'category' => 'other',
            'price' => (float)$row['price'],
            'stock' => 50, // mặc định 10 sản phẩm trong kho
            'threshold' => 3, // cảnh báo khi còn < 3
            'description' => '',
            'sold' => 0
        ];
    }
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

    function formatDate(date) {
        return new Date(date).toLocaleDateString('vi-VN');
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

        setTimeout(() => {
            notification.classList.add('opacity-0');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }



    function loadPOS() {
        loadPOSProducts();
        loadPOSCustomers();
        updateCartDisplay();
    }

    function loadPOSProducts() {
        const searchTerm = document.getElementById('posProductSearch')?.value.toLowerCase() || '';

        let filteredProducts = products.filter(product => {
            return product.stock > 0 && product.name.toLowerCase().includes(searchTerm);
        });

        const productsHtml = filteredProducts.map(product => `
                <div class="product-item border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer" data-id="${product.id}">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-800 text-sm">${product.name}</h4>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-bold">${formatCurrency(product.price)}</span>
                        <span class="text-xs text-gray-500">Còn: ${product.stock}</span>
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


    function loadPOSCustomers() {
        const customerOptions = customers.map(customer =>
            `<option value="${customer.id}">${customer.name} - ${customer.email}</option>`
        ).join('');

        document.getElementById('posCustomer').innerHTML = `
                <option value="">Khách lẻ</option>
                ${customerOptions}
            `;
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
        cart = cart.filter(item => item.id != productId);
        updateCartDisplay();
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
            cartItemsContainer.innerHTML = '<p class="text-gray-500 text-center py-8">Giỏ hàng trống</p>';
            document.getElementById('checkoutBtn').disabled = true;
        } else {
            const cartHtml = cart.map(item => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-sm">${item.name}</p>
                            <p class="text-xs text-gray-500">${formatCurrency(item.price)}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, -1)" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300">-</button>
                            <span class="text-sm font-medium w-8 text-center">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300">+</button>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 ml-2">
                                <i class="fas fa-trash text-xs"></i>
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

        const customerId = document.getElementById('posCustomer').value;
        const paymentMethod = document.getElementById('paymentMethod').value;

        const customerName = customerId ?
            customers.find(c => c.id == customerId)?.name || 'Khách lẻ' :
            'Khách lẻ';

        const order = {
            id: Date.now(),
            customerId: customerId || null,
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