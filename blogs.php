<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';

    // 1. Obtener y sanitizar el slug
    $slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
    $slug = htmlspecialchars($slug, ENT_QUOTES, 'UTF-8');

    // 2. Datos de ejemplo para desarrollo o fallback
    $sample_articles = [
        'introduccion-a-la-inteligencia-artificial-en-2026' => [
            'titulo' => 'Introducción a la Inteligencia Artificial en 2026',
            'slug' => 'introduccion-a-la-inteligencia-artificial-en-2026',
            'resumen' => 'Descubre las principales tendencias y herramientas de IA que están transformando la industria actual.',
            'html_contenido' => '<p>La <strong>Inteligencia Artificial</strong> ha avanzado a pasos agigantados. En este artículo analizamos los modelos más recientes y sus aplicaciones prácticas en el desarrollo de software y automatización.</p>
            <h2>1. Agentes autónomos y modelos generativos multimodales</h2>
            <p>Los sistemas modernos ya no se limitan a responder preguntas simples de texto. Hoy en día, los agentes con capacidades de razonamiento profundo pueden coordinar tareas complejas de principio a fin, integrando visión por computadora, análisis de audio y ejecución de herramientas de software.</p>
            <blockquote>"La verdadera ventaja competitiva radica en cómo las organizaciones integran la inteligencia artificial en sus flujos diarios de trabajo para potenciar las capacidades humanas."</blockquote>
            <h2>2. Automatización inteligente en los negocios</h2>
            <p>Empresas de todos los tamaños están implementando flujos de trabajo inteligentes que reducen el tiempo de respuesta a clientes, optimizan inventarios y generan análisis predictivos en tiempo real.</p>
            <ul>
                <li><strong>Atención al cliente 24/7:</strong> Asistentes conversacionales con comprensión de contexto profunda.</li>
                <li><strong>Análisis de datos predictivo:</strong> Detección temprana de tendencias del mercado y patrones de demanda.</li>
                <li><strong>Optimización operativa:</strong> Reducción de costos y minimización de errores manuales en procesos repetitivos.</li>
            </ul>
            <h2>3. Conclusiones y visión de futuro</h2>
            <p>El 2026 marca un punto de inflexión donde la accesibilidad de las tecnologías de IA permite a emprendedores y corporaciones innovar a una velocidad sin precedentes. Mantenerse actualizado y experimentar con estas herramientas es clave para liderar el mercado.</p>',
            'imagen_destacada' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1400&q=80',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'creador_id' => 1,
            'creador' => 'Equipo Editorial',
            'estado' => 'publicado',
            'fecha_publicacion' => '2026-09-01 10:00:00'
        ]
    ];

    $article = null;
    $prev_article = null;
    $next_article = null;

    // 3. Consultar la API get_blog_by_slug
    if (!empty($slug)) {
        $api_url = URL_API . "get_blog_by_slug";
        $postData = json_encode(['slug' => $slug]);
        $response_raw = API($jwt, $api_url, $postData, 'POST');
        $response = json_decode($response_raw, true);

        if (!empty($response['data'])) {
            $article = is_array($response['data']) && isset($response['data']['titulo'])
                ? $response['data']
                : (isset($response['data'][0]) ? $response['data'][0] : $response['data']);
        } elseif (!empty($response['titulo']) || !empty($response['title'])) {
            $article = $response;
        }

        // Obtener artículo anterior y siguiente si vienen en la respuesta de la API
        if (!empty($response['prev_article'])) {
            $prev_article = $response['prev_article'];
        } elseif (!empty($response['articulo_anterior'])) {
            $prev_article = $response['articulo_anterior'];
        } elseif (!empty($response['anterior'])) {
            $prev_article = $response['anterior'];
        }

        if (!empty($response['next_article'])) {
            $next_article = $response['next_article'];
        } elseif (!empty($response['articulo_siguiente'])) {
            $next_article = $response['articulo_siguiente'];
        } elseif (!empty($response['siguiente'])) {
            $next_article = $response['siguiente'];
        }
    }

    // Fallback de demostración si la API aún no tiene el slug de prueba
    if (!$article && isset($sample_articles[$slug])) {
        $article = $sample_articles[$slug];
    }

    // 4. Mapeo de campos estandarizados
    $titulo = $article['titulo'] ?? $article['title'] ?? ($slug ? 'Artículo' : 'Artículo no encontrado');
    $resumen = $article['resumen'] ?? $article['summary'] ?? $article['description'] ?? '';
    $html_contenido = $article['html_contenido'] ?? $article['content'] ?? $article['contenido'] ?? '';
    $imagen_destacada = $article['imagen_destacada'] ?? $article['image'] ?? $article['imagen'] ?? $article['cover_image'] ?? '';
    $video_url = $article['video_url'] ?? $article['video'] ?? '';
    $creador = $article['creador'] ?? $article['author'] ?? $article['autor'] ?? $article['nombre_creador'] ?? 'Equipo Editorial';
    $estado = $article['estado'] ?? $article['status'] ?? 'publicado';
    $fecha_publicacion = $article['fecha_publicacion'] ?? $article['published_at'] ?? $article['fecha'] ?? '';

    // Iniciales para el avatar del autor
    $avatar_initials = 'ED';
    if (!empty($creador)) {
        $words = preg_split('/\s+/', trim($creador));
        if (count($words) >= 2) {
            $avatar_initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        } else {
            $avatar_initials = mb_strtoupper(mb_substr($creador, 0, 2));
        }
    }

    // Procesar URL de la imagen destacada
    $image_display = '';
    if (!empty($imagen_destacada)) {
        if (preg_match('/^https?:\/\//i', $imagen_destacada)) {
            $image_display = $imagen_destacada;
        } else {
            $image_display = rtrim(URL_IMAGES, '/') . '/' . ltrim($imagen_destacada, '/');
        }
    }

    // Formateador de fecha en español
    function format_blog_date_es($dateValue) {
        if (empty($dateValue)) return 'Fecha por confirmar';
        $timestamp = strtotime($dateValue);
        if (!$timestamp) return $dateValue;
        $months = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];
        $day = date('j', $timestamp);
        $month = $months[(int)date('n', $timestamp)] ?? date('F', $timestamp);
        $year = date('Y', $timestamp);
        return "$day de $month, $year";
    }

    $fecha_formateada = format_blog_date_es($fecha_publicacion);
    $fecha_iso = !empty($fecha_publicacion) ? date('c', strtotime($fecha_publicacion)) : date('c');

    // Estimación de tiempo de lectura
    $word_count = str_word_count(strip_tags($html_contenido));
    $reading_time = max(1, (int)ceil($word_count / 200)) . ' min de lectura';

    // Parser de video embebido (YouTube, Vimeo, MP4)
    function parse_blog_video($url) {
        if (empty($url)) return null;
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return [
                'type' => 'youtube',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?rel=0&modestbranding=1',
                'video_id' => $matches[1]
            ];
        }
        if (preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $url, $matches)) {
            return [
                'type' => 'vimeo',
                'embed_url' => 'https://player.vimeo.com/video/' . $matches[1],
                'video_id' => $matches[1]
            ];
        }
        if (preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $url)) {
            return [
                'type' => 'direct',
                'src' => $url
            ];
        }
        return null;
    }

    $video_info = parse_blog_video($video_url);

    // URL canónica para compartir en redes
    $share_url = URL_BASE . '/blogs/' . ($slug ? urlencode($slug) : '');
    $encoded_url = urlencode($share_url);
    $encoded_title = urlencode($titulo);
    $encoded_full_msg = urlencode($titulo . ' — ' . $share_url);

    $share_links = [
        'whatsapp' => "https://api.whatsapp.com/send?text={$encoded_full_msg}",
        'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encoded_url}",
        'twitter'  => "https://twitter.com/intent/tweet?text={$encoded_title}&url={$encoded_url}",
        'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encoded_url}",
        'telegram' => "https://t.me/share/url?url={$encoded_url}&text={$encoded_title}",
        'email'    => "mailto:?subject={$encoded_title}&body=" . rawurlencode("Te invito a leer este artículo: {$titulo}\n\n{$share_url}")
    ];

    require_once 'head.php';
