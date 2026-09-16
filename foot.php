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
          <?= Trd(1); ?>
        </p>
      </div>

      <div class="footer-col">
        <h4><?= Trd(2); ?></h4>
        <ul>
          <li><a href="<?= URL_BASE ?>/"><?= Trd(3); ?></a></li>
          <li><a href="<?= URL_BASE ?>/products/all"><?= Trd(4); ?></a></li>
          <li><a href="<?= URL_BASE ?>/products/stock"><?= Trd(5); ?></a></li>
          <li><a href="#"><?= Trd(6); ?></a></li>
          <li><a href="<?= URL_BASE ?>/contact"><?= Trd(7); ?></a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4><?= Trd(8); ?></h4>
        <ul>
          <li><a href="#"><?= Trd(9); ?></a></li>
          <li><a href="#"><?= Trd(10); ?></a></li>
          <li><a href="<?= URL_BASE ?>/aboutus"><?= Trd(11); ?></a></li>
          <li><a href="<?= URL_BASE ?>/comments"><?= Trd(12); ?></a></li>
          <li><a href="<?= URL_BASE ?>/guarantees"><?= Trd(13); ?></a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4><?= Trd(14); ?></h4>
        <div class="social-row">
          <a href="#" aria-label="Facebook"><svg class="icon" style="width:15px;height:15px"><use href="#icon-facebook"/></svg></a>
          <a href="#" aria-label="Instagram"><svg class="icon" style="width:15px;height:15px"><use href="#icon-instagram"/></svg></a>
          <a href="#" aria-label="TikTok"><svg class="icon" style="width:15px;height:15px"><use href="#icon-tiktok"/></svg></a>
          <a href="#" aria-label="YouTube"><svg class="icon" style="width:15px;height:15px"><use href="#icon-youtube"/></svg></a>
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