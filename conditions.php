<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    $isSpanish = strtoupper($_SESSION['Idioma']) === 'ES';
    require_once 'head.php'; 
?>
  <title><?= $isSpanish ? 'Términos y Condiciones' : 'Terms & Conditions' ?> — <?= COMPANY_NAME ?></title>
  <meta name="description" content="<?= $isSpanish ? 'Términos y condiciones de uso y políticas de compra y distribución mayorista de' : 'Terms and conditions of use and wholesale purchase and distribution policies for' ?> <?= COMPANY_NAME ?>.">

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

.alert-box { background: #FFF5F5; padding: 20px; border-radius: 6px; border-left: 3px solid #B8402A; margin: 24px 0; font-size: 0.92rem; color: #742A2A; }
</style>
<link rel="stylesheet" href="css/cart.css">

</head>

<body>
<?php 
  require_once ('nav.php');
?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "conditions"]);
    //$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<main class="wrap-text">
  <header class="legal-header">
    <h1><?= $isSpanish ? 'Términos y Condiciones' : 'Terms & Conditions' ?></h1>
    <div class="meta-date"><?= $isSpanish ? 'Fecha de entrada en vigor' : 'Effective Date' ?>: September 15, 2026</div>
    <div class="meta-date"><?= $isSpanish ? 'Última actualización' : 'Last Updated' ?>: September 15, 2026</div>
  </header>

  <?php if ($isSpanish): ?>
  <article class="legal-content">
    <p>Estos Términos y Condiciones (“Términos”) se aplican a las compras realizadas a través de dsjumperspro.com (el “sitio web”) y a las ventas realizadas por D’s Jumpers LLC (“D’s Jumpers”, “nosotros” o “nuestro”). Al realizar un pedido o una compra, usted acepta estos términos y las políticas aplicables mencionadas a continuación.</p>

    <h2>Pedidos, depósitos y pagos</h2>
    <p>Todos los precios están expresados en dólares estadounidenses, salvo que se indique lo contrario. Cuando corresponda, podrán añadirse impuestos, gastos de envío, entrega y otros cargos.</p>
    <p>Los clientes pueden pagar el total o, cuando se ofrezca esta opción, realizar un depósito del 10% de la compra. Los depósitos no son reembolsables y se aplican al precio total de compra. Salvo que se acuerde lo contrario por escrito, el saldo restante debe pagarse en su totalidad antes de que la unidad sea enviada, entregada o puesta a disposición para recogerla.</p>
    <ul><li>Los pagos se procesan a través de Square u otro proveedor de pagos identificado durante el proceso de compra.</li></ul>
    <p>Las opciones de financiación o pago a plazos, incluido Afterpay, pueden estar disponibles para compras elegibles. El proveedor externo determina la elegibilidad, aprobación, límites de compra, calendario de pagos, intereses, cargos y demás condiciones de financiación. D’s Jumpers no determina ni garantiza la aprobación de la financiación.</p>
    <ul><li>Los clientes son responsables de proporcionar información completa y exacta de su cuenta, facturación, envío, contacto y pedido.</li></ul>

    <h2>Ventas finales, cancelaciones y pedidos personalizados</h2>
    <p>Todas las ventas son finales. Los pedidos no pueden cancelarse, devolverse ni cambiarse una vez realizados. Los productos personalizados, con nombre o diseño propio, fabricados bajo pedido y de pedido especial también son venta final y no pueden cancelarse. Los clientes deben revisar y aprobar los colores, diseños, logotipos, textos, especificaciones, dimensiones y demás detalles de personalización antes de la producción. D’s Jumpers no se responsabiliza de errores de personalización basados en la información enviada o aprobada por el cliente.</p>

    <h2>Productos, precios y aceptación de pedidos</h2>
    <p>Nos esforzamos razonablemente por proporcionar descripciones, fotografías, dimensiones, especificaciones, precios, disponibilidad y tiempos estimados de preparación exactos. Los colores o el aspecto real pueden variar ligeramente debido a la fotografía, la configuración de la pantalla o variaciones de fabricación.</p>
    <p>D’s Jumpers se reserva el derecho de corregir errores o inexactitudes genuinos relacionados con precios, información del producto, especificaciones, disponibilidad, gastos de envío u otra información del sitio web.</p>
    <p>Podemos rechazar o cancelar un pedido cuando sea razonablemente necesario, incluso por sospecha de fraude, problemas de pago, falta de disponibilidad del producto, errores de publicación o precio, o circunstancias que impidan cumplir el pedido. Si D’s Jumpers cancela un pedido después de recibir el pago, las cantidades pagadas por la parte cancelada se reembolsarán según corresponda.</p>

    <h2>Equipos nuevos y usados</h2>
    <p>D’s Jumpers vende equipos nuevos y usados.</p>
    <p>Los equipos usados pueden presentar signos de uso previo, incluido desgaste normal, imperfecciones estéticas, reparaciones, decoloración, manchas u otras características de su estado que hayan sido informadas. Los clientes son responsables de revisar las descripciones, fotografías e información de estado disponibles antes de comprar.</p>
    <p>La cobertura de la garantía, cuando corresponda, se rige por nuestra Política de Garantía independiente y por cualquier garantía aplicable del fabricante.</p>

    <h2>Envío, entrega y recogida</h2>
    <p>D’s Jumpers ofrece envíos dentro de Estados Unidos y puede ofrecer entrega local y recogida por parte del cliente para pedidos elegibles.</p>
    <p>Los gastos de envío y entrega, la disponibilidad y los plazos estimados pueden variar según el producto, destino, transportista y pedido. Las fechas estimadas de envío o entrega son aproximadas, salvo que se garanticen expresamente por escrito.</p>
    <p>Los clientes deben inspeccionar los pedidos enviados inmediatamente después de la entrega. Siempre que sea razonablemente posible, los daños visibles deben fotografiarse y anotarse en la documentación de entrega del transportista antes de aceptar el pedido.</p>
    <p>Los daños ocasionados durante el envío deben notificarse a D’s Jumpers dentro de las 48 horas posteriores a la entrega, incluyendo fotografías, información del pedido y la documentación correspondiente del transportista. Los clientes deben conservar el embalaje y los materiales dañados mientras se revisa la reclamación. Informar con retraso puede afectar nuestra capacidad de ayudar con una reclamación al transportista.</p>
    <p>Los clientes que recojan un pedido son responsables de inspeccionar y confirmar la mercancía antes de hacerse cargo de ella y de proporcionar un medio de transporte adecuado. Una vez que la mercancía haya sido aceptada y retirada del lugar de recogida, D’s Jumpers no se responsabiliza de los daños producidos durante el transporte del cliente, la carga o descarga, el almacenamiento, la instalación o el uso posterior. En nuestra Política de Envío, Entrega y Recogida pueden establecerse condiciones adicionales de cumplimiento.</p>

    <h2>Uso del equipo y responsabilidad del cliente</h2>
    <p>D’s Jumpers Sales proporciona equipos únicamente para su compra. La instalación, preparación, funcionamiento, anclaje, supervisión y desmontaje no están incluidos, salvo que se acuerden expresamente por escrito por separado.</p>
    <p>Los compradores son responsables de determinar si el equipo es adecuado para el uso y el lugar previstos, así como de seguir las instrucciones del fabricante, las normas de seguridad, los requisitos de anclaje, los procedimientos de inspección y mantenimiento y las leyes y reglamentos aplicables.</p>
    <p>Los clientes son responsables de obtener los permisos, licencias, inspecciones, seguros o aprobaciones necesarios para el uso previsto.</p>

    <h2>Indemnización</h2>
    <p>En la máxima medida permitida por la ley aplicable, el comprador acepta indemnizar, defender y mantener indemne a D’s Jumpers LLC y a sus propietarios, directivos, empleados, agentes y afiliados frente a reclamaciones de terceros, daños, pérdidas, responsabilidades y gastos legales razonables derivados de la instalación, preparación, anclaje, funcionamiento, mantenimiento, almacenamiento, transporte, modificación o uso indebido del equipo comprado por parte del comprador; del incumplimiento de la ley aplicable; o del incumplimiento sustancial de estos términos.</p>

    <h2>Garantía</h2>
    <p>La cobertura de la garantía varía según el producto, el fabricante, el estado y si el equipo es nuevo o usado.</p>
    <p>Las condiciones, exclusiones, procedimientos de reclamación y cobertura aplicable de la garantía se establecen en nuestra Política de Garantía independiente y, cuando corresponda, en la garantía del fabricante. Los clientes deben revisar la Política de Garantía antes de comprar.</p>

    <h2>Uso del sitio web</h2>
    <p>No puede hacer un uso indebido del sitio web, participar en actividades fraudulentas, intentar obtener acceso no autorizado, introducir código malicioso, interferir con la seguridad o el funcionamiento del sitio web ni utilizarlo infringiendo la ley aplicable.</p>
    <p>Nuestra Política de Privacidad regula la recopilación y el uso de información personal a través del sitio web.</p>

    <h2>Limitación de responsabilidad</h2>
    <p>En la máxima medida permitida por la ley aplicable, D’s Jumpers no será responsable de daños indirectos, incidentales, especiales o consecuentes derivados de la compra, transporte, instalación, preparación, funcionamiento, almacenamiento, mantenimiento o uso de los equipos vendidos por D’s Jumpers.</p>

    <h2>Cambios, separabilidad y acuerdo</h2>
    <p>Podemos actualizar estos Términos para reflejar cambios en nuestro sitio web, políticas, prácticas comerciales o requisitos legales. Los Términos actualizados se publicarán en nuestro sitio web con una fecha revisada de última actualización.</p>
    <p>Si alguna disposición de estos Términos se considera ilegal o inaplicable, dicha disposición se limitará o eliminará en la medida necesaria y las disposiciones restantes continuarán vigentes.</p>
    <p>Estos Términos, junto con las políticas aplicables, los detalles del pedido, las facturas, las especificaciones aprobadas de pedidos personalizados, las condiciones de garantía y cualquier acuerdo escrito independiente entre D’s Jumpers y el cliente, constituyen los términos aplicables a la compra.</p>

    <h2>Ley aplicable</h2>
    <p>Estos Términos se rigen por las leyes del Estado de California, salvo cuando la ley aplicable exija lo contrario.</p>

    <h2>Contacto</h2>
    <p>Las preguntas sobre estos Términos y Condiciones pueden dirigirse a:</p>
  </article>
  <?php else: ?>
  <article class="legal-content">
    <p>These Terms & Conditions (“Terms”) apply to purchases made through dsjumperspro.com (the “website”) and sales made by D’s Jumpers LLC (“D’s Jumpers,” “we,” “us,” or “our”). By placing an order or making a purchase, you agree to these terms and any applicable policies referenced below.</p>

    <h2>Orders, Deposits & Payment</h2>
    <p>All prices are listed in U.S. dollars unless otherwise stated. Applicable taxes, shipping, delivery, and other charges may be added where applicable.</p>
    <p>Customers may pay in full or, when offered, must place a 10% deposit toward their purchase. Deposits are non-refundable and applied toward the total purchase price. Unless otherwise agreed to in writing, the remaining balance must be paid in full before the unit is shipped, delivered, or released for pickup.</p>

    <ul>
      <li>Payments are processed through Square or another payment provider identified at checkout.</li>
    </ul>

    <p>Financing or installment options, including Afterpay, may be available on eligible purchases. Eligibility, approval, purchase limits, payment schedules, interest, fees, and other financing terms are determined by the third-party provider. D’s Jumpers does not determine or guarantee financing approval.</p>

    <ul><li>Customers are responsible for providing complete and accurate account, billing, shipping, contact, and order information.</li></ul>

    
    <h2>Final Sales, Cancellations & Custom Orders</h2>
    <p>All sales are final. Orders cannot be canceled, returned, or exchanged once placed. Custom, personalized, made to order, and special order products are also final sale and non cancelable. Customers are responsible for reviewing and approving applicable colors, artwork, logos, text, specifications, dimensions, and other customization details before production. D’s Jumpers is not responsible for customization errors based on information submitted or approved by the customer.</p>

    <h2>Products, Pricing & Order Acceptance</h2>
    <p>We make reasonable efforts to provide accurate product descriptions, photographs, dimensions, specifications, pricing, availability, and estimated fulfillment times. Actual colors or appearance may vary slightly due to photography, screen settings, or manufacturing variations.</p>
    <p>D’s Jumpers reserves the right to correct genuine errors or inaccuracies involving pricing, product information, specifications, availability, shipping charges, or other website information.</p>
    <p>We may refuse or cancel an order when reasonably necessary, including due to suspected fraud, payment issues, product unavailability, listing or pricing errors, or circumstances preventing us from fulfilling the order. If D’s Jumpers cancels an order after receiving payment, amounts paid for the canceled portion will be refunded as appropriate.</p>

    <h2>New & Used Equipment</h2>
    <p>D’s Jumpers sells both new and used equipment.</p>
    <p>Used equipment may show signs of previous use, including normal wear, cosmetic imperfections, repairs, fading, staining, or other disclosed condition-related characteristics. Customers are responsible for reviewing available descriptions, photographs, and condition information before purchasing.</p>
    <p>Warranty coverage, when applicable, is governed by our separate Warranty Policy and any applicable manufacturer's warranty.</p>

    <h2>Shipping, Delivery & Pickup</h2>
    <p>D’s Jumpers offers shipping within the United States and may offer local delivery and customer pickup for eligible orders.</p>
    <p>Shipping and delivery costs, availability, and estimated timelines may vary based on the product, destination, carrier, and order. Estimated shipping or delivery dates are estimates unless expressly guaranteed in writing.</p>
    <p>Customers should inspect shipped orders immediately upon delivery. Visible damage should be photographed and noted on the carrier's delivery documentation before acceptance whenever reasonably possible.</p>
    <p>Shipping damage should be reported to D’s Jumpers within 48 hours of delivery with photographs, order information, and relevant carrier documentation. Customers should retain damaged packaging and materials while a claim is being reviewed. Delayed reporting may affect our ability to assist with a carrier or freight claim.</p>
    <p>Customers picking up an order are responsible for inspecting and confirming the merchandise before taking possession and for providing an appropriate method of transportation. Once merchandise has been accepted and removed from the pickup location, D’s Jumpers is not responsible for damage occurring during customer transportation, loading or unloading, storage, setup, or subsequent use. Additional fulfillment terms may be provided in our Shipping, Delivery & Pickup Policy.</p>

    <h2>Equipment Use & Customer Responsibility</h2>
    <p>D’s Jumpers Sales provides equipment for purchase only. Installation, setup, operation, anchoring, supervision, and teardown are not included unless expressly agreed to separately in writing.</p>
    <p>Purchasers are responsible for determining whether equipment is appropriate for their intended use and location and for following manufacturer instructions, safety guidelines, anchoring requirements, inspection and maintenance procedures, and applicable laws and regulations.</p>
    <p>Customers are responsible for obtaining any permits, licenses, inspections, insurance, or approvals required for their intended use.</p>

    <h2>Indemnification</h2>
    <p>To the fullest extent permitted by applicable law, the purchaser agrees to indemnify, defend, and hold harmless D’s Jumpers LLC and its owners, officers, employees, agents, and affiliates from third-party claims, damages, losses, liabilities, and reasonable legal expenses arising from the purchaser’s improper installation, setup, anchoring, operation, maintenance, storage, transportation, modification, or misuse of purchased equipment; violation of applicable law; or material breach of these terms.</p>

    <h2>Warranty</h2>
    <p>Warranty coverage varies depending on the product, manufacturer, condition, and whether the equipment is new or used.</p>
    <p>Warranty terms, exclusions, claim procedures, and applicable coverage are provided in our separate Warranty Policy and, where applicable, the manufacturer's warranty. Customers should review the Warranty Policy before purchasing.</p>

    <h2>Website Use</h2>
    <p>You may not misuse the website, engage in fraudulent activity, attempt unauthorized access, introduce malicious code, interfere with website security or operation, or use the website in violation of applicable law.</p>
    <p>Our Privacy Policy governs the collection and use of personal information through the website.</p>

    <h2>Limitation of Liability</h2>
    <p>To the fullest extent permitted by applicable law, D’s Jumpers will not be liable for indirect, incidental, special, or consequential damages arising from the purchase, transportation, installation, setup, operation, storage, maintenance, or use of equipment sold by D’s Jumpers.</p>

    <h2>Changes, Severability & Agreement</h2>
    <p>We may update these Terms to reflect changes to our website, policies, business practices, or legal requirements. Updated Terms will be posted on our website with a revised Last Updated date.</p>
    <p>If any provision of these Terms is determined to be unlawful or unenforceable, that provision will be limited or removed to the extent necessary, and the remaining provisions will remain in effect.</p>
    <p>These Terms, together with applicable policies, order details, invoices, approved custom-order specifications, warranty terms, and any separate written agreement between D’s Jumpers and the customer, constitute the terms applicable to the purchase.</p>

    <h2>Governing Law</h2>
    <p>These Terms are governed by the laws of the State of California, except where applicable law requires otherwise.</p>

    <h2>Contact Us</h2>
    <p>Questions regarding these Terms & Conditions may be directed to:</p>

  </article>
  <?php endif; ?>

      <div class="meta-date">D’s Jumpers LLC</div>
      <div class="meta-date">Email:  <a href="mailto:prosupport@dsjumpers.com">prosupport@dsjumpers.com</a></div>
      <div class="meta-date">Website: <a href="https://dsjumperspro.com">dsjumperspro.com</a> </div>
      <div class="meta-date">California, United States</div>
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