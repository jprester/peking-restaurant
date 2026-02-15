/**
 * Peking Restaurant - Vanilla JS
 */
document.addEventListener("DOMContentLoaded", () => {
  // --- Mobile main menu toggle (hamburger) ---
  const mobileToggle = document.getElementById("mobileMenuToggle");
  const mobileMenu = document.getElementById("mobileMenu");

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener("click", () => {
      const isOpen = mobileMenu.style.display === "block";
      mobileMenu.style.display = isOpen ? "none" : "block";
      mobileToggle.classList.toggle("open", !isOpen);
    });

    mobileMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        mobileMenu.style.display = "none";
        mobileToggle.classList.remove("open");
      });
    });
  }

  // --- Mobile menu category toggle ---
  const catToggle = document.getElementById("menuCategoryToggle");
  const catList = document.getElementById("menuCategoryList");

  if (catToggle && catList) {
    const catToggleWrap = catToggle.closest(".mob-cat-wrap");

    catToggle.addEventListener("click", () => {
      const isOpen = catList.style.display === "block";
      catList.style.display = isOpen ? "none" : "block";
      if (catToggleWrap) {
        catToggleWrap.classList.toggle("open", !isOpen);
      }
    });

    catList.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        catList.style.display = "none";
        if (catToggleWrap) {
          catToggleWrap.classList.remove("open");
        }
      });
    });
  }

  // --- Image slider with crossfade ---
  const slides = document.querySelectorAll(".slider-images .slide");
  const captionEl = document.querySelector(".slider-caption");
  if (slides.length > 1) {
    let current = 0;

    // Show initial caption
    if (captionEl && slides[current].dataset.caption) {
      captionEl.textContent = slides[current].dataset.caption;
    }

    setInterval(() => {
      slides[current].classList.remove("active");
      current = (current + 1) % slides.length;
      slides[current].classList.add("active");

      if (captionEl) {
        captionEl.style.opacity = "0";
        setTimeout(() => {
          captionEl.textContent = slides[current].dataset.caption || "";
          captionEl.style.opacity = "1";
        }, 300);
      }
    }, 5000);
  }
});
