<?php
/**
 * Carousel footer: page counter and previous/next buttons.
 *
 * Expects $args: button, url (the "view all" button shown here on small screens).
 *
 * @package Estatein
 */

?>
<div class="carousel__footer">
	<?php if ( ! empty( $args['button'] ) ) : ?>
		<a class="btn btn--muted carousel__view-all" href="<?php echo esc_url( $args['url'] ); ?>"><?php echo esc_html( $args['button'] ); ?></a>
	<?php endif; ?>
	<p class="carousel__count"><span data-carousel-current>01</span> <?php esc_html_e( 'of', 'estatein' ); ?> <span data-carousel-total>01</span></p>
	<div class="carousel__buttons">
		<button class="carousel__button" type="button" data-carousel-prev aria-label="<?php esc_attr_e( 'Previous', 'estatein' ); ?>">
			<?php estatein_icon( 'arrow-left', 30 ); ?>
		</button>
		<button class="carousel__button" type="button" data-carousel-next aria-label="<?php esc_attr_e( 'Next', 'estatein' ); ?>">
			<?php estatein_icon( 'arrow-right', 30 ); ?>
		</button>
	</div>
</div>
