<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    $isSpanish = strtoupper($_SESSION['Idioma']) === 'ES';
    require_once 'head.php'; 
?>
  <title><?= $isSpanish ? 'Aviso de Privacidad' : 'Privacy Policy' ?> — <?= COMPANY_NAME ?></title>
  <meta name="description" content="<?= $isSpanish ? 'Aviso de privacidad y protección de datos personales de' : 'Privacy policy and personal data protection notice for' ?> <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<style>
:root{
  --container-text:   760px;
}
body{
  margin:0; font-family:var(--font); color:var(--color-ink); background:var(--color-bg);
  -webkit-font-smoothing:antialiased; font-size:15px; line-height:1.5;
}
.wrap-text { max-width:var(--container-text); margin:0 auto; padding:0 24px; }


/* Cabecera Legal */
.legal-header { padding: 60px 0 40px; border-bottom: 1px solid var(--color-line); margin-bottom: 40px; }
.legal-header h1 { font-size: 2.4rem; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 12px; line-height: 1.1; }
.meta-date { font-size: 0.88rem; color: var(--color-ink-soft); font-weight: 500; }

/* Contenido Editorial Legal */
.legal-content h2 { font-size: 1.3rem; font-weight: 700; letter-spacing: -0.01em; margin: 36px 0 14px; color: var(--color-ink); }
.legal-content p { margin: 0 0 16px; color: #2D3139; }
.legal-content ul { margin: 0 0 20px; padding-left: 20px; color: #2D3139; }
.legal-content li { margin-bottom: 8px; }

.highlight-box { background: var(--color-bg-soft); padding: 20px; border-radius: 6px; border-left: 3px solid var(--color-brand); margin: 24px 0; font-size: 0.92rem; }

/* Footer simplificado para páginas legales */
.legal-footer { margin-top: 80px; padding: 24px 0; border-top: 1px solid var(--color-line); font-size: 0.84rem; color: var(--color-ink-soft); text-align: center; }
</style>
<link rel="stylesheet" href="css/cart.css">

</head>

<body>
<?php 
  require_once ('nav.php');
?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "privacy"]);
    //$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<main class="wrap-text">
  <header class="legal-header">
    <h1><?= $isSpanish ? 'Aviso de Privacidad' : 'Privacy Policy' ?></h1>
    <div class="meta-date"><?= $isSpanish ? 'Fecha de entrada en vigor' : 'Effective Date' ?>: September 15, 2026</div>
    <div class="meta-date"><?= $isSpanish ? 'Última actualización' : 'Last Updated' ?>: September 15, 2026</div>
  </header>

  <?php if ($isSpanish): ?>
  <article class="legal-content">
    <p>D’s Jumpers LLC (“D’s Jumpers”, “nosotros” o “nuestro”) respeta su privacidad. Este Aviso de Privacidad explica cómo recopilamos, usamos y compartimos información personal cuando visita dsjumperspro.com (el “sitio web”), crea una cuenta, realiza una compra, se comunica con nosotros o utiliza nuestros servicios de cualquier otra forma.</p>

    <h2>Información que recopilamos</h2>
    <p>Podemos recopilar la información personal que usted nos proporciona, incluyendo:</p>
    <ul>
      <li>Información de contacto, como su nombre, dirección de correo electrónico, número de teléfono y direcciones de facturación y envío.</li>
      <li>Información de la cuenta, como sus credenciales de acceso, preferencias e información asociada a su cuenta de cliente.</li>
      <li>Información del pedido, como los productos comprados, historial de pedidos, opciones de envío, entrega o recogida y detalles de la transacción.</li>
      <li>Información de pago. Los pagos se procesan mediante proveedores externos, incluido Square. D’s Jumpers no almacena directamente los números completos de las tarjetas cuando nuestro proveedor procesa los pagos.</li>
      <li>Comunicaciones, incluida la información que proporciona al contactarnos por correo electrónico, teléfono, mensaje de texto, atención al cliente o a través de nuestro sitio web.</li>
      <li>Preferencias de marketing, incluidas sus preferencias para correos electrónicos y mensajes de texto promocionales.</li>
    </ul>
    <p>También podemos recopilar automáticamente información sobre cómo utiliza nuestro sitio web mediante cookies, píxeles y tecnologías similares. Esto puede incluir su dirección IP, información del navegador y dispositivo, páginas visitadas, fuentes de referencia, ubicación aproximada derivada de su dirección IP e interacciones con nuestro sitio web.</p>

    <h2>Cómo usamos su información</h2>
    <p>Podemos usar su información para:</p>
    <ul>
      <li>crear y administrar cuentas de clientes;</li>
      <li>procesar pagos, compras y pedidos;</li>
      <li>organizar envíos, entregas locales o recogidas por parte del cliente;</li>
      <li>comunicarnos con usted sobre su cuenta o sus pedidos;</li>
      <li>proporcionar atención al cliente;</li>
      <li>operar, mantener y mejorar nuestro sitio web y servicios;</li>
      <li>analizar el tráfico y el rendimiento del sitio web;</li>
      <li>medir y mejorar nuestra publicidad;</li>
      <li>enviar marketing por correo electrónico o SMS cuando esté permitido;</li>
      <li>detectar o prevenir fraudes e incidentes de seguridad; y</li>
      <li>cumplir requisitos legales, contables y comerciales aplicables.</li>
    </ul>

    <h2>Cookies, analítica y publicidad</h2>
    <p>Utilizamos cookies y tecnologías similares para operar y mejorar nuestro sitio web, comprender cómo interactúan los visitantes con él y apoyar nuestra publicidad.</p>
    <p>Utilizamos servicios como Google Analytics y Google Ads. Estos servicios pueden usar cookies, píxeles o tecnologías similares para recopilar información sobre sus interacciones con nuestro sitio web, medir el tráfico y el rendimiento publicitario y proporcionar o medir publicidad relevante.</p>
    <p>Los terceros pueden recopilar información sobre sus actividades en línea a lo largo del tiempo y en diferentes sitios web o servicios en línea.</p>
    <p>Algunos navegadores ofrecen una configuración de “No rastrear” (“DNT”). Debido a que no existe un estándar universalmente aceptado para responder a las señales DNT tradicionales, nuestro sitio web puede no responder a ellas. Cuando la ley aplicable nos exija reconocer una señal legalmente válida de exclusión u otro control de privacidad, la procesaremos según lo exija la ley.</p>
    <p>También puede administrar ciertas cookies mediante la configuración de su navegador o los controles de privacidad disponibles en nuestro sitio web.</p>

    <h2>Cómo compartimos la información</h2>
    <p>Podemos compartir información personal cuando sea razonablemente necesario para operar nuestro negocio y prestar nuestros servicios, incluso con:</p>
    <ul>
      <li>Event Go Solutions LLC, que proporciona la tecnología que respalda nuestro sitio web y servicios de comercio electrónico;</li>
      <li>Square y otros proveedores de pagos utilizados para procesar transacciones;</li>
      <li>proveedores de envío, entrega y cumplimiento de pedidos;</li>
      <li>proveedores de analítica y publicidad, incluido Google;</li>
      <li>proveedores de comunicaciones por correo electrónico y SMS;</li>
      <li>proveedores de alojamiento web, seguridad, TI y otros servicios; y</li>
      <li>autoridades gubernamentales u otras partes cuando la ley lo exija o sea necesario para proteger nuestros derechos legales.</li>
    </ul>
    <p>D’s Jumpers no vende información personal a cambio de dinero. Sin embargo, ciertas tecnologías publicitarias pueden implicar compartir identificadores, información del dispositivo o actividad en el sitio web con proveedores de publicidad. Según algunas leyes de privacidad, estas actividades pueden considerarse “compartir” o publicidad dirigida incluso cuando no se intercambia dinero. Cuando la ley aplicable otorgue un derecho de exclusión, respetaremos las solicitudes que cumplan los requisitos legales.</p>

    <h2>Marketing por correo electrónico y SMS</h2>
    <p>Si se suscribe a comunicaciones promocionales, podemos utilizar su dirección de correo electrónico o número de teléfono para enviarle información sobre productos, promociones, ventas y nuevo inventario de D’s Jumpers.</p>
    <p>Puede cancelar la suscripción a los correos electrónicos promocionales mediante el enlace de cancelación incluido en nuestros correos.</p>
    <p>Si acepta recibir mensajes de texto promocionales, puede cancelar dicha recepción siguiendo las instrucciones incluidas en los mensajes, incluida la respuesta STOP cuando esté disponible. Pueden aplicarse tarifas de mensajes y datos. El consentimiento para recibir mensajes de texto promocionales no es una condición de compra.</p>
    <p>Cancelar las comunicaciones de marketing no impide que le enviemos comunicaciones necesarias sobre su cuenta, pedidos, pagos, envíos, entregas, recogidas o atención al cliente.</p>
    <p>No vendemos números de teléfono móvil ni información de consentimiento para SMS a terceros para sus propios fines de marketing.</p>

    <h2>Sus opciones de privacidad</h2>
    <p>Puede contactarnos para solicitar acceso a determinada información personal que conservamos sobre usted, corregir información inexacta, solicitar su eliminación cuando corresponda o actualizar sus preferencias de marketing.</p>
    <p>Cierta información puede conservarse cuando sea necesario para completar transacciones, mantener registros comerciales o contables, prevenir fraudes, resolver disputas o cumplir obligaciones legales.</p>
    <p>Dependiendo de su estado de residencia y de la ley aplicable, puede tener derechos de privacidad adicionales. Procesaremos las solicitudes de privacidad que cumplan los requisitos conforme a la ley aplicable.</p>
    <p>Para enviar una solicitud relacionada con la privacidad, contáctenos en prosupport@dsjumperspro.com.</p>

    <h2>Seguridad y conservación de datos</h2>
    <p>Utilizamos medidas razonables diseñadas para proteger la información personal. Sin embargo, ningún método de transmisión o almacenamiento electrónico es completamente seguro y no podemos garantizar una seguridad absoluta.</p>
    <p>Conservamos la información personal durante el tiempo razonablemente necesario para completar pedidos, mantener cuentas de clientes y registros comerciales, proporcionar atención al cliente, cumplir obligaciones legales y fiscales, resolver disputas, prevenir fraudes y hacer cumplir nuestros acuerdos y políticas.</p>

    <h2>Cambios a este Aviso de Privacidad</h2>
    <p>Podemos actualizar este Aviso de Privacidad para reflejar cambios en nuestro sitio web, servicios, prácticas comerciales, tecnología o requisitos legales.</p>
    <p>Cuando hagamos cambios, publicaremos el Aviso de Privacidad revisado en nuestro sitio web y actualizaremos la fecha de última actualización indicada arriba. Proporcionaremos avisos adicionales cuando la ley aplicable lo exija.</p>

    <h2>Contacto</h2>
    <p>Si tiene preguntas sobre este Aviso de Privacidad, nuestras prácticas de privacidad o su información personal, puede contactarnos en:</p>
  </article>
  <?php else: ?>
  <article class="legal-content">
    <p>D’s Jumpers LLC (“D’s Jumpers,” “we,” “us,” or “our”) respects your privacy. This Privacy Policy explains how we collect, use, and share personal information when you visit dsjumperspro.com (the “website”), create an account, make a purchase, communicate with us, or otherwise use our services.</p>

    <h2>Information We Collect</h2>
    <p>We may collect personal information that you provide to us, including:</p>   
    <ul>
      <li>Contact information, such as your name, email address, phone number, billing address, and shipping address.</li>
      <li>Account information, such as your login credentials, account preferences, and information associated with your customer account</li>
      <li>Order information, such as products purchased, order history, shipping, delivery or pickup selections, and transaction details.</li>
      <li>Payment information. Payments are processed through third-party payment providers, including Square. D’s Jumpers does not directly store complete payment card numbers when payments are processed by our payment provider.</li>
      <li>Communications, including information you provide when contacting us by email, phone, text message, customer support, or through our website.</li>
      <li>Marketing preferences, including your preferences for promotional emails and text messages.</li>
    </ul>
    <p>We may also automatically collect information about how you use our website through cookies, pixels, and similar technologies. This may include your IP address, browser and device information, pages viewed, referring sources, approximate location derived from your IP address, and interactions with our website.</p>

    
