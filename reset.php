<?php
    ob_start();
    session_start();

    require 'vendor/autoload.php';
    require_once 'config.php';
    if (isset($_SESSION['logged_in'])){
        header("Location: ".URL_BASE);
        exit;
    }    
    require_once 'functions.php';
    require_once 'head.php'; 

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "reset"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);    
    $TrdRsp = $Traducciones;


    // Capturar y validar parámetros recibidos por la URL para verificar identidad
    $email = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_SANITIZE_EMAIL) : '';
    $token = isset($_GET['token']) ? htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8') : '';

    // Si faltan parámetros clave, podrías redirigir o mostrar un error preventivo

    $invalid_route = true; // Por defecto asumimos que es inválida

    // Si los parámetros tienen el formato correcto, validamos contra la BD
    if ($email && $token) {
        try {
            $api_url = URL_API."validate_token";
            $data = json_encode(["email" => $email,"token" => $token]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);          
            
            if ($data['status']=='success')
                $invalid_route = false; 

        } catch (Exception $e) {
            $invalid_route = true;
        }
    }    

?>
<title><?= Trd(1); ?> — <?= COMPANY_NAME ?></title>
<meta name="description" content="<?= Trd(2); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:focus-visible{ outline:2px solid var(--color-brand); outline-offset:2px; }

.swal2-styled.swal2-confirm {
  background-color: var(--color-brand) !important;
  box-shadow: none !important;
}

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

.reset-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
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

.form-group input {
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

.form-group input:focus {
  border-color: var(--color-brand);
  box-shadow: 0 0 0 1px var(--color-brand);
}

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
}
</style>

<script>
  // Traducciones requeridas para el bloque Javascript
  const jsTrd = {
    titleNoMatch: `<?= Trd(13); ?>`,
    textNoMatch: `<?= Trd(14); ?>`,
    btnNoMatch: `<?= Trd(15); ?>`,
    btnSaving: `<?= Trd(16); ?>`,
    titleSuccess: `<?= Trd(17); ?>`,
    textSuccess: `<?= Trd(18); ?>`,
    btnSuccess: `<?= Trd(19); ?>`,
    titleErrUpdate: `<?= Trd(20); ?>`,
    textErrUpdate: `<?= Trd(21); ?>`,
    btnRetry: `<?= Trd(22); ?>`,
    titleErrConn: `<?= Trd(23); ?>`,
    textErrConn: `<?= Trd(24); ?>`,
    btnUnderstood: `<?= Trd(25); ?>`,
    btnResetDefault: `<?= Trd(10); ?>`
  };
</script>

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
      <h1><?= Trd(3); ?></h1>
      <p class="auth-subtitle"><?= Trd(4); ?></p>
    </header>

    <?php if ($invalid_route): ?>
      <div style="text-align:center; padding: 20px; color: #c0392b; font-weight: 600;">
        <?= Trd(5); ?>
      </div>
    <?php else: ?>

      <form action="#" method="POST" class="reset-form" id="resetPasswordForm" onsubmit="executeResetPasswordAPI(event)">
        
        <input type="hidden" name="email" value="<?= $email ?>">
        <input type="hidden" name="token" value="<?= $token ?>">

        <div class="form-group">
          <label for="regPassword"><?= Trd(6); ?></label>
          <input type="password" id="regPassword" name="password" required placeholder="<?= Trd(7); ?>" minlength="8">
        </div>

        <div class="form-group">
          <label for="regPasswordConfirm"><?= Trd(8); ?></label>
          <input type="password" id="regPasswordConfirm" name="password_confirm" required placeholder="<?= Trd(9); ?>" minlength="8">
        </div>

        <button type="submit" class="btn-submit" id="btnResetSubmit"><?= Trd(10); ?></button>

      </form>

    <?php endif; ?>

    <footer class="auth-footer">
      <?= Trd(11); ?>
      <a href="#" class="link-primary" onclick="openLoginModal()"><?= Trd(12); ?></a>
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

function executeResetPasswordAPI(event) {
  event.preventDefault();

  const form = document.getElementById('resetPasswordForm');
  const btnSubmit = document.getElementById('btnResetSubmit');
  const password = document.getElementById('regPassword').value;
  const passwordConfirm = document.getElementById('regPasswordConfirm').value;
  
  // Validación de coincidencia de contraseñas
  if (password !== passwordConfirm) {
    Swal.fire({
      title: jsTrd.titleNoMatch,
      text: jsTrd.textNoMatch,
      icon: 'warning',
      confirmButtonText: jsTrd.btnNoMatch,
      customClass: { confirmButton: 'swal2-confirm' }
    });
    return;
  }

  // UI Loading State
  btnSubmit.disabled = true;
  btnSubmit.textContent = jsTrd.btnSaving;

  const formData = $(form).serialize(); 

  // Petición AJAX al archivo encargado de actualizar la base de datos
  $.ajax({
    url: 'ajax_reset_password.php',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        Swal.fire({
          title: jsTrd.titleSuccess,
          text: response.message || jsTrd.textSuccess,
          icon: 'success',
          confirmButtonText: jsTrd.btnSuccess,
          customClass: { confirmButton: 'swal2-confirm' }
        }).then((result) => {
          if (result.isConfirmed) {
            form.reset(); 
            // Redirigir al inicio o disparar modal de login directo
            window.location.href = url_base; 
          }
        });
      } else {
        Swal.fire({
          title: jsTrd.titleErrUpdate,
          text: response.message || jsTrd.textErrUpdate,
          icon: 'error',
          confirmButtonText: jsTrd.btnRetry,
          customClass: { confirmButton: 'swal2-confirm' }
        });
        
        btnSubmit.disabled = false;
        btnSubmit.textContent = jsTrd.btnResetDefault;
      }
    },
    error: function(xhr, status, error) {
      Swal.fire({
        title: jsTrd.titleErrConn,
        text: jsTrd.textErrConn,
        icon: 'error',
        confirmButtonText: jsTrd.btnUnderstood,
        customClass: { confirmButton: 'swal2-confirm' }
      });

      btnSubmit.disabled = false;
      btnSubmit.textContent = jsTrd.btnResetDefault;
    }
  });
}

</script>

</body>
</html>