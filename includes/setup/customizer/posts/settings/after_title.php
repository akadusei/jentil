<?php

/**
 * Content 'after title' setting
 *
 * Add setting and control for our content 'after title'
 * setting in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Content 'after title' setting
 *
 * Add setting and control for our content 'after title'
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class After_Title extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        parent::__construct( $content );
        
        $this->mod = $this->mod( 'after_title' );

        $this->name = $this->mod->get( 'name' );
        
        $this->args['default'] = $this->mod->get( 'default' );
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = esc_html__( 'After title (comma-separated)', 'jentil' );
        $this->control['description'] = esc_html__( 'Comma-separated', 'jentil' );
        $this->control['type'] = 'text';
	}
}