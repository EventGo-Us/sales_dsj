<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "hero"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>
  <section class="hero">
    <div class="wrap hero-inner">
      <div class="hero-copy">
        <p class="eyebrow"><?= Trd(1); ?></p>
        <h1><?= Trd(2); ?></h1>
        <p class="lead"><?= Trd(3); ?></p>
        <div class="hero-ctas">
          <a href="<?= URL_BASE ?>/products/all" class="btn btn-primary"><?= Trd(4); ?></a>
          <a href="<?= URL_BASE ?>/contact" class="text-link"><?= Trd(5); ?></a>
        </div>

        <div class="stat-row">
          <div class="stat"><span class="num">800+</span><span class="label">Rentadoras activas</span></div>
          <div class="stat"><span class="num">3 años</span><span class="label">Garantía de costuras</span></div>
          <div class="stat"><span class="num">5–10</span><span class="label">Días de entrega</span></div>
        </div>
      </div>

      <div class="hero-art">

<?php
                $api_url = URL_API."products_sale_hero";
                //$data = json_encode(["Product" => $_GET['Id']]);
                $data='';
                $data = json_decode(API($jwt,$api_url,$data,'GET'), true);

                if ($data['status'] === 'success') {
                    foreach ($data['images'] as $img) {
                      $URLImage2= URL_IMAGES.'/products_images/originals/'.$img['Image'];
                    }
                    foreach ($data['data'] as $product) {
                      $URLImage = URL_IMAGES.'/products_images/originals/'.$product['Image'];
                      
                      echo '
                        <div class="hero-photo hero-photo--main">
                          <img src="'.$URLImage.'" alt="'.$product['Name'].'">
                        </div>
                        <div class="hero-photo hero-photo--accent">
                          <img src="'.$URLImage2.'" alt="'.$product['Name'].'">
                        </div>
                        <div class="hero-note">
                          <span class="from">Desde</span>
                          <span class="amount">$'.number_format($product['SalePrice']-$product['Discount'], 2, ".", ",") .'</span>
                        </div>                      
                      ';
                    }
                }

?>      



      </div>
    </div>
  </section>