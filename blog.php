<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php';
?>
<title>Blog — <?= COMPANY_NAME ?></title>
<meta name="description" content="Artículos, ideas y novedades de <?= COMPANY_NAME ?>.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= URL_BASE ?>/css/index.css">
<link rel="stylesheet" href="<?= URL_BASE ?>/css/cart.css">
<link rel="stylesheet" href="<?= URL_BASE ?>/css/blog.css">
</head>

<body>
<?php require_once 'nav.php'; ?>

<main class="wrap blog-page">
  <header class="blog-header">
    <p class="blog-eyebrow"><?= COMPANY_NAME ?></p>
    <h1>Ideas para hacer crecer tu negocio</h1>
    <p class="blog-intro">Consejos, novedades e historias para emprender en grande.</p>
  </header>

  <section class="blog-tools" aria-label="Buscar artículos">
    <p class="blog-results" id="blog-results" aria-live="polite"></p>
    <form class="blog-search" id="blog-search-form" role="search">
      <label class="visually-hidden" for="blog-search-input">Buscar artículos</label>
      <input id="blog-search-input" name="search" type="search" placeholder="Buscar artículos..." autocomplete="off">
      <button type="submit" class="blog-search-button" aria-label="Buscar">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 5 5"></path></svg>
      </button>
    </form>
  </section>

  <section class="blog-grid" id="blog-grid" aria-live="polite" aria-busy="false"></section>
  <nav class="blog-pagination" id="blog-pagination" aria-label="Paginación de artículos"></nav>
</main>

<?php
  require_once 'news.php';
  require_once 'foot.php';
  require_once 'cart.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php require_once 'scripts.php'; ?>
<script src="<?= URL_BASE ?>/js/index.js"></script>

<script>
const BLOG_ARTICLES_PER_PAGE = 12;
let blogCurrentPage = 1;
let blogRequest = null;

function escapeBlogImageUrl(value) {
    if (!value) return '';

    try {
        const imageUrl = new URL(String(value), `${url_images}/`);
        return ['http:', 'https:'].includes(imageUrl.protocol) ? imageUrl.href : '';
    } catch (error) {
        return '';
    }
}

function getBlogPublication(article) {
    const dateValue = article.published_at || article.publication_date || article.fecha_publicacion || article.fecha_creacion || article.fecha || '';
    const timeValue = article.published_time || article.publication_time || article.hora_publicacion || article.hora || '';
    const hasEmbeddedTime = /\d{1,2}:\d{2}/.test(String(dateValue));
    const normalizedDate = String(dateValue).replace(' ', 'T');
    const dateInput = dateValue ? `${normalizedDate}${timeValue && !hasEmbeddedTime ? `T${timeValue}` : ''}` : '';
    const parsedDate = dateInput ? new Date(dateInput) : null;

    if (!parsedDate || Number.isNaN(parsedDate.getTime())) {
        return { label: [dateValue, timeValue].filter(Boolean).join(' · '), datetime: '' };
    }

    const dateLabel = new Intl.DateTimeFormat('es-MX', {
        day: 'numeric', month: 'long', year: 'numeric'
    }).format(parsedDate);
    const timeLabel = timeValue || (hasEmbeddedTime
        ? new Intl.DateTimeFormat('es-MX', { hour: '2-digit', minute: '2-digit' }).format(parsedDate)
        : '');

    return {
        label: [dateLabel, timeLabel].filter(Boolean).join(' · '),
        datetime: parsedDate.toISOString()
    };
}

function appendBlogText(parent, tagName, className, text) {
    const element = document.createElement(tagName);
    element.className = className;
    element.textContent = text || '';
    parent.appendChild(element);
    return element;
}

