<?php

/**
 * Colophon mods
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Colophon Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Colophon extends Mod {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct() {
        $this->name = 'colophon';
        $this->default = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'jentil' ), '<span itemprop="copyrightYear">{{this_year}}</span>', '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>' );
    }

    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      string          Mod
     */
    public function mod() {
        return $this->parse_placeholders( get_theme_mod( $this->name, $this->default ) );
    }

    /**
     * Parse placeholders
     *
     * Replace placeholders with actual info
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Mod with placeholders replaced
     */
    private function parse_placeholders( $mod ) {
        return str_ireplace( array(
            '{{site_name}}',
            '{{site_url}}',
            '{{this_year}}',
            '{{site_description}}',
        ), array(
            esc_attr( get_bloginfo( 'name' ) ),
            esc_attr( home_url( '/' ) ),
            esc_attr( date( 'Y', current_time( 'timestamp' ) ) ),
            esc_attr( get_bloginfo( 'description' ) ),
        ),
        $mod );
    }
}