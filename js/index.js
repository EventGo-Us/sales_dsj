
// BUSQUEDA
const mobileSearchToggle = document.getElementById('mobileSearchToggle');
const searchBarContainer = document.getElementById('searchBarContainer');

if (mobileSearchToggle && searchBarContainer) {
  mobileSearchToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    
    // Si el menú móvil lateral está abierto, lo cerramos primero
    if (typeof closeNav === "function") {
      closeNav();
    }
    
    // Alternar visibilidad de la barra de búsqueda
    searchBarContainer.classList.toggle('open');
  });

  // Evitar que hacer clic dentro de la barra de búsqueda cierre el componente indeseadamente
  searchBarContainer.addEventListener('click', (e) => {
    e.stopPropagation();
  });
}

// Modificar tu función closeNav() existente para asegurar que también cierre la búsqueda al interactuar fuera
const originalCloseNav = closeNav;
closeNav = function() {
  if (typeof originalCloseNav === "function") originalCloseNav();
  if (searchBarContainer) searchBarContainer.classList.remove('open');
};



//MENU
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');
const navBackdrop = document.getElementById('navBackdrop');

function closeNav(){
  mainNav.classList.remove('open');
  navBackdrop.classList.remove('open');
  menuToggle.setAttribute('aria-expanded','false');
}

// Abrir y Cerrar Menú Móvil
menuToggle.addEventListener('click', (e) => {
  e.preventDefault();
  e.stopPropagation();
  const isOpen = mainNav.classList.toggle('open');
  navBackdrop.classList.toggle('open', isOpen);
  menuToggle.setAttribute('aria-expanded', String(isOpen));
});

// Cerrar al hacer clic en el fondo oscuro
navBackdrop.addEventListener('click', closeNav);

// Control de Submenús (Dropdowns) para Móvil y Escritorio
document.querySelectorAll('[data-dropdown]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    
    const parent = btn.closest('.has-dropdown');
    const wasOpen = parent.classList.contains('open');
    
    // Cerrar otros submenús que estén abiertos
    document.querySelectorAll('.has-dropdown.open').forEach(el => {
      if (el !== parent) el.classList.remove('open');
    });
    
    // Alternar el submenú actual
    if (wasOpen) {
      parent.classList.remove('open');
    } else {
      parent.classList.add('open');
    }
  });
});

// Cerrar submenús al hacer clic fuera (Útil en Desktop)
document.addEventListener('click', () => {
  document.querySelectorAll('.has-dropdown.open').forEach(el => el.classList.remove('open'));
});


// CONTROL DEL POPOVER DE "MI CUENTA"
const accountWrapper = document.getElementById('accountWrapper');
const accountBtn = document.getElementById('accountBtn');

if (accountBtn && accountWrapper) {
  accountBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    
    // Cerramos los dropdowns de navegación si estuvieran abiertos
    document.querySelectorAll('.has-dropdown.open').forEach(el => el.classList.remove('open'));
    
    // Alternamos el bocadillo actual
    accountWrapper.classList.toggle('open');
  });

  // Evitamos que dar click dentro del formulario lo cierre accidentalmente
  const accountPopover = document.getElementById('accountPopover');
  if (accountPopover) {
    accountPopover.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }
}

// Modificar tu detector global existente de "click fuera" para que también cierre Mi Cuenta
document.addEventListener('click', () => {
  document.querySelectorAll('.has-dropdown.open').forEach(el => el.classList.remove('open'));
  if (accountWrapper) accountWrapper.classList.remove('open');
});


const cartWrapper = document.getElementById('cartWrapper');
const openCartBtn = document.getElementById('openCartBtn');
const cartDrawer = document.getElementById('cartDrawer');

if (openCartBtn && cartWrapper) {
  openCartBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    
    // Cerramos el menú de cuenta si estuviera abierto
    const accountWrapper = document.getElementById('accountWrapper');
    if (accountWrapper) accountWrapper.classList.remove('open');
    
    // Alternamos el carrito
    cartWrapper.classList.toggle('open');
  });

  // Evitar que dar clic dentro del carrito lo cierre solo
  if (cartDrawer) {
    cartDrawer.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }
}

// Actualizar el cierre general haciendo clic afuera
document.addEventListener('click', () => {
  if (cartWrapper) cartWrapper.classList.remove('open');
});

const langWrapper = document.getElementById('langWrapper');
const langBtn = document.getElementById('langBtn');

// Alternar dropdown al dar clic
langBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  langWrapper.classList.toggle('open');
  
  // Cerrar otros menús si estuvieran abiertos
  if(typeof closeNav === 'function') closeNav();
  document.querySelectorAll('.has-dropdown.open').forEach(el => el.classList.remove('open'));
});

// Cerrar si hace clic fuera del componente
document.addEventListener('click', () => {
  langWrapper.classList.remove('open');
});


    $('.lang-option').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: url_base + '/change_lng.php',
            type: 'POST',
            data: { lang: $(this).data('lang') },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Recargamos para que el servidor lea la nueva sesión de idioma
                    location.reload(); 
                }
            }
        });
        
    });

// CARRUSEL DEL BANNER
const bannerCarousel = document.querySelector('.banner-carousel');

if (bannerCarousel) {
  const slides = Array.from(bannerCarousel.querySelectorAll('.banner-slide'));
  const indicators = Array.from(bannerCarousel.querySelectorAll('.banner-indicator'));
  let activeSlide = 0;
  let carouselTimer;

  const showSlide = (index) => {
    activeSlide = index;
    slides.forEach((slide, slideIndex) => {
      const isActive = slideIndex === activeSlide;
      slide.classList.toggle('is-active', isActive);
      slide.setAttribute('aria-hidden', String(!isActive));
      indicators[slideIndex].classList.toggle('is-active', isActive);
      indicators[slideIndex].setAttribute('aria-pressed', String(isActive));
    });
  };

  const stopCarousel = () => {
    window.clearInterval(carouselTimer);
  };

  const startCarousel = () => {
    stopCarousel();
    if (!document.hidden && !bannerCarousel.matches(':hover') && !bannerCarousel.contains(document.activeElement)) {
      carouselTimer = window.setInterval(() => {
        showSlide((activeSlide + 1) % slides.length);
      }, 5000);
    }
  };

  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
      showSlide(index);
      startCarousel();
    });
  });

  bannerCarousel.addEventListener('mouseenter', stopCarousel);
  bannerCarousel.addEventListener('mouseleave', startCarousel);
  bannerCarousel.addEventListener('focusin', stopCarousel);
  bannerCarousel.addEventListener('focusout', (event) => {
    if (!bannerCarousel.contains(event.relatedTarget)) {
      startCarousel();
    }
  });
  document.addEventListener('visibilitychange', startCarousel);
  startCarousel();
}
