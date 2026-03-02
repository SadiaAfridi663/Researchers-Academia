// Mobile menu and submenu logic is handled in Include/navbar.php now.
// Do not redeclare const menuBtn, mobileMenu etc. otherwise it throws a SyntaxError and breaks the entire file.

// team page hero slider start here
const slides = document.querySelectorAll(".team-slide");
let current = 0;

function arrangeSlides() {
  const isSmallScreen = window.innerWidth < 768; // < md breakpoint
  slides.forEach((slide, i) => {
    const offset = (i - current + slides.length) % slides.length;

    slide.style.zIndex = slides.length - offset;
    slide.style.opacity = 1;

    if (offset === 0) {
      slide.style.transform = `translate(0, 0) scale(1)`;
      slide.classList.add("shadow-2xl");
    } else {
      const translate = offset * 70; // gap between stacked slides
      const scale = 1 - offset * 0.08;

      if (isSmallScreen) {
        // stack UPWARDS on small screens
        slide.style.transform = `translateY(${translate}px) scale(${scale})`;
      } else {
        // stack SIDEWAYS on large screens
        slide.style.transform = `translateX(${translate}px) scale(${scale})`;
      }

      slide.classList.remove("shadow-2xl");
    }
  });
}

function nextSlide() {
  current = (current + 1) % slides.length;
  arrangeSlides();
}

if (slides.length > 0) {
  arrangeSlides();
  setInterval(nextSlide, 2000);
  // handle resize dynamically
  window.addEventListener("resize", arrangeSlides);
}
// team page hero slider end here





// bloge slider start here
document.addEventListener("DOMContentLoaded", () => {
  const track = document.getElementById("row-track");
  const slides = track.children;
  let index = 0;

  function getVisibleSlides() {
    if (window.innerWidth >= 1024) return 3; // lg
    if (window.innerWidth >= 640) return 2; // sm & md
    return 1; // xs
  }

  function updateSlider() {
    const visibleSlides = getVisibleSlides();
    track.style.transform = `translateX(-${index * (100 / visibleSlides)}%)`;
  }

  function nextSlide() {
    const visibleSlides = getVisibleSlides();
    index++;
    if (index > slides.length - visibleSlides) {
      index = 0;
    }
    updateSlider();
  }

  setInterval(nextSlide, 3000);
  window.addEventListener("resize", updateSlider); // resize par adjust
});

// blog slider end here



