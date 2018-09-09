<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->


<?php 
$orig_post = $post;
global $post;

$categories = get_the_category($post->ID);
if ($categories) {
	$category_ids = array();
	foreach($categories as $individual_category) {
		$category_ids[] = $individual_category->term_id;
	}
	$args=array(
		'category__in' => $category_ids,
		'post__not_in' => array($post->ID),
		'posts_per_page'=> 4, // Number of related posts that will be shown.
		'ignore_sticky_posts' => true
	);
	$my_query = new wp_query( $args );

	if( $my_query->have_posts() ) {
		echo '<div id="related_posts"><h3>Artículos relacionados</h3>';

	while( $my_query->have_posts() ) {
		$my_query->the_post();
		?>

	<div>
		<div class="relatedthumb">
			<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
		</div>
		<div class="relatedcontent">
			<h3><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
		</div>
	</div>
<?php
		}
		echo '</ul></div>';
	}
}
$post = $orig_post;
wp_reset_query(); 
?>

	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