?>
<title><?= htmlspecialchars($titulo) ?> — <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= htmlspecialchars(!empty($resumen) ? $resumen : 'Artículo en ' . COMPANY_NAME) ?>">

<!-- Open Graph / Redes Sociales -->
<meta property="og:type" content="article">
<meta property="og:title" content="<?= htmlspecialchars($titulo) ?> — <?= COMPANY_NAME ?>">
<meta property="og:description" content="<?= htmlspecialchars(!empty($resumen) ? $resumen : $titulo) ?>">
<meta property="og:url" content="<?= htmlspecialchars($share_url) ?>">
<meta property="og:site_name" content="<?= COMPANY_NAME ?>">
<?php if (!empty($image_display)): ?>
<meta property="og:image" content="<?= htmlspecialchars($image_display) ?>">
<?php endif; ?>
<meta property="article:published_time" content="<?= htmlspecialchars($fecha_iso) ?>">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($titulo) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars(!empty($resumen) ? $resumen : $titulo) ?>">
<?php if (!empty($image_display)): ?>
<meta name="twitter:image" content="<?= htmlspecialchars($image_display) ?>">
<?php endif; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= URL_BASE ?>/css/index.css">
<link rel="stylesheet" href="<?= URL_BASE ?>/css/cart.css">
<link rel="stylesheet" href="<?= URL_BASE ?>/css/blog.css">
</head>

