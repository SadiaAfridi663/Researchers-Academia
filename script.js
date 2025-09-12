
        // HAMBURGER start
        const menuBtn = document.getElementById( "menu-btn" );
        const mobileMenu = document.getElementById( "mobile-menu" );

        menuBtn.addEventListener( "click", () => {
            mobileMenu.classList.toggle( "-translate-y-full" );
            mobileMenu.classList.toggle( "translate-y-0" );
        } );
        // HAMBURGER END