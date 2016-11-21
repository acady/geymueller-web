<?php
/**
 * Email Styles
 *
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Load colours
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
#wrapper {
    background-color: <?php echo esc_attr( $bg ); ?>;
    margin: 0;
    padding: 70px 0 70px 0;
    -webkit-text-size-adjust: none !important;
    width: 100%;
}

#template_container {
    background: url('<?php echo get_template_directory_uri(); ?>/images/background/dp-white.png');
    background-color: <?php echo esc_attr( $body ); ?>;
    border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
}

#template_header {
    color: <?php echo esc_attr( $base ); ?>;
    border-bottom: 0;
    line-height: 100%;
    vertical-align: middle;
}

#template_header h1 {
    color: <?php echo esc_attr( $base ); ?>;
}

#body_content table td {
    padding: 30px 48px 48px 48px;
}

#body_content table td td {
    padding: 12px;
}

#body_content table td th {
    padding: 12px;
}

#body_content p {
    margin: 0 0 16px;
    text-align: center;
}

#body_content_inner {
    color: <?php echo esc_attr( $text_lighter_20 ); ?>;
    font-size: 14px;
    line-height: 150%;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
    color: <?php echo esc_attr( $text_lighter_20 ); ?>;
    border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
}

.text {
    color: <?php echo esc_attr( $text ); ?>;
    text-align: center;
}

.link {
    color: <?php echo esc_attr( $base ); ?>;
}

#header_wrapper {
    padding: 36px 48px 0 48px;
    display: block;
}

h1 {
    color: <?php echo esc_attr( $base ); ?>;
    font-weight: 300;
    text-transform: uppercase;
    font-size: 30px;
    line-height: 150%;
    margin: 0;
    text-align: center;
}

h2 {
    color: <?php echo esc_attr( $base ); ?>;
    display: block;
    font-weight: 300;
    text-transform: uppercase;
    font-size: 18px;
    line-height: 130%;
    margin: 16px 0 8px;
    text-align: center;
}

h3 {
    color: <?php echo esc_attr( $base ); ?>;
    display: block;
    font-weight: 300;
    text-transform: uppercase;
    font-size: 16px;
    line-height: 130%;
    margin: 16px 0 8px;
    text-align: center;
}

a {
    color: <?php echo esc_attr( $base ); ?>;
    text-decoration: underline;
}

img {
    border: none;
    display: inline;
    font-size: 14px;
    height: auto;
    line-height: 100%;
    outline: none;
    text-decoration: none;
    text-transform: capitalize;
}
<?php