<body>
<?php require_once 'nav.php'; ?>

<main class="wrap blog-article-page">
  <!-- Migas de pan (Breadcrumbs) -->
  <nav class="blog-breadcrumbs" aria-label="Ruta de navegación">
    <a href="<?= URL_BASE ?>/">Inicio</a>
    <span class="separator" aria-hidden="true">/</span>
    <a href="<?= URL_BASE ?>/blog">Blog</a>
    <span class="separator" aria-hidden="true">/</span>
    <span class="current" aria-current="page"><?= htmlspecialchars($titulo) ?></span>
  </nav>

  <?php if ($article): ?>
  <article class="article-container" id="blog-article-container">
    
    <!-- Encabezado del Artículo -->
    <header class="article-header">
      <span class="article-category-badge">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
        Artículo de Blog
      </span>
      <h1 id="article-title"><?= htmlspecialchars($titulo) ?></h1>
      
      <?php if (!empty($resumen)): ?>
      <p class="article-lead" id="article-lead"><?= htmlspecialchars($resumen) ?></p>
      <?php endif; ?>

      <!-- Barra de Metadatos y Compartir Rápido -->
      <div class="article-meta-bar">
        <div class="article-author-info">
          <div class="article-author-avatar" aria-hidden="true"><?= $avatar_initials ?></div>
          <div class="article-meta-details">
            <span class="article-author-name" id="article-author"><?= htmlspecialchars($creador) ?></span>
            <div class="article-meta-sub">
              <time datetime="<?= htmlspecialchars($fecha_iso) ?>" id="article-date"><?= $fecha_formateada ?></time>
              <span class="article-meta-dot" aria-hidden="true">•</span>
              <span class="article-reading-time" id="article-reading-time"><?= $reading_time ?></span>
            </div>
          </div>
        </div>

        <!-- Botones de compartir superiores -->
        <div class="article-quick-share" aria-label="Compartir artículo">
          <span class="quick-share-label">Compartir:</span>
          
          <!-- WhatsApp -->
          <a href="<?= $share_links['whatsapp'] ?>" target="_blank" rel="noopener noreferrer" class="share-btn-mini wa" title="Compartir en WhatsApp" aria-label="Compartir en WhatsApp">
            <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24M8.53 7.33c-.19 0-.48.07-.73.34-.25.28-.97.95-.97 2.31s.99 2.68 1.13 2.86c.14.19 1.95 2.97 4.73 4.17.66.29 1.18.46 1.58.59.67.21 1.28.18 1.76.11.53-.08 1.64-.67 1.87-1.32.23-.64.23-1.2.16-1.32-.07-.11-.26-.18-.55-.32-.28-.14-1.64-.81-1.9-1-.25-.09-.43-.14-.62.14-.18.28-.71.9-.87 1.08-.16.18-.32.21-.6.07-.28-.14-1.18-.44-2.26-1.4-.84-.75-1.4-1.68-1.56-1.96-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.19.05-.36-.02-.5-.07-.14-.62-1.5-.85-2.06-.23-.55-.46-.48-.63-.49-.16-.01-.36-.01-.55-.01Z"/></svg>
          </a>

          <!-- Facebook -->
          <a href="<?= $share_links['facebook'] ?>" target="_blank" rel="noopener noreferrer" class="share-btn-mini fb" title="Compartir en Facebook" aria-label="Compartir en Facebook">
            <svg viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
          </a>

          <!-- X (Twitter) -->
          <a href="<?= $share_links['twitter'] ?>" target="_blank" rel="noopener noreferrer" class="share-btn-mini tw" title="Compartir en X" aria-label="Compartir en X">
            <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>

          <!-- LinkedIn -->
          <a href="<?= $share_links['linkedin'] ?>" target="_blank" rel="noopener noreferrer" class="share-btn-mini in" title="Compartir en LinkedIn" aria-label="Compartir en LinkedIn">
            <svg viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.65 1.65 0 0 0 1.66-1.66 1.66 1.66 0 1 0-1.66 1.66m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
          </a>

          <!-- Copiar Enlace -->
          <button type="button" class="share-btn-mini copy btn-copy-link" data-url="<?= htmlspecialchars($share_url) ?>" title="Copiar enlace" aria-label="Copiar enlace del artículo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
          </button>
        </div>
      </div>
    </header>

    <!-- Elemento Multimedia Destacado (Video o Imagen) -->
    <div class="article-featured-media">
      <?php if (!empty($video_info)): ?>
        <div class="article-video-wrapper">
          <?php if ($video_info['type'] === 'youtube' || $video_info['type'] === 'vimeo'): ?>
            <iframe 
              src="<?= htmlspecialchars($video_info['embed_url']) ?>" 
              title="<?= htmlspecialchars($titulo) ?>"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
              allowfullscreen 
              loading="lazy">
            </iframe>
          <?php elseif ($video_info['type'] === 'direct'): ?>
            <video controls preload="metadata">
              <source src="<?= htmlspecialchars($video_info['src']) ?>">
              Tu navegador no soporta la reproducción de video.
            </video>
          <?php endif; ?>
        </div>
      <?php elseif (!empty($image_display)): ?>
        <img 
          src="<?= htmlspecialchars($image_display) ?>" 
          alt="<?= htmlspecialchars($titulo) ?>" 
          class="article-media-image"
          loading="eager"
          onerror="this.style.display='none';"
        >
      <?php endif; ?>
    </div>

    <!-- Contenido HTML Principal del Artículo -->
    <div class="article-content" id="article-body">
      <?= $html_contenido ?>
    </div>

    <!-- Caja de Compartir en Redes Sociales (Al pie del artículo) -->
    <section class="article-share-box" aria-label="Compartir en redes sociales">
      <div class="share-box-header">
        <h3>¿Te gustó este artículo? ¡Compártelo!</h3>
        <p>Ayuda a otros emprendedores y profesionales compartiendo este contenido en tus redes sociales.</p>
      </div>

      <div class="share-buttons-grid">
        <!-- WhatsApp -->
        <a href="<?= $share_links['whatsapp'] ?>" target="_blank" rel="noopener noreferrer" class="share-card-btn wa">
          <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24M8.53 7.33c-.19 0-.48.07-.73.34-.25.28-.97.95-.97 2.31s.99 2.68 1.13 2.86c.14.19 1.95 2.97 4.73 4.17.66.29 1.18.46 1.58.59.67.21 1.28.18 1.76.11.53-.08 1.64-.67 1.87-1.32.23-.64.23-1.2.16-1.32-.07-.11-.26-.18-.55-.32-.28-.14-1.64-.81-1.9-1-.25-.09-.43-.14-.62.14-.18.28-.71.9-.87 1.08-.16.18-.32.21-.6.07-.28-.14-1.18-.44-2.26-1.4-.84-.75-1.4-1.68-1.56-1.96-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.19.05-.36-.02-.5-.07-.14-.62-1.5-.85-2.06-.23-.55-.46-.48-.63-.49-.16-.01-.36-.01-.55-.01Z"/></svg>
          <span>WhatsApp</span>
        </a>

        <!-- Facebook -->
        <a href="<?= $share_links['facebook'] ?>" target="_blank" rel="noopener noreferrer" class="share-card-btn fb">
          <svg viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
          <span>Facebook</span>
        </a>

        <!-- X (Twitter) -->
        <a href="<?= $share_links['twitter'] ?>" target="_blank" rel="noopener noreferrer" class="share-card-btn tw">
          <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          <span>X / Twitter</span>
        </a>

        <!-- LinkedIn -->
        <a href="<?= $share_links['linkedin'] ?>" target="_blank" rel="noopener noreferrer" class="share-card-btn in">
          <svg viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.65 1.65 0 0 0 1.66-1.66 1.66 1.66 0 1 0-1.66 1.66m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
          <span>LinkedIn</span>
        </a>

        <!-- Telegram -->
        <a href="<?= $share_links['telegram'] ?>" target="_blank" rel="noopener noreferrer" class="share-card-btn tg">
          <svg viewBox="0 0 24 24"><path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l-.313 4.672c.46 0 .663-.211.921-.46l2.211-2.15 4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.413Z"/></svg>
          <span>Telegram</span>
        </a>

        <!-- Correo Electrónico -->
        <a href="<?= $share_links['email'] ?>" class="share-card-btn email">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <span>Email</span>
        </a>
      </div>

      <!-- Barra de copiar enlace directo -->
      <div class="share-copy-bar">
        <input type="text" readonly value="<?= htmlspecialchars($share_url) ?>" class="share-copy-input" id="share-url-input" aria-label="Enlace del artículo">
        <button type="button" class="share-copy-btn btn-copy-link" data-url="<?= htmlspecialchars($share_url) ?>">
          <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
          <span>Copiar enlace</span>
        </button>
      </div>
    </section>

    <!-- Navegación al pie (Artículo anterior | Artículo siguiente) -->
    <nav class="article-nav-footer" aria-label="Navegación entre artículos">
      <div class="article-nav-grid" id="article-nav-grid">
        
        <!-- Artículo Anterior -->
        <div id="nav-prev-container">
          <?php if (!empty($prev_article)): ?>
            <?php 
              $prev_slug = $prev_article['slug'] ?? $prev_article['Slug'] ?? '';
              $prev_title = $prev_article['titulo'] ?? $prev_article['title'] ?? 'Artículo anterior';
            ?>
            <a href="<?= URL_BASE ?>/blogs/<?= htmlspecialchars($prev_slug) ?>" class="article-nav-card prev">
              <span class="nav-direction-label">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Artículo anterior
              </span>
              <span class="nav-article-title"><?= htmlspecialchars($prev_title) ?></span>
            </a>
          <?php else: ?>
            <div class="article-nav-empty" id="nav-prev-placeholder"></div>
          <?php endif; ?>
        </div>

        <!-- Botón Central: Ver todos los artículos -->
        <div class="article-nav-center">
          <a href="<?= URL_BASE ?>/blog" class="btn-all-blogs">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Ver todos los artículos
          </a>
        </div>

        <!-- Artículo Siguiente -->
        <div id="nav-next-container">
          <?php if (!empty($next_article)): ?>
            <?php 
              $next_slug = $next_article['slug'] ?? $next_article['Slug'] ?? '';
              $next_title = $next_article['titulo'] ?? $next_article['title'] ?? 'Artículo siguiente';
            ?>
            <a href="<?= URL_BASE ?>/blogs/<?= htmlspecialchars($next_slug) ?>" class="article-nav-card next">
              <span class="nav-direction-label">
                Artículo siguiente
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </span>
              <span class="nav-article-title"><?= htmlspecialchars($next_title) ?></span>
            </a>
          <?php else: ?>
            <div class="article-nav-empty" id="nav-next-placeholder"></div>
          <?php endif; ?>
        </div>

      </div>
    </nav>

  </article>

  <?php else: ?>
  <!-- Estado cuando no se encuentra el artículo -->
  <section class="blog-state" style="padding: 80px 20px; text-align: center;">
    <h2 style="font-size: 2rem; margin-bottom: 12px; color: var(--color-ink);">Artículo no encontrado</h2>
    <p style="color: var(--color-ink-soft); margin-bottom: 24px;">El artículo que buscas no existe o ha sido movido.</p>
    <a href="<?= URL_BASE ?>/blog" class="blog-page-button active" style="display: inline-flex; align-items: center; text-decoration: none; padding: 12px 24px; border-radius: var(--radius-sm);">
      Volver al listado de artículos
    </a>
  </section>
  <?php endif; ?>

