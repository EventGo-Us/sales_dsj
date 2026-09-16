<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "profile"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    $TrdRsp = $Traducciones;
?>
<title><?= Trd(1) ?> — <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2) ?> <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<link rel="stylesheet" href="css/index.css">
<style>
/* ============================================================
   0. TOKENS — Consistentes con <?= COMPANY_NAME ?>
   ============================================================ */
:root{
  
  --radius-sm: 4px;
  --radius-md: 8px;
  --container: 1120px;
}

/* ============================================================
   1. RESET + BASE
   ============================================================ */
*,*::before,*::after{ box-sizing:border-box; }
body{
  margin:0; font-family:var(--font); color:var(--color-ink); background:var(--color-bg);
  -webkit-font-smoothing:antialiased; font-size:15px; line-height:1.5;
}
.wrap{ max-width:var(--container); margin:0 auto; padding:0 24px; }
a{ color:inherit; text-decoration:none; }
button{ font:inherit; cursor:pointer; background:none; border:none; }
h1{ font-size:1.8rem; font-weight:800; letter-spacing:-0.02em; margin:0; }
h2{ font-size:1.25rem; font-weight:700; margin:0 0 20px 0; letter-spacing:-0.01em; }
p{ margin:0; }

/* ============================================================
   2. DISTRIBUCIÓN DEL PANEL (LAYOUT)
   ============================================================ */
.account-header {
  padding: 40px 0 24px;
  border-bottom: 1px solid var(--color-line);
  margin-bottom: 32px;
}
.account-layout {
  display: grid;
  grid-template-columns: 240px 1fr;
  gap: 48px;
  align-items: start;
  margin-bottom: 60px;
}

/* Menú Lateral de Navegación */
.account-nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.nav-tab-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--color-ink-soft);
  border-radius: var(--radius-sm);
  text-align: left;
  transition: background 0.15s ease, color 0.15s ease;
}
.nav-tab-btn:hover {
  background: var(--color-bg-soft);
  color: var(--color-ink);
}
.nav-tab-btn.active {
  background: var(--color-bg-soft);
  color: var(--color-brand);
}
.nav-tab-btn.btn-logout {
  margin-top: 20px;
  border-top: 1px solid var(--color-line);
  padding-top: 16px;
  color: #DC2626;
}
.nav-tab-btn.btn-logout:hover {
  background: #FEF2F2;
}

/* Paneles de Contenido */
.account-panel {
  display: none; /* Ocultos por defecto, activados por JS */
}
.account-panel.active {
  display: block;
}

/* ============================================================
   3. COMPONENTES INTERNOS DE LOS PANELES
   ============================================================ */

/* Formulario de Perfil */
.profile-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
  max-width: 600px;
}
.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}
.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.form-group label {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--color-ink-soft);
}
.form-group input, .form-group select {
  font-family: var(--font);
  font-size: 0.9rem;
  padding: 10px 14px;
  border: 1px solid var(--color-line-strong);
  border-radius: var(--radius-sm);
  outline: none;
  background: var(--color-bg);
}
.form-group input:focus, .form-group select:focus {
  border-color: var(--color-brand);
}
.btn-save {
  background: var(--color-brand);
  color: #FFFFFF;
  padding: 10px 24px;
  font-size: 0.88rem;
  font-weight: 600;
  border-radius: var(--radius-sm);
  align-self: flex-start;
  margin-top: 8px;
}

