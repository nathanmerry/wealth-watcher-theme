<?php

/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

require __DIR__ . '/OfferMapper.php';
require __DIR__ . '/Utils.php';

add_filter('intent_niche', function ($var) {
  return 'FS';
});
add_filter('intent_account_id', function ($var) {
  return 'b5f6c6e9-ad12-42cd-877c-8764c12e9991';
});
add_filter('intent_funnel_id', function ($var) {
  return 'dba07206-5053-46f6-8720-c4bb42f8dddc';
});
add_filter('intent_funnel_slug', function ($var) {
  return 'latestInvestmentOpportunity';
});
add_filter('intent_environment_is_production', function ($var) {
  return true;
});

add_action('acf/init', function () {
  acf_add_options_page([
    'page_title' => 'Funnel Settings',
    'menu_title' => 'Funnel Settings',
    'menu_slug' => 'funnel-settings',
    'capability' => 'manage_options'
  ]);

  acf_add_options_page([
    'page_title' => 'Cryptocurrencies',
    'menu_title' => 'Cryptocurrencies',
    'menu_slug' => 'cryptocurrencies',
    'capability' => 'manage_options'
  ]);
});

// Get current env
// $currentEnv = 'local';
// if (isset($_SERVER['SERVER_NAME'])) {
//     if ($_SERVER['SERVER_NAME'] === 'staging.bright-investments.com') {
//         $currentEnv = 'staging';
//     } else if ($_SERVER['SERVER_NAME'] === 'bright-investments.com' || $_SERVER['SERVER_NAME'] === 'beta.bright-investments.com') {
//         $currentEnv = 'production';
//     }
// }
$currentEnv = 'production';
define('IE_ENVIRONMENT', $currentEnv);

//define('ACF_URL', get_stylesheet_directory_uri() . '/vendor/advanced-custom-fields-pro/');
/* var_dump(ACF_URL);
die(); */
// Include ACF & Vendors
// if (!class_exists('acf')) {
//   require_once __DIR__ . '/vendor/advanced-custom-fields-pro/acf.php';
// }
/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
// $composer_autoload = __DIR__ . '/vendor/autoload.php';
// if ( file_exists( $composer_autoload ) ) {
// 	require_once $composer_autoload;
// 	$timber = new Timber\Timber();
// }

/**
 * Autoloads all PHP files in the functions/ folder.
 */
