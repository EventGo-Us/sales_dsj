<?php
    $TrdNews = $Traducciones;
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "news"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>


<style>
  /* Corrección rápida de contraste opcional para que los botones de SweetAlert combinen con la marca */
  .swal2-styled.swal2-confirm {
    background-color: #10B981 !important; /* Verde comercial */
  }
</style>

<section class="newsletter-band">
  <div class="wrap newsletter-inner">
    <div>
      <h2><?= Trd(1); ?></h2>
      <p><?= Trd(2); ?></p>
    </div>
    <form class="newsletter-form" id="newsletterForm" onsubmit="simulateNewsletterAPI(event)">
      <input type="email" id="newsletterEmail" required placeholder="<?= Trd(3); ?>" aria-label="<?= Trd(3); ?>">
      <button type="submit" id="btnNewsletterSubmit"><?= Trd(4); ?></button>
      <span class="form-note" id="formNote" hidden><?= Trd(6); ?></span>
    </form>
  </div>
</section>

<script>
function simulateNewsletterAPI(event) {
  event.preventDefault();

  const emailInput = document.getElementById('newsletterEmail');
  const btnSubmit = document.getElementById('btnNewsletterSubmit');
  const email = emailInput.value.trim();

  if (!email) return;

  // Feedback visual: deshabilitar el botón durante la petición[cite: 1]
  btnSubmit.disabled = true;
  btnSubmit.textContent = "<?= Trd(5); ?>"; // Texto de "Cargando..."[cite: 1]

  // Petición AJAX con jQuery
  $.ajax({
    url: url_api +'newsletter', // Ruta hacia tu archivo PHP de backend
    type: 'POST',
    data: JSON.stringify({ email: email }),
    contentType: 'application/json',
    headers: {
        'Authorization': 'Bearer ' + token,
        'X-ID-CLIENT': '<?= ID_CLIENT ?>',
        'LNG': '<?= $_SESSION['Idioma'] ?>'
    },       
    success: function(data) {
      if (data.status === 'exists') {
        // El correo ya está registrado en la base de datos
        const alertText = "<?= Trd(8); ?>".replace('{email}', email);

        Swal.fire({
          title: '<?= Trd(7); ?>',
          text: alertText,
          icon: 'info',
          confirmButtonText: '<?= Trd(9); ?>',
          customClass: { confirmButton: 'swal2-confirm' }
        });

      } else if (data.status === 'success') {
        // Registro exitoso en la base de datos
        Swal.fire({
          title: '<?=  $account['account'][0]['Correo'] ?> <br><br> <?= Trd(10); ?>',
          text: '<?= Trd(11); ?>',
          icon: 'success',
          confirmButtonText: '<?= Trd(12); ?>',
          customClass: { confirmButton: 'swal2-confirm' }
        });

        emailInput.value = '';
      } else {
        // Errores controlados devueltos por el servidor
        Swal.fire({
          title: 'Error',
          text: data.message,
          icon: 'error',
          confirmButtonText: 'Ok'
        });
      }
    },
    error: function(xhr, status, error) {
      // Error de red, URL incorrecta o caída del servidor
      console.error('Error en la petición:', error);
      Swal.fire({
        title: 'Error',
        text: 'Hubo un problema de conexión con el servidor.',
        icon: 'error',
        confirmButtonText: 'Ok'
      });
    },
    complete: function() {
      btnSubmit.disabled = false;
      btnSubmit.textContent = "<?= Trd(4); ?>";
    }
  });
}
</script>
<?php
  $Traducciones =$TrdNews;
?>