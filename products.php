<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
    $Category = str_replace("-"," ",$_GET['Id']);

    $Sub = '';
    if (isset($_GET['Sub']))
        $Sub = str_replace("-"," ",$_GET['Sub']);

    if ($Category =='search'){
      $Category = str_replace("-"," ",$_GET['category']);
      $search = $_GET['q'];
    }
    else{
      $search = '';
    }


?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "products"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
    $Trad_rsp = $Traducciones;
?>

<title><?= Trd(1); ?> — <?= COMPANY_NAME ?></title>
<meta name="description" content="Explora nuestro catálogo completo de brincolines, combos y toboganes de agua comerciales al mayoreo.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<link rel="stylesheet" href="<?= URL_BASE ?>/css/products.css">
<link rel="stylesheet" href="<?= URL_BASE ?>/css/cart.css">

</head>
<body>
<?php 
  require_once ('nav.php');
   $Traducciones = $Trad_rsp;
?>


<main class="wrap">

  <header class="catalog-header">
    <h1><?= Trd(1); ?></h1>
    <p><?= Trd(2); ?></p>
  </header>

  <div class="catalog-bar">
    <span class="results-count" id="count_products"></span>
    <div class="catalog-utils">
      <button class="btn-filter-trigger" id="filterTriggerBtn">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; vertical-align: middle; display: inline-block;">
          <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
        </svg><?= Trd(3); ?>
      </button>
      <select class="sort-select" aria-label="Ordenar productos" id ="select-orden">
        <option value="destacados" ><?= Trd(4); ?></option>
        <option value="precio_menor"><?= Trd(5); ?></option>
        <option value="precio_mayor"><?= Trd(6); ?></option>
        <option value="nuevos" ><?= Trd(7); ?></option>
      </select>
    </div>
  </div>

  <div class="catalog-layout">
    
    <aside class="catalog-sidebar" id="catalogSidebar">
      <div class="sidebar-mobile-header">
        <h4><?= Trd(3); ?></h4>
        <button class="close-sidebar-btn" id="closeSidebarBtn" aria-label="Cerrar filtros">✕</button>
      </div>

      <div class="filter-group">
        <h3><?= Trd(8); ?></h3>
<ul class="filter-links">
    <?php
    if ($Category == 'all') {
        echo '<li class="active"><a href="'.URL_BASE.'/products/all">' . Trd(1) . '</a></li>';
    } else {
        echo '<li><a href="'.URL_BASE.'/products/all">' . Trd(1) . '</a></li>';
    }

    if ($datacat['status'] === 'success') {
        foreach ($datacat['data'] as $category) {
            $category['Imagen'] = URL_IMAGES.'/categories/thumbnails/'.$category['Imagen'];
            $URL = str_replace(" ", "-", $category['Nombre']);
            
            // 1. Validar si esta categoría tiene subcategorías
            $has_subcategories = false;
            $subcategories_html = '';
            
            if (isset($datascat['data']) && is_array($datascat['data'])) {
                foreach ($datascat['data'] as $scategory) {
                    if ($category['Id'] == $scategory['Id']) {
                        if (!$has_subcategories) {
                            $has_subcategories = true;
                            $subcategories_html .= '<ul class="sidebar-submenu">';
                        }
                        $SURL = str_replace(" ", "-", $scategory['Nombre_sc']);
                        
                        // Detectar si la subcategoría actual es la que está seleccionada (opcional, por si manejas la variable $SubCategory)
                        
                        
                        if ($Sub == $scategory['Nombre_sc']){
                            //$sub_active = (isset($SubCategory) && $SubCategory == $scategory['Nombre_sc']) ? 'class=" active"' : '';
                            //$subcategories_html .= '<li '.$sub_active.'><a href="'.URL_BASE.'/products/'.$URL.'/'.$SURL.'">'.$scategory['Nombre_sc'].'**</a></li>';
                            $subcategories_html .= '<li class="active-sub" ><a href="'.URL_BASE.'/products/'.$URL.'/'.$SURL.'">'.$scategory['Nombre_sc'].'</a></li>';
                        }                            
                        else{
                            //$sub_active = (isset($SubCategory) && $SubCategory == $scategory['Nombre_sc']) ? 'class="active-sub"' : '';
                            //$subcategories_html .= '<li '.$sub_active.'><a href="'.URL_BASE.'/products/'.$URL.'/'.$SURL.'">'.$scategory['Nombre_sc'].'</a></li>';
                            $subcategories_html .= '<li ><a href="'.URL_BASE.'/products/'.$URL.'/'.$SURL.'">'.$scategory['Nombre_sc'].'</a></li>';
                        }
                            

                        
                        
                    }
                }
                if ($has_subcategories) {
                    $subcategories_html .= '</ul>';
                }
            }
            
            // 2. Determinar las clases de la categoría padre
            $classes = [];
            if ($Category == $category['Nombre']) {
                $classes[] = 'active';
            }
            if ($has_subcategories) {
                $classes[] = 'has-sidebar-submenu';
            }
            
            // Si la categoría está activa y tiene subcategorías, la dejamos abierta por defecto de forma visual
            if ($Category == $category['Nombre'] && $has_subcategories) {
                $classes[] = 'open';
            }

            $class_string = !empty($classes) ? 'class="'.implode(' ', $classes).'"' : '';
            
            // 3. Renderizar el elemento de la lista
            echo '<li '.$class_string.'>';
            echo '<a href="'.URL_BASE.'/products/'.$URL.'">'.$category['Nombre'].'</a>';
            
            if ($has_subcategories) {
                echo $subcategories_html; // Aquí entran las subcategorías en formato acordeón
            }
            
            echo '</li>';
        }        
    } 
    ?> 
