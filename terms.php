<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    $isSpanish = isset($_SESSION['Idioma']) && strtoupper($_SESSION['Idioma']) === 'ES';
    require_once 'head.php';

    $spanishTerms = <<<'TERMS'
Términos del Servicio
RESUMEN
Este sitio web es operado por Inflatable sales group. En todo el sitio, los términos “nosotros”, “nos” y “nuestro” se refieren a Inflatable sales group. Inflatable sales group ofrece este sitio web, incluida toda la información, herramientas y servicios disponibles en este sitio para usted, el usuario, sujeto a su aceptación de todos los términos, condiciones, políticas y avisos aquí establecidos.

Al visitar nuestro sitio o comprar algo de nosotros, usted utiliza nuestro “Servicio” y acepta quedar sujeto a los siguientes términos y condiciones (“Términos del Servicio” o “Términos”), incluidos los términos, condiciones y políticas adicionales a los que se haga referencia aquí o que estén disponibles mediante un hipervínculo. Estos Términos del Servicio se aplican a todos los usuarios del sitio, incluidos, entre otros, quienes navegan, proveedores, clientes, comerciantes o contribuyentes de contenido.

Lea detenidamente estos Términos del Servicio antes de acceder o utilizar nuestro sitio web. Al acceder o utilizar cualquier parte del sitio, usted acepta quedar sujeto a estos Términos del Servicio. Si no acepta todos los términos y condiciones de este acuerdo, no podrá acceder al sitio web ni utilizar ningún Servicio. Si estos Términos del Servicio se consideran una oferta, la aceptación se limita expresamente a estos Términos del Servicio.

Toda nueva función o herramienta que se agregue a la tienda actual también estará sujeta a los Términos del Servicio. Puede consultar la versión más reciente de los Términos del Servicio en cualquier momento en esta página. Nos reservamos el derecho de actualizar, modificar o reemplazar cualquier parte de estos Términos del Servicio mediante la publicación de actualizaciones o cambios en nuestro sitio web. Es su responsabilidad revisar periódicamente esta página para comprobar si hay cambios. Si continúa utilizando o accediendo al sitio web después de la publicación de cualquier cambio, acepta dichos cambios.

Nuestra tienda está alojada por Shopify Inc. Esta empresa nos proporciona la plataforma de comercio electrónico en línea que nos permite venderle nuestros productos y Servicios.

SECCIÓN 1 - TÉRMINOS DE LA TIENDA EN LÍNEA
Al aceptar estos Términos del Servicio, usted declara que tiene al menos la mayoría de edad en su estado o provincia de residencia, o que tiene la mayoría de edad en su estado o provincia de residencia y nos ha dado su consentimiento para permitir que cualquiera de sus dependientes menores use este sitio.
No puede utilizar nuestros productos para ningún propósito ilegal o no autorizado, ni puede, al utilizar el Servicio, infringir ninguna ley de su jurisdicción (incluidas, entre otras, las leyes de derechos de autor).
No debe transmitir gusanos, virus ni ningún código de naturaleza destructiva.
El incumplimiento o la violación de cualquiera de los Términos dará lugar a la terminación inmediata de sus Servicios.

SECCIÓN 2 - CONDICIONES GENERALES
Nos reservamos el derecho de rechazar el Servicio a cualquier persona, por cualquier motivo y en cualquier momento.
Usted entiende que su contenido (sin incluir la información de tarjetas de crédito) puede transferirse sin cifrar e implicar (a) transmisiones a través de varias redes y (b) cambios para adaptarse a los requisitos técnicos de las redes o dispositivos de conexión. La información de tarjetas de crédito siempre se cifra durante su transferencia por las redes.
Usted acepta no reproducir, duplicar, copiar, vender, revender ni explotar ninguna parte del Servicio, el uso del Servicio o el acceso al Servicio, ni ningún contacto en el sitio web a través del cual se proporciona el Servicio, sin nuestro permiso expreso por escrito.
Los encabezados utilizados en este acuerdo se incluyen únicamente por conveniencia y no limitarán ni afectarán de otro modo estos Términos.

