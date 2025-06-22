<?php
/**
 * Template Name: Front Page - Galerie Photos
 */
get_header();
?>

<main id="primary" class="site-main galerie">

    <div class="zone-filtres">
        <div class="filtres-gauche">
            <?php
            $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
            if (!empty($categories) && !is_wp_error($categories)) :
            ?>
                <div class="filtres">
                    <label for="categorie"><strong>Catégorie</strong></label>
                    <select name="categorie" id="categorie">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php
            $formats = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]);
            if (!empty($formats) && !is_wp_error($formats)) :
            ?>
                <div class="filtres">
                    <label for="format"><strong>Format</strong></label>
                    <select name="format" id="format">
                        <option value="">Tous les formats</option>
                        <?php foreach ($formats as $format) : ?>
                            <option value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
        </div>

        <div class="filtres-droite">
            <div class="filtres">
                <label for="tri"><strong>Trier par</strong></label>
                <select name="tri" id="tri">
                    <option value="date_desc">Date décroissante</option>
                    <option value="date_asc">Date croissante</option>
                    <option value="title_asc">Titre A-Z</option>
                    <option value="title_desc">Titre Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <div id="photos-container" class="colonnes-images">
        <!-- Les photos chargées par AJAX apparaîtront ici -->
    </div>

    <button id="load-more">Charger plus</button>

</main>

<?php get_footer(); ?>