</ul>
      </div>

      <div class="filter-group">
        <h3><?= Trd(9); ?></h3>
        <ul class="filter-links">
          <li <?php echo ($Category  == "stock") ? "class='active'" : ""; ?>><a  href="<?= URL_BASE ?>/products/stock"><?= Trd(10); ?></a></li>
          <li <?php echo ($Category  == "byrequest") ? "class='active'" : ""; ?>><a href="<?= URL_BASE ?>/products/byrequest"><?= Trd(11); ?></a></li>
          <li <?php echo ($Category  == "newdesign") ? "class='active'" : ""; ?>><a href="<?= URL_BASE ?>/products/newdesign"><?= Trd(12); ?></a></li>
        </ul>
      </div>
    </aside>

    <section class="products-container">
      <div class="product-grid" id = "contenedor-productos">



      </div>

      <nav class="pagination" aria-label="Paginación de catálogo" id="paginado">

      </nav>

    </section>
  </div>
</main>
<?php
  require_once('news.php');
  require_once('foot.php');
  require_once('cart.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
  require_once('scripts.php');
?>
<script src="<?= URL_BASE ?>/js/index.js"></script>


<script>
// CONTROL DEL DRAWER DE FILTROS EN MÓVIL
const filterTriggerBtn = document.getElementById('filterTriggerBtn');
const catalogSidebar = document.getElementById('catalogSidebar');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');

if (filterTriggerBtn && catalogSidebar && navBackdrop) {
  filterTriggerBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    catalogSidebar.classList.add('open');
    navBackdrop.classList.add('open');
  });

  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener('click', () => {
      catalogSidebar.classList.remove('open');
      navBackdrop.classList.remove('open');
    });
  }
}

// Definimos variables globales para el estado del catálogo
let paginaActual = 1;
let registrosPorPagina = 9; // Modifica según tu diseño
let ordenActual = 'destacados'; // O 'precio_mayor'

$(document).ready(function() {
    // Primera carga al abrir la página
    cargarProductos(paginaActual,'<?php echo $Category ?>','<?php echo $Sub ?>','<?php echo $search ?>');

    // Ejemplo de evento si tienes un selector de ordenamiento (opcional)
    $('#select-orden').on('change', function() {
        ordenActual = $(this).val();
    //    ordenActual = 'precio_menor';
        cargarProductos(1,'<?php echo $Category ?>','<?php echo $Sub ?>',$('#q').val());
    });
});

