<article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
    <a href="<?php the_permalink(); ?>" class="image-link">
        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('large', ['class' => 'image-carte']);
        } else {
            $attachments = get_attached_media('image', get_the_ID());
            if (!empty($attachments)) {
                $first_attachment = reset($attachments);
                echo wp_get_attachment_image($first_attachment->ID, 'large', false, ['class' => 'image-carte']);
            } else {
                echo '<img src="' . get_template_directory_uri() . '/images/default-photo.jpg" alt="Image par défaut" class="image-carte" />';
            }
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