SECCIÓN 3 - EXACTITUD, INTEGRIDAD Y VIGENCIA DE LA INFORMACIÓN
No nos hacemos responsables si la información disponible en este sitio no es exacta, completa o actual. El material de este sitio se proporciona únicamente con fines informativos generales y no debe utilizarse como única base para tomar decisiones sin consultar fuentes de información primarias, más exactas, completas o actuales. Cualquier uso del material de este sitio queda bajo su propio riesgo.
Este sitio puede contener cierta información histórica. La información histórica, por su naturaleza, no es actual y se proporciona únicamente como referencia. Nos reservamos el derecho de modificar el contenido de este sitio en cualquier momento, pero no tenemos la obligación de actualizar ninguna información. Usted acepta que es su responsabilidad supervisar los cambios en nuestro sitio.

SECCIÓN 4 - MODIFICACIONES DEL SERVICIO Y LOS PRECIOS
Los precios de nuestros productos están sujetos a cambios sin previo aviso.
Nos reservamos el derecho de modificar o interrumpir el Servicio (o cualquier parte o contenido del mismo) en cualquier momento y sin previo aviso.
No seremos responsables ante usted ni ante terceros por ninguna modificación, cambio de precio, suspensión o interrupción del Servicio.

SECCIÓN 5 - PRODUCTOS O SERVICIOS (SI CORRESPONDE)
Ciertos productos o Servicios pueden estar disponibles exclusivamente en línea a través del sitio web. Estos productos o Servicios pueden tener cantidades limitadas y solo podrán devolverse o cambiarse de acuerdo con nuestra Política de reembolso: [ENLACE A LA POLÍTICA DE REEMBOLSO]
Hemos hecho todo lo posible para mostrar con la mayor exactitud posible los colores e imágenes de nuestros productos que aparecen en la tienda. No podemos garantizar que la pantalla de su computadora reproduzca con exactitud cualquier color.
Nos reservamos el derecho, pero no tenemos la obligación, de limitar las ventas de nuestros productos o Servicios a cualquier persona, región geográfica o jurisdicción. Podemos ejercer este derecho caso por caso. Nos reservamos el derecho de limitar las cantidades de los productos o Servicios que ofrecemos. Todas las descripciones de productos y sus precios están sujetas a cambios en cualquier momento y sin previo aviso, a nuestro exclusivo criterio. Nos reservamos el derecho de dejar de ofrecer cualquier producto en cualquier momento. Cualquier oferta de un producto o Servicio en este sitio será nula donde esté prohibida.
No garantizamos que la calidad de los productos, Servicios, información u otro material que usted compre u obtenga cumpla sus expectativas, ni que se corrijan los errores del Servicio.

SECCIÓN 6 - EXACTITUD DE LA FACTURACIÓN Y DE LA INFORMACIÓN DE LA CUENTA
Nos reservamos el derecho de rechazar cualquier pedido que realice. A nuestro exclusivo criterio, podemos limitar o cancelar las cantidades compradas por persona, por hogar o por pedido. Estas restricciones pueden incluir pedidos realizados con la misma cuenta de cliente, la misma tarjeta de crédito o que utilicen la misma dirección de facturación o envío. Si modificamos o cancelamos un pedido, podemos intentar notificárselo mediante el correo electrónico o la dirección o el número de teléfono de facturación que proporcionó al realizarlo. Nos reservamos el derecho de limitar o prohibir los pedidos que, a nuestro exclusivo juicio, parezcan haber sido realizados por distribuidores, revendedores o comerciantes.
Usted acepta proporcionar información actual, completa y exacta de compra y de cuenta para todas las compras realizadas en nuestra tienda. Acepta actualizar oportunamente su cuenta y demás información, incluida su dirección de correo electrónico y los números y fechas de vencimiento de sus tarjetas de crédito, para que podamos completar sus transacciones y contactarlo cuando sea necesario.

