<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_scripts(){

	wp_register_script('require', get_bloginfo('template_url') . '/js/vendor/requirejs/require.js', array(), false, true);
	wp_enqueue_script('require');

	/* LOCAL */
	/*
	wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
	wp_enqueue_script('global');
	wp_register_script('livereload', 'http://realonline.imareal.sbg.ac.at.local:35729/livereload.js?snipver=1', null, false, true);
	wp_enqueue_script('livereload');
	*/

	/* PRODUCTION */
	wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
//    wp_register_script('global', get_bloginfo('template_url') . '/js/optimized.min.js', array('require'), false, true);
	wp_enqueue_script('global');


	wp_enqueue_style('global', get_bloginfo('template_url') . '/css/global.css');
}

//Add Featured Image Support
add_theme_support('post-thumbnails');

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

function register_menus() {
	register_nav_menus(
		array(
			'main-nav' => 'Main Navigation',
			'footer-nav' => 'Footer Navigation',
			'language-nav' => 'Language Navigation'
		)
	);
}
add_action( 'init', 'register_menus' );

// remove unused functionality
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


function get_product_by_sku( $sku ) {

	global $wpdb;

	$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

	return $product_id;

}

function add_product( $request ) {
	
	$product = json_decode($request->get_body(), true);
	
	$product_id =get_product_by_sku($product['archivnr']);
	
	if( $product_id == null ){
		
		$variation = array(
				'post_title'   => $product['bildthema'],
				'post_content' => '',
				'post_status'  => 'publish',
				'post_parent' => '',
				'post_type'    => 'product'
		);
		
		$product_id = wp_insert_post( $variation );

		update_post_meta( $product_id, '_sku', $product['archivnr'] );
		update_post_meta( $product_id, '_price', '0' );
		
		wp_set_object_terms( $product_id, $product['archivnr'], 'pa_archivnummer', false);
		wp_set_object_terms( $product_id, $product['dianr'], 'pa_fotonummer', false);
		wp_set_object_terms( $product_id, $product['bildthema'], 'pa_bildthema', false);
		wp_set_object_terms( $product_id, $product['standort'], 'pa_standort', false);
		wp_set_object_terms( $product_id, $product['institution'], 'pa_institution', false);
		
		$product_attributes_data = array();
		$product_attributes_data['pa_archivnummer'] = array(
		
				'name'         => 'pa_archivnummer',
				'value'        => '',
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
		
		);
		$product_attributes_data['pa_fotonummer'] = array(
		
				'name'         => 'pa_fotonummer',
				'value'        => '',
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
		
		);
		$product_attributes_data['pa_bildthema'] = array(
		
				'name'         => 'pa_bildthema',
				'value'        => '',
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
		
		);
		$product_attributes_data['pa_standort'] = array(
		
				'name'         => 'pa_standort',
				'value'        => '',
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
		
		);
		$product_attributes_data['pa_institution'] = array(
		
				'name'         => 'pa_institution',
				'value'        => '',
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
		
		);
		update_post_meta( $product_id, '_product_attributes', $product_attributes_data );
		
		// Add Featured Image to Post
		$tmp_filename = explode(';', $product['dianr'])[0];
		$image_url  = 'http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/' . $tmp_filename . '.tif&WID=500&HEI=500&CVT=JPG';
		//$image_url  = 'http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/' . $tmp_filename . '.tif&WID=1000&HEI=1000&CVT=JPG';
		$upload_dir = wp_upload_dir(); // Set upload folder
		$image_data = file_get_contents($image_url); // Get image data
		$filename   = $tmp_filename . '.jpg'; // Create image file name
		
		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
		    $file = $upload_dir['path'] . '/' . $filename;
		} else {
		    $file = $upload_dir['basedir'] . '/' . $filename;
		}
		
		// Create the image  file on the server
		file_put_contents( $file, $image_data );
		
		// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );
		
		// Set attachment data
		$attachment = array(
		    'post_mime_type' => $wp_filetype['type'],
		    'post_title'     => sanitize_file_name( $filename ),
		    'post_content'   => '',
		    'post_status'    => 'inherit'
		);
		
		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		
		// Include image.php
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		
		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );
		
		// And finally assign featured image to post
		set_post_thumbnail( $product_id, $attach_id );
		
	}
	
	return $product_id;
}

function get_wishlists(){
	
	return WC_Wishlists_User::get_wishlists();
	
}

function store_search( $request ) {
	
	$body = json_decode($request->get_body(), true);
	
	$savings = $body['savings'];
	
	update_user_meta(get_current_user_id(), 'savings', $savings);
	
	return $savings;
}