<h2>How We Use Your Information</h2>
<p>We may use your information to: </p>
<ul>
  <li>create and manage customer accounts;</li>
  <li>process payments, purchases, and orders;</li>
  <li>arrange shipping, local delivery, or customer pickup;</li>
  <li>communicate with you about your account or orders;</li>
  <li>provide customer support;</li>
  <li>operate, maintain, and improve our website and services;</li>
  <li>analyze website traffic and performance;</li>
  <li>measure and improve our advertising;</li>
  <li>send email or SMS marketing when permitted;</li>
  <li>detect or prevent fraud and security incidents; and</li>
  <li>comply with applicable legal, accounting, and business requirements.</li>
</ul>

<h2>Cookies, Analytics & Advertising</h2>
<p>We use cookies and similar technologies to operate and improve our website, understand how visitors interact with it, and support our advertising.</p>
<p>We use services including Google Analytics and Google Ads. These services may use cookies, pixels, or similar technologies to collect information about your interactions with our website, measure website traffic and advertising performance, and provide or measure relevant advertising.</p>
<p>Third parties may collect information about your online activities over time and across different websites or online services.</p>
<p>Some browsers provide a “Do Not Track” (“DNT”) setting. Because there is no universally accepted standard for responding to traditional DNT signals, our website may not respond to them. Where applicable law requires us to recognize a legally valid opt-out preference signal or other privacy control, we will process it as required by law.</p>
<p>You may also manage certain cookies through your browser settings or privacy controls made available on our website.</p>