// Función principal para consultar la API
function cargarProductos(pagina,category,scat,search) {
    paginaActual = pagina;
    const contenedor = document.getElementById('contenedor-productos');
    
    $.ajax({
        url: url_api + 'get_all_sales',
        type: 'POST', // Cambiado a GET según la API
        contentType: 'application/json',
        data: JSON.stringify({
            pagina: paginaActual,
            registros_por_pagina: registrosPorPagina,
            categoria: category, 
            scategoria: scat, 
            orden: ordenActual,
            search: search
        }),
        
        headers: {
            'Authorization': 'Bearer ' + token,
            'X-ID-CLIENT': '<?= ID_CLIENT ?>',
            'LNG': '<?= $_SESSION['Idioma'] ?>'
        },        
        beforeSend: function() {
            $('#count_products').html('');
            contenedor.innerHTML = `
                <div class="loading-container w-100 py-5 text-center">
                    <div class="custom-spinner"></div>
                    <p class="mt-3 text-muted small letter-spacing"><?= Trd(13); ?></p>
                </div>
            `;
        },
        success: function(response) {
            if (response.status === 'success' && response.data.length > 0) {
                $('#count_products').html(response.total_registros + ' <?= Trd(14); ?>');
                mostrarProductos(response.data);
                armarpaginado(response);
            } else {
                // Estado Estético: No se encontraron productos
                contenedor.innerHTML = `
                    <div class="empty-state-container w-100 py-5 text-center">
                        <div class="empty-icon">✕</div>
                        <h3 class="empty-title"><?= Trd(15); ?></h3>
                        <p class="empty-text"><?= Trd(16); ?></p>
                    </div>
                `;
                document.getElementById('paginado').innerHTML = '';
            }
        },
        error: function() {
            // Estado Estético: Error de conexión / servidor
            contenedor.innerHTML = `
                <div class="empty-state-container w-100 py-5 text-center">
                    <div class="empty-icon error-icon">!</div>
                    <h3 class="empty-title text-danger"><?= Trd(17); ?></h3>
                    <p class="empty-text"><?= Trd(18); ?></p>
                    <button class="btn-outline-sm mt-3" onclick="cargarProductos(paginaActual)"><?= Trd(19); ?></button>
                </div>
            `;
            document.getElementById('paginado').innerHTML = '';
        }
    });     
}

function mostrarProductos(productos) {
    const contenedor = $('#contenedor-productos');
    contenedor.empty(); // Limpiamos el contenedor

    // Estructura de la leyenda (Iconografía-Colors)
    const HTMLLeyenda = `
        <div class="products-legend-bar">
            <span class="legend-item"><span class="dot-icon dot-new"></span> <?= Trd(20); ?></span>
            <span class="legend-item"><span class="dot-icon dot-featured"></span> <?= Trd(21); ?></span>
            <span class="legend-item"><span class="dot-icon dot-stock"></span> <?= Trd(22); ?></span>
            <span class="legend-item"><span class="dot-icon dot-request"></span> <?= Trd(23); ?></span>
        </div>
    `;

    // 1. Insertar la leyenda ANTES de los resultados
    contenedor.before($('.products-legend-bar').remove()); // Evita duplicados si ya existía
    contenedor.parent().prepend(HTMLLeyenda);

    productos.forEach(producto => {
        // Formatear precios
        let precioOriginal = parseFloat(producto.SalePrice).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
        let precioNeto = parseFloat(producto.precio_neto).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
        
        let tieneDescuento = parseFloat(producto.Discount) > 0;
        let HTMLPrecio = tieneDescuento 
            ? `<span class="price-sale">${precioNeto}</span> <span class="price-original" style="text-decoration: line-through; color: #777; font-size: 0.9em; margin-left: 5px;">${precioOriginal}</span>`
            : `<span class="price-sale">${precioNeto}</span>`;

        let texto = producto.Name.replaceAll(" ", "-");            
        let url_product = `<?= URL_BASE ?>/product/${texto}?Idp=${producto.Id}`;

        // ============================================================
        // CONSTRUCCIÓN DE ICONOS-COLOR (DEBAJO DE LA IMAGEN)
        // ============================================================
        let HTMLIconosColor = '';

        if (producto.NewDesign == 1 || producto.NewDesign === true) {
            HTMLIconosColor += `<span class="dot-icon dot-new" title="<?= Trd(20); ?>"></span>`;
        }
        if (producto.Featured == 1) {
            HTMLIconosColor += `<span class="dot-icon dot-featured" title="<?= Trd(21); ?>"></span>`;
        }
        if (producto.OnlyRequest == 1) {
            HTMLIconosColor += `<span class="dot-icon dot-request" title="<?= Trd(24); ?>"></span>`;
        } else {
            HTMLIconosColor += `<span class="dot-icon dot-stock" title="<?= Trd(25); ?> (${producto.Quantity})"></span>`;
        }
        //<span class="tag tag-stock">Stock: ${producto.Quantity}</span>
        let card = `
            <article class="product-card">
              <a href="${url_product}" class="product-media">
                <img src="${url_images}/products_images/thumbnails/${producto.Image}" alt="${producto.Name}">
                
              </a>
              
              <div class="product-body">
                <div class="product-color-icons-row">
                    ${HTMLIconosColor}
                </div>

                <a href="${url_product}" class="product-name">${producto.Name}</a>
                
                <div class="price-row">
                    ${HTMLPrecio}
                </div>
                
                <a href="${url_product}" class="btn-outline-sm"><?= Trd(26); ?></a>
              </div>
            </article>
        `;
        contenedor.append(card);
    });

    // 2. Insertar la leyenda AL FINAL de los resultados de forma dinámica
    $('.products-legend-bar-end').remove(); // Limpieza previa
    contenedor.after(`<br>${HTMLLeyenda}`);
}



