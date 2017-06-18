<?php

/**
 * Feeds (Atom, RSS etc)
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Feeds (Atom, RSS etc)
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Feeds extends MagPack\Utilities\Singleton {
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
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Add support for RSS and atom feeds
     * 
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        add_theme_support( 'automatic-feed-links' );
    }
}