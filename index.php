<?php
/**
 * Fallback template for pages, posts and archives that don't have their own design yet.
 *
 * @package Estatein
 */

get_header();
?>

<div class="section container content">
	<?php if ( is_archive() || is_home() ) : ?>
		<h1 class="heading"><?php echo is_home() ? esc_html( get_bloginfo( 'name' ) ) : wp_kses_post( get_the_archive_title() ); ?></h1>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'content__entry' ); ?>>
				<?php if ( is_singular() ) : ?>
					<h1 class="heading"><?php the_title(); ?></h1>
					<?php the_post_thumbnail( 'large' ); ?>
					<div class="content__body"><?php the_content(); ?></div>
				<?php else : ?>
					<h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="lead"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1 class="heading"><?php esc_html_e( 'Nothing found', 'estatein' ); ?></h1>
		<p class="lead"><?php esc_html_e( 'There is no content here yet.', 'estatein' ); ?></p>
	<?php endif; ?>
</div>

<?php
get_footer();