/* Órdenes / Pedidos */
.orders-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.order-card {
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.order-card-header {
  background: var(--color-bg-soft);
  padding: 16px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  border-bottom: 1px solid var(--color-line);
  font-size: 0.85rem;
}
.order-meta-grid {
  display: flex;
  gap: 28px;
}
.meta-item {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.meta-item span:first-child {
  color: var(--color-ink-soft);
  font-weight: 500;
  font-size: 0.78rem;
}
.meta-item span:last-child {
  font-weight: 600;
}
.order-badge {
  padding: 4px 10px;
  font-size: 0.75rem;
  font-weight: 700;
  border-radius: 50px;
}
.order-badge.process { background: #FEF3C7; color: var(--color-alert); }
.order-badge.success { background: #DCFCE7; color: var(--color-success); }

.order-card-body {
  padding: 20px;
}
.order-product-row {
  display: flex;
  align-items: center;
  gap: 16px;
}
.order-product-img {
  width: 60px;
  height: 60px;
  border: 1px solid var(--color-line);
  border-radius: var(--radius-sm);
  object-fit: cover;
}
.order-product-info {
  flex: 1;
}
.order-product-title {
  font-weight: 600;
  font-size: 0.9rem;
  display: block;
}
.order-product-qty {
  font-size: 0.8rem;
  color: var(--color-ink-soft);
}

/* Tarjetas de Direcciones */
.address-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}
.address-card {
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: relative;
}
.address-card.default {
  border-color: var(--color-brand);
}
.address-badge {
  position: absolute;
  top: 16px;
  right: 16px;
  font-size: 0.7rem;
  background: var(--color-bg-soft);
  padding: 2px 8px;
  border-radius: 4px;
  font-weight: 600;
  color: var(--color-brand);
  border: 1px solid var(--color-line-strong);
}
.address-card p {
  font-size: 0.88rem;
  color: #2D3139;
  line-height: 1.6;
}
.address-card h3 {
  font-size: 0.95rem;
  font-weight: 700;
  margin: 0 0 10px 0;
}
.address-actions {
  margin-top: 16px;
  display: flex;
  gap: 14px;
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--color-brand);
}
.address-actions button:hover {
  text-decoration: underline;
}
.btn-add-address {
  border: 2px dashed var(--color-line-strong);
  border-radius: var(--radius-md);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 30px;
  color: var(--color-ink-soft);
  font-weight: 600;
  font-size: 0.9rem;
  transition: border-color 0.15s ease, color 0.15s ease;
}
.btn-add-address:hover {
  border-color: var(--color-brand);
  color: var(--color-brand);
}

/* ============================================================
   4. RESPONSIVO MÓVIL
   ============================================================ */
@media (max-width: 840px) {
  .account-layout {
    grid-template-columns: 1fr; /* Una sola columna vertical */
    gap: 32px;
  }
  .account-nav {
    flex-direction: row; /* Menú horizontal tipo pestañas superiores */
    overflow-x: auto;
    border-bottom: 1px solid var(--color-line);
    padding-bottom: 8px;
    gap: 8px;
  }
  .nav-tab-btn {
    white-space: nowrap;
    padding: 8px 14px;
  }
  .nav-tab-btn.btn-logout {
    margin-top: 0;
    border-top: none;
    padding-top: 8px;
  }
  .address-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 540px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}


/* ============================================================
   ESTILOS DEL MODAL DE ELIMINACIÓN (DESTRUCTIVO)
   ============================================================ */
/* Nota: Reutiliza el .modal-backdrop anterior si lo deseas, o usa el id específico */
#deleteModalBackdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(22, 24, 29, 0.4);
  backdrop-filter: blur(4px);
  z-index: 210; /* Ligeramente superior si es necesario */
  display: none;
}
#deleteModalBackdrop.open { display: block; }

.delete-modal {
  position: fixed;
  top: 50%; left: 50%;
  transform: translate(-50%, -46%) scale(0.97);
  width: 100%; max-width: 400px; /* Más angosto y compacto que el de captura */
  background: var(--color-bg, #FFFFFF);
  border: 1px solid var(--color-line, #E6E6E2);
  border-radius: var(--radius-md, 8px);
  box-shadow: 0 20px 40px -10px rgba(22, 24, 29, 0.3);
  z-index: 211;
  display: none;
  opacity: 0;
  transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
}
.delete-modal.open {
  display: block;
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
}

.delete-modal-content {
  padding: 32px 24px 24px 24px;
  text-align: center;
}

/* Ícono de Alerta Rojo Suave */
.delete-icon-alert {
  width: 48px; height: 48px;
  background: #FEE2E2; /* Rojo muy tenue */
  color: #DC2626; /* Rojo oscuro */
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px auto;
}
.delete-icon-alert svg { width: 24px; height: 24px; }

.delete-modal h2 {
  font-size: 1.15rem; font-weight: 700; color: var(--color-ink, #16181D);
  margin: 0 0 8px 0; letter-spacing: -0.01em;
}
.delete-modal-text {
  font-size: 0.88rem; line-height: 1.5; color: var(--color-ink-soft, #6B7077);
  margin: 0 0 24px 0;
}

/* Botones alineados horizontalmente al 100% */
.delete-modal-actions {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
}
.btn-delete-cancel {
  padding: 10px; font-size: 0.88rem; font-weight: 600;
  border: 1px solid var(--color-line-strong, #D6D6D1); border-radius: var(--radius-sm, 4px);
  color: var(--color-ink-soft, #6B7077); background: none;
  cursor: pointer;
}
.btn-delete-cancel:hover { background: var(--color-bg-soft, #F7F7F5); color: var(--color-ink, #16181D); }

.btn-delete-confirm {
  padding: 10px; font-size: 0.88rem; font-weight: 700;
  background: #DC2626; color: #FFFFFF; border: none;
  border-radius: var(--radius-sm, 4px); cursor: pointer;
  transition: background 0.15s ease;
}
.btn-delete-confirm:hover { background: #B91C1C; }

/* En móviles pequeños se mantiene centrado */
@media (max-width: 440px) {
  .delete-modal { width: calc(100% - 32px); }
}

</style>
<link rel="stylesheet" href="css/cart.css">

</head>

<body>
<?php 
  require_once ('nav.php');
  $Traducciones = $TrdRsp;
?>

<div class="wrap">
  
  <header class="account-header">
    <h1><?= Trd(1) ?></h1>
    <p style="color: var(--color-ink-soft); font-size: 0.9rem; margin-top: 4px;"><?= Trd(3) ?></p>
  </header>

  <div class="account-layout">
    
    <nav class="account-nav" aria-label="Menú de usuario">
      <button class="nav-tab-btn active" data-target="panel-profile"><?= Trd(4) ?></button>
      <button class="nav-tab-btn" data-target="panel-process"><?= Trd(5) ?></button>
      <button class="nav-tab-btn" data-target="panel-history"><?= Trd(6) ?></button>
      <button class="nav-tab-btn" data-target="panel-addresses"><?= Trd(7) ?></button>
      <button class="nav-tab-btn btn-logout" onclick="handleLogout()"><?= Trd(8) ?></button>
    </nav>

    <main class="account-content">
      
      <section class="account-panel active" id="panel-profile">
        <h2><?= Trd(4) ?></h2>
        <form action="#" method="POST" class="profile-form" id="profileForm">
          <div class="form-row">
            <div class="form-group">
              <label for="profName"><?= Trd(9) ?></label>
              <input type="text" id="profName" value="Juan" required>
            </div>
            <div class="form-group">
              <label for="profLastName"><?= Trd(10) ?></label>
              <input type="text" id="profLastName" value="Pérez" required>
            </div>
          </div>
          <div class="form-group">
            <label for="profEmail"><?= Trd(11) ?></label>
            <input type="email" id="profEmail" value="juan.perez@correo.com" required readonly>
          </div>
          <div class="form-group">
            <label for="profPhone"><?= Trd(12) ?></label>
            <input type="tel" id="profPhone" value="3312345678" required>
          </div>
          <button type="submit" class="btn-save"><?= Trd(13) ?></button>
        </form>
      </section>

      <section class="account-panel" id="panel-process">
        <h2><?= Trd(5) ?></h2>
        <div class="orders-list" id='processOrdersContainer'>
        </div>
      </section>

      <section class="account-panel" id="panel-history">
        <h2><?= Trd(6) ?></h2>
        <div class="orders-list" id='historyOrdersContainer'>
        </div>
      </section>

      <section class="account-panel" id="panel-addresses">
        <h2><?= Trd(7) ?></h2>
        <div class="address-grid" id="addressesContainer">
          
          <button class="btn-add-address" onclick="openAddressModal('add')">
            <span style="font-size: 1.5rem; line-height:1;">+</span>
            <?= Trd(15) ?>
          </button>

        </div>
      </section>

    </main>
  </div>
</div>

<div class="modal-backdrop" id="addressModalBackdrop"></div>
<div class="address-modal" id="addressModal" role="dialog" aria-hidden="true" aria-labelledby="modalTitle">
  
  <div class="modal-header">
    <h2 id="modalTitle"><?= Trd(19) ?></h2>
    <button class="btn-close-modal" id="closeModalBtn" aria-label="Cerrar modal">&times;</button>
  </div>

  <form action="#" method="POST" id="addressForm" class="modal-body">
    <input type="hidden" id="addressId" name="address_id" value="">

    <div class="form-group full-width">
      <label for="adrAlias"><?= Trd(21) ?></label>
      <input type="text" id="adrAlias" name="alias" required placeholder="Ej. Bodega Principal, Sucursal Norte, Casa">
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="adrCity"><?= Trd(22) ?></label>
        <input type="text" id="adrCity" name="city" required placeholder="Ej. Zapopan">
      </div>
    </div>    

    <div class="form-group full-width">
      <label for="adrStreet"><?= Trd(23) ?></label>
      <input type="text" id="adrStreet" name="street" required placeholder="Ej. Av. Industria 1242, Bodega 4B">
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="adrColonia"><?= Trd(24) ?></label>
        <input type="text" id="adrColonia" name="colonia" required placeholder="Ej. Altagracia">
      </div>
      <div class="form-group">
        <label for="adrZip"><?= Trd(25) ?></label>
        <input type="text" id="adrZip" name="zip" required placeholder="45100" maxlength="5" pattern="[0-9]{5}">
      </div>
    </div>


    <div class="form-row">
      <div class="form-group">
        <label for="adrCntry"><?= Trd(26) ?></label>
        <select id="adrCntry" name="Country" required>
          <option value="" disabled selected><?= Trd(27) ?></option>
          <option value="MX">México</option>
          <option value="USA">United States</option>
        </select>
      </div>

      <div class="form-group">
        <label for="adrState"><?= Trd(28) ?></label>
        <select id="adrState" name="state" required disabled>
          <option value="" disabled selected><?= Trd(29) ?></option>
        </select>
      </div>
    </div>


    <div class="form-group full-width">
      <label for="adrReferences"><?= Trd(30) ?></label>
      <textarea id="adrReferences" name="references" placeholder="Ej. Portón color azul, entre Calle 3 y Calle 4, frente a la llantera..."></textarea>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn-cancel" id="cancelModalBtn"><?= Trd(31) ?></button>
      <button type="submit" class="btn-save"><?= Trd(32) ?></button>
    </div>
  </form>
</div>


<div class="modal-backdrop" id="deleteModalBackdrop"></div>
<div class="delete-modal" id="deleteModal" role="alertdialog" aria-hidden="true" aria-labelledby="deleteModalTitle">
  
  <div class="delete-modal-content">
    <div class="delete-icon-alert">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        <line x1="10" y1="11" x2="10" y2="17"></line>
        <line x1="14" y1="11" x2="14" y2="17"></line>
      </svg>
    </div>

    <h2 id="deleteModalTitle"><?= Trd(33) ?></h2>
    <p class="delete-modal-text"><?= Trd(34) ?></p>
    
    <input type="hidden" id="deleteTargetId" value="">
    <input type="hidden" id="deleteTargetType" value=""> <div class="delete-modal-actions">
      <button type="button" class="btn-delete-cancel" id="closeDeleteModalBtn"><?= Trd(31) ?></button>
      <button type="button" class="btn-delete-confirm" id="confirmDeleteBtn"><?= Trd(35) ?></button>
    </div>
  </div>
</div>


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
// Pasa los textos JS que necesitas dinámicamente desde PHP para respetar traducciones backend
const textNoOrders = <?= json_encode(Trd(14)) ?>;
const textNoDetails = <?= json_encode(Trd(36)) ?>;
const textQty = <?= json_encode(Trd(41)) ?>;
const textPrice = <?= json_encode(Trd(42)) ?>;
const textOrderPlaced = <?= json_encode(Trd(43)) ?>;
const textTotal = <?= json_encode(Trd(44)) ?>;
const textBalance = <?= json_encode(Trd(45)) ?>;
const textShippedTo = <?= json_encode(Trd(46)) ?>;
const textPrincipal = <?= json_encode(Trd(16)) ?>;
const textEdit = <?= json_encode(Trd(17)) ?>;
const textDelete = <?= json_encode(Trd(18)) ?>;
const titleEditAddress = <?= json_encode(Trd(20)) ?>;
const titleAddAddress = <?= json_encode(Trd(19)) ?>;

// ============================================================
// 1. CARGA INICIAL Y CONTROL DE PESTAÑAS (TABS)
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
  loadProfileData();
  loadOrders('process', '#processOrdersContainer');
  loadOrders('finish', '#historyOrdersContainer');
  loadAddresses();

  document.querySelectorAll('.nav-tab-btn[data-target]').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      document.querySelectorAll('.nav-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.account-panel').forEach(panel => panel.classList.remove('active'));
      
      button.classList.add('active');
      document.getElementById(targetId).classList.add('active');
    });
  });

  $('#profileForm').on('submit', function(e) {
    e.preventDefault();
    updateProfile();
  });

  $('#addressForm').on('submit', function(e) {
    e.preventDefault();
    saveAddress();
  });
});

// ============================================================
// 2. PETICIONES AJAX: PERFIL DE USUARIO
// ============================================================
function loadProfileData() {
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'GET',
    data: { action: 'get_profile' },
    dataType: 'json',
    success: function(res) {
      if(res.success) {
        $('#profName').val(res.data.firstname);
        $('#profLastName').val(res.data.lastname);
        $('#profEmail').val(res.data.email);
        $('#profPhone').val(res.data.phone);
      }
    }
  });
}

function updateProfile() {
  const btn = $('#profileForm button[type="submit"]');
  btn.disabled = true;

  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'POST',
    data: {
      action: 'update_profile',
      firstname: $('#profName').val(),
      lastname: $('#profLastName').val(),
      phone: $('#profPhone').val()
    },
    dataType: 'json',
    success: function(res) {
      if(res.success) {
        Swal.fire({ title: '¡Éxito!', text: res.message, icon: 'success', timer: 2000, showConfirmButton: false });
      } else {
        Swal.fire({ title: 'Error', text: res.message, icon: 'error', confirmButtonText: 'Entendido' });
      }
      btn.disabled = false;
    }
  });
}

