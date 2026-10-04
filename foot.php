<?php
    $TraFoot = $Traducciones;
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "foot"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>
<footer class="site-footer" id="contacto">
  <div class="wrap">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="index.php" class="logo"><?= COMPANY_NAME ?></a>
        <p>

        <?php
        /*
        echo $account['account'][0]['Direccion']." ".$account['account'][0]['Direccion2']."<br>";
        echo $account['account'][0]['Ciudad'].' '. $account['account'][0]['CP']."<br>";
        echo $account['account'][0]['Estado']."<br><br>";
        */

        echo "9242 Hyssop Dr. <br>";
        echo "Rancho Cucamonga CA <br>";
        echo "91730<br><br>";
        ?>
         <strong><svg class="icon" style="width:15px;height:15px"><use href="#icon-phone" /></svg>:</strong> <?php echo formatPhoneNumber($account['account'][0]['TelefonoOficina']); ?><br>
         <strong><svg class="icon" style="width:15px;height:15px" viewBox="0 0 24 24" fill="currentColor">
  <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.572-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
</svg>:</strong> <?php echo formatPhoneNumber($account['account'][0]['TelefonoCelular']); ?>
        </p>
      </div>

      <div class="footer-col">
        <h4><?= Trd(2); ?></h4>
        <ul>
          <li><a href="<?= URL_BASE ?>/"><?= Trd(3); ?></a></li>
          <li><a href="<?= URL_BASE ?>/products/all"><?= Trd(4); ?></a></li>
          <li><a href="<?= URL_BASE ?>/products/stock"><?= Trd(5); ?></a></li>
          <li><a href="<?= URL_BASE ?>/contact"><?= Trd(7); ?></a></li>
          <li><a href="<?= URL_BASE ?>/terms"><?= Trd(26); ?></a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4><?= Trd(8); ?></h4>
        <ul>
          <li><a href="#"><?= Trd(9); ?></a></li>
          <li><a href="#"><?= Trd(10); ?></a></li>
          <li><a href="<?= URL_BASE ?>/aboutus"><?= Trd(11); ?></a></li>
          <li><a href="<?= URL_BASE ?>/comments"><?= Trd(12); ?></a></li>
          <li><a href="<?= URL_BASE ?>/warranties"><?= Trd(13); ?></a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4><?= Trd(14); ?></h4>
        <div class="social-row">
          <a href="<?= $account['account'][0]['URLFace'] ?>" aria-label="Facebook"><svg class="icon" style="width:15px;height:15px"><use href="#icon-facebook"/></svg></a>
          <a href="<?= $account['account'][0]['URLInsta'] ?>" aria-label="Instagram"><svg class="icon" style="width:15px;height:15px"><use href="#icon-instagram"/></svg></a>
          <a href="<?= $account['account'][0]['URLLink'] ?>" aria-label="TikTok"><svg class="icon" style="width:15px;height:15px"><use href="#icon-tiktok"/></svg></a>
          <a href="<?= $account['account'][0]['URLYou'] ?>" aria-label="YouTube"><svg class="icon" style="width:15px;height:15px"><use href="#icon-youtube"/></svg></a>
        </div>
        <p style="margin-top:18px; font-size:.8rem;"><?= Trd(15); ?></p>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© 2026 <?= COMPANY_NAME ?> <?= Trd(16); ?></span>
      <div class="legal-links">
        <a href="<?php echo URL_BASE?>/privacy"><?= Trd(17); ?></a>
        <a href="<?php echo URL_BASE?>/conditions"><?= Trd(18); ?></a>
      </div>
    </div>
  </div>
</footer>

<style>

  
.full-width {
  width: 100%;
}
.modal-body .form-group input {
  width: 100%;
}

</style>
<div class="modal-backdrop" id="loginModalBackdrop"></div>

<div class="address-modal" id="loginModal" role="dialog" aria-hidden="true" aria-labelledby="loginModalTitle">
  
  <div class="modal-header">
    <h2 id="loginModalTitle"><?= Trd(19); ?></h2>
    <button class="btn-close-modal" id="closeLoginModalBtn" aria-label="Cerrar modal">&times;</button>
  </div>

  <form action="#" method="POST" class="modal-body login-form" id="loginForm_md" onsubmit="processLoginAPI(event,'_md')">
    <div class="form-group full-width">
      <label for="loginUser"><?= Trd(20); ?></label>
      <input type="text" id="loginUser" name="loginUser" required placeholder="ejemplo@correo.com">
    </div>
    
    <div class="form-group full-width">
      <label for="loginPass"><?= Trd(21); ?></label>
      <input type="password" id="loginPass" name="loginPass" required placeholder="••••••••">
    </div>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 4px 0 12px 0; font-size: 0.82rem;">
      <a href="<?= URL_BASE ?>/recovery" style="color: var(--color-ink-soft); text-decoration: underline;"><?= Trd(22); ?></a>
      <div class="register-text">
        <?= Trd(23); ?><a href="<?= URL_BASE ?>/register" style="color: var(--color-brand); font-weight: 600;"><?= Trd(24); ?></a>
      </div>
    </div>
    
    <div class="modal-footer" style="border-top: none; padding-top: 0; margin-top: 0;">
      <button type="submit" class="btn-save" id="btnLoginSubmit_md" style="width: 100%; text-align: center; justify-content: center;"><?= Trd(25); ?></button>
    </div>
  </form>
</div>
<?php
$Traducciones = $TraFoot;
?>