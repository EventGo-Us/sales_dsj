<?php
    ob_start();
    session_start();
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 
?>
<title><?= Trd(1); ?> <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= sprintf(Trd(2), COMPANY_NAME); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<style>


/* ============================================================
   2. DISTRIBUCIÓN DE LA PÁGINA (GRID)
   ============================================================ */
.contact-header {
  padding: 60px 0 40px;
  text-align: center;
  border-bottom: 1px solid var(--color-line);
  margin-bottom: 48px;
}
.contact-header p {
  color: var(--color-ink-soft);
  font-size: 1.05rem;
  max-width: 600px;
  margin: 0 auto;
}

.contact-layout {
  display: grid;
  grid-template-columns: 1fr 400px;
  gap: 64px;
  margin-bottom: 80px;
  align-items: start;
}

/* Columna del Formulario */
.contact-form-wrapper {
  background: var(--color-bg);
}
.contact-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}
.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.form-group label {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--color-ink-soft);
}
.form-group input, .form-group select, .form-group textarea {
  font-family: var(--font);
  font-size: 0.9rem;
  padding: 10px 14px;
  border: 1px solid var(--color-line-strong);
  border-radius: var(--radius-sm);
  outline: none;
  background: var(--color-bg);
  color: var(--color-ink);
  transition: border-color 0.15s ease;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color: var(--color-brand);
}
.form-group textarea {
  resize: vertical;
  min-height: 140px;
}

.btn-submit {
  background: var(--color-brand);
  color: #FFFFFF;
  padding: 12px 32px;
  font-size: 0.9rem;
  font-weight: 700;
  border-radius: var(--radius-sm);
  align-self: flex-start;
  transition: background 0.15s ease;
}
.btn-submit:hover {
  background: var(--color-brand-dark);
}

/* Columna de Información Lateral */
.contact-info-sidebar {
  display: flex;
  flex-direction: column;
  gap: 32px;
}
.info-block {
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  padding: 24px;
}
.info-block h3 {
  font-size: 0.95rem;
  font-weight: 700;
  margin: 0 0 12px 0;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--color-ink-soft);
}
.info-block p {
  font-size: 0.92rem;
  line-height: 1.6;
  color: var(--color-ink);
}

/* Botón de Acción Directa a WhatsApp */
.btn-whatsapp-direct {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: var(--color-whatsapp);
  color: #FFFFFF;
  padding: 14px;
  border-radius: var(--radius-sm);
  font-weight: 700;
  font-size: 0.95rem;
  text-align: center;
  transition: opacity 0.15s ease;
}
.btn-whatsapp-direct:hover {
  opacity: 0.9;
}

/* ============================================================
   3. RESPONSIVO MÓVIL
   ============================================================ */
@media (max-width: 860px) {
  .contact-layout {
    grid-template-columns: 1fr; /* Una columna vertical en tablets y celulares */
    gap: 48px;
  }
  .contact-info-sidebar {
    order: -1; /* Mover info de contacto arriba en celular para UX rápida */
  }
}

@media (max-width: 540px) {
  .contact-header { padding: 40px 0 24px; margin-bottom: 32px; }
  .contact-header h1 { font-size: 1.8rem; }
  .form-row { grid-template-columns: 1fr; }
  .btn-submit { width: 100%; text-align: center; }
}
</style>
</head>

<body>
<?php 
  require_once ('nav.php');
?>

<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "contact"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>

<div class="wrap">
  
  <header class="contact-header">
    <h1><?= Trd(3); ?></h1>
    <p><?= Trd(4); ?></p>
  </header>

  <div class="contact-layout">
    
<!-- ... Resto de tu código inicial de contact.php ... -->
<main class="contact-form-wrapper">
  <h2><?= Trd(5); ?></h2>
  <!-- Actualizamos el id y el onsubmit -->
  <form id="contactForm" class="contact-form" onsubmit="submitContactForm(event)">
    
    <div class="form-row">
      <div class="form-group">
        <label for="conName"><?= Trd(6); ?></label>
        <input type="text" id="conName" name="name" required placeholder="Ej. Juan Pérez">
      </div>
      <div class="form-group">
        <label for="conPhone"><?= Trd(7); ?></label>
        <input type="tel" id="conPhone" name="phone" required placeholder="33 1234 5678" maxlength="10">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="conEmail"><?= Trd(8); ?></label>
        <input type="email" id="conEmail" name="email" required placeholder="juan@ejemplo.com">
      </div>
      <div class="form-group">
        <label for="conSubject"><?= Trd(9); ?></label>
        <select id="conSubject" name="subject" required>
          <option value="" disabled selected><?= Trd(10); ?></option>
          <option value="cotizacion"><?= Trd(11); ?></option>
          <option value="envio"><?= Trd(12); ?></option>
          <option value="garantia"><?= Trd(13); ?></option>
          <option value="otro"><?= Trd(14); ?></option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="conMessage"><?= Trd(15); ?></label>
      <textarea id="conMessage" name="message" required placeholder="<?= Trd(16); ?>"></textarea>
    </div>

    <!-- SECCIÓN NUEVA: CAPTCHA VISUAL -->
    <div class="form-group" style="margin-bottom: 10px;">
      <label for="conCaptcha"><?= Trd(17); ?></label>
      <div style="display: flex; gap: 12px; align-items: center;">
        <!-- Contenedor donde se insertará dinámicamente la imagen -->
        <div id="captchaContainer" style="cursor: pointer;" title="<?= Trd(18); ?>"></div>
        <!-- Campo oculto que guardará el Token Cifrado de verificación -->
        <input type="hidden" id="conCaptchaToken" name="captcha_token">
        <input type="text" id="conCaptcha" name="captcha" required placeholder="<?= Trd(19); ?>" maxlength="5" style="text-transform: uppercase; width: 150px;">
      </div>
    </div>

    <!-- Añadimos id al botón de enviar -->
    <button type="submit" id="btnContactSubmit" class="btn-submit"><?= Trd(20); ?></button>
  </form>
