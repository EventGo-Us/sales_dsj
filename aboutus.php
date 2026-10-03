<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
?>
<title>Quiénes Somos — <?= COMPANY_NAME ?></title>
<meta name="description" content="Conoce la trayectoria de <?= COMPANY_NAME ?>, fabricantes y distribuidores líderes de brincolines e inflables de uso rudo en México.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<style>


/* ============================================================
   2. SECCIONES DE LA PÁGINA
   ============================================================ */

/* Hero Simplificado */
.about-hero {
  padding: 80px 0 56px;
  text-align: center;
  border-bottom: 1px solid var(--color-line);
  background: linear-gradient(180deg, var(--color-bg-soft) 0%, var(--color-bg) 100%);
}
.about-hero p {
  font-size: 1.1rem;
  color: var(--color-ink-soft);
  max-width: 700px;
  margin: 0 auto;
}

/* Bloques de Contenido (Historia e Infraestructura) */
.about-split {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 64px;
  padding: 64px 0;
  align-items: center;
}
.about-split.reverse {
  direction: rtl;
}
.about-split.reverse .split-text {
  direction: ltr;
}
.split-image-placeholder {
  background: var(--color-bg-soft);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  aspect-ratio: 4 / 3;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--color-ink-faint);
  font-weight: 500;
  font-size: 0.9rem;
}

/* Bloque de Valores / Pilares de Fábrica */
.values-section {
  background: var(--color-bg-soft);
  padding: 64px 0;
  border-top: 1px solid var(--color-line);
  border-bottom: 1px solid var(--color-line);
}
.values-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
  margin-top: 32px;
}
.value-card {
  background: var(--color-bg);
  padding: 24px;
  border-radius: var(--radius-md);
  border: 1px solid var(--color-line);
}
.value-card h3 {
  color: var(--color-brand);
}
.value-card p {
  font-size: 0.9rem;
  color: var(--color-ink-soft);
}

/* Sección de Localización y Mapa */
.map-section {
  padding: 64px 0 80px;
}
.map-layout {
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 48px;
  margin-top: 32px;
  align-items: start;
}
.map-info-box {
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 24px;
}
.map-info-box ul {
  margin: 16px 0 0 0;
  padding-left: 20px;
  font-size: 0.9rem;
  color: var(--color-ink-soft);
}
.map-info-box li {
  margin-bottom: 8px;
}

/* Contenedor del Mapa (Mantiene proporción responsiva) */
.map-container {
  width: 100%;
  height: 450px;
  border-radius: var(--radius-md);
  overflow: hidden;
  border: 1px solid var(--color-line);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}
.map-container iframe {
  width: 100%;
  height: 100%;
  border: 0;
}

/* ============================================================
   3. RESPONSIVO MÓVIL
   ============================================================ */
