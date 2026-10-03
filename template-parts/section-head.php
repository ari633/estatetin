<?php
/**
 * Section heading: sparkle decoration, title, intro and a "view all" button.
 *
 * Expects $args: title, text, and optionally button + url.
 *
 * @package Estatein
 */

?>
<div class="section-head">
	<div class="section-head__text">
		<div class="sparkles" aria-hidden="true">
			<span class="sparkles__item sparkles__item--1"><img src="<?php echo esc_url( estatein_asset( 'icons/sparkle-1.svg' ) ); ?>" width="60" height="60" alt=""></span>
			<span class="sparkles__item sparkles__item--2"><img src="<?php echo esc_url( estatein_asset( 'icons/sparkle-2.svg' ) ); ?>" width="36" height="36" alt=""></span>
			<span class="sparkles__item sparkles__item--3"><img src="<?php echo esc_url( estatein_asset( 'icons/sparkle-3.svg' ) ); ?>" width="16.8" height="16.8" alt=""></span>
		</div>
		<h2 class="heading"><?php echo esc_html( $args['title'] ); ?></h2>
		<p class="lead"><?php echo esc_html( $args['text'] ); ?></p>
	</div>
	<?php if ( ! empty( $args['button'] ) ) : ?>
		<a class="btn btn--muted section-head__button" href="<?php echo esc_url( $args['url'] ); ?>"><?php echo esc_html( $args['button'] ); ?></a>
	<?php endif; ?>
</div>
