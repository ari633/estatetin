<?php
/**
 * Page hero: large heading and intro on a gradient band.
 *
 * Expects $args: title, text.
 *
 * @package Estatein
 */

?>
<section class="page-hero">
	<div class="page-hero__text">
		<h1 class="heading"><?php echo esc_html( $args['title'] ); ?></h1>
		<p class="lead"><?php echo esc_html( $args['text'] ); ?></p>
	</div>
</section>
