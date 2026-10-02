<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    if (!isset($_SESSION['logged_in'])){
      header("Location: ".URL_BASE."/products/all");
      exit; 
    }

    require_once 'head.php'; 



  

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "checkout"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    $TrdRsp = $Traducciones;
    
?>
<title><?= Trd(1) ?><?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2) ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/checkout.css">
<link rel="stylesheet" href="css/cart.css">

<style>

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

</style>

    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <style>

        .card-payment { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .form-control { border-radius: 8px; padding: 12px; border: 1px solid #dee2e6; }
        .form-control:focus { box-shadow: none; border-color: #000; }
        .btn-pay { background: #000; color: #fff; border: none; padding: 14px; border-radius: 8px; font-weight: 600; transition: 0.3s; }
        .btn-pay:hover { background: #333; color: #fff; }
        .btn-pay:disabled { background: #ccc; }
        .input-group-text { background: transparent; border-radius: 8px; }
        .anticipo-card { cursor: pointer; border: 2px solid #eee; border-radius: 10px; transition: 0.2s; }
        .anticipo-card:hover { border-color: #000; }
        .selected-anticipo { border-color: #000 !important; background-color: #f8f9fa; }
        .text-detail { font-size: 0.85rem; color: #6c757d; }


        #pdf-canvas {
            max-height: 160px; /* Limita la altura del preview */
            object-fit: contain;
            background-color: #eee;
        }

        .anticipo-card {
            cursor: pointer;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .selected-anticipo {
            border-color: #0d6efd;
            background-color: #f0f7ff;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2);
        }        

        .spinner-border {
            --bs-spinner-width: 1.2rem;
            --bs-spinner-height: 1.2rem;
            vertical-align: middle;
            margin-right: 8px;
        }

    </style>


</head>
<body>
<?php 
  require_once ('nav.php');
  $Traducciones = $TrdRsp;

  $api_url = URL_API."quote_account";
  //$data = json_encode(['token' => $token]);
  $data ='';
  $account = json_decode(API($jwt,$api_url,$data,'GET'), true);  
?>

<button class="mobile-summary-toggle" id="mobileSummaryToggle" aria-expanded="false">
  <span class="mobile-summary-toggle-text">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
    <span id="toggleTextBtn"><?= Trd(3) ?></span>
  </span>
  <span class="mobile-summary-toggle-price" id="mobileSummaryPrice">$0.00</span>
</button>

<div class="wrap checkout-grid">
  
  <main>
    <form id="payment-form" onsubmit="processCheckout(event)">
      
      <section class="checkout-section">
        <h2><?= Trd(4) ?></h2>

        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div class="form-group">
            <label><?= Trd(5) ?></label>
            <input type="text" id="chkFirstname" readonly class="input-text" style="background: var(--color-line-faint); cursor: not-allowed;">
          </div>
          <div class="form-group">
            <label><?= Trd(6) ?></label>
            <input type="text" id="chkLastname" readonly class="input-text" style="background: var(--color-line-faint); cursor: not-allowed;">
          </div>
        </div>
        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 12px;">
          <div class="form-group">
            <label><?= Trd(7) ?></label>
            <input type="email" id="chkEmail" readonly class="input-text" style="background: var(--color-line-faint); cursor: not-allowed;">
          </div>
          <div class="form-group">
            <label><?= Trd(8) ?></label>
            <input type="tel" id="chkPhone" readonly class="input-text" style="background: var(--color-line-faint); cursor: not-allowed;">
          </div>
        </div>        

      </section>

      <div class="checkout-block" style="margin-top: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
          <h3 class="checkout-block-title" style="margin: 0;"><?= Trd(9) ?></h3>
          <button type="button" class="link-primary" onclick="openAddressModal('add')" style="background:none; border:none; cursor:pointer; font-size:0.9rem;">
            <?= Trd(10) ?>
          </button>
        </div>

        <div class="address-grid" id="checkoutAddressesContainer">
          </div>
        
        
      </div>      





      <section class="checkout-section"><section class="checkout-section" style="margin-top: 32px;">
        <h2><?= Trd(11) ?></h2>

        <?php
            $PayPlatform = $account['Pay_platform'];

            $api_url = URL_API."PAYPAL";
            $data = '';
            $paypal_account = json_decode(API($jwt,$api_url,$data,'GET'), true);      


        ?>        

        <div class="card-payment" style="background: #fff; border: 1px solid var(--color-line); border-radius: var(--radius-md); padding: 24px;">

            <input type="hidden" name="token_id"    id="token_id">
            <input type="hidden" name="token"       id="token" value="">
            <input type="hidden" name="amount"      id="monto_final" value="">
            <input type="hidden" name="cartNote_final" id="cartNote_final" value="">
            <input type="hidden" name="cart_json"   id="cart_json" value="">
            <input type="hidden" name="id_client"   id="id_client" value="">
            <input type="hidden" name="id_address"  id="id_address" value="">
            <input type="hidden" name="select_tax"  id="select_tax" value="">


<div id="holder-contact-fields" style="margin-bottom: 24px;">
    <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; color: var(--color-ink);">
        <?= Trd(12) ?>
    </h4>
    <p style="font-size: 0.8rem; color: var(--color-ink-soft); margin-top: -8px; margin-bottom: 12px;">
        <?= Trd(13) ?>
    </p>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
        <div class="form-group">
            <label style="font-size: 0.8rem; font-weight: 600;"><?= Trd(5) ?></label>
            <input type="text" name="name" id="client-name" class="input-text" value="Nom" required style="width: 100%;">
        </div>
        <div class="form-group">
            <label style="font-size: 0.8rem; font-weight: 600;"><?= Trd(6) ?></label>
            <input type="text" name="last_name" id="client-lastname" class="input-text" value="Ape" required style="width: 100%;">
        </div>
    </div>
    <div class="form-group">
        <label style="font-size: 0.8rem; font-weight: 600;"><?= Trd(14) ?></label>
        <input type="email" name="email" id="client-email" class="input-text" value="Correo" required style="width: 100%;">
    </div>
</div>
            <?php if ($paypal_account['Active'] == 1): ?>
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;"><?= Trd(15) ?></label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    
                    <label style="border: 2px solid var(--color-brand); padding: 12px; border-radius: var(--radius-sm); cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.88rem; font-weight: 600;">
                        <input type="radio" name="payment_method" id="method-card" checked style="accent-color: var(--color-brand);">
                        <?= Trd(16) ?>
                    </label>

                    <label style="border: 1px solid var(--color-line-strong); padding: 12px; border-radius: var(--radius-sm); cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.88rem; font-weight: 600;">
                        <input type="radio" name="payment_method" id="method-paypal">
                        <?= Trd(17) ?>
                    </label>
                    
                </div>
            </div>
            <?php endif; 
            $TrdRsp = $Traducciones;
            $api_url = URL_API."Traducciones_web";
            $data = json_encode(['program' => "mpayment"]);
            $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);              
            $TrdPgs = $Traducciones;
            ?>

            <div id="traditional-gateway-section" style="margin-bottom: 20px;">
                <?php if ($PayPlatform == 'OPAY'): ?>
                    <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; color: var(--color-ink);"><?= Trd(12) ?></h4>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <input type="text" class="input-text" placeholder="<?= Trd(13) ?>" data-openpay-card="holder_name" style="width:100%;">
                        <input type="text" class="input-text only-numbers" placeholder="<?= Trd(14) ?>" data-openpay-card="card_number" maxlength="16" style="width:100%;">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                            <input type="text" class="input-text only-numbers" placeholder="<?= Trd(15) ?> (MM)" data-openpay-card="expiration_month" maxlength="2">
                            <input type="text" class="input-text only-numbers" placeholder="<?= Trd(16) ?> (AA)" data-openpay-card="expiration_year" maxlength="2">
                            <input type="text" class="input-text only-numbers" placeholder="<?= Trd(17) ?>" data-openpay-card="cvv2" maxlength="4">
                        </div>
                    </div>
                <?php else: ?>
                    <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; color: var(--color-ink);"><?= Trd(18) ?></h4>
                    <div id="card-container" style="min-height: 80px; padding: 10px; border: 1px solid var(--color-line); border-radius: var(--radius-sm); background: var(--color-bg-soft);"></div>
                <?php endif; ?>
            </div>

            <div id="paypal-gateway-section" style="margin-bottom: 20px; display: none;">
                <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; color: var(--color-ink);"><?= Trd(18) ?></h4>
                <div id="paypal-button-container" style="width: 100%; min-height: 150px;"></div>
            </div>

            <div style="font-size: 0.88rem; display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; border-top: 1px solid var(--color-line); padding-top: 16px;">
                <div style="display: flex; justify-content: space-between; color: var(--color-ink-soft);">
                    <span><?= Trd(19) ?></span>
                    <span class="fw-bold">$<?= number_format(1000, 2, '.', ',') ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; color: var(--color-ink-soft);">
                    <span><?= Trd(20) ?></span>
                    <span class="fw-bold">$<?= number_format(0, 2, '.', ',') ?></span>
                </div>
            </div>

            <div class="total-box" style="background: var(--color-bg-soft); border: 1px solid var(--color-line-strong); padding: 16px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-weight: 700; color: var(--color-brand); display: block; font-size: 0.95rem;"><?= Trd(21) ?></span>
                        <small style="color: var(--color-ink-soft); font-size: 0.78rem;"><?= Trd(22) ?></small>
                    </div>
                    <h2 style="font-size: 1.6rem; font-weight: 800; color: var(--color-brand); margin: 0;" id="display-pago-hoy">$<?= number_format(1000, 2, '.', ',') ?></h2>
                </div>
            </div>
            
            <div id="payment-status-container" style="margin-top: 12px; margin-bottom: 12px;"></div>

            <div id="traditional-buttons-section">
                <?php if ($PayPlatform == 'OPAY'): ?>
                    <button type="button" class="btn-primary" id="pay-button" style="width:100%; padding:14px; font-weight:700;"><?= Trd(23) ?></button>
                <?php else: ?>
                    <button type="button" class="btn-primary" id="card-button" style="width:100%; padding:14px; font-weight:700;"><?= Trd(23) ?></button>
                <?php endif; ?>
                
                <div style="width: 100%; display: flex; justify-content: center; margin-top: 16px;">
                    <?php if ($PayPlatform == 'OPAY'): ?>
                        <img src="https://www.openpay.mx/_ipx/_/img/header/openpay-color.svg" alt="Openpay" style="height: 22px; opacity: 0.5; display: block; margin: 0 auto;">
                    <?php else: ?>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Square%2C_Inc._logo.svg/1280px-Square%2C_Inc._logo.svg.png" alt="Square" style="height: 20px; opacity: 0.5; display: block; margin: 0 auto;">
                    <?php endif; ?>                     
                </div>
            </div>

        </div>
      </section>

</form>
  </main>
<?php
$Traducciones = $TrdRsp;
?>
  <aside class="checkout-summary-card" id="checkoutSummaryCol">
    <h3><?= Trd(19) ?></h3>
    
    <div class="summary-items-list" id="checkoutItemsList">
      </div>
      <div class="summary-row">
        <span class="summary-row-label"><?= Trd(20) ?></span>
        <span id="checkoutSubtotal">$0.00</span>
      </div>
      <div class="summary-row">
        <span class="summary-row-label"><?= Trd(46) ?></span>
        <span id="checkoutTax">$0.00</span>
      </div>      
    <div class="summary-row">
      <span class="summary-row-label"><?= Trd(21) ?></span>
      <span style="font-size:0.8rem; color:var(--color-ink-faint)"><?= Trd(22) ?></span>
    </div>


    <div class="summary-row total">
      <span class="summary-row-label"><?= Trd(23) ?></span>
      <span><span id="checkoutTotal">$0.00</span> <span style="font-size:0.75rem; font-weight:400; color:var(--color-ink-soft);">USD</span></span>
    </div>

    <div class="cart-note-box">
      <label for="cartNote"><?= Trd(24) ?></label>
      <textarea id="cartNote" placeholder="<?= Trd(25) ?>"></textarea>
    </div>


    <p class="tax-shipping-statement"><?= Trd(26) ?></p>
  </aside>

</div>

<div class="modal-backdrop" id="addressModalBackdrop"></div>
<div class="address-modal" id="addressModal" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <h2 id="modalTitle"><?= Trd(27) ?></h2>
    <button type="button" class="btn-close-modal" onclick="closeAddressModal()">&times;</button>
  </div>
  <form id="addressForm" class="modal-body">
    <input type="hidden" id="addressId" name="address_id">
    
    <div class="form-group">
      <label for="adrAlias"><?= Trd(28) ?></label>
      <input type="text" id="adrAlias" required placeholder="Ej. Mi Casa">
    </div>
    
    <div class="form-row">
      <div class="form-group">
        <label for="adrState"><?= Trd(29) ?></label>
        <input type="text" id="adrState" required placeholder="Jalisco">
      </div>
      <div class="form-group">
        <label for="adrCity"><?= Trd(30) ?></label>
        <input type="text" id="adrCity" required placeholder="Guadalajara">
      </div>
    </div>

    <div class="form-group">
      <label for="adrStreet"><?= Trd(31) ?></label>
      <input type="text" id="adrStreet" required placeholder="Av. Juárez 123">
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="adrColonia"><?= Trd(32) ?></label>
        <input type="text" id="adrColonia" required placeholder="Centro">
      </div>
      <div class="form-group">
        <label for="adrZip"><?= Trd(33) ?></label>
        <input type="text" id="adrZip" required placeholder="44100" maxlength="5">
      </div>
    </div>

    <div class="form-group">
      <label for="adrReferences"><?= Trd(34) ?></label>
      <textarea id="adrReferences" rows="2" placeholder="Fachada color portón negro, entre calle Hidalgo y Morelos"></textarea>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn-cancel" onclick="closeAddressModal()"><?= Trd(35) ?></button>
      <button type="submit" class="btn-save" id="save_address"><?= Trd(36) ?></button>
    </div>
  </form>
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
/* ============================================================
   INTEGRACIÓN LOGICALSTORAGE COMPLETA EN CHECKOUT
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Obtener datos de la pasarela
  const cart = JSON.parse(localStorage.getItem('brinca_cart')) || [];
  
  $('#cart_json').val(localStorage.getItem('brinca_cart'));

  // Seguridad: Si el carrito está vacío, regresar de inmediato al catálogo
  if (cart.length === 0) {
    Swal.fire({ title: 'Error', text: '<?= Trd(37) ?>', icon: 'error', confirmButtonText: 'Entendido' });
    window.location.href = url_base + "/products/all";
    return;
  }

  // 2. Ejecutar la renderización dinámica
 

  window.renderCheckoutSummary = function() {
    const itemsContainer = document.getElementById('checkoutItemsList');
    const subtotalLabel = document.getElementById('checkoutSubtotal');
    const taxLabel = document.getElementById('checkoutTax');
    const totalLabel = document.getElementById('checkoutTotal');
    const mobilePriceLabel = document.getElementById('mobileSummaryPrice');

    if (!itemsContainer) return;
    itemsContainer.innerHTML = ''; // Limpiar mocks

    let totalCalculado = 0;
    let totalItemsGlobal = 0;

    cart.forEach(item => {
      const itemTotal = item.price * item.quantity;
      totalCalculado += itemTotal;
      totalItemsGlobal += item.quantity;

      const singlePriceFormatted = item.price.toLocaleString('en-US', { style: 'currency', currency: 'USD' });

      // Inyección exacta respetando la arquitectura de marcas de clases CSS con soporte dinámico PHP transpilado a JS
      const itemHTML = `
        <div class="summary-item">
          <div class="summary-item-img-wrap">
            <img src="${item.image}" alt="${item.name}">
            <span class="summary-item-qty-badge">${item.quantity}</span>
          </div>
          <div class="summary-item-title">
            ${item.name}
            <span>${item.onlyRequest ? '<?= Trd(38) ?>' : '<?= Trd(39) ?>'}</span>
          </div>
          <div class="summary-item-price">${singlePriceFormatted}</div>
        </div>
      `;
      itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
    });

    // Formatear globales finales
   
    const StotalString = totalCalculado.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    if (subtotalLabel) subtotalLabel.textContent = StotalString;

    totalImpuesto = totalCalculado * $('#select_tax').val(); 
    const totaltaxString = totalImpuesto.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    if (taxLabel) taxLabel.textContent = totaltaxString;

    totalCalculado = totalCalculado + totalImpuesto;
    const totalString = totalCalculado.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    
    $('#monto_final').val(totalCalculado);

   
    
    if (totalLabel) totalLabel.textContent = totalString;
    if (mobilePriceLabel) mobilePriceLabel.textContent = totalString; // Precio del acordeón móvil

    // Actualizar sincronización del badge flotante global del menú por si acaso
    $('.cart-count').text(totalItemsGlobal);
  }
   window.renderCheckoutSummary();
});


function processCheckout(event) {
  event.preventDefault();
  
  // Limpieza exitosa post-pago
  alert('<?= Trd(40) ?>');
  
  localStorage.removeItem('brinca_cart'); // Vaciamos para evitar duplicidad de compras
  window.location.href = "thankyou.php";  // Redirección simulada a página de éxito
}


let checkoutAddresses = [];

document.addEventListener("DOMContentLoaded", () => {
  // Carga inicial de datos al abrir la pasarela de pago
  loadCheckoutProfile();
  loadCheckoutAddresses();


  $('#addressForm').on('submit', function(e) {
    e.preventDefault();
    saveCheckoutAddress();
  });  
  
});

function loadCheckoutProfile() {
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'GET',
    data: { action: 'get_profile' },
    dataType: 'json',
    success: function(res) {
      if(res.success) {
        $('#chkFirstname').val(res.data.firstname);
        $('#chkLastname').val(res.data.lastname);
        $('#chkEmail').val(res.data.email);
        $('#chkPhone').val(res.data.phone);

        // NUEVO: Inicializamos los campos del pago con sus datos editables
        $('#id_client').val(res.data.customer_id);
        $('#client-name').val(res.data.firstname);
        $('#client-lastname').val(res.data.lastname);
        $('#client-email').val(res.data.email);        

      }
    }
  });
}

function loadCheckoutAddresses() {
  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'GET',
    data: { action: 'get_addresses' },
    dataType: 'json',
    success: function(res) {
      let html = '';
      if(res.success && res.data.length > 0) {
        checkoutAddresses = res.data;
        
        // Identificar cuál dirección se marcará por defecto (la configurada como principal o la primera del array)
        const defaultAddr = res.data.find(a => a.is_default == 1) || res.data[0];
        selectAddress(defaultAddr.id,defaultAddr.tax);

        res.data.forEach(addr => {
          html += `
            <div class="address-card" id="addr_card_${addr.id}" onclick="selectAddress(${addr.id,addr.tax})" style="cursor: pointer; position: relative; transition: all 0.2s ease;">
              <div class="select-indicator" style="position: absolute; top: 12px; right: 12px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid var(--color-line-strong);"></div>
              <h3 style="margin-top: 0; font-size: 0.95rem;">${escapeHTML(addr.alias)}</h3>
              <p style="font-size: 0.85rem; line-height: 1.4; color: var(--color-ink-soft); margin-bottom: 0;">
                <strong>${escapeHTML(res.customer_name)}</strong><br>
                ${escapeHTML(addr.street)}<br>
                Col. ${escapeHTML(addr.colonia)}, CP ${escapeHTML(addr.zip)}<br>
                ${escapeHTML(addr.city)}, ${escapeHTML(addr.state)}
              </p>
            </div>`;
        });
      } else {
        html = `
          <div style="grid-column: 1 / -1; text-align: center; padding: 24px; border: 2px dashed var(--color-line); border-radius: var(--radius-md);">
            <p style="color: var(--color-ink-soft); margin-bottom: 12px;"><?= Trd(41) ?></p>
          </div>`;
        $('#id_address').val('');
      }
      
      $('#checkoutAddressesContainer').html(html);
      // Aplicar estilos de selección si ya se renderizó el DOM
      if($('#id_address').val()) {
        highlightActiveCard($('#id_address').val());
      }
    }
  });
}


function selectAddress(id,tax) {
  $('#id_address').val(id);
  $('#select_tax').val(tax);
  highlightActiveCard(id);
 window.renderCheckoutSummary();
}

function highlightActiveCard(id) {
  // Remover clases activas previas
  $('.address-card').css({
    'border': '1px solid var(--color-line)',
    'box-shadow': 'none'
  });
  $('.select-indicator').css({
    'background': 'none',
    'border-color': 'var(--color-line-strong)'
  });

  // Aplicar estilos dinámicos a la tarjeta seleccionada (estilo Var Brand)
  $(`#addr_card_${id}`).css({
    'border': '2px solid var(--color-brand)',
    'box-shadow': '0 4px 12px rgba(0,0,0,0.05)'
  });
  $(`#addr_card_${id} .select-indicator`).css({
    'background': 'var(--color-brand)',
    'border-color': 'var(--color-brand)'
  });
}

// ============================================================
// 3. AGREGAR NUEVA DIRECCIÓN DESDE EL MODAL DEL CHECKOUT
// ============================================================
function openAddressModal(mode) {
  document.getElementById('addressForm').reset();
  document.getElementById('addressId').value = '';
  
  document.getElementById('addressModalBackdrop').classList.add('open');
  document.getElementById('addressModal').classList.add('open');
}

function closeAddressModal() {
  document.getElementById('addressModalBackdrop').classList.remove('open');
  document.getElementById('addressModal').classList.remove('remove'); // compatible con tus clases animadas
  document.getElementById('addressModal').classList.remove('open');
}

function saveCheckoutAddress() {

const $btnSubmit = $('#save_address');
  
  // 2. Deshabilitar y cambiar texto de inmediato
  $btnSubmit.prop('disabled', true);
  const originalText = $btnSubmit.text();
  $btnSubmit.text("<?= Trd(42) ?>");

  $.ajax({
    url: 'ajax_profile_actions.php',
    type: 'POST',
    data: {
      action: 'create_address',
      alias: $('#adrAlias').val(),
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
        Swal.fire({ title: '<?= Trd(43) ?>', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
        closeAddressModal();
        loadCheckoutAddresses(); // Recarga y selecciona automáticamente la nueva dirección
        $btnSubmit.prop('disabled', false);
        $btnSubmit.text(originalText);
      } else {
        Swal.fire({ title: 'Error', text: res.message, icon: 'error', confirmButtonText: 'Entendido' });
        $btnSubmit.prop('disabled', false);
        $btnSubmit.text(originalText);
      }
    }
  });
}

// Helper para sanitizar textos inyectados dinámicamente
function escapeHTML(str) {
  if(!str) return '';
  return str.replace(/[&<>'"]/g, tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag));
}


</script>


<?php if ($PayPlatform == 'OPAY'){
        $Traducciones = $TrdPgs; 
        $api_url = URL_API."OPAY";
        $data = '';
        $opay_account = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    ?>
    <script>
        $(document).ready(function() {
            // Configuración Openpay
            OpenPay.setId('<?php echo $opay_account['Id'];?>');
            OpenPay.setApiKey('<?php echo $opay_account['PublicKey'];?>');
            OpenPay.setSandboxMode(true);
            OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

            // --- VALIDACIONES DE INPUTS ---
            $('.only-numbers').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Elimina cualquier cosa que no sea número
            });

            // --- PROCESAR PAGO ---
            $('#pay-button').on('click', function(e) {
                e.preventDefault();
                
                // 1. Referencia al botón para feedback visual
                var $btn = $(this);
                $btn.prop("disabled", true).text("<?= Trd(24) ?>");

                // 2. Validación manual de campos requeridos (Nombre, Email, etc.)
                let valid = true;
                $('#payment-form input[required]').each(function() {
                    if ($(this).val().trim() === "") {
                        $(this).addClass('is-invalid'); // Clase de Bootstrap para error
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!valid) {
                    alert("<?= Trd(25) ?>");
                    $btn.prop("disabled", false).text("<?= Trd(26) ?>");
                    return;
                }
                const statusDiv = document.getElementById('payment-status-container');
                statusDiv.innerHTML = ""; // Limpiar mensajes previos
                // 3. Crear Token con Openpay
                // extractFormAndCreate lee automáticamente los campos con 'data-openpay-card'
                OpenPay.token.extractFormAndCreate('payment-form', function(res) {
                    // --- CASO ÉXITO: Token generado ---
                    var token_id = res.data.id;
                    $('#token_id').val(token_id);

                    $('#cartNote_final').val($('#cartNote').val())

                    // Enviamos los datos al backend.php mediante AJAX
                    var datosFormulario = $('#payment-form').serialize();



                    $.ajax({
                        type: "POST",
                        url: url_api +'processpayment_sale',
                    // IMPORTANTE: Convierte tu objeto a una cadena JSON
                        data:JSON.stringify(Object.fromEntries(new URLSearchParams(datosFormulario))),
                        dataType: "json",
                        contentType: "application/json", // IMPORTANTE: Indica que envías JSON
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
                            'LNG':'<?= $_SESSION['Idioma'] ?>'
                        },
                        success: function(respuestaBackend) {
                            if(respuestaBackend.status === 'success') {
                                window.location.replace(url_base + "/"+ respuestaBackend.url);
                            } else if (respuestaBackend.status === 'pending') {
                                // Manejo de 3D Secure (Si el banco pide autenticación extra)
                                //window.location.href = respuestaBackend.url;
                            }
                        },
                        error: function(err) {
                            var errorMsg = err.responseJSON ? err.responseJSON.description : "Error interno en el servidor.";
                            //alert("Error en el cobro: " + errorMsg);

                            statusDiv.innerHTML = `
                                <div class="alert alert-danger d-flex align-items-center mt-3">
                                    <span class="me-2">❌</span>
                                    <div><?= Trd(27) ?>:  ${errorMsg}</div>
                                </div>`;                               

                            $btn.prop("disabled", false).text("<?= Trd(26) ?>");
                        }
                    });



                }, function(err) {
                    // --- CASO ERROR: Fallo al generar el token (ej. tarjeta inválida) ---
                    var desc = err.data.description != undefined ? err.data.description : err.message;
                    statusDiv.innerHTML = `
                        <div class="alert alert-danger d-flex align-items-center mt-3">
                            <span class="me-2">❌</span>
                            <div><?= Trd(28) ?>:  ${desc}</div>
                        </div>`;                    

                    $btn.prop("disabled", false).text("<?= Trd(26) ?>");
                });
            });




        });
    </script>
<?php }
    else{
        $Traducciones = $TrdPgs; 
        $api_url = URL_API."SQUARE";
        $data = '';
        $square_account = json_decode(API($jwt,$api_url,$data,'GET'), true);            
?>
    <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    <script>
            const appId = '<?php echo $square_account['Id'];?>';
            const locId = '<?php echo $square_account['LocalId'];?>';

            async function initSquare() {
            const payments = Square.payments(appId, locId);
            const card     = await payments.card();
            await card.attach('#card-container');

            document.getElementById('card-button').addEventListener('click', async () => {
                try {
                    const result = await card.tokenize();
                    if (result.status === 'OK') {
                        await procesarPago(result.token);
                    }
                } catch (e) {
                    console.error('Error al tokenizar:', e);
                }
            });
        }
        
        async function procesarPago(token_square) {
            const statusDiv = document.getElementById('payment-status-container');
            const payButton = document.getElementById('card-button');
            $('#token_id').val(token_square);
            // 1. Bloquear botón y mostrar icono de carga
            payButton.disabled = true;
            payButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <?= Trd(29) ?>
            `;
            
            statusDiv.innerHTML = ""; // Limpiar mensajes previos

            try {
                $('#cartNote_final').val($('#cartNote').val())
                var datosFormulario = $('#payment-form').serialize();
                

                    $.ajax({
                        type: "POST",
                        url: url_api +'processpayment_square_sale',
                    // IMPORTANTE: Convierte tu objeto a una cadena JSON
                        data:JSON.stringify(Object.fromEntries(new URLSearchParams(datosFormulario))),
                        dataType: "json",
                        contentType: "application/json", // IMPORTANTE: Indica que envías JSON
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
                            'LNG':'<?= $_SESSION['Idioma'] ?>'
                        },                      
                        success: function(respuestaBackend) {
                            if(respuestaBackend.status === 'success') {
                                window.location.replace(url_base + "/"+ respuestaBackend.url);
                            } else if (respuestaBackend.status === 'pending') {
                                //window.location.href = respuestaBackend.url;
                            }
                        },
                        error: function(err) {
                            var errorMsg = err.responseJSON ? err.responseJSON.description : "Error interno en el servidor.";

                            statusDiv.innerHTML = `
                                <div class="alert alert-danger d-flex align-items-center mt-3">
                                    <span class="me-2">❌</span>
                                    <div>${errorMsg}</div>
                                </div>`;                            

                            payButton.disabled = false;
                            payButton.innerHTML = "<?= Trd(30) ?>";
                        }
                    });                
            } catch (error) {
                statusDiv.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center mt-3">
                        <span class="me-2">❌</span>
                        <div>${error.message}</div>
                    </div>`;
                
                // Reactivar el botón para que el usuario pueda intentar de nuevo
                payButton.disabled = false;
                payButton.innerHTML = "<?= Trd(30) ?>";
            }
        }

        initSquare();
    </script>
<?php }
$Traducciones = $TrdRsp; 
?>



<?php if ($paypal_account['Active'] == 1):?>
<script src="https://www.paypal.com/sdk/js?client-id=<?= $paypal_account['Id'] ?>&currency=<?= $account['Currency'] ?>&enable-funding=venmo,paylater&buyer-country=<?= $account['Pais'] ?>"></script>
<script>

$(document).ready(function() {
    // Escuchar el cambio en los botones de selección de método de pago
// Usamos delegación de eventos en el contenedor padre o en el body para asegurar que siempre escuche
$(document).on('change', 'input[name="payment_method"]', function() {
    if ($('#method-paypal').is(':checked')) {
        // Ocultar pasarela tradicional y mostrar PayPal
        $('#traditional-gateway-section, #traditional-buttons-section').hide();
        $('#paypal-gateway-section').show();
    } else {
        // Mostrar pasarela tradicional y ocultar PayPal
        $('#paypal-gateway-section').hide();
        $('#traditional-gateway-section, #traditional-buttons-section').show();
    }
});

// Inicializar el botón de PayPal
    paypal.Buttons({
        commit: true,
        style: {
            layout: 'vertical',
            shape:  'rect',
            label:  'paypal'
        },
        
        // Validación: Bloquear el flujo de PayPal si los campos de contacto están vacíos
        onInit: function(data, actions) {
            function checkForm() {
                const name = $('#client-name').val();
                const lastname = $('#client-lastname').val();
                const email = $('#client-email').val();
                
                if(name && lastname && email) {
                    actions.enable();
                } else {
                    actions.disable();
                }
            }
            
            checkForm();
            $('#client-name, #client-lastname, #client-email').on('keyup change', checkForm);
        },
        
        onClick: function() {
            if(!$('#client-name').val() || !$('#client-lastname').val() || !$('#client-email').val()){
                $('#payment-form')[0].reportValidity(); // Cambiado al ID de tu formulario unificado
            }
        },

        createOrder: function(data, actions) {
            // 1. Obtenemos los montos y los datos editados de la tarjeta prestada/propia en tiempo real
            var monto = $('#monto_final').val(); 
            var nombreTitular = $('#client-name').val();
            var apellidoTitular = $('#client-lastname').val();
            var emailTitular = $('#client-email').val();
            
            // 2. Estructuramos la orden enviándole la información del pagador a PayPal
            return actions.order.create({
                application_context: {
                    shipping_preference: 'NO_SHIPPING'
                },
                // Inyectamos el objeto 'payer' nativo de la API de PayPal
                payer: {
                    name: {
                        given_name: nombreTitular,
                        surname: apellidoTitular
                    },
                    email_address: emailTitular
                },
                purchase_units: [{
                    amount: {
                        value: monto
                    }
                }]
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                // Serializamos los datos completos del formulario único
                $('#cartNote_final').val($('#cartNote').val())
                var formData = $('#payment-form').serialize(); // Aseguramos usar el formulario principal
                formData += '&orderID=' + encodeURIComponent(data.orderID);
                
                $.ajax({
                    type: "POST",
                    url: url_api + 'processpayment_paypal_sale',
                    data: JSON.stringify(Object.fromEntries(new URLSearchParams(formData))),                    
                    dataType: 'json',
                    contentType: "application/json",
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'X-ID-CLIENT': '<?= ID_CLIENT ?>',
                        'LNG':'<?= $_SESSION['Idioma'] ?>'
                    },                        
                    beforeSend: function() {
                        $('#payment-status-container').html('<div class="spinner-border text-primary"></div> <?= Trd(45) ?>');
                    },
                    success: function(respuestaBackend) {
                        if(respuestaBackend.status === 'success') {
                            window.location.replace(url_base + "/"+ respuestaBackend.url);
                        } else {
                            //$('#payment-status-container').html('<div class="alert alert-danger">'+ respuestaBackend.message +'</div>');
                        }
                    }
                });
            });
        }
    }).render('#paypal-button-container');

});

</script>
<?php endif;?>

</body>
</html>