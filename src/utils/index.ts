// Utility Functions for ValorIA Project

import type { ObserverOptions } from '@/types';

/**
 * Format number with decimal comma (Brazilian format)
 * @param num - Number to format
 * @param decimals - Number of decimal places
 * @returns Formatted string with comma decimal separator
 */
export const formatNumber = (num: number, decimals: number): string => {
  return num.toFixed(decimals).replace('.', ',');
};

/**
 * Easing function for smooth animations
 * @param progress - Progress value between 0 and 1
 * @returns Eased progress value
 */
export const easeOutCubic = (progress: number): number => {
  return 1 - Math.pow(1 - progress, 3);
};

/**
 * Get current scroll position with fallback
 * @returns Current scroll position in pixels
 */
export const getScrollPosition = (): number => {
  return window.pageYOffset || document.documentElement.scrollTop;
};

/**
 * Check if element is in viewport
 * @param element - DOM element to check
 * @param threshold - Visibility threshold (0-1)
 * @returns Promise<boolean> - Whether element is visible
 */
export const isElementInViewport = (
  element: HTMLElement,
  threshold: number = 0.5
): Promise<boolean> => {
  return new Promise((resolve) => {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            resolve(true);
            observer.disconnect();
          }
        });
      },
      { threshold }
    );

    observer.observe(element);

    // Fallback timeout
    setTimeout(() => {
      resolve(false);
      observer.disconnect();
    }, 5000);
  });
};

/**
 * Create intersection observer with default options
 * @param callback - Observer callback function
 * @param options - Observer options
 * @returns Configured IntersectionObserver
 */
export const createIntersectionObserver = (
  callback: IntersectionObserverCallback,
  options: ObserverOptions = {}
): IntersectionObserver => {
  const defaultOptions: ObserverOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -50px 0px'
  };

  const mergedOptions = { ...defaultOptions, ...options };
  return new IntersectionObserver(callback, mergedOptions);
};

/**
 * Debounce function for performance optimization
 * @param func - Function to debounce
 * @param wait - Wait time in milliseconds
 * @returns Debounced function
 */
export const debounce = <T extends (...args: any[]) => any>(
  func: T,
  wait: number
): ((...args: Parameters<T>) => void) => {
  let timeout: ReturnType<typeof setTimeout>;

  return (...args: Parameters<T>) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => func(...args), wait);
  };
};

/**
 * Check if device is mobile based on screen width
 * @returns boolean - Whether device is mobile
 */
export const isMobile = (): boolean => {
  return window.innerWidth <= 768;
};

/**
 * Generate unique ID for elements
 * @param prefix - Optional prefix for ID
 * @returns Unique ID string
 */
export const generateId = (prefix: string = 'id'): string => {
  return `${prefix}-${Math.random().toString(36).substr(2, 9)}`;
};