</main>

<!-- Notificación Flotante (Toast) -->
<div id="blog-toast" class="blog-toast" role="status" aria-live="polite">
  <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
  <span>¡Enlace copiado al portapapeles!</span>
</div>

<?php
  require_once 'news.php';
  require_once 'foot.php';
  require_once 'cart.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php require_once 'scripts.php'; ?>
<script src="<?= URL_BASE ?>/js/index.js"></script>

<script>
const currentSlug = "<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>";
const hasPrevArticle = <?= !empty($prev_article) ? 'true' : 'false' ?>;
const hasNextArticle = <?= !empty($next_article) ? 'true' : 'false' ?>;

// Función para mostrar Toast flotante
function showBlogToast(message) {
    const toast = document.getElementById('blog-toast');
    if (!toast) return;
    if (message) {
        toast.querySelector('span').textContent = message;
    }
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3200);
}

// Copiar enlace al portapapeles
function setupCopyLinkButtons() {
    $(document).on('click', '.btn-copy-link', function(e) {
        e.preventDefault();
        const urlToCopy = $(this).data('url') || window.location.href;
        
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(urlToCopy).then(() => {
                showBlogToast('¡Enlace copiado al portapapeles!');
            }).catch(() => {
                fallbackCopyText(urlToCopy);
            });
        } else {
            fallbackCopyText(urlToCopy);
        }
    });
}

