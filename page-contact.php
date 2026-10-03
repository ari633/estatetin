<?php
/**
 * Contact page (used by the page with the slug "contact").
 *
 * @package Estatein
 */

get_header();

$email = 'info@estatein.com';
$phone = '+1 (123) 456-7890';

$tiles = array(
	array( 'mail-solid', $email, 'mailto:' . $email ),
	array( 'phone', $phone, 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ),
	array( 'pin-solid', __( 'Main Headquarters', 'estatein' ), '#offices' ),
	array(
		'logo-mark',
		array(
			'Instagram' => '#',
			'LinkedIn'  => '#',
			'Facebook'  => '#',
		),
	),
);

$offices = array(
	array(
		'group'   => 'main',
		'label'   => __( 'Main Headquarters', 'estatein' ),
		'address' => '123 Estatein Plaza, City Center, Metropolis',
		'text'    => __( 'Our main headquarters serve as the heart of Estatein. Located in the bustling city center, this is where our core team of experts operates, driving the excellence and innovation that define us.', 'estatein' ),
		'email'   => 'info@estatein.com',
		'phone'   => '+1 (123) 456-7890',
		'city'    => 'Metropolis',
	),
	array(
		'group'   => 'regional',
		'label'   => __( 'Regional Offices', 'estatein' ),
		'address' => '456 Urban Avenue, Downtown District, Metropolis',
		'text'    => __( "Estatein's presence extends to multiple regions, each with its own dynamic real estate landscape. Discover our regional offices, staffed by local experts who understand the nuances of their respective markets.", 'estatein' ),
		'email'   => 'info@restatein.com',
		'phone'   => '+1 (123) 628-7890',
		'city'    => 'Metropolis',
	),
);

$tabs = array(
	'all'           => __( 'All', 'estatein' ),
	'regional'      => __( 'Regional', 'estatein' ),
	'international' => __( 'International', 'estatein' ),
);

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'title' => __( 'Get in Touch with Estatein', 'estatein' ),
		'text'  => __( "Welcome to Estatein's Contact Us page. We're here to assist you with any inquiries, requests, or feedback you may have. Whether you're looking to buy or sell a property, explore investment opportunities, or simply want to connect, we're just a message away. Reach out to us, and let's start a conversation.", 'estatein' ),
	)
);
get_template_part( 'template-parts/features', null, array( 'items' => $tiles ) );
?>

<section class="section container" id="form">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( "Let's Connect", 'estatein' ),
			'text'  => __( "We're excited to connect with you and learn more about your real estate goals. Use the form below to get in touch with Estatein. Whether you're a prospective client, partner, or simply curious about our services, we're here to answer your questions and provide the assistance you need.", 'estatein' ),
		)
	);
	get_template_part( 'template-parts/inquiry-form', null, array( 'contact' => true ) );
	?>
</section>

<section class="section container" id="offices" data-tabs>
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Discover Our Office Locations', 'estatein' ),
			'text'  => __( "Estatein is here to serve you across multiple locations. Whether you're looking to meet our team, discuss real estate opportunities, or simply drop by for a chat, we have offices conveniently located to serve your needs. Explore the categories below to find the Estatein office nearest to you", 'estatein' ),
		)
	);
	?>

	<div class="tabs" role="group" aria-label="<?php esc_attr_e( 'Filter offices', 'estatein' ); ?>">
		<?php foreach ( $tabs as $group => $label ) : ?>
			<button class="tabs__tab" type="button" data-tab="<?php echo esc_attr( $group ); ?>" aria-pressed="<?php echo 'all' === $group ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button>
		<?php endforeach; ?>
	</div>

	<div class="offices">
		<?php foreach ( $offices as $office ) : ?>
			<article class="card office" data-tab-item="<?php echo esc_attr( $office['group'] ); ?>">
				<div class="office__text">
					<p><?php echo esc_html( $office['label'] ); ?></p>
					<h3 class="office__address"><?php echo esc_html( $office['address'] ); ?></h3>
					<p class="lead"><?php echo esc_html( $office['text'] ); ?></p>
				</div>
				<ul class="tags">
					<li class="tag"><span class="tag__icon"><?php estatein_icon( 'mail-solid', 24 ); ?></span><a href="<?php echo esc_url( 'mailto:' . $office['email'] ); ?>"><?php echo esc_html( $office['email'] ); ?></a></li>
					<li class="tag"><span class="tag__icon"><?php estatein_icon( 'phone', 24 ); ?></span><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $office['phone'] ) ); ?>"><?php echo esc_html( $office['phone'] ); ?></a></li>
					<li class="tag"><span class="tag__icon"><?php estatein_icon( 'pin-solid', 24 ); ?></span><?php echo esc_html( $office['city'] ); ?></li>
				</ul>
				<a class="btn btn--primary" href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $office['address'] ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Get Direction', 'estatein' ); ?></a>
			</article>
		<?php endforeach; ?>
		<p class="empty" data-tab-empty hidden><?php esc_html_e( 'No offices in this category yet.', 'estatein' ); ?></p>
	</div>