@media (max-width: 860px) {
  .about-split, .about-split.reverse {
    grid-template-columns: 1fr;
    gap: 32px;
    padding: 40px 0;
  }
  .about-split.reverse {
    direction: ltr;
  }
  .values-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .map-layout {
    grid-template-columns: 1fr;
    gap: 32px;
  }
  .map-container {
    height: 320px;
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
    $data = json_encode(['program' => "aboutus"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<section class="about-hero">
  <div class="wrap">
    <h1><?= Trd(1); ?></h1>
    <p><?= Trd(2); ?></p>
  </div>
</section>

<div class="wrap">
  
  <article class="about-split">
    <div class="split-text">
      <?php
      if (strtoupper($_SESSION['Idioma'])== 'ES'){
      ?>
      <h2><?= Trd(3); ?></h2></br>
      <p>Con sede en Rialto California, brindamos un servicio cercano, profesional y enfocado en las necesidades de la industria del entretenimiento. Entendemos que la compra de un inflable es una inversión importante; por ello, ofrecemos productos diseñados para ofrecer un excelente rendimiento y una larga vida útil.</p>
      </br>
      <p>Como distribuidores autorizados de Bouncing Angels, una marca reconocida por su trayectoria, innovación y prestigio en la fabricación de inflables, ponemos al alcance de nuestros clientes productos que cumplen con altos estándares de calidad y desempeño. Esta alianza nos permite ofrecer soluciones confiables para quienes buscan ampliar su inventario o iniciar un negocio exitoso de renta de brincolines.</p>
      </br>
      <p>Nuestra misión es convertirnos en el socio comercial de confianza para emprendedores y empresas del sector, ofreciendo inflables que combinan innovación, calidad y rentabilidad, respaldados por un servicio que genera relaciones duraderas.</p>
      </br>
      <p>D´s Jumpers es sinónimo de confianza, calidad y compromiso. Más que vender inflables, ayudamos a construir negocios exitosos y a crear experiencias inolvidables para miles de familias.</p>
      <?php
      }else{
      ?>
      <h2><?= Trd(3); ?></h2></br>
      <p>Based in Rialto, California, we provide a close, professional service focused on the needs of the entertainment industry. We understand that purchasing an inflatable is a significant investment; therefore, we offer products designed to deliver excellent performance and a long lifespan.</p>
      </br>
      <p>As authorized distributors of Bouncing Angels—a brand recognized for its track record, innovation, and prestige in inflatable manufacturing—we bring our customers products that meet high standards of quality and performance. This partnership allows us to offer reliable solutions for those looking to expand their inventory or start a successful bounce house rental business.</p>
      </br>
      <p>Our mission is to become the trusted business partner for entrepreneurs and companies in the sector, offering inflables that combine innovation, quality, and profitability, backed by a service that builds lasting relationships.</p>
      </br>
      <p>D´s Jumpers is synonymous with trust, quality, and commitment. More than just selling inflatables, we help build successful businesses and create unforgettable experiences for thousands of families.</p>      
      <?php
      }
      ?>      
    </div>
    <div class="split-image-placeholder">
      <span>[ Fotografía de nuestro Taller de Producción ]</span>
    </div>
  </article>

</div>

<section class="values-section">
  <div class="wrap">
    <h2 style="text-align: center;"><?= Trd(4); ?></h2>
    <div class="values-grid">
      
      <div class="value-card">
        <h3><?= Trd(5); ?></h3></br>
        <p><?= Trd(6); ?></p>
      </div>

      <div class="value-card">
        <h3><?= Trd(7); ?></h3></br>
        <p><?= Trd(8); ?></p>
      </div>

      <div class="value-card">
        <h3><?= Trd(9); ?></h3></br>
        <p><?= Trd(10); ?></p>
      </div>

    </div>
    </br>
    <h3 style="text-align: center;"><?= Trd(11); ?></h3>    
  </div>
</section>

<section class="wrap map-section">
  <h2><?= Trd(12); ?></h2>
  <p><?= Trd(13); ?></p>
  
  <div class="map-layout">
    
    <div class="map-info-box">
      <h3><?= Trd(14); ?></h3>
      <p style="font-size: 0.92rem; font-weight: 500;">
<?php
        echo "9242 Hyssop Dr. <br>";
        echo "Rancho Cucamonga CA <br>";
        echo "91730";
?>
      </p>
<!--
      <ul>
        <li>A 10 minutos de Periférico Norte.</li>
        <li>Estacionamiento techado para carga y descarga de mercancía pesada.</li>
        <li>Atención previa cita para cotizaciones de flotillas.</li>
      </ul>
-->
    </div>

    <div class="map-container">
<?php
$lat = $account['account'][0]['Lat']; // tu latitud desde PHP
$lng = $account['account'][0]['Lng']; // tu longitud desde PHP
?>
<iframe 
    src="https://maps.google.com/maps?q=<?= $lat ?>,<?= $lng ?>&z=16&output=embed"
    width="100%" 
    height="400" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
    </div>

  </div>
</section>
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

</body>
</html>