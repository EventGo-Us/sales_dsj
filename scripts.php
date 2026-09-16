<?php
$TrdRsp = $Traducciones;
$api_url = URL_API."Traducciones_web_sales";
$data = json_encode(['program' => "scripts"]);
$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const token = "<?php echo $jwt;?>"; 
    const url_api ="<?php echo URL_API;?>"
    const url_images ="<?php echo URL_IMAGES;?>"
    const id_client ="<?= ID_CLIENT ?>" 
    //const CURRENCY_ ="" 
    const url_base = "<?= URL_BASE ?>";

/* Configuración de traducciones globales mapeadas desde la base de datos */
const coreTranslations = {
  cartEmptyMsg: `<?= Trd(1); ?>`,
  qtyLabel: `<?= Trd(2); ?>`,
  btnRemove: `<?= Trd(3); ?>`,
  invalidQtyTitle: `<?= Trd(4); ?>`,
  invalidQtyText1: `<?= Trd(5); ?>`,
  invalidQtyText2: `<?= Trd(6); ?>`,
  btnCorrectQty: `<?= Trd(7); ?>`,
  txtVerifying: `<?= Trd(8); ?>`,
  loginWelcomeTitle: `<?= Trd(9); ?>`,
  loginErrorTitle: `<?= Trd(10); ?>`,
  loginErrorDefaultText: `<?= Trd(11); ?>`,
  btnGotIt: `<?= Trd(12); ?>`,
  connErrorTitle: `<?= Trd(13); ?>`,
  connErrorText: `<?= Trd(14); ?>`
};

// ============================================================
// LÓGICA CORE DEL CARRITO (DISPONIBLE EN TODOS LOS PROGRAMAS)
// ============================================================

// 1. Instancia global del estado del carrito
let cart = JSON.parse(localStorage.getItem('brinca_cart')) || [];

// 2. Guardar datos actuales en LocalStorage
function saveCart() {
  localStorage.setItem('brinca_cart', JSON.stringify(cart));
}

// 3. Renderizar dinámicamente los elementos en el Popover/Drawer lateral
function renderCart() {
  const cartBody = document.getElementById('cartDrawerBody');
  const cartSubtotal = document.getElementById('cartSubtotal');
  
  if (!cartBody) return;
  cartBody.innerHTML = ''; // Limpiamos la estructura vieja

  if (cart.length === 0) {
    cartBody.innerHTML = `<p class="cart-empty-msg" style="text-align:center; color:#777; padding:20px;">${coreTranslations.cartEmptyMsg}</p>`;
    if (cartSubtotal) cartSubtotal.textContent = '$0.00';
    $('.cart-count').text(0); // Forzar a 0 si está vacío
    return;
  }

  let subtotal = 0;

  cart.forEach(item => {
    const itemTotal = item.price * item.quantity;
    subtotal += itemTotal;

    const priceFormatted = item.price.toLocaleString('en-US', { style: 'currency', currency: 'USD' });

    const itemHTML = `
      <div class="cart-item" data-id="${item.id}">
        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
        <div class="cart-item-details">
          <span class="cart-item-title">${item.name}</span>
          <div class="cart-qty-control-inline" style="margin: 4px 0;">
            <span class="cart-item-qty">${coreTranslations.qtyLabel}<strong>${item.quantity}</strong></span>
            <button class="btn-qty-mini" onclick="changeQtyInCart('${item.id}', -1)">−</button>
            <button class="btn-qty-mini" onclick="changeQtyInCart('${item.id}', 1)">+</button>
          </div>
          <span class="cart-item-price">${priceFormatted}</span>
          <button class="btn-remove-item" onclick="removeFromCart('${item.id}')">${coreTranslations.btnRemove}</button>
        </div>
      </div>
    `;
    cartBody.insertAdjacentHTML('beforeend', itemHTML);
  });

  if (cartSubtotal) {
    cartSubtotal.textContent = subtotal.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
  }

  // Actualiza los contadores en cualquier parte de la pantalla (.cart-count)
  const totalPiezas = cart.reduce((sum, item) => sum + item.quantity, 0);
  $('.cart-count').text(totalPiezas);    
}

// 4. Funciones expuestas a los eventos inline de los botones del drawer
window.removeFromCart = function(id) {
  cart = cart.filter(item => item.id !== id);
  saveCart();
  renderCart();

  // Si estás en carrito.php o checkout.php, sincroniza sus vistas nativas si existen
  if (typeof renderCartPage === 'function') renderCartPage();
  if (typeof renderCheckoutSummary === 'function') renderCheckoutSummary();
};

