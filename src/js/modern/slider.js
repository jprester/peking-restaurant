/**
 * Modern Image Slider Component
 * Replaces Nivo Slider with vanilla JavaScript and CSS
 */

import { DOM, Animation, Events, Utils } from './utils.js';

export class ImageSlider {
  constructor(container, options = {}) {
    this.container =
      typeof container === 'string' ? DOM.query(container) : container;
    if (!this.container) {
      console.error('Slider container not found');
      return;
    }

    this.options = {
      autoplay: true,
      autoplayDelay: 5000,
      transitionDuration: 500,
      showNavigation: true,
      showDots: true,
      pauseOnHover: true,
      infiniteLoop: true,
      effect: 'slide', // 'slide', 'fade'
      ...options,
    };

    this.currentSlide = 0;
    this.slideCount = 0;
    this.isTransitioning = false;
    this.autoplayTimer = null;
    this.isPlaying = this.options.autoplay;

    this.init();
  }

  init() {
    this.setupSlider();
    this.createNavigation();
    this.createDots();
    this.bindEvents();

    if (this.options.autoplay) {
      this.startAutoplay();
    }
  }

  setupSlider() {
    // Get all slide images
    const images = DOM.queryAll('img', this.container);
    this.slideCount = images.length;

    if (this.slideCount === 0) {
      console.warn('No images found in slider container');
      return;
    }

    // Create slider structure
    this.container.className = 'image-slider';
    this.container.innerHTML = '';

    // Create slides container
    this.slidesContainer = DOM.create('div', {
      className: 'image-slider__container',
    });
    this.container.appendChild(this.slidesContainer);

    // Create slides from images
    images.forEach((img, index) => {
      const slide = DOM.create('div', {
        className: 'image-slider__slide',
        dataset: { index: index },
      });

      const newImg = DOM.create('img', {
        src: img.src,
        alt: img.alt || `Slide ${index + 1}`,
        loading: 'lazy',
      });

      slide.appendChild(newImg);

      // Add caption if available
      const caption = img.getAttribute('data-caption') || img.alt;
      if (caption && caption !== `Slide ${index + 1}`) {
        const captionEl = DOM.create('div', {
          className: 'image-slider__caption',
        });
        captionEl.innerHTML = `<h3>${caption}</h3>`;
        slide.appendChild(captionEl);
      }

      this.slidesContainer.appendChild(slide);
    });

    // Set initial position
    this.updateSliderPosition(false);
  }

  createNavigation() {
    if (!this.options.showNavigation || this.slideCount <= 1) return;

    // Previous button
    this.prevBtn = DOM.create('button', {
      className: 'image-slider__nav image-slider__nav--prev',
      'aria-label': 'Previous slide',
    });
    this.prevBtn.innerHTML = '&#8249;';
    this.container.appendChild(this.prevBtn);

    // Next button
    this.nextBtn = DOM.create('button', {
      className: 'image-slider__nav image-slider__nav--next',
      'aria-label': 'Next slide',
    });
    this.nextBtn.innerHTML = '&#8250;';
    this.container.appendChild(this.nextBtn);
  }

  createDots() {
    if (!this.options.showDots || this.slideCount <= 1) return;

    this.dotsContainer = DOM.create('div', { className: 'image-slider__dots' });

    for (let i = 0; i < this.slideCount; i++) {
      const dot = DOM.create('button', {
        className: `image-slider__dot ${i === 0 ? 'image-slider__dot--active' : ''}`,
        'aria-label': `Go to slide ${i + 1}`,
        dataset: { index: i },
      });
      this.dotsContainer.appendChild(dot);
    }

    this.container.appendChild(this.dotsContainer);
  }

  bindEvents() {
    // Navigation buttons
    if (this.prevBtn) {
      Events.on(this.prevBtn, 'click', (e) => {
        e.preventDefault();
        this.prevSlide();
      });
    }

    if (this.nextBtn) {
      Events.on(this.nextBtn, 'click', (e) => {
        e.preventDefault();
        this.nextSlide();
      });
    }

    // Dot navigation
    if (this.dotsContainer) {
      Events.on(
        '.image-slider__dot',
        'click',
        (e) => {
          e.preventDefault();
          const index = parseInt(e.target.dataset.index);
          this.goToSlide(index);
        },
        this.dotsContainer
      );
    }

    // Pause on hover
    if (this.options.pauseOnHover) {
      Events.on(this.container, 'mouseenter', () => this.pauseAutoplay());
      Events.on(this.container, 'mouseleave', () => this.resumeAutoplay());
    }

    // Keyboard navigation
    Events.on(document, 'keydown', (e) => {
      if (!this.container.matches(':hover')) return;

      switch (e.key) {
        case 'ArrowLeft':
          e.preventDefault();
          this.prevSlide();
          break;
        case 'ArrowRight':
          e.preventDefault();
          this.nextSlide();
          break;
        case ' ':
          e.preventDefault();
          this.toggleAutoplay();
          break;
      }
    });

    // Touch/swipe support
    this.addTouchSupport();

    // Visibility API for autoplay
    Events.on(document, 'visibilitychange', () => {
      if (document.hidden) {
        this.pauseAutoplay();
      } else if (this.isPlaying) {
        this.resumeAutoplay();
      }
    });
  }