// ============================================================
// 3. PETICIONES AJAX: ÓRDENES Y HISTORIAL
// ============================================================
function loadOrders(type, containerId) {
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'GET',
    data: { action: 'get_orders', type: type },
    dataType: 'json',
    success: function(res) {
      let html = '';
      
      if(res.success && res.data.length > 0) {
        res.data.forEach(order => {
          const badgeClass = type === 'process' ? 'process' : 'success';
          
          let products = [];
          try {
            products = typeof order.cart_json === 'string' ? JSON.parse(order.cart_json) : order.cart_json;
          } catch (e) {
            console.error("Error al parsear cart_json para la orden:", order, e);
          }

          let productsHtml = '';
          if (Array.isArray(products) && products.length > 0) {
            products.forEach(product => {
            const imgUrl = product.image || 'https://placehold.co/120'; 

              productsHtml += `
                <div class="order-product-row">
                  <img src="${imgUrl}" alt="Producto" class="order-product-img">
                  <div class="order-product-info">
                    <span class="order-product-title">${product.name}</span>
                    <span class="order-product-qty">${textQty} ${product.qty}</span>
                    <span class="order-product-price">${textPrice} $${parseFloat(product.price).toFixed(2)}</span>
                  </div>
                </div>`;
            });
          } else {
            productsHtml = `<div class="order-product-row"><p>${textNoDetails}</p></div>`;
          }

          html += `
            <div class="order-card">
              <div class="order-card-header">
                <div class="order-meta-grid">
                  <div class="meta-item"><span>${textOrderPlaced}</span><span>${order.FechaCreacion}</span></div>
                  <div class="meta-item"><span>${textTotal}</span><span>$${parseFloat(order.Total).toFixed(2)}</span></div>
                  <div class="meta-item"><span>${textBalance}</span><span>$${parseFloat(order.Balance).toFixed(2)}</span></div>
                  <div class="meta-item"><span>${textShippedTo}</span><span>${order.Ciudad}, ${order.Estado}</span></div>
                </div>
                <span class="order-badge ${badgeClass}">${order.status_p}</span>
              </div>
              <div class="order-card-body">
                ${productsHtml} 
              </div>
            </div>`;
        });
      } else {
        html = `<p style="color: var(--color-ink-soft); text-align:center; padding: 20px;">${textNoOrders}</p>`;
      }
      
      $(containerId).html(html);
    }
  });
}

