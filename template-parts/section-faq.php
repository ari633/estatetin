<?php
/**
 * "Frequently Asked Questions" carousel.
 *
 * @package Estatein
 */

$faqs = estatein_get_faqs();
$head = array(
	'title'  => __( 'Frequently Asked Questions', 'estatein' ),
	'text'   => __( "Find answers to common questions about Estatein's services, property listings, and the real estate process. We're here to provide clarity and assist you every step of the way.", 'estatein' ),
	'button' => __( 'View All FAQ’s', 'estatein' ),
	'url'    => get_post_type_archive_link( 'faq' ),
);
?>
<section class="section container" id="faqs">
	<?php get_template_part( 'template-parts/section-head', null, $head ); ?>
	<div class="carousel" data-carousel>
		<div class="carousel__track" data-carousel-track>
			<?php foreach ( $faqs as $faq ) : ?>
				<article class="card faq-card">
					<h3 class="card__title"><?php echo esc_html( $faq['question'] ); ?></h3>
					<p class="lead"><?php echo esc_html( $faq['summary'] ); ?></p>
					<a class="btn btn--muted" href="<?php echo esc_url( $faq['url'] ); ?>"><?php esc_html_e( 'Read More', 'estatein' ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
		<?php get_template_part( 'template-parts/carousel-footer', null, $head ); ?>
	</div>
</section>