SECCIÓN 7 - HERRAMIENTAS OPCIONALES
Podemos ofrecerle acceso a herramientas de terceros que no supervisamos ni controlamos y sobre las que no tenemos influencia.
Usted reconoce y acepta que proporcionamos acceso a dichas herramientas “tal cual” y “según disponibilidad”, sin garantías, declaraciones ni condiciones de ningún tipo y sin respaldo alguno. No tendremos responsabilidad alguna derivada de su uso de herramientas opcionales de terceros o relacionada con este.
El uso que usted haga de las herramientas opcionales ofrecidas a través del sitio queda enteramente bajo su propio riesgo y criterio, y debe asegurarse de conocer y aprobar los términos bajo los cuales las proporciona el proveedor o los proveedores externos correspondientes.
En el futuro, también podemos ofrecer nuevos Servicios o funciones a través del sitio web (incluido el lanzamiento de nuevas herramientas y recursos). Dichas funciones o Servicios nuevos también estarán sujetos a estos Términos del Servicio.

SECCIÓN 8 - ENLACES DE TERCEROS
Ciertos contenidos, productos y Servicios disponibles a través de nuestro Servicio pueden incluir materiales de terceros.
Los enlaces de terceros en este sitio pueden dirigirlo a sitios web de terceros que no están afiliados con nosotros. No somos responsables de examinar o evaluar el contenido o la exactitud, y no garantizamos ni asumimos responsabilidad alguna por materiales o sitios web de terceros, ni por otros materiales, productos o Servicios de terceros.
No somos responsables de ningún daño relacionado con la compra o el uso de bienes, Servicios, recursos, contenido u otras transacciones realizadas en conexión con sitios web de terceros. Revise detenidamente las políticas y prácticas de dichos terceros y asegúrese de comprenderlas antes de realizar cualquier transacción. Las quejas, reclamaciones, inquietudes o preguntas sobre productos de terceros deben dirigirse a dichos terceros.

SECCIÓN 9 - COMENTARIOS, OPINIONES Y OTROS ENVÍOS DE LOS USUARIOS
Si, a petición nuestra, envía ciertos materiales específicos (por ejemplo, participaciones en concursos) o, sin que se los solicitemos, envía ideas creativas, sugerencias, propuestas, planes u otros materiales, ya sea en línea, por correo electrónico, correo postal o de otro modo (en conjunto, “comentarios”), acepta que podemos, en cualquier momento y sin restricciones, editar, copiar, publicar, distribuir, traducir y utilizar de cualquier otra forma y en cualquier medio los comentarios que nos envíe. No tenemos ni tendremos la obligación de (1) mantener la confidencialidad de los comentarios; (2) pagar una compensación por ellos; ni (3) responder a ellos.
Podemos, pero no estamos obligados a, supervisar, editar o eliminar contenido que, a nuestro exclusivo criterio, determinemos que es ilegal, ofensivo, amenazante, difamatorio, calumnioso, pornográfico, obsceno, objetable de cualquier otra manera, o que infringe la propiedad intelectual de alguna parte o estos Términos del Servicio.
Usted acepta que sus comentarios no infringirán ningún derecho de terceros, incluidos los derechos de autor, marcas comerciales, privacidad, personalidad u otros derechos personales o de propiedad. También acepta que sus comentarios no contendrán material difamatorio, ilegal, abusivo u obsceno, ni virus informáticos u otro malware que pueda afectar de cualquier forma el funcionamiento del Servicio o de cualquier sitio web relacionado. No puede utilizar una dirección de correo electrónico falsa, hacerse pasar por otra persona ni inducirnos a nosotros o a terceros a error sobre el origen de los comentarios. Usted es el único responsable de los comentarios que haga y de su exactitud. No asumimos responsabilidad alguna por los comentarios publicados por usted o por terceros.

SECCIÓN 10 - INFORMACIÓN PERSONAL
El envío de su información personal a través de la tienda se rige por nuestra Política de privacidad.

