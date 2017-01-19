<?php


if( ! class_exists( 'HooCore_Plugin' ) ) {
	class HooCore_Plugin {

		/**
		 * Plugin version, used for cache-busting of style and script file references.
		 *
		 * @since   1.0.0
		 *
		 * @var     string
		 */
		const VERSION = '2.0.0';

        /**
		 * @TODO - Rename "plugin-name" to the name your your plugin
		 *
		 * Unique identifier for your plugin.
		 *
		 *
		 * The variable name is used as the text domain when internationalizing strings
		 * of text. Its value should match the Text Domain file header in the main
		 * plugin file.
		 *
		 * @since    1.0.0
		 *
		 * @var      string
		 */
		protected $plugin_slug = 'singlepage';
		
		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		protected static $instance = null;
		
		/**
		 * Initialize the plugin by setting localization and loading public scripts
		 * and styles.
		 *
		 * @since     1.0.0
		 */
		private function __construct() {
		    define('SINGLEPAGE_LIB_HOO_URI', 'lib/hoo-core');
			define('HOO_TINYMCE_URI', SINGLEPAGE_LIB_HOO_URI . 'tinymce');
			define('HOO_TINYMCE_DIR', SINGLEPAGE_LIB_HOO_DIR .'tinymce');

			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));
			//add_action('admin_init', array(&$this, 'updater'));
			add_action('wp_ajax_hoo_shortcodes_popup', array(&$this, 'popup'));
		}
	
	

		/**
		 * Registers TinyMCE rich editor buttons
		 *
		 * @return	void
		 */
		 
		 
		function init() {
			if( ! is_admin() )
			{
				/*wp_enqueue_style( 'hoo-shortcodes', plugin_dir_url( __FILE__ ) . 'shortcodes.css' );
				wp_enqueue_script( 'jquery-ui-accordion' );
				wp_enqueue_script( 'jquery-ui-tabs' );*/
				wp_enqueue_script( 'hoo-shortcodes-lib', "", array('jquery', 'jquery-ui-accordion', 'jquery-ui-tabs') );
			}

			if ( get_user_option('rich_editing') == 'true' )
			{
				add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
				add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
			}

			$this->init_shortcodes();

		}
		
	
		// --------------------------------------------------------------------------	

		/**
		 * Find and include all shortcode classes within shortcodes folder
		 *
		 * @return void
		 */
		function init_shortcodes() {

			foreach( glob( SINGLEPAGE_LIB_HOO_DIR . 'shortcodes/*.php' ) as $filename ) {
				require_once $filename;
			}

		}

		// --------------------------------------------------------------------------

		/**
		 * Function to apply attributes to HTML tags.
		 * Devs can override attributes in a child theme by using the correct slug
		 *
		 *
		 * @param  string $slug       Slug to refer to the HTML tag
		 * @param  array  $attributes Attributes for HTML tag
		 * @return [type]             [description]
		 */
		public static function attributes( $slug, $attributes = array() ) {

			$out = '';
			$attr = apply_filters( "hoo_attr_{$slug}", $attributes );

			if ( empty( $attr ) ) {
				$attr['class'] = $slug;
			}

			foreach ( $attr as $name => $value ) {
				$out .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
			}

			return trim( $out );

		} // end attr()
		
		// --------------------------------------------------------------------------		
		
		/**
		 * Return an instance of this class.
		 *
		 * @since     1.0.0
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;

		}
		
		// --------------------------------------------------------------------------		
		
		/**
		 * Function to return animation classes for shortcodes mainly.
		 *
		 * @param  array  $args Animation type, direction and speed
		 * @return array        Array with data attributes
		 */
		public static function animations( $args = array() ) {

            $defaults = array(
            	'type' 		=> '',
            	'direction' => 'left',
            	'speed' 	=> '0.1',
            );

            $args = wp_parse_args( $args, $defaults );

			if( $args['type'] ) {

				$animation_attribues['animation_class'] = 'hoo-animated';

				if( $args['type'] != 'bounce' &&
					$args['type'] != 'flash' && 
					$args['type'] != 'shake'
				) {
					$direction_suffix = 'In' . ucfirst( $args['direction'] );
					$args['type'] .= $direction_suffix;
				}

				$animation_attribues['data-animationType'] = $args['type'];

				if( $args['speed'] ) {
					$animation_attribues['data-animationDuration'] = $args['speed'];
				}

				return $animation_attribues;

			}

		}
		
		// --------------------------------------------------------------------------		
		
		/**
		 * Function to get the default shortcode param values applied.
		 *
		 * @param  array  $args  Array with user set param values
		 * @return array  $defaults  Array with default param values
		 */
		public static function set_shortcode_defaults( $defaults, $args ) {
			
			if( ! $args ) {
				$$args = array();
			}
		
			$args = shortcode_atts( $defaults, $args );		
		
			foreach( $args as $key => $value ) {
				if( $value == '' || 
					$value == '|' 
				) {
					$args[$key] = $defaults[$key];
				}
			}

			return $args;
		
		}
		
		// --------------------------------------------------------------------------		
		
		/**
		 * Some helping fuctions
		 *
		 */
		public static function font_awesome_name_handler( $icon ) {
			$old_icons['arrow'] = 'angle-right';
			$old_icons['asterik'] = 'asterisk';
			$old_icons['cross'] = 'times';
			$old_icons['ban-circle'] = 'ban';
			$old_icons['bar-chart'] = 'bar-chart-o';
			$old_icons['beaker'] = 'flask';
			$old_icons['bell'] = 'bell-o';
			$old_icons['bell-alt'] = 'bell';
			$old_icons['bitbucket-sign'] = 'bitbucket-square';
			$old_icons['bookmark-empty'] = 'bookmark-o';
			$old_icons['building'] = 'building-o';
			$old_icons['calendar-empty'] = 'calendar-o';
			$old_icons['check-empty'] = 'square-o';
			$old_icons['check-minus'] = 'minus-square-o';
			$old_icons['check-sign'] = 'check-square';
			$old_icons['check'] = 'check-square-o';
			$old_icons['chevron-sign-down'] = 'chevron-circle-down';
			$old_icons['chevron-sign-left'] = 'chevron-circle-left';
			$old_icons['chevron-sign-right'] = 'chevron-circle-right';
			$old_icons['chevron-sign-up'] = 'chevron-circle-up';
			$old_icons['circle-arrow-down'] = 'arrow-circle-down';
			$old_icons['circle-arrow-left'] = 'arrow-circle-left';
			$old_icons['circle-arrow-right'] = 'arrow-circle-right';
			$old_icons['circle-arrow-up'] = 'arrow-circle-up';
			$old_icons['circle-blank'] = 'circle-o';
			$old_icons['cny'] = 'rub';
			$old_icons['collapse-alt'] = 'minus-square-o';
			$old_icons['collapse-top'] = 'caret-square-o-up';
			$old_icons['collapse'] = 'caret-square-o-down';
			$old_icons['comment-alt'] = 'comment-o';
			$old_icons['comments-alt'] = 'comments-o';
			$old_icons['copy'] = 'files-o';
			$old_icons['cut'] = 'scissors';
			$old_icons['dashboard'] = 'tachometer';
			$old_icons['double-angle-down'] = 'angle-double-down';
			$old_icons['double-angle-left'] = 'angle-double-left';
			$old_icons['double-angle-right'] = 'angle-double-right';
			$old_icons['double-angle-up'] = 'angle-double-up';
			$old_icons['download'] = 'arrow-circle-o-down';
			$old_icons['download-alt'] = 'download';
			$old_icons['edit-sign'] = 'pencil-square';
			$old_icons['edit'] = 'pencil-square-o';
			$old_icons['ellipsis-horizontal'] = 'ellipsis-h';
			$old_icons['ellipsis-vertical'] = 'ellipsis-v';
			$old_icons['envelope-alt'] = 'envelope-o';
			$old_icons['exclamation-sign'] = 'exclamation-circle';
			$old_icons['expand-alt'] = 'plus-square-o';
			$old_icons['expand'] = 'caret-square-o-right';
			$old_icons['external-link-sign'] = 'external-link-square';
			$old_icons['eye-close'] = 'eye-slash';
			$old_icons['eye-open'] = 'eye';
			$old_icons['facebook-sign'] = 'facebook-square';
			$old_icons['facetime-video'] = 'video-camera';
			$old_icons['file-alt'] = 'file-o';
			$old_icons['file-text-alt'] = 'file-text-o';
			$old_icons['flag-alt'] = 'flag-o';
			$old_icons['folder-close-alt'] = 'folder-o';
			$old_icons['folder-close'] = 'folder';
			$old_icons['folder-open-alt'] = 'folder-open-o';
			$old_icons['food'] = 'cutlery';
			$old_icons['frown'] = 'frown-o';
			$old_icons['fullscreen'] = 'arrows-alt';
			$old_icons['github-sign'] = 'github-square';
			$old_icons['google-plus-sign'] = 'google-plus-square';
			$old_icons['group'] = 'users';
			$old_icons['h-sign'] = 'h-square';
			$old_icons['hand-down'] = 'hand-o-down';
			$old_icons['hand-left'] = 'hand-o-left';
			$old_icons['hand-right'] = 'hand-o-right';
			$old_icons['hand-up'] = 'hand-o-up';
			$old_icons['hdd'] = 'hdd-o';
			$old_icons['heart-empty'] = 'heart-o';
			$old_icons['hospital'] = 'hospital-o';
			$old_icons['indent-left'] = 'outdent';
			$old_icons['indent-right'] = 'indent';
			$old_icons['info-sign'] = 'info-circle';
			$old_icons['keyboard'] = 'keyboard-o';
			$old_icons['legal'] = 'gavel';
			$old_icons['lemon'] = 'lemon-o';
			$old_icons['lightbulb'] = 'lightbulb-o';
			$old_icons['linkedin-sign'] = 'linkedin-square';
			$old_icons['meh'] = 'meh-o';
			$old_icons['microphone-off'] = 'microphone-slash';
			$old_icons['minus-sign-alt'] = 'minus-square';
			$old_icons['minus-sign'] = 'minus-circle';
			$old_icons['mobile-phone'] = 'mobile';
			$old_icons['moon'] = 'moon-o';
			$old_icons['move'] = 'arrows';
			$old_icons['off'] = 'power-off';
			$old_icons['ok-circle'] = 'check-circle-o';
			$old_icons['ok-sign'] = 'check-circle';
			$old_icons['ok'] = 'check';
			$old_icons['paper-clip'] = 'paperclip';
			$old_icons['paste'] = 'clipboard';
			$old_icons['phone-sign'] = 'phone-square';
			$old_icons['picture'] = 'picture-o';
			$old_icons['pinterest-sign'] = 'pinterest-square';
			$old_icons['play-circle'] = 'play-circle-o';
			$old_icons['play-sign'] = 'play-circle';
			$old_icons['plus-sign-alt'] = 'plus-square';
			$old_icons['plus-sign'] = 'plus-circle';
			$old_icons['pushpin'] = 'thumb-tack';
			$old_icons['question-sign'] = 'question-circle';
			$old_icons['remove-circle'] = 'times-circle-o';
			$old_icons['remove-sign'] = 'times-circle';
			$old_icons['remove'] = 'times';
			$old_icons['reorder'] = 'bars';
			$old_icons['resize-full'] = 'expand';
			$old_icons['resize-horizontal'] = 'arrows-h';
			$old_icons['resize-small'] = 'compress';
			$old_icons['resize-vertical'] = 'arrows-v';
			$old_icons['rss-sign'] = 'rss-square';
			$old_icons['save'] = 'floppy-o';
			$old_icons['screenshot'] = 'crosshairs';
			$old_icons['share-alt'] = 'share';
			$old_icons['share-sign'] = 'share-square';
			$old_icons['share'] = 'share-square-o';
			$old_icons['sign-blank'] = 'square';
			$old_icons['signin'] = 'sign-in';
			$old_icons['signout'] = 'sign-out';
			$old_icons['smile'] = 'smile-o';
			$old_icons['sort-by-alphabet-alt'] = 'sort-alpha-desc';
			$old_icons['sort-by-alphabet'] = 'sort-alpha-asc';
			$old_icons['sort-by-attributes-alt'] = 'sort-amount-desc';
			$old_icons['sort-by-attributes'] = 'sort-amount-asc';
			$old_icons['sort-by-order-alt'] = 'sort-numeric-desc';
			$old_icons['sort-by-order'] = 'sort-numeric-asc';
			$old_icons['sort-down'] = 'sort-asc';
			$old_icons['sort-up'] = 'sort-desc';
			$old_icons['stackexchange'] = 'stack-overflow';
			$old_icons['star-empty'] = 'star-o';
			$old_icons['star-half-empty'] = 'star-half-o';
			$old_icons['sun'] = 'sun-o';
			$old_icons['thumbs-down-alt'] = 'thumbs-o-down';
			$old_icons['thumbs-up-alt'] = 'thumbs-o-up';
			$old_icons['time'] = 'clock-o';
			$old_icons['trash'] = 'trash-o';
			$old_icons['tumblr-sign'] = 'tumblr-square';
			$old_icons['twitter-sign'] = 'twitter-square';
			$old_icons['unlink'] = 'chain-broken';
			$old_icons['upload'] = 'arrow-circle-o-up';
			$old_icons['upload-alt'] = 'upload';
			$old_icons['warning-sign'] = 'exclamation-triangle';
			$old_icons['xing-sign'] = 'xing-square';
			$old_icons['youtube-sign'] = 'youtube-square';
			$old_icons['zoom-in'] = 'search-plus';
			$old_icons['zoom-out'] = 'search-minus';

			if( substr( $icon, 0, 5 ) == 'icon-' || substr( $icon, 0, 3 ) != 'fa-' ) {
				$icon = str_replace( 'icon-', 'fa-', $icon );
			
				if( array_key_exists( str_replace( 'fa-', '', $icon ), $old_icons ) ) {
					$fa_icon = 'fa-' . $old_icons[str_replace( 'fa-', '', $icon )];
				} else {
                    if( substr( $icon, 0, 3 ) != 'fa-' ) {
                        $fa_icon = 'fa-' . $icon;
                    } else {
                        $fa_icon = $icon;
                    }
				}
			} elseif( substr( $icon, 0, 3 ) != 'fa-' ) {
				$fa_icon = 'fa-' . $icon;
			} else {
				$fa_icon = $icon;
			}

			return $fa_icon;
		}  			 
		 
		public static function order_array_like_array( Array $to_be_ordered, Array $order_like ) {
			$ordered = array();

			foreach( $order_like as $key ) {
				if( array_key_exists( $key, $to_be_ordered ) ) {
					$ordered[$key] = $to_be_ordered[$key];
					unset( $to_be_ordered[$key] );
				}
			}

			return $ordered + $to_be_ordered;
		}  		 
		 
		public static function get_attachment_id_from_url( $attachment_url = '' ) {
			global $wpdb;
			$attachment_id = false;

			if ( $attachment_url == '' ) {
				return;
			}

			$upload_dir_paths = wp_upload_dir();

			// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
			if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

				// If this is the URL of an auto-generated thumbnail, get the URL of the original image
				$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

				// Remove the upload path base directory from the attachment URL
				$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

				// Run a custom database query to get the attachment ID from the modified attachment URL
				$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
			}
			return $attachment_id;
		}


		public static function hex2rgb( $hex ) {
		   $hex = str_replace( "#", "", $hex );

		   if( strlen( $hex ) == 3 ) {
			  $r = hexdec( substr( $hex, 0, 1 ).substr($hex, 0, 1 ) );
			  $g = hexdec( substr( $hex, 1, 1).substr( $hex, 1, 1 ) );
			  $b = hexdec( substr( $hex, 2, 1).substr( $hex, 2, 1 ) );
		   } else {
			  $r = hexdec( substr( $hex, 0, 2 ) );
			  $g = hexdec( substr( $hex, 2, 2 ) ) ;
			  $b = hexdec( substr( $hex, 4, 2 ) );
		   }
		   $rgb = array( $r, $g, $b );

		   return $rgb; // returns an array with the rgb values
		}
		
		public static function rgb2hsl( $hex_color ) {

			$hex_color    = str_replace( '#', '', $hex_color );

			if( strlen( $hex_color ) < 3 ) {
				str_pad( $hex_color, 3 - strlen( $hex_color ), '0' );
			}

			$add         = strlen( $hex_color ) == 6 ? 2 : 1;
			$aa          = 0;
			$add_on      = $add == 1 ? ( $aa = 16 - 1 ) + 1 : 1;

			$red         = round( ( hexdec( substr( $hex_color, 0, $add ) ) * $add_on + $aa ) / 255, 6 );
			$green       = round( ( hexdec( substr( $hex_color, $add, $add ) ) * $add_on + $aa ) / 255, 6 );
			$blue        = round( ( hexdec( substr( $hex_color, ( $add + $add ) , $add ) ) * $add_on + $aa ) / 255, 6 );

			$hsl_color    = array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

			$minimum     = min( $red, $green, $blue );
			$maximum     = max( $red, $green, $blue );

			$chroma      = $maximum - $minimum;

			$hsl_color['lum'] = ( $minimum + $maximum ) / 2;

			if( $chroma == 0 ) {
				$hsl_color['lum'] = round( $hsl_color['lum'] * 100, 0 );

				return $hsl_color;
			}

			$range = $chroma * 6;

			$hsl_color['sat'] = $hsl_color['lum'] <= 0.5 ? $chroma / ( $hsl_color['lum'] * 2 ) : $chroma / ( 2 - ( $hsl_color['lum'] * 2 ) );

			if( $red <= 0.004 || 
				$green <= 0.004 || 
				$blue <= 0.004 
			) {
				$hsl_color['sat'] = 1;
			}

			if( $maximum == $red ) {
				$hsl_color['hue'] = round( ( $blue > $green ? 1 - ( abs( $green - $blue ) / $range ) : ( $green - $blue ) / $range ) * 255, 0 );
			} else if( $maximum == $green ) {
				$hsl_color['hue'] = round( ( $red > $blue ? abs( 1 - ( 4 / 3 ) + ( abs ( $blue - $red ) / $range ) ) : ( 1 / 3 ) + ( $blue - $red ) / $range ) * 255, 0 );
			} else {
				$hsl_color['hue'] = round( ( $green < $red ? 1 - 2 / 3 + abs( $red - $green ) / $range : 2 / 3 + ( $red - $green ) / $range ) * 255, 0 );
			}

			$hsl_color['sat'] = round( $hsl_color['sat'] * 100, 0 );
			$hsl_color['lum']  = round( $hsl_color['lum'] * 100, 0 );

			return $hsl_color;
		}		

		public static function calc_color_brightness( $color ) {
		
			if( strtolower( $color ) == 'black' ||
				strtolower( $color ) == 'navy' ||
				strtolower( $color ) == 'purple' ||
				strtolower( $color ) == 'maroon' ||
				strtolower( $color ) == 'indigo' ||
				strtolower( $color ) == 'darkslategray' ||
				strtolower( $color ) == 'darkslateblue' ||
				strtolower( $color ) == 'darkolivegreen' ||
				strtolower( $color ) == 'darkgreen' ||
				strtolower( $color ) == 'darkblue' 
			) {
				$brightness_level = 0;
			} elseif( strpos( $color, '#' ) === 0 ) {
				$color = self::hex2rgb( $color );

				$brightness_level = sqrt( pow( $color[0], 2) * 0.299 + pow( $color[1], 2) * 0.587 + pow( $color[2], 2) * 0.114 );			
			} else {
				$brightness_level = 150;
			}

			return $brightness_level;
		}		

		// --------------------------------------------------------------------------

		/**
		 * Defins TinyMCE rich editor js plugin
		 *
		 * @return	void
		 */
		function add_rich_plugins( $plugin_array )
		{

			return $plugin_array;
		}

		// --------------------------------------------------------------------------

		/**
		 * Adds TinyMCE rich editor buttons
		 *
		 * @return	void
		 */
		function register_rich_buttons( $buttons )
		{
			array_push( $buttons, 'hoo_button' );
			return $buttons;
		}

		/**
		 * Enqueue Scripts and Styles
		 *
		 * @return	void
		 */
		function admin_init()
		{
			// css
			wp_enqueue_style( 'hoo-popup', HOO_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
			wp_enqueue_style( 'jquery.chosen', HOO_TINYMCE_URI . '/css/chosen.css', false, '1.0', 'all' );
			wp_enqueue_style( 'font-awesome', SINGLEPAGE_THEME_URI . 'css/font-awesome.css', false, '4.2.0', 'all' );
			wp_enqueue_style( 'wp-color-picker' );

			// js
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-livequery', HOO_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
			wp_enqueue_script( 'jquery-appendo', HOO_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
			wp_enqueue_script( 'base64', HOO_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
			wp_enqueue_script( 'jquery.chosen', HOO_TINYMCE_URI . '/js/chosen.jquery.min.js', false, '1.0', false );
			wp_enqueue_script( 'wp-color-picker' );

			wp_enqueue_script( 'hoo-popup', HOO_TINYMCE_URI . '/js/popup.js', false, '1.0', false );

			// Developer mode
			$dev_mode = current_theme_supports( 'hoo_shortcodes_embed' );
			if( $dev_mode ) {
				$dev_mode = 'true';
			} else {
				$dev_mode = 'false';
			}

			wp_localize_script( 'hoo-popup', 'HooShortcodes', array('plugin_folder' => SINGLEPAGE_LIB_HOO_URI, 'dev' => $dev_mode) );
		}

		/**
		 * Popup function which will show shortcode options in thickbox.
		 *
		 * @return void
		 */
		function popup() {
	

			require_once( HOO_TINYMCE_DIR . '/hoo-sc.php' );

			die();

		}


	}
}
// Load the instance of the plugin
add_action( 'after_setup_theme', array( 'HooCore_Plugin', 'get_instance' ) );



/*----------------------------------------------------------------------------*
 * Register custom post types
 *----------------------------------------------------------------------------*/
add_action( 'init', 'singlepage_register_post_types' );
function singlepage_register_post_types() {
	
    $portfolio_slug = of_get_option("portfolio_slug");
	$portfolio_slug = $portfolio_slug?$portfolio_slug:"portfolio";
	register_post_type(
		'singlepage_portfolio',
		array(
			'labels' => array(
				'name' 			=> 'Portfolio',
				'singular_name' => 'Portfolio'
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array(
				'slug' => $portfolio_slug
			),
			'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
			'can_export' => true,
		)
	);

	register_taxonomy('portfolio_category', 'singlepage_portfolio', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));
	register_taxonomy('portfolio_skills', 'singlepage_portfolio', array('hierarchical' => true, 'label' => 'Skills', 'query_var' => true, 'rewrite' => true));
	register_taxonomy('portfolio_tags', 'singlepage_portfolio', array('hierarchical' => false, 'label' => 'Tags', 'query_var' => true, 'rewrite' => true));

/*	register_post_type(
		'singlepage_faq',
		array(
			'labels' => array(
				'name' => 'FAQs',
				'singular_name' => 'FAQ'
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'faq-items'),
			'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
			'can_export' => true,
		)
	);

	register_taxonomy('faq_category', 'singlepage_faq', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));*/


}

add_action( 'admin_menu', 'singlepage_admin_menu' );
function singlepage_admin_menu() {
	global $submenu;

	unset( $submenu['edit.php?post_type=themehoo_elastic'][10] );
}

/*----------------------------------------------------------------------------*
* Remove extra P tags
*----------------------------------------------------------------------------*/
function singlepage_shortcodes_formatter($content) {
	$block = join("|",array("youtube", "vimeo", "soundcloud", "button", "dropcap", "highlight", "checklist", "tabs", "tab", "accordian", "toggle", "one_half", "one_third", "one_fourth", "two_third", "three_fourth", "tagline_box", "pricing_table", "pricing_column", "pricing_price", "pricing_row", "pricing_footer", "content_boxes", "content_box", "slider", "slide", "testimonials", "testimonial", "progress", "person", "recent_posts", "recent_works", "alert", "fontawesome", "social_links", "clients", "client", "title", "separator", "tooltip", "fullwidth", "map", "counters_circle", "counter_circle", "counters_box", "counter_box", "flexslider", "blog", "imageframe", "images", "image", "sharing", "featured_products_slider", "products_slider", "menu_anchor", 'flip_boxes', 'flip_box'));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}

add_filter('the_content', 'singlepage_shortcodes_formatter');
add_filter('widget_text', 'singlepage_shortcodes_formatter');

if( ! function_exists('tf_content') ) {
	function tf_content($limit, $strip_html) {
		global $smof_data, $more;

		$content = '';

		if(!$limit && $limit != 0) {
			$limit = 285;
		}

		$limit = (int) $limit;

		$test_strip_html = $strip_html;

		if($strip_html == "true" || $strip_html == true) {
			$test_strip_html = true;
		} else {
			$test_strip_html = false;
		}
		
		$custom_excerpt = false;

		$post = get_post(get_the_ID());

		$pos = strpos($post->post_content, '<!--more-->');

		if($smof_data['link_read_more']) {
			$readmore = ' <a href="'.get_permalink( get_the_ID() ).'">&#91;...&#93;</a>';
		} else {
			$readmore = ' &#91;...&#93;';
		}

		if($smof_data['disable_excerpts']) {
			$readmore = '';
		}

		if($test_strip_html) {
			$more = 0;
			$raw_content = strip_tags( get_the_content( $readmore ) );
			
			if( $post->post_excerpt ||
				$pos !== false
			) {
				$more = 0;
				if( ! $pos ) {
					$raw_content = strip_tags( rtrim( get_the_excerpt(), '[&hellip;]' ) . $readmore );
				}
				$custom_excerpt = true;
			}
		} else {
			$more = 0;
			$raw_content = get_the_content( $readmore );
			if( $post->post_excerpt ||
				$pos !== false
			) {
				$more = 0;
				if( ! $pos ) {
					$raw_content = rtrim( get_the_excerpt(), '[&hellip;]' ) . $readmore;
				}
				$custom_excerpt = true;
			}
		}

		if($raw_content && $custom_excerpt == false) {

			$pattern = get_shortcode_regex();
			$content = preg_replace_callback("/$pattern/s", 'singlepage_process_tag', $raw_content);

			if( $smof_data['excerpt_base'] == 'Characters' ) {
				$content = mb_substr($content, 0, $limit);
				if( $limit != 0 && 
					! $smof_data['disable_excerpts']
				) {
					$content .= $readmore;
				}
			} else {
				$content = explode(' ', $content, $limit);
				if( count( $content ) >= $limit ) {
					array_pop($content);
					if($smof_data['disable_excerpts']) {
						$content = implode(" ",$content);
					} else {
						$content = implode(" ",$content);
					if($limit != 0) {
							if($smof_data['link_read_more']) {
								$content .= $readmore;
							} else {
								$content .= $readmore;
							}
						}
					}
				} else {
					$content = implode(" ",$content);
				}
			}

			if( $limit != 0 ) {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
			}

			$strip_html_class = '';
			if($test_strip_html) {
				$strip_html_class = 'strip-html';
			}
			$content = sprintf( '<div class="excerpt-container %s">%s</div>', $strip_html_class, do_shortcode( $content ) );

			return $content;
		}

		if($custom_excerpt == true) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback("/$pattern/s", 'singlepage_process_tag', $raw_content);		
			if( $test_strip_html == true ) {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$content = '<div class="excerpt-container strip-html">'.do_shortcode($content).'</div>';
			} else {
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
			}
		}

		if( has_excerpt() ) {
			$content = do_shortcode( get_the_excerpt() );
			$content = '<p>' . $content . '</p>';
		}

		return $content;
	}
}