<h2>How We Share Information</h2>
<p>We may share personal information as reasonably necessary to operate our business and provide our services, including with:</p>
<ul>
  <li>Event Go Solutions LLC, which provides technology supporting our website and e-commerce services;</li>
  <li>Square and other payment providers used to process transactions;</li>
  <li>shipping, delivery, and fulfillment providers;</li>
  <li>analytics and advertising providers, including Google;</li>
  <li>email and SMS communication providers;</li>
  <li>website hosting, security, IT, and other service providers; and</li>
  <li>government authorities or other parties when required by law or necessary to protect our legal rights.</li>
</ul>
<p>D’s Jumpers does not sell personal information for monetary payment. However, certain advertising technologies may involve sharing identifiers, device information, or website activity with advertising providers. Under some privacy laws, these activities may be considered “sharing” or targeted advertising even when no money is exchanged. Where applicable law provides an opt-out right, we will honor qualifying requests as required.

<h2>Email & SMS Marketing</h2>
<p>If you sign up for promotional communications, we may use your email address or phone number to send information about D’s Jumpers products, promotions, sales, and new inventory.</p>
<p>You may unsubscribe from promotional emails using the unsubscribe link provided in our emails.</p>
<p>If you opt in to promotional text messages, you may opt out by following the instructions included in the messages, including replying STOP when available. Message and data rates may apply. Consent to receive promotional text messages is not a condition of purchase.</p>
<p>Opting out of marketing communications does not prevent us from sending necessary communications regarding your account, orders, payments, shipping, delivery, pickup, or customer service.</p>
<p>We do not sell mobile phone numbers or SMS opt-in consent information to third parties for their own marketing purposes.</p>

