// JavaScript para Animação de Contadores
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-number[data-from]');
    const animationDuration = 2500; // 2.5 segundos para cada animação
    const observerThreshold = 0.5; // Ativar quando 50% do elemento estiver visível

    // Função para formatar número com vírgula decimal
    function formatNumber(num, decimals) {
        // Converte para string e substitui ponto por vírgula
        const formatted = num.toFixed(decimals).replace('.', ',');
        return formatted;
    }

    // Função para animar um contador
    function animateCounter(counter) {
        const from = parseFloat(counter.dataset.from);
        const to = parseFloat(counter.dataset.to);
        const decimals = parseInt(counter.dataset.decimals) || 0;
        const startTime = performance.now();

        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / animationDuration, 1);

            // Função easeOutCubic para animação suave
            const easeOutCubic = 1 - Math.pow(1 - progress, 3);
            const currentValue = from + (to - from) * easeOutCubic;

            counter.textContent = formatNumber(currentValue, decimals);

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                // Garante que o valor final seja exato
                counter.textContent = formatNumber(to, decimals);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    // Configurar Intersection Observer
    const observerOptions = {
        threshold: observerThreshold,
        rootMargin: '0px 0px -50px 0px' // Ativa um pouco antes do elemento entrar completamente
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                // Marca como animado para não repetir
                entry.target.dataset.animated = 'true';
                animateCounter(entry.target);
            }
        });
    }, observerOptions);

    // Observar todos os contadores
    counters.forEach(counter => {
        observer.observe(counter);
    });
});