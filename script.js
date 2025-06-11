  // Mobile menu functionality
const menuToggle = document.getElementById('mobile-menu');
const navLinks = document.querySelector('.nav-links');

if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// MAC Plus image functionality
const screenImage = document.getElementById('macplusScreenImage');
const boxes = document.querySelectorAll('.macplus-box');

if (screenImage && boxes.length > 0) {
    const originalScreen = screenImage.src;

    boxes.forEach(box => {
        box.addEventListener('mouseenter', () => {
            const newImage = box.getAttribute('data-image');
            screenImage.src = newImage;
        });
        box.addEventListener('mouseleave', () => {
            screenImage.src = originalScreen;
        });
    });
}

//kulüp ekleme jsonu