SECCIÓN 11 - ERRORES, INEXACTITUDES Y OMISIONES
Ocasionalmente, puede haber información en nuestro sitio o en el Servicio que contenga errores tipográficos, inexactitudes u omisiones relacionadas con descripciones de productos, precios, promociones, ofertas, cargos de envío, tiempos de tránsito y disponibilidad. Nos reservamos el derecho de corregir errores, inexactitudes u omisiones, y de cambiar o actualizar información o cancelar pedidos si cualquier información del Servicio o de un sitio web relacionado es inexacta, en cualquier momento y sin previo aviso (incluso después de que usted haya enviado su pedido).
No nos comprometemos a actualizar, modificar ni aclarar información del Servicio o de cualquier sitio web relacionado, incluida, entre otras, la información sobre precios, excepto cuando la ley lo exija. Ninguna fecha de actualización o renovación especificada en el Servicio o en cualquier sitio web relacionado debe interpretarse como indicación de que toda la información del Servicio o de dicho sitio web ha sido modificada o actualizada.

SECCIÓN 12 - USOS PROHIBIDOS
Además de las prohibiciones establecidas en los Términos del Servicio, se prohíbe utilizar el sitio o su contenido: (a) para cualquier propósito ilícito; (b) para incitar a otros a realizar o participar en actos ilícitos; (c) para infringir reglamentos, normas, leyes internacionales, federales, provinciales o estatales, u ordenanzas locales; (d) para infringir nuestros derechos de propiedad intelectual o los de terceros; (e) para acosar, abusar, insultar, perjudicar, difamar, calumniar, desacreditar, intimidar o discriminar por motivos de género, orientación sexual, religión, etnia, raza, edad, nacionalidad o discapacidad; (f) para enviar información falsa o engañosa; (g) para cargar o transmitir virus u otro tipo de código malicioso que afecte o pueda afectar de cualquier forma la funcionalidad o el funcionamiento del Servicio, de cualquier sitio web relacionado, de otros sitios web o de Internet; (h) para recopilar o rastrear información personal de otras personas; (i) para enviar spam, suplantar sitios de forma fraudulenta, realizar pharming o pretexting, rastrear, rastrear mediante arañas web o extraer datos; (j) para cualquier propósito obsceno o inmoral; o (k) para interferir o eludir las funciones de seguridad del Servicio, de cualquier sitio web relacionado, de otros sitios web o de Internet. Nos reservamos el derecho de terminar su uso del Servicio o de cualquier sitio web relacionado por infringir cualquiera de los usos prohibidos.

SECCIÓN 13 - EXENCIÓN DE GARANTÍAS; LIMITACIÓN DE RESPONSABILIDAD
No garantizamos, declaramos ni aseguramos que el uso de nuestro Servicio será ininterrumpido, oportuno, seguro o libre de errores.
No garantizamos que los resultados que puedan obtenerse del uso del Servicio sean exactos o confiables.
Usted acepta que, de vez en cuando, podemos retirar el Servicio por períodos indefinidos o cancelarlo en cualquier momento, sin previo aviso.
Usted acepta expresamente que el uso del Servicio, o la imposibilidad de usarlo, queda bajo su exclusivo riesgo. El Servicio y todos los productos y Servicios que se le proporcionen a través del Servicio se ofrecen (salvo que nosotros indiquemos expresamente lo contrario) “tal cual” y “según disponibilidad” para su uso, sin declaraciones, garantías ni condiciones de ningún tipo, expresas o implícitas, incluidas todas las garantías o condiciones implícitas de comerciabilidad, calidad comercial, idoneidad para un propósito particular, durabilidad, titularidad y no infracción.
En ningún caso Inflatable sales group, nuestros directores, funcionarios, empleados, afiliados, agentes, contratistas, pasantes, proveedores, prestadores de Servicios o licenciantes serán responsables por lesiones, pérdidas, reclamaciones ni daños directos, indirectos, incidentales, punitivos, especiales o consecuentes de ningún tipo, incluidos, entre otros, la pérdida de beneficios, ingresos, ahorros o datos, los costos de reemplazo o daños similares, ya sea por contrato, responsabilidad extracontractual (incluida la negligencia), responsabilidad objetiva o de otro modo, que surjan del uso de cualquiera de los Servicios o de cualquier producto adquirido mediante el Servicio, o de cualquier otra reclamación relacionada de algún modo con el uso del Servicio o de cualquier producto, incluidos, entre otros, errores u omisiones en cualquier contenido, o cualquier pérdida o daño de cualquier tipo sufrido como resultado del uso del Servicio o de cualquier contenido (o producto) publicado, transmitido o puesto a disposición a través del Servicio, incluso si se hubiera advertido de la posibilidad de dichos daños. Dado que algunos estados o jurisdicciones no permiten excluir o limitar la responsabilidad por daños incidentales o consecuentes, en dichos estados o jurisdicciones nuestra responsabilidad se limitará al máximo permitido por la ley.

