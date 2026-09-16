<?php
    ob_start();
    session_start();

    require 'vendor/autoload.php';
    require_once 'config.php';
    if (isset($_SESSION['logged_in'])){
        header("Location: ".URL_BASE);
    }    
    require_once 'functions.php';
    require_once 'head.php'; 

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "register"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    $TrdRsp = $Traducciones;

?>
<title><?= Trd(1); ?> <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2); ?><?= COMPANY_NAME ?><?= Trd(3); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:focus-visible{ outline:2px solid var(--color-brand); outline-offset:2px; }

/* Ajuste de contraste para los botones de SweetAlert */
.swal2-styled.swal2-confirm {
  background-color: var(--color-brand) !important;
  box-shadow: none !important;
}

/* ============================================================
   2. ESTRUCTURA DE LA PÁGINA DE REGISTRO
   ============================================================ */
.auth-container {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 16px;
}

.auth-card {
  width: 100%;
  max-width: 520px; 
  background: var(--color-bg);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-md);
  box-shadow: 0 10px 30px -10px rgba(22, 24, 29, 0.08);
  padding: 40px;
}

.auth-header {
  margin-bottom: 28px;
  text-align: center;
}
.auth-logo {
  font-weight: 800;
  font-size: 1.4rem;
  letter-spacing: -0.01em;
  color: var(--color-ink);
  display: inline-block;
  margin-bottom: 16px;
}
.auth-subtitle {
  font-size: 0.9rem;
  color: var(--color-ink-soft);
}

/* Formulario Jerárquico */
.register-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
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

