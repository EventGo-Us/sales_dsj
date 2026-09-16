<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 

    // 1. VALIDACIÓN DE URL (id y token)
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    $isValid = false;
    $reviewData = null;
    $errorMessage = "El enlace de acceso ha expirado o es inválido.";

    if ($id > 0 && !empty($token)) {
        // Buscamos si existe el registro con ese token y que no haya sido usado

        $api_url = URL_API."validate_token_comment";
        $data = json_encode(['id' => $id,'token' => $token,]);
        $reviewData = json_decode(API($jwt,$api_url,$data,'GET'), true);        

        //die(print_r($reviewData));
        //$stmt = $pdo->prepare("SELECT id, author_name, author_meta FROM customer_reviews WHERE id = ? AND access_token = ? AND token_used = 0");
        //$stmt->execute([$id, $token]);
        //$reviewData = $stmt->fetch();

        if ($reviewData['data']) {
            $isValid = true;
        }
    }

    // 2. PROCESAMIENTO DEL FORMULARIO (POST)
    $successMessage = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isValid) {
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';

        if ($rating >= 1 && $rating <= 5 && !empty($review_text)) {
            try {

                $api_url = URL_API."set_comment";
                $data = json_encode(['id' => $id,'rating' => $rating,'review_text' => $review_text,]);
                $reviewData = json_decode(API($jwt,$api_url,$data,'POST'), true);               
                //die(print_r($reviewData));

                // Actualizamos la fila con el comentario del cliente y quemamos el token
                //$stmt = $pdo->prepare("UPDATE customer_reviews SET rating = ?, review_text = ?, token_used = 1, status = 'pending' WHERE id = ?");
                //$stmt->execute([$rating, $review_text, $id]);

                $successMessage = "¡Muchas gracias! Tu opinión ha sido enviada con éxito y será revisada por nuestro equipo.";
                $isValid = false; // Desactivar el formulario para que no se reenvíe
            } catch (PDOException $e) {
                $errorMessage = "Ocurrió un error al guardar tu comentario. Por favor, inténtalo más tarde.";
            }
        } else {
            $errorMessage = "Por favor, selecciona una calificación y escribe tu reseña.";
        }
    }    

?>
<title>Opiniones de Clientes — <?= COMPANY_NAME ?></title>
<meta name="description" content="Descubre las experiencias de empresas de renta y salones de eventos que han escalado sus negocios con inflables <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<style>
/* Reutilizando la base visual de tu hoja de estilos bento */
:root {
  --color-brand: #0066cc;
  --color-bg: #ffffff;
  --color-bg-soft: #f8fafc;
  --color-line: #e2e8f0;
  --color-line-strong: #cbd5e1;
  --color-ink: #0f172a;
  --color-ink-soft: #64748b;
  --color-rating: #f59e0b;
  --radius-md: 12px;
}

body {
  font-family: 'Inter', sans-serif;
  background-color: #f1f5f9;
  color: var(--color-ink);
  margin: 0;
  padding: 0;
}



.form-card {
  background: var(--color-bg);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 40px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
}

.form-header h1 {
  font-size: 1.75rem;
  font-weight: 800;
  letter-spacing: -0.03em;
  margin-bottom: 8px;
}

.form-header p {
  color: var(--color-ink-soft);
  font-size: 0.95rem;
  line-height: 1.5;
  margin-bottom: 32px;
}

/* Sistema de estrellas interactivas */
.rating-selector {
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
  gap: 8px;
  margin-bottom: 24px;
}

.rating-selector input {
  display: none;
}

.rating-selector label {
  font-size: 2.25rem;
  color: #e2e8f0;
  cursor: pointer;
  transition: color 0.15s ease;
}

.rating-selector label:hover,
.rating-selector label:hover ~ label,
.rating-selector input:checked ~ label {
  color: var(--color-rating);
}

.form-group {
  margin-bottom: 24px;
}

.form-group label {
  display: block;
  font-weight: 600;
  font-size: 0.88rem;
  margin-bottom: 8px;
}

.form-control {
  width: 100%;
  box-sizing: border-box;
  font-family: inherit;
  font-size: 0.95rem;
  padding: 12px 16px;
  border: 1px solid var(--color-line-strong);
  border-radius: 8px;
  outline: none;
  transition: border-color 0.2s ease;
}

.form-control:focus {
  border-color: var(--color-brand);
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.12);
}

.btn-submit {
  background: var(--color-brand);
  color: #fff;
  border: none;
  font-weight: 600;
  font-size: 0.95rem;
  padding: 14px 24px;
  border-radius: 8px;
  cursor: pointer;
  width: 100%;
  transition: background 0.2s ease;
}

.btn-submit:hover {
  background: #0052a3;
}

/* Alertas */
.alert {
  padding: 16px;
  border-radius: 8px;
  font-size: 0.94rem;
  line-height: 1.5;
  margin-bottom: 24px;
}
.alert-danger {
  background: #fef2f2;
  border: 1px solid #fee2e2;
  color: #991b1b;
}
.alert-success {
  background: #f0fdf4;
  border: 1px solid #dcfce7;
  color: #166534;
  text-align: center;
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
  <div class="form-card">
    
    <?php if (!empty($successMessage)): ?>
      <div class="alert alert-success">
        <div style="font-size: 3rem; margin-bottom: 10px;">🎉</div>
        <?= htmlspecialchars($successMessage) ?>
      </div>
    <?php endif; ?>

    <?php if (!$isValid && empty($successMessage)): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($errorMessage) ?>
      </div>
    <?php endif; ?>

    <?php if ($isValid): ?>
      <div class="form-header">
        <h1>¡Hola, <?= htmlspecialchars($reviewData['data']['author_name']) ?>!</h1>
        <p>Tu opinión es sumamente valiosa para nosotros. Cuéntanos qué tal fue tu experiencia con <?= COMPANY_NAME ?>.</p>
      </div>

      <form action="new_comment.php?id=<?= $id ?>&token=<?= htmlspecialchars($token) ?>" method="POST">
        
        <div class="form-group">
          <label>¿Cómo calificarías tu experiencia?</label>
          <div class="rating-selector">
            <input type="radio" id="star5" name="rating" value="5" required /><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4" /><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3" /><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2" /><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1" /><label for="star1">★</label>
          </div>
        </div>

        <div class="form-group">
          <label for="review_text">Tu reseña u opinión</label>
          <textarea id="review_text" name="review_text" class="form-control" rows="6" placeholder="Escribe aquí tu experiencia con nuestros productos, atención o tiempos de entrega..." required></textarea>
        </div>

        <button type="submit" class="btn-submit">Enviar Comentario</button>
      </form>
    <?php endif; ?>

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