document.addEventListener('DOMContentLoaded', () => {
    const scrollContent = document.querySelector('.scroll-content');
    if (!scrollContent) return;

    let currentY = 0;
    let targetY = 0;
    const speed = 0.12; // plus petit = plus fluide

    window.addEventListener('scroll', () => {
        targetY = window.scrollY;
    }, { passive: true });

    function animate() {
        currentY += (targetY - currentY) * speed;

        scrollContent.style.transform = `translateY(${-currentY}px)`;

        requestAnimationFrame(animate);
    }

    animate();
});
