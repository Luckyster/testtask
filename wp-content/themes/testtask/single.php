<?php
// Template for displaying single album with custom fields from ACF
get_header(); ?>

<div class="container album-detail">
    <h1 class="album-detail__title"><?php the_title(); ?></h1>
    <div class="album-detail__grid">
        <?php if(has_post_thumbnail()): ?>
            <div class="album-detail__thumb">
                <?php the_post_thumbnail('full__hd'); ?>
            </div>
        <?php endif; ?>
        <div class="album-detail__custom-fields">
            <?php
            $custom_fields = get_field('custom_fields');

            if (!empty($custom_fields)) :
                ?>
                <div class="custom-fields">
                    <?php
                    foreach ($custom_fields as $field) :
                            $name = $field['name'] ?? '';
                            $text = $field['text'] ?? '';
                            ?>
                            <div class="custom-fields__item">
                                <?php if(!empty($name)): ?>
                                <div class="custom-fields__name">
                                    <strong><?php echo esc_html($name); ?>:</strong>
                                </div>
                                <?php endif; ?>
                                <?php if($text): ?>
                                <div class="custom-fields__text">
                                    <?php echo esc_html($text); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php
                    endforeach; ?>
                </div>
            <?php endif; ?>

            <?php
            the_content();
            ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
