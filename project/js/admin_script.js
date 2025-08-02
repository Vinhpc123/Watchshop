let navbar = document.querySelector('.header .navbar');
let accountBox = document.querySelector('.header .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   accountBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   accountBox.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   accountBox.classList.remove('active');
}

// Nếu tồn tại form chỉnh sửa thì hiện form
const editForm = document.querySelector('.edit-product-form');
if (editForm) {
   editForm.style.display = 'flex';
}

// Nút "Hủy" sẽ ẩn form và quay về trang chính
const closeBtn = document.querySelector('#close-update');
if (closeBtn) {
   closeBtn.onclick = (e) => {
      e.preventDefault();
      editForm.style.display = 'none';
      window.location.href = 'admin_products.php';
   }
}

//Ngay khi chọn ảnh mới → ảnh phía dưới sẽ cập nhật ngay
function previewImage(event) {
    const img = document.getElementById('preview');
    if (event.target.files.length > 0) {
        img.src = URL.createObjectURL(event.target.files[0]);
    }
}



