<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "stock"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
    $TrdRsp = $Traducciones;
?>
  <section class="products-section alt-bg" id="en-stock">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow"><?= Trd(1);?></p>
          <h2><?= Trd(2);?></h2>
        </div>
        <a href="products/all" class="link-arrow"><?= Trd(3);?> <svg class="icon"><use href="#icon-arrow"/></svg></a>
      </div>

      <div class="product-grid">

            <?php
                $api_url = URL_API."products_sale_stock";
                //$data = json_encode(["Product" => $_GET['Id']]);
                $data='';
                $data = json_decode(API($jwt,$api_url,$data,'GET'), true);
                if ($data['status'] === 'success') {
                    foreach ($data['data'] as $product) {
                        if ($product['Discount'] > 0){
                          $price = '<div class="price-row"><span class="price-sale is-discount">$'.number_format($product['SalePrice']-$product['Discount'], 2, ".", ",").'</span><span class="price-regular">$'.number_format($product['SalePrice'], 2, ".", ",").'</span></div>';
                        }
                        else{
                          $price = '<div class="price-row"><span class="price-sale">$'.number_format($product['SalePrice'], 2, ".", ",").'</span></div>';
                        }
                        $URLImage = URL_IMAGES.'/products_images/thumbnails/'.$product['Image'];
                        //$URL = 'product/'.str_replace(" ","-",$product['Name']);
                        $URL = 'product/'.str_replace(" ","-",$product['Name']).'?Idp='.$product['Id'];
                        
                        // Nota: Se concatenó Trd(2) para "En stock" y Trd(4) para "Ver detalles" dentro del string de echo
                        echo '
                          <article class="product-card">
                            <a href="'.$URL.'" class="product-media">
                              <img src="'.$URLImage.'" alt="'.$product['Name'].'">
                              <span class="tag tag-stock">'.Trd(2).'</span>
                            </a>
                            <div class="product-body">
                              <a href="'.$URL.'" class="product-name">'.$product['Name'].'</a>
                              '.$price.'
                              <a href="'.$URL.'" class="btn-outline-sm">'.Trd(4).'</a>
                            </div>
                          </article>
                        ';
                    }        
                } 
            ?>        


      </div>
    </div>
  </section>

  <?php
    $Traducciones = $TrdRsp;
  ?>