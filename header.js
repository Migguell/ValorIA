// JavaScript para Header Inteligente
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.main-header');
    let lastScrollTop = 0;
    let scrollThreshold = 100; // Distância mínima de rolagem para ativar

    // Estado inicial: transparente no topo
    updateHeaderState();

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Atualiza estado do header baseado na posição de rolagem
        updateHeaderState();

        // Controle de mostrar/esconder baseado na direção da rolagem
        if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
            // Rolando para baixo - esconder header
            header.classList.add('hidden');
            header.classList.remove('visible');
        } else if (scrollTop < lastScrollTop || scrollTop <= scrollThreshold) {
            // Rolando para cima ou no topo - mostrar header
            header.classList.remove('hidden');
            if (scrollTop > 50) { // Só adiciona fundo branco se não estiver no topo
                header.classList.add('visible');
            } else {
                header.classList.remove('visible');
            }
        }

        lastScrollTop = scrollTop;
    });

    function updateHeaderState() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop <= 50) {
            // No topo da página - header transparente
            header.classList.remove('hidden');
            header.classList.remove('visible');
        }
    }
});