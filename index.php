<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
?>
<title><?= COMPANY_NAME ?> — Construimos la diversión que impulsa tu negocio.</title>
<meta name="description" content="Brincolines, combos, toboganes de agua e inflables comerciales al mayoreo. Vinil 18oz, costuras reforzadas y envíos a toda la República.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

</head>
<body>
  <?php 
    require_once ('nav.php');
  ?>
<main>


<section id="banner" class="banner-band" aria-label="Promociones destacadas">
  <div class="banner-carousel" role="group" aria-roledescription="carrusel">
    <div class="banner-carousel-slides">
      <div class="banner-slide is-active" role="group" aria-roledescription="diapositiva" aria-label="1 de 3">
        <img src="<?= URL_BASE ?>/images/banner/slide_1.webp" alt="Inflables fabricados bajo pedido en Estados Unidos" fetchpriority="high">
      </div>
      <div class="banner-slide" role="group" aria-roledescription="diapositiva" aria-label="2 de 3" aria-hidden="true">
        <img src="<?= URL_BASE ?>/images/banner/slide_2.webp" alt="Sillas para eventos">
      </div>
      <div class="banner-slide" role="group" aria-roledescription="diapositiva" aria-label="3 de 3" aria-hidden="true">
        <img src="<?= URL_BASE ?>/images/banner/slide_3.webp" alt="Carpas para eventos en oferta">
      </div>
    </div>
    <div class="banner-indicators" role="group" aria-label="Indicadores de posición">
      <button class="banner-indicator is-active" type="button" aria-label="Mostrar imagen 1" aria-pressed="true"></button>
      <button class="banner-indicator" type="button" aria-label="Mostrar imagen 2" aria-pressed="false"></button>
      <button class="banner-indicator" type="button" aria-label="Mostrar imagen 3" aria-pressed="false"></button>
    </div>
  </div>
</section>
  <!-- HERO -->
  <?php
    //require_once('hero.php');
  ?>
  <hr class="divider-full">
  <!-- CATEGORÍAS -->
  <?php 
    require_once('cat.php');
  ?>
  <!-- EN STOCK -->
  <?php
    require_once('stock.php');
  ?>
  <!-- FEATURES -->
  <?php
    require_once('features.php');
  ?>
  <!-- NUEVOS DISEÑOS -->
  <?php
    require_once('new_designs.php');
  ?>
  <hr class="divider-full">
  <!-- COLECCIONES -->
  <?php
    //require_once('all_cat.php');
  ?>
  <!-- NEWSLETTER -->
  <?php
  require_once('news.php');
  ?>
</main>

<?php
  require_once('foot.php');
  require_once('cart.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="js/index.js"></script>

<script>

</script>
</body>
</html>