</section>

<section class="section container">
	<div class="world">
		<img class="world__pattern" src="<?php echo esc_url( estatein_asset( 'img/hero-pattern.svg' ) ); ?>" width="1922.9" height="1284.4" alt="" aria-hidden="true">
		<div class="world__grid">
			<?php // Photo slots: the design's photos are not in the theme yet. ?>
			<div class="world__photo world__photo--a">
				<img src="https://media.istockphoto.com/id/1384946649/id/foto/bertemu-dengan-agen-real-estat.jpg?s=612x612&w=0&k=20&c=UaqUZgKHnGq62Mz0jd9YgWL3Vxk-6WrqvAOeXeC4RzM=" />
			</div>
			<div class="world__photo world__photo--b">
				<img src="https://media.istockphoto.com/id/2214259809/id/foto/pasangan-senior-berbicara-dengan-agen-real-estat-di-rumah.jpg?s=612x612&w=0&k=20&c=19MjMQ737xK4cxtIihhutrxiE6ae_PdUqdCnI6A1cMI=" />
			</div>
			<div class="world__photo world__photo--c">
				<img src="https://media.istockphoto.com/id/2273320843/id/foto/manajer-bank-jepang-yang-bahagia-berbicara-dengan-pelanggannya-pada-pertemuan-di-kantor.jpg?s=612x612&w=0&k=20&c=kmLhYjOQbk6Bu6W6p16V5OU6HnW5xTFcLuy4bRx1SSQ=" height="100%" />
			</div>
			<div class="world__photo world__photo--d">
				<img src="https://media.istockphoto.com/id/2200075226/id/foto/agen-asuransi-menutupi-rumah-dengan-tangan-konsep-asuransi-bersiap-untuk-kejadian-tak-terduga.jpg?s=612x612&w=0&k=20&c=IIOK1w2ul-NpcCkV4ycyjs_ZijE4dfIQiahrYn0ZznE=" />
			</div>
			<div class="world__photo world__photo--e">
				<img src="https://media.istockphoto.com/id/1432896526/id/foto/agen-rumah-berbicara-dengan-pembeli-rumah-baru-dan-menawarkan-suku-bunga-yang-baik-dan.jpg?s=612x612&w=0&k=20&c=JPMxY8A-7YW07xipj-6ci38Cnz3Vr8a4au5EM5QJDjA=" />
			</div>
			<div class="world__photo world__photo--f">
				<img src="https://media.istockphoto.com/id/2214259792/id/foto/potret-pria-agen-real-estat-dewasa-pertengahan-menggunakan-tablet-digital-di-rumah.webp?a=1&b=1&s=612x612&w=0&k=20&c=sisL930LLYe0ljBIg8JbZxkake4GrvNdLbKhz7FbqM4=" />
			</div>
			<div class="world__text">
				<?php
				get_template_part(
					'template-parts/section-head',
					null,
					array(
						'title' => __( "Explore Estatein's World", 'estatein' ),
						'text'  => __( 'Step inside the world of Estatein, where professionalism meets warmth, and expertise meets passion. Our gallery offers a glimpse into our team and workspaces, inviting you to get to know us better.', 'estatein' ),
					)
				);
				?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