// Función para procesar y pintar la paginación dinámica
function armarpaginado(response) {
    const paginadoContenedor = $('#paginado');
    paginadoContenedor.empty(); // Limpiamos la navegación previa

    let totalPaginas = response.total_paginas;
    let pagina = response.pagina_actual;

    if (totalPaginas <= 1) return; // Si solo hay una página, no pintamos nada

    // Botón Anterior (←)
    if (pagina > 1) {
        paginadoContenedor.append(`<a href="#" class="pagination-item" onclick="event.preventDefault(); cargarProductos(${pagina - 1});">←</a>`);
    }

    // Listado de páginas numéricas
    for (let i = 1; i <= totalPaginas; i++) {
        let claseActiva = (i === pagina) ? 'active' : '';
        paginadoContenedor.append(`
            <a href="#" class="pagination-item ${claseActiva}" onclick="event.preventDefault(); cargarProductos(${i});">${i}</a>
        `);
    }

    // Botón Siguiente (→)
    if (pagina < totalPaginas) {
        paginadoContenedor.append(`<a href="#" class="pagination-item" onclick="event.preventDefault(); cargarProductos(${pagina + 1});">→</a>`);
    }
}


document.addEventListener("DOMContentLoaded", function() {
    // 1. Evitar que el clic en los submenús cierre el contenedor de filtros por accidente
    const sidebarLinks = document.querySelector('.filter-links');
    if (sidebarLinks) {
        sidebarLinks.addEventListener('click', function(e) {
            // Evita que el evento "haga eco" hacia los contenedores padres del sidebar
            e.stopPropagation();
        });
    }

    // 2. Controlar el acordeón de categorías en el Sidebar para móviles
    const sidebarParentCategories = document.querySelectorAll('.filter-links li.has-sidebar-submenu > a');

    sidebarParentCategories.forEach(categoryLink => {
        categoryLink.addEventListener('click', function(e) {
            // Detectamos si es una pantalla móvil/tablet (ajusta los píxeles según tu diseño)
            if (window.innerWidth <= 991) {
                const parentLi = this.parentElement;
                
                // Si la categoría con subcategorías NO está expandida (.open)
                if (!parentLi.classList.contains('open')) {
                    e.preventDefault();  // Detiene la recarga/navegación a la página de la categoría padre
                    e.stopPropagation(); // Detiene el flujo del clic inmediatamente
                    
                    // Opcional: Cierra otros acordeones de categorías abiertos para ahorrar espacio en la pantalla móvil
                    document.querySelectorAll('.filter-links li.has-sidebar-submenu.open').forEach(li => {
                        if (li !== parentLi) li.classList.remove('open');
                    });
                    
                    // Añade la clase que el CSS interpreta para estirar el menú hacia abajo
                    parentLi.classList.add('open');
                }
                // Si el usuario vuelve a presionar la categoría cuando ya está abierta (.open), 
                // el enlace funcionará de manera normal y lo llevará a la página principal de esa categoría.
            }
        });
    });
});


</script>
</body>
</html>