<?php

/**
 * @package WordPress
 * @subpackage jackpine
 * @since jackpine 0.1.0
 */

require_once __DIR__ . '/vendor/autoload.php';

use Timber\Menu;
use Timber\Site;
use Timber\Timber;
use WPackio\Enqueue;

$timber = new Timber();

Timber::$dirname = 'templates';

class jackpine extends Site
{
    public $enqueue;

    public function __construct()
    {
        $this->enqueue = new Enqueue(
            'jackpine',
            'dist',
            '0.1.0',
            'theme'
        );

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);

        parent::__construct();
    }

    public function add_to_context($context)
    {
        $context['site'] = $this;
        // set menus
        $context['menu_primary'] = new Menu( 'primary' );
        $context['menu_secondary'] = new Menu( 'secondary' );
        $context['menu_social'] = new Menu( 'social' );
        $context['menu_footer'] = new Menu( 'footer' );
        $context['menu_mobile'] = new Menu( 'mobile' );
        // set custom logo
        $custom_logo_url = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
        $context['custom_logo_url'] = $custom_logo_url;
        // set home page
        $context['is_front_page'] = is_front_page();
        // set widgets
        $context['footer_area_one'] = Timber::get_widgets('footer_area_one');
        $context['footer_area_two'] = Timber::get_widgets('footer_area_two');
        $context['footer_area_three'] = Timber::get_widgets('footer_area_three');
        $context['footer_area_four'] = Timber::get_widgets('footer_area_four');


        return $context;
    }

    public function add_to_twig($twig)
    {
        return $twig;
    }

    public function theme_supports()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            ]
        );
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
        add_theme_support('custom-background');
        add_theme_support('customize-selective-refresh-widgets');
        // Gutenberg support
        add_theme_support( 'wp-block-styles' );
        add_theme_support('align-wide');
        add_theme_support( 'editor-styles' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support('experimental-custom-spacing');
        add_theme_support('experimental-link-color');
        // Add theme support for Custom Header
        $header_args = array(
            'default-image'          => '',
            'width'                  => 1600,
            'height'                 => 500,
            'flex-width'             => true,
            'flex-height'            => true,
            'uploads'                => true,
            'random-default'         => true,
            'header-text'            => true,
            'default-text-color'     => '#efefef',
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
            'video'                  => true,
            'video-active-callback'  => '',
        );
        add_theme_support( 'custom-header', $header_args );

        /** Removing the Website field from WordPress comments is a proven way to reduce spam */
        add_filter('comment_form_default_fields', 'remove_website_field');
        function remove_website_field($fields)
        {
            if (isset($fields['url'])) {
                unset($fields['url']);
            }
            return $fields;
        }

        /** Limit comment depth to two. If you need more, you will need to adjust the Tailwind styling */
        add_filter( 'thread_comments_depth_max', function( $max )
        {
            return 2;
        } );

    }

    public function enqueue_scripts()
    {
        $this->enqueue->enqueue('theme', 'styles', []);
        $this->enqueue->enqueue('theme', 'main', []);
    }
}

new jackpine();



// Register Navigation Menus
if ( ! function_exists( 'custom_navigation_menus' ) ) {
function custom_navigation_menus() {

    $locations = array(
        'primary' => __( 'Primary Nav', 'rchy' ),
        'secondary' => __( 'Secondary Nav', 'rchy' ),
        'social' => __( 'Social Media Nav', 'rchy' ),
        'footer' => __( 'Footer Nav', 'rchy' ),
        'mobile' => __( 'Mobile Nav', 'rchy' ),
    );
    register_nav_menus( $locations );

    }
add_action( 'init', 'custom_navigation_menus' );
}

// Register Sidebar Widgets
function register_widget_areas() {

    register_sidebar( array(
      'name'          => 'Footer area one',
      'id'            => 'footer_area_one',
      'description'   => 'Footer widgets',
      'before_widget' => '<section class="footer-area footer-area-one">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));

    register_sidebar( array(
      'name'          => 'Footer area two',
      'id'            => 'footer_area_two',
      'description'   => 'Footer widgets',
      'before_widget' => '<section class="footer-area footer-area-two">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));

    register_sidebar( array(
      'name'          => 'Footer area three',
      'id'            => 'footer_area_three',
      'description'   => 'Footer widgets',
      'before_widget' => '<section class="footer-area footer-area-three">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));

    register_sidebar( array(
      'name'          => 'Footer area four',
      'id'            => 'footer_area_four',
      'description'   => 'Footer widgets',
      'before_widget' => '<section class="footer-area footer-area-three">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
    ));

  }

add_action( 'widgets_init', 'register_widget_areas' );

//Allow shortcodes in widgets
add_filter ('widget_text', 'do_shortcode');
function year_shortcode () {
    $year = date_i18n ('Y');
    return $year;
    }
add_shortcode ('year', 'year_shortcode');

// Gutenberg theme color palette
// back-end display
function rchy_add_custom_gutenberg_color_palette() {
	add_theme_support(
		'editor-color-palette',
		[
			[
				'name'  => esc_html__( 'Navy', 'rchy' ),
				'slug'  => 'navy',
				'color' => '#00263e',
			],
			[
				'name'  => esc_html__( 'Sunset Orange', 'rchy' ),
				'slug'  => 'orange',
				'color' => '#b15533',
			],
			[
				'name'  => esc_html__( 'Royal Blue', 'rchy' ),
				'slug'  => 'blue',
				'color' => '#004b7a',
            ],
            [
				'name'  => esc_html__( 'Gold', 'rchy' ),
				'slug'  => 'yellow',
				'color' => '#f7a532',
			],
            [
				'name'  => esc_html__( 'Green', 'rchy' ),
				'slug'  => 'green',
				'color' => '#136f63',
            ],
            [
				'name'  => esc_html__( 'Dark Gray', 'rchy' ),
				'slug'  => 'gray800',
				'color' => '#3c3c3d',
            ],
            [
				'name'  => esc_html__( 'Medium Gray', 'rchy' ),
				'slug'  => 'gray400',
				'color' => '#cfc9c5',
            ],
            [
				'name'  => esc_html__( 'Beige', 'rchy' ),
				'slug'  => 'gray100',
				'color' => '#f8f4f1',
			],
		]
	);
}
add_action( 'after_setup_theme', 'rchy_add_custom_gutenberg_color_palette' );
