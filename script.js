  const menuToggle = document.getElementById('mobile-menu');
  const navLinks = document.querySelector('.nav-links');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
  });
    const boxes = document.querySelectorAll('.macplus-box');
    const screenImage = document.getElementById('macplusScreenImage');
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

    