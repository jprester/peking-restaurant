/**
 * Modern Navigation Component
 * Replaces jQuery-based navigation with modern vanilla JavaScript
 */

import { DOM, Animation, Events, Utils } from './utils.js';

export class MobileNavigation {
  constructor(options = {}) {
    this.options = {
      menuSelector: '.mobile-menilist',
      toggleSelector: '.mobile-meninav a',
      activeClass: 'is-open',
      animationDuration: 300,
      closeOnOutsideClick: true,
      closeOnItemClick: true,
      ...options,
    };

    this.menuElement = DOM.query(this.options.menuSelector);
    this.toggleElements = DOM.queryAll(this.options.toggleSelector);
    this.isOpen = false;

    this.init();
  }

  init() {
    if (!this.menuElement) {
      console.warn('Mobile menu element not found');
      return;
    }

    this.bindEvents();
    this.setupAria();
  }

  bindEvents() {
    // Toggle button clicks
    this.toggleElements.forEach((toggle) => {
      Events.on(toggle, 'click', (e) => {
        e.preventDefault();
        this.toggle();
      });
    });

    // Close on outside click
    if (this.options.closeOnOutsideClick) {
      Events.on(document, 'click', (e) => {
        if (
          this.isOpen &&
          !this.menuElement.contains(e.target) &&
          !this.toggleElements.some((toggle) => toggle.contains(e.target))
        ) {
          this.close();
        }
      });
    }

    // Close on menu item click
    if (this.options.closeOnItemClick) {
      Events.on(
        '.nav__link',
        'click',
        () => {
          this.close();
        },
        this.menuElement
      );
    }

    // Keyboard navigation
    Events.on(document, 'keydown', (e) => {
      if (e.key === 'Escape' && this.isOpen) {
        this.close();
      }
    });

    // Handle window resize
    const resizeHandler = Utils.debounce(() => {
      if (window.innerWidth > 768 && this.isOpen) {
        this.close();
      }
    }, 250);

    Events.on(window, 'resize', resizeHandler);
  }

  setupAria() {
    // Set up ARIA attributes
    this.toggleElements.forEach((toggle, index) => {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute(
        'aria-controls',
        this.menuElement.id || `mobile-menu-${index}`
      );

      if (!this.menuElement.id) {
        this.menuElement.id = `mobile-menu-${index}`;
      }
    });

    this.menuElement.setAttribute('aria-hidden', 'true');
  }

  toggle() {
    if (this.isOpen) {
      this.close();
    } else {
      this.open();
    }
  }

  open() {
    if (this.isOpen) return;

    this.isOpen = true;
    DOM.addClass(this.menuElement, this.options.activeClass);

    // Update ARIA attributes
    this.toggleElements.forEach((toggle) => {
      toggle.setAttribute('aria-expanded', 'true');
    });
    this.menuElement.setAttribute('aria-hidden', 'false');

    // Animate menu
    Animation.slideDown(this.menuElement, this.options.animationDuration);

    // Focus first menu item
    const firstLink = DOM.query('.nav__link', this.menuElement);
    if (firstLink) {
      setTimeout(() => firstLink.focus(), this.options.animationDuration);
    }

    // Emit event
    Events.trigger(this.menuElement, 'mobile-menu:open');
  }

  close() {
    if (!this.isOpen) return;

    this.isOpen = false;
    DOM.removeClass(this.menuElement, this.options.activeClass);

    // Update ARIA attributes
    this.toggleElements.forEach((toggle) => {
      toggle.setAttribute('aria-expanded', 'false');
    });
    this.menuElement.setAttribute('aria-hidden', 'true');

    // Animate menu
    Animation.slideUp(this.menuElement, this.options.animationDuration);

    // Emit event
    Events.trigger(this.menuElement, 'mobile-menu:close');
  }
}

export class SmoothScroll {
  constructor(options = {}) {
    this.options = {
      selector: 'a[href^="#"]',
      duration: 800,
      easing: 'easeInOutCubic',
      offset: 0,
      ...options,
    };

    this.init();
  }

