  // Mobile menu toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    const line3 = document.getElementById('line3');
    const body = document.body;
    
    function toggleMobileMenu() {
        const isOpen = !mobileMenu.classList.contains('-translate-y-full');
        
        if (isOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }
    
    function openMobileMenu() {
        mobileMenu.classList.remove('-translate-y-full');
        mobileOverlay.classList.remove('hidden');
        body.classList.add('overflow-hidden');
        
        // Hamburger animation
        line1.classList.add('rotate-45', 'translate-y-2');
        line2.classList.add('opacity-0');
        line3.classList.add('-rotate-45', '-translate-y-3');
    }
    
    function closeMobileMenu() {
        mobileMenu.classList.add('-translate-y-full');
        mobileOverlay.classList.add('hidden');
        body.classList.remove('overflow-hidden');
        
        // Hamburger animation
        line1.classList.remove('rotate-45', 'translate-y-2');
        line2.classList.remove('opacity-0');
        line3.classList.remove('-rotate-45', '-translate-y-3');
        
        // Close submenu if open
        const submenu = document.getElementById('research-submenu');
        const arrow = document.getElementById('submenu-arrow');
        submenu.classList.add('max-h-0');
        submenu.classList.remove('max-h-40');
        arrow.classList.remove('rotate-180');
    }
    
    menuBtn.addEventListener('click', toggleMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);
    
    // Research submenu toggle
    function toggleSubmenu() {
        const submenu = document.getElementById('research-submenu');
        const arrow = document.getElementById('submenu-arrow');
        
        submenu.classList.toggle('max-h-0');
        submenu.classList.toggle('max-h-40');
        arrow.classList.toggle('rotate-180');
    }


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

arrangeSlides();
setInterval(nextSlide, 2000);

// handle resize dynamically
window.addEventListener("resize", arrangeSlides);
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