function fallbackCopyText(text) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    try {
        document.execCommand('copy');
        showBlogToast('¡Enlace copiado al portapapeles!');
    } catch (err) {
        showBlogToast('No fue posible copiar el enlace');
    }
    document.body.removeChild(tempInput);
}

// Cargar artículos adyacentes (anterior / siguiente) dinámicamente si no venían en la respuesta del backend
function loadAdjacentBlogArticles() {
    if ((hasPrevArticle && hasNextArticle) || !currentSlug) return;

    $.ajax({
        url: url_api + 'get_all_blogs',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            pagina: 1,
            registros_por_pagina: 50,
            search: ''
        }),
        headers: {
            'Authorization': 'Bearer ' + token,
            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
            'LNG': '<?= $_SESSION['Idioma'] ?>'
        },
        success: function(response) {
            const articles = Array.isArray(response.data) ? response.data : [];
            if (!articles.length) return;

            const currentIndex = articles.findIndex(item => {
                const s = item.slug || item.Slug || '';
                return s === currentSlug;
            });

            if (currentIndex === -1) return;

            // Artículo Anterior (índice anterior en la lista)
            if (!hasPrevArticle && currentIndex > 0) {
                const prev = articles[currentIndex - 1];
                const prevSlug = prev.slug || prev.Slug || '';
                const prevTitle = prev.titulo || prev.title || prev.Titulo || 'Artículo anterior';
                
                if (prevSlug) {
                    $('#nav-prev-container').html(`
                        <a href="${url_base}/blogs/${encodeURIComponent(prevSlug)}" class="article-nav-card prev">
                            <span class="nav-direction-label">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                Artículo anterior
                            </span>
                            <span class="nav-article-title">${escapeHtml(prevTitle)}</span>
                        </a>
                    `);
                }
            }

            // Artículo Siguiente (índice posterior en la lista)
            if (!hasNextArticle && currentIndex < articles.length - 1) {
                const next = articles[currentIndex + 1];
                const nextSlug = next.slug || next.Slug || '';
                const nextTitle = next.titulo || next.title || next.Titulo || 'Artículo siguiente';

                if (nextSlug) {
                    $('#nav-next-container').html(`
                        <a href="${url_base}/blogs/${encodeURIComponent(nextSlug)}" class="article-nav-card next">
                            <span class="nav-direction-label">
                                Artículo siguiente
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </span>
                            <span class="nav-article-title">${escapeHtml(nextTitle)}</span>
                        </a>
                    `);
                }
            }
        }
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}

$(document).ready(function() {
    setupCopyLinkButtons();
    loadAdjacentBlogArticles();
});
</script>
</body>
</html>
