<?php
    $api_url = URL_API."Traducciones_web_sales";
    $data = json_encode(['program' => "cat"]);
    $Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);
?>
  <section class="categories">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow"><?= Trd(1); ?></p>
          <h2><?= Trd(2); ?></h2>
        </div>
      </div>

      <div class="category-grid">

            <?php
                $api_url = URL_API."categories_sale";
                //$data = json_encode(["Product" => $_GET['Id']]);
                $data='';
                $data = json_decode(API($jwt,$api_url,$data,'POST'), true);
                if ($data['status'] === 'success') {
                    foreach ($data['data'] as $category) {
                        $category['Imagen'] = URL_IMAGES.'/categories/thumbnails/'.$category['Imagen'];
                        $URL = str_replace(" ","-",$category['Nombre']);
                        echo '
                          <a class="category-card" href="products/'.$URL.'">
                            <div class="img-wrap"><img src="'.$category['Imagen'].'" alt="'.$category['Nombre'].'"></div>
                            <div class="cat-meta"><h3>'.$category['Nombre'].'</h3><svg class="icon"><use href="#icon-arrow"/></svg></div>
                          </a>                        
                        ';
                    }        
                } 
            ?>      
      </div>
    </div>
  </section>