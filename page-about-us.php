<?php
/**
 * About Us page (used by the page with the slug "about-us").
 *
 * @package Estatein
 */

get_header();

$contact_url = estatein_page_url( 'contact' );
$story       = __( 'Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to create a real estate platform that transcended the ordinary.', 'estatein' );

$stats = array(
	'200+' => __( 'Happy Customers', 'estatein' ),
	'10k+' => __( 'Properties For Clients', 'estatein' ),
	'16+'  => __( 'Years of Experience', 'estatein' ),
);

// Each value is array( icon, title, text ).
$values = array(
	array( 'star', __( 'Trust', 'estatein' ), __( 'Trust is the cornerstone of every successful real estate transaction.', 'estatein' ) ),
	array( 'feature-value', __( 'Excellence', 'estatein' ), __( 'We set the bar high for ourselves. From the properties we list to the services we provide.', 'estatein' ) ),
	array( 'feature-home', __( 'Client-Centric', 'estatein' ), __( 'Your dreams and needs are at the center of our universe. We listen, understand.', 'estatein' ) ),
	array( 'star', __( 'Our Commitment', 'estatein' ), __( 'We are dedicated to providing you with the highest level of service, professionalism, and support.', 'estatein' ) ),
);

$achievements = array(
	__( '3+ Years of Excellence', 'estatein' ) => __( "With over 3 years in the industry, we've amassed a wealth of knowledge and experience, becoming a go-to resource for all things real estate.", 'estatein' ),
	__( 'Happy Clients', 'estatein' )          => __( 'Our greatest achievement is the satisfaction of our clients. Their success stories fuel our passion for what we do.', 'estatein' ),
	__( 'Industry Recognition', 'estatein' )   => __( "We've earned the respect of our peers and industry leaders, with accolades and awards that reflect our commitment to excellence.", 'estatein' ),
);

$steps = array(
	__( 'Discover a World of Possibilities', 'estatein' ) => __( 'Your journey begins with exploring our carefully curated property listings. Use our intuitive search tools to filter properties based on your preferences, including location, type, size, and budget.', 'estatein' ),
	__( 'Narrowing Down Your Choices', 'estatein' )       => __( "Once you've found properties that catch your eye, save them to your account or make a shortlist. This allows you to compare and revisit your favorites as you make your decision.", 'estatein' ),
	__( 'Personalized Guidance', 'estatein' )             => __( 'Have questions about a property or need more information? Our dedicated team of real estate experts is just a call or message away.', 'estatein' ),
	__( 'See It for Yourself', 'estatein' )               => __( "Arrange viewings of the properties you're interested in. We'll coordinate with the property owners and accompany you to ensure you get a firsthand look at your potential new home.", 'estatein' ),
	__( 'Making Informed Decisions', 'estatein' )         => __( 'Before making an offer, our team will assist you with due diligence, including property inspections, legal checks, and market analysis. We want you to be fully informed and confident in your choice.', 'estatein' ),
	__( 'Getting the Best Deal', 'estatein' )             => __( "We'll help you negotiate the best terms and prepare your offer. Our goal is to secure the property at the right price and on favorable terms.", 'estatein' ),
);

$team = array(
	'Max Mitchell'   => [ 'title' => __( 'Founder', 'estatein' ), 'photo' => 'https://media.istockphoto.com/id/165485484/id/foto/pengusaha-percaya-diri-terisolasi-di-latar-belakang-putih.jpg?s=612x612&w=0&k=20&c=0YaiIqFhBn-4HJKN0OF8YlzF2TW_2J4ul6LUi1bk9aE=' ],
	'Sarah Johnson'  => [ 'title' => __( 'Chief Real Estate Officer', 'estatein' ), 'photo' => 'https://media.istockphoto.com/id/185246998/id/foto/wanita-pengusaha-asia-kasual.jpg?s=612x612&w=0&k=20&c=d8V0rQRBi8HsjfXOVwar2KNXESvcu4G5-xQ2Kc4cxZI=' ],
	'David Brown'    => [ 'title' => __( 'Head of Property Management', 'estatein' ), 'photo' => 'https://media.istockphoto.com/id/629460362/id/foto/pengusaha-tersenyum-dengan-dokumen.jpg?s=612x612&w=0&k=20&c=AA9g1nrOh3644SXX1z-7eMZMOR5Zx4TkKkfBT6b_6TA=' ],
	'Michael Turner' => [ 'title' => __( 'Legal Counsel', 'estatein' ), 'photo' => 'https://media.istockphoto.com/id/2224533883/id/foto/potret-agen-real-estat-wanita-bahagia-berpose-di-ruang-tamu-modern.jpg?s=612x612&w=0&k=20&c=sPrtLqIMeB99fsAGML1PUx8MxqOBMhNG90fUPzE7qZA=' ],
);

$clients = array(
	array(
		'since'    => '2019',
		'name'     => 'ABC Corporation',
		'domain'   => __( 'Commercial Real Estate', 'estatein' ),
		'category' => __( 'Luxury Home Development', 'estatein' ),
		'quote'    => __( "Estatein's expertise in finding the perfect office space for our expanding operations was invaluable. They truly understand our business needs.", 'estatein' ),
	),
	array(
		'since'    => '2018',
		'name'     => 'GreenTech Enterprises',
		'domain'   => __( 'Commercial Real Estate', 'estatein' ),
		'category' => __( 'Retail Space', 'estatein' ),
		'quote'    => __( "Estatein's ability to identify prime retail locations helped us expand our brand presence. They are a trusted partner in our growth.", 'estatein' ),
	),
);
?>