.form-group input, .form-group select {
  font-family: var(--font);
  font-size: 0.9rem;
  padding: 10px 14px;
  border: 1px solid var(--color-line-strong);
  border-radius: var(--radius-sm);
  outline: none;
  background: var(--color-bg);
  color: var(--color-ink);
  height: 42px;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.form-group input:focus, .form-group select:focus {
  border-color: var(--color-brand);
  box-shadow: 0 0 0 1px var(--color-brand);
}

.form-group input::placeholder {
  color: var(--color-ink-faint);
}

/* Checkbox de Términos */
.checkbox-group {
  flex-direction: row;
  align-items: flex-start;
  gap: 10px;
  margin-top: 4px;
}
.checkbox-group input[type="checkbox"] {
  width: 16px;
  height: 16px;
  margin: 2px 0 0 0;
  cursor: pointer;
  accent-color: var(--color-brand);
}
.checkbox-group label {
  font-size: 0.82rem;
  font-weight: 400;
  line-height: 1.4;
}
.link-inline {
  color: var(--color-brand);
  font-weight: 500;
  text-decoration: underline;
}

/* Botón de Enviar */
.btn-submit {
  background: var(--color-brand);
  color: #FFFFFF;
  padding: 12px;
  font-size: 0.9rem;
  font-weight: 700;
  border-radius: var(--radius-sm);
  text-align: center;
  margin-top: 10px;
  border: none;
  cursor: pointer;
  transition: background 0.15s ease;
}
.btn-submit:hover {
  background: var(--color-brand-dark);
}
.btn-submit:disabled {
  background: var(--color-line-strong);
  cursor: not-allowed;
}

/* Enlace para volver a Login */
.auth-footer {
  margin-top: 24px;
  text-align: center;
  font-size: 0.86rem;
  color: var(--color-ink-soft);
  border-top: 1px solid var(--color-line);
  padding-top: 20px;
}
.link-primary {
  color: var(--color-brand);
  font-weight: 600;
}
.link-primary:hover {
  text-decoration: underline;
}

/* ============================================================
   3. RESPONSIVO
   ============================================================ */
@media (max-width: 580px) {
  .auth-card {
    padding: 24px 16px;
    border: none;
    box-shadow: none;
    background: transparent;
  }
  body {
    background: var(--color-bg);
  }
  .form-row {
    grid-template-columns: 1fr;
    gap: 18px;
  }
}
</style>

</head>

<body>
<?php 
  require_once ('nav.php');
  $Traducciones = $TrdRsp;
?>



<div class="auth-container">
  <article class="auth-card">
    
    <header class="auth-header">
      <a href="#" class="auth-logo"><?= COMPANY_NAME ?></a>
      <h1><?= Trd(4); ?></h1>
      <p class="auth-subtitle"><?= Trd(5); ?></p>
    </header>

    <form action="#" method="POST" class="register-form" id="registerForm" onsubmit="simulateRegisterAPI(event)">
      
      <div class="form-row">
        <div class="form-group">
          <label for="regName"><?= Trd(6); ?></label>
          <input type="text" id="regName" name="firstname" required placeholder="<?= Trd(7); ?>">
        </div>
        <div class="form-group">
          <label for="regLastName"><?= Trd(8); ?></label>
          <input type="text" id="regLastName" name="lastname" required placeholder="<?= Trd(9); ?>">
        </div>
      </div>

      <div class="form-group">
        <label for="regEmail"><?= Trd(10); ?></label>
        <input type="email" id="regEmail" name="email" required placeholder="juan@ejemplo.com">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="regPhone"><?= Trd(11); ?></label>
          <input type="tel" id="regPhone" name="phone" required placeholder="33 1234 5678" maxlength="10">
        </div>

      </div>

<div class="form-row">
  <div class="form-group">
    <label for="regPassword"><?= Trd(12); ?></label>
    <input type="password" id="regPassword" name="password" required placeholder="<?= Trd(13); ?>" minlength="8">
  </div>
  <div class="form-group">
    <label for="regPasswordConfirm"><?= Trd(14); ?></label>
    <input type="password" id="regPasswordConfirm" name="password_confirm" required placeholder="<?= Trd(15); ?>" minlength="8">
  </div>
</div>

      <div class="form-group checkbox-group">
        <input type="checkbox" id="regTerms" name="terms" required>
        <label for="regTerms"><?= Trd(16); ?> <a href="conditions" class="link-inline"><?= Trd(17); ?></a> <?= Trd(18); ?> <a href="privacy" class="link-inline"><?= Trd(19); ?></a> <?= Trd(20); ?> <?= COMPANY_NAME ?>.</label>
      </div>

      <button type="submit" class="btn-submit" id="btnRegisterSubmit"><?= Trd(21); ?></button>

    </form>

    <footer class="auth-footer">
      <?= Trd(22); ?>
      <a href="#"  class="link-primary" onclick="openLoginModal()"><?= Trd(23); ?></a>
    </footer>

  </article>
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

function simulateRegisterAPI(event) {
  event.preventDefault();

  const form = document.getElementById('registerForm');
  const btnSubmit = document.getElementById('btnRegisterSubmit');
  const phoneInput = document.getElementById('regPhone').value;
  const password = document.getElementById('regPassword').value;
  const passwordConfirm = document.getElementById('regPasswordConfirm').value;
  
  // 1. Validación estricta del número telefónico
  if(!/^\d{10}$/.test(phoneInput.replace(/\s/g, ''))) {
    Swal.fire({
      title: '<?= Trd(24); ?>',
      text: '<?= Trd(25); ?>',
      icon: 'warning',
      confirmButtonText: '<?= Trd(26); ?>',
      customClass: { confirmButton: 'swal2-confirm' }
    });
    return;
  }

  // 2. Validación de coincidencia de contraseñas
  if (password !== passwordConfirm) {
    Swal.fire({
      title: '<?= Trd(27); ?>',
      text: '<?= Trd(28); ?>',
      icon: 'warning',
      confirmButtonText: '<?= Trd(29); ?>',
      customClass: { confirmButton: 'swal2-confirm' }
    });
    return;
  }

  // Deshabilitar botón para evitar multi-envíos (Loading UI)
  btnSubmit.disabled = true;
  btnSubmit.textContent = '<?= Trd(30); ?>';

  // 3. Recolectar de forma automática todos los campos del formulario
  const formData = $(form).serialize(); 

  // 4. Llamado AJAX Real con jQuery
  $.ajax({
    url: 'ajax_register.php',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        Swal.fire({
          title: '<?= Trd(31); ?>',
          text: response.message || '<?= Trd(32); ?>',
          icon: 'success',
          confirmButtonText: '<?= Trd(33); ?>',
          customClass: { confirmButton: 'swal2-confirm' }
        }).then((result) => {
          if (result.isConfirmed) {
            form.reset(); 
            window.location.href = url_base+"/products/all"; 
          }
        });
      } else {
        Swal.fire({
          title: '<?= Trd(34); ?>',
          text: response.message || '<?= Trd(35); ?>',
          icon: 'error',
          confirmButtonText: '<?= Trd(36); ?>',
          customClass: { confirmButton: 'swal2-confirm' }
        });
        
        btnSubmit.disabled = false;
        btnSubmit.textContent = '<?= Trd(21); ?>';
      }
    },
    error: function(xhr, status, error) {
      Swal.fire({
        title: '<?= Trd(37); ?>',
        text: '<?= Trd(38); ?>',
        icon: 'error',
        confirmButtonText: '<?= Trd(39); ?>',
        customClass: { confirmButton: 'swal2-confirm' }
      });

      btnSubmit.disabled = false;
      btnSubmit.textContent = '<?= Trd(21); ?>';
    }
  });
}

</script>

</body>
</html>