</main>


    <aside class="contact-info-sidebar">
      
      <a href="https://wa.me/523312345678?text=Hola,%20busco%20cotizar%20brincolines%20al%20mayoreo" class="btn-whatsapp-direct" target="_blank" rel="noopener">
        <span><?= Trd(21); ?></span>
      </a>

      <div class="info-block">
        <h3><?= Trd(22); ?></h3>
        <p>
          <strong><?= COMPANY_NAME ?></strong><br>
        <?php
        echo $account['account'][0]['Direccion']." ".$account['account'][0]['Direccion2']."<br>";
        echo $account['account'][0]['Ciudad'].' '.$account['account'][0]['CP']."<br>";
        echo $account['account'][0]['Estado']."<br><br>";
        ?>
        <span style="color: var(--color-ink-soft); font-size: 0.82rem;"><?= Trd(26); ?> <?= $account['account'][0]['ZonaHoraria'] ?></span>
        </p>
      </div>
<!-- Información de contacto adicional 
      <div class="info-block">
        <h3><?= Trd(23); ?></h3>
        <p>
          <?= Trd(24); ?><br>
          <?= Trd(25); ?><br>
          
        </p>
      </div>
-->
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

<script>
// Traducciones para los diálogos de SweetAlert y JS
const jsTrd = {
  sending: "<?= Trd(27); ?>",
  sentTitle: "<?= Trd(28); ?>",
  acceptBtn: "<?= Trd(29); ?>",
  valTitle: "<?= Trd(30); ?>",
  retryBtn: "<?= Trd(31); ?>",
  errorTitle: "<?= Trd(32); ?>",
  understoodBtn: "<?= Trd(33); ?>",
  netErrorTitle: "<?= Trd(34); ?>",
  netErrorMsg: "<?= Trd(35); ?>",
  closeBtn: "<?= Trd(36); ?>"
};

// Función para refrescar la imagen del captcha añadiendo un timestamp único contra el caché
function loadCaptcha() {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'captcha.php?t=' + new Date().getTime(), true);
  xhr.responseType = 'blob'; // Recibir la imagen como objeto binario
  
  xhr.onload = function() {
    if (this.status === 200) {
      // 1. Extraer el token cifrado desde los headers
      const token = xhr.getResponseHeader('X-Captcha-Token');
      document.getElementById('conCaptchaToken').value = token;
      
      // 2. Renderizar la imagen binaria en el contenedor
      const blob = this.response;
      const imgUrl = URL.createObjectURL(blob);
      document.getElementById('captchaContainer').innerHTML = `<img src="${imgUrl}" style="border-radius: var(--radius-sm); border: 1px solid var(--color-line); height: 42px;">`;
      document.getElementById('conCaptcha').value = '';
    }
  };
  xhr.send();
}

// Cargar al iniciar y al hacer clic en la imagen
document.addEventListener('DOMContentLoaded', loadCaptcha);
document.getElementById('captchaContainer').addEventListener('click', loadCaptcha);

function submitContactForm(event) {
  event.preventDefault();

  const btnSubmit = document.getElementById('btnContactSubmit');
  const originalText = btnSubmit.textContent;

  // Deshabilitar botón durante el proceso
  btnSubmit.disabled = true;
  btnSubmit.textContent = jsTrd.sending;

  const formArray = $('#contactForm').serializeArray();
  const formDataObject = {};

  formArray.forEach(function(item) {
    formDataObject[item.name] = item.value;
  });

  $.ajax({
    url:  url_api +'contact',
    type: 'POST',
    data: JSON.stringify(formDataObject),
    contentType: 'application/json',
    headers: {
        'Authorization': 'Bearer ' + token,
        'X-ID-CLIENT': '<?= ID_CLIENT ?>',
        'LNG': '<?= $_SESSION['Idioma'] ?>'
    },     
    success: function(data) {
      if (data.status === 'success') {
        // Alerta de éxito al enviar el formulario
        Swal.fire({
          title: jsTrd.sentTitle,
          text: data.message,
          icon: 'success',
          confirmButtonText: jsTrd.acceptBtn,
          customClass: { confirmButton: 'swal2-confirm' }
        });

        $('#contactForm')[0].reset();
        loadCaptcha();

      } else if (data.status === 'captcha_error') {
        // Alerta de advertencia si el captcha falla o expira
        Swal.fire({
          title: jsTrd.valTitle,
          text: data.message,
          icon: 'warning',
          confirmButtonText: jsTrd.retryBtn,
          customClass: { confirmButton: 'swal2-confirm' }
        });

        loadCaptcha();
        document.getElementById('conCaptcha').focus();

      } else {
        // Alerta de error controlado devuelto por tu API
        Swal.fire({
          title: jsTrd.errorTitle,
          text: data.message,
          icon: 'error',
          confirmButtonText: jsTrd.understoodBtn,
          customClass: { confirmButton: 'swal2-confirm' }
        });
      }
    },
    error: function(xhr, status, error) {
      console.error("Error en la conexión externa: ", error);
      // Alerta de error crítico/fallo de red
      Swal.fire({
        title: jsTrd.netErrorTitle,
        text: jsTrd.netErrorMsg,
        icon: 'error',
        confirmButtonText: jsTrd.closeBtn,
        customClass: { confirmButton: 'swal2-confirm' }
      });
    },
    complete: function() {
      // Devolver botón a su estado original
      btnSubmit.disabled = false;
      btnSubmit.textContent = originalText;
    }
  });
}
</script>


</body>
</html>