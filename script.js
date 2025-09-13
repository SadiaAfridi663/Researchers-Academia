
  
const menuBtn = document.getElementById("menu-btn");
const mobileMenu = document.getElementById("mobile-menu");

menuBtn.addEventListener("click", () => {
  // toggle mobile menu
  mobileMenu.classList.toggle("-translate-y-full");
  mobileMenu.classList.toggle("translate-y-0");

  // toggle open class for hamburger
  menuBtn.classList.toggle("open");
});








    //    team page hero slider start here
        const slides = document.querySelectorAll( '.team-slide' );
        let current = 0;

        function arrangeSlides() {
            slides.forEach( ( slide, i ) => {
                const offset = ( i - current + slides.length ) % slides.length;

                slide.style.zIndex = slides.length - offset;

                slide.style.opacity = 1;

                // Position slides stacked
                if ( offset === 0 ) {
                    slide.style.transform = `translateX(0) scale(1)`;
                    slide.classList.add( 'shadow-2xl' );
                } else {
                    const translateX = offset * 70; 
                    const scale = 1 - ( offset * 0.08 );
                    slide.style.transform = `translateX(${ translateX }px) scale(${ scale })`;
                    slide.classList.remove( 'shadow-2xl' );
                }
            } );
        }

        function nextSlide() {
            current = ( current + 1 ) % slides.length;
            arrangeSlides();
        }

        arrangeSlides();

        setInterval( nextSlide, 2000 );
    //    team page hero slider start here
