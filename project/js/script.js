let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}

//chuyển động ảnh trang home
const slides = document.querySelectorAll('.home .slide');
const prevBtn = document.querySelector('.nav-btn.prev');
const nextBtn = document.querySelector('.nav-btn.next');
let current = 0;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove('active');
  });
  slides[index].classList.add('active');
}

// Gọi ban đầu
showSlide(current);

// Nút prev
prevBtn.addEventListener('click', () => {
  current = (current - 1 + slides.length) % slides.length;
  showSlide(current);
});

// Nút next
nextBtn.addEventListener('click', () => {
  current = (current + 1) % slides.length;
  showSlide(current);
});

// Tự động chuyển ảnh
setInterval(() => {
  current = (current + 1) % slides.length;
  showSlide(current);
}, 5000);
