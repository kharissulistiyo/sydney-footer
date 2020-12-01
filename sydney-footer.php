<?php
/**
 * Sydney Footer
 *
 * @package     Sydney Footer
 * @author      kharisblank
 * @copyright   2020 kharisblank
 * @license     GPL-2.0+
 *
 * @sydney-footer
 * Plugin Name: Sydney Footer
 * Plugin URI:  https://easyfixwp.com/
 * Description: A simple plugin to add extra widgets area on Sydney theme footer.
 * Version:     0.0.6
 * Author:      kharisblank
 * Author URI:  https://easyfixwp.com
 * Text Domain: sydney-footer
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// Disallow direct access to file
defined( 'ABSPATH' ) or die( __('Not Authorized!', 'sydney-footer') );

define( 'SYDNEY_FOOTER_FILE', __FILE__ );
define( 'SYDNEY_FOOTER_URL', plugins_url( null, SYDNEY_FOOTER_FILE ) );


if ( ! function_exists( 'sydney_setup' ) ) :
 // return;
endif;


if ( !class_exists('Sydney_Footer') ) :
 class Sydney_Footer {

   public function __construct() {
     add_action('widgets_init', array($this, 'register_widgets_area'), 9999);
     add_action('sydney_after_footer', array($this, 'sydney_footer'), 9999);
     add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'), 9999 );
   }

   function register_widgets_area() {
     register_sidebar( array(
   		'name'          => __( 'Extra Footer', 'sydney-footer' ),
   		'id'            => 'footer-extra',
   		'description'   => '',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>',
   	) );

     do_action( 'sydney_extra_footer_area' );

   }

   function sydney_footer() {
     ?>
     <?php if ( is_active_sidebar( 'footer-extra' ) ) : ?>
       <div class="sydney-footer-extra footer-widgets widget-area" role="complementary">
           <div class="container">
             <div class="sidebar-column col-md-12">
   		        <?php
               do_action( 'sydney_before_extra_footer' );
               dynamic_sidebar( 'footer-extra');
               do_action( 'sydney_after_extra_footer' );
               ?>
             </div>
           </div>
       </div>
   	<?php endif; ?>
     <?php
   }

   function enqueue_scripts() {
     wp_register_style( 'sydney-footer-style', SYDNEY_FOOTER_URL . '/css/sydney-footer.css', array(), null );
     wp_register_script('sydney-footer-script',
                       SYDNEY_FOOTER_URL .'/js/sydney-footer.js',
                       array ('jquery'),
                       false, true);

     wp_enqueue_style( 'sydney-footer-style' );
     wp_enqueue_script( 'sydney-footer-script' );
   }

 }
endif;

new Sydney_Footer;
