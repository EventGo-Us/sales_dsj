<style>
.menu-toggle {
  display: none;
}

.distributor-label {
  flex: 0 1 190px;
  color: var(--color-ink-soft);
  font-size: .76rem;
  font-weight: 600;
  line-height: 1.35;
  text-align: center;
}

@media (max-width: 760px) {
  .menu-toggle {
    display: inline-flex;
  }

  .header-top-row {
    flex-wrap: wrap;
  }

  .distributor-label {
    order: 4;
    flex: 0 0 100%;
    padding: 0 8px 2px;
    font-size: .72rem;
  }
}

/* ==========================================================================
   1. DROPDOWN GENERAL (Para Productos, Puntos de Entrega, Recursos)
   ========================================================================== */
.has-dropdown { 
  position: relative; 
}

/* El cuadro flotante blanco que aparece abajo de los botones principales */
.dropdown {
  position: absolute; 
  top: calc(100% + 4px); 
  left: 0; 
  min-width: 230px;
  background: #fff; 
  border: 1px solid var(--color-line); 
  border-radius: var(--radius-sm);
  box-shadow: 0 8px 20px -10px rgba(0,0,0,.15);
  padding: 8px; 
  opacity: 0; 
  visibility: hidden; 
  transform: translateY(4px);
  transition: opacity .15s ease, transform .15s ease, visibility .15s ease;
  z-index: 100;
}

/* Mostrar cualquier dropdown general al abrirse */
.has-dropdown.open .dropdown { 
  opacity: 1; 
  visibility: visible; 
  transform: translateY(0); 
}

/* Enlaces base dentro de cualquier dropdown */
.dropdown a { 
  display: block; 
  padding: 9px 12px; 
  font-size: .85rem; 
  border-radius: 4px; 
  color: inherit;
  text-decoration: none;
}

.dropdown a:hover { 
  background: var(--color-bg-soft); 
  color: var(--color-brand); 
}

/* Animaciones de iconos de flecha */
.nav-link .icon { transition: transform 0.2s ease; }
.has-dropdown.open .nav-link .icon { transform: rotate(180deg); }
/* ==========================================================================
   2. AJUSTE EXCLUSIVO PARA LAS SUBCATEGORÍAS (Hacia Abajo)
   ========================================================================== */

.dropdown ul, 
.dropdown ul.submenu {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
  display: block !important;
  float: none !important;
  width: 100% !important;
}

.dropdown li {
  display: block !important;
  float: none !important;
  position: relative !important;
  width: 100% !important;
}

/* El Submenú colapsado por defecto */
.dropdown .submenu {
  max-height: 0 !important;
  overflow: hidden !important;
  opacity: 0 !important;
  visibility: hidden !important;
  padding-left: 20px !important;
  background: transparent !important;
  box-shadow: none !important;
  border: none !important;
  position: static !important;
  transition: max-height 0.25s ease-out, opacity 0.2s ease !important;
}

/* OPCIÓN PC: Abre con Hover */
@media (min-width: 992px) {
  .dropdown li.has-submenu:hover > .submenu {
    max-height: 500px !important;
    opacity: 1 !important;
    visibility: visible !important;
    padding-top: 4px !important;
    padding-bottom: 4px !important;
  }
}

/* OPCIÓN MÓVIL: Abre cuando tiene la clase .open (controlada por JS) */
.dropdown li.has-submenu.open > .submenu {
  max-height: 500px !important;
  opacity: 1 !important;
  visibility: visible !important;
  padding-top: 4px !important;
  padding-bottom: 4px !important;
}

/* Estilos de los enlaces */
.dropdown .submenu a {
  display: block !important;
  font-size: 0.8rem !important;
  opacity: 0.85 !important;
  padding: 6px 12px !important;
}

</style>
<?php

function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "nav"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);

    $api_url = URL_API."account";
    $data = "";
    $account = json_decode(API($jwt,$api_url,$data,'GET'), true);   
