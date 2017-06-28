<?php

/**
 * Thumbnails (Featured Images)
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Thumbnails (Featured Images)
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Thumbnails extends MagPack\Utilities\Wizard {
    /**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Enable
     * 
     * Add support for featured images (post thumbnails).
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        add_theme_support( 'post-thumbnails' );
    }
    
    /**
     * Image sizes
     * 
     * Add/set sizes of featured images.
     * 
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function sizes() {
        set_post_thumbnail_size( 640, 360, true );
        
        add_image_size( 'mini-thumb', 100, 100, true );
        add_image_size( 'micro-thumb', 75, 75, true );
        add_image_size( 'nano-thumb', 50, 50, true );
    }
}