// ============================================================
// 4. PETICIONES AJAX: GESTIÓN DE DIRECCIONES
// ============================================================
let localAddressesMemory = []; 

function loadAddresses() {
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'GET',
    data: { action: 'get_addresses' },
    dataType: 'json',
    success: function(res) {
      let html = '';
      if(res.success && res.data.length > 0) {
        localAddressesMemory = res.data; 
        res.data.forEach(addr => {
          const isDefault = addr.is_default == 1 ? 'default' : '';
          const badge = addr.is_default == 1 ? `<span class="address-badge">${textPrincipal}</span>` : '';
          
          html += `
            <div class="address-card ${isDefault}">
              ${badge}
              <h3>${escapeHTML(addr.alias)}</h3>
              <p>${escapeHTML(res.customer_name)}<br>${escapeHTML(addr.street)}<br>Col. ${escapeHTML(addr.colonia)}, CP ${escapeHTML(addr.zip)}<br>${escapeHTML(addr.city)}, ${escapeHTML(addr.state)}, ${escapeHTML(addr.country)}</p>
              <div class="address-actions">
                <button onclick="prepareEditAddress(${addr.id})">${textEdit}</button>
                <button onclick="openDeleteModal('${addr.id}', 'address')" style="color: var(--color-ink-soft);">${textDelete}</button>
              </div>
            </div>`;
        });
      }
      html += `
        <button class="btn-add-address" onclick="openAddressModal('add')">
          <span style="font-size: 1.5rem; line-height:1;">+</span> ${titleAddAddress}
        </button>`;
      
      $('#addressesContainer').html(html);
    }
  });
}

