/**
 * Modern utility functions for Peking Restaurant website
 * Replaces jQuery dependencies with vanilla JavaScript
 */

// DOM utilities
export const DOM = {
  // jQuery equivalent: $(selector)
  query: (selector, context = document) => {
    return context.querySelector(selector);
  },

  // jQuery equivalent: $(selector) for multiple elements
  queryAll: (selector, context = document) => {
    return Array.from(context.querySelectorAll(selector));
  },

  // jQuery equivalent: $(document).ready()
  ready: (callback) => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', callback);
    } else {
      callback();
    }
  },

  // jQuery equivalent: .addClass()
  addClass: (element, className) => {
    if (element) element.classList.add(className);
  },

  // jQuery equivalent: .removeClass()
  removeClass: (element, className) => {
    if (element) element.classList.remove(className);
  },

  // jQuery equivalent: .toggleClass()
  toggleClass: (element, className) => {
    if (element) element.classList.toggle(className);
  },

  // jQuery equivalent: .hasClass()
  hasClass: (element, className) => {
    return element ? element.classList.contains(className) : false;
  },

  // jQuery equivalent: .hide()
  hide: (element) => {
    if (element) element.style.display = 'none';
  },

  // jQuery equivalent: .show()
  show: (element) => {
    if (element) element.style.display = '';
  },

  // Create element
  create: (tag, attributes = {}, textContent = '') => {
    const element = document.createElement(tag);

    Object.entries(attributes).forEach(([key, value]) => {
      if (key === 'className') {
        element.className = value;
      } else if (key === 'dataset') {
        Object.entries(value).forEach(([dataKey, dataValue]) => {
          element.dataset[dataKey] = dataValue;
        });
      } else {
        element.setAttribute(key, value);
      }
    });

    if (textContent) {
      element.textContent = textContent;
    }

    return element;
  },
};

// Animation utilities (replacing jQuery animations)
export const Animation = {
  // Slide toggle replacement
  slideToggle: (element, duration = 300) => {
    if (!element) return;

    const isVisible =
      element.style.display !== 'none' &&
      getComputedStyle(element).display !== 'none';

    if (isVisible) {
      Animation.slideUp(element, duration);
    } else {
      Animation.slideDown(element, duration);
    }
  },

  // Slide down
  slideDown: (element, duration = 300) => {
    if (!element) return;

    element.style.height = '0';
    element.style.overflow = 'hidden';
    element.style.display = '';

    const height = element.scrollHeight;

    element.style.transition = `height ${duration}ms ease-in-out`;
    element.style.height = height + 'px';

    setTimeout(() => {
      element.style.height = '';
      element.style.overflow = '';
      element.style.transition = '';
    }, duration);
  },

  // Slide up
  slideUp: (element, duration = 300) => {
    if (!element) return;

    const height = element.scrollHeight;
    element.style.transition = `height ${duration}ms ease-in-out`;
    element.style.height = height + 'px';
    element.style.overflow = 'hidden';

    // Trigger reflow
    element.offsetHeight;

    element.style.height = '0';

    setTimeout(() => {
      element.style.display = 'none';
      element.style.height = '';
      element.style.overflow = '';
      element.style.transition = '';
    }, duration);
  },

  // Fade in
  fadeIn: (element, duration = 300) => {
    if (!element) return;

    element.style.opacity = '0';
    element.style.display = '';
    element.style.transition = `opacity ${duration}ms ease-in-out`;

    // Trigger reflow
    element.offsetHeight;

    element.style.opacity = '1';

    setTimeout(() => {
      element.style.transition = '';
    }, duration);
  },

  // Fade out
  fadeOut: (element, duration = 300) => {
    if (!element) return;

    element.style.transition = `opacity ${duration}ms ease-in-out`;
    element.style.opacity = '0';

    setTimeout(() => {
      element.style.display = 'none';
      element.style.opacity = '';
      element.style.transition = '';
    }, duration);
  },
};

// Event utilities
export const Events = {
  // Add event listener with delegation support
  on: (selector, event, handler, context = document) => {
    if (typeof selector === 'string') {
      // Event delegation
      context.addEventListener(event, (e) => {
        const target = e.target.closest(selector);
        if (target) {
          handler.call(target, e);
        }
      });
    } else {
      // Direct element
      selector.addEventListener(event, handler);
    }
  },

  // Remove event listener
  off: (element, event, handler) => {
    if (element) {
      element.removeEventListener(event, handler);
    }
  },

  // Trigger custom event
  trigger: (element, eventName, data = {}) => {
    if (element) {
      const event = new CustomEvent(eventName, { detail: data });
      element.dispatchEvent(event);
    }
  },
};

// AJAX utilities (fetch replacement for jQuery.ajax)
export const HTTP = {
  // GET request
  get: async (url, options = {}) => {
    try {
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          ...options.headers,
        },
        ...options,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      console.error('GET request failed:', error);
      throw error;
    }
  },

  // POST request
  post: async (url, data = {}, options = {}) => {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...options.headers,
        },
        body: JSON.stringify(data),
        ...options,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      console.error('POST request failed:', error);
      throw error;
    }
  },
};

// Utility functions
export const Utils = {
  // Debounce function
  debounce: (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  },

  // Throttle function
  throttle: (func, limit) => {
    let inThrottle;
    return function executedFunction(...args) {
      if (!inThrottle) {
        func.apply(this, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  },

  // Check if element is in viewport
  isInViewport: (element) => {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <=
        (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  },

  // Format price
  formatPrice: (price, currency = 'KN') => {
    const num = parseFloat(price);
    return isNaN(num) ? price : `${num.toFixed(2)} ${currency}`;
  },

  // Escape HTML
  escapeHtml: (unsafe) => {
    return unsafe
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  },
};

// Storage utilities
export const Storage = {
  // localStorage wrapper
  local: {
    get: (key, defaultValue = null) => {
      try {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : defaultValue;
      } catch (error) {
        console.warn('localStorage get error:', error);
        return defaultValue;
      }
    },

    set: (key, value) => {
      try {
        localStorage.setItem(key, JSON.stringify(value));
        return true;
      } catch (error) {
        console.warn('localStorage set error:', error);
        return false;
      }
    },

    remove: (key) => {
      try {
        localStorage.removeItem(key);
        return true;
      } catch (error) {
        console.warn('localStorage remove error:', error);
        return false;
      }
    },
  },

  // sessionStorage wrapper
  session: {
    get: (key, defaultValue = null) => {
      try {
        const item = sessionStorage.getItem(key);
        return item ? JSON.parse(item) : defaultValue;
      } catch (error) {
        console.warn('sessionStorage get error:', error);
        return defaultValue;
      }
    },

    set: (key, value) => {
      try {
        sessionStorage.setItem(key, JSON.stringify(value));
        return true;
      } catch (error) {
        console.warn('sessionStorage set error:', error);
        return false;
      }
    },

    remove: (key) => {
      try {
        sessionStorage.removeItem(key);
        return true;
      } catch (error) {
        console.warn('sessionStorage remove error:', error);
        return false;
      }
    },
  },
};
