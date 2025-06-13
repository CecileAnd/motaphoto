<main>
    <section class="galerie" id="galerie">
      <div class="zone-filtres">
  <div class="filtres-gauche">
    <div class="filtres" data-filtre="categorie">
      <button class="filtre-bouton">
        <span class="texte-filtre">Catégories</span> <span class="chevron">&#9013;</span>
      </button>
      <ul class="filtre-options">
        <li data-value="">&nbsp;</li>
        <li data-value="reception">Réception</li>
        <li data-value="mariage">Mariage</li>
        <li data-value="concert">Concert</li>
        <li data-value="television">Télévision</li>
      </ul>
    </div>
    <div class="filtres" data-filtre="format">
      <button class="filtre-bouton">
        <span class="texte-filtre">Formats</span> <span class="chevron">&#9013;</span>
      </button>
      <ul class="filtre-options">
        <li data-value="">&nbsp;</li>
        <li data-value="paysage">Paysage</li>
        <li data-value="portrait">Portrait</li>
      </ul>
    </div>
  </div>
  <div class="filtres-droite">
    <div class="filtres" data-filtre="tri">
      <button class="filtre-bouton">
        <span class="texte-filtre">Trier&nbsp;par</span> <span class="chevron">&#9013;</span>
      </button>
      <ul class="filtre-options">
        <li data-value="recente">Plus récentes</li>
        <li data-value="ancienne">Plus anciennes</li>
      </ul>
    </div>
  </div>
</div>
  <div class="grille-images">


<?php 
$args = array(
    'post_type' => 'photographie',
    'orderby' => 'date',
    'posts_per_page' => '-1',
    'order' => 'DESC',
);

$my_query = new WP_Query( $args );

// 3. On lance la boucle !
if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

$image = get_field('maphoto');?>

<article class="carte" data-categorie="reception" data-format="paysage" data-date="2019-01-01" data-reference="bf2385" data-type="Argentique">
    <a href="<?php echo $image['url'] ?>" data-lightbox="galerie" data-title="Santé !">
      <img src="<?php echo $image['url'] ?>" alt="Santé !" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche"><?php the_title(); ?></span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>

<?php
endwhile;
endif;

// 4. On réinitialise à la requête principale (important)
wp_reset_postdata();

?>
  <article class="carte" data-categorie="reception" data-format="paysage" data-date="2019-01-01" data-reference="bf2385" data-type="Argentique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-1.jpeg" data-lightbox="galerie" data-title="Santé !">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-1.jpeg" alt="Santé !" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
  <article class="carte" data-categorie="reception" data-format="paysage" data-date="2020-01-01" data-reference="bf2386" data-type="Argentique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-1.jpeg" data-lightbox="galerie" data-title="Et bon anniversaire !">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-1.jpeg" alt="Et bon anniversaire !" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
  <article class="carte" data-categorie="concert" data-format="paysage" data-date="2021-01-01" data-reference="bf2387" data-type="Numérique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-2.jpeg" data-lightbox="galerie" data-title="Let's party!">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-2.jpeg" alt="Let's party!" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
  <article class="carte" data-categorie="mariage" data-format="portrait" data-date="2019-01-01" data-reference="bf2388" data-type="Argentique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-3.jpeg" data-lightbox="galerie" data-title="Tout est installé">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-3.jpeg" alt="Tout est installé" />
     <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
  <article class="carte" data-categorie="mariage" data-format="portrait" data-date="2020-01-01" data-reference="bf2389" data-type="Numérique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-4.jpeg" data-lightbox="galerie" data-title="Vers l'éternité">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-4.jpeg" alt="Vers l'éternité" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
  <article class="carte" data-categorie="mariage" data-format="portrait" data-date="2021-01-01" data-reference="bf2390" data-type="Numérique">
    <a href="<?php echo get_template_directory_uri();?>/images/nathalie-5.jpeg" data-lightbox="galerie" data-title="Embrassez la mariée">
      <img src="<?php echo get_template_directory_uri();?>/images/nathalie-5.jpeg" alt="Embrassez la mariée" />
      <div class="overlay">
        <div class="icone-full">⛶</div>
        <div class="icone-oeil">👁</div>
        <div class="infos-bas"><span class="gauche">SANTÉ !</span><span  class="droite">RECEPTION</span></div>
      </div>
    </a>
  </article>
</div>
<div class="zone-bouton">
  <div id="btn-charger-plus" class="charger-plus">Charger plus</div>
</div>
</section>
</main>