?>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <symbol id="icon-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="icon-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
    <symbol id="icon-cart" viewBox="0 0 24 24"><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/><circle cx="9" cy="20" r="1"/><circle cx="20" cy="20" r="1"/></symbol>
    <symbol id="icon-menu" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></symbol>
    <symbol id="icon-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></symbol>
    <symbol id="icon-arrow" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
    <symbol id="icon-shield" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></symbol>
    <symbol id="icon-truck" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></symbol>
    <symbol id="icon-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
    <symbol id="icon-tag" viewBox="0 0 24 24"><path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.82 0l4.6-4.6a2 2 0 0 0 0-2.82z"/><line x1="7" y1="7.5" x2="7.01" y2="7.5"/></symbol>
    <symbol id="icon-facebook" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></symbol>
    <symbol id="icon-instagram" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></symbol>
    <symbol id="icon-tiktok" viewBox="0 0 24 24"><path d="M9 2v12.6a3.4 3.4 0 1 1-2-3.1V2h2zM13 2c.5 2.5 2.5 4.4 5 4.8v3c-1.8 0-3.5-.5-5-1.6V13"/></symbol>
    <symbol id="icon-youtube" viewBox="0 0 24 24"><path d="M22.5 6.4a2.8 2.8 0 0 0-2-2C18.9 4 12 4 12 4s-6.9 0-8.6.4a2.8 2.8 0 0 0-2 2A29 29 0 0 0 1 11.8a29 29 0 0 0 .5 5.3 2.8 2.8 0 0 0 2 2c1.7.4 8.5.4 8.5.4s6.9 0 8.6-.4a2.8 2.8 0 0 0 2-2 29 29 0 0 0 .4-5.3 29 29 0 0 0-.5-5.4z"/><polygon points="9.8 15 15.5 11.8 9.8 8.5 9.8 15"/></symbol>
  </defs>
</svg>

<div class="topbar">
  <div class="wrap">
    <a href="tel:+<?php  echo $account['account'][0]['TelefonoOficina']; ?>"><?php  echo formatPhoneNumber($account['account'][0]['TelefonoOficina']); ?></a>
    <div class="topbar-right">
      <span><?= Trd(1); ?></span>
      <span><?= Trd(2); ?></span>
    </div>
  </div>
</div>

<header class="site-header">
  <div class="wrap header-inner">
    
    <div class="header-top-row">
      <button class="menu-toggle icon-btn" id="menuToggle" aria-label="Abrir menú" aria-expanded="false">
        <svg class="icon"><use href="#icon-menu"/></svg>
      </button>

      <a href="<?= URL_BASE ?>/" class="logo"><?= COMPANY_NAME ?></a>

      <div class="search-bar-container" id="searchBarContainer">
        <form action="<?= URL_BASE ?>/products/search" method="GET" class="search-form">
          <div class="search-select-wrapper">
            <?php
            $cat = '';
            if ( isset($_GET['category']))
              $cat = $_GET['category'];
            ?>
            <select name="category" id="category" aria-label="Categoría de búsqueda">
              
              <?php

                  if ($cat == 'all')
                    echo '<option value="all" selected>' . Trd(3) . '</option>';
                  else
                    echo '<option value="all">' . Trd(3) . '</option>';

                  $api_url = URL_API."categories_sale";
                  $data='';
                  $datacat = json_decode(API($jwt,$api_url,$data,'POST'), true);
                  if ($datacat['status'] === 'success') {
                      foreach ($datacat['data'] as $category) {
                          $category['Imagen'] = URL_IMAGES.'/categories/originals/'.$category['Imagen'];
                          $URL = str_replace(" ","-",$category['Nombre']);
                          $sel = '';
                          if ($cat == $URL)
                            $sel = 'selected';
                          echo '<option value="'.$URL.'" '.$sel.'>'.$category['Nombre'].'</option>';
                      }        
                  } 

                  $api_url = URL_API."scategories_sale";
                  $data='';
                  $datascat = json_decode(API($jwt,$api_url,$data,'POST'), true);                  
                  
              ?>
            </select>
            <svg class="icon select-chevron"><use href="#icon-chevron"/></svg>
          </div>
          <div class="search-input-wrapper">
            <?php
            if ( isset($_GET['q']))
              echo '<input type="text" name="q" id="q" placeholder="' . Trd(29) . '" value="'.$_GET['q'].'" required autocomplete="off">';
            else
              echo '<input type="text" name="q" id="q" placeholder="' . Trd(29) . '" required autocomplete="off">'
            ?>
            
            <button type="submit" class="search-submit-btn" aria-label="Ejecutar búsqueda">
              <svg class="icon"><use href="#icon-search"/></svg>
            </button>
          </div>
        </form>
      </div>

      <div class="distributor-label">Authorized Bouncing Angels Distributors</div>

