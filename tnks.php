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
    $data = json_encode(['program' => "tnks"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);   
    $TrdRsp = $Traducciones; 

?>
<title><?= $Traducciones[1] ?><?= COMPANY_NAME ?></title>
<meta name="description" content="<?= $Traducciones[2] ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/tnks.css">
<link rel="stylesheet" href="css/cart.css">
<style>
/* Estilos para el Gran Modal del Contrato (Ancho Expandido) */
.modal-contract-overlay {
  position: fixed;
  top: 0; 
  left: 0; 
  width: 100vw; 
  height: 100vh;
  background-color: rgba(15, 23, 42, 0.65); 
  backdrop-filter: blur(8px); 
  display: flex; 
  align-items: center; 
  justify-content: center;
  z-index: 99999;
  padding: 15px; 
}

.modal-contract-box {
  width: 96%; 
  max-width: 1400px; 
  height: 92vh; 
  background: #ffffff;
  border-radius: 16px; 
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3); 
  display: flex; 
  flex-direction: column;
  overflow: hidden;
  animation: modalScaleUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalScaleUp {
  from { transform: scale(0.97); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.modal-contract-header {
  padding: 24px; 
  border-bottom: 1px solid #f1f5f9; 
  text-align: center;
  background-color: #f8fafc;
}
.modal-contract-header h2 { 
  font-size: 1.8rem; 
  color: #0f172a; 
  margin: 0; 
  font-weight: 700; 
}

.modal-contract-body {
  padding: 30px; 
  flex: 1; 
  display: flex;
  flex-direction: column;
  overflow: hidden; 
}

/* Contenedor del texto amplio del contrato */
.contract-text {
  background: #f8fafc; 
  padding: 30px; 
  border-radius: 12px; 
  border: 1px solid #e2e8f0; 
  flex: 1; 
  overflow-y: auto; 
  margin-bottom: 20px;
  font-size: 1rem;
  color: #334155;
  line-height: 1.6;
}

/* Sección de la firma ajustada para el nuevo ancho */
.signature-section { 
  text-align: center; 
  background: #fff;
  padding-top: 10px;
  display: flex;
  flex-direction: column;
  align-items: center; 
}
.signature-label { 
  font-weight: 600; 
  font-size: 0.95rem; 
  color: #475569; 
  margin-bottom: 10px; 
  display: block; 
}

#signature-canvas {
  border: 2px dashed #cbd5e1; 
  background: #fdfdfd; 
  border-radius: 12px;
  cursor: crosshair; 
  touch-action: none; 
}

.signature-actions { 
  display: flex; 
  justify-content: center; 
  margin-top: 8px; 
}
.btn-clear { 
  background: none; 
  border: none; 
  color: #ef4444; 
  font-size: 0.9rem; 
  font-weight: 600; 
  cursor: pointer; 
}
.btn-clear:hover { 
  text-decoration: underline; 
}

.modal-contract-footer {
  padding: 20px 30px; 
  border-top: 1px solid #f1f5f9; 
  background: #f8fafc; 
}
.btn-submit-contract {
  background-color: #10B981; 
  color: white; 
  border: none; 
  padding: 16px;
  border-radius: 8px; 
  font-weight: 600; 
  cursor: pointer; 
  width: 100%; 
  font-size: 1.1rem;
  transition: background 0.2s;
}
.btn-submit-contract:hover:not(:disabled) {
  background-color: #059669;
}
.btn-submit-contract:disabled { 
  background-color: #cbd5e1; 
  color: #94a3b8;
  cursor: not-allowed; 
}

@media (max-width: 768px) {
  .modal-contract-overlay { padding: 8px; }
  .modal-contract-box { width: 100%; height: 96vh; border-radius: 12px; }
  .modal-contract-body { padding: 15px; }
  .contract-text { padding: 15px; }
}
</style>


</head>

<body>
<?php 
    require_once ('nav.php');
    $Traducciones = $TrdRsp;


    $IdSale= $_GET['Sale'];
    $Id= $_GET['Id'];

    $api_url = URL_API."account";
    $data = "";
    $account = json_decode(API($jwt,$api_url,$data,'GET'), true);   

    $api_url = URL_API."get_sale";
    $data = json_encode(['Sale' => $IdSale,'Id' => $Id]);
    $Sale = json_decode(API($jwt,$api_url,$data,'POST'), true);    

if ($Sale['sale']['Contrato'] == 0){
    $api_url = URL_API."get_sale_contract";
    $data = json_encode(['lng' => 'es']);
    $Template = json_decode(API($jwt,$api_url,$data,'POST'), true);        
    $Contract = $Template['template'];


    // 1. Campos generales y del cliente
$datosContrato = [
    '*company_logo*'       => $account['account'][0]['Logo'], 
    '*company_name*'       => $account['account'][0]['NombreCompania'],
    '*company_address*'    => $account['account'][0]['Direccion']." ".$account['account'][0]['Direccion2'],
    '*company_city*'       => $account['account'][0]['Ciudad'],
    '*company_state*'      => $account['account'][0]['Estado'],
    '*company_phone*'      => $account['account'][0]['TelefonoCelular'],

    ' *leadid*'             => $Sale['sale']['id'],
    '*contractsentdate*'   => date('Y-m-d H:i:s'),

    '*organization*'       => $Sale['address']['Alias'] ?? 'Particular',
    '*ctfirstname*'        => $Sale['client']['firstname'].' '. $Sale['client']['lastname'] ?? 'Cliente', 
    '*ctlastname*'         => '', 
    '*eventstreet*'        => $Sale['address']['Street'] ?? '',
    '*eventcity*'          => $Sale['address']['City'] ?? '',
    '*eventstate*'         => $Sale['address']['State'] ?? '',
    '*eventzip*'           => $Sale['address']['Zip'] ?? '',
    '*phones*'             => $Sale['client']['phone'] ?? 'No provisto',

    '*deliverydate*'       => date('Y-m-d', strtotime('+7 days')), 
    '*deliverytype*'       => 'Pendiente de cotizar',

    '*itemtotals*'         => number_format( $Sale['sale']['total_amount'], 2),
    '*discount*'           => '0.00',
    '*subtotal*'           => number_format($Sale['sale']['total_amount'], 2),
    '*total*'              => number_format($Sale['sale']['total_amount'], 2),
    '*apayment*'           => number_format($Sale['sale']['total_amount'], 2), 
    '*-apayment*'           => number_format($Sale['sale']['total_amount'], 2), 
    '*ctr_balance_due*'    => number_format($Sale['sale']['balance'], 2), 

    '*signature*'          => '', 
    '*customerdsname*'     => ($Sale['client']['firstname'].' '. $Sale['client']['lastname'] ?? 'Cliente'),
    '*signeddate*'         => date('d/m/Y H:i:s')
];

$articulosContrato = json_decode($Sale['sale']['cart_json'], true) ?? [];

function generarContratoHtml($htmlTemplate, $camposGenerales, $productos) {
    
    preg_match('/<tr class="item-fila".*?>(.*?)<\/tr>/s', $htmlTemplate, $matches);
    
    if (!empty($matches)) {
        $filaTemplateOriginal = $matches[0]; 
        $innerFilaTemplate = $matches[1];    
        $htmlArticulosAgrupados = "";

        foreach ($productos as $item) {
            
            $item['image'] = str_replace('originals', 'thumbnails', $item['image']);
            $item['image'] = str_replace('.avif', '.jpg', $item['image']);
            $reemplazosProducto = [
                '*productname_url_photo*' => $item['image'] ?? '',
                '*productname*'           => $item['name'] ?? 'Producto',
                '*product_sku_or_details*'=> $item['sku'] ?? 'Vinil 18oz comercial',
                '*discount*'              => isset($item['discount']) ? '$'.$item['discount'] : '$0.00',
                '*salesqty*'              => $item['quantity'] ?? 1,
                '*salestotalprice*'       => number_format(($item['price'] * $item['quantity']), 2)
            ];

            $filaProcesada = str_replace(
                array_keys($reemplazosProducto), 
                array_values($reemplazosProducto), 
                $innerFilaTemplate
            );

            $htmlArticulosAgrupados .= '<tr style="border-bottom: 1px solid #eee;">' . $filaProcesada . '</tr>';
        }

        $htmlTemplate = str_replace($filaTemplateOriginal, $htmlArticulosAgrupados, $htmlTemplate);
    }

    $htmlFinal = str_replace(
        array_keys($camposGenerales), 
        array_values($camposGenerales), 
        $htmlTemplate
    );

    return $htmlFinal;
}

$contratoListoParaImprimir = generarContratoHtml($Contract, $datosContrato, $articulosContrato);

}
?>

<div class="wrap success-grid">
  
  <main>
    
    <section class="success-hero">
<div class="success-badge" style="display: flex; align-items: center; justify-content: center; background-color: #10B981; width: 64px; height: 64px; border-radius: 50%;">
  <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="20 6 9 17 4 12"></polyline>
  </svg>
</div>      <span class="order-number" id="successOrderNum">Venta - <?= $Sale['sale']['id'] .  " Transacción - " . $Sale['pay']['TransactionId'] ?></span>
      <h1><?= $Traducciones[7] ?></h1>
      <p><?= $Traducciones[8] ?><strong id="successCustomerEmail"><?= $Traducciones[9] ?></strong>.</p>
    </section>

    <section class="steps-section">
      <h2><?= $Traducciones[10] ?></h2>
      
      <div class="steps-timeline">
        
        <div class="step-item active">
          <div class="step-number">1</div>
          <div class="step-content">
            <span class="step-title"><?= $Traducciones[11] ?></span>
            <span class="step-desc"><?= $Traducciones[12] ?></span>
          </div>
        </div>

        <div class="step-item">
          <div class="step-number">2</div>
          <div class="step-content">
            <span class="step-title"><?= $Traducciones[13] ?></span>
            <span class="step-desc"><?= sprintf($Traducciones[14], COMPANY_NAME) ?></span>
          </div>
        </div>

        <div class="step-item">
          <div class="step-number">3</div>
          <div class="step-content">
            <span class="step-title"><?= $Traducciones[15] ?></span>
            <span class="step-desc"><?= $Traducciones[16] ?></span>
          </div>
        </div>

      </div>
    </section>

    <section class="info-summary-block">
      <div class="info-card">
        <h4><?= $Traducciones[17] ?></h4>
        <p id="successShippingAddress">
          <?= $Traducciones[18] ?>
        </p>
      </div>
      <div class="info-card">
        <h4><?= $Traducciones[19] ?></h4>
        <p id="successPaymentMethod">
          <?= sprintf($Traducciones[20], strtoupper($Sale['pay']['Platform'])) ?>
        </p>
      </div>
    </section>

    <div class="action-buttons-row">
      <a href="../products/all" class="btn-primary"><?= $Traducciones[21] ?></a>
      <a href="https://wa.me/523312345678" target="_blank" class="btn-outline"><?= $Traducciones[22] ?></a>
    </div>

  </main>

  <aside class="success-summary-card">
    <h3><?= $Traducciones[23] ?></h3>
    
    <div class="purchased-items" id="successPurchasedItemsList">
      </div>

    <div class="summary-row">
      <span class="summary-row-label"><?= $Traducciones[24] ?></span>
      <span id="successSubtotal">$0.00</span>
    </div>
    <div class="summary-row">
      <span class="summary-row-label"><?= $Traducciones[25] ?></span>
      <span style="font-size:0.8rem; color:var(--color-ink-soft)"><?= $Traducciones[26] ?></span>
    </div>
    <div class="summary-row total">
      <span class="summary-row-label"><?= $Traducciones[27] ?></span>
      <span><span id="successTotal">$0.00</span> <span style="font-size:0.75rem; font-weight:400; color:var(--color-ink-soft);">USD</span></span>
    </div>
  </aside>

</div>

<?php 
  require_once('news.php');
  require_once('foot.php');
  require_once('cart.php');
  if ($Sale['sale']['Contrato'] == 0){
?>

<div id="contractModal" class="modal-contract-overlay">
  <div class="modal-contract-box">
    <div class="modal-contract-header">
      <h2><?= $Traducciones[3] ?></h2>
    </div>
    
    <div class="modal-contract-body" >
      <div class="contract-text" id ='Contract'>
        <?= $contratoListoParaImprimir ?>
      </div>

      <div class="signature-section">
        <span class="signature-label"><?= $Traducciones[4] ?></span>
        <canvas id="signature-canvas" width="550" height="180"></canvas>
        <div class="signature-actions">
          <button type="button" class="btn-clear" id="clear-signature"><?= $Traducciones[5] ?></button>
        </div>
      </div>
    </div>

    <div class="modal-contract-footer">
      <button type="button" id="btnSignContract" class="btn-submit-contract" disabled><?= $Traducciones[6] ?></button>
    </div>
  </div>
</div>
<?php
  }
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="js/index.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    populateCustomerFields()
    const purchasedCart = <?= $Sale['sale']['cart_json'] ? $Sale['sale']['cart_json'] : '[]' ?>;

  if (purchasedCart.length === 0) {
    document.getElementById('successPurchasedItemsList').innerHTML = `<p style="color:var(--color-ink-soft); font-size:0.9rem; padding:10px 0;"><?= $Traducciones[28] ?></p>`;
    return;
  }

  renderPostPurchaseSummary(purchasedCart);

  function renderPostPurchaseSummary(items) {
    const container = document.getElementById('successPurchasedItemsList');
    const subtotalLabel = document.getElementById('successSubtotal');
    const totalLabel = document.getElementById('successTotal');
    const paymentAmountLabel = document.getElementById('successPaymentAmount');

    if (!container) return;
    container.innerHTML = ''; 

    let totalCalculado = 0;

    items.forEach(item => {
      const itemTotal = item.price * item.quantity;
      totalCalculado += itemTotal;

      const singlePriceFormatted = item.price.toLocaleString('en-US', { style: 'currency', currency: 'USD' });

      const itemHTML = `
        <div class="purchased-item">
          <img src="${item.image}" class="purchased-item-img" alt="${item.name}">
          <div class="purchased-item-details">
            <span class="purchased-item-title">${item.name}</span>
            <span class="purchased-item-qty"><?= $Traducciones[29] ?>${item.quantity}</span>
          </div>
          <div class="purchased-item-price">${singlePriceFormatted}</div>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', itemHTML);
    });

    const totalString = totalCalculado.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    
    if (subtotalLabel) subtotalLabel.textContent = totalString;
    if (totalLabel) totalLabel.textContent = totalString;
    if (paymentAmountLabel) paymentAmountLabel.textContent = totalString;

    $('.cart-count').text(0);
  }

  function populateCustomerFields() {
    const emailStr = "<?= $Sale['client']['email'] ?>";
    document.getElementById('successCustomerEmail').textContent = emailStr;

    const addressHTML = `
      <?= $Sale['address']['Alias'] ?><br>
      <?= $Sale['address']['Street'] ?><br>
      <?= $Sale['address']['Colonia'] ?><br>
      <?= $Sale['address']['City'] ?><br>
      <?= $Sale['address']['State'].", ".$Sale['address']['Zip'] ?><br>
    `;
    document.getElementById('successShippingAddress').innerHTML = addressHTML;
  }

  localStorage.removeItem('brinca_cart');
  renderCart()
});

<?php 
if ($Sale['sale']['Contrato'] == 0){
?>
const canvas = document.getElementById('signature-canvas');
const ctx = canvas.getContext('2d');
const clearBtn = document.getElementById('clear-signature');
const submitBtn = document.getElementById('btnSignContract');
const modal = document.getElementById('contractModal');

let drawing = false;
let hasSigned = false;

function resizeCanvas() {
  const containerWidth = canvas.parentElement.clientWidth;
  
  canvas.width = containerWidth > 800 ? 800 : containerWidth - 10;
  canvas.height = 160;

  ctx.strokeStyle = "#0f172a"; 
  ctx.lineWidth = 3;            
  ctx.lineCap = "round";        
  ctx.lineJoin = "round";
}

function getMousePos(e) {
  const rect = canvas.getBoundingClientRect();
  
  if (e.touches && e.touches.length > 0) {
    return {
      x: e.touches[0].clientX - rect.left,
      y: e.touches[0].clientY - rect.top
    };
  }
  
  return {
    x: e.clientX - rect.left,
    y: e.clientY - rect.top
  };
}

canvas.addEventListener('mousedown', (e) => {
  drawing = true;
  const pos = getMousePos(e);
  ctx.beginPath();
  ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener('mousemove', (e) => {
  if (!drawing) return;
  const pos = getMousePos(e);
  ctx.lineTo(pos.x, pos.y);
  ctx.stroke();
  
  if (!hasSigned) {
    hasSigned = true;
    submitBtn.disabled = false; 
  }
});

window.addEventListener('mouseup', () => {
  drawing = false;
});

canvas.addEventListener('touchstart', (e) => {
  drawing = true;
  const pos = getMousePos(e);
  ctx.beginPath();
  ctx.moveTo(pos.x, pos.y);
  e.preventDefault(); 
}, { passive: false });

canvas.addEventListener('touchmove', (e) => {
  if (!drawing) return;
  const pos = getMousePos(e);
  ctx.lineTo(pos.x, pos.y);
  ctx.stroke();
  
  if (!hasSigned) {
    hasSigned = true;
    submitBtn.disabled = false;
  }
  e.preventDefault();
}, { passive: false });

canvas.addEventListener('touchend', () => {
  drawing = false;
});

clearBtn.addEventListener('click', () => {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  submitBtn.disabled = true;
  hasSigned = false;
});

submitBtn.addEventListener('click', () => {
  if (hasSigned) {
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="spinner-loading"></span><?= $Traducciones[30] ?>`;
    const dataURL = canvas.toDataURL(); 
    
    $('#img-firma-tabla').attr('src', dataURL).show();

    let contenido = $('#Contract').html(); 

    contenido = contenido.replace("*signeddate*", "<?php echo date('Y-m-d')?>")
                        .replace("*customerdsname*", $('#signer-name').val()); 

            const contenidoDiv = document.getElementById('Contract').innerHTML;            
            const datos = { 
                sale: '<?php echo $IdSale;?>',
                token: '<?php echo $Id;?>',
                contrato: contenidoDiv 
            };                        

    $('#Contract').html(contenido);           

            fetch('pdf.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                modal.style.display = 'none'; 
            })
            .catch((error) => {
                console.error('Error:', error);
            });        
  }
});

resizeCanvas();
window.addEventListener('resize', resizeCanvas);
window.addEventListener('resize', resizeCanvas);

<?php 
}
?>  
</script>
</body>
</html>