window.changeQtyInCart = function(id, val) {
  const item = cart.find(item => item.id === id);
  if (item) {
    let targetQty = item.quantity + val;
    if (targetQty < 1) {
      window.removeFromCart(id);
      return;
    }
    if (!item.onlyRequest && targetQty > item.maxStock) {

          Swal.fire({
            title: coreTranslations.invalidQtyTitle,
            text: `${coreTranslations.invalidQtyText1}${item.maxStock}${coreTranslations.invalidQtyText2}`,
            icon: 'warning',
            confirmButtonText: coreTranslations.btnCorrectQty,
            customClass: {
              confirmButton: 'swal2-confirm'
            }
          });      

      return;
    }
    item.quantity = targetQty;
    saveCart();
    renderCart();

    // Sincroniza las páginas principales en caso de estar abiertas
    if (typeof renderCartPage === 'function') renderCartPage();
    if (typeof renderCheckoutSummary === 'function') renderCheckoutSummary();
  }
};    


$(document).ready(function() {
  renderCart();
});


//LOGIN MODAL

const loginModal = document.getElementById('loginModal');
const loginModalBackdrop = document.getElementById('loginModalBackdrop');

// Función para ABRIR el modal de inicio de sesión
function openLoginModal() {
  // Limpiar el formulario cada vez que se abra por experiencia de usuario
  document.getElementById('loginForm_md').reset();
  loginModalBackdrop.classList.add('open');
  loginModal.classList.add('open');
}

// Función para CERRAR el modal
function closeLoginModal() {
  loginModalBackdrop.classList.remove('open');
  loginModal.classList.remove('open');
}

// Inicializar eventos de cierre cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById('closeLoginModalBtn').addEventListener('click', closeLoginModal);
  loginModalBackdrop.addEventListener('click', closeLoginModal);
});

// --- EJEMPLO DE USO INTERACTIVO ---
// Puedes llamarlo directamente desde un atributo HTML en tus botones del Nav:
// <button onclick="openLoginModal()">Iniciar Sesión</button>


///PROCESO LOGIN 

function processLoginAPI(event,frm) {
  event.preventDefault();

  const form = document.getElementById('loginForm'+frm);
  const btnSubmit = document.getElementById('btnLoginSubmit'+frm);
  
  // Deshabilitar botón para evitar multi-envíos (Loading UI)
  btnSubmit.disabled = true;
  const originalText = btnSubmit.textContent;
  btnSubmit.textContent = coreTranslations.txtVerifying;

  // Recolectar datos del formulario de forma automática
  const formData = $(form).serialize(); 

  $.ajax({
    url: url_base+'/login_process.php', // Apunta al archivo PHP que procesará el login
    type: 'POST',
    data: formData,
    dataType: 'json', 
    success: function(response) {
      if (response.success) {
        Swal.fire({
          title: coreTranslations.loginWelcomeTitle,
          text: response.message,
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          // Redirección tras el éxito del login
          if (frm == '_md')
              location.reload();
          else
            window.location.href = url_base+"/products/all"; 
        });
      } else {
        // Credenciales incorrectas o error controlado
        Swal.fire({
          title: coreTranslations.loginErrorTitle,
          text: response.message || coreTranslations.loginErrorDefaultText,
          icon: 'error',
          confirmButtonText: coreTranslations.btnGotIt,
          customClass: {
            confirmButton: 'swal2-confirm'
          }
        });
        
        // Reactivar botón
        btnSubmit.disabled = false;
        btnSubmit.textContent = originalText;
      }
    },
    error: function(xhr, status, error) {
      Swal.fire({
        title: coreTranslations.connErrorTitle,
        text: coreTranslations.connErrorText,
        icon: 'error',
        confirmButtonText: coreTranslations.btnGotIt,
        customClass: {
          confirmButton: 'swal2-confirm'
        }
      });

      // Restaurar el botón
      btnSubmit.disabled = false;
      btnSubmit.textContent = originalText;
    }
  });
}

document.addEventListener("DOMContentLoaded", function() {
    // 1. Evitar que todo el menú principal se cierre al hacer clic dentro del dropdown de productos
    const mainDropdown = document.querySelector('.dropdown');
    if (mainDropdown) {
        mainDropdown.addEventListener('click', function(e) {
            // Esto evita que el clic "suba" al botón principal o al documento
            e.stopPropagation(); 
        });
    }

    // 2. Controlar la apertura de las subcategorías en móviles
    const parentCategories = document.querySelectorAll('.dropdown li.has-submenu > a');

    parentCategories.forEach(categoryLink => {
        categoryLink.addEventListener('click', function(e) {
            // Detectamos si estamos en un dispositivo móvil/pantalla chica
            if (window.innerWidth <= 991) {
                const parentLi = this.parentElement;
                
                // Si el submenú NO está abierto, detenemos el enlace y lo desplegamos
                if (!parentLi.classList.contains('open')) {
                    e.preventDefault(); 
                    e.stopPropagation(); // Detiene el clic aquí para que no cierre nada más
                    
                    // Cerramos otras subcategorías que estén abiertas para no amontonar
                    document.querySelectorAll('.dropdown li.has-submenu.open').forEach(li => {
                        if (li !== parentLi) li.classList.remove('open');
                    });
                    
                    // Abrimos la actual hacia abajo
                    parentLi.classList.add('open');
                } 
                // Si ya tiene la clase '.open', el segundo clic te llevará a la categoría normal
            }
        });
    });
});
</script>

<?php

 $Traducciones = $TrdRsp;

?>