<div class="header-actions">
  <button class="icon-btn mobile-search-toggle" id="mobileSearchToggle" aria-label="Buscar"><svg class="icon"><use href="#icon-search"/></svg></button>
  
  <div class="account-dropdown-wrapper" id="accountWrapper">
    <button class="icon-btn" aria-label="Mi cuenta" id="accountBtn" title="Mi cuenta">
      <svg class="icon"><use href="#icon-user"/></svg>
    </button>
    
<div class="account-popover" id="accountPopover">

  <?php if (isset($_SESSION['logged_in'])): ?>
    <div class="user-logged-menu">
      <div class="user-welcome">
        <span class="user-avatar-mini">
          <?= strtoupper(substr($_SESSION['customer_name'] ?? 'U', 0, 1)); ?>
        </span>
        <div class="user-meta-nav">
          <span class="nav-username"><?= htmlspecialchars($_SESSION['customer_name'] ?? Trd(30)); ?></span>
          <span class="nav-user-role"><?= Trd(4); ?></span>
        </div>
      </div>
      
      <hr class="nav-divider">
      
      <div class="nav-account-links">
        <a href="<?= URL_BASE ?>/profile.php?tab=profile" class="nav-account-item">
          <svg class="icon-nav" viewBox="0 0 24 24"><polyline points="20 21 20 19 16 19 16 21"></polyline><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          <?= Trd(5); ?>
        </a>
        
        <a href="<?= URL_BASE ?>/profile.php?tab=process" class="nav-account-item">
          <svg class="icon-nav" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
          <?= Trd(6); ?>
        </a>  

        <a href="<?= URL_BASE ?>/profile.php?tab=addresses" class="nav-account-item">
          <svg class="icon-nav" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          <?= Trd(7); ?>
        </a>

        
        
        <hr class="nav-divider">
        
        <a href="<?= URL_BASE ?>/logout" class="nav-account-item logout-link">
          <svg class="icon-nav" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          <?= Trd(8); ?>
        </a>
      </div>

    </div>

  <?php else: ?>
<form action="#" method="POST" class="login-form" id="loginForm" onsubmit="processLoginAPI(event,'')">
  <h4><?= Trd(9); ?></h4>
  
  <div class="form-field">
    <label for="loginUser"><?= Trd(10); ?></label>
    <input type="text" id="loginUser" name="loginUser" required placeholder="ejemplo@correo.com">
  </div>
  
  <div class="form-field">
    <label for="loginPass"><?= Trd(11); ?></label>
    <input type="password" id="loginPass" name="loginPass" required placeholder="••••••••">
  </div>
  
  <button type="submit" class="btn-login" id="btnLoginSubmit"><?= Trd(12); ?></button>
  
  <div class="login-links">
    <a href="<?= URL_BASE ?>/recovery" class="link-secondary"><?= Trd(13); ?></a>
    <div class="register-text">
      <?= Trd(14); ?> <a href="<?= URL_BASE ?>/register" class="link-primary"><?= Trd(15); ?></a>
    </div>
  </div>
</form>
  <?php endif; ?>
  