function prepareEditAddress(id) {
  const addressData = localAddressesMemory.find(a => a.id == id);
  if(addressData) {
    openAddressModal('edit', addressData);
  }
}

function saveAddress() {
  const id = $('#addressId').val();
  const mode = id ? 'update_address' : 'create_address';
  
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'POST',
    data: {
      action: mode,
      address_id: id,
      alias: $('#adrAlias').val(),
      country :$('#adrCntry').val(), 
      state: $('#adrState').val(),
      city: $('#adrCity').val(),
      street: $('#adrStreet').val(),
      colonia: $('#adrColonia').val(),
      zip: $('#adrZip').val(),
      references: $('#adrReferences').val()
    },
    dataType: 'json',
    success: function(res) {
      if(res.success) {
        Swal.fire({ title: '¡Guardado!', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
        closeAddressModal();
        loadAddresses(); 
      } else {
        Swal.fire({ title: 'Error', text: res.message, icon: 'error', confirmButtonText: 'Aceptar' });
      }
    }
  });
}

document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
  const idToDelete = document.getElementById('deleteTargetId').value;
  
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'POST',
    data: { action: 'delete_address', address_id: idToDelete },
    dataType: 'json',
    success: function(res) {
      closeDeleteModal();
      if(res.success) {
        Swal.fire({ title: 'Eliminado', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
        loadAddresses();
      } else {
        Swal.fire({ title: 'No permitido', text: res.message, icon: 'warning', confirmButtonText: 'Entendido' });
      }
    }
  });
});

