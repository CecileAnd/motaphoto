<article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
    <a href="<?php the_permalink(); ?>" class="image-link">
        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('large', ['class' => 'image-carte']);
        } 
        ?>
    </a>

    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
    </header>

    <div class="entry-content">
        <?php the_excerpt(); ?>
    </div>
</article>
