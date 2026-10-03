<?php
/**
 * Row of four icon tiles.
 *
 * Expects $args: items — each array( icon, label, url ), or
 * array( icon, links ) where links is label => url for a tile with several links.
 *
 * @package Estatein
 */

?>
<ul class="features" id="features">
	<?php foreach ( $args['items'] as $item ) : ?>
		<li class="feature">
			<span class="feature__icon"><span><?php estatein_icon( $item[0], 34 ); ?></span></span>
			<?php if ( is_array( $item[1] ) ) : ?>
				<span class="feature__title feature__links">
					<?php foreach ( $item[1] as $label => $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</span>
			<?php else : ?>
				<a class="feature__title feature__link" href="<?php echo esc_url( $item[2] ); ?>"><?php echo esc_html( $item[1] ); ?></a>
			<?php endif; ?>
			<span class="feature__arrow"><?php estatein_icon( 'arrow-corner', 34 ); ?></span>
		</li>
	<?php endforeach; ?>
</ul>