SECCIÓN 14 - INDEMNIZACIÓN
Usted acepta indemnizar, defender y eximir de responsabilidad a Inflatable sales group y a nuestra empresa matriz, subsidiarias, afiliadas, socios, funcionarios, directores, agentes, contratistas, licenciantes, prestadores de Servicios, subcontratistas, proveedores, pasantes y empleados frente a cualquier reclamación o demanda, incluidos los honorarios razonables de abogados, presentada por un tercero debido a su incumplimiento de estos Términos del Servicio o de los documentos que incorporan por referencia, o a la infracción por su parte de cualquier ley o de los derechos de terceros.

SECCIÓN 15 - DIVISIBILIDAD
Si se determina que alguna disposición de estos Términos del Servicio es ilegal, nula o inaplicable, dicha disposición seguirá siendo aplicable en la máxima medida permitida por la ley vigente, y la parte inaplicable se considerará separada de estos Términos del Servicio. Esa determinación no afectará la validez ni la aplicabilidad de las demás disposiciones.

SECCIÓN 16 - TERMINACIÓN
Las obligaciones y responsabilidades de las partes contraídas antes de la fecha de terminación subsistirán a la terminación de este acuerdo para todos los efectos.
Estos Términos del Servicio permanecerán vigentes hasta que usted o nosotros los terminemos. Usted puede terminarlos en cualquier momento notificándonos que ya no desea utilizar nuestros Servicios o dejando de utilizar nuestro sitio.
Si, a nuestro exclusivo juicio, usted incumple o sospechamos que ha incumplido algún término o disposición de estos Términos del Servicio, también podemos terminar este acuerdo en cualquier momento y sin previo aviso. Usted seguirá siendo responsable de todos los importes adeudados hasta la fecha de terminación, inclusive, y podremos denegarle el acceso a nuestros Servicios (o a cualquier parte de estos).

SECCIÓN 17 - ACUERDO COMPLETO
El hecho de que no ejerzamos o hagamos cumplir algún derecho o disposición de estos Términos del Servicio no constituirá una renuncia a dicho derecho o disposición.
Estos Términos del Servicio y las políticas o reglas operativas que publiquemos en este sitio o con respecto al Servicio constituyen el acuerdo y entendimiento íntegros entre usted y nosotros, y rigen su uso del Servicio. Sustituyen cualquier acuerdo, comunicación o propuesta anterior o contemporánea, oral o escrita, entre usted y nosotros (incluidas, entre otras, las versiones anteriores de los Términos del Servicio).
Las ambigüedades en la interpretación de estos Términos del Servicio no se interpretarán en contra de la parte que los redactó.

SECCIÓN 18 - LEY APLICABLE
Estos Términos del Servicio y cualquier acuerdo independiente mediante el cual le proporcionemos Servicios se regirán e interpretarán de conformidad con las leyes de Estados Unidos.

