<?php
/**
 * Inquiry form.
 *
 * Expects $args, one of:
 * - property: the selected property ("Title, Location"), on a property page;
 * - contact: true for the Contact page form (inquiry type, how you heard about us);
 * - neither, for the Properties page form with search preferences.
 *
 * @package Estatein
 */

$property = isset( $args['property'] ) ? $args['property'] : '';
$contact  = ! empty( $args['contact'] );
$status   = isset( $_GET['inquiry'] ) ? sanitize_key( $_GET['inquiry'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ranges   = estatein_filter_ranges();
$rooms    = array( '1', '2', '3', '4', '5+' );
?>
<form class="form<?php echo $property ? ' form--compact' : ''; ?><?php echo $contact ? ' form--contact' : ''; ?>" id="inquire" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<input type="hidden" name="action" value="estatein_inquiry">
	<?php wp_nonce_field( 'estatein_inquiry', 'estatein_inquiry_nonce' ); ?>
	<p class="form__trap" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>

	<?php if ( 'sent' === $status ) : ?>
		<p class="form__notice" role="status"><?php esc_html_e( 'Thank you. Your message has been sent and we will get back to you soon.', 'estatein' ); ?></p>
	<?php elseif ( 'error' === $status ) : ?>
		<p class="form__notice form__notice--error" role="alert"><?php esc_html_e( 'Your message could not be sent. Please enter your first name and a valid email, and accept the terms.', 'estatein' ); ?></p>
	<?php endif; ?>

	<div class="form__grid">
		<?php
		estatein_form_input( 'first_name', __( 'First Name', 'estatein' ), __( 'Enter First Name', 'estatein' ), 'text', true );
		estatein_form_input( 'last_name', __( 'Last Name', 'estatein' ), __( 'Enter Last Name', 'estatein' ) );
		estatein_form_input( 'email', __( 'Email', 'estatein' ), __( 'Enter your Email', 'estatein' ), 'email', true );
		estatein_form_input( 'phone', __( 'Phone', 'estatein' ), __( 'Enter Phone Number', 'estatein' ), 'tel' );
		?>

		<?php if ( $property ) : ?>
			<p class="field field--full">
				<label for="inquiry-property"><?php esc_html_e( 'Selected Property', 'estatein' ); ?></label>
				<span class="field__select">
					<input class="field__control field__control--readonly" id="inquiry-property" name="property" type="text" value="<?php echo esc_attr( $property ); ?>" readonly>
					<?php estatein_icon( 'pin-solid', 24 ); ?>
				</span>
			</p>
		<?php elseif ( $contact ) : ?>
			<?php
			estatein_form_select( 'inquiry_type', __( 'Inquiry Type', 'estatein' ), __( 'Select Inquiry Type', 'estatein' ), array( __( 'General Question', 'estatein' ), __( 'Buying a Property', 'estatein' ), __( 'Selling a Property', 'estatein' ), __( 'Property Management', 'estatein' ), __( 'Investment Advice', 'estatein' ) ) );
			estatein_form_select( 'heard_from', __( 'How Did You Hear About Us?', 'estatein' ), __( 'Select', 'estatein' ), array( __( 'Search Engine', 'estatein' ), __( 'Social Media', 'estatein' ), __( 'Friend or Family', 'estatein' ), __( 'Advertisement', 'estatein' ), __( 'Other', 'estatein' ) ) );
			?>
		<?php else : ?>
			<?php
			estatein_form_select( 'location', __( 'Preferred Location', 'estatein' ), __( 'Select Location', 'estatein' ), estatein_property_options( 'estatein_location' ) );
			estatein_form_select( 'property_type', __( 'Property Type', 'estatein' ), __( 'Select Property Type', 'estatein' ), estatein_property_options( 'estatein_type' ) );
			estatein_form_select( 'bathrooms', __( 'No. of Bathrooms', 'estatein' ), __( 'Select no. of Bathrooms', 'estatein' ), $rooms );
			estatein_form_select( 'bedrooms', __( 'No. of Bedrooms', 'estatein' ), __( 'Select no. of Bedrooms', 'estatein' ), $rooms );
			?>
			<div class="field--half">
				<?php estatein_form_select( 'budget', __( 'Budget', 'estatein' ), __( 'Select Budget', 'estatein' ), $ranges['price'] ); ?>
			</div>
			<fieldset class="field field--half">
				<legend><?php esc_html_e( 'Preferred Contact Method', 'estatein' ); ?></legend>
				<div class="contact-methods">
					<label class="contact-method">
						<?php estatein_icon( 'phone', 24 ); ?>
						<input class="contact-method__input" type="tel" name="contact_phone" placeholder="<?php esc_attr_e( 'Enter Your Number', 'estatein' ); ?>" aria-label="<?php esc_attr_e( 'Contact number', 'estatein' ); ?>">
						<input class="contact-method__radio" type="radio" name="contact_method" value="<?php esc_attr_e( 'Phone', 'estatein' ); ?>" checked aria-label="<?php esc_attr_e( 'Contact me by phone', 'estatein' ); ?>">
					</label>
					<label class="contact-method">
						<?php estatein_icon( 'mail-solid', 24 ); ?>
						<input class="contact-method__input" type="email" name="contact_email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'estatein' ); ?>" aria-label="<?php esc_attr_e( 'Contact email', 'estatein' ); ?>">
						<input class="contact-method__radio" type="radio" name="contact_method" value="<?php esc_attr_e( 'Email', 'estatein' ); ?>" aria-label="<?php esc_attr_e( 'Contact me by email', 'estatein' ); ?>">
					</label>
				</div>
			</fieldset>
		<?php endif; ?>

		<p class="field field--full">
			<label for="inquiry-message"><?php esc_html_e( 'Message', 'estatein' ); ?></label>
			<textarea class="field__control" id="inquiry-message" name="message" placeholder="<?php esc_attr_e( 'Enter your Message here..', 'estatein' ); ?>"></textarea>
		</p>
	</div>

	<div class="form__footer">
		<label class="checkbox">
			<input type="checkbox" name="agree" value="1" required>
			<span>
				<?php
				printf(
					/* translators: 1: Terms of Use link, 2: Privacy Policy link. */
					esc_html__( 'I agree with %1$s and %2$s', 'estatein' ),
					'<a href="' . esc_url( estatein_page_url( 'terms-and-conditions' ) ) . '">' . esc_html__( 'Terms of Use', 'estatein' ) . '</a>',
					'<a href="' . esc_url( estatein_page_url( 'privacy-policy' ) ) . '">' . esc_html__( 'Privacy Policy', 'estatein' ) . '</a>'
				);
				?>
			</span>
		</label>
		<button class="btn btn--primary form__submit" type="submit"><?php esc_html_e( 'Send Your Message', 'estatein' ); ?></button>
	</div>
</form>
