// TypeScript para Animação de Contadores

interface CounterData {
    from: number;
    to: number;
    decimals: number;
    animated?: string;
}

interface CounterConfig {
    animationDuration: number;
    observerThreshold: number;
}

class CounterAnimationManager {
    private counters: NodeListOf<HTMLElement>;
    private config: CounterConfig;
    private observer: IntersectionObserver;

    constructor() {
        this.counters = document.querySelectorAll('.stat-number[data-from]');
        this.config = {
            animationDuration: 2500, // 2.5 segundos para cada animação
            observerThreshold: 0.5 // Ativar quando 50% do elemento estiver visível
        };

        this.init();
    }

    private init(): void {
        if (this.counters.length === 0) return;

        this.setupIntersectionObserver();
        this.observeCounters();
    }

    /**
     * Formata número com vírgula decimal
     */
    private formatNumber(num: number, decimals: number): string {
        // Converte para string e substitui ponto por vírgula
        const formatted: string = num.toFixed(decimals).replace('.', ',');
        return formatted;
    }

    /**
     * Anima um contador específico
     */
    private animateCounter(counter: HTMLElement): void {
        const counterData: CounterData = this.extractCounterData(counter);
        const startTime: number = performance.now();

        const updateCounter = (currentTime: number): void => {
            const elapsed: number = currentTime - startTime;
            const progress: number = Math.min(elapsed / this.config.animationDuration, 1);

            // Função easeOutCubic para animação suave
            const easeOutCubic: number = 1 - Math.pow(1 - progress, 3);
            const currentValue: number = counterData.from + (counterData.to - counterData.from) * easeOutCubic;

            counter.textContent = this.formatNumber(currentValue, counterData.decimals);

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                // Garante que o valor final seja exato
                counter.textContent = this.formatNumber(counterData.to, counterData.decimals);
            }
        };

        requestAnimationFrame(updateCounter);
    }

    /**
     * Extrai dados do contador a partir dos atributos data
     */
    private extractCounterData(counter: HTMLElement): CounterData {
        const from: number = parseFloat(counter.dataset.from || '0');
        const to: number = parseFloat(counter.dataset.to || '0');
        const decimals: number = parseInt(counter.dataset.decimals || '0');

        return { from, to, decimals };
    }

    /**
     * Configura o Intersection Observer para detectar quando os contadores entram em viewport
     */
    private setupIntersectionObserver(): void {
        const observerOptions: IntersectionObserverInit = {
            threshold: this.config.observerThreshold,
            rootMargin: '0px 0px -50px 0px' // Ativa um pouco antes do elemento entrar completamente
        };

        this.observer = new IntersectionObserver((entries: IntersectionObserverEntry[]): void => {
            entries.forEach((entry: IntersectionObserverEntry): void => {
                if (entry.isIntersecting && !entry.target.dataset.animated) {
                    // Marca como animado para não repetir
                    (entry.target as HTMLElement).dataset.animated = 'true';
                    this.animateCounter(entry.target as HTMLElement);
                }
            });
        }, observerOptions);
    }

    /**
     * Inicia a observação de todos os contadores encontrados
     */
    private observeCounters(): void {
        this.counters.forEach((counter: HTMLElement): void => {
            this.observer.observe(counter);
        });
    }

    /**
     * Limpa o observer quando necessário
     */
    public destroy(): void {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}

// Inicializa o gerenciador de contadores quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', (): void => {
    new CounterAnimationManager();
});