foreach (glob(__DIR__ . '/functions/*.php') as $filename) {
  include_once $filename;
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {

  add_action(
    'admin_notices',
    function () {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    }
  );

  add_filter(
    'template_include',
    function ($template) {
      return get_stylesheet_directory() . '/static/no-timber.html';
    }
  );
  return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = ['templates', 'src/views'];

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
  const fontVariants = [
    'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
    'Open Sans:400italic,700italic,400,700' => 'Open Sans',
    'Oswald:400,700' => 'Oswald',
    'Playfair Display:400,700,400italic' => 'Playfair Display',
    'Montserrat:400,700' => 'Montserrat',
    'Raleway:400,700' => 'Raleway',
    'Droid Sans:400,700' => 'Droid Sans',
    'Lato:400,700,400italic,700italic' => 'Lato',
    'Arvo:400,700,400italic,700italic' => 'Arvo',
    'Lora:400,700,400italic,700italic' => 'Lora',
    'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
    'Oxygen:400,300,700' => 'Oxygen',
    'PT Serif:400,700' => 'PT Serif',
    'PT Sans:400,700,400italic,700italic' => 'PT Sans',
    'PT Sans Narrow:400,700' => 'PT Sans Narrow',
    'Cabin:400,700,400italic' => 'Cabin',
    'Fjalla One:400' => 'Fjalla One',
    'Francois One:400' => 'Francois One',
    'Josefin Sans:400,300,600,700' => 'Josefin Sans',
    'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
    'Arimo:400,700,400italic,700italic' => 'Arimo',
    'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
    'Bitter:400,700,400italic' => 'Bitter',
    'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
    'Roboto:400,400italic,700,700italic' => 'Roboto',
    'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
    'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
    'Roboto Slab:400,700' => 'Roboto Slab',
    'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
    'Rokkitt:400' => 'Rokkitt'
  ];

  /** Add timber support. */
  public function __construct()
  {
    add_action('after_setup_theme', array($this, 'theme_supports'));
    add_filter('timber/context', array($this, 'add_to_context'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_taxonomies'));
    add_action('customize_register', [$this, 'themeTweaks']);
    add_filter('acf/settings/save_json', function () {
      return get_stylesheet_directory() . '/acf-json';
    });
    add_action('wp_enqueue_scripts', [$this, 'loadGoogleFonts']);
    add_action('wp_enqueue_scripts', [$this, 'loadBrandColors']);

    parent::__construct();
  }
  /** This is where you can register custom post types. */
  public function register_post_types()
  {
  }
  /** This is where you can register custom taxonomies. */
  public function register_taxonomies()
  {
  }

  /** This is where you add some context
   *
   * @param array $context context['this'] Being the Twig's {{ this }}.
   */
  public function add_to_context(array $context): array
  {
    $context['header_menu']  = new Timber\Menu('header_menu');
    $context['footer_menu']  = new Timber\Menu('footer_menu');

    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

    if (has_custom_logo()) {
      $context['logo'] = esc_url($logo[0]);
    }

    $context['footer_logo'] = esc_url(get_theme_mod('footer_logo'));
    $context['footer_text'] = esc_html(get_theme_mod('theme_footer_text'));

    $context['site']  = $this;
    return $context;
  }

  public function theme_supports()
  {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
    add_theme_support('title-tag');

    /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
    add_theme_support('post-thumbnails');

    /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
    add_theme_support(
      'html5',
      array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      )
    );

    /*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
    add_theme_support(
      'post-formats',
      [
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio'
      ]
    );

    add_theme_support('menus');

    register_nav_menus([
      'header_menu' => 'Header Menu',
      'footer_menu' => 'Footer Menu'
    ]);

    $defaults = [
      'height'               => 100,
      'width'                => 400,
      'flex-height'          => true,
      'flex-width'           => true,
      'header-text'          => ['site-title', 'site-description'],
      'unlink-homepage-logo' => true
    ];

    add_theme_support('custom-logo', $defaults);
  }

  public function themeTweaks($wp_customize)
  {
    // Add Theme Primary Color setting
    $wp_customize->add_setting('theme_primary_color', ['default' => '#04bfbf']);

    // Add Theme Secondary Color setting
    $wp_customize->add_setting('theme_secondary_color', ['default' => '#04bfbf']);

    $wp_customize->add_setting('footer_logo');

    // Add Fonts setting section
    $wp_customize->add_section('fonts_section', [
      'title' => 'Fonts',
      'priority' => 24
    ]);

    $wp_customize->add_section('logo_section', [
      'title'      => 'Logotype',
      'priority'   => 30
    ]);

    $wp_customize->add_section('footer_section', [
      'title'      => 'Footer',
      'priority'   => 31
    ]);

    // Add font for headings setting
    $wp_customize->add_setting('theme_headings_font', [
      'sanitize_callback' => function ($input) {
        if (array_key_exists($input, self::fontVariants)) {
          return $input;
        } else {
          return '';
        }
      }
    ]);

    // Add font for headings setting
    $wp_customize->add_setting('theme_body_font', [
      'sanitize_callback' => function ($input) {
        if (array_key_exists($input, self::fontVariants)) {
          return $input;
        } else {
          return '';
        }
      }
    ]);

    // Add Footer Textarea setting
    $wp_customize->add_setting('theme_footer_text', [
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_textarea_field'
    ]);

    // Add Footer background color setting
    $wp_customize->add_setting('theme_footer_bg_color', ['default' => '#21252c']);

    // Add Footer text color setting
    $wp_customize->add_setting('theme_footer_text_color', ['default' => '#ffffff']);

    // Add Controls
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_primary_color', [
      'label' => 'Theme Primary Color',
      'section' => 'colors',
      'settings' => 'theme_primary_color'
    ]));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_secondary_color', [
      'label' => 'Theme Secondary Color',
      'section' => 'colors',
      'settings' => 'theme_secondary_color'
    ]));

    $wp_customize->add_control('theme_headings_font', [
      'type' => 'select',
      'description' => 'Select your desired font for the headings.',
      'section' => 'fonts_section',
      'choices' => self::fontVariants
    ]);

    $wp_customize->add_control('theme_body_font', [
      'type' => 'select',
      'description' => 'Select your desired font for the body.',
      'section' => 'fonts_section',
      'choices' => self::fontVariants
    ]);

    $wp_customize->add_control(
      new WP_Customize_Image_Control($wp_customize, 'footer_logo', [
        'label'      => 'Upload a logo for website footer',
        'section'    => 'logo_section',
        'settings'   => 'footer_logo'
      ])
    );

    $wp_customize->add_control('theme_footer_text', [
      'type' => 'textarea',
      'section' => 'footer_section',
      'label' => 'Footer Text',
      'description' => 'This text appears in the footer before the disclaimer.'
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_footer_bg_color', [
      'label' => 'Background Color',
      'section' => 'footer_section',
      'settings' => 'theme_footer_bg_color'
    ]));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_footer_text_color', [
      'label' => 'Text Color',
      'section' => 'footer_section',
      'settings' => 'theme_footer_text_color'
    ]));
  }

  public function loadGoogleFonts()
  {
    // $headings_font = esc_html(get_theme_mod('theme_headings_font'));
    // $body_font = esc_html(get_theme_mod('theme_body_font'));
    // $custom_css = '';

    // if (!$headings_font) {
    $headings_font = 'Poppins:200,300,400,500,600,700';
    //}

    // $font_pieces = explode(":", $headings_font);
    // $font_pieces[0] = '"' . str_replace('+', ' ', $font_pieces[0]) . '"';
    // //$custom_css .= "h1, h2, h3, h4, h5, h6 { font-family: {$font_pieces[0]}; }"."\n";
    // $custom_css .= ":root { --font-heading: {$font_pieces[0]}; }\n";

    // if (!$body_font) {
    $body_font = 'Poppins:200,300,400,500,600,700';
    //}

    $font_pieces = explode(":", $body_font);
    $font_pieces[0] = '"' . str_replace('+', ' ', $font_pieces[0]) . '"';
    //$custom_css .= "body, button, input, select, textarea, a, span, p, div { font-family: {$font_pieces[0]}; }"."\n";
    // $custom_css .= ":root { --font-body: {$font_pieces[0]}; }\n";

    //Output all the styles
    wp_enqueue_style('theme-headings-font', 'https://fonts.googleapis.com/css?family=' . $headings_font);
    wp_enqueue_style('theme-body-font', 'https://fonts.googleapis.com/css?family=' . $body_font);
    // Font Awesome
    wp_enqueue_style('theme-awesome-font', 'https://pro.fontawesome.com/releases/v5.15.1/css/all.css');

    wp_register_style('theme-fonts-custom-css', false);
    wp_enqueue_style('theme-fonts-custom-css');

    // wp_add_inline_style('theme-fonts-custom-css', $custom_css);
  }

  public function loadBrandColors()
  {
    $primaryColor = esc_html(get_theme_mod('theme_primary_color'));
    $secondaryColor = esc_html(get_theme_mod('theme_secondary_color'));
    $footerBgColor = esc_html(get_theme_mod('theme_footer_bg_color'));
    $footerTextColor = esc_html(get_theme_mod('theme_footer_text_color'));

    $customCss = '';
    if ($primaryColor) {
      $customCss .= ":root { --primary-color: {$primaryColor} }";
      $darkenPrimaryColor = $this->adjustColorBrightness($primaryColor, 10);
      $customCss .= ":root { --primary-color-darken: {$darkenPrimaryColor} }";
    }

    if ($secondaryColor) {
      $customCss .= ":root { --secondary-color: {$secondaryColor} }";
    }

    if ($footerBgColor) {
      $customCss .= "body .footer { background-color: {$footerBgColor}; }\n";
    }

    if ($footerTextColor) {
      $customCss .= "body .footer { color: {$footerTextColor}; }\n";
    }

    if ($customCss) {
      wp_register_style('theme-colors-custom-css', false);
      wp_enqueue_style('theme-colors-custom-css');

      wp_add_inline_style('theme-colors-custom-css', $customCss);
    }
  }

  public function adjustColorBrightness($hex, $steps): string
  {
    $steps = max(-255, min(255, $steps));

    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
      $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
      $color = hexdec($color);
      $color = max(0, min(255, $color + $steps));
      $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
    }

    return $return;
  }
}

function dump($arr)
{
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
}

// new OfferMapper();
new StarterSite();

$_SERVER['HTTP_CF_IPCOUNTRY'] = 'GB';

add_shortcode('content', 'youtube_shortcode');