<section class="section container journey" id="story">
	<div class="journey__content">
		<?php
		get_template_part(
			'template-parts/section-head',
			null,
			array(
				'title' => __( 'Our Journey', 'estatein' ),
				'text'  => $story . ' ' . __( "Over the years, we've expanded our reach, forged valuable partnerships, and gained the trust of countless clients.", 'estatein' ),
			)
		);
		?>
		<ul class="stats">
			<?php foreach ( $stats as $value => $label ) : ?>
				<li class="stats__item">
					<strong class="stats__value"><?php echo esc_html( $value ); ?></strong>
					<span class="stats__label"><?php echo esc_html( $label ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php // Photo slot: the design's image is not in the theme yet. ?>
	<div class="journey__media">
		<img class="journey__pattern" src="https://media.istockphoto.com/id/547451008/id/foto/rumah-di-tumpukan-uang.jpg?s=612x612&w=0&k=20&c=i9TbZylhuONdsXnxffmnVSc3IyW67vXXLnEBUtOuIg4="  alt="" aria-hidden="true">
	</div>
</section>

<section class="section container invest invest--values" id="values">
	<div class="invest__intro">
		<?php
		get_template_part(
			'template-parts/section-head',
			null,
			array(
				'title' => __( 'Our Values', 'estatein' ),
				'text'  => $story,
			)
		);
		?>
	</div>
	<div class="values">
		<?php
		foreach ( $values as $value ) {
			get_template_part(
				'template-parts/service-card',
				null,
				array(
					'icon'  => $value[0],
					'title' => $value[1],
					'text'  => $value[2],
				)
			);
		}
		?>
	</div>
</section>

<section class="section container" id="works">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Our Achievements', 'estatein' ),
			'text'  => $story,
		)
	);
	?>
	<div class="service-grid">
		<?php foreach ( $achievements as $title => $text ) : ?>
			<article class="card achievement">
				<h3 class="card__title"><?php echo esc_html( $title ); ?></h3>
				<p class="lead"><?php echo esc_html( $text ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="section container" id="how-it-works">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Navigating the Estatein Experience', 'estatein' ),
			'text'  => __( "At Estatein, we've designed a straightforward process to help you find and purchase your dream property with ease. Here's a step-by-step guide to how it all works.", 'estatein' ),
		)
	);
	$number = 0;
	?>
	<ol class="steps">
		<?php foreach ( $steps as $title => $text ) : ?>
			<li class="step">
				<?php /* translators: %s: step number. */ ?>
				<p class="step__label"><?php echo esc_html( sprintf( __( 'Step %s', 'estatein' ), zeroise( ++$number, 2 ) ) ); ?></p>
				<div class="step__body">
					<h3 class="card__title"><?php echo esc_html( $title ); ?></h3>
					<p class="lead"><?php echo esc_html( $text ); ?></p>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
</section>

<section class="section container" id="team">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Meet the Estatein Team', 'estatein' ),
			'text'  => __( 'At Estatein, our success is driven by the dedication and expertise of our team. Get to know the people behind our mission to make your real estate dreams a reality.', 'estatein' ),
		)
	);
	?>
	<div class="team">
		<?php foreach ( $team as $name => $role ) : ?>
			<article class="card member">
				
				<div class="member__photo">
					<img class="member__photo-img" src="<?php echo esc_url( $role['photo'] ); ?>" alt="<?php echo esc_attr( $name ); ?>">
					<a class="member__social" href="#" aria-label="<?php echo esc_attr( $name ); ?> — Twitter"><?php estatein_icon( 'twitter', 24 ); ?></a>
				</div>
				<div class="member__text">
					<h3 class="member__name"><?php echo esc_html( $name ); ?></h3>
					<p class="lead"><?php echo esc_html( $role['title'] ); ?></p>
				</div>
				<a class="member__hello" href="<?php echo esc_url( $contact_url ); ?>">
					<span><?php esc_html_e( 'Say Hello 👋', 'estatein' ); ?></span>
					<span class="member__send"><?php estatein_icon( 'send', 24.9898, 24.8354 ); ?></span>
				</a>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="section container" id="clients">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Our Valued Clients', 'estatein' ),
			'text'  => __( 'At Estatein, we have had the privilege of working with a diverse range of clients across various industries. Here are some of the clients we\'ve had the pleasure of serving', 'estatein' ),
		)
	);
	?>
	<div class="carousel" data-carousel>
		<div class="carousel__track carousel__track--two" data-carousel-track>
			<?php foreach ( $clients as $client ) : ?>
				<article class="card client">
					<header class="client__head">
						<div>
							<?php /* translators: %s: year. */ ?>
							<p class="lead"><?php echo esc_html( sprintf( __( 'Since %s', 'estatein' ), $client['since'] ) ); ?></p>
							<h3 class="office__address"><?php echo esc_html( $client['name'] ); ?></h3>
						</div>
						<a class="btn btn--muted" href="#"><?php esc_html_e( 'Visit Website', 'estatein' ); ?></a>
					</header>
					<dl class="client__facts">
						<div>
							<dt class="lead"><?php esc_html_e( 'Domain', 'estatein' ); ?></dt>
							<dd><?php echo esc_html( $client['domain'] ); ?></dd>
						</div>
						<div>
							<dt class="lead"><?php esc_html_e( 'Category', 'estatein' ); ?></dt>
							<dd><?php echo esc_html( $client['category'] ); ?></dd>
						</div>
					</dl>
					<blockquote class="client__quote">
						<p class="lead"><?php esc_html_e( 'What They Said 🤗', 'estatein' ); ?></p>
						<p><?php echo esc_html( $client['quote'] ); ?></p>
					</blockquote>
				</article>
			<?php endforeach; ?>
		</div>
		<?php get_template_part( 'template-parts/carousel-footer' ); ?>
	</div>
</section>

<?php
get_footer();
