<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "features"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>
  <section class="features-band">
    <div class="wrap">
      <div class="features-grid">
        <div class="feature-item">
          <svg class="icon"><use href="#icon-shield"/></svg>
          <div><h3><?= Trd(1); ?></h3><p><?= Trd(2); ?></p></div>
        </div>
        <div class="feature-item">
          <svg class="icon"><use href="#icon-tag"/></svg>
          <div><h3><?= Trd(3); ?></h3><p><?= Trd(4); ?></p></div>
        </div>
        <div class="feature-item">
          <svg class="icon"><use href="#icon-truck"/></svg>
          <div><h3><?= Trd(5); ?></h3><p><?= Trd(6); ?></p></div>
        </div>
        <div class="feature-item">
          <svg class="icon"><use href="#icon-phone"/></svg>
          <div><h3><?= Trd(7); ?></h3><p><?= Trd(8); ?></p></div>
        </div>
      </div>
    </div>
  </section>