<?php
/**
 * Service card: icon, title and a short description.
 *
 * Expects $args: icon, title, text.
 *
 * @package Estatein
 */

?>
<article class="card service-card">
	<header class="service-card__head">
		<span class="feature__icon feature__icon--small"><span><?php estatein_icon( $args['icon'], 34 ); ?></span></span>
		<h3 class="service-card__title"><?php echo esc_html( $args['title'] ); ?></h3>
	</header>
	<p class="lead"><?php echo esc_html( $args['text'] ); ?></p>
</article>
