<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "carrito"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    $TrdRsp = $Traducciones;

?>
<title><?= Trd(1); ?><?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/carrito.css">
<link rel="stylesheet" href="css/cart.css">

</head>
<body>
<?php 
  require_once ('nav.php');
  $Traducciones = $TrdRsp;
?>

<main class="wrap">
  
  <div id="cartActiveState" style="display: none;">
    
    <header class="cart-page-header">
      <h1><?= Trd(3); ?></h1>
      <a href="products/all"><?= Trd(4); ?></a>
    </header>

    <div class="cart-grid">
      
      <section class="cart-items-list" id="cartPageList">
        <div class="cart-table-header">
          <span><?= Trd(5); ?></span>
          <span style="text-align: center;"><?= Trd(6); ?></span>
          <span style="text-align: right;"><?= Trd(7); ?></span>
        </div>
        </section>

      <aside class="cart-summary-card">
        <h2><?= Trd(8); ?></h2>
        
        <div class="summary-row">
          <span class="summary-row-label"><?= Trd(9); ?></span>
          <span id="summarySubtotal">$0.00</span>
        </div>
        <div class="summary-row">
          <span class="summary-row-label"><?= Trd(10); ?></span>
          <span style="font-size: 0.82rem; color: var(--color-ink-soft);"><?= Trd(11); ?></span>
        </div>
        
        <div class="summary-row total">
          <span class="summary-row-label"><?= Trd(12); ?></span>
          <span id="summaryTotal">$0.00</span>
        </div>


        <div class="cart-checkout-actions">
          <?php
          if (isset($_SESSION['logged_in'])):          
          ?>
            <a href="<?= URL_BASE ?>/checkout">
            <button class="btn-primary" onclick=""><?= Trd(13); ?></button>
            </a>
          <?php
          else:
          ?>   
          <button class="btn-primary" onclick="openLoginModal()"><?= Trd(14); ?></button>
          <?php
          endif;
          ?>          
          
          <p class="tax-shipping-statement"><?= Trd(15); ?></p>
        </div>
      </aside>

    </div>
  </div>

  <div id="cartEmptyState" class="cart-empty-state" style="display: none;">
    <h2><?= Trd(16); ?></h2>
    <p><?= Trd(17); ?></p>
    <a href="<?= URL_BASE ?>/products/all" class="btn-primary"><?= Trd(18); ?></a>
  </div>

</main>

<?php 
  require_once('news.php');
  require_once('foot.php');
  require_once('cart.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="js/index.js"></script>

<script>
/* ============================================================
   LÓGICA DE SINCRONIZACIÓN Y RENDER DE LA PÁGINA DEL CARRITO
   ============================================================ */

// Inyección de traducciones para su uso en JS de forma segura
const trdProduct = "<?= Trd(5); ?>";
const trdQuantity = "<?= Trd(6); ?>";
const trdTotal = "<?= Trd(7); ?>";
const trdBajoPedido = "<?= Trd(19); ?>";
const trdEnStock = "<?= Trd(20); ?>";
const trdEliminar = "<?= Trd(21); ?>";
const trdAlertStock1 = "<?= Trd(22); ?>";
const trdAlertStock2 = "<?= Trd(23); ?>";

document.addEventListener('DOMContentLoaded', () => {
  // 1. Obtener los datos persistidos de LocalStorage
  let cart = JSON.parse(localStorage.getItem('brinca_cart')) || [];
  
  // Renderizar inicialmente al entrar a la página
  renderCartPage();

  function renderCartPage() {
    const activeState = document.getElementById('cartActiveState');
    const emptyState = document.getElementById('cartEmptyState');
    const pageList = document.getElementById('cartPageList');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryTotal = document.getElementById('summaryTotal');

    // Control de estados de la pantalla completa
    if (cart.length === 0) {
      activeState.style.display = 'none';
      emptyState.style.display = 'flex';
      $('.cart-count').text(0);
      return;
    }

    activeState.style.display = 'block';
    emptyState.style.display = 'none';

    // Limpiar filas viejas dejando únicamente la cabecera fija traducida
    const headerHTML = `
      <div class="cart-table-header">
        <span>${trdProduct}</span>
        <span style="text-align: center;">${trdQuantity}</span>
        <span style="text-align: right;">${trdTotal}</span>
      </div>
    `;
    pageList.innerHTML = headerHTML;

    let subtotalGeneral = 0;
    let totalItemsGlobal = 0;

    // Iterar e inyectar cada artículo guardado
    cart.forEach(item => {
      const itemTotal = item.price * item.quantity;
      subtotalGeneral += itemTotal;
      totalItemsGlobal += item.quantity;

      const priceFormatted = itemTotal.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
      const vendorStatus = item.onlyRequest ? trdBajoPedido : trdEnStock;

      const rowHTML = `
        <div class="cart-row" data-product-id="${item.id}">
          <div class="cart-product-cell">
            <img src="${item.image}" class="cart-product-img" alt="${item.name}">
            <div class="cart-product-info">
              <a href="../product/details?Idp=${item.id}" class="cart-product-title">${item.name}</a>
              <span class="cart-product-vendor">${vendorStatus}</span>
              <button class="btn-cart-remove" onclick="removeProductPage('${item.id}')">${trdEliminar}</button>
            </div>
          </div>
          <div style="display: flex; justify-content: center; align-items: center;">
            <div class="qty-selector">
              <button class="qty-btn" onclick="updateRowQtyPage('${item.id}', -1)">−</button>
              <input type="number" class="qty-input" value="${item.quantity}" min="1" readonly>
              <button class="qty-btn" onclick="updateRowQtyPage('${item.id}', 1)">+</button>
            </div>
          </div>
          <div class="cart-price-cell">${priceFormatted}</div>
        </div>
      `;
      pageList.insertAdjacentHTML('beforeend', rowHTML);
    });

    // Actualizar cajas de texto de totales
    const totalString = subtotalGeneral.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    if(summarySubtotal) summarySubtotal.textContent = totalString;
    if(summaryTotal) summaryTotal.textContent = totalString;

    // Actualizar el número de la bolsa flotante en el navbar simultáneamente
    $('.cart-count').text(totalItemsGlobal);
  }

  // Guardar cambios en el almacenamiento local
  function saveCart() {
    localStorage.setItem('brinca_cart', JSON.stringify(cart));
  }

  // EXPOSICIÓN GLOBAL DE FUNCIONES DE CONTROL DE INTERACCIÓN
  
  // 1. Modificar cantidad desde los botones +/- de la tabla
  window.updateRowQtyPage = function(productId, val) {
    const item = cart.find(i => i.id === productId);
    if (!item) return;

    let targetQty = item.quantity + val;

    // Validación de decremento mínimo
    if (targetQty < 1) {
      window.removeProductPage(productId);
      return;
    }

    // Validación estricta de stock si NO es bajo pedido
    if (!item.onlyRequest && targetQty > item.maxStock) {
      alert(`${trdAlertStock1}${item.maxStock}${trdAlertStock2}`);
      return;
    }

    item.quantity = targetQty;
    saveCart();
    renderCartPage();

    // Sincronizar el popover lateral (cartDrawer) si estuviera incluido en esta página
    if (typeof window.renderCart === 'function') window.renderCart(); 
  };

  // 2. Eliminar producto completo desde el renglón
  window.removeProductPage = function(productId) {
    cart = cart.filter(i => i.id !== productId);
    saveCart();
    renderCartPage();

    if (typeof window.renderCart === 'function') window.renderCart();
  };
});
</script>
</body>
</html>