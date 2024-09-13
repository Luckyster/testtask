<?php
// Template for displaying albums on the home page
get_header(); ?>

<div class="container">
    <?php do_shortcode('[albums]'); ?>
</div>

<?php get_footer(); ?>