</div>
  </div>

  <div class="cart-dropdown-wrapper" id="cartWrapper">
    <button class="icon-btn" id="openCartBtn" aria-label="Carrito">
      <svg class="icon"><use href="#icon-cart"/></svg>
      <span class="cart-count">0</span>
    </button>

    <div class="cart-popover" id="cartDrawer" aria-hidden="true">


      <div class="cart-popover-header">
        <h2><?= Trd(16); ?></h2>
      </div>

      <div class="cart-popover-body" id="cartDrawerBody">

      </div>

      <div class="cart-popover-footer">
        <div class="cart-subtotal-row">
          <span><?= Trd(17); ?></span>
          <span id="cartSubtotal">$0.00</span>
        </div>
        <div class="cart-footer-actions">
          <a href="<?= URL_BASE ?>/cart">
            <button class="btn-checkout"><?= Trd(18); ?></button>
          </a>
        </div>
      </div>

    </div>

  </div>

  <div class="lang-dropdown-wrapper" id="langWrapper">
    <button class="lang-btn" id="langBtn" aria-label="Cambiar idioma" aria-haspopup="true">
      <span><?php echo strtoupper($_SESSION['Idioma'])?></span>
      <svg class="icon lang-chevron"><use href="#icon-chevron"/></svg>
    </button>
    <div class="lang-popover" id="langPopover">
      <a href="#" class="lang-option" data-lang="es">Español (ES)</a>
      <a href="#" class="lang-option" data-lang="en">English (EN)</a>
    </div>
  </div>

</div>


    </div>

    <div class="header-bottom-row">
      <nav class="main-nav" id="mainNav">
        <ul>
          <li><a href="<?= URL_BASE ?>"><?= Trd(19); ?></a></li>
          <li class="has-dropdown">
            <button class="nav-link" data-dropdown><?= Trd(20); ?> <svg class="icon"><use href="#icon-chevron"/></svg></button>
<div class="dropdown">
    <ul>
        <li><a href="<?php echo URL_BASE; ?>/products/all"><?= Trd(21); ?></a></li>
        
        <?php
        if ($datacat['status'] === 'success') {
            foreach ($datacat['data'] as $category) {
                $category['Imagen'] = URL_IMAGES.'/categories/originals/'.$category['Imagen'];
                $URL = str_replace(" ", "-", $category['Nombre']);
                
                // Buscar subcategorías
                $has_subcategories = false;
                $subcategories_html = '';
                
                if (isset($datascat['data']) && is_array($datascat['data'])) {
                    foreach ($datascat['data'] as $scategory) {
                        if ($category['Id'] == $scategory['Id']) {
                            if (!$has_subcategories) {
                                $has_subcategories = true;
                                $subcategories_html .= '<ul class="submenu">';
                            }
                            $SURL = str_replace(" ", "-", $scategory['Nombre_sc']);
                            $subcategories_html .= '<li><a href="'.URL_BASE.'/products/'.$URL.'/'.$SURL.'">- '.$scategory['Nombre_sc'].'</a></li>';
                        }
                    }
                    if ($has_subcategories) {
                        $subcategories_html .= '</ul>';
                    }
                }
                
                // Asignar clase si tiene hijos
                $clase_padre = $has_subcategories ? 'class="has-submenu"' : '';
                
                echo '<li '.$clase_padre.'>';
                echo '<a href="'.URL_BASE.'/products/'.$URL.'">'.$category['Nombre'].'</a>';
                if ($has_subcategories) {
                    echo $subcategories_html; // Aquí se inyecta el .submenu
                }
                echo '</li>';
            }
        }
        ?>
    </ul>
</div>
          </li>
          <li><a href="<?= URL_BASE ?>/products/stock"><?= Trd(22); ?></a></li>

          <li class="has-dropdown">
            <button class="nav-link" data-dropdown><?= Trd(24); ?> <svg class="icon"><use href="#icon-chevron"/></svg></button>
            <div class="dropdown">
              <a href="#">Blog</a>
              <a href="#"><?= Trd(25); ?></a>
              <a href="<?php echo URL_BASE?>/aboutus"><?= Trd(26); ?></a>
              <a href="<?php echo URL_BASE?>/comments"><?= Trd(27); ?></a>
            </div>
          </li>
          <li><a href="<?php echo URL_BASE?>/contact"><?= Trd(28); ?></a></li>
        </ul>
      </nav>
    </div>

  </div>
</header>
<div class="nav-backdrop" id="navBackdrop"></div>