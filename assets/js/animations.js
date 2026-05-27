document.addEventListener('DOMContentLoaded', () => {
    // Configuramos el observador
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15 // El 15% del elemento debe ser visible para disparar la animación
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Añadimos la clase 'is-visible' cuando entra en el viewport
                entry.target.classList.add('is-visible');
                // Dejamos de observar una vez que ya se animó
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Seleccionamos todos los elementos con clases de revelación
    const elementsToReveal = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale, .reveal-fade');
    
    // Y los empezamos a observar
    elementsToReveal.forEach(el => observer.observe(el));
});