function renderBlogArticles(articles) {
    const grid = document.getElementById('blog-grid');
    grid.replaceChildren();

    if (!articles.length) {
        appendBlogText(grid, 'p', 'blog-state', 'No hay artículos disponibles por el momento.');
        return;
    }

    const fragment = document.createDocumentFragment();
    articles.forEach(article => {
        const title = article.title || article.titulo || article.Titulo || article.titulo_articulo || article.Name || 'Artículo sin título';
        const creator = article.creator || article.author || article.creador || article.autor || article.nombre_creador || 'Redacción';
        const image = article.image || article.image_url || article.imagen || article.Imagen || article.imagen_portada || article.cover_image || '';
        const slug = article.slug || article.Slug || '';
        const articleUrl = slug ? `<?= URL_BASE ?>/blogs/${encodeURIComponent(slug)}` : '#';
        const publication = getBlogPublication(article);
        const card = document.createElement('article');
        card.className = 'blog-card';

        const media = document.createElement(slug ? 'a' : 'div');
        media.className = 'blog-card-media';
        if (slug) {
            media.href = articleUrl;
            media.setAttribute('aria-label', title);
        }
        const imageUrl = escapeBlogImageUrl(image);
        if (imageUrl) {
            const imageElement = document.createElement('img');
            imageElement.src = imageUrl;
            imageElement.alt = title;
            imageElement.loading = 'lazy';
            imageElement.addEventListener('error', () => {
                imageElement.remove();
                appendBlogText(media, 'span', 'blog-image-fallback', 'Imagen no disponible');
            }, { once: true });
            media.appendChild(imageElement);
        } else {
            appendBlogText(media, 'span', 'blog-image-fallback', 'Imagen no disponible');
        }

        const body = document.createElement('div');
        body.className = 'blog-card-body';
        
        const titleContainer = document.createElement('h2');
        titleContainer.className = 'blog-card-title';
        if (slug) {
            const titleLink = document.createElement('a');
            titleLink.href = articleUrl;
            titleLink.textContent = title;
            titleContainer.appendChild(titleLink);
        } else {
            titleContainer.textContent = title;
        }
        body.appendChild(titleContainer);

        appendBlogText(body, 'p', 'blog-card-creator', creator);

        const time = document.createElement('time');
        time.className = 'blog-card-date';
        if (publication.datetime) time.dateTime = publication.datetime;
        time.textContent = publication.label || 'Fecha por confirmar';
        body.appendChild(time);

        card.append(media, body);
        fragment.appendChild(card);
    });
    grid.appendChild(fragment);
}

function renderBlogPagination(response) {
    const pagination = document.getElementById('blog-pagination');
    pagination.replaceChildren();

    const totalPages = Number(response.total_paginas || response.total_pages || 1);
    blogCurrentPage = Number(response.pagina_actual || response.current_page || blogCurrentPage);
    if (totalPages <= 1) return;

    const addPageButton = (label, page, options = {}) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `blog-page-button${options.active ? ' active' : ''}`;
        button.textContent = label;
        button.disabled = Boolean(options.disabled);
        if (options.active) button.setAttribute('aria-current', 'page');
        button.addEventListener('click', () => loadBlogArticles(page));
        pagination.appendChild(button);
    };

    addPageButton('Anterior', blogCurrentPage - 1, { disabled: blogCurrentPage <= 1 });

    let firstPage = Math.max(1, blogCurrentPage - 2);
    let lastPage = Math.min(totalPages, firstPage + 4);
    firstPage = Math.max(1, lastPage - 4);
    for (let page = firstPage; page <= lastPage; page++) {
        addPageButton(String(page), page, { active: page === blogCurrentPage });
    }

    addPageButton('Siguiente', blogCurrentPage + 1, { disabled: blogCurrentPage >= totalPages });
}

function loadBlogArticles(page = 1) {
    const grid = document.getElementById('blog-grid');
    const results = document.getElementById('blog-results');
    const search = document.getElementById('blog-search-input').value.trim();
    blogCurrentPage = page;
    grid.setAttribute('aria-busy', 'true');
    grid.replaceChildren();
    appendBlogText(grid, 'p', 'blog-state', 'Cargando artículos...');
    results.textContent = '';
    document.getElementById('blog-pagination').replaceChildren();

    if (blogRequest) blogRequest.abort();
    blogRequest = $.ajax({
        url: url_api + 'get_all_blogs',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            pagina: page,
            registros_por_pagina: BLOG_ARTICLES_PER_PAGE,
            search: search
        }),
        headers: {
            'Authorization': 'Bearer ' + token,
            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
            'LNG': '<?= $_SESSION['Idioma'] ?>'
        },
        success: function(response) {
            const articles = Array.isArray(response.data) ? response.data : [];
            renderBlogArticles(articles);
            renderBlogPagination(response);
            const total = Number(response.total_registros || response.total_records || articles.length);
            results.textContent = `${total} ${total === 1 ? 'artículo' : 'artículos'}`;
        },
        error: function(xhr, status) {
            if (status === 'abort') return;
            grid.replaceChildren();
            appendBlogText(grid, 'p', 'blog-state blog-state-error', 'No fue posible cargar los artículos. Intenta de nuevo.');
        },
        complete: function() {
            grid.setAttribute('aria-busy', 'false');
        }
    });
}

document.getElementById('blog-search-form').addEventListener('submit', event => {
    event.preventDefault();
    loadBlogArticles(1);
});

$(document).ready(() => loadBlogArticles(1));
</script>
</body>
</html>