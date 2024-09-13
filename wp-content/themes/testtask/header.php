<?php

/**
 * Header default template.
 *
 * @see Options -> Header.
 *
 * @package WordPress
 * @subpackage theme_name
 */

// Theme URI for favicon and etc.
$uri = get_template_directory_uri();
?>

<!doctype html>
<html class="no-js" <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- FAVICON -->
	<!-- /FAVICON -->

	<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>
	<?php wp_body_open() ?>
	<div class="wrapper">
        <header>
            <?php wp_nav_menu(array(
                'theme_location' => 'header_menu',
                'menu_class' => 'header-menu menu',
                'depth' => 2
            )); ?>
        </header>
