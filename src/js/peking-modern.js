/**
 * Modern Peking Restaurant JavaScript
 * Replaces jQuery-based peking_scripts.js with modern vanilla JavaScript
 */

// Import modern modules
import app from './modern/app.js';

// Legacy compatibility layer for existing jQuery code
// This ensures existing functionality continues to work while we transition

// Create jQuery-like DOM ready function for backward compatibility
function domReady(callback) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', callback);
  } else {
    callback();
  }
}

// Modern implementation of existing jQuery functionality
domReady(() => {
  console.log('Peking Restaurant - Modern JavaScript loaded');

  // Modern mobile menu implementation (replaces jQuery slideToggle)
  const mobileMenuToggles = document.querySelectorAll('.mobile-meninav a');
  const mobileMenuList = document.querySelector('.mobile-menilist');

  mobileMenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (event) => {
      event.preventDefault();

      if (mobileMenuList) {
        // Modern slide toggle implementation
        const isHidden =
          mobileMenuList.style.display === 'none' ||
          getComputedStyle(mobileMenuList).display === 'none';

        if (isHidden) {
          // Slide down
          mobileMenuList.style.display = 'block';
          mobileMenuList.style.height = '0';
          mobileMenuList.style.overflow = 'hidden';
          mobileMenuList.style.transition = 'height 0.3s ease-in-out';

          // Get the full height
          const fullHeight = mobileMenuList.scrollHeight;

          // Trigger the animation
          requestAnimationFrame(() => {
            mobileMenuList.style.height = fullHeight + 'px';
          });

          // Clean up after animation
          setTimeout(() => {
            mobileMenuList.style.height = '';
            mobileMenuList.style.overflow = '';
            mobileMenuList.style.transition = '';
          }, 300);
        } else {
          // Slide up
          const currentHeight = mobileMenuList.scrollHeight;
          mobileMenuList.style.height = currentHeight + 'px';
          mobileMenuList.style.overflow = 'hidden';
          mobileMenuList.style.transition = 'height 0.3s ease-in-out';

          // Trigger the animation
          requestAnimationFrame(() => {
            mobileMenuList.style.height = '0';
          });

          // Hide after animation
          setTimeout(() => {
            mobileMenuList.style.display = 'none';
            mobileMenuList.style.height = '';
            mobileMenuList.style.overflow = '';
            mobileMenuList.style.transition = '';
          }, 300);
        }
      }
    });
  });

  // Modern main menu implementation (replaces $('.mmenu a').click)
  const mainMenuToggles = document.querySelectorAll('.mmenu a');
  const mainNav = document.querySelector('.mnav');

  mainMenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (event) => {
      event.preventDefault();

      if (mainNav) {
        // Modern slide toggle implementation
        const isHidden =
          mainNav.style.display === 'none' ||
          getComputedStyle(mainNav).display === 'none';

        if (isHidden) {
          mainNav.style.display = 'block';
          mainNav.style.opacity = '0';
          mainNav.style.transform = 'translateY(-10px)';
          mainNav.style.transition = 'all 0.3s ease-in-out';

          requestAnimationFrame(() => {
            mainNav.style.opacity = '1';
            mainNav.style.transform = 'translateY(0)';
          });
        } else {
          mainNav.style.transition = 'all 0.3s ease-in-out';
          mainNav.style.opacity = '0';
          mainNav.style.transform = 'translateY(-10px)';

          setTimeout(() => {
            mainNav.style.display = 'none';
            mainNav.style.opacity = '';
            mainNav.style.transform = '';
            mainNav.style.transition = '';
          }, 300);
        }
      }
    });
  });

  // Initialize modern Nivo Slider replacement
  initializeModernSlider();

  // Initialize modern form enhancements
  initializeFormEnhancements();

  // Initialize modern accessibility features
  initializeAccessibility();

  // Initialize modern performance optimizations
  initializePerformanceOptimizations();
});

// Modern slider initialization (replaces Nivo Slider)
function initializeModernSlider() {
  const sliderContainers = document.querySelectorAll('#slider, .nivo-slider');

  sliderContainers.forEach((container) => {
    // Convert Nivo Slider to modern slider
    const images = container.querySelectorAll('img');
    if (images.length > 1) {
      // Transform container for modern slider
      container.className = 'image-slider';
      container.setAttribute('data-slider', 'true');
      container.setAttribute('data-autoplay', 'true');
      container.setAttribute('data-delay', '5000');

      // The modern slider component will handle the rest
      console.log(`Initialized modern slider with ${images.length} images`);
    }
  });
}