  addTouchSupport() {
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    Events.on(this.container, 'touchstart', (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
      this.pauseAutoplay();
    });

    Events.on(this.container, 'touchmove', (e) => {
      if (!isDragging) return;
      currentX = e.touches[0].clientX;
    });

    Events.on(this.container, 'touchend', () => {
      if (!isDragging) return;
      isDragging = false;

      const diffX = startX - currentX;
      const threshold = 50;

      if (Math.abs(diffX) > threshold) {
        if (diffX > 0) {
          this.nextSlide();
        } else {
          this.prevSlide();
        }
      }

      if (this.isPlaying) {
        this.resumeAutoplay();
      }
    });
  }

  nextSlide() {
    if (this.isTransitioning) return;

    const nextIndex = this.options.infiniteLoop
      ? (this.currentSlide + 1) % this.slideCount
      : Math.min(this.currentSlide + 1, this.slideCount - 1);

    this.goToSlide(nextIndex);
  }

  prevSlide() {
    if (this.isTransitioning) return;

    const prevIndex = this.options.infiniteLoop
      ? (this.currentSlide - 1 + this.slideCount) % this.slideCount
      : Math.max(this.currentSlide - 1, 0);

    this.goToSlide(prevIndex);
  }

  goToSlide(index) {
    if (this.isTransitioning || index === this.currentSlide) return;

    this.currentSlide = index;
    this.updateSliderPosition();
    this.updateDots();
    this.resetAutoplay();
  }

  updateSliderPosition(animate = true) {
    if (!this.slidesContainer) return;

    this.isTransitioning = animate;

    if (this.options.effect === 'fade') {
      // Fade effect
      const slides = DOM.queryAll('.image-slider__slide', this.slidesContainer);
      slides.forEach((slide, index) => {
        slide.style.opacity = index === this.currentSlide ? '1' : '0';
      });
    } else {
      // Slide effect
      const translateX = -this.currentSlide * 100;
      this.slidesContainer.style.transform = `translateX(${translateX}%)`;
    }

    if (animate) {
      setTimeout(() => {
        this.isTransitioning = false;
      }, this.options.transitionDuration);
    }
  }

  updateDots() {
    if (!this.dotsContainer) return;

    const dots = DOM.queryAll('.image-slider__dot', this.dotsContainer);
    dots.forEach((dot, index) => {
      if (index === this.currentSlide) {
        DOM.addClass(dot, 'image-slider__dot--active');
      } else {
        DOM.removeClass(dot, 'image-slider__dot--active');
      }
    });
  }

  startAutoplay() {
    if (this.slideCount <= 1) return;

    this.isPlaying = true;
    this.autoplayTimer = setInterval(() => {
      this.nextSlide();
    }, this.options.autoplayDelay);
  }

  pauseAutoplay() {
    if (this.autoplayTimer) {
      clearInterval(this.autoplayTimer);
      this.autoplayTimer = null;
    }
  }

  resumeAutoplay() {
    if (this.isPlaying && !this.autoplayTimer) {
      this.startAutoplay();
    }
  }

  stopAutoplay() {
    this.isPlaying = false;
    this.pauseAutoplay();
  }

  toggleAutoplay() {
    if (this.isPlaying) {
      this.stopAutoplay();
    } else {
      this.startAutoplay();
    }
  }

  resetAutoplay() {
    if (this.isPlaying) {
      this.pauseAutoplay();
      this.startAutoplay();
    }
  }

  // Public API methods
  destroy() {
    this.stopAutoplay();

    // Remove event listeners
    if (this.container) {
      this.container.innerHTML = '';
    }
  }

  getCurrentSlide() {
    return this.currentSlide;
  }

  getSlideCount() {
    return this.slideCount;
  }
}

// Auto-initialize sliders
DOM.ready(() => {
  const sliders = DOM.queryAll('[data-slider]');
  sliders.forEach((slider) => {
    const options = {};

    // Parse data attributes for options
    if (slider.dataset.autoplay !== undefined) {
      options.autoplay = slider.dataset.autoplay !== 'false';
    }
    if (slider.dataset.delay) {
      options.autoplayDelay = parseInt(slider.dataset.delay);
    }
    if (slider.dataset.effect) {
      options.effect = slider.dataset.effect;
    }

    new ImageSlider(slider, options);
  });
});
