<?php

/**
 * Jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Jentil
 *
 * This hooks methods into actions and filters
 * that enables standard theme functionality.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
final class Jentil extends MagPack\Utilities\Singleton {
    /**
     * Theme directory path
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         string         $dir_path       Theme directory path
     */
    protected $dir_path;

    /**
     * Theme directory URI
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         string         $dir_url       Theme directory URI
     */
    protected $dir_url;

    /**
     * Theme parts
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         array         $parts       Theme parts
     */
    protected $parts;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct() {
    	$this->dir_url = get_template_directory_uri();
    	$this->dir_path = get_template_directory();

    	$this->parts = $this->parts();
    }

    /**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       Jentil 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array( 'dir_url', 'dir_path', 'parts' );
    }

    /**
     * Theme parts
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return 		array       Theme parts
     */
    private function parts() {
    	$parts = array();

    	$parts['language'] = new Language( $this );
    	$parts['styles'] = new Styles( $this );
    	$parts['thumbnails'] = new Thumbnails( $this );
    	$parts['feeds'] = new Feeds( $this );
    	$parts['html5'] = new HTML5( $this );
    	$parts['title_tag'] = new Title_Tag( $this );
    	$parts['layout'] = new Layout( $this );
    	$parts['logo'] = new Logo( $this );
    	$parts['archives'] = new Archives( $this );
    	$parts['search'] = new Search( $this );
    	$parts['menus'] = new Menus( $this );
    	$parts['breadcrumbs'] = new Breadcrumbs( $this );
    	$parts['posts'] = new Posts( $this );
    	$parts['comments'] = new Comments( $this );
    	$parts['widgets'] = new Widgets( $this );
    	$parts['colophon'] = new Colophon( $this );
    	$parts['customizer'] = new Customizer\Customizer( $this );
    	$parts['metaboxes'] = new Metaboxes( $this );
    	$parts['updater'] = new Updater( $this );

    	return $parts;
    }

    /**
     * Run the theme
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function run() {
		$this->language();
		$this->styles();
		$this->thumbnails();
		$this->feeds();
		$this->HTML5();
		$this->title_tag();
		$this->layout();
		$this->logo();
		$this->menus();
		$this->breadcrumbs();
		$this->archives();
		$this->search();
		$this->posts();
		$this->comments();
		$this->widgets();
		$this->colophon();
		$this->customizer();
		$this->metaboxes();
		$this->updater();
	}

	/**
     * Language
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function language() {
		add_action( 'after_setup_theme', array( $this->parts['language'], 'load_textdomain' ) );
	}

    /**
     * Comments
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function comments() {
		add_action( 'wp_enqueue_scripts', array( $this->parts['comments'], 'js' ) );
	}

	/**
     * Stylesheets
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function styles() {
		add_action( 'wp_enqueue_scripts', array( $this->parts['styles'], 'enqueue' ) );
	}

	/**
     * Thumbnails
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function thumbnails() {
		add_action( 'after_setup_theme', array( $this->parts['thumbnails'], 'enable' ) );
		add_action( 'after_setup_theme', array( $this->parts['thumbnails'], 'sizes' ) );
	}

	/**
     * Feeds (Atom, RSS etc)
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function feeds() {
		add_action( 'after_setup_theme', array( $this->parts['feeds'], 'enable' ) );
	}

	/**
     * HTML5
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function HTML5() {
		add_action( 'after_setup_theme', array( $this->parts['html5'], 'enable' ) );
		add_filter( 'language_attributes', array( $this->parts['html5'], 'html_tag_schema' ) );
		add_filter( 'wp_kses_allowed_html', array( $this->parts['html5'], 'kses_allow' ), 10, 2 );
	}

	/**
     * Title tag
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function title_tag() {
		add_action( 'after_setup_theme', array( $this->parts['title_tag'], 'enable' ) );
		add_action( 'wp_head', array( $this->parts['title_tag'], 'render' ) );
	}

	/**
     * Layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function layout() {
		add_filter( 'body_class', array( $this->parts['layout'], 'body_class' ) );
	}

	/**
     * Logo
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function logo() {
		add_action( 'after_setup_theme', array( $this->parts['logo'], 'enable' ) );
		add_action( 'jentil_inside_header', array( $this->parts['logo'], 'render' ) );
	}

	/**
     * Archives
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function archives() {
		add_action( 'jentil_before_content', array( $this->parts['archives'], 'description' ) );
	}

	/**
     * Search
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function search() {
		add_action( 'get_search_form', array( $this->parts['search'], 'form' ) );
		add_action( 'jentil_inside_header', array( $this->parts['search'], 'render' ) );
		add_action( 'jentil_before_content', array( $this->parts['search'], 'search_page_form' ) );
	}

	/**
     * Menus
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function menus() {
		add_action( 'after_setup_theme', array( $this->parts['menus'], 'register' ) );
		add_action( 'jentil_inside_header', array( $this->parts['menus'], 'header_menu' ) );
		add_action( 'jentil_inside_header', array( $this->parts['menus'], 'mobile_header_menu_toggle' ) );
		add_action( 'jentil_inside_header', array( $this->parts['menus'], 'mobile_header_menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this->parts['menus'], 'js' ) );
	}

	/**
     * Breadcrumbs
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function breadcrumbs() {
		add_action( 'jentil_before_before_title', array( $this->parts['breadcrumbs'], 'render' ) );
	}

	/**
     * Posts
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function posts() {
		add_filter( 'body_class', array( $this->parts['posts'], 'body_class' ) );
		// add_action( 'jentil_before_before_title', array( $this->parts['posts'], 'post_parent_link' ) );
		add_action( 'jentil_before_content', array( $this->parts['posts'], 'attachment' ) );
		// add_filter( 'jentil_singular_after_title', array( $this->parts['posts'], 'single_post_after_title_' ), 10, 3 );
		add_action( 'jentil_after_title', array( $this->parts['posts'], 'single_post_after_title' ) );
	}

	/**
     * Widgets
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function widgets() {
		add_action( 'widgets_init', array( $this->parts['widgets'], 'register' ) );
		add_action( 'jentil_inside_footer', array( $this->parts['widgets'], 'footer_widgets' ) );
	}

	/**
     * Colophon
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function colophon() {
		add_action( 'jentil_inside_footer', array( $this->parts['colophon'], 'render' ) );
	}

	/**
     * Customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function customizer() {
		add_action( 'customize_register', array( $this->parts['customizer'], 'add' ) );
		add_action( 'customize_preview_init', array( $this->parts['customizer'], 'js' ) );
		add_action( 'after_setup_theme', array( $this->parts['customizer'], 'selective_refresh' ) );
	}
	
	/**
     * Metaboxes
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function metaboxes() {
		add_action( 'load-post.php', array( $this->parts['metaboxes'], 'setup' ) );
		add_action( 'load-post-new.php', array( $this->parts['metaboxes'], 'setup' ) );
	}

	/**
     * Update theme
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function updater() {
		add_action( 'after_setup_theme', array( $this->parts['updater'], 'check' ) );
	}
}