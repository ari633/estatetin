<?php
/**
 * Property card.
 *
 * Expects $args: property (see estatein_property_data()), and optionally
 * style: "tags" (bedroom/bathroom/type pills) or "tagline" (one pill above the title).
 *
 * @package Estatein
 */

$property = $args['property'];
$style    = isset( $args['style'] ) ? $args['style'] : 'tags';
?>
<article class="card property-card">
	<?php if ( $property['image'] ) : ?>
		<img class="property-card__image" src="<?php echo esc_url( $property['image'] ); ?>" alt="<?php echo esc_attr( $property['title'] ); ?>" loading="lazy">
	<?php endif; ?>
	<div class="property-card__body">
		<?php if ( 'tagline' === $style && $property['tagline'] ) : ?>
			<p class="tag property-card__tagline"><?php echo esc_html( $property['tagline'] ); ?></p>
		<?php endif; ?>
		<div class="property-card__text">
			<h3 class="card__title"><?php echo esc_html( $property['title'] ); ?></h3>
			<p class="lead">
				<?php echo esc_html( $property['excerpt'] ); ?>
				<a href="<?php echo esc_url( $property['url'] ); ?>"><?php esc_html_e( 'Read More', 'estatein' ); ?></a>
			</p>
		</div>
		<?php if ( 'tags' === $style ) : ?>
		<ul class="tags">
			<?php if ( $property['bedrooms'] ) : ?>
				<li class="tag"><span class="tag__icon"><?php estatein_icon( 'bed', 22, 17 ); ?></span><?php echo esc_html( $property['bedrooms'] ); ?></li>
			<?php endif; ?>
			<?php if ( $property['bathrooms'] ) : ?>
				<li class="tag"><span class="tag__icon"><?php estatein_icon( 'bath', 21.0171, 21 ); ?></span><?php echo esc_html( $property['bathrooms'] ); ?></li>
			<?php endif; ?>
			<?php if ( $property['type'] ) : ?>
				<li class="tag"><span class="tag__icon"><?php estatein_icon( 'building', 24 ); ?></span><?php echo esc_html( $property['type'] ); ?></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
		<div class="property-card__footer">
			<p class="price">
				<span class="price__label"><?php esc_html_e( 'Price', 'estatein' ); ?></span>
				<span class="price__value"><?php echo esc_html( $property['price'] ); ?></span>
			</p>
			<a class="btn btn--primary" href="<?php echo esc_url( $property['url'] ); ?>"><?php esc_html_e( 'View Property Details', 'estatein' ); ?></a>
		</div>
	</div>
</article>