function get_searches(){
	
	$searches = get_user_meta(get_current_user_id(), 'savings', true);
	
	if(!$searches){
		$searches = (object) array();
	}
	
	return $searches;
}

add_action( 'rest_api_init', function () {

	register_rest_route( 'imareal', '/product/add', array(
			'methods' => WP_REST_Server::EDITABLE,
			'callback' => 'add_product',
	) );
	
	register_rest_route( 'imareal', '/wishlists', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'get_wishlists',
	) );
	
	register_rest_route( 'imareal', '/searches/update', array(
			'methods' => WP_REST_Server::EDITABLE,
			'callback' => 'store_search',
	) );
	
	register_rest_route( 'imareal', '/searches', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'get_searches',
	) );
	
} );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function return_to_shop_url() {
	return get_permalink( get_page_by_path( '/suche' ) );
}
add_filter( 'woocommerce_return_to_shop_redirect', 'return_to_shop_url' );

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {

	$fields['billing']['billing_phone']['required'] = false;
	
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_state']);

	unset($fields['shipping']['shipping_company']);
	unset($fields['shipping']['shipping_address_2']);
	unset($fields['shipping']['shipping_state']);
	
	$fields['billing']['organisation_name'] = array(
		"label" => __("Institution / Firma")
	);
	$fields['billing']['organisation_uid'] = array(
		"label" => __("UID")
	);
	$fields['billing']['topic'] = array(
		"label" => __("Projektthema"),
		"required" => true
	);
	$fields['billing']['publikation'] = array(
			"label" => __("Publikation"),
			"required" => true,
			"type" => "select",
			"options" => array(
				'Nein' => 'Nein',
				'Ja' => 'Ja',
			)
	);
	$fields['billing']['publikation_author'] = array(
			"label" => __("Autor"),
			"required" => true
	);
	$fields['billing']['publikation_title'] = array(
			"label" => __("Titel"),
			"required" => true
	);
	$fields['billing']['publikation_verlag'] = array(
			"label" => __("Verlag"),
			"required" => true
	);
	$fields['billing']['publikation_auflage'] = array(
			"label" => __("Auflage"),
			"required" => true
	);
	$fields['billing']['comment'] = array(
			"label" => __("Anmerkungen"),
			"type" => "textarea"
	);

	return $fields;
}

add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['organisation_name'] ) ) {
        update_post_meta( $order_id, '_organisation_name', sanitize_text_field( $_POST['organisation_name'] ) );
        update_post_meta( $order_id, '_organisation_uid', sanitize_text_field( $_POST['organisation_uid'] ) );
        update_post_meta( $order_id, '_topic', sanitize_text_field( $_POST['topic'] ) );
        update_post_meta( $order_id, '_publikation', sanitize_text_field( $_POST['publikation'] ) );
        update_post_meta( $order_id, '_publikation_author', sanitize_text_field( $_POST['publikation_author'] ) );
        update_post_meta( $order_id, '_publikation_title', sanitize_text_field( $_POST['publikation_title'] ) );
        update_post_meta( $order_id, '_publikation_verlag', sanitize_text_field( $_POST['publikation_verlag'] ) );
        update_post_meta( $order_id, '_publikation_auflage', sanitize_text_field( $_POST['publikation_auflage'] ) );
        update_post_meta( $order_id, '_comment', sanitize_text_field( $_POST['comment'] ) );
    }
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__("Institution / Firma").':</strong> ' . get_post_meta( $order->id, '_organisation_name', true) . '</p>';
	echo '<p><strong>'.__("UID").':</strong> ' . get_post_meta( $order->id, '_organisation_uid', true) . '</p>';
	echo '<p><strong>'.__("Projektthema").':</strong> ' . get_post_meta( $order->id, '_topic', true) . '</p>';
	echo '<p><strong>'.__("Publikation").':</strong> ' . get_post_meta( $order->id, '_publikation', true) . '</p>';
	echo '<p><strong>'.__("Autor").':</strong> ' . get_post_meta( $order->id, '_publikation_author', true) . '</p>';
	echo '<p><strong>'.__("Titel").':</strong> ' . get_post_meta( $order->id, '_publikation_title', true) . '</p>';
	echo '<p><strong>'.__("Verlag").':</strong> ' . get_post_meta( $order->id, '_publikation_verlag', true) . '</p>';
	echo '<p><strong>'.__("Auflage").':</strong> ' . get_post_meta( $order->id, '_publikation_auflage', true) . '</p>';
	echo '<p><strong>'.__("Anmerkungen").':</strong> ' . get_post_meta( $order->id, '_comment', true) . '</p>';
}