SECCIÓN 19 - CAMBIOS EN LOS TÉRMINOS DEL SERVICIO
Puede consultar la versión más reciente de los Términos del Servicio en cualquier momento en esta página.
Nos reservamos el derecho, a nuestro exclusivo criterio, de actualizar, modificar o reemplazar cualquier parte de estos Términos del Servicio mediante la publicación de actualizaciones y cambios en nuestro sitio web. Es su responsabilidad revisar periódicamente nuestro sitio web para comprobar si hay cambios. Si continúa utilizando o accediendo a nuestro sitio web o al Servicio después de la publicación de cualquier cambio en estos Términos del Servicio, acepta dichos cambios.

SECCIÓN 20 - INFORMACIÓN DE CONTACTO
Las preguntas sobre los Términos del Servicio deben enviarse a harry@bouncingangels.com.
TERMS;

    $termsText = $isSpanish ? $spanishTerms : file_get_contents(__DIR__ . '/terms.txt');
    if ($termsText === false) {
        throw new RuntimeException('Unable to read the terms.txt source file.');
    }

    function parseTermsDocument($text)
    {
        $lines = preg_split('/\R/', trim($text));
        $title = array_shift($lines);
        $sections = [];
        $heading = null;
        $paragraph = [];
        $flushParagraph = static function () use (&$paragraph, &$sections) {
            if ($paragraph !== []) {
                $sections[count($sections) - 1]['paragraphs'][] = implode(' ', $paragraph);
                $paragraph = [];
            }
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                $flushParagraph();
                continue;
            }

            if (preg_match('/^(OVERVIEW|RESUMEN|SECTION\s+\d+\s+-|SECCIÓN\s+\d+\s+-)/iu', $line)) {
                $flushParagraph();
                $heading = $line;
                $sections[] = ['heading' => $heading, 'paragraphs' => []];
                continue;
            }

            if ($heading === null) {
                throw new RuntimeException('The terms document is missing its overview heading.');
            }
            $paragraph[] = $line;
        }
        $flushParagraph();

        return ['title' => $title, 'sections' => $sections];
    }

    $document = parseTermsDocument($termsText);
    $escape = static function ($value) {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };
?>
  <title><?= $escape($document['title']) ?> — <?= COMPANY_NAME ?></title>
  <meta name="description" content="<?= $escape($isSpanish ? 'Términos y condiciones para el uso de los servicios de' : 'Terms and conditions for using the services of') ?> <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<style>
:root{
  --container-text: 760px;
}
body{
  margin:0; font-family:var(--font); color:var(--color-ink); background:var(--color-bg);
  -webkit-font-smoothing:antialiased; font-size:15px; line-height:1.5;
}
.wrap-text { max-width:var(--container-text); margin:0 auto; padding:0 24px; }
.legal-header { padding:60px 0 40px; border-bottom:1px solid var(--color-line); margin-bottom:40px; }
.legal-header h1 { font-size:2.4rem; font-weight:800; letter-spacing:-0.03em; margin:0 0 12px; line-height:1.1; }
.legal-content h2 { font-size:1.3rem; font-weight:700; letter-spacing:-0.01em; margin:36px 0 14px; color:var(--color-ink); }
.legal-content p { margin:0 0 16px; color:#2D3139; }
</style>
<link rel="stylesheet" href="css/cart.css">
</head>

<body>
<?php require_once 'nav.php'; ?>

<main class="wrap-text">
  <header class="legal-header">
    <h1><?= $escape($document['title']) ?></h1>
  </header>

  <article class="legal-content">
    <?php foreach ($document['sections'] as $section): ?>
      <h2><?= $escape($section['heading']) ?></h2>
      <?php foreach ($section['paragraphs'] as $paragraph): ?>
        <p><?= $escape($paragraph) ?></p>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </article>
</main>
<?php
    require_once 'news.php';
    require_once 'foot.php';
    require_once 'cart.php';
?>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php require_once 'scripts.php'; ?>
<script src="js/index.js"></script>
</html>
