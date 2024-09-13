<?php
/**
 * 404 page default template.
 *
 * @see Options -> 404 Page.
 *
 * @package WordPress
 * @subpackage theme_name
 */

get_header();

$title_404	= get_field( 'title_404', 'option' );
$desc_404	= get_field( 'description_404', 'option' );
$bg_img_404	= get_field( 'background_image_404', 'option' )
			? ' style="background-image: url(' . esc_url( wp_get_attachment_image_url( $bg_img_404['id'], 'full' ) ) . ')' : '';
?>

<main class="main">
	<div class="hero hero-404">
		<div class="container">
			<div class="hero-inner"<?php echo $bg_img_404 ?>>
				<div class="hero-body">
					<?php
					if( $title_404 ){
						?>
						<h1 class="hero-title">
							<?php printf( esc_html__( '%s', 'theme_name' ), $title_404 ) ?>
						</h1>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div><!-- .hero.hero-404 -->

	<div class="page-content page-content-404">
		<div class="container">
			<?php
			if( $desc_404 ){
				printf( __( '%s', 'theme_name' ), $desc404 );
			}
			?>
		</div>
	</div>
</main>

<?php
get_footer();