function escapeHTML(str) {
  if(!str) return '';
  return str.replace(/[&<>'"]/g, tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag));
}

function handleLogout() {
  Swal.fire({
    title: <?= json_encode(Trd(37)) ?>,
    text: <?= json_encode(Trd(38)) ?>,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: 'var(--color-brand)',
    cancelButtonColor: '#6B7077',
    confirmButtonText: <?= json_encode(Trd(39)) ?>,
    cancelButtonText: <?= json_encode(Trd(31)) ?>
  }).then((result) => {
    if (result.isConfirmed) {
       window.location.href = 'logout.php';
    }
  });
}


const addressModal = document.getElementById('addressModal');
const addressModalBackdrop = document.getElementById('addressModalBackdrop');
const addressForm = document.getElementById('addressForm');
const modalTitle = document.getElementById('modalTitle');

function openAddressModal(mode = 'add', data = null) {
  addressForm.reset(); 
  document.getElementById('addressId').value = '';

  if (mode === 'edit' && data) {
    modalTitle.innerText = titleEditAddress;
    document.getElementById('addressId').value = data.id || '';
    document.getElementById('adrAlias').value = data.alias || '';
    document.getElementById('adrCntry').value = data.country || '';
    $('#adrCntry').trigger('change');
    document.getElementById('adrState').value = data.state || '';
    document.getElementById('adrCity').value = data.city || '';
    document.getElementById('adrStreet').value = data.street || '';
    document.getElementById('adrColonia').value = data.colonia || '';
    document.getElementById('adrZip').value = data.zip || '';
    document.getElementById('adrReferences').value = data.references || '';
  } else {
    modalTitle.innerText = titleAddAddress;
  }

  addressModalBackdrop.classList.add('open');
  addressModal.classList.add('open');
}

function closeAddressModal() {
  addressModalBackdrop.classList.remove('open');
  addressModal.classList.remove('open');
}

document.getElementById('closeModalBtn').addEventListener('click', closeAddressModal);
document.getElementById('cancelModalBtn').addEventListener('click', closeAddressModal);
addressModalBackdrop.addEventListener('click', closeAddressModal);

function editar(){
  const dataInfo = { id: '12', alias: 'Bodega Zapopan', state: 'Jalisco', city: 'Zapopan' };
  openAddressModal('edit', dataInfo);
}


const deleteModal = document.getElementById('deleteModal');
const deleteModalBackdrop = document.getElementById('deleteModalBackdrop');
const targetInputId = document.getElementById('deleteTargetId');
const targetInputType = document.getElementById('deleteTargetType');

function openDeleteModal(id, type = 'address') {
  targetInputId.value = id;
  targetInputType.value = type;
  
  deleteModalBackdrop.classList.add('open');
  deleteModal.classList.add('open');
}

function closeDeleteModal() {
  deleteModalBackdrop.classList.remove('open');
  deleteModal.classList.remove('open');
  targetInputId.value = '';
  targetInputType.value = '';
}

document.getElementById('closeDeleteModalBtn').addEventListener('click', closeDeleteModal);
deleteModalBackdrop.addEventListener('click', closeDeleteModal);

document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
  const idToDelete = targetInputId.value;
  const typeToDelete = targetInputType.value;

  console.log(`Eliminando ${typeToDelete} con ID: ${idToDelete}`);
  alert(<?= json_encode(Trd(40)) ?>);
  closeDeleteModal();
});


