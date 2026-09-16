<?php
    ob_start();
    session_start();
    //echo $_SESSION['Idioma']."**";
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 

    $Product = str_replace("-"," ",$_GET['Id']);
    $IdP = str_replace("-"," ",$_GET['Idp']);
?>
<title><?= $Product; ?> - <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../css/product.css">
<link rel="stylesheet" href="../css/cart.css">

<style>
/* ============================================================
   EFECTO ZOOM INTERNO PARA LA GALERÍA
   ============================================================ */
.main-image {
  position: relative;
  overflow: hidden; /* Oculta todo lo que se salga del recuadro al hacer zoom */
  cursor: zoom-in;   /* Cambia el cursor a una lupa de acercamiento */
  border-radius: var(--radius-md); /* Mantiene la consistencia visual */
}

#productMainImg {
  width: 100%;
  height: 100%;
  object-fit: cover;
  /* El transition suaviza la entrada/salida y el movimiento del puntero */
  transition: transform 0.15s ease-out, transform-origin 0.05s ease-out;
  will-change: transform, transform-origin;
}

</style>
</head>

<body>
<?php 
  require_once ('nav.php');
?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "product"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);

    $api_url = URL_API."products_sale";
    $data = json_encode(["Product" => $Product ,"IdP" => $IdP ]);
    $data = json_decode(API($jwt,$api_url,$data,'POST'), true);    
    foreach ($data['data'] as $producto) {
      $Nombre_sc = $producto['Nombre_sc']
?>

<div class="breadcrumbs wrap">
  <?php
  if ($Nombre_sc != ""):
  ?>    

    <a href="../products/all"><?= Trd(3); ?></a>
    <span>/</span><a href="../products/<?= str_replace(" ","-",$producto['Nombre']) ?>"><?php echo $producto['Nombre']?></a>
    <span>/</span><a href="../products/<?= str_replace(" ","-",$producto['Nombre'])."/".str_replace(" ","-",$producto['Nombre_sc']) ?>"><?php echo $producto['Nombre_sc']?></a>
    <span>/</span><?php echo $producto['Name']?>
  <?php
  else:
  ?>
    <a href="../products/all"><?= Trd(3); ?></a><span>/</span><a href="../products/<?= str_replace(" ","-",$producto['Nombre']) ?>"><?php echo $producto['Nombre']?></a><span>/</span><?php echo $producto['Name']?>
  <?php
  endif;
  ?>

</div>

<main class="wrap product-detail-layout">
  <section class="product-gallery">
    <div class="main-image">
      <?php 
          foreach ($data['Image'] as $Image) {
              $URLImagep = URL_IMAGES.'/products_images/originals/'.$Image['Image'];
          }
      ?>    
      <img id="productMainImg" src="<?= $URLImagep ?>" alt="<?= $producto['Name'] ?>">
    </div>

    <div class="thumbnail-grid">
      <?php 
          foreach ($data['Images'] as $Image) {
              $OURLImage = "'".URL_IMAGES.'/products_images/originals/'.$Image['Image']."'";
              $URLImage = URL_IMAGES.'/products_images/thumbnails/'.$Image['Image'];
              echo '
                <div class="thumb-item active" onclick="changeImage(this, '.$OURLImage.')">
                  <img src="'.$URLImage.'" alt="'.$producto['Name'].'">
                </div>
              ';
          }
      ?>
    </div>
  </section>

  <section class="product-info-panel">
    <div class="product-meta-top">
      <span class="product-vendor"><?= COMPANY_NAME ?><?= Trd(4); ?></span>
      <h1><?php echo $producto['Name']?></h1>
      <div class="product-status-tag"><?= Trd(5); ?></div>
    </div>

    <div class="product-price-box">
      <div>
        <?php
          if ($producto['Discount'] > 0){
            echo '
              <span class="detail-price-sale">$'.number_format($producto['SalePrice'] - $producto['Discount'], 2, ".", ",") .'</span>
              <span class="detail-price-regular">$'.number_format($producto['SalePrice'], 2, ".", ",").'</span>            
            ';            
          }
          else{
            echo '
              <span class="detail-price-sale">$$'.number_format($producto['SalePrice'], 2, ".", ",").'</span>
            ';
          }
        ?>
        <span class="price-tax-note"><?= Trd(6); ?></span>
      </div>
    </div>

        <div class="products-legend-bar">
        <?php
                if ($producto['NewDesign'] == 1 || $producto['NewDesign'] === true) {
                    echo  '<span class="legend-item"><span class="dot-icon dot-new"></span>' . Trd(7) . '</span>';
                }
                if ($producto['Featured'] == 1) {
                    echo  '<span class="legend-item"><span class="dot-icon dot-featured"></span>' . Trd(8) . '</span>';
                }
                if ($producto['OnlyRequest'] == 1) {
                    echo  '<span class="legend-item"><span class="dot-icon dot-request"></span>' . Trd(9) . '</span>';
                } else {
                    echo '<span class="legend-item"><span class="dot-icon dot-stock"></span>' . Trd(10) . '</span>';
                }
        ?>        
        </div>


    <div class="product-description-short">
      <p>
      <?php
        if ($_SESSION['Idioma'] =='es')
          echo $producto['Sale_Description_es'];
        else
          echo $producto['Sale_Description'];

        foreach ($data['Stock'] as $Stock) {

        }

      ?>

      </p>
    </div>
<div class="purchase-selectors">
  <div>
    <span class="selector-label"><?= Trd(11); ?></span>
    <div class="qty-selector">
      <button class="qty-btn" onclick="updateQty(-1, <?= ($producto['OnlyRequest'] == 1) ? 999 : $Stock['Quantity'] ?>)">−</button>
      <input type="number" id="quantity" class="qty-input" value="1" min="1" max="<?= ($producto['OnlyRequest'] == 1) ? 999 : $Stock['Quantity'] ?>" aria-label="Cantidad de piezas">
      <button class="qty-btn" onclick="updateQty(1, <?= ($producto['OnlyRequest'] == 1) ? 999 : $Stock['Quantity'] ?>)">+</button>
    </div>
  </div>

  <div class="purchase-actions">
    <button class="btn-primary" 
            id="btnAddToCart"
            data-id="<?= $producto['Id'] ?>"
            data-name="<?= htmlspecialchars($producto['Name']) ?>"
            data-price="<?= ($producto['Discount'] > 0) ? ($producto['SalePrice'] - $producto['Discount']) : $producto['SalePrice'] ?>"
            data-image="<?= $URLImagep ?>"
            data-onlyrequest="<?= $producto['OnlyRequest'] ?>"
            data-stock="<?= $Stock['Quantity'] ?>">
            <?= Trd(12); ?>
    </button>
    <button class="btn-outline"><?= Trd(13); ?></button>
  </div>
</div>

    <div class="specs-widget">
      <h3><?= Trd(14); ?></h3>
      <table class="specs-table">
        <tr>
          <td><?= Trd(15); ?></td>
          <td><?= $producto['ActualSize'] ?></td>
        </tr>
        <tr>
          <td><?= Trd(16); ?></td>
          <td><?= $producto['Materials'] ?></td>
        </tr>
        <tr>
          <td><?= Trd(17); ?></td>
          <td><?= $producto['Unions'] ?></td>
        </tr>
        <tr>
          <td><?= Trd(18); ?></td>
          <td><?= $producto['Capacity'] ?></td>
        </tr>
        <tr>
          <td><?= Trd(19); ?></td>
          <td><?= $producto['Includes'] ?></td>
        </tr>
        <?php
        
        if ($producto['OnlyRequest'] == 1) {
          echo "
            <tr>
              <td>" . Trd(20) . "</td>
              <td>".$producto['Production_days']. Trd(21) . "</td>
            </tr>          
          ";
        }

        ?>
      </table>
    </div>
  </section>
</main>

<?php 
  }
  require_once ('related.php');
  require_once('news.php');
  require_once('foot.php');
  require_once('cart.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="../js/index.js"></script>

<script>
/* Objeto de configuración para inyectar traducciones de PHP a JS de forma segura */
const translations = {
  stockLimitTitle: `<?= Trd(22); ?>`,
  stockLimitText1: `<?= Trd(23); ?>`,
  stockLimitText2: `<?= Trd(24); ?>`,
  btnGotIt: `<?= Trd(25); ?>`,
  limitExceededTitle: `<?= Trd(26); ?>`,
  limitExceededText1: `<?= Trd(27); ?>`,
  limitExceededText2: `<?= Trd(28); ?>`,
  btnReviewCart: `<?= Trd(29); ?>`,
  invalidQtyTitle: `<?= Trd(30); ?>`,
  invalidQtyText: `<?= Trd(31); ?>`,
  btnCorrectQty: `<?= Trd(32); ?>`
};

/* Lógica Simple de la Galería */
function changeImage(thumbElement, fullImgUrl) {
  document.getElementById('productMainImg').src = fullImgUrl;
  document.querySelectorAll('.thumb-item').forEach(item => item.classList.remove('active'));
  thumbElement.classList.add('active');
}


/* Selector de Cantidad */
function updateQty(val) {
  const qtyInput = document.getElementById('quantity');
  let currentQty = parseInt(qtyInput.value) || 1;
  currentQty += val;
  if(currentQty < 1) currentQty = 1;
  qtyInput.value = currentQty;
}


/* Lógica de Zoom dinámico al pasar el puntero */
const mainImageContainer = document.querySelector('.main-image');
const mainImg = document.getElementById('productMainImg');

if (mainImageContainer && mainImg) {
  // Cuando el ratón se mueve dentro del contenedor
  mainImageContainer.addEventListener('mousemove', (e) => {
    const rect = mainImageContainer.getBoundingClientRect();
    
    // Calcula la posición exacta del cursor dentro del contenedor (en pixeles)
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // Convierte la posición a porcentaje (0% a 100%)
    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;
    
    // Mueve el centro de coordenadas del zoom hacia el puntero y escala la imagen
    mainImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    mainImg.style.transform = 'scale(2)'; // Ajusta a 2.5 si quieres más aumento
  });

  // Cuando el ratón sale del contenedor, regresa a la normalidad de forma suave
  mainImageContainer.addEventListener('mouseleave', () => {
    mainImg.style.transform = 'scale(1)';
    mainImg.style.transformOrigin = 'center center';
  });
}



/* ============================================================
   LÓGICA DEL CARRITO DE COMPRAS CON LOCALSTORAGE
   ============================================================ */
// Reemplazar la función anterior de cantidad para que valide límites de stock en tiempo real
function updateQty(val, maxStock) {
  const qtyInput = document.getElementById('quantity');
  let currentQty = parseInt(qtyInput.value) || 1;
  currentQty += val;
  
  if (currentQty < 1) currentQty = 1;
  if (currentQty > maxStock) {
    Swal.fire({
      title: translations.stockLimitTitle,
      text: `${translations.stockLimitText1}${maxStock}${translations.stockLimitText2}`,
      icon: 'warning',
      confirmButtonText: translations.btnGotIt,
      customClass: {
        confirmButton: 'swal2-confirm'
      }
    });    
    currentQty = maxStock;
  }
  qtyInput.value = currentQty;
}


document.addEventListener('DOMContentLoaded', () => {

  // Escuchador del botón "Añadir al Carrito" (Solo se activa si el botón existe en la página actual)
  const btnAddToCart = document.getElementById('btnAddToCart');
  if (btnAddToCart) {
    btnAddToCart.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const name = this.getAttribute('data-name');
      const price = parseFloat(this.getAttribute('data-price'));
      const image = this.getAttribute('data-image');
      const onlyRequest = parseInt(this.getAttribute('data-onlyrequest')) === 1;
      const maxStock = parseInt(this.getAttribute('data-stock')) || 0;
      const quantityToAdd = parseInt(document.getElementById('quantity').value) || 1;

      const existingProductIndex = cart.findIndex(item => item.id === id);

      if (existingProductIndex > -1) {
        let newQty = cart[existingProductIndex].quantity + quantityToAdd;
        
        if (!onlyRequest && newQty > maxStock) {
          Swal.fire({
            title: translations.limitExceededTitle,
            text: `${translations.limitExceededText1}${cart[existingProductIndex].quantity}${translations.limitExceededText2}${maxStock}.`,
            icon: 'warning',
            confirmButtonText: translations.btnReviewCart,
            customClass: {
              confirmButton: 'swal2-confirm'
            }
          });          
          cart[existingProductIndex].quantity = maxStock;
        } else {
          cart[existingProductIndex].quantity = newQty;
        }
      } else {
        if (!onlyRequest && quantityToAdd > maxStock) {
          Swal.fire({
            title: translations.invalidQtyTitle,
            text: `${translations.invalidQtyText}${maxStock} unidades.`,
            icon: 'warning',
            confirmButtonText: translations.btnCorrectQty,
            customClass: {
              confirmButton: 'swal2-confirm'
            }
          });          
          return;
        }
        
        cart.push({
          id: id,
          name: name,
          price: price,
          image: image,
          quantity: quantityToAdd,
          onlyRequest: onlyRequest,
          maxStock: maxStock
        });
      }

      saveCart();
      renderCart();
      
      // Animaciones de feedback visual
      const $boton = $(this);
      $boton.addClass('btn-clicked');
      setTimeout(() => $boton.removeClass('btn-clicked'), 150);

      const $contador = $('.cart-count');
      $contador.addClass('pop-animation');
      setTimeout(() => $contador.removeClass('pop-animation'), 400);      

      // Desplegar el sidebar del carrito
      const cartDrawer = document.getElementById('cartDrawer');
      if (cartDrawer) {
        cartDrawer.setAttribute('aria-hidden', 'false');
      }
    });
  }
});
</script>
</body>
</html>