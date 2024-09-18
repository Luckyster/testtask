<a href="<?php the_permalink();?>" class="album">
    <h2 class="album__title"><?php the_title(); ?></h2>
    <div class="album__thumbnail">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium'); ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/src/img/default.jpg" alt="Default Image">
        <?php endif; ?>
    </div>
</a>