add_filter('show_admin_bar', '__return_false');

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
            background-size: 320px 51px;
            width: 320px;
            height: 51px;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function loginpage_custom_link() {
	return get_bloginfo('url');
}
add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
	return get_bloginfo('name');
}
add_filter('login_headertitle', 'change_title_on_logo');

function insert_praeambel_checkout() {
	echo '<p>Die Fotos in REALonline wurden überwiegend von Fotografen des Instituts für Realienkunde des Mittelalters und der frühen Neuzeit aufgenommen. Als mit öffentlichen Mitteln finanzierte Institution stellen wir die erschlossenen Bildquellen in REALonline der Forschung sowie der interessierten Öffentlichkeit zur Verfügung. Vor allem für wissenschaftliche Zwecke können darüber hinaus digitale Bilddaten unter nachstehenden Bedingungen bestellt werden. Die Bearbeitungszeit Ihrer Anfrage und die Übermittlung der digitalen Bilddaten kann je nach Ressourcen der Mitarbeiter_innen des Instituts variieren.</p><p>Die Bilddateien werden am Server des IMAREAL bereitgestellt (&Uuml;bermittlung der Bilddateien in anderer Form auf Anfrage).</p>';

}

add_filter('checkout_praeambel', 'insert_praeambel_checkout');

// * Custom login form ** //
// Redirect to custom login
/*
$page_id = "";
$product_pages_args = array(
	'meta_key' => '_wp_page_template',
	'meta_value' => 'page-templates/login.php'
);

$product_pages = get_pages( $product_pages_args );

foreach ( $product_pages as $product_page ) {
	$page_id.= $product_page->ID;
}

function goto_login_page() {
	global $page_id;
	$login_page = home_url( '/?page_id='. $page_id. '/' );
	$page = basename($_SERVER['REQUEST_URI']);
	//echo "goto_login_page<br>";
	//var_dump($page_id);
	if( $page == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		wp_redirect($login_page);
		exit;
	}
}
add_action('init','goto_login_page');

function login_failed() {
	global $page_id;
	$login_page = home_url( '/?page_id='. $page_id. '/' );
	wp_redirect( $login_page . '&login=failed' );
	exit;
}
add_action( 'wp_login_failed', 'login_failed' );

function blank_username_password( $user, $username, $password ) {
	global $page_id;
	$login_page = home_url( '/?page_id='. $page_id. '/' );
	if( $username == "" || $password == "" ) {
		wp_redirect( $login_page . "&login=blank" );
		exit;
	}
}
add_filter( 'authenticate', 'blank_username_password', 1, 3);

//echo $login_page = $page_path ;

function logout_page() {
	global $page_id;
	$login_page = home_url( '/?page_id='. $page_id. '/' );
	wp_redirect( $login_page . "&login=false" );
	exit;
}
add_action('wp_logout', 'logout_page');

$page_showing = basename($_SERVER['REQUEST_URI']);

if (strpos($page_showing, 'failed') !== false) {
	echo '<p class="error-msg"><strong>ERROR:</strong> Invalid username and/or password.</p>';
}
elseif (strpos($page_showing, 'blank') !== false ) {
	echo '<p class="error-msg"><strong>ERROR:</strong> Username and/or Password is yet empty.</p>';
}

*/

// Custom login ends here.


/**
 * Outputs a rasio button form field
 */
function woocommerce_form_field_radio( $key, $args, $value = '' ) {
	global $woocommerce;
	$defaults = array(
			'type' => 'radio',
			'label' => '',
			'placeholder' => '',
			'required' => false,
			'class' => array( ),
			'label_class' => array( ),
			'return' => false,
			'options' => array( )
	);
	$args = wp_parse_args( $args, $defaults );
	if ( ( isset( $args[ 'clear' ] ) && $args[ 'clear' ] ) )
		$after = '<div class="clear"></div>';
		else
			$after = '';
			$required = ( $args[ 'required' ] ) ? ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>' : '';
			switch ( $args[ 'type' ] ) {
				case "select":
					$options = '';
					if ( !empty( $args[ 'options' ] ) )
						foreach ( $args[ 'options' ] as $option_key => $option_text )
							$options .= '<input type="radio" name="' . $key . '" id="' . $key . '" value="' . $option_key . '" ' . selected( $value, $option_key, false ) . 'class="select">' . $option_text . '' . "\r\n";
							$field = '<p id="' . $key . '_field">
<!--<label for="' . $key . '" class="' . implode( ' ', $args[ 'label_class' ] ) . '">' . $args[ 'label' ] . $required . '</label>-->
' . $options . '
</p>' . $after;
							break;
			} //$args[ 'type' ]
			if ( $args[ 'return' ] )
				return $field;
				else
					echo $field;
}
/**
 * Add the field to the checkout
 **/
