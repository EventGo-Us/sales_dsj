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
  <!-- HERO -->
  <?php
    require_once('hero.php');
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