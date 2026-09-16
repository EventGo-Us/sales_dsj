<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
?>
<title>Opiniones de Clientes — <?= COMPANY_NAME ?></title>
<meta name="description" content="Descubre las experiencias de empresas de renta y salones de eventos que han escalado sus negocios con inflables <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<style>
/* ============================================================
   0. TOKENS — Consistentes con <?= COMPANY_NAME ?>
   ============================================================ */


/* ============================================================
   2. CABECERA Y RESUMEN DE CALIFICACIONES
   ============================================================ */
.reviews-header {
  padding: 60px 0 40px;
  border-bottom: 1px solid var(--color-line);
  margin-bottom: 48px;
}
.header-grid {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 40px;
  align-items: center;
}
.header-text p {
  color: var(--color-ink-soft);
  font-size: 1.05rem;
  max-width: 600px;
  margin-top: 8px;
}

/* Tarjeta de promedio numérico */
.rating-summary-card {
  background: var(--color-bg-soft);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 24px;
  text-align: center;
}
.big-number {
  font-size: 3rem;
  font-weight: 800;
  line-height: 1;
  letter-spacing: -0.04em;
  color: var(--color-ink);
}
.stars-row {
  color: var(--color-rating);
  font-size: 1.2rem;
  margin: 6px 0;
}
.total-count {
  font-size: 0.84rem;
  color: var(--color-ink-soft);
  font-weight: 500;
}

/* ============================================================
   3. RETÍCULA DE TESTIMONIOS (GRID ESTILO BENTO)
   ============================================================ */
.reviews-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 80px;
}

.review-card {
  background: var(--color-bg);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 28px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.review-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px -10px rgba(22, 24, 29, 0.05);
}

/* Tarjeta destacada (toma 2 columnas de ancho) */
.review-card.featured {
  grid-column: span 2;
  background: var(--color-bg-soft);
  border-color: var(--color-line-strong);
}

.review-stars {
  color: var(--color-rating);
  font-size: 0.95rem;
  margin-bottom: 14px;
}
.review-text {
  font-size: 0.94rem;
  color: #2D3139;
  line-height: 1.6;
  margin-bottom: 20px;
  font-style: italic;
}
.review-card.featured .review-text {
  font-size: 1.05rem;
  color: var(--color-ink);
}

/* Autor del comentario */
.review-author {
  display: flex;
  align-items: center;
  gap: 12px;
  border-top: 1px solid var(--color-line);
  padding-top: 16px;
}
.review-card.featured .review-author {
  border-top-color: var(--color-line-strong);
}
.author-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--color-line-strong);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.85rem;
  color: var(--color-brand);
}
.author-info {
  display: flex;
  flex-direction: column;
}
.author-name {
  font-weight: 600;
  font-size: 0.88rem;
  color: var(--color-ink);
}
.author-meta {
  font-size: 0.78rem;
  color: var(--color-ink-soft);
}

/* ============================================================
   4. RESPONSIVO MÓVIL
   ============================================================ */
@media (max-width: 900px) {
  .reviews-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .review-card.featured {
    grid-column: span 2;
  }
}

@media (max-width: 700px) {
  .header-grid {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .reviews-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .review-card.featured {
    grid-column: span 1;
  }
  .reviews-header {
    padding: 40px 0 24px;
  }
}
</style>
</head>

<body>
<?php 
  require_once ('nav.php');
?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "comments"]);
    //$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<div class="wrap">
  
  <header class="reviews-header">
    <div class="header-grid">
      <div class="header-text">
        <h1>Casos de éxito y opiniones</h1>
        <p>Conoce las experiencias reales de arrendadores, salones de fiestas y emprendedores que han construido flotillas rentables con nuestros inflables comerciales.</p>
      </div>
      
      <div class="rating-summary-card">
        <span class="big-number" id="avg_label">4.9</span>
        <div class="stars-row" id="avg_stars">★★★★★</div>
        <span class="total-count">Basado en todos los comentarios</span>
      </div>
    </div>
  </header>


<!-- Filtros interactivos opcionales -->
<div style="margin-bottom: 24px; display: flex; gap: 12px; justify-content: flex-end;">
  <button class="btn-filter active" onclick="loadReviews('relevant')">Más relevantes</button>
  <button class="btn-filter" onclick="loadReviews('recent')">Más recientes</button>
</div>

<!-- El contenedor ahora se llenará dinámicamente -->
<main class="reviews-grid" id="reviews-container">
    <!-- Los artículos generados por la API aparecerán aquí -->
</main>  



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
function loadReviews(sortBy = 'relevant') {
    const container = $('#reviews-container');
    container.html('<p style="grid-column: 1/-1; text-align:center;">Cargando opiniones...</p>');
    
    // Actualizar estados visuales de los botones
    $('.btn-filter').removeClass('active');
    event?.target?.classList?.add('active');

    // Cambia la ruta por la ubicación real de tu API PHP
    $.ajax({
        url: url_api +'sale_comments',
        method: 'POST',
        data: JSON.stringify({ sort: sortBy, limit: 12 }),
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + token,
            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
            'LNG': '<?= $_SESSION['Idioma'] ?>'
        },        
        success: function(response) {

            const stars_avg = '★'.repeat(response.avg) + '☆'.repeat(5 - response.avg);
            const avg_label = $('#avg_label');
            const avg_stars = $('#avg_stars');

            avg_label.html(response.avg)
            avg_stars.html(stars_avg)

            container.empty();
            if(response.data.length === 0) {
                container.html('<p style="grid-column: 1/-1; text-align:center;">No hay opiniones disponibles por el momento.</p>');
                return;
            }

            response.data.forEach(function(review) {
                // Generar estrellas visuales basadas en el número (rating)
                const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                
                // Determinar si aplica la clase CSS "featured" (bento grid)
                const featuredClass = review.is_featured == 1 ? 'featured' : '';

                const reviewHtml = `
                    <article class="review-card ${featuredClass}">
                      <div>
                        <div class="review-stars">${stars}</div>
                        <p class="review-text">"${review.review_text}"</p>
                      </div>
                      <div class="review-author">
                        <div class="author-avatar">${review.avatar_initials}</div>
                        <div class="author-info">
                          <span class="author-name">${review.author_name}</span>
                          <span class="author-meta">${review.author_meta}</span>
                        </div>
                      </div>
                    </article>
                `;
                container.append(reviewHtml);
            });
        },
        error: function() {
            container.html('<p style="grid-column: 1/-1; text-align:center; color:red;">Ocurrió un error al cargar las opiniones.</p>');
        }
    });
}

// Carga inicial automática al abrir la página
$(document).ready(function() {
    loadReviews('relevant');
});
</script>

</body>
</html>