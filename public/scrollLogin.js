document.addEventListener('DOMContentLoaded', () => {
    const scrollContent = document.querySelector('.scroll-content');
    if (!scrollContent) return;

    let currentY = 0;
    let direction = 1; // 1 = descend, -1 = monte
    const speed = 0.2;

    function animate() {

        currentY += speed * direction;

        // limite du mouvement (évite de sortir du background)
        if (currentY > 300 || currentY < 0) {
            direction *= -1;
        }

        scrollContent.style.transform = `translateY(${-currentY}px)`;

        requestAnimationFrame(animate);
    }

    animate();
});