<?php
/**
 * Services page (used by the page with the slug "services").
 *
 * @package Estatein
 */

get_header();

$contact_url = estatein_page_url( 'contact' );

/*
 * The first two groups share a layout: four service cards followed by a
 * wide call-to-action card. Each service is array( icon, title, text ).
 */
$groups = array(
	array(
		'id'       => 'valuation',
		'title'    => __( 'Unlock Property Value', 'estatein' ),
		'text'     => __( 'Selling your property should be a rewarding experience, and at Estatein, we make sure it is. Our Property Selling Service is designed to maximize the value of your property, ensuring you get the best deal possible. Explore the categories below to see how we can help you at every step of your selling journey', 'estatein' ),
		'services' => array(
			array( 'feature-value', __( 'Valuation Mastery', 'estatein' ), __( 'Discover the true worth of your property with our expert valuation services.', 'estatein' ) ),
			array( 'feature-invest', __( 'Strategic Marketing', 'estatein' ), __( 'Selling a property requires more than just a listing; it demands a strategic marketing approach.', 'estatein' ) ),
			array( 'feature-management', __( 'Negotiation Wizardry', 'estatein' ), __( 'Negotiating the best deal is an art, and our negotiation experts are masters of it.', 'estatein' ) ),
			array( 'feature-home', __( 'Closing Success', 'estatein' ), __( 'A successful sale is not complete until the closing. We guide you through the intricate closing process.', 'estatein' ) ),
		),
		'cta'      => array(
			__( 'Unlock the Value of Your Property Today', 'estatein' ),
			__( 'Ready to unlock the true value of your property? Explore our Property Selling Service categories and let us help you achieve the best deal possible for your valuable asset.', 'estatein' ),
		),
	),
	array(
		'id'       => 'management',
		'title'    => __( 'Effortless Property Management', 'estatein' ),
		'text'     => __( "Owning a property should be a pleasure, not a hassle. Estatein's Property Management Service takes the stress out of property ownership, offering comprehensive solutions tailored to your needs. Explore the categories below to see how we can make property management effortless for you", 'estatein' ),
		'services' => array(
			array( 'feature-home', __( 'Tenant Harmony', 'estatein' ), __( 'Our Tenant Management services ensure that your tenants have a smooth and reducing vacancies.', 'estatein' ) ),
			array( 'feature-management', __( 'Maintenance Ease', 'estatein' ), __( 'Say goodbye to property maintenance headaches. We handle all aspects of property upkeep.', 'estatein' ) ),
			array( 'feature-value', __( 'Financial Peace of Mind', 'estatein' ), __( 'Managing property finances can be complex. Our financial experts take care of rent collection', 'estatein' ) ),
			array( 'feature-invest', __( 'Legal Guardian', 'estatein' ), __( 'Stay compliant with property laws and regulations effortlessly.', 'estatein' ) ),
		),
		'cta'      => array(
			__( 'Experience Effortless Property Management', 'estatein' ),
			__( 'Ready to experience hassle-free property management? Explore our Property Management Service categories and let us handle the complexities while you enjoy the benefits of property ownership.', 'estatein' ),
		),
	),
);

$investment = array(
	array( 'feature-value', __( 'Market Insight', 'estatein' ), __( 'Stay ahead of market trends with our expert Market Analysis. We provide in-depth insights into real estate market conditions', 'estatein' ) ),
	array( 'feature-invest', __( 'ROI Assessment', 'estatein' ), __( 'Make investment decisions with confidence. Our ROI Assessment services evaluate the potential returns on your investments', 'estatein' ) ),
	array( 'feature-home', __( 'Customized Strategies', 'estatein' ), __( 'Every investor is unique, and so are their goals. We develop Customized Investment Strategies tailored to your specific needs', 'estatein' ) ),
	array( 'feature-management', __( 'Diversification Mastery', 'estatein' ), __( 'Diversify your real estate portfolio effectively. Our experts guide you in spreading your investments across various property types and locations', 'estatein' ) ),
);

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'title' => __( 'Elevate Your Real Estate Experience', 'estatein' ),
		'text'  => __( 'Welcome to Estatein, where your real estate aspirations meet expert guidance. Explore our comprehensive range of services, each designed to cater to your unique needs and dreams.', 'estatein' ),
	)
);
get_template_part( 'template-parts/features', null, array( 'items' => estatein_service_tiles() ) );
?>

<?php foreach ( $groups as $group ) : ?>
	<section class="section container" id="<?php echo esc_attr( $group['id'] ); ?>">
		<?php get_template_part( 'template-parts/section-head', null, $group ); ?>
		<div class="service-grid">
			<?php
			foreach ( $group['services'] as $service ) {
				get_template_part(
					'template-parts/service-card',
					null,
					array(
						'icon'  => $service[0],
						'title' => $service[1],
						'text'  => $service[2],
					)
				);
			}
			?>
			<article class="card service-cta">
				<header class="service-cta__head">
					<h3 class="card__title"><?php echo esc_html( $group['cta'][0] ); ?></h3>
					<a class="btn btn--dark" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
				</header>
				<p class="lead"><?php echo esc_html( $group['cta'][1] ); ?></p>
			</article>
		</div>
	</section>
<?php endforeach; ?>

<section class="section container invest" id="investment">
	<div class="invest__intro">
		<?php
		get_template_part(
			'template-parts/section-head',
			null,
			array(
				'title' => __( 'Smart Investments, Informed Decisions', 'estatein' ),
				'text'  => __( "Building a real estate portfolio requires a strategic approach. Estatein's Investment Advisory Service empowers you to make smart investments and informed decisions.", 'estatein' ),
			)
		);
		?>
		<article class="card service-cta service-cta--stacked">
			<h3 class="card__title"><?php esc_html_e( 'Unlock Your Investment Potential', 'estatein' ); ?></h3>
			<p class="lead"><?php esc_html_e( 'Explore our Property Management Service categories and let us handle the complexities while you enjoy the benefits of property ownership.', 'estatein' ); ?></p>
			<a class="btn btn--dark" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
		</article>
	</div>
	<div class="invest__grid">
		<?php
		foreach ( $investment as $service ) {
			get_template_part(
				'template-parts/service-card',
				null,
				array(
					'icon'  => $service[0],
					'title' => $service[1],
					'text'  => $service[2],
				)
			);
		}
		?>
	</div>
</section>

<?php
get_footer();
