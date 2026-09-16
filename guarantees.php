<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
?>
<title>Políticas de Garantía — <?= COMPANY_NAME ?></title>
<meta name="description" content="Conoce los plazos y la cobertura de garantía de nuestros inflables comerciales, motores y accesorios de uso rudo.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/product.css">
<link rel="stylesheet" href="css/cart.css">

<style>
/* ============================================================
   ESTILOS ESPECÍFICOS PARA LA PÁGINA DE GARANTÍAS
   ============================================================ */
.warranty-hero {
  background: var(--color-bg-soft, #F7F7F5);
  border-bottom: 1px solid var(--color-line, #E6E6E2);
  padding: 60px 0;
  text-align: center;
}
.warranty-hero h1 {
  font-size: 2.4rem;
  font-weight: 800;
  letter-spacing: -0.03em;
  margin: 0 0 12px 0;
  color: var(--color-ink, #16181D);
}
.warranty-hero p {
  font-size: 1.05rem;
  color: var(--color-ink-soft, #6B7077);
  max-width: 650px;
  margin: 0 auto;
}

.warranty-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 48px;
  margin: 48px auto 80px auto;
}

/* Rejilla de Coberturas */
.warranty-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-bottom: 40px;
}
.warranty-card {
  border: 1px solid var(--color-line, #E6E6E2);
  border-radius: var(--radius-md, 8px);
  padding: 24px;
  background: var(--color-bg, #FFFFFF);
}
.warranty-card-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}
.warranty-badge {
  background: #E0E7FF;
  color: var(--color-brand, #173A8A);
  font-size: 0.78rem;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: var(--radius-sm, 4px);
  text-transform: uppercase;
}
.warranty-card h3 {
  font-size: 1.1rem;
  font-weight: 700;
  margin: 0;
  color: var(--color-ink, #16181D);
}
.warranty-card p {
  font-size: 0.9rem;
  color: var(--color-ink-soft, #6B7077);
  margin: 0;
  line-height: 1.5;
}

/* Tabla de Periodos */
.warranty-section-title {
  font-size: 1.3rem;
  font-weight: 700;
  letter-spacing: -0.01em;
  margin: 0 0 20px 0;
  border-bottom: 2px solid var(--color-ink, #16181D);
  padding-bottom: 8px;
}

.warranty-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 40px;
  font-size: 0.9rem;
}
.warranty-table th, .warranty-table td {
  padding: 12px 16px;
  text-align: left;
  border-bottom: 1px solid var(--color-line, #E6E6E2);
}
.warranty-table th {
  background: var(--color-bg-soft, #F7F7F5);
  font-weight: 700;
  color: var(--color-ink, #16181D);
}
.warranty-table td strong {
  color: var(--color-brand, #173A8A);
}

/* Contenido de restricciones */
.bullet-list {
  padding-left: 20px;
  margin: 0 0 32px 0;
}
.bullet-list li {
  font-size: 0.9rem;
  color: var(--color-ink-soft, #6B7077);
  margin-bottom: 10px;
  line-height: 1.5;
}

/* Barra lateral de reclamos */
.sidebar-claim-card {
  background: var(--color-bg-soft, #F7F7F5);
  border: 1px solid var(--color-line, #E6E6E2);
  border-radius: var(--radius-md, 8px);
  padding: 24px;
  position: sticky;
  top: 24px;
}
.sidebar-claim-card h4 {
  font-size: 1.05rem;
  font-weight: 700;
  margin: 0 0 12px 0;
  color: var(--color-ink, #16181D);
}
.sidebar-claim-card p {
  font-size: 0.85rem;
  color: var(--color-ink-soft, #6B7077);
  margin: 0 0 16px 0;
  line-height: 1.5;
}
.btn-claim-whatsapp {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: #25D366;
  color: #FFFFFF;
  text-decoration: none;
  font-size: 0.88rem;
  font-weight: 700;
  padding: 12px;
  border-radius: var(--radius-sm, 4px);
  text-align: center;
  transition: background 0.15s ease;
}
.btn-claim-whatsapp:hover {
  background: #128C7E;
}
.claim-note {
  font-size: 0.75rem;
  color: var(--color-ink-faint, #9A9EA4);
  display: block;
  margin-top: 12px;
  text-align: center;
}

/* Responsivo */
@media (max-width: 900px) {
  .warranty-layout {
    grid-template-columns: 1fr;
    gap: 32px;
  }
  .warranty-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .sidebar-claim-card {
    position: static;
  }
}
</style>
</head>

<body>
<?php require_once ('nav.php'); ?>


<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "guarantees"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<section class="warranty-hero">
  <div class="wrap">
    <h1><?=  Trd(1) ?></h1>
    <p><?=  Trd(2) ?></p><br>
    <p><?=  Trd(3) ?></p><br>
  </div>
</section>

<div class="wrap">
  <div class="warranty-layout">
    
    <main>
      <h2 class="warranty-section-title"><?=  Trd(4) ?></p></h2>
      <div class="warranty-grid">
        
        <div class="warranty-card">
          <div class="warranty-card-header">
            <span class="warranty-badge"><?=  Trd(5) ?></p></span>
          </div>
          <h3><?=  Trd(6) ?></p></h3>
          <p><?=  Trd(7) ?></p></p>
        </div>

        <div class="warranty-card">
          <div class="warranty-card-header">
            <span class="warranty-badge"><?=  Trd(8) ?></p></span>
          </div>
          <h3><?=  Trd(9) ?></h3>
          <p><?=  Trd(10) ?></p>
        </div>

        <div class="warranty-card">
          <div class="warranty-card-header">
            <span class="warranty-badge"><?=  Trd(11) ?></span>
          </div>
          <h3><?=  Trd(12) ?></h3>
          <p><?=  Trd(13) ?></p>
        </div>

        <div class="warranty-card">
          <div class="warranty-card-header">
            <span class="warranty-badge"><?=  Trd(14) ?></span>
          </div>
          <h3><?=  Trd(15) ?></h3>
          <p><?=  Trd(16) ?></p>
        </div>

      </div>

      <h2 class="warranty-section-title">Tiempos de Garantía por Categoría</h2>
      <table class="warranty-table">
        <thead>
          <tr>
            <th>Línea de Producto / Componente</th>
            <th>Uso Recomendado</th>
            <th>Periodo de Garantía</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Toboganes de Agua e Inflables Interactivos</strong></td>
            <td>Comercial de Alto Impacto</td>
            <td><strong>2 Años</strong> ante costuras y vinil</td>
          </tr>
          <tr>
            <td><strong>Brincolines Clásicos y Combos Básicos</strong></td>
            <td>Comercial Estándar</td>
            <td><strong>1 Año</strong> ante costuras y vinil</td>
          </tr>
          <tr>
            <td><strong>Motores de Inflado (Sopladores de 1.0 HP / 1.5 HP)</strong></td>
            <td>Continuo / Rudo</td>
            <td><strong>1 Año</strong> en sistema eléctrico</td>
          </tr>
          <tr>
            <td><strong>Carpas Comerciales y Lonas de Sombra</strong></td>
            <td>Exterior Fijo</td>
            <td><strong>6 Meses</strong> estructurales</td>
          </tr>
          <tr>
            <td><strong>Bolsas de Almacenamiento y Kits de Parches</strong></td>
            <td>Accesorios</td>
            <td><strong>30 Días</strong> por defectos de fábrica</td>
          </tr>
        </tbody>
      </table>

      <h2 class="warranty-section-title"><?=  Trd(27) ?></h2>
      <p style="font-size:0.9rem; color:var(--color-ink-soft); margin-bottom: 12px;"><?=  Trd(28) ?></p><br>
      <p style="font-size:0.9rem; color:var(--color-ink-soft); margin-bottom: 12px;"><?=  Trd(29) ?></p>
      <ul class="bullet-list">
        <li><b><?=  Trd(30) ?>:</b> <?=  Trd(31) ?></li>
        <li><b><?=  Trd(32) ?>:</b> <?=  Trd(33) ?></li>
        <li><b><?=  Trd(34) ?>:</b> <?=  Trd(35) ?></li>
        <li><b><?=  Trd(36) ?>:</b> <?=  Trd(37) ?></li>
        <li><b><?=  Trd(38) ?>:</b> <?=  Trd(39) ?></li>
        <li><b><?=  Trd(40) ?>:</b> <?=  Trd(41) ?></li>
      </ul>
      <p style="font-size:0.9rem; color:var(--color-ink-soft); margin-bottom: 12px;"><?=  Trd(42) ?></p><br>
      <p style="font-size:0.9rem; color:var(--color-ink-soft); margin-bottom: 12px;"><?=  Trd(43) ?></p>
    </main>

    <aside>
      <div class="sidebar-claim-card">
        <h4><?=  Trd(17) ?></h4>
        <p><?=  Trd(18) ?></p>
        <p><strong>1. <?=  Trd(19) ?></strong> <?=  Trd(20) ?></p>
        <p><strong>2. <?=  Trd(21) ?></strong> <?=  Trd(22) ?></p>
        <p><strong>3. <?=  Trd(23) ?></strong> <?=  Trd(24) ?></p>
        
        <a href="https://wa.me/523312345678?text=Hola,%20necesito%20soporte%20tecnico%20sobre%20una%20garantia" class="btn-claim-whatsapp" target="_blank">
          <svg style="width:16px; height:16px; fill:currentColor;" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397 0 11.973 0c3.184.001 6.177 1.242 8.426 3.496 2.249 2.254 3.487 5.244 3.484 8.427-.004 6.577-5.343 11.921-11.916 11.921-2.004-.001-3.973-.505-5.731-1.467L0 24zm6.211-3.56c1.625.965 3.393 1.474 5.228 1.475 5.626 0 10.201-4.52 10.204-10.077.002-2.693-1.045-5.224-2.948-7.127-1.904-1.904-4.434-2.952-7.135-2.953-5.632 0-10.21 4.52-10.215 10.079-.002 1.782.463 3.52 1.348 5.074l-.994 3.633 3.716-.974zm11.396-7.75c-.302-.15-1.787-.879-2.057-.977-.271-.098-.468-.147-.665.148-.197.295-.762.977-.934 1.173-.172.197-.344.221-.646.072-.302-.15-1.273-.468-2.426-1.494-.897-.798-1.502-1.784-1.678-2.083-.176-.3-.019-.461.13-.61l.404-.471c.15-.176.201-.296.301-.493.101-.197.051-.369-.026-.518-.076-.148-.665-1.603-.912-2.193-.24-.579-.485-.501-.665-.51-.173-.008-.37-.01-.567-.01-.197 0-.518.074-.788.369-.271.295-1.034 1.01-1.034 2.463s1.059 2.85 1.207 3.047c.148.197 2.084 3.179 5.048 4.453.705.304 1.256.486 1.684.622.71.226 1.356.194 1.866.118.568-.084 1.788-.73 2.039-1.436.252-.706.252-1.312.177-1.437-.076-.125-.272-.197-.574-.348z"/></svg>
          <?=  Trd(25) ?>
        </a>
        <span class="claim-note"><?=  Trd(26) ?> · 9:00 AM a 6:00 PM</span>
      </div>
    </aside>

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
</body>
</html>