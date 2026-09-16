<?php
    ob_start();
    session_start();    
    require 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'functions.php';
    require_once 'head.php'; 

    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "recovery"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);        
    $TrdRsp = $Traducciones;
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/cart.css">

<style>
/* ============================================================
   0. TOKENS — Consistentes con <?= COMPANY_NAME ?>
   ============================================================ */


/* ============================================================
   1. RESET + BASE
   ============================================================ */
*,*::before,*::after{ box-sizing:border-box; }

a{ color:inherit; text-decoration:none; }
button{ font:inherit; cursor:pointer; background:none; border:none; }
h1{ font-size:1.4rem; font-weight:800; letter-spacing:-0.02em; margin:0 0 8px 0; line-height:1.2; text-align:center; }
p{ margin:0; }

:focus-visible{ outline:2px solid var(--color-brand); outline-offset:2px; }

/* ============================================================
   2. CARD DE AUTENTICACIÓN
   ============================================================ */
.auth-container {
  flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 16px;
}
.auth-card {
  width: 100%; max-width: 440px; background: var(--color-bg);
  border: 1px solid var(--color-line); border-radius: var(--radius-md);
  box-shadow: 0 10px 30px -10px rgba(22, 24, 29, 0.08); padding: 40px;
}
.auth-header { text-align: center; margin-bottom: 24px; }
.auth-logo { font-weight: 800; font-size: 1.4rem; color: var(--color-ink); display: inline-block; margin-bottom: 16px; }
.auth-subtitle { font-size: 0.88rem; color: var(--color-ink-soft); line-height: 1.4; }

/* Estructura del Formulario */
.recover-form { display: flex; flex-direction: column; gap: 18px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label { font-size: 0.8rem; font-weight: 600; color: var(--color-ink-soft); }
.form-group input {
  font-family: var(--font); font-size: 0.9rem; padding: 10px 14px;
  border: 1px solid var(--color-line-strong); border-radius: var(--radius-sm);
  outline: none; background: var(--color-bg); height: 42px;
}
.form-group input:focus { border-color: var(--color-brand); box-shadow: 0 0 0 1px var(--color-brand); }

.btn-submit {
  background: var(--color-brand); color: #FFFFFF; padding: 12px;
  font-size: 0.9rem; font-weight: 700; border-radius: var(--radius-sm);
  text-align: center; margin-top: 6px; transition: background 0.15s ease;
}
.btn-submit:hover { background: var(--color-brand-dark); }

/* Pantalla de Éxito Oculta Inicialmente */
.success-state { display: none; text-align: center; }
.success-state.active { display: block; }
.success-icon {
  width: 48px; height: 48px; background: #DCFCE7; color: var(--color-success);
  border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
  font-size: 1.5rem; margin-bottom: 16px; font-weight: bold;
}

/* Footer de Navegación */
.auth-footer {
  margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--color-line);
  text-align: center; font-size: 0.86rem; color: var(--color-ink-soft);
  display: flex; justify-content: center; gap: 16px;
}
.link-primary { color: var(--color-brand); font-weight: 600; }
.link-primary:hover { text-decoration: underline; }

/* Responsivo */
@media (max-width: 480px) {
  .auth-card { padding: 24px 16px; border: none; box-shadow: none; background: transparent; }
  body { background: var(--color-bg); }
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
    
    <div id="formContainer">
      <header class="auth-header">
        <a href="#" class="auth-logo"><?= COMPANY_NAME ?></a>
        <h1><?= Trd(1); ?></h1>
        <p class="auth-subtitle"><?= Trd(2); ?></p>
      </header>

      <form action="#" method="POST" class="recover-form" id="recoverForm">
        <div class="form-group">
          <label for="recoverEmail"><?= Trd(3); ?></label>
          <input type="email" id="recoverEmail" name="email" required placeholder="ejemplo@correo.com">
        </div>
        <button type="submit" class="btn-submit"><?= Trd(4); ?></button>
      </form>
    </div>

    <div class="success-state" id="successState">
      <div class="success-icon">✓</div>
      <h1><?= Trd(5); ?></h1>
      <p class="auth-subtitle" style="margin-bottom: 12px;"><?= Trd(6); ?><strong id="targetEmail">tu correo</strong>.</p>
      <p class="auth-subtitle" style="font-size: 0.8rem;"><?= Trd(7); ?></p>
    </div>

    <footer class="auth-footer">
      <a href="#" class="link-primary" onclick="openLoginModal()"><?= Trd(8); ?></a>
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
document.getElementById('recoverForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const form = this;
  const emailInput = document.getElementById('recoverEmail');
  const emailVal = emailInput.value;
  const submitBtn = form.querySelector('.btn-submit');
  
  // Guardamos el texto original del botón y lo cambiamos a "Enviando..."
  const originalBtnText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<?= Trd(9); ?>';
  submitBtn.disabled = true; // Deshabilitamos para evitar doble clic

  // Creamos los datos para enviar por POST
  const formData = new FormData();
  formData.append('email', emailVal);

  // Llamada a la API en PHP
  fetch('api_recover.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Error en la respuesta del servidor');
    }
    return response.json();
  })
  .then(data => {
    if (data.status === 'success') {
      // Alerta de éxito con SweetAlert2
      Swal.fire({
        icon: 'success',
        title: '<?= Trd(10); ?>',
        text: data.message,
        confirmButtonColor: 'var(--color-brand, #000)',
        timer: 3500,
        timerProgressBar: true
      }).then(() => {
        // Mostramos el contenedor de éxito nativo de tu plantilla
        document.getElementById('targetEmail').innerText = emailVal;
        document.getElementById('formContainer').style.display = 'none';
        document.getElementById('successState').classList.add('active');
      });
    } else {
      // Alerta de error devuelta por la API
      Swal.fire({
        icon: 'error',
        title: '<?= Trd(11); ?>',
        text: data.message,
        confirmButtonColor: 'var(--color-brand, #000)'
      });
      
      // Restauramos el botón si falló
      submitBtn.innerHTML = originalBtnText;
      submitBtn.disabled = false;
    }
  })
  .catch(error => {
    console.error('Error:', error);
    // Alerta de error de conexión/servidor
    Swal.fire({
      icon: 'error',
      title: '<?= Trd(12); ?>',
      text: '<?= Trd(13); ?>',
      confirmButtonColor: 'var(--color-brand, #000)'
    });
    
    // Restauramos el botón en caso de fallo crítico
    submitBtn.innerHTML = originalBtnText;
    submitBtn.disabled = false;
  });
});
</script>

</body>
</html>