  init() {
    Events.on(this.options.selector, 'click', (e) => {
      const href = e.target.getAttribute('href');

      if (href === '#' || href === '#top') {
        e.preventDefault();
        this.scrollToTop();
        return;
      }

      const target = DOM.query(href);
      if (target) {
        e.preventDefault();
        this.scrollToElement(target);
      }
    });
  }

  scrollToElement(element) {
    const targetPosition =
      element.getBoundingClientRect().top +
      window.pageYOffset -
      this.options.offset;
    this.scrollTo(targetPosition);
  }

  scrollToTop() {
    this.scrollTo(0);
  }

  scrollTo(targetPosition) {
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    const ease = (t, b, c, d) => {
      // easeInOutCubic
      t /= d / 2;
      if (t < 1) return (c / 2) * t * t * t + b;
      t -= 2;
      return (c / 2) * (t * t * t + 2) + b;
    };

    const animation = (currentTime) => {
      if (startTime === null) startTime = currentTime;
      const timeElapsed = currentTime - startTime;
      const progress = Math.min(timeElapsed / this.options.duration, 1);

      const easedProgress = ease(timeElapsed, 0, 1, this.options.duration);
      const currentPosition = startPosition + distance * easedProgress;

      window.scrollTo(0, currentPosition);

      if (progress < 1) {
        requestAnimationFrame(animation);
      }
    };

    requestAnimationFrame(animation);
  }
}

export class ScrollSpy {
  constructor(options = {}) {
    this.options = {
      sections: '[data-scroll-spy]',
      navLinks: '.nav__link[href^="#"]',
      activeClass: 'nav__link--active',
      offset: 100,
      ...options,
    };

    this.sections = DOM.queryAll(this.options.sections);
    this.navLinks = DOM.queryAll(this.options.navLinks);

    this.init();
  }

  init() {
    if (this.sections.length === 0) return;

    const scrollHandler = Utils.throttle(() => {
      this.updateActiveSection();
    }, 100);

    Events.on(window, 'scroll', scrollHandler);
    this.updateActiveSection(); // Initial check
  }

  updateActiveSection() {
    const scrollPosition = window.pageYOffset + this.options.offset;
    let activeSection = null;

    // Find the current section
    this.sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;

      if (
        scrollPosition >= sectionTop &&
        scrollPosition < sectionTop + sectionHeight
      ) {
        activeSection = section;
      }
    });

    // Update navigation
    this.navLinks.forEach((link) => {
      DOM.removeClass(link, this.options.activeClass);

      if (activeSection) {
        const href = link.getAttribute('href');
        if (href === `#${activeSection.id}`) {
          DOM.addClass(link, this.options.activeClass);
        }
      }
    });
  }
}

export class IntersectionObserver {
  constructor(options = {}) {
    this.options = {
      elements: '.animate-on-scroll',
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px',
      activeClass: 'is-visible',
      once: true,
      ...options,
    };

    this.elements = DOM.queryAll(this.options.elements);
    this.observer = null;

    this.init();
  }

  init() {
    if (!window.IntersectionObserver || this.elements.length === 0) {
      // Fallback for browsers without IntersectionObserver
      this.elements.forEach((element) => {
        DOM.addClass(element, this.options.activeClass);
      });
      return;
    }

    this.observer = new window.IntersectionObserver(
      this.handleIntersection.bind(this),
      {
        threshold: this.options.threshold,
        rootMargin: this.options.rootMargin,
      }
    );

    this.elements.forEach((element) => {
      this.observer.observe(element);
    });
  }

  handleIntersection(entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        DOM.addClass(entry.target, this.options.activeClass);

        if (this.options.once) {
          this.observer.unobserve(entry.target);
        }
      } else if (!this.options.once) {
        DOM.removeClass(entry.target, this.options.activeClass);
      }
    });
  }

  disconnect() {
    if (this.observer) {
      this.observer.disconnect();
    }
  }
}

// Initialize navigation components
DOM.ready(() => {
  // Initialize mobile navigation
  new MobileNavigation();

  // Initialize smooth scrolling
  new SmoothScroll();

  // Initialize scroll spy
  new ScrollSpy();

  // Initialize intersection observer for animations
  new IntersectionObserver();
});
