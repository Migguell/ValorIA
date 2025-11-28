// TypeScript para Header Inteligente
interface HeaderState {
    lastScrollTop: number;
    scrollThreshold: number;
}

class HeaderManager {
    private header: HTMLElement | null;
    private state: HeaderState;

    constructor() {
        this.header = document.querySelector('.main-header');
        this.state = {
            lastScrollTop: 0,
            scrollThreshold: 100 // Distância mínima de rolagem para ativar
        };

        this.init();
    }

    private init(): void {
        // Estado inicial: transparente no topo
        this.updateHeaderState();

        window.addEventListener('scroll', this.handleScroll.bind(this));
    }

    private handleScroll(): void {
        const scrollTop: number = window.pageYOffset || document.documentElement.scrollTop;

        // Atualiza estado do header baseado na posição de rolagem
        this.updateHeaderState();

        // Controle de mostrar/esconder baseado na direção da rolagem
        if (scrollTop > this.state.lastScrollTop && scrollTop > this.state.scrollThreshold) {
            // Rolando para baixo - esconder header
            this.hideHeader();
        } else if (scrollTop < this.state.lastScrollTop || scrollTop <= this.state.scrollThreshold) {
            // Rolando para cima ou no topo - mostrar header
            this.showHeader(scrollTop);
        }

        this.state.lastScrollTop = scrollTop;
    }

    private hideHeader(): void {
        if (this.header) {
            this.header.classList.add('hidden');
            this.header.classList.remove('visible');
        }
    }

    private showHeader(scrollTop: number): void {
        if (this.header) {
            this.header.classList.remove('hidden');
            if (scrollTop > 50) { // Só adiciona fundo branco se não estiver no topo
                this.header.classList.add('visible');
            } else {
                this.header.classList.remove('visible');
            }
        }
    }

    private updateHeaderState(): void {
        const scrollTop: number = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop <= 50) {
            // No topo da página - header transparente
            this.resetHeader();
        }
    }

    private resetHeader(): void {
        if (this.header) {
            this.header.classList.remove('hidden');
            this.header.classList.remove('visible');
        }
    }
}

// Inicializa o header manager quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', (): void => {
    new HeaderManager();
});