<h2>Your Privacy Choices</h2>
<p>You may contact us to request access to certain personal information we maintain about you, correct inaccurate information, request deletion where applicable, or update your marketing preferences.</p>
<p>Certain information may be retained when necessary to complete transactions, maintain business or accounting records, prevent fraud, resolve disputes, or comply with legal obligations.</p>
<p>Depending on your state of residence and applicable law, you may have additional privacy rights. We will process qualifying privacy requests as required by applicable law.</p>
<p>To submit a privacy-related request, contact us at prosupport@dsjumperspro.com.

<h2>Security & Data Retention</h2>
<p>We use reasonable measures designed to protect personal information. However, no method of electronic transmission or storage is completely secure, and we cannot guarantee absolute security.</p>
<p>We retain personal information for as long as reasonably necessary to fulfill orders, maintain customer accounts and business records, provide customer service, comply with legal and tax obligations, resolve disputes, prevent fraud, and enforce our agreements and policies.</p>

<h2>Changes to This Privacy Policy</h2>
<p>We may update this Privacy Policy to reflect changes to our website, services, business practices, technology, or legal requirements.</p>
<p>When we make changes, we will post the revised Privacy Policy on our website and update the Last Updated date above. We will provide additional notice when required by applicable law.</p>

<h2>Contact Us</h2>
<p>If you have questions about this Privacy Policy, our privacy practices, or your personal information, please contact:</p>


      <div class="meta-date">D’s Jumpers LLC</div>
      <div class="meta-date">Email:  <a href="mailto:prosupport@dsjumpers.com">prosupport@dsjumpers.com</a></div>
      <div class="meta-date">Website: <a href="https://dsjumperspro.com">dsjumperspro.com</a> </div>
      <div class="meta-date">California, United States</div>
  </article>
  <?php endif; ?>
</main>
<?php 
  require_once('news.php');
  require_once('foot.php');
  require_once('cart.php');
?>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="js/index.js"></script>
</html>