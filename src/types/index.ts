// Global Type Definitions for ValorIA Project

// DOM Element Types
export type DOMElement = HTMLElement;

// Header Types
export interface HeaderState {
  lastScrollTop: number;
  scrollThreshold: number;
}

export interface HeaderClasses {
  hidden: string;
  visible: string;
}

// Counter Types
export interface CounterData {
  from: number;
  to: number;
  decimals: number;
  animated?: string;
}

export interface CounterConfig {
  animationDuration: number;
  observerThreshold: number;
}

export interface CounterOptions {
  easeOutCubic?: (progress: number) => number;
  onUpdate?: (value: string) => void;
  onComplete?: (finalValue: string) => void;
}

// Animation Types
export interface AnimationFrame {
  timestamp: number;
  progress: number;
}

// Observer Types
export interface ObserverOptions extends IntersectionObserverInit {
  threshold?: number;
  rootMargin?: string;
}

// Service Types
export interface ServiceResponse<T = any> {
  success: boolean;
  data?: T;
  error?: string;
}

// Event Types
export interface ScrollEvent extends Event {
  target: Window;
  deltaY: number;
}

// Utility Types
export type Optional<T, K extends keyof T> = Omit<T, K> & Partial<Pick<T, K>>;
export type RequiredBy<T, K extends keyof T> = T & Required<Pick<T, K>>;