/**
 * Main Application Entry Point
 * Modern JavaScript for Peking Restaurant website
 */

import { DOM, Events, Utils, Storage } from './utils.js';
import { ImageSlider } from './slider.js';
import {
  MobileNavigation,
  SmoothScroll,
  ScrollSpy,
  IntersectionObserver,
} from './navigation.js';

class PekingApp {
  constructor() {
    this.components = new Map();
    this.isLoaded = false;

    this.init();
  }

  init() {
    DOM.ready(() => {
      this.setupComponents();
      this.bindGlobalEvents();
      this.initializeFeatures();
      this.isLoaded = true;

      console.log('Peking Restaurant app initialized');
    });
  }

  setupComponents() {
    // Initialize mobile navigation
    this.components.set(
      'mobileNav',
      new MobileNavigation({
        menuSelector: '.mobile-menilist',
        toggleSelector: '.mobile-meninav a',
      })
    );

    // Initialize smooth scrolling
    this.components.set(
      'smoothScroll',
      new SmoothScroll({
        duration: 600,
        offset: 80,
      })
    );

    // Initialize scroll spy for navigation
    this.components.set(
      'scrollSpy',
      new ScrollSpy({
        sections: 'main section[id]',
        offset: 100,
      })
    );

    // Initialize intersection observer for animations
    this.components.set(
      'intersectionObserver',
      new IntersectionObserver({
        elements: '.animate-on-scroll',
        threshold: 0.2,
        once: true,
      })
    );

    // Initialize image sliders
    this.initializeSliders();
  }

  initializeSliders() {
    // Auto-initialize Nivo Slider replacements
    const nivoSliders = DOM.queryAll(
      '#slider, .nivo-slider, [data-nivo-slider]'
    );
    nivoSliders.forEach((slider, index) => {
      const sliderId = `slider-${index}`;
      this.components.set(
        sliderId,
        new ImageSlider(slider, {
          autoplay: true,
          autoplayDelay: 5000,
          effect: 'slide',
          showNavigation: true,
          showDots: true,
        })
      );
    });

    // Initialize custom sliders
    const customSliders = DOM.queryAll('[data-slider]');
    customSliders.forEach((slider, index) => {
      const sliderId = `custom-slider-${index}`;
      const options = this.parseSliderOptions(slider);
      this.components.set(sliderId, new ImageSlider(slider, options));
    });
  }

  parseSliderOptions(element) {
    const options = {};

    if (element.dataset.autoplay !== undefined) {
      options.autoplay = element.dataset.autoplay !== 'false';
    }
    if (element.dataset.delay) {
      options.autoplayDelay = parseInt(element.dataset.delay);
    }
    if (element.dataset.effect) {
      options.effect = element.dataset.effect;
    }
    if (element.dataset.navigation !== undefined) {
      options.showNavigation = element.dataset.navigation !== 'false';
    }
    if (element.dataset.dots !== undefined) {
      options.showDots = element.dataset.dots !== 'false';
    }

    return options;
  }

  bindGlobalEvents() {
    // Handle legacy jQuery mobile menu functionality
    this.handleLegacyMobileMenu();

    // Handle form improvements
    this.enhanceForms();

    // Handle image lazy loading
    this.setupLazyLoading();

    // Handle external links
    this.handleExternalLinks();

    // Handle print functionality
    this.setupPrintStyles();

    // Handle performance monitoring
    this.setupPerformanceMonitoring();
  }

  handleLegacyMobileMenu() {
    // Support for existing mobile menu structure
    Events.on('.mmenu a', 'click', (e) => {
      e.preventDefault();
      const mnav = DOM.query('.mnav');
      if (mnav) {
        DOM.toggleClass(mnav, 'is-open');
        // Use modern animation instead of jQuery slideToggle
        if (DOM.hasClass(mnav, 'is-open')) {
          mnav.style.display = 'block';
        } else {
          mnav.style.display = 'none';
        }
      }
    });
  }

  enhanceForms() {
    // Add modern form validation and UX improvements
    const forms = DOM.queryAll('form');

    forms.forEach((form) => {
      // Add novalidate to use custom validation
      form.setAttribute('novalidate', 'true');

      // Handle form submission
      Events.on(form, 'submit', (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault();
          return false;
        }
      });

      // Add real-time validation
      const inputs = DOM.queryAll('input, textarea, select', form);
      inputs.forEach((input) => {
        Events.on(input, 'blur', () => {
          this.validateField(input);
        });

        Events.on(
          input,
          'input',
          Utils.debounce(() => {
            this.clearFieldError(input);
          }, 300)
        );
      });
    });
  }

  validateForm(form) {
    const inputs = DOM.queryAll(
      'input[required], textarea[required], select[required]',
      form
    );
    let isValid = true;

    inputs.forEach((input) => {
      if (!this.validateField(input)) {
        isValid = false;
      }
    });

    return isValid;
  }

  validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    const type = field.type;

    let isValid = true;
    let errorMessage = '';

    // Required validation
    if (isRequired && !value) {
      isValid = false;
      errorMessage = 'Ovo polje je obavezno.';
    }

    // Email validation
    if (type === 'email' && value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = 'Molimo unesite valjanu email adresu.';
      }
    }

    // Phone validation
    if (type === 'tel' && value) {
      const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
      if (!phoneRegex.test(value)) {
        isValid = false;
        errorMessage = 'Molimo unesite valjan broj telefona.';
      }
    }

    this.displayFieldValidation(field, isValid, errorMessage);
    return isValid;
  }

  displayFieldValidation(field, isValid, errorMessage) {
    // Remove existing error styling
    DOM.removeClass(field, 'error');
    const existingError = DOM.query('.field-error', field.parentNode);
    if (existingError) {
      existingError.remove();
    }

    if (!isValid && errorMessage) {
      // Add error styling
      DOM.addClass(field, 'error');

      // Add error message
      const errorEl = DOM.create(
        'div',
        { className: 'field-error' },
        errorMessage
      );
      field.parentNode.appendChild(errorEl);
    }
  }

  clearFieldError(field) {
    DOM.removeClass(field, 'error');
    const existingError = DOM.query('.field-error', field.parentNode);
    if (existingError) {
      existingError.remove();
    }
  }

  setupLazyLoading() {
    // Native lazy loading fallback for older browsers
    if ('loading' in HTMLImageElement.prototype) {
      const images = DOM.queryAll('img[data-src]');
      images.forEach((img) => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      });
    } else {
      // IntersectionObserver fallback
      this.setupImageLazyLoading();
    }
  }

  setupImageLazyLoading() {
    const images = DOM.queryAll('img[data-src]');

    if (!window.IntersectionObserver) {
      // Fallback: load all images immediately
      images.forEach((img) => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      });
      return;
    }

    const imageObserver = new window.IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
            DOM.addClass(img, 'loaded');
            imageObserver.unobserve(img);
          }
        });
      },
      {
        rootMargin: '50px 0px',
      }
    );

    images.forEach((img) => imageObserver.observe(img));
  }

  handleExternalLinks() {
    // Add external link indicators and security
    const externalLinks = DOM.queryAll(
      'a[href^="http"]:not([href*="' + location.hostname + '"])'
    );

    externalLinks.forEach((link) => {
      // Add external link indicator
      if (!link.querySelector('.external-icon')) {
        const icon = DOM.create('span', { className: 'external-icon' }, ' ↗');
        link.appendChild(icon);
      }

      // Add security attributes
      link.setAttribute('rel', 'noopener noreferrer');
      link.setAttribute('target', '_blank');
    });
  }

  setupPrintStyles() {
    // Add print-specific functionality
    Events.on(window, 'beforeprint', () => {
      // Expand collapsed menus for print
      const collapsedMenus = DOM.queryAll('.mobile-menilist:not(.is-open)');
      collapsedMenus.forEach((menu) => {
        DOM.addClass(menu, 'print-expanded');
      });
    });

    Events.on(window, 'afterprint', () => {
      // Restore collapsed state
      const expandedMenus = DOM.queryAll('.print-expanded');
      expandedMenus.forEach((menu) => {
        DOM.removeClass(menu, 'print-expanded');
      });
    });
  }

  setupPerformanceMonitoring() {
    // Basic performance monitoring
    if ('performance' in window && 'PerformanceObserver' in window) {
      try {
        // Monitor Largest Contentful Paint
        const lcpObserver = new PerformanceObserver((list) => {
          const entries = list.getEntries();
          const lastEntry = entries[entries.length - 1];
          console.log('LCP:', lastEntry.startTime);
        });
        lcpObserver.observe({
          type: 'largest-contentful-paint',
          buffered: true,
        });

        // Monitor First Input Delay
        const fidObserver = new PerformanceObserver((list) => {
          const entries = list.getEntries();
          entries.forEach((entry) => {
            console.log('FID:', entry.processingStart - entry.startTime);
          });
        });
        fidObserver.observe({ type: 'first-input', buffered: true });
      } catch (e) {
        // Silently fail for unsupported browsers
      }
    }
  }

  initializeFeatures() {
    // Initialize additional features based on page content
    this.setupMenuPage();
    this.setupContactPage();
    this.setupHomePage();
  }

  setupMenuPage() {
    // Menu-specific functionality
    if (DOM.query('.menu-page, #meni')) {
      this.initializeMenuFilters();
      this.initializeMenuSearch();
    }
  }

  initializeMenuFilters() {
    // Menu category filtering
    const filterButtons = DOM.queryAll('[data-filter]');
    const menuItems = DOM.queryAll('.menu-item, .jelo');

    filterButtons.forEach((button) => {
      Events.on(button, 'click', (e) => {
        e.preventDefault();
        const filter = button.dataset.filter;

        // Update active button
        filterButtons.forEach((btn) => DOM.removeClass(btn, 'active'));
        DOM.addClass(button, 'active');

        // Filter menu items
        menuItems.forEach((item) => {
          if (filter === 'all' || item.dataset.category === filter) {
            item.style.display = '';
            DOM.addClass(item, 'animate-fade-in-up');
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  initializeMenuSearch() {
    // Menu search functionality
    const searchInput = DOM.query('[data-menu-search]');
    if (!searchInput) return;

    const menuItems = DOM.queryAll('.menu-item, .jelo');

    Events.on(
      searchInput,
      'input',
      Utils.debounce((e) => {
        const searchTerm = e.target.value.toLowerCase().trim();

        menuItems.forEach((item) => {
          const title =
            item.querySelector('h3, .naziv')?.textContent.toLowerCase() || '';
          const description =
            item.querySelector('p, .opis')?.textContent.toLowerCase() || '';

          if (
            !searchTerm ||
            title.includes(searchTerm) ||
            description.includes(searchTerm)
          ) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      }, 300)
    );
  }

  setupContactPage() {
    // Contact page specific functionality
    if (DOM.query('.contact-page, #kontakt')) {
      // Initialize map if present
      this.initializeMap();
    }
  }

  initializeMap() {
    // Placeholder for map functionality
    const mapContainer = DOM.query('[data-map]');
    if (mapContainer && !mapContainer.innerHTML.trim()) {
      // Add static map or integrate with mapping service
      mapContainer.innerHTML = `
        <div class="map-placeholder">
          <p>Mapa će biti dostupna uskoro.</p>
          <p>Adresa: ${mapContainer.dataset.address || 'Zagreb, Hrvatska'}</p>
        </div>
      `;
    }
  }

  setupHomePage() {
    // Homepage specific functionality
    if (DOM.query('.home-page, #index')) {
      // Initialize homepage features
      this.initializeHeroAnimations();
    }
  }

  initializeHeroAnimations() {
    // Hero section animations
    const heroElements = DOM.queryAll('.hero h1, .hero p, .hero .btn');

    heroElements.forEach((element, index) => {
      setTimeout(() => {
        DOM.addClass(element, 'animate-fade-in-up');
      }, index * 200);
    });
  }

  // Public API
  getComponent(name) {
    return this.components.get(name);
  }

  destroyComponent(name) {
    const component = this.components.get(name);
    if (component && typeof component.destroy === 'function') {
      component.destroy();
      this.components.delete(name);
    }
  }

  isReady() {
    return this.isLoaded;
  }
}

// Initialize the application
const app = new PekingApp();

// Expose app to global scope for debugging
if (typeof window !== 'undefined') {
  window.PekingApp = app;
}

export default app;
