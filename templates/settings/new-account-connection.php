<?php
/**
 * New account template.
 *
 * @var string $provider_name Provider name.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<input type="text" name="apikey" class="wpforms-required"
	placeholder="<?php printf( /* translators: %s - current provider name. */ esc_attr__( '%s API Key *', 'wpforms-mailchimp' ), esc_html( $provider_name ) ); ?>">
<input type="text" name="label"
	placeholder="<?php printf( /* translators: %s - current provider name. */ esc_attr__( '%s Account Nickname', 'wpforms-mailchimp' ), esc_html( $provider_name ) ); ?>">
<p class="description">
	<?php
	printf(
		wp_kses(
			/* translators: %s - URL to the WPForms Mailchimp Addon page. */
			__( 'The API Key can be found in your Mailchimp account settings. <a href="%s" target="_blank" rel="noopener noreferrer">Learn More</a>.', 'wpforms-mailchimp' ),
			[
				'a' => [
					'href'   => [],
					'target' => [],
					'rel'    => [],
				],
			]
		),
		esc_url( wpforms_utm_link( 'https://wpforms.com/docs/install-use-mailchimp-addon-wpforms/#mailchimp-api', 'Integration Settings', 'Mailchimp Documentation' ) )
	);
	?>
</p>
<p class="error hidden">
	<?php esc_html_e( 'Something went wrong while performing an AJAX request.', 'wpforms-mailchimp' ); ?>
</p>