document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab'); 

  if (tabParam && tabParam !== 'profile') {
    const targetPanel = `panel-${tabParam}`;
    const targetButton = document.querySelector(`.nav-tab-btn[data-target="${targetPanel}"]`);
    
    if (targetButton) {
      document.querySelectorAll('.nav-tab-btn').forEach(btn => btn.classList.remove('active'));
      
      const profilePanel = document.getElementById('panel-profile');
      if (profilePanel) {
        profilePanel.classList.remove('active');
      }

      document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
      targetButton.classList.add('active');

      const panelElement = document.getElementById(targetPanel);
      if (panelElement) {
        panelElement.classList.add('active');
      }
    }
  }
});


$(document).ready(function() {
    // Los nombres de los estados se mantienen idénticos ya que son nombres propios geográficos locales.
    const estadosPorPais = {
        "MX": [
            { id: "AGU", nombre: "AGUASCALIENTES" },
            { id: "BCN", nombre: "BAJA CALIFORNIA" },
            { id: "BCS", nombre: "BAJA CALIFORNIA SUR" },
            { id: "CAM", nombre: "CAMPECHE" },
            { id: "COA", nombre: "COAHUILA DE ZARAGOZA" },
            { id: "COL", nombre: "COLIMA" },
            { id: "CHP", nombre: "CHIAPAS" },
            { id: "CHH", nombre: "CHIHUAHUA" },
            { id: "CMX", nombre: "CIUDAD DE MEXICO" },
            { id: "DUR", nombre: "DURANGO" },
            { id: "GUA", nombre: "GUANAJUATO" },
            { id: "GRO", nombre: "GUERRERO" },
            { id: "HID", nombre: "HIDALGO" },
            { id: "JAL", nombre: "JALISCO" },
            { id: "MEX", nombre: "MEXICO (ESTADO DE MEXICO)" },
            { id: "MIC", nombre: "MICHOACAN DE OCAMPO" },
            { id: "MOR", nombre: "MORELOS" },
            { id: "NAY", nombre: "NAYARIT" },
            { id: "NLE", nombre: "NUEVO LEON" },
            { id: "OAX", nombre: "OAXACA" },
            { id: "PUE", nombre: "PUEBLA" },
            { id: "QUE", nombre: "QUERETARO" },
            { id: "ROO", nombre: "QUINTANA ROO" },
            { id: "SLP", nombre: "SAN LUIS POTOSI" },
            { id: "SIN", nombre: "SINALOA" },
            { id: "SON", nombre: "SONORA" },
            { id: "TAB", nombre: "TABASCO" },
            { id: "TAM", nombre: "TAMAULIPAS" },
            { id: "TLA", nombre: "TLAXCALA" },
            { id: "VER", nombre: "VERACRUZ DE IGNACIO DE LA LLAVE" },
            { id: "YUC", nombre: "YUCATAN" },
            { id: "ZAC", nombre: "ZACATECAS" },
            { id: "CDMX", nombre: "MEXICO O CIUDAD DE MEXICO" }
        ],
        "USA": [
            { id: "AL", nombre: "ALABAMA" },
            { id: "AK", nombre: "ALASKA" },
            { id: "AZ", nombre: "ARIZONA" },
            { id: "AR", nombre: "ARKANSAS" },
            { id: "CA", nombre: "CALIFORNIA" },
            { id: "CO", nombre: "COLORADO" },
            { id: "CT", nombre: "CONNECTICUT" },
            { id: "DE", nombre: "DELAWARE" },
            { id: "FL", nombre: "FLORIDA" },
            { id: "GA", nombre: "GEORGIA" },
            { id: "HI", nombre: "HAWAII" },
            { id: "ID", nombre: "IDAHO" },
            { id: "IL", nombre: "ILLINOIS" },
            { id: "IN", nombre: "INDIANA" },
            { id: "IA", nombre: "IOWA" },
            { id: "KS", nombre: "KANSAS" },
            { id: "KY", nombre: "KENTUCKY" },
            { id: "LA", nombre: "LOUISIANA" },
            { id: "ME", nombre: "MAINE" },
            { id: "MD", module: "MARYLAND", nombre: "MARYLAND" },
            { id: "MA", nombre: "MASSACHUSETTS" },
            { id: "MI", module: "MICHIGAN", nombre: "MICHIGAN" },
            { id: "MN", nombre: "MINNESOTA" },
            { id: "MS", nombre: "MISSISSIPPI" },
            { id: "MO", nombre: "MISSOURI" },
            { id: "MT", nombre: "MONTANA" },
            { id: "NE", nombre: "NEBRASKA" },
            { id: "NV", nombre: "NEVADA" },
            { id: "NH", nombre: "NEW HAMPSHIRE" },
            { id: "NJ", nombre: "NEW JERSEY" },
            { id: "NM", nombre: "NEW MEXICO" },
            { id: "NY", nombre: "NEW YORK" },
            { id: "NC", nombre: "NORTH CAROLINA" },
            { id: "ND", nombre: "NORTH DAKOTA" },
            { id: "OH", nombre: "OHIO" },
            { id: "OK", nombre: "OKLAHOMA" },
            { id: "OR", nombre: "OREGON" },
            { id: "PA", nombre: "PENNSYLVANIA" },
            { id: "RI", nombre: "RHODE ISLAND" },
            { id: "SC", nombre: "SOUTH CAROLINA" },
            { id: "SD", nombre: "SOUTH DAKOTA" },
            { id: "TN", nombre: "TENNESSEE" },
            { id: "TX", nombre: "TEXAS" },
            { id: "UT", nombre: "UTAH" },
            { id: "VT", nombre: "VERMONT" },
            { id: "VA", nombre: "VIRGINIA" },
            { id: "WA", nombre: "WASHINGTON" },
            { id: "WV", nombre: "WEST VIRGINIA" },
            { id: "WI", nombre: "WISCONSIN" },
            { id: "WY", nombre: "WYOMING" }
        ]
    };

    $('#adrCntry').on('change', function() {
        const paisSeleccionado = $(this).val();
        const $selectState = $('#adrState');

        $selectState.empty().append($('<option>', {
            value: "",
            disabled: true,
            selected: true,
            text: <?= json_encode(Trd(29)) ?>
        }));

        if (paisSeleccionado && estadosPorPais[paisSeleccionado]) {
            $selectState.prop('disabled', false);

            $.each(estadosPorPais[paisSeleccionado], function(index, estado) {
                $selectState.append($('<option>', {
                    value: estado.id,
                    text: estado.nombre
                }));
            });
        } else {
            $selectState.prop('disabled', true);
        }
    });
});

</script>

</body>
</html>