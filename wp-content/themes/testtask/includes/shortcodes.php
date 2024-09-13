<?php
function albums_shortcode($atts) {
    wp_enqueue_script( 'filters', get_template_directory_uri() . '/static/js/filters.min.js', [], mt_rand(), true );
    wp_localize_script( 'filters', 'ajax',[
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ]);

    $atts = shortcode_atts(
        array(
            'count' => 10,
        ),
        $atts,
        'albums'
    );
    $genres = get_terms( 'genre', [
        'hide_empty' => false,
        'orderby' => 'name',
    ] );
    $post_per_page =$atts['count']?? 10;
    $wp_args = array(
        'post_type' => 'album',
        'posts_per_page' => $post_per_page
    );
    $search_result = new WP_Query( $wp_args );
    ob_start(); ?>

    <div class="js-album-filter-container album-filter">
        <div class="album-filter__inner">
            <form class="js-album-filter-form album-filter__form">
                <label for="genre"><?php _e('Filter by genre') ?>:</label>
                <input type="hidden" name="count" value="<?= isset($atts['count']) ? esc_attr($atts['count']) : ''; ?>">
                <input type="hidden" class="js-skip" name="skip" value="<?php echo $post_per_page; ?>">
                <select class="genre" name="genre">
                    <option value=""><?php _e('Choose genre'); ?></option>
                    <?php foreach ($genres as $genre) : ?>
                        <option value="<?php echo esc_attr($genre->slug); ?>">
                            <?php echo esc_html($genre->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="js-albums-list album-filter__list">
            <?php
            if ($search_result->have_posts()) {
                while ($search_result->have_posts()) {
                    $search_result->the_post();
                    get_template_part('includes/albums-item');
                }
            } else {
                echo '<p class="h3 no-items">' . __('No posts found.') . '</p>';
            } ?>
        </div>
        <?php if (!empty($post_per_page) && $search_result->found_posts > $post_per_page && $post_per_page != -1): ?>
            <div class="album-filter__btn-wrapper">
                <button class="btn btn--grey btn--arrow js-filters__loadmore album-filter__loadmore" >
                    <?php _e('Load More'); ?>
                </button>
            </div>
        <?php endif; ?>
    </div>
    <?php echo ob_get_clean();

}
add_shortcode('albums', 'albums_shortcode');

function filter_albums() {
    $response = [
        'hide_more' => 0,
        'total' => 0,
        'skip' => 0,
        'data' => '',
    ];
    $genre = isset($_POST['genre']) ? sanitize_text_field($_POST['genre']) : '';
    $count = isset($_POST['count']) ? intval($_POST['count']) : 10;
    $skip = isset($_POST['skip']) ? abs(intval($_POST['skip'])) : 0;

    $args = array(
        'post_type' => 'album',
        'posts_per_page' => $count,
        'offset' => $skip,
    );

    if (!empty($genre)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'genre',
                'field'    => 'slug',
                'terms'    => $genre,
            ),
        );
    }

    $albums_query = new WP_Query($args);
    ob_start();
    if ($albums_query->have_posts()) :
        while ($albums_query->have_posts()) : $albums_query->the_post();
            get_template_part('includes/albums-item');
        endwhile;
    else :
        echo '<p>' . __('No albums') . '</p>';
    endif;
    $response['data'] = ob_get_clean();
    $response['total'] = $albums_query->found_posts;
    $response['skip'] = $skip + $count;
    if ($response['skip'] >= $response['total']) {
        $response['hide_more'] = 1;
    }
    //$response['dbg'] = $args;
    // Send JSON response
    wp_send_json($response);
}
add_action('wp_ajax_filter_albums', 'filter_albums');
add_action('wp_ajax_nopriv_filter_albums', 'filter_albums');

function albums_with_singles_shortcode() {
    global $wpdb;

    $query = "
        SELECT 
            wp_posts.post_title AS album_title, 
            COUNT(wp_term_relationships.object_id) AS singles_count
        FROM 
            wp_posts
        LEFT JOIN 
            wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id
        LEFT JOIN 
            wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
        LEFT JOIN 
            wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
        WHERE 
                wp_posts.post_type = 'album'
            AND wp_term_taxonomy.taxonomy = 'single'
        GROUP BY 
            wp_posts.ID
        ORDER BY 
            wp_posts.post_title ASC
    ";

    $results = $wpdb->get_results($query);

    if (!empty($results)) {
        ob_start();

        echo '<ul class="album-list">';
        foreach ($results as $row) {
            echo '<li>';
            echo '<strong>' . esc_html($row->album_title) . '</strong> - ';
            echo esc_html($row->singles_count) . ' ' . __('singles');
            echo '</li>';
        }
        echo '</ul>';

        return ob_get_clean();
    } else {
        return '<p>' . __('No albums found.') . '</p>';
    }
}
add_shortcode('albums_with_singles', 'albums_with_singles_shortcode');
