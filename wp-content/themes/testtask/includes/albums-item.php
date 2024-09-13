<a href="<?php the_permalink();?>" class="album">
    <h2 class="album__title"><?php the_title(); ?></h2>
    <div class="album__thumbnail">
        <?php the_post_thumbnail('medium'); ?>
    </div>
</a>