add_action( 'woocommerce_after_checkout_billing_form', 'usage_field', 10 );
function usage_field( $checkout ) {
	echo '<div><h3 class="checkout-heading" id="checkout-heading-group">' . __( 'Verwendungsgruppen' ) . '</h3>';
	woocommerce_form_field_radio( 'usage', array(
			'type' => 'select',
			'class' => array(
				'usage form-row-wide to-checkbox'
			),
			'label' => __( '' ),
			'placeholder' => __( '' ),
			'required' => true,
			'options' => array(
				'Arbeitsfotos f&uuml;r wissenschaftliche Zwecke' => '<label for="usage">Arbeitsfotos f&uuml;r wissenschaftliche Zwecke </label><div class="wocommerce_checkout_imgfee">bis 10 Bilddateien frei, weitere auf Anfrage</div><br/>',
				'Unver&ouml;ffentlichte Dissertationen' => '<label for="usage"> Unver&ouml;ffentlichte Dissertationen </label><div class="wocommerce_checkout_imgfee">auf Anfrage</div><br/>',
				'Ver&ouml;ffentlichung im Rahmen &ouml;ffentlicher Vortr&auml;ge oder in wissenschaftlichen Publikationen (Auflage bis 1000 Exemplare)' => '<label for="usage"> Ver&ouml;ffentlichung im Rahmen &ouml;ffentlicher Vortr&auml;ge oder in wissenschaftlichen Publikatione</label><div class="wocommerce_checkout_imgfee"><b>Auflage bis 1000 Exemplare </b><br/>bis 4 Bilddateien frei, ab der 5. Bilddatei EUR 18,- pro Bilddatei</div><br/>',
				'Ver&ouml;ffentlichung in wissenschaftlichen Publikationen (Auflage ab 1000 Exemplare)' => '<label for="usage"> Ver&ouml;ffentlichung in wissenschaftlichen Publikationen</label><div class="wocommerce_checkout_imgfee"><b> Auflage ab 1000 Exemplare </b><br/>EUR 18,- pro Bilddatei</div><br/>',
				'Ver&ouml;ffentlichung in B&uuml;chern, Taschenb&uuml;chern, Schulb&uuml;chern, Periodika, Reisef&uuml;hrern, Bildb&auml;nden, etc.' => '<label for="usage"> Ver&ouml;ffentlichung in B&uuml;chern, Taschenb&uuml;chern, Schulb&uuml;chern, Periodika, Reisef&uuml;hrern, Bildb&auml;nden, etc. </label><div class="wocommerce_checkout_imgfee"><b>Auflage bis 1000:</b> Abbildungsformat bis Seite auf DIN A4 (in EUR) 1/4: 30,- | 1/2: 33,- | 1/1: 42,- | 2/1: 60,- <br><b>Auflage bis 5000:</b> Abbildungsformat bis Seite auf DIN A4 (in EUR) 1/4: 35,- | 1/2: 38,50 | 1/1: 49,- | 2/1: 70,- <br>Aufschläge für Cover, Kalender, Werbung (auf Anfrage)</div><br/>',
				'Ver&ouml;ffentlichung in Film und Fernsehen' => '<label for="usage"> Ver&ouml;ffentlichung in Film und Fernsehen </label><div class="wocommerce_checkout_imgfee">die erste Bilddatei EUR 75,- jede weitere Bilddatei EUR 30,- pro Bilddatei</div><br/>'

			)
	), $checkout->get_value( 'usage' ) );
	echo '</div>';
}
/**
 * Process the checkout
 **/
add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process' );
function my_custom_checkout_field_process( ) {
	global $woocommerce;
	// Check if set, if its not set add an error.
	if ( !$_POST[ 'usage' ] )
		wc_add_notice( __( 'Please specify a usage.' ), 'error' );
}
/**
 * Update the order meta with field value
 **/
add_action( 'woocommerce_checkout_update_order_meta', 'usage_field_update_order_meta' );
function usage_field_update_order_meta( $order_id ) {
	if ( $_POST[ 'usage' ] )
		update_post_meta( $order_id, 'Verwendungsgruppe', esc_attr( $_POST[ 'usage' ] ) );
}

/* rename checout link */
function woocommerce_button_proceed_to_checkout() {
	$checkout_url = WC()->cart->get_checkout_url();
	?>
	<a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Weiter zur Bestellung', 'woocommerce' ); ?></a>
	<?php
}

add_filter( 'woocommerce_enable_order_notes_field', '__return_true', 1);

/* Q-Translate-X */


?>

