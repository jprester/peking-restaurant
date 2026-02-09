/**
 * Peking Restaurant - Vanilla JS
 * Replaces jQuery for simple interactions
 */

document.addEventListener("DOMContentLoaded", function () {
  // --- Mobile main menu toggle ---
  var mobileToggle = document.getElementById("mobileMenuToggle");
  var mobileMenu = document.getElementById("mobileMenu");

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener("click", function (e) {
      e.preventDefault();
      mobileMenu.style.display =
        mobileMenu.style.display === "block" ? "none" : "block";
    });
  }

  // --- Mobile menu category toggle ---
  var catToggle = document.getElementById("menuCategoryToggle");
  var catList = document.getElementById("menuCategoryList");

  if (catToggle && catList) {
    catToggle.addEventListener("click", function (e) {
      e.preventDefault();
      catList.style.display =
        catList.style.display === "block" ? "none" : "block";
    });
  }

  // --- Simple image slider with crossfade ---
  var slides = document.querySelectorAll(".slider-images .slide");
  if (slides.length > 1) {
    var currentSlide = 0;

    setInterval(function () {
      slides[currentSlide].classList.remove("active");
      currentSlide = (currentSlide + 1) % slides.length;
      slides[currentSlide].classList.add("active");
    }, 4000);
  }
});