// Modern form enhancements
function initializeFormEnhancements() {
  const forms = document.querySelectorAll('form');

  forms.forEach((form) => {
    // Add modern validation
    const inputs = form.querySelectorAll('input, textarea, select');

    inputs.forEach((input) => {
      // Modern placeholder fallback for older browsers
      if (
        input.placeholder &&
        !('placeholder' in document.createElement('input'))
      ) {
        // Placeholder polyfill for very old browsers
        if (!input.value) {
          input.value = input.placeholder;
          input.style.color = '#999';

          input.addEventListener('focus', () => {
            if (input.value === input.placeholder) {
              input.value = '';
              input.style.color = '';
            }
          });

          input.addEventListener('blur', () => {
            if (!input.value) {
              input.value = input.placeholder;
              input.style.color = '#999';
            }
          });
        }
      }

      // Modern validation feedback
      input.addEventListener('invalid', (e) => {
        e.preventDefault();
        showValidationMessage(input, input.validationMessage);
      });

      input.addEventListener('input', () => {
        clearValidationMessage(input);
      });
    });
  });
}

function showValidationMessage(input, message) {
  clearValidationMessage(input);

  const errorElement = document.createElement('div');
  errorElement.className = 'validation-error';
  errorElement.textContent = message;
  errorElement.style.color = '#d32f2f';
  errorElement.style.fontSize = '0.875rem';
  errorElement.style.marginTop = '4px';

  input.parentNode.appendChild(errorElement);
  input.style.borderColor = '#d32f2f';
}

function clearValidationMessage(input) {
  const existingError = input.parentNode.querySelector('.validation-error');
  if (existingError) {
    existingError.remove();
  }
  input.style.borderColor = '';
}

// Modern accessibility features
function initializeAccessibility() {
  // Add skip links
  if (!document.querySelector('.skip-link')) {
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.className = 'skip-link';
    skipLink.textContent = 'Preskoči na glavni sadržaj';
    skipLink.style.cssText = `
      position: absolute;
      top: -40px;
      left: 6px;
      background: #000;
      color: #fff;
      padding: 8px;
      text-decoration: none;
      border-radius: 4px;
      z-index: 1000;
      transition: top 0.3s;
    `;

    skipLink.addEventListener('focus', () => {
      skipLink.style.top = '6px';
    });

    skipLink.addEventListener('blur', () => {
      skipLink.style.top = '-40px';
    });

    document.body.insertBefore(skipLink, document.body.firstChild);
  }

  // Add focus management for modals and menus
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      // Close any open modals or menus
      const openMenus = document.querySelectorAll(
        '.mobile-menilist[style*="block"], .mnav[style*="block"]'
      );
      openMenus.forEach((menu) => {
        menu.style.display = 'none';
      });
    }
  });

  // Improve keyboard navigation
  const focusableElements = document.querySelectorAll(
    'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
  );
  focusableElements.forEach((element) => {
    element.addEventListener('focus', () => {
      element.style.outline = '2px solid #a5745f';
      element.style.outlineOffset = '2px';
    });

    element.addEventListener('blur', () => {
      element.style.outline = '';
      element.style.outlineOffset = '';
    });
  });
}

// Modern performance optimizations
function initializePerformanceOptimizations() {
  // Preload critical resources
  const criticalImages = document.querySelectorAll('img[data-critical]');
  criticalImages.forEach((img) => {
    const link = document.createElement('link');
    link.rel = 'preload';
    link.as = 'image';
    link.href = img.src;
    document.head.appendChild(link);
  });

  // Optimize images with modern formats
  if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img:not([loading])');
    images.forEach((img) => {
      if (!img.closest('.image-slider')) {
        // Don't lazy load slider images
        img.loading = 'lazy';
      }
    });
  }

  // Service Worker registration for caching (optional)
  if ('serviceWorker' in navigator && window.location.protocol === 'https:') {
    navigator.serviceWorker.register('/sw.js').catch(() => {
      // Silently fail if service worker is not available
    });
  }

  // Critical CSS inline, defer non-critical CSS
  const nonCriticalCSS = document.querySelectorAll(
    'link[rel="stylesheet"][data-defer]'
  );
  nonCriticalCSS.forEach((link) => {
    link.media = 'print';
    link.onload = function () {
      this.media = 'all';
    };
  });
}

// Expose functions globally for backward compatibility
window.PekingModern = {
  domReady,
  initializeModernSlider,
  initializeFormEnhancements,
  initializeAccessibility,
  initializePerformanceOptimizations,
};

console.log('Peking Restaurant